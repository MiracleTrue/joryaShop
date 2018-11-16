@extends('layouts.app')
@section('title', '卓雅美业')

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
                            <img src="{{ asset('img/banner/banner_1.png') }}">
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a>
                            <img src="{{ asset('img/banner/banner_1.png') }}">
                        </a>
                    </div>
                @endif
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
        <div class="new_product product-part">
            <div class="m-wrapper">
                <h3>新品首发</h3>
                <div class="new_product_left pull-left">
                    @if($poster = \App\Models\Poster::getPosterBySlug('pc_index_left_top'))
                        <div class="product_left_top">
                            <img class="lazy" data-src="{{ $poster->image_url }}">
                        </div>
                    @else
                        <div class="product_left_top">
                            <img class="lazy" data-src="{{ asset('defaults/default_pc_index_left_top.png') }}">
                        </div>
                    @endif
                    @if($poster = \App\Models\Poster::getPosterBySlug('pc_index_left_bottom'))
                        <div class="product_left_bottom">
                            <img class="lazy" data-src="{{ $poster->image_url }}">
                        </div>
                    @else
                        <div class="product_left_bottom">
                            <img class="lazy" data-src="{{ asset('defaults/default_pc_index_left_bottom.png') }}">
                        </div>
                    @endif
                </div>
                @if($poster = \App\Models\Poster::getPosterBySlug('pc_index_right'))
                    <div class="new_product_right pull-left">
                        <a href="{{ $poster->link }}"><img  class="lazy" data-src="{{ $poster->image_url }}"></a>
                    </div>
                @else
                    <div class="new_product_right pull-left">
                        <img class="lazy" data-src="{{ asset('defaults/default_pc_index_right.png') }}">
                    </div>
                @endif
            </div>
        </div>
        @foreach($products as $key => $category_products)
            @if($key % 2 == 1)
                <div class="fashion_trend product-part">
                    <div class="m-wrapper">
                        <div class="part_title">
                        	<h3>{{ App::isLocale('en') ? $category_products['category']->name_en : $category_products['category']->name_zh }}</h3>
                            <ul class="pull-right">
                                @foreach($category_products['children'] as $k => $child)
                                    @if($k > 5)
                                        @break
                                    @endif
                                    <li>
                                        <a href="{{ route('product_categories.index', ['category' => $child->id]) }}">{{App::isLocale('en') ? $child->name_en : $child->name_zh }}</a>
                                        <span>/</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="content">
                            <ul>
                                @foreach($category_products['products'] as $k => $product)
                                    @if($k > 7)
                                        @break
                                    @endif
                                    <li>
                                        <a href="{{ route('products.show', ['product' => $product->id]) }}">
                                            <img class="lazy" data-src="{{ $product->thumb_url }}">
                                            <h5>{{App::isLocale('en') ? $product->name_en : $product->name_zh }}</h5>
                                            <span>{{ App::isLocale('en') ? $product->description_en : $product->description_zh }}</span>
                                            <p class="product_price">@lang('basic.currency.symbol') {{ $product->price }}</p>
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
                            <h3>{{ App::isLocale('en') ? $category_products['category']->name_en : $category_products['category']->name_zh }}</h3>
                            <ul class="pull-right">
                                @foreach($category_products['children'] as $k => $child)
                                    @if($k > 5)
                                        @break
                                    @endif
                                    <li>
                                        <a href="{{ route('product_categories.index', ['category' => $child->id]) }}">{{ App::isLocale('en') ? $child->name_en : $child->name_zh }}</a>
                                        <span>/</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="customization_banner">
                            @if($poster = \App\Models\Poster::getPosterBySlug('pc_index_floor_' . $key))
                                <img class="lazy" data-src="{{ $poster->image_url }}" style="height: 310px;">
                                <a class="buy_now" href="{{ $poster->link }}">@lang('product.buy_now')</a>
                            @else
                                <img class="lazy" data-src="{{ asset('defaults/default_pc_index_floor_even.png') }}">
                                <a class="buy_now" href="{{ route('root') }}">@lang('product.buy_now')</a>
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
                                        <h5>{{ App::isLocale('en') ? $product->name_en : $product->name_zh }}</h5>
                                        <span>{{ App::isLocale('en') ? $product->description_en : $product->description_zh }}</span>
                                        <p class="product_price">@lang('basic.currency.symbol') {{ $product->price }}</p>
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
                <h3>猜你喜欢</h3>
                <ul class="guess_lists">
                    @foreach($guesses as $k => $guess)
                        @if($k > 7)
                            @break
                        @endif
                        <li>
                            <div class="guess_list_img">
                                <div class="guess_list_tips">
                                    <img class="lazy" data-src="{{ asset('img/guess_tips.png') }}">
                                </div>
                                <img  class="lazy" data-src="{{ $guess->thumb_url }}">
                            </div>
                            <h5>{{ App::isLocale('en') ? $guess->name_en : $guess->name_zh }}</h5>
                            <p class="guess_price">
                                <span class="new_price">@lang('basic.currency.symbol') {{ $guess->price }}</span>
                                <span class="old_price">@lang('basic.currency.symbol') {{ bcmul($guess->price, 1.2, 2) }}</span>
                            </p>
                            <a class="buy_now_guess"
                               href="{{ route('products.show', ['product' => $guess->id]) }}">@lang('product.buy_now')</a>
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
            var swiper = new Swiper('.swiper-container', {
                centeredSlides: true,
                loop: true,
                speed: 1500,
                // effect : 'cube',
                fadeEffect: {
                    crossFade: true,
                },
                autoplay: {
                    delay: 3000,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
    </script>
@endsection
