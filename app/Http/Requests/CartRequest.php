<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Models\ProductSku;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CartRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->routeIs('carts.store')) {
            return [
                'sku_id' => [
                    'bail',
                    // 'required_without:product_id,product_sku_attr_values',
                    'required_with:number',
                    'integer',
                    'exists:product_skus,id',
                    function ($attribute, $value, $fail) {
                        $sku = ProductSku::find($value);
                        if ($sku->product->on_sale == 0) {
                            $fail(trans('basic.orders.Product_sku_off_sale'));
                        }
                        /*if ($sku->stock == 0) {
                            $fail(trans('basic.orders.Product_sku_out_of_stock'));
                        }*/
                        /*if ($sku->stock < $this->input('number')) {
                            $fail(trans('basic.orders.Insufficient_sku_stock'));
                        }*/
                    },
                ],
                'number' => [
                    // 'bail',
                    'required',
                    'required_with:sku_id',
                    'integer',
                    'min:1',
                    /*function ($attribute, $value, $fail) {
                        $sku = ProductSku::find($this->input('sku_id'));
                        if ($sku->stock < $value) {
                            $fail(trans('basic.orders.Insufficient_sku_stock'));
                        }
                    },*/
                ],
            ];
        } elseif ($this->routeIs('carts.store_by_sku_attr')) {
            return [
                'product_id' => [
                    'required_with:product_sku_attr_values,number',
                    'integer',
                    //'exists:products,id',
                    Rule::exists('products', 'id')->where(function ($query) {
                        return $query->where('on_sale', 1);
                    }),
                    // Rule::unique('user_favourites')->where('user_id', $user->id),
                    /*Rule::unique('user_favourites')->where(function ($query) use ($user) {
                        return $query->where('user_id', $user->id);
                    }),*/
                ],
                'product_sku_attr_values' => 'required_with:product_id,number|array',
                'product_sku_attr_values.*' => 'required_with:product_id,number|string',
                'number' => [
                    // 'bail',
                    'required',
                    'required_with:product_id,product_sku_attr_values',
                    'integer',
                    'min:1',
                    /*function ($attribute, $value, $fail) {
                        $sku = ProductSku::find($this->input('sku_id'));
                        if ($sku->stock < $value) {
                            $fail(trans('basic.orders.Insufficient_sku_stock'));
                        }
                    },*/
                ],
            ];
        } elseif ($this->routeIs('carts.update')) {
            return [
                'sku_id' => [
                    'bail',
                    'required',
                    'required_with:number',
                    'integer',
                    'exists:product_skus,id',
                    function ($attribute, $value, $fail) {
                        $sku = ProductSku::find($value);
                        if ($sku->product->on_sale == 0) {
                            $fail(trans('basic.orders.Product_sku_off_sale'));
                        }
                        /*if ($sku->stock == 0) {
                            $fail(trans('basic.orders.Product_sku_out_of_stock'));
                        }*/
                        /*if ($sku->stock < $this->input('number')) {
                            $fail(trans('basic.orders.Insufficient_sku_stock'));
                        }*/
                    },
                ],
                'number' => [
                    'bail',
                    'required',
                    'required_with:sku_id',
                    'integer',
                    'min:1',
                    /*function ($attribute, $value, $fail) {
                        $sku = ProductSku::find($this->input('sku_id'));
                        if ($sku->stock < $value) {
                            $fail(trans('basic.orders.Insufficient_sku_stock'));
                        }
                    },*/
                ],
            ];
        } elseif ($this->routeIs('carts.destroy')) {
            return [
                'sku_id' => [
                    'required',
                    'integer',
                ],
            ];
        } else {
            throw new NotFoundHttpException();
        }
    }

    /**
     * Get custom attributes for validator errors.
     * @return array
     */
    public function attributes()
    {
        if (!App::isLocale('zh-CN')) {
            return [];
        }
        return [
            'sku_id' => '商品SKU-ID',
            'product_id' => '商品ID',
            'product_sku_attr_values' => '商品SKU参数组合',
            'number' => '商品购买数量',
        ];
    }

    /**
     * Get custom messages for validator errors.
     * @return array
     */
    public function messages()
    {
        return [
            'sku_id.exists' => trans('basic.orders.Product_sku_does_not_exist'),
        ];
    }
}
