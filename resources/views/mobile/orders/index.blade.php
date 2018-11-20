@extends('layouts.mobile')
@section('title', '我的订单')
@section('content')
	<div class="orderBox">
		<div class="orderHeadTop">
	    	<div class="headerBar">
				<img src="{{ asset('static_m/img/icon_backtop.png') }}" class="backImg" onclick="javascript:history.back(-1);"/>
				<span>我的订单</span>
			</div>
			<div class="orderHead">
				<div class="orderActive">全部</div>
				<div>待付款</div>
				<div>待收货</div>
				<div>待评价</div>
				<div>售后</div>
			</div>
	    </div>
		<div class="orderMain">
			@for($i = 0;$i<3; $i++)
				<div class="orderItem">
					<div class="orderItemH">
						<span>订单编号:45654645464</span>
						<span class="orderItemState">待付款</span>
					</div>
					<div class="orderItemDetail">
						<img src="{{ asset('static_m/img/blockImg.png') }}"/>
						<div class="orderDal">
							<div class="orderIntroduce">
								<div class="goodsName">卓业美业长直假发片卓业美业长直假发片</div>
								<div class="goodsSku">颜色：黄</div>
							</div>
							<div class="orderPrice">
								<div>￥5000.00</div>
								<div class="orderItemNum">x1</div>
							</div>
						</div>
					</div>
					<div class="orderItemTotle">
						<span>共1件商品</span>
						<span class="orderCen">需付款:</span>
						<span>￥298.00</span>
					</div>
					<div class="orderBtns">
						@if(false)
							<!--待付款状态-->
							<button class="orderBtnS">立即付款</button>
						@elseif(false)
						<!--待收货状态-->
							<button class="orderBtnC">提醒发货</button>	
						@elseif(false)
						<!--交易完成状态-->
							<button class="orderBtnC">查看物流</button>
							<button class="orderBtnS">评价</button>	
						@elseif(false)
						<!--交易关闭状态-->
							<button class="orderBtnC">删除订单</button>
							@elseif(false)
						<!--退款中状态-->
							<button class="orderBtnC">查看物流</button>
							<button class="orderBtnS">确认收货</button>
						@else
						<!--待收货状态-->
							<button class="orderBtnC">查看物流</button>
							<button class="orderBtnS">确认收货</button>
						@endif
					</div>
				</div>
			@endfor
		</div>
	</div>
@endsection


@section('scriptsAfterJs')
    <script type="text/javascript">
        //页面单独JS写这里
        $(".orderHead div").on("click",function(e){
        	$(".orderHead div").removeClass("orderActive");
        	$(this).addClass("orderActive");
        });
        $(".orderItemDetail").on("click",function(){
        	window.location.href = "{{ route('mobile.orders.show',\App\Models\Order::where('user_id',Auth::id())->first()) }}";
        });
    </script>
@endsection
