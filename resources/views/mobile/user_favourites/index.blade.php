@extends('layouts.mobile')
@section('title', App::isLocale('en') ? 'My Favourites' : '我的收藏')
@section('content')
    @if(!is_wechat_browser())
    <div class="headerBar fixHeader">
    @else
    <div class="headerBar fixHeader height_no">
    @endif
        <img src="{{ asset('static_m/img/icon_backtop.png') }}" class="backImg" onclick="javascript:history.back(-1);"/>
        <span>@lang('product.My Favourites')</span>
    </div>
    @if($favourites->isEmpty())
            <!--暂无收藏-->
    <div class="notFav">
        <img src="{{ asset('static_m/img/Nocollection.png') }}"/>
        <span>@lang('product.No collection yet')</span>
        <a href="{{ route('mobile.root') }}">@lang('product.shop_now')</a>
    </div>
    @else
        @if(!is_wechat_browser())
        <div class="favBox">
        @else
        <div class="favBox margin-top_no">
        @endif
            @foreach($favourites as $favourite)
                <div class="favItem" code='{{ $favourite->id }}' data-url="{{ route('mobile.products.show', ['product' => $favourite->product->id]) }}">
                    <img src="{{ $favourite->product->thumb_url }}"/>
                    <div class="favDetail">
                        <div class="goodsName">
                            {{ App::isLocale('en') ? $favourite->product->name_en : $favourite->product->name_zh }}
                        </div>
                        <div class="goodsPri">
                            <div>
                                <span class="realPri">
                                    @lang('basic.currency.symbol') {{ App::isLocale('en') ? $favourite->product->price_in_usd : $favourite->product->price }}
                                </span>
                                <s>
                                    @lang('basic.currency.symbol') {{ App::isLocale('en') ? bcmul($favourite->product->price_in_usd, 1.2, 2) : bcmul($favourite->product->price, 1.2, 2) }}
                                </s>
                            </div>
                            <img class="addTo_cart" src="{{ asset('static_m/img/icon_ShoppingCart2.png') }}"/>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="editFav">
            @foreach($favourites as $favourite)
                <div class="favItem" code='{{ $favourite->id }}'>
                    <label class="favItemLab">
                        <input type="checkbox" name="" id="" value="{{ $favourite->id }}" code="{{ route('user_favourites.destroy', $favourite->id) }}">
                        <span></span>
                    </label>
                    <img data-url="{{ route('mobile.products.show', ['product' => $favourite->product->id]) }}" src="{{ $favourite->product->thumb_url }}"/>
                    <div class="favDetail" data-url="{{ route('mobile.products.show', ['product' => $favourite->product->id]) }}">
                        <div class="goodsName">
                            {{ App::isLocale('en') ? $favourite->product->name_en : $favourite->product->name_zh }}
                        </div>
                        <div class="goodsPri">
                            <div>
                                <span class="realPri">
                                    @lang('basic.currency.symbol') {{ App::isLocale('en') ? $favourite->product->price_in_usd : $favourite->product->price }}
                                </span>
                                <s>
                                    @lang('basic.currency.symbol') {{ App::isLocale('en') ? bcmul($favourite->product->price_in_usd, 1.2, 2) : bcmul($favourite->product->price, 1.2, 2) }}
                                </s>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="editFixt">
            <span class="editBtn">@lang('product.Edit')</span>
            <span class="cancelBtn" data-url="{{ route('user_favourites.multi_delete') }}">@lang('product.Cancel Favourites')</span>
        </div>
    @endif
    {{--@include('layouts._footer')--}}
@endsection

@section('scriptsAfterJs')
    <script type="text/javascript">
        //页面单独JS写这里
        $(".editBtn").on("click", function () {
            if ($(this).html() == "@lang('product.Edit')") {
                $(this).html("@lang('product.Return')");
                $(".favBox").css("display", "none");
                $(".editFav").css("display", "block");
            } else if ($(this).html() == "@lang('product.Return')") {
                $(this).html("@lang('product.Edit')");
                $(".favBox").css("display", "block");
                $(".editFav").css("display", "none");
            }
        });
        $(".cancelBtn").on("click", function () {
            if ($(this).css("background") == "#bc8c61") {
                $(this).css("background", "#dcdcdc");
                $(".editBtn").css("background", "#bc8c61");
                $(".favBox").css("display", "block");
                $(".editFav").css("display", "none");
            }
        });
        $(".favItemLab").on("click", function () {
            if ($(this).children("input").prop("checked") == true) {
                $(".cancelBtn").css("background", "#bc8c61");
                $(".cancelBtn").on("click", function () {
                    layer.open({
                        anim: 'up',
                        content: "@lang('product.Are you sure you want to cancel your attention to this product')",
                        btn: ["@lang('app.determine')", "@lang('app.cancel')"],
                        yes: function(index){
                        	var favourite_ids = "";
	                    	var choose_history = $(".editFav").find("input[type='checkbox']:checked");
	                    	if(choose_history.length>0){
	                    		$.each(choose_history,function(i,n){
	                    			favourite_ids+= $(n).val()+","
	                    		})
	                    		favourite_ids = favourite_ids.substring(0,favourite_ids.length-1);
	                    	}
	                    	var data = {
				                _method: "DELETE",
				                _token: "{{ csrf_token() }}",
				                favourite_ids: favourite_ids
				            }
				            $.ajax({
				                type: "post",
				                url: $(".cancelBtn").attr("data-url"),
				                data: data,
				                success: function (data) {
				                	layer.close(index);
				                    window.location.reload();
				                },
				                error: function (err) {
				                    console.log(err);
				                    if (err.status == 403) {
				                         layer.open({
										    content: "@lang('app.Unable to complete operation')"
										    ,skin: 'msg'
										    ,time: 2 //2秒后自动关闭
										  });
				                    }
				                }
				            });
                        }
                    });
                });
            } else {
                var iptArr = $(".favItemLab input");
                var eqArr = [];
                for (var i = 0; i < iptArr.length; i++) {
                    var iptItem = iptArr[i].checked;
                    eqArr.push(iptItem);
                    var index = $.inArray(true, eqArr);
                }
                if (index == -1) {
                    $(".cancelBtn").css("background", "#dcdcdc");
                }
            }
        });
        //页面跳转
        $(".favBox").on("click", '.favItem', function () {
            window.location.href = $(this).attr("data-url");
        });
        $(".favBox").on("click", '.addTo_cart', function () {
            window.location.href = $(this).parents(".favItem").attr("data-url");
        });
        //编辑状态下的跳转
        $(".editFav").on("click", '.favDetail', function () {
            window.location.href = $(this).attr("data-url");
        });
        $(".editFav").on("click", 'img', function () {
            window.location.href = $(this).attr("data-url");
        });
    </script>
@endsection
