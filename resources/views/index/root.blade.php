@extends('layouts.app')
@section('title', App::isLocale('zh-CN') ? '莱瑞美业' : 'Lyricalhair')
@section('content')
    <div class="home-page">
        <div class="swiper-container banner" id="banner">
            <div class="swiper-wrapper">
                @if(isset($banners) && $banners->isNotEmpty())
                    @foreach($banners as $banner)
                        <div class="swiper-slide">
                            <a>
                                <img src="{{ $banner->image_url }}">
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="swiper-slide">
                        <a>
                            <img src="{{ asset('defaults/defaults_pc_banner.png') }}">
                        </a>
                    </div>
                @endif
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
        <div class="new_product product-part">
            <div class="m-wrapper">
                <h3>@lang('app.New Product Starter')</h3>
                <div class="new_product_left pull-left">
                    @if($poster = \App\Models\Poster::getPosterBySlug('pc_index_left_top'))
                        <div class="product_left_top">
                            <a href="{{ $poster->link }}"><img class="lazy" data-src="{{ $poster->image_url }}"></a>
                        </div>
                    @else
                        <div class="product_left_top">
                            <img class="lazy" data-src="{{ asset('defaults/default_pc_index_left_bottom.jpg') }}">
                        </div>
                    @endif
                    @if($poster = \App\Models\Poster::getPosterBySlug('pc_index_left_bottom'))
                        <div class="product_left_bottom">
                            <a href="{{ $poster->link }}"><img class="lazy" data-src="{{ $poster->image_url }}"></a>
                        </div>
                    @else
                        <div class="product_left_bottom">
                            <img class="lazy" data-src="{{ asset('defaults/default_pc_index_left_bottom.jpg') }}">
                        </div>
                    @endif
                </div>
                @if($poster = \App\Models\Poster::getPosterBySlug('pc_index_right'))
                    <div class="new_product_right pull-left">
                        <a href="{{ $poster->link }}"><img class="lazy" data-src="{{ $poster->image_url }}"></a>
                    </div>
                @else
                    <div class="new_product_right pull-left">
                        <img class="lazy" data-src="{{ asset('defaults/default_pc_index_right.jpg') }}">
                    </div>
                @endif
            </div>
        </div>
        @foreach($products as $key => $category_products)
            @if(($key+1) % 2 == 1)
                <div class="fashion_trend product-part">
                    <div class="m-wrapper">
                        <div class="part_title">
                            <a href="{{ route('product_categories.index', ['category' => $category_products['category']->id]) }}">
                                <h3>{{ App::isLocale('zh-CN') ? $category_products['category']->name_zh : $category_products['category']->name_en }}</h3>
                            </a>
                            <ul class="pull-right">
                                @foreach($category_products['children'] as $k => $child)
                                    @if($k > 5)
                                        @break
                                    @endif
                                    <li>
                                        <a href="{{ route('product_categories.index', ['category' => $child->id]) }}">{{ App::isLocale('zh-CN') ? $child->name_zh : $child->name_en }}</a>
                                        @if($k != 0)
                                            <span>/</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="content">
                            <ul>
                                @foreach($category_products['products'] as $k => $product)
                                    @if($category_products['products']->count() > 4 && $category_products['products']->count() < 8)
                                        @if($k > 3)
                                            @break
                                        @endif
                                    @else
                                        @if($k > 7)
                                            @break
                                        @endif
                                    @endif
                                    <li>
                                        <a href="{{ route('products.show', ['product' => $product->id]) }}">
                                            <img class="lazy" data-src="{{ $product->thumb_url }}">
                                            <h5 title="{{ App::isLocale('zh-CN') ? $product->name_zh : $product->name_en }}">
                                                {{ App::isLocale('zh-CN') ? $product->name_zh : $product->name_en }}
                                            </h5>
                                            <span title="{{ App::isLocale('zh-CN') ? strip_tags($product->description_zh) : strip_tags($product->description_en) }}">
                                                {!! App::isLocale('zh-CN') ? $product->description_zh : $product->description_en !!}
                                            </span>
                                            {{--<p class="product_price">@lang('basic.currency.symbol') {{ App::isLocale('en') ? $product->price_in_usd : $product->price }}</p>--}}
                                            <p class="product_price">{{ get_global_symbol() }} {{ get_current_price($product->price) }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @else
                <div class="customization product-part">
                    <div class="m-wrapper">
                        <div class="part_title">
                            <a href="{{ route('product_categories.index', ['category' => $category_products['category']->id]) }}">
                                <h3>{{ App::isLocale('zh-CN') ? $category_products['category']->name_zh : $category_products['category']->name_en }}</h3>
                            </a>
                            <ul class="pull-right">
                                @foreach($category_products['children'] as $k => $child)
                                    @if($k > 5)
                                        @break
                                    @endif
                                    <li>
                                        <a href="{{ route('product_categories.index', ['category' => $child->id]) }}">{{ App::isLocale('zh-CN') ? $child->name_zh : $child->name_en }}</a>
                                        @if($k != 0)
                                            <span>/</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="customization_banner">
                            @if($poster = \App\Models\Poster::getPosterBySlug('pc_index_floor_' . ($key+1)))
                                <a class="buy_now" href="{{ $poster->link }}">
                                    <img class="lazy" data-src="{{ $poster->image_url }}" style="height: 310px;">
                                </a>
                            @else
                                <a class="buy_now" href="{{ route('root') }}">
                                    <img class="lazy"
                                         data-src="{{ asset('defaults/default_pc_index_floor_even.png') }}"/>
                                </a>
                            @endif
                        </div>
                        <div class="customization_list">
                            <ul>
                                @foreach($category_products['products'] as $k => $product)
                                    @if($k > 3)
                                        @break
                                    @endif
                                    <li>
                                        <div>
                                            <img class="lazy" data-src="{{ $product->thumb_url }}">
                                            <a href="{{ route('products.show', ['product' => $product->id]) }}">
                                                <div class="list_mask"></div>
                                                <img src="{{ asset('img/mask_search.png') }}">
                                            </a>
                                        </div>
                                        <h5 title="{{ App::isLocale('zh-CN') ? $product->name_zh : $product->name_en }}">
                                            {{ App::isLocale('zh-CN') ? $product->name_zh : $product->name_en }}
                                        </h5>
                                        <span title="{{ App::isLocale('zh-CN') ? strip_tags($product->description_zh) : strip_tags($product->description_en) }}">
                                            {!! App::isLocale('zh-CN') ? $product->description_zh : $product->description_en !!}
                                        </span>
                                        {{--<p class="product_price">@lang('basic.currency.symbol') {{ App::isLocale('en') ? $product->price_in_usd : $product->price }}</p>--}}
                                        <p class="product_price">{{ get_global_symbol() }} {{ get_current_price($product->price) }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        <div class="guess_like product-part">
            <div class="m-wrapper">
                <h3>@lang('app.you may also like')</h3>
                <ul class="guess_lists">
                    @foreach($guesses as $k => $guess)
                        @if($k > 7)
                            @break
                        @endif
                        <li>
                            <div class="guess_list_img">
                                {{--<div class="guess_list_tips">
                                    <img class="lazy" data-src="{{ asset('img/guess_tips.png') }}">
                                </div>--}}
                                <img class="lazy" data-src="{{ $guess->thumb_url }}">
                            </div>
                            <h5 title="{{ App::isLocale('zh-CN') ? $guess->name_zh : $guess->name_en }}">
                                {{ App::isLocale('zh-CN') ? $guess->name_zh : $guess->name_en }}
                            </h5>
                            <p class="guess_price">
                                {{--<span class="new_price">@lang('basic.currency.symbol') {{ App::isLocale('en') ? $guess->price_in_usd : $guess->price }}</span>--}}
                                {{--<span class="old_price">@lang('basic.currency.symbol') {{ App::isLocale('en') ? bcmul($guess->price_in_usd, 1.2, 2) : bcmul($guess->price, 1.2, 2) }}</span>--}}
                                <span class="new_price">{{ get_global_symbol() }} {{ get_current_price($guess->price) }}</span>
                                <span class="old_price">{{ get_global_symbol() }} {{ bcmul(get_current_price($guess->price), 1.2, 2) }}</span>
                            </p>
                            <a class="buy_now_guess" href="{{ route('products.show', ['product' => $guess->id]) }}">
                                @lang('product.buy_now')
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('scriptsAfterJs')
    <script src="{{ asset('js/swiper/js/swiper.js') }}"></script>
    <script type="text/javascript">
        $(function () {
        	if($(".swiper-container .swiper-slide").length != 1){
			    var swiper = new Swiper('.swiper-container', {
	                centeredSlides: true,
	                loop: true,
	                speed: 4000,
	                fadeEffect: {
	                    crossFade: true,
	                },
		            autoplay: {
		                delay: 4000,
		            },
	                navigation: {
	                    nextEl: '.swiper-button-next',
	                    prevEl: '.swiper-button-prev',
	                },
	           });
			}
        });
    </script>
@endsection
