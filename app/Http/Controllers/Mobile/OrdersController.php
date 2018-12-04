<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostOrderCommentRequest;
use App\Http\Requests\PutOrderCommentRequest;
use App\Http\Requests\PostOrderRequest;
use App\Http\Requests\RefundOrderRequest;
use App\Http\Requests\RefundOrderWithShipmentRequest;
use App\Jobs\AutoCloseOrderJob;
use App\Jobs\AutoCompleteOrderJob;
use App\Models\Cart;
use App\Models\Config;
use App\Models\ExchangeRate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderRefund;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\ProductSku;
use App\Models\ShipmentCompany;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    // GET 订单列表页面
    public function index(Request $request)
    {
        return view('mobile.orders.index');
    }

    public function more(Request $request)
    {
        $user = Auth::user();
        $status = $request->has('status') ? $request->input('status') : 'all';
        $builder = $user->orders();

        switch ($status) {
            // 待付款订单
            case Order::ORDER_STATUS_PAYING:
                $builder->where('status', Order::ORDER_STATUS_PAYING)
                    ->orderByDesc('created_at');
                break;
            // 待发货订单
            case Order::ORDER_STATUS_SHIPPING:
                $builder = $builder->where('status', Order::ORDER_STATUS_SHIPPING)
                    ->orderByDesc('paid_at')
                    ->simplePaginate(5);
                break;
            // 待收货订单
            case Order::ORDER_STATUS_RECEIVING:
                $builder->where('status', Order::ORDER_STATUS_RECEIVING)
                    ->orderByDesc('shipped_at');
                break;
            // 待评价订单
            case Order::ORDER_STATUS_UNCOMMENTED:
                $builder->where(['status' => Order::ORDER_STATUS_COMPLETED, 'commented_at' => null])
                    ->orderByDesc('completed_at');
                break;
            // 售后订单
            case Order::ORDER_STATUS_REFUNDING:
                $builder->where('status', Order::ORDER_STATUS_REFUNDING)
                    ->orderByDesc('updated_at');
                break;
            // 已完成订单
            case Order::ORDER_STATUS_COMPLETED:
                $builder->where('status', Order::ORDER_STATUS_COMPLETED)
                    ->orderByDesc('completed_at');
                break;
            // 默认：all 全部订单
            default:
                $builder->orderByDesc('updated_at');
                break;
        }

        $orders = $builder->simplePaginate(5);

        // return $orders;
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => [
                'orders' => $orders,
            ],
        ]);
    }

    // GET 订单详情页面
    public function show(Request $request, Order $order)
    {
        $this->authorize('view', $order);

        // 订单物流状态
        $shipment_company_name = $order->shipment_company;
        $order_shipment_traces = [];
        if ($order->shipment_company != null && $order->shipment_company != 'etc' && $order->shipment_sn != null) {
            $shipment_companies = ShipmentCompany::shipmentCompanies()->pluck('name', 'code');
            if (isset($shipment_companies[$order->shipment_company])) {
                $shipment_company_name = $shipment_companies[$order->shipment_company];
                // 快递鸟(kdniao.com) 即时查询API
                $order_shipment_traces = kdniao_shipment_query($order->shipment_company, $order->shipment_sn);
            }
        }

        $order_refund_type = OrderRefund::ORDER_REFUND_TYPE_REFUND;
        if ($order->status == Order::ORDER_STATUS_REFUNDING) {
            $order_refund_type = $order->refund->type;
        }

        $seconds_to_close_order = 0;
        $seconds_to_complete_order = 0;
        if ($order->status == Order::ORDER_STATUS_PAYING) {
            $seconds_to_close_order = strtotime($order->created_at) + Order::getSecondsToCloseOrder() - time();
            if ($seconds_to_close_order < 0) {
                $seconds_to_close_order = 0;
            }
        }
        if ($order->status == Order::ORDER_STATUS_RECEIVING) {
            $seconds_to_complete_order = strtotime($order->shipped_at) + Order::getSecondsToCompleteOrder() - time();
            if ($seconds_to_complete_order < 0) {
                $seconds_to_complete_order = 0;
            }
        }

        return view('mobile.orders.show', [
            'order' => $order,
            'shipment_sn' => $order->shipment_sn,
            'shipment_company' => $shipment_company_name,
            'order_shipment_traces' => $order_shipment_traces,
            'order_refund_type' => $order_refund_type,
            'seconds_to_close_order' => $seconds_to_close_order,
            'seconds_to_complete_order' => $seconds_to_complete_order,
        ]);
    }

    // GET 选择地址+币种页面
    public function prePayment(PostOrderRequest $request)
    {
        $total_amount = 0;
        $total_amount_en = 0;
        $total_shipping_fee = 0;
        $total_shipping_fee_en = 0;
        $items = [];
        if ($request->has('sku_id') && $request->has('number')) {
            $sku = ProductSku::find($request->query('sku_id'));
            $sku->price_en = ExchangeRate::exchangePrice($sku->price, 'USD');
            $product = $sku->product;
            $product->shipping_fee_en = ExchangeRate::exchangePrice($product->shipping_fee, 'USD');
            $number = $request->query('number');
            $items[0]['sku'] = $sku;
            $items[0]['product'] = $product;
            $items[0]['number'] = $number;
            $items[0]['amount'] = bcmul($sku->price, $number, 2);
            $items[0]['amount_en'] = bcmul($sku->price_en, $number, 2);
            $items[0]['shipping_fee'] = bcmul($product->shipping_fee, $number, 2);
            $items[0]['shipping_fee_en'] = bcmul($product->shipping_fee_en, $number, 2);
            $total_amount = bcmul($sku->price, $number, 2);
            $total_amount_en = bcmul($sku->price_en, $number, 2);
            $total_shipping_fee = bcmul($product->shipping_fee, $number, 2);
            $total_shipping_fee_en = bcmul($product->shipping_fee_en, $number, 2);
        } elseif ($request->has('cart_ids')) {
            $cart_ids = explode(',', $request->query('cart_ids'));
            foreach ($cart_ids as $key => $cart_id) {
                $cart = Cart::find($cart_id);
                $number = $cart->number;
                $sku = $cart->sku;
                $sku->price_en = ExchangeRate::exchangePrice($sku->price, 'USD');
                $product = $sku->product;
                $product->shipping_fee_en = ExchangeRate::exchangePrice($product->shipping_fee, 'USD');
                $items[$key]['sku'] = $sku;
                $items[$key]['product'] = $product;
                $items[$key]['number'] = $number;
                $items[$key]['amount'] = bcmul($sku->price, $number, 2);
                $items[$key]['amount_en'] = bcmul($sku->price_en, $number, 2);
                $items[$key]['shipping_fee'] = bcmul($product->shipping_fee, $number, 2);
                $items[$key]['shipping_fee_en'] = bcmul($product->shipping_fee_en, $number, 2);
                $total_amount += bcmul($sku->price, $number, 2);
                $total_amount_en += bcmul($sku->price_en, $number, 2);
                $total_shipping_fee += bcmul($product->shipping_fee, $number, 2);
                $total_shipping_fee_en += bcmul($product->shipping_fee_en, $number, 2);
            }
        }
        $total_fee = bcadd($total_amount, $total_shipping_fee, 2);
        $total_fee_en = bcadd($total_amount_en, $total_shipping_fee_en, 2);

        $address = false;
        $userAddress = UserAddress::where('user_id', $request->user()->id);
        if ($userAddress->where('is_default', 1)->exists()) {
            // 默认地址
            $address = $userAddress->where('is_default', 1)
                ->first();
        } elseif ($userAddress->exists()) {
            // 上次使用地址
            $address = $userAddress->latest('last_used_at')
                ->latest('updated_at')
                ->latest()
                ->first();
        }

        return view('mobile.orders.pre_payment', [
            'items' => $items,
            'address' => $address,
            'total_amount' => $total_amount,
            'total_amount_en' => $total_amount_en,
            'total_shipping_fee' => $total_shipping_fee,
            'total_shipping_fee_en' => $total_shipping_fee_en,
            'total_fee' => $total_fee,
            'total_fee_en' => $total_fee_en,
        ]);
    }

    // GET 选择支付方式页面
    public function paymentMethod(Request $request, Order $order)
    {
        $this->authorize('pay', $order);

        return view('mobile.orders.payment_method', [
            'order' => $order,
        ]);
    }


    // GET 物流详情 页面
    public function showShipment(Request $request, Order $order)
    {
        $this->authorize('view', $order);

        // 订单物流状态
        $shipment_company_name = $order->shipment_company;
        $order_shipment_traces = [];
        if ($order->shipment_company != null && $order->shipment_company != 'etc' && $order->shipment_sn != null) {
            $shipment_companies = ShipmentCompany::shipmentCompanies()->pluck('name', 'code');
            if (isset($shipment_companies[$order->shipment_company])) {
                $shipment_company_name = $shipment_companies[$order->shipment_company];
                // 快递鸟(kdniao.com) 即时查询API
                $order_shipment_traces = kdniao_shipment_query($order->shipment_company, $order->shipment_sn);
            }
        }

        return view('mobile.orders.show_shipment', [
            'order' => $order,
            'shipment_sn' => $order->shipment_sn,
            'shipment_company' => $shipment_company_name,
            'order_shipment_traces' => $order_shipment_traces,
        ]);
    }

    // GET 创建订单评价
    public function createComment(Request $request, Order $order)
    {
        $this->authorize('store_comment', $order);

        return view('mobile.orders.create_comment', [
            'order' => $order,
            // 'order_items' => $order->items()->with('sku.product')->get(),
        ]);
    }

    // POST 发布订单评价 [每款产品都必须发布评价 + 评分]
    public function storeComment(PostOrderCommentRequest $request, Order $order)
    {
        $this->authorize('store_comment', $order);

        if ($request->input('order_id') != $order->id) {
            return redirect()->back()->withInput();
        }

        $order_items = $order->items()->with('sku.product')->get()->groupBy('id');

        foreach ($order_items as $order_item_id => $order_item) {
            ProductComment::create([
                'parent_id' => 0,
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'order_item_id' => $order_item_id,
                'product_id' => $order_item[0]->sku->product->id,
                'composite_index' => $request->input('composite_index')[$order_item_id],
                'description_index' => $request->input('description_index')[$order_item_id],
                'shipment_index' => $request->input('shipment_index')[$order_item_id],
                'content' => $request->input('content')[$order_item_id],
                'photos' => $request->input('photos')[$order_item_id],
            ]);
        }

        $order->commented_at = Carbon::now()->toDateTimeString();
        $order->save();

        /*return response()->json([
            'code' => 200,
            'message' => 'success',
        ]);*/
        return redirect()->route('mobile.orders.show_comment', [
            'order' => $order->id,
        ]);
    }

    // GET 查看订单评价
    public function showComment(Request $request, Order $order)
    {
        $this->authorize('show_comment', $order);

        if ($order->comments->isEmpty()) {
            return redirect()->route('mobile.orders.create_comment', [
                'order' => $order->id,
            ]);
        }

        return view('mobile.orders.show_comment', [
            'user' => $request->user(),
            'order' => $order,
            // 'order_items' => $order->items()->with('sku.product')->get(),
            'comments' => $order->comments->groupBy('order_item_id'),
        ]);
    }

    /*--售后订单--*/
    // GET 退单申请页面 [仅退款]
    public function refund(Request $request, Order $order)
    {
        $this->authorize('refund', $order);

        return view('mobile.orders.refund', [
            'order' => $order,
            'refund' => $order->refund,
            'snapshot' => $order->snapshot,
        ]);
    }


    // GET 退单申请页面 [退货并退款]
    public function refundWithShipment(Request $request, Order $order)
    {
        $this->authorize('refund_with_shipment', $order);

        $shipment_company_name = $order->shipment_company;
        if ($order->shipment_company != null && $order->shipment_sn != null) {
            $shipment_companies = ShipmentCompany::shipmentCompanies()->pluck('name', 'code');
            if (isset($shipment_companies[$order->shipment_company])) {
                $shipment_company_name = $shipment_companies[$order->shipment_company];
            }
        }

        return view('mobile.orders.refund_with_shipment', [
            'order' => $order,
            'refund' => $order->refund,
            'snapshot' => $order->snapshot,
            'shipment_company' => $shipment_company_name,
        ]);
    }
}
