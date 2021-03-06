@extends('layouts.mobile')
@section('title', (App::isLocale('zh-CN') ? '申请退款' : 'Request A Refund') . ' - ' . \App\Models\Config::config('title'))
@section('content')
    <div class="headerBar fixHeader">
        @if(!is_wechat_browser())
            <img src="{{ asset('static_m/img/icon_backtop.png') }}" class="backImg"
                 onclick="javascript:history.back(-1);"/>
            <span>@lang('order.Refund request')</span>
        @endif
    </div>
    <div class="refund">
        <div class="refund_con">
            <div class="refund_content">
                <!--售后状态-->
                <div class="after_sales_status">
                    @if(! $refund)
                            <!--第一步-->
                    <div class="aftersales_status_item">
                        <img src="{{ asset('static_m/img/refund_1.png') }}">
                        <p><span class="status_title">@lang('order.Seller applies for refunds only')</span></p>
                    </div>
                    @elseif(isset($refund) && $refund->status == \App\Models\OrderRefund::ORDER_REFUND_STATUS_CHECKING)
                            <!--第2步-->
                    <div class="aftersales_status_item">
                        <img src="{{ asset('static_m/img/refund_2.png') }}">
                        <p><span class="status_title">@lang('order.Seller handles refund Request')</span></p>
                    </div>
                    @elseif(isset($refund) && $refund->status == \App\Models\OrderRefund::ORDER_REFUND_STATUS_REFUNDED)
                            <!--第3步-->
                    <div class="aftersales_status_item">
                        <img src="{{ asset('static_m/img/refund_3.png') }}">
                        <p>
                            <span class="status_title">@lang('order.Request for refund terminated')</span>
                            <span>
                                @lang('order.Refund successfully'),
                                {{--{{ ($order->currency == 'USD') ? '&#36;' : '&#165;' }} {{ bcadd($order->total_amount, $order->total_shipping_fee, 2) }}--}}
                                {{ get_symbol_by_currency($order->currency) }} {{ bcadd($order->total_amount, $order->total_shipping_fee, 2) }}
                                @lang('order.has been refunded by the previous payment method').
                            </span>
                        </p>
                    </div>
                    @elseif(isset($refund) && $refund->status == \App\Models\OrderRefund::ORDER_REFUND_STATUS_DECLINED)
                            <!--第4步-->
                    <div class="aftersales_status_item">
                        <img src="{{ asset('static_m/img/refund_4.png') }}">
                        <p>
                            <span class="status_title">@lang('order.Refund failed')</span>
                            <span>@lang('order.You can contact online with our customer service agent')</span>
                        </p>
                    </div>
                    @endif
                </div>
                <!--申请内容-->
                <div class="refund_info">
                    @if(! $refund)
                            <!--第一步-->
                    <form method="POST" enctype="multipart/form-data" id="step-1-form"
                          action="{{ route('orders.store_refund', ['order' => $order->id]) }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <p>
                            <span>@lang('order.Refund amount')</span>
                            <input name="amount" type="text" class="refund_price" readonly
                                   {{--value="{{ ($order->currency == 'USD') ? '&#36;' : '&#165;' }} {{ bcadd($order->total_amount, $order->total_shipping_fee, 2) }}">--}}
                                   value="{{ get_symbol_by_currency($order->currency) }} {{ bcadd($order->total_amount, $order->total_shipping_fee, 2) }}">
                        </p>
                        <div class="refund_info_item">
                            <span>@lang('order.Application description')</span>
                            <select class="choose_remark" name="">
                                <option value="default" selected="selected" disabled="disabled">
                                    @lang('order.Please select the refund reason')
                                </option>
                                @if($refund_reasons = \App\Models\RefundReason::refundReasons())
                                    @foreach($refund_reasons as $refund_reason)
                                        <option value="{{ \Illuminate\Support\Facades\App::isLocale('zh-CN') ? $refund_reason->reason_zh : $refund_reason->reason_en }}">
                                            {{ \Illuminate\Support\Facades\App::isLocale('zh-CN') ? $refund_reason->reason_zh : $refund_reason->reason_en }}
                                        </option>
                                    @endforeach
                                @endif
                                <option value="etc">@lang('order.Etc')</option>
                            </select>
                        </div>
                        <div class="refund_info_item other_reason dis_ni">
                            <textarea name="remark_from_user" maxlength="200"
                                      placeholder="@lang('order.Please fill in the reason for the refund')">{{ old('remark_from_user') }}</textarea>
                        </div>
                    </form>
                    @elseif(isset($refund) && $refund->status == \App\Models\OrderRefund::ORDER_REFUND_STATUS_CHECKING)
                            <!--第二步-->
                    <form method="POST" enctype="multipart/form-data" id="step-2-form"
                          action="{{ route('orders.update_refund', ['order' => $order->id]) }}">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <p>
                            <span>@lang('order.Refund amount')</span>
                            <input name="amount" type="text" class="refund_price" readonly
                                   {{--value="{{ ($order->currency == 'USD') ? '&#36;' : '&#165;' }} {{ bcadd($order->total_amount, $order->total_shipping_fee, 2) }}">--}}
                                   value="{{ get_symbol_by_currency($order->currency) }} {{ bcadd($order->total_amount, $order->total_shipping_fee, 2) }}">
                        </p>
                        <div class="refund_info_item">
                            <span>@lang('order.Application description')</span>
                            <!--需要跟据第一步用户的选择判断显示的内容，如选择的其他请按照格式显示并显示下方的文本域-->
                            <select class="choose_remark" name="">
                                <option value="default" selected="selected" disabled="disabled">
                                    @lang('order.Please select the refund reason')
                                </option>
                                @if($refund_reasons = \App\Models\RefundReason::refundReasons())
                                    @foreach($refund_reasons as $refund_reason)
                                        <option value="{{ \Illuminate\Support\Facades\App::isLocale('zh-CN') ? $refund_reason->reason_zh : $refund_reason->reason_en }}">
                                            {{ \Illuminate\Support\Facades\App::isLocale('zh-CN') ? $refund_reason->reason_zh : $refund_reason->reason_en }}
                                        </option>
                                    @endforeach
                                @endif
                                <option value="etc">@lang('order.Etc')</option>
                            </select>
                        </div>
                        <!--同样需要判断是否需要显示手写理由，如没有则不需要展示 判断是上面的下拉菜单是否选择了其他-->
                        <div class="refund_info_item other_reason dis_ni">
                            <textarea name="remark_from_user" class="step2_textarea" maxlength="200"
                                      readonly>{{ $order->refund->remark_from_user }}</textarea>
                        </div>
                    </form>
                    @else
                            <!--第三步第四步都是这个-->
                    <p>
                        <span>@lang('order.Refund amount')</span>
                        <input name="amount" type="text" class="refund_price" readonly
                               {{--value="{{ ($order->currency == 'USD') ? '&#36;' : '&#165;' }} {{ bcadd($order->total_amount, $order->total_shipping_fee, 2) }}">--}}
                               value="{{ get_symbol_by_currency($order->currency) }} {{ bcadd($order->total_amount, $order->total_shipping_fee, 2) }}">
                    </p>
                    <div class="refund_info_item">
                        <span>@lang('order.Application description')</span>
                        <textarea name="remark_from_user" maxlength="200"
                                  readonly>{{ $order->refund->remark_from_user }}</textarea>
                    </div>
                    @endif
                </div>
                <!--订单内容-->
                <div class="order_products">
                    @foreach($snapshot as $order_item)
                        <div class="ordDetail_item">
                            <img src="{{ $order_item['sku']['product']['thumb_url'] }}"
                                 data-url="{{ route('mobile.products.show', ['product' => $order_item['sku']['product']['id'],'slug'=>$order_item['sku']['product']['slug']]) }}">
                            <div>
                                <div class="ordDetailName">
                                    <a href="{{ route('mobile.products.show', ['product' => $order_item['sku']['product']['id'],'slug'=>$order_item['sku']['product']['slug']]) }}">
                                        {{ App::isLocale('zh-CN') ? $order_item['sku']['product']['name_zh'] : $order_item['sku']['product']['name_en'] }}
                                    </a>
                                </div>
                                <div>
                                    <span>
                                        @lang('basic.users.quantity')：{{ $order_item['number'] }}
                                        &nbsp;&nbsp;
                                    </span>
                                    <span>
                                        <a href="{{ route('mobile.products.show', ['product' => $order_item['sku']['product']['id'],'slug'=>$order_item['sku']['product']['slug']]) }}">
                                            {{--{{ App::isLocale('en') ? $order_item['sku']['name_en'] : $order_item['sku']['name_zh'] }}--}}
                                            {{ $order_item['sku']['attr_value_string'] }}
                                        </a>
                                    </span>
                                </div>
                                <div class="ordDetailPri">
                                    {{--<span>{{ ($order->currency == 'USD') ? '&#36;' : '&#165;' }}</span>--}}
                                    <span>{{ get_symbol_by_currency($order->currency) }}</span>
                                    <span>{{ $order_item['price'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="order_info">
                        <p>
                            <span>@lang('order.Order time')：</span>
                            <span>{{ $order->created_at }}</span>
                        </p>
                        <p>
                            <span>@lang('order.Order number')：</span>
                            <span>{{ $order->order_sn }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="refund_btns">
                <div>
                    @if(! $refund)
                            <!--第一步显示-->
                    <a class="doneBtn step-1-submit" href="javascript:void(0);"
                       data-url="{{ route('orders.store_refund', ['order' => $order->id]) }}">
                        @lang('app.submit')
                    </a>
                    @elseif(isset($refund) && $refund->status == \App\Models\OrderRefund::ORDER_REFUND_STATUS_CHECKING)
                            <!--第二步显示-->
                    <a class="ordDetailBtnC change_btn" href="javascript:void(0);"
                       data-url="{{ route('orders.update_refund', ['order' => $order->id]) }}">
                        @lang('order.Modify')
                    </a>
                    <a class="ordDetailBtnC save_btn dis_ni" href="javascript:void(0);"
                       data-url="{{ route('orders.store_refund', ['order' => $order->id]) }}">
                        @lang('order.Save changes')
                    </a>
                    <a class="ordDetailBtnS Revocation_btn" href="javascript:void(0);"
                       code="{{ route('orders.revoke_refund', ['order' => $order->id]) }}">
                        @lang('order.Revocation of application')
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptsAfterJs')
    <script type="text/javascript">
        $(function () {
            $(".refund_con").css("min-height", $(window).height() - $(".headerBar ").height());
            //第一步表单提交
            $(".step-1-submit").on("click", function () {
                if ($("#step-1-form").find("textarea").val() == null || $("#step-1-form").find("textarea").val() == "") {
                    layer.open({
                        content: "@lang('order.Please fill in the reason for the refund')",
                        skin: 'msg',
                        time: 2, //2秒后自动关闭
                    });
                    return false;
                } else {
                    if ($("#step-1-form").find("textarea").val().length < 3) {
                        layer.open({
                            content: "@lang('product.Evaluation content is not less than 3 words')！",
                            skin: 'msg',
                            time: 2, //2秒后自动关闭
                        });
                        return false;
                    } else if ($("#step-1-form").find("textarea").val().length >= 199) {
                        layer.open({
                            content: "@lang('product.The content of the evaluation should not exceed 200 words')！",
                            skin: 'msg',
                            time: 2, //2秒后自动关闭
                        });
                        return false;
                    }
                }
                $("#step-1-form").submit();
            });
            //点击修改申请
            $(".change_btn").on("click", function () {
                $(this).addClass("dis_ni");
                $(".save_btn").removeClass("dis_ni");
                $(".step2_textarea").prop("readonly", false);
                $(".other_reason").addClass("dis_ni");
                $(".choose_remark").removeClass("dis_n");
            });
            //保存修改
            $(".save_btn").on("click", function () {
                if ($("#step-2-form").find("textarea").val() == null || $("#step-2-form").find("textarea").val() == "") {
                    layer.open({
                        content: "@lang('order.Please fill in the reason for the refund')",
                        skin: 'msg',
                        time: 2, //2秒后自动关闭
                    });
                    return false;
                } else {
                    if ($("#step-2-form").find("textarea").val().length < 3) {
                        layer.open({
                            content: "@lang('product.Evaluation content is not less than 3 words')！",
                            skin: 'msg',
                            time: 2, //2秒后自动关闭
                        });
                        return false;
                    } else if ($("#step-2-form").find("textarea").val().length >= 199) {
                        layer.open({
                            content: "@lang('product.The content of the evaluation should not exceed 200 words')！",
                            skin: 'msg',
                            time: 2, //2秒后自动关闭
                        });
                        return false;
                    }
                }
                $("#step-2-form").submit();
            });
            //撤销退款申请
            $(".Revocation_btn").on("click", function () {
                var clickDom = $(this);
                layer.open({
                    content: "@lang('order.Make sure to apply after withdrawing sales')",
                    btn: ["@lang('app.determine')", "@lang('app.cancel')"],
                    yes: function (index) {
                        var data = {
                            _method: "PATCH",
                            _token: "{{ csrf_token() }}",
                        };
                        var url = clickDom.attr('code');
                        $.ajax({
                            type: "post",
                            url: url,
                            data: data,
                            success: function (data) {
                                window.location.href = "{{ route('mobile.orders.index') }}";
                            },
                            error: function (err) {
                                console.log(err);
                                if (err.status == 403) {
                                    layer.open({
                                        content: "@lang('app.Unable to complete operation')",
                                        skin: 'msg',
                                        time: 2, //2秒后自动关闭
                                    });
                                }
                            },
                        });
                        layer.close(index);
                    }
                });
            });
            //切换下拉菜单
            $(".choose_remark").on("change", function () {
                if ($(this).val() == "etc") {
                    $(".other_reason").removeClass("dis_ni");
                } else {
                    $(".other_reason").addClass("dis_ni");
                    $(".other_reason textarea").val($(this).val());
                }
            });
        });
    </script>
@endsection
