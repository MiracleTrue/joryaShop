@extends('layouts.app')
@section('title', '个人中心-我的订单')
@section('content')
    @include('common.error')
    <div class="User_center my_orders">
        <div class="m-wrapper">
            <div class="refun_crumbs">
                <p class="Crumbs">
                    <a href="{{ route('root') }}">首页</a>
                    <span>></span>
                    <a href="{{ route('users.home') }}">个人中心</a>
                    <span>></span>
                    <a href="{{ route('orders.index') }}">我的订单</a>
                    <span>></span>
                    <a href="{{ route('orders.show', ['order' => $order->id]) }}">订单详情</a>
                    <span>></span>
                    <a href="#">申请售后</a>
                </p>
            </div>
            <!--申请内容-->
            <div class="refund_content">
                <div class="technological_process">
                    <!--分步骤显示图片一共四张-->
                    @if(! $refund)
                        <img src="{{ asset('img/process-1.png') }}">
                    @elseif(isset($refund) && $refund->status == \App\Models\OrderRefund::ORDER_REFUND_STATUS_CHECKING)
                        <img src="{{ asset('img/process-2.png') }}">
                    @elseif(isset($refund) && in_array($refund->status, [\App\Models\OrderRefund::ORDER_REFUND_STATUS_SHIPPING, \App\Models\OrderRefund::ORDER_REFUND_STATUS_RECEIVING]))
                        <img src="{{ asset('img/process-3.png') }}">
                    @elseif(isset($refund) && $refund->status == \App\Models\OrderRefund::ORDER_REFUND_STATUS_REFUNDED)
                        <img src="{{ asset('img/process-4.png') }}">
                    @elseif(isset($refund) && $refund->status == \App\Models\OrderRefund::ORDER_REFUND_STATUS_DECLINED)
                        <img src="{{ asset('img/process-5.png') }}">
                    @endif
                </div>
                <div class="process_content">
                    <!--左侧内容-->
                    <div class="pull-left left_content">
                        @if(! $refund)
                                <!--第一步买家申请退货并退款-->
                        <div class="step_content step-1">
                            <form method="POST"
                                  action="{{ route('orders.store_refund_with_shipment', ['order' => $order->id]) }}"
                                  enctype="multipart/form-data" id="step-1-form">
                                {{ csrf_field() }}
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <ul class="step-1-ul step-ul">
                                    <li>
                                        <span><i class="red">*</i>退款金额：</span>
                                        <input name="amount" type="text" class="refund_amount"
                                               value="{{ $order->total_amount }}" readonly>
                                    </li>
                                    <li>
                                        <span><i class="red">*</i>申请说明：</span>
                                        <textarea name="remark_by_user" class="reasons_for_refunds"
                                                  placeholder="请填写退款原因"></textarea>
                                        <span class="remainder">200</span>
                                    </li>
                                    <li>
                                        <span><i class="red">*</i>商品图片：</span>
                                        <div class="refunds_photos">
                                            <span>上传凭证</span>
                                            <span>（最多3张）</span>
                                        </div>
                                        <input type="file" name="image" value="" id="refunds_photos_file"
                                               onchange="imgChange(this)">
                                        <input type="hidden" name="photos_for_refund">
                                    </li>
                                </ul>
                            </form>
                            <p class="btn_submit_area">
                                <a class="step-1-submit step-submit">提交</a>
                            </p>
                        </div>
                        @elseif(isset($refund) && $refund->status == \App\Models\OrderRefund::ORDER_REFUND_STATUS_CHECKING)
                                <!--第二步卖家处理退货申请-->
                        <div class="step_content step-2">
                            <form method="POST"
                                  action="{{ route('orders.update_refund_with_shipment', ['order' => $order->id]) }}"
                                  enctype="multipart/form-data" id="step-2-form">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <ul class="step-1-ul step-ul">
                                    <li>
                                        <span><i class="red">*</i>退款金额：</span>
                                        <input name="amount" type="text" class="refund_amount no_border"
                                               value="{{ $order->total_amount }}" readonly>
                                    </li>
                                    <li>
                                        <span><i class="red">*</i>申请说明：</span>
                                        <textarea name="remark_by_user" class="reasons_for_refunds no_border" readonly
                                                  placeholder="请填写退款原因">{{ $refund->remark_by_user }}</textarea>
                                        <span class="remainder hidden">200</span>
                                    </li>
                                    <li>
                                        <span><i class="red">*</i>商品图片：</span>
                                        <div class="refunds_photos dis_n refunds_2">
                                            <span>上传凭证</span>
                                            <span>（最多3张）</span>
                                        </div>
                                        <input type="file" name="image" value="" id="refunds_photos_2"
                                               onchange="imgChange(this)">
                                        <input type="hidden" name="photos_for_refund"
                                               value="{{ $refund->photos_for_refund }}">
                                        <!--获取的图片按照下面的格式存放不超过3张-->
                                        @if($refund->photos_for_refund)
                                            @foreach($refund->photo_set_for_refund as $photo_for_refund)
                                                <div class='refund-path' data-path='{{ $photo_for_refund }}'>
                                                    <img src="{{ $photo_for_refund }}"
                                                         data-path='{{ $photo_for_refund }}'>
                                                    <img class='del_btn dis_n'
                                                         src="{{ asset('img/delete_refund_photos.png') }}"/>
                                                </div>
                                            @endforeach
                                        @endif
                                    </li>
                                </ul>
                            </form>
                            <p class="btn_submit_area">
                                <a class="step-2-submit-1 step-submit">修改申请</a>
                                <a class="step-2-submit-2 step-submit dis_ni">保存修改</a>
                                <a class="step-2-submit-3 normal-submit"
                                   code="{{ route('orders.revoke_refund', ['order' => $order->id]) }}">撤销申请</a>
                            </p>
                        </div>
                        @elseif(isset($refund) && in_array($refund->status, [\App\Models\OrderRefund::ORDER_REFUND_STATUS_SHIPPING, \App\Models\OrderRefund::ORDER_REFUND_STATUS_RECEIVING]))
                                <!--第三步买家退货-->
                        <div class="step_content step-3">
                            <div class="read_info">
                                <!--需要根据退款的流程来进行判断显示哪一个-->
                                @if($refund->status == \App\Models\OrderRefund::ORDER_REFUND_STATUS_SHIPPING)
                                    <p class="read_info_title">
                                        审核通过，等待买家发货
                                    </p>
                                @elseif($refund->status == \App\Models\OrderRefund::ORDER_REFUND_STATUS_RECEIVING)
                                    <p class="read_info_title">
                                        等待卖家收货
                                    </p>
                                @endif
                                <div class="read_address_info">
                                    <p>退货地址</p>
                                    <p><span>联系人：</span><span>{{ $refund->seller_info['name'] }}</span></p>
                                    <p><span>联系方式：</span><span>{{ $refund->seller_info['phone'] }}</span></p>
                                    <p><span>联系地址：</span><span>{{ $refund->seller_info['address'] }}</span></p>
                                </div>
                                <ul class="step-ul">
                                    <li>
                                        <span>退款金额：</span>
                                        <span class="amount_num">{{ $order->total_amount }}</span>
                                    </li>
                                    <li>
                                        <span>退款说明：</span>
                                        <p>{{ $refund->remark_by_user }}</p>
                                    </li>
                                    <li>
                                        <span>商品图片：</span>
                                        @if($refund->photos_for_refund)
                                            @foreach($refund->photo_set_for_refund as $photo_for_refund)
                                                <div class='refund-path'>
                                                    <img src="{{ $photo_for_refund }}">
                                                </div>
                                            @endforeach
                                        @endif
                                    </li>
                                </ul>
                            </div>
                            @if($refund->status == \App\Models\OrderRefund::ORDER_REFUND_STATUS_SHIPPING)
                                <form method="POST"
                                      action="{{ route('orders.update_refund_with_shipment', ['order' => $order->id]) }}"
                                      enctype="multipart/form-data" id="step-3-form">
                                    {{ method_field('PUT') }}
                                    {{ csrf_field() }}
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <ul class="step-1-ul step-ul">
                                        <li>
                                            <span><i class="red">*</i>物流公司：</span>
                                            <input name="shipment_company" type="text" class="refund_company" value="">
                                        </li>
                                        <li>
                                            <span><i class="red">*</i>物流单号：</span>
                                            <input name="shipment_sn" type="text" class="refund_ numbers" value="">
                                        </li>
                                        <li>
                                            <span><i class="red">*</i>备注内容：</span>
                                        <textarea name="remark_by_shipment" class="remarks_for_refunds"
                                                  placeholder="请填写备注内容"></textarea>
                                        </li>
                                        <li>
                                            <span><i class="red">*</i>物流单据：</span>
                                            <!--这个refunds_3区域和read_info_title设置相同的判断显示隐藏，
                                                当地一条显示的时候下面的区域显示，
                                                第二条显示的时候下面这条隐藏
                                            -->
                                            <div class="refunds_photos refunds_3">
                                                <span>上传凭证</span>
                                                <span>（最多3张）</span>
                                            </div>
                                            <input type="file" name="image" value="" id="refunds_photos_bill"
                                                   onchange="imgChange(this)">
                                            <input type="hidden" name="photos_for_shipment">
                                        </li>
                                    </ul>
                                </form>
                                <!--这个区域和read_info_title设置相同的判断显示隐藏，
                                    当地一条显示的时候下面的区域显示，
                                    第二条显示的时候下面这条隐藏
                                -->
                                <p class="btn_submit_area">
                                    <a class="step-3-submit step-submit">提交</a>
                                </p>
                            @elseif($refund->status == \App\Models\OrderRefund::ORDER_REFUND_STATUS_RECEIVING)
                                <div class="read_info last_level">
                                    <ul class="step-ul">
                                        <li>
                                            <span>物流公司：</span>
                                            <span>{{ $shipment_company }}</span>
                                        </li>
                                        <li>
                                            <span>物流单号：</span>
                                            <span>{{ $refund->shipment_sn }}</span>
                                        </li>
                                        <li>
                                            <span>备注内容：</span>
                                            <p>{{ $refund->remark_by_shipment }}</p>
                                        </li>
                                        <li>
                                            <span>物流单据：</span>
                                            @if($refund->photos_for_shipment)
                                                @foreach($refund->photo_set_for_shipment as $photo_for_shipment)
                                                    <div class='refund-path'>
                                                        <img src="{{ $photo_for_shipment }}">
                                                    </div>
                                                @endforeach
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                        @elseif(isset($refund) && $refund->status == \App\Models\OrderRefund::ORDER_REFUND_STATUS_REFUNDED)
                                <!--第四步退款成功-->
                        <div class="step_content step-4">
                            <div class="read_info">
                                <p class="read_info_title">
                                    审核通过，退款成功
                                    <span>
                                        退款成功！ {{ $order->total_amount }}
                                        元已按照原打款路径退回。
                                    </span>
                                </p>
                                <div class="read_address_info">
                                    <p>退货地址</p>
                                    <p><span>联系人：</span><span>{{ $refund->seller_info['name'] }}</span></p>
                                    <p><span>联系方式：</span><span>{{ $refund->seller_info['phone'] }}</span></p>
                                    <p><span>联系地址：</span><span>{{ $refund->seller_info['address'] }}</span></p>
                                </div>
                                <ul class="step-ul">
                                    <li>
                                        <span>退款金额：</span>
                                        <span class="amount_num">¥ {{ $order->total_amount }}</span>
                                    </li>
                                    <li>
                                        <span>退款说明：</span>
                                        <p>{{ $refund->remark_by_user }}</p>
                                    </li>
                                    <li>
                                        <span>商品图片：</span>
                                        @if($refund->photos_for_refund)
                                            @foreach($refund->photo_set_for_refund as $photo_for_refund)
                                                <div class='refund-path'>
                                                    <img src="{{ $photo_for_refund }}">
                                                </div>
                                            @endforeach
                                        @endif
                                    </li>
                                </ul>
                            </div>
                            <div class="read_info last_level">
                                <ul class="step-ul">
                                    <li>
                                        <span>物流公司：</span>
                                        <span>{{ $shipment_company }}</span>
                                    </li>
                                    <li>
                                        <span>物流单号：</span>
                                        <span>{{ $refund->shipment_sn }}</span>
                                    </li>
                                    <li>
                                        <span>备注内容：</span>
                                        <p>{{ $refund->remark_by_shipment }}</p>
                                    </li>
                                    <li>
                                        <span>物流单据：</span>
                                        @foreach($refund->photo_set_for_shipment as $photo_for_shipment)
                                            <div class='refund-path'>
                                                <img src="{{ $photo_for_shipment }}">
                                            </div>
                                        @endforeach
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @elseif(isset($refund) && $refund->status == \App\Models\OrderRefund::ORDER_REFUND_STATUS_DECLINED)
                                <!--第五步退款失败-->
                        <div class="step_content step-5">
                            <div class="read_info last_level">
                                <p class="read_info_title">
                                    审核未通过
                                    <span>
                                        你可以联系在线客服或者拨打400电话
                                    </span>
                                </p>
                                <ul class="step-ul">
                                    <li>
                                        <span>退款金额：</span>
                                        <span class="amount_num">¥ {{ $order->total_amount }}</span>
                                    </li>
                                    <li>
                                        <span>退款说明：</span>
                                        <p>{{ $refund->remark_by_user }}</p>
                                    </li>
                                    <li>
                                        <span>商品图片：</span>
                                        @if($refund->photos_for_refund)
                                            @foreach($refund->photo_set_for_refund as $photo_for_refund)
                                                <div class='refund-path'>
                                                    <img src="{{ $photo_for_refund }}">
                                                </div>
                                            @endforeach
                                        @endif
                                    </li>
                                    <li class="red">
                                        <span>卖家回复：</span>
                                        <p>{{ $refund->remark_by_seller }}</p>
                                    </li>
                                </ul>
                                <p class="btn_submit_area">
                                    <a class="step-5-submit-1 step-submit">确定</a>
                                    <a class="step-5-submit-2 normal-submit"
                                       code="{{ route('orders.revoke_refund', ['order' => $order->id]) }}">撤销申请</a>
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                    <!--右侧订单信息-->
                    <div class="pull-left order_lists">
                        <p class="step_content_title">订单信息</p>
                        <ul>
                            @foreach($snapshot as $order_item)
                                <li>
                                    <a href="{{ route('products.show', ['product' => $order_item['sku']['product']['id']]) }}">
                                        <div class="info_img">
                                            <img src="{{ $order_item['sku']['product']['thumb_url'] }}">
                                        </div>
                                        <div class="order_lists_info">
                                            <p><span>{{ $order_item['sku']['product']['name_zh'] }}</span></p>
                                            <p>{{ $order_item['sku']['name_zh'] }}</p>
                                            <p>单价：¥ {{ $order_item['price'] }} x {{ $order_item['number'] }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                            <li class="order_lists_total">
                                <p>
                                    <span>订单时间：</span>
                                    <span>{{ $order->created_at }}</span>
                                </p>
                                <p>
                                    <span>订单编号：</span>
                                    <span>{{ $order->order_sn }}</span>
                                </p>
                                <p>
                                    <span>邮费：</span>
                                    <span><i>¥ </i>{{ $order->total_shipping_fee }}</span>
                                </p>
                                <p>
                                    <span>合计：</span>
                                    <span><i>¥ </i>{{ bcadd($order->total_amount, $order->total_shipping_fee, 2) }}
                                        （含邮费）</span>
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptsAfterJs')
    <script src="{{ asset('js/swiper/js/swiper.js') }}"></script>
    <script type="text/javascript">
        var set_finish = false;
        $(function () {
            $(".navigation_left ul li").removeClass("active");
            $(".my_order").addClass("active");
            $(".myorder_classification li").on('click', function () {
                $(".myorder_classification li").removeClass('active');
                $(this).addClass("active");
            });
            //页面加载时判断右侧订单信息的高度
            var h = $(".left_content").height();
            $(".order_lists ul").css("height", parseInt(h - 65));
            //上传图片
            $(".refunds_photos").on("click", function () {
                var img_num = $(this).parents('li').find(".refund-path");
                if (img_num.length < 3) {
                    $("#refunds_photos_file").click();
                } else {
                    layer.msg('最多上传3张图片！！');
                }
            });
            $(".refunds_2").on("click", function () {
                var img_num = $(this).parents('li').find(".refund-path");
                if (img_num.length < 3) {
                    $("#refunds_photos_2").click();
                } else {
                    layer.msg('最多上传3张图片！！');
                }
            });
            $(".refunds_3").on("click", function () {
                var img_num = $(this).parents('li').find(".refund-path");
                if (img_num.length < 3) {
                    $("#refunds_photos_bill").click();
                } else {
                    layer.msg('最多上传3张图片！！');
                }
            });
            //图片删除
            $(".del_btn").on('click', function () {
                $(this).parents('.refund-path').remove();
            });
            //第一步提交退款申请
            $(".step-1-submit").on("click", function () {
                set_path("#step-1-form", 'photos_for_refund');
                if (set_finish == true) {
                    $("#step-1-form").submit();
                }
            });
            //判断文本域的字数
            $(".reasons_for_refunds").keyup(function () {
                var text = $(this).val();
                //中文字数统计
                str = (text.replace(/\w/g, "")).length;
                //非汉字的个数
                abcnum = text.length - str;
                total = str + abcnum;
                if (total > 200) {
                    $(this).val($(this).val().substring(0, 200));
                    $(".remainder").html('0');
                    layer.msg('字数超过上限')
                } else {
                    var num = 200 - total;
                    $(".remainder").html(num);
                }
            });
            $(".reasons_for_refunds").change(function () {
                var text = $(this).val();
                //中文字数统计
                str = (text.replace(/\w/g, "")).length;
                //非汉字的个数
                abcnum = text.length - str;
                total = str + abcnum;
                // console.log(total);
                if (total > 200) {
                    $(this).val($(this).val().substring(0, 200));
                    $(".remainder").html('0');
                    layer.msg('字数超过上限')
                } else {
                    var num = 200 - total;
                    $(".remainder").html(num);
                }
            });
            //修改申请
            $(".step-2-submit-1").on("click", function () {
                $(".step-2 input").removeClass("no_border");
                $(".step-2 textarea").removeClass("no_border");
                $(".step-2 textarea").prop("readonly", false);
                $(".step-2 .del_btn").removeClass('dis_n');
                $(".refunds_2").removeClass('dis_n');
                $(".remainder").removeClass('hidden');
                $(this).addClass("dis_ni");
                $(".step-2-submit-2").removeClass("dis_ni");
            });
            //提交保存修改
            $(".step-2-submit-2").on("click", function () {
                set_path("#step-2-form", 'photos_for_refund');
                if (set_finish == true) {
                    $("#step-2-form").submit();
                }
            });
            //撤销退款申请
            $(".step-2-submit-3").on("click", function () {
                var data = {
                    _method: "PATCH",
                    _token: "{{ csrf_token() }}",
                };
                var url = $(this).attr('code');
                $.ajax({
                    type: "post",
                    url: url,
                    data: data,
                    success: function (data) {
                        window.location.href = "{{ route('orders.index') }}";
                    },
                    error: function (err) {
                        console.log(err);
                        if (err.status == 403) {
                            layer.open({
                                type: 1,
                                content: '您无权限执行此操作！'
                            });
                        }
                    }
                });
            });
            //提交物流单据
            $(".step-3-submit").on("click", function () {
                set_path("#step-3-form", 'photos_for_shipment');
                if (set_finish == true) {
                    $("#step-3-form").submit();
                }
            });
            //撤销退款申请
            $(".step-5-submit-2").on("click", function () {
                var data = {
                    _method: "PATCH",
                    _token: "{{ csrf_token() }}",
                };
                var url = $(this).attr('code');
                $.ajax({
                    type: "post",
                    url: url,
                    data: data,
                    success: function (data) {
                        window.location.href = "{{ route('orders.index') }}";
                    },
                    error: function (err) {
                        console.log(err);
                        if (err.status == 403) {
                            layer.open({
                                type: 1,
                                content: '您无权限执行此操作！',
                            });
                        }
                    }
                });
            })
        });
        // 图片上传入口按钮 input[type=file]值发生改变时触发
        function imgChange(obj) {
            var filePath = $(obj).val();
            if (filePath.indexOf("jpg") != -1 || filePath.indexOf("png") != -1 || filePath.indexOf("jpeg") != -1 || filePath.indexOf("gif") != -1 || filePath.indexOf("bmp") != -1) {
                var arr = filePath.split('\\');
                var fileName = arr[arr.length - 1];
                upLoadBtnSwitch = 1;
                UpLoadImg(obj);
            } else {
                layer.open({
                    title: '提示',
                    content: '您未选择图片，或者您上传文件格式有误！（当前支持图片格式：jpg，png，jpeg，gif，bmp）'
                });
                upLoadBtnSwitch = 0;
                return false
            }
        }

        // 本地图片上传 按钮
        function UpLoadImg(obj) {
            var formData = new FormData();
            formData.append('image', $(obj)[0].files[0]);
            $.ajax({
                url: "{{ route('comment_image.upload') }}",
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,//必须false才会避开jQuery对 formdata 的默认处理 XMLHttpRequest会对 formdata 进行正确的处理
                processData: false,//必须false才会自动加上正确的Content-Type
                type: 'post',
                success: function (data) {
                    var html = "<div class='refund-path' data-path='" + data.path + "'>" +
                            "<img src='" + data.preview + "' data-path='" + data.path + "'>" +
                            "<img class='del_btn' src='{{ asset('img/delete_refund_photos.png') }}'/>" +
                            "</div>";
                    $(obj).parents('li').append(html);
                }, error: function (e) {
                    console.log(e);
                }
            });
        }
        function set_path(dom, input_name) {
            var order_list = $(dom).find(".refund-path");
            var path_url = "";
            $.each(order_list, function (i, n) {
                path_url += $(n).attr('data-path') + ",";
            });
            path_url = path_url.substring(0, path_url.length - 1);

            $(dom).find("input[name='" + input_name + "']").val(path_url);
            set_finish = true;
            return set_finish;
        }
    </script>
@endsection
