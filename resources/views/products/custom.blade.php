@extends('layouts.app')
@section('content')
    <div class="custom">
        {{-- 价格显示 --}}
        <div class="custom-top">
            <div class="custom-price" data-price="{{ get_current_price($product->price) }}">
                <span>{{ get_global_symbol() }}</span>
                <span class="custom-price-num">{{ get_current_price($product->price) }}</span>
            </div>
        </div>
        {{--标题--}}
        <div class="custom-title">
            <div class="custom-title-left">
                <a href="{{ route('seo_url', ['slug' => $product->slug]) }}" class="back-to-product">
                    <i class="iconfont">&#xe603;</i> BACK TO PRODUCT: <span> Custom a New System</span>
                </a>
            </div>
            <div class="custom-title-center">
                <ul>
                    {{-- @foreach($custom_attr_types as $key => $custom_attr_type) --}}
                    {{-- <li class="{{ $key == 0 ? 'active' : '' }}" > --}}
                    {{--不同的href值对应相同id值得模块--}}
                    {{--这个标号用序号表示，方便js用来计数--}}
                    {{-- <a data-href="#tab-{{ $custom_attr_type }}" href="javascript:void (0)"> --}}
                    {{-- 这个标号无意义，仅是用来页面显示区分用 --}}
                    {{-- <span>{{ $custom_attr_type }}</span> --}}
                    {{-- </a> --}}
                    {{-- </li> --}}
                    {{-- @endforeach --}}
                    <li class="active">
                        <a data-href="#tab-SERVICE" href="javascript:void (0)">
                            <span>SERVICE</span>
                        </a>
                    </li>
                    <li class="">
                        <a data-href="#tab-BASE" href="javascript:void (0)">
                            <span>BASE</span>
                        </a>
                    </li>
                    <li class="">
                        <a data-href="#tab-HAIR" href="javascript:void (0)">
                            <span>HAIR</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="custom-title-right">
                <button class="previous">PREVIOUS</button>
                <button class="next">NEXT</button>
                <button class="addtocart">ADD TO CART</button>
            </div>
        </div>
        {{--内容--}}
        <div class="customizations-content">
            {{-- 商品默认图片 --}}
            <div class="customizations-img">
                <img src="{{ $product->photo_urls[0] }}" alt="lyricalhair.com">
            </div>
            {{--背景--}}
            <div class="customizations-bg"></div>
            {{--内容列表--}}
            <div class="customizations-slide">
                <h3 class="product-title">CUSTOMIZE</h3>
                {{-- @foreach($grouped_custom_attrs as $type => $custom_attrs) --}}
                    {{--不同的href值对应相同id值得模块--}}
                    {{-- <div class="customizations-slide-content {{ $type == $custom_attr_types[0] ? 'active' : '' }}"
                         id="tab-{{ $type }}">
                        <input type="hidden" class="addToCartSuccess" value="{{ route('carts.index') }}">
                        <input type="hidden" value="{{ route('products.custom.store', ['product' => $product->id]) }}"
                               id="addToCartUrl">
                        <ul>
                            @foreach($custom_attrs as $key => $custom_attr)
                                <li class="top-level"> --}}
                                    {{-- 是否为必选项 --}}
                                    {{-- <h6 class="block-title {{ $custom_attr->is_required ? 'required' : '' }}"> --}}
                                        {{--判断该选择项是否为必填,必填为true显示星号--}}
                                        {{-- @if($custom_attr->is_required)
                                            <span class="red iconfont">&#xe613;</span>
                                        @endif --}}
                                        {{--后面的标号为了区分没有实际意义--}}
                                        {{-- <span class="select-title"
                                              title="{{ $custom_attr->name }}">{{ $custom_attr->name }}</span> --}}
                                        {{-- 显示用户已选择额内容 --}}
                                        {{-- <span class="selected-option" title=""></span>
                                        <span class="opener iconfont">&#xe60f;</span>
                                    </h6>
                                    <div class="block-content">
                                        <ul class="block-list" data-url="{{ $custom_attr->photo_url }}">
                                            @foreach($custom_attr->values as $custom_attr_value)
                                                <li class="block-list-level">
                                                    <label>
                                                        <input type="radio" value="{{ $custom_attr_value->id }}"
                                                               name="{{ $custom_attr->name }}"> --}}
                                                        {{--后面的标号为了区分没有实际意义--}}
                                                        {{-- <span class="val-text">{{ $custom_attr_value->value }}</span>
                                                        <span class="price red"
                                                              data-price="{{ get_current_price($custom_attr_value->delta_price) }}">
                                                            @if($custom_attr_value->delta_price != 0)
                                                                <i>{{ get_global_currency() }}</i>
                                                                <i class="price_num">{{ get_current_price($custom_attr_value->delta_price) }}</i>
                                                            @endif
                                                        </span>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach --}}
                {{-- SERVICE模块 --}}
                <div class="customizations-slide-content active" id="tab-SERVICE">
                    <input type="hidden" class="addToCartSuccess" value="https://lyricalhair.com/carts">
                    <input type="hidden" value="https://lyricalhair.com/products/custom/208" id="addToCartUrl">
                    <ul>
                        <li class="top-level">
                            <h6 class="block-title required">
                            <span class="red iconfont"></span>                                       
                                <span class="select-title" title="Production Time">Production Time</span>
                                <span class="selected-option" title="Rush service 4-5 weeks" data-id="90"></span>
                                <span class="opener iconfont"></span>
                            </h6>
                            <div class="block-content" style="display: none;">
                                {{-- 一级菜单 --}}
                                <ul class="block-list" data-url="">
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="90" name="Production Time">
                                            <span class="val-text">Rush service 4-5 weeks</span>
                                            <span class="price red" data-price="50.00"><i>USD</i><i class="price_num">50.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="89" name="Production Time">
                                            <span class="val-text">Regular service 7-8 weeks</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                </ul>
                                {{-- 对应的图片的位置 --}}
                                <div class="block-img">
                                    <img src="https://www.lyricalhair.com/storage/original/201909/HD-0.jpg" alt="lyricalhair.com">
                                </div>
                            </div>
                        </li>
                        <li class="top-level">    
                            <h6 class="block-title required">
                                <span class="red iconfont"></span>                                
                                <span class="select-title" title="Hair Cut">Hair Cut</span>
                                <span class="selected-option" title="Yes,have hair cut-in and styled" data-id="84"></span>
                                <span class="opener iconfont"></span>
                            </h6>
                            <div class="block-content" style="display: none;">
                                {{-- 一级菜单 --}}
                                <ul class="block-list" data-url="">
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="84" name="Hair Cut">
                                            <span class="val-text">Yes,have hair cut-in and styled</span>
                                            <span class="price red" data-price="20.00"><i>USD</i><i class="price_num">20.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="83" name="Hair Cut">
                                            <span class="val-text">No,I will have my hair cut-in and styled by my stylist</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                </ul>
                                {{-- 对应的图片的位置 --}}
                                <div class="block-img">
                                    <img src="https://www.lyricalhair.com/storage/original/201909/HD-0.jpg" alt="lyricalhair.com">
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                {{-- BASE模块 --}}
                <div class="customizations-slide-content" id="tab-BASE">
                    <input type="hidden" class="addToCartSuccess" value="http://joryashop.test/carts">
                    <input type="hidden" value="http://joryashop.test/products/custom/1" id="addToCartUrl">
                    <ul>
                        <li class="top-level">
                            <h6 class="block-title required">
                                <span class="red iconfont"></span>
                                <span class="select-title" title="Base Size">Base Size</span>
                                <span class="selected-option" title=""></span>
                                <span class="opener iconfont"></span>
                            </h6>
                            <div class="block-content">
                                <ul class="block-list" data-url="https://lorempixel.com/640/480/">
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="4" name="Base Size">
                                            <span class="val-text" title="size ≥ 10"x10", or area ≥ 100 square inches">size ≥ 10"x10", or area ≥ 100 square inches</span>
                                            <span class="price red" data-price="14.00"><i>USD</i><i class="price_num">14.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="3" name="Base Size">
                                            <span class="val-text" title='8"x10"&lt; size &lt;10"x10", or 80 square inches&lt; area &lt;100 square inches'>8"x10"&lt; size &lt;10"x10", or 80 square inches&lt; area &lt;100 square inches</span>
                                            <span class="price red" data-price="13.00"><i>USD</i><i class="price_num">13.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="2" name="Base Size">
                                            <span class="val-text">4"x4"≤ size ≤8"x10", or 16 square inches≤ area ≤80 square inches</span>
                                            <span class="price red" data-price="12.00"><i>USD</i><i class="price_num">12.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="1" name="Base Size">
                                            <span class="val-text">size &lt; 4"x4", or area &lt; 16 square inches</span>
                                            <span class="price red" data-price="11.00"><i>USD</i><i class="price_num">11.00</i></span>
                                        </label>
                                    </li>
                                </ul>
                                {{-- 对应的图片的位置 --}}
                                <div class="block-img">
                                    <img src="https://www.lyricalhair.com/storage/original/201909/HD-0.jpg" alt="lyricalhair.com">
                                </div>
                            </div>
                        </li>
                        <li class="top-level">
                            <h6 class="block-title required">
                                <span class="red iconfont"></span>
                                <span class="select-title" title="Base Design">Base Design</span>
                                <span class="selected-option" title=""></span>
                                <span class="opener iconfont"></span>
                            </h6>
                            <div class="block-content">
                                <ul class="block-list" data-url="https://lorempixel.com/640/480/">
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="15" name="Base Design">
                                            <span class="val-text">S7 French lace all over</span>
                                            <span class="price red" data-price="15.00"><i>USD</i><i class="price_num">15.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="14" name="Base Design">
                                            <span class="val-text">S4 Super fine mono with PU perimeter and 1/4" lace front</span>
                                            <span class="price red" data-price="14.00"><i>USD</i><i class="price_num">14.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="13" name="Base Design">
                                            <span class="val-text">S3 Fine mono with PU perimeter</span>
                                            <span class="price red" data-price="13.00"><i>USD</i><i class="price_num">13.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="12" name="Base Design">
                                            <span class="val-text">S2 Fine welded mono lace all over</span>
                                            <span class="price red" data-price="12.00"><i>USD</i><i class="price_num">12.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="11" name="Base Design">
                                            <span class="val-text">S16 Integration base with skin perimeter</span>
                                            <span class="price red" data-price="11.00"><i>USD</i><i class="price_num">11.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="10" name="Base Design">
                                            <span class="val-text">S15 Thin skin with 1/4" French lace front</span>
                                            <span class="price red" data-price="16.00"><i>USD</i><i class="price_num">16.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="9" name="Base Design">
                                            <span class="val-text">S13 French lace with PU perimeter</span>
                                            <span class="price red" data-price="15.00"><i>USD</i><i class="price_num">15.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="8" name="Base Design">
                                            <span class="val-text">S12 Thin skin with mono lace front( zig zag connection)</span>
                                            <span class="price red" data-price="14.00"><i>USD</i><i class="price_num">14.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="7" name="Base Design">
                                            <span class="val-text">S1 Thin skin all over</span>
                                            <span class="price red" data-price="13.00"><i>USD</i><i class="price_num">13.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="6" name="Base Design">
                                            <span class="val-text">L16 Fine welded mono with PU edge on sides &amp; back</span>
                                            <span class="price red" data-price="12.00"><i>USD</i><i class="price_num">12.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="5" name="Base Design">
                                            <span class="val-text">L15 French lace with PU edge on sides &amp; back</span>
                                            <span class="price red" data-price="11.00"><i>USD</i><i class="price_num">11.00</i></span>
                                        </label>
                                    </li>
                                </ul>
                                {{-- 对应的图片的位置 --}}
                                <div class="block-img">
                                    <img src="https://www.lyricalhair.com/storage/original/201909/HD-0.jpg" alt="lyricalhair.com">
                                </div>
                            </div>
                        </li>
                        <li class="top-level">
                            <h6 class="block-title required">
                                <span class="red iconfont"></span>
                                <span class="select-title" title="Base Material Color">Base Material Color</span>
                                <span class="selected-option" title=""></span>
                                <span class="opener iconfont"></span>
                            </h6>
                            <div class="block-content">
                                <ul class="block-list" data-url="https://lorempixel.com/640/480/">
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="19" name="Base Material Color">
                                            <span class="val-text">Black</span>
                                            <span class="price red" data-price="14.00"><i>USD</i><i class="price_num">14.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="18" name="Base Material Color">
                                            <span class="val-text">Brown</span>
                                            <span class="price red" data-price="13.00"><i>USD</i><i class="price_num">13.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="17" name="Base Material Color">
                                            <span class="val-text">Light Brown</span>
                                            <span class="price red" data-price="12.00"><i>USD</i><i class="price_num">12.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="16" name="Base Material Color">
                                            <span class="val-text">Flesh</span>
                                            <span class="price red" data-price="11.00"><i>USD</i><i class="price_num">11.00</i></span>
                                        </label>
                                    </li>
                                </ul>
                                {{-- 对应的图片的位置 --}}
                                <div class="block-img">
                                    <img src="https://www.lyricalhair.com/storage/original/201909/HD-0.jpg" alt="lyricalhair.com">
                                </div>
                            </div>
                        </li>
                        <li class="top-level">
                            <h6 class="block-title required">
                                <span class="red iconfont">&#xe613;</span>
                                <span class="select-title" title="Scallop Front">Scallop Front</span>
                                <span class="selected-option" title=""></span>
                                <span class="opener iconfont">&#xe60f;</span>
                            </h6>
                            <div class="block-content">
                                <ul class="block-list" data-url="https://lorempixel.com/640/480/">
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="29" name="Scallop Front">
                                            <span class="val-text">#6 scallop size</span>
                                            <span class="price red" data-price="16.00"><i>USD</i><i class="price_num">16.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="28" name="Scallop Front">
                                            <span class="val-text">#5 scallop size</span>
                                            <span class="price red" data-price="15.00"><i>USD</i><i class="price_num">15.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="27" name="Scallop Front">
                                            <span class="val-text">#4 scallop size</span>
                                            <span class="price red" data-price="14.00"><i>USD</i><i class="price_num">14.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="26" name="Scallop Front">
                                            <span class="val-text">#3 scallop size</span>
                                            <span class="price red" data-price="13.00"><i>USD</i><i class="price_num">13.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="25" name="Scallop Front">
                                            <span class="val-text">#2 scallop size</span>
                                            <span class="price red" data-price="12.00"><i>USD</i><i class="price_num">12.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="24" name="Scallop Front">
                                            <span class="val-text">#1 scallop size</span>
                                            <span class="price red" data-price="11.00"><i>USD</i><i class="price_num">11.00</i></span>
                                        </label>
                                    </li>
                                </ul>
                                {{-- 对应的图片的位置 --}}
                                <div class="block-img">
                                    <img src="https://www.lyricalhair.com/storage/original/201909/HD-0.jpg" alt="lyricalhair.com">
                                </div>
                            </div>
                        </li>
                        <li class="top-level">
                            <h6 class="block-title required">
                                <span class="red iconfont"></span>
                                <span class="select-title" title="Front Contour">Front Contour</span>
                                <span class="selected-option" title=""></span>
                                <span class="opener iconfont"></span>
                            </h6>
                            <div class="block-content">
                                <ul class="block-list" data-url="https://lorempixel.com/640/480/">
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="23" name="Front Contour">
                                            <span class="val-text">C(nearly straight shape)</span>
                                            <span class="price red" data-price="14.00"><i>USD</i><i class="price_num">14.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="22" name="Front Contour">
                                            <span class="val-text">CC (round shape)</span>
                                            <span class="price red" data-price="13.00"><i>USD</i><i class="price_num">13.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="21" name="Front Contour">
                                            <span class="val-text">A (between AA and CC)</span>
                                            <span class="price red" data-price="12.00"><i>USD</i><i class="price_num">12.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="20" name="Front Contour">
                                            <span class="val-text">AA (V peak shape)</span>
                                            <span class="price red" data-price="11.00"><i>USD</i><i class="price_num">11.00</i></span>
                                        </label>
                                    </li>
                                </ul>
                                {{-- 对应的图片的位置 --}}
                                <div class="block-img">
                                    <img src="https://www.lyricalhair.com/storage/original/201909/HD-0.jpg" alt="lyricalhair.com">
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                {{-- hair模块 --}}
                <div class="customizations-slide-content" id="tab-HAIR">
                    <input type="hidden" class="addToCartSuccess" value="https://lyricalhair.com/carts">
                    <input type="hidden" value="https://lyricalhair.com/products/custom/208" id="addToCartUrl">
                    <ul>
                        <li class="top-level">
                            <h6 class="block-title required">
                                <span class="red iconfont"></span>                            
                                <span class="select-title" title="Hair Direction">Hair Direction</span>
                                <span class="selected-option" title=""></span>
                                <span class="opener iconfont"></span>
                            </h6>
                            <div class="block-content">
                                {{-- 一级菜单 --}}
                                <ul class="block-list" data-url="">
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="59" name="Hair Direction">
                                            <span class="val-text">Forward Pompadour</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="58" name="Hair Direction">
                                            <span class="val-text">Center crown</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="57" name="Hair Direction">
                                            <span class="val-text">Right crown</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="56" name="Hair Direction">
                                            <span class="val-text">Left crown</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="53" name="Hair Direction">
                                            <span class="val-text">Center part</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="52" name="Hair Direction">
                                            <span class="val-text">Right part</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="51" name="Hair Direction">
                                            <span class="val-text">Left part</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="50" name="Hair Direction">
                                            
                                            <span class="val-text">Free style</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="102" name="Hair Direction">
                                            <span class="val-text">Backward Pompadour</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                </ul>
                                {{-- 对应的图片的位置 --}}
                                <div class="block-img">
                                    <img src="https://www.lyricalhair.com/storage/original/201909/HD-0.jpg" alt="lyricalhair.com">
                                </div>
                            </div>
                        </li>
                        <li class="top-level">
                            <h6 class="block-title required">
                                <span class="red iconfont"></span>                                      
                                <span class="select-title" title="Curl &amp; Wave">Curl &amp; Wave</span>
                                <span class="selected-option" title=""></span>
                                <span class="opener iconfont"></span>
                            </h6>
                            <div class="block-content">
                                {{-- 一级菜单 --}}
                                <ul class="block-list" data-url="">
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="149" name="Curl &amp; Wave">
                                            <span class="val-text">Same as the hair sample I'll send in</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="125" name="Curl &amp; Wave">
                                            <span class="val-text">Same as My Last Order</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="119" name="Curl &amp; Wave">
                                            <span class="val-text">very straight</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="36" name="Curl &amp; Wave">
                                            <span class="val-text">40mm natural straight</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="37" name="Curl &amp; Wave">
                                            <span class="val-text">36mm body wave</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="38" name="Curl &amp; Wave">
                                            <span class="val-text">32mm slight wave</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="39" name="Curl &amp; Wave">
                                            <span class="val-text">25mm medium wave</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="40" name="Curl &amp; Wave">
                                            <span class="val-text">19mm tight wave</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="41" name="Curl &amp; Wave">
                                            <span class="val-text">15mm loose wave</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="42" name="Curl &amp; Wave">
                                            <span class="val-text">10mm tight curl</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="43" name="Curl &amp; Wave">
                                            <span class="val-text">4mm medium Afro</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                </ul>
                                {{-- 对应的图片的位置 --}}
                                <div class="block-img">
                                    <img src="https://www.lyricalhair.com/storage/original/201909/HD-0.jpg" alt="lyricalhair.com">
                                </div>
                            </div>
                        </li>
                        <li class="top-level">
                            <h6 class="block-title required">
                                <span class="red iconfont"></span>           
                                <span class="select-title" title="Hair Density">Hair Density</span>
                                <span class="selected-option" title=""></span>
                                <span class="opener iconfont"></span>
                            </h6>
                            <div class="block-content">
                                {{-- 一级 --}}
                                <ul class="block-list" data-url="https://www.lyricalhair.com/storage/original/201909/HD-0.jpg">
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="44" name="Hair Density">
                                            <span class="val-text">Extra Light--60%</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="45" name="Hair Density">
                                            <span class="val-text">Light--80%</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="46" name="Hair Density">
                                            <span class="val-text">Light Medium--100%</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="127" name="Hair Density">
                                            <span class="val-text">Light Medium to Medium--115%</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="47" name="Hair Density">
                                            <span class="val-text">Medium--130%</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="48" name="Hair Density">
                                            <span class="val-text">Medium Heavy--150%</span>
                                            <span class="price red" data-price="15.00"><i>USD</i><i class="price_num">15.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="49" name="Hair Density">
                                            <span class="val-text">Heavy--180%</span>
                                            <span class="price red" data-price="30.00"><i>USD</i><i class="price_num">30.00</i></span>
                                        </label>
                                    </li>
                                </ul>
                                {{-- 对应的图片的位置 --}}
                                <div class="block-img">
                                    <img src="https://www.lyricalhair.com/storage/original/201909/HD-0.jpg" alt="lyricalhair.com">
                                </div>
                            </div>
                        </li>
                        <li class="top-level">
                            <h6 class="block-title required">
                                <span class="red iconfont"></span>                                        
                                <span class="select-title" title="Hair Length">Hair Length</span>
                                <span class="selected-option" title=""></span>
                                <span class="opener iconfont"></span>
                            </h6>
                            <div class="block-content">
                                {{-- 一级 --}}
                                <ul class="block-list" data-url="">
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="30" name="Hair Length">
                                            <span class="val-text">4 Inch</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="31" name="Hair Length">
                                            <span class="val-text">6 Inch</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="32" name="Hair Length">
                                            <span class="val-text">8 Inch</span>
                                            <span class="price red" data-price="80.00"><i>USD</i><i class="price_num">80.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="33" name="Hair Length">
                                            <span class="val-text">10 Inch</span>
                                            <span class="price red" data-price="105.00"><i>USD</i><i class="price_num">105.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="34" name="Hair Length">
                                            <span class="val-text">12 Inch</span>
                                            <span class="price red" data-price="130.00"><i>USD</i><i class="price_num">130.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="35" name="Hair Length">
                                            <span class="val-text">14 Inch</span>
                                            <span class="price red" data-price="160.00"><i>USD</i><i class="price_num">160.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="103" name="Hair Length">
                                            <span class="val-text">16 inch</span>
                                            <span class="price red" data-price="200.00"><i>USD</i><i class="price_num">200.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="104" name="Hair Length">
                                            <span class="val-text">18 inch</span>
                                            <span class="price red" data-price="240.00"><i>USD</i><i class="price_num">240.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="105" name="Hair Length">
                                            <span class="val-text">20 inch</span>
                                            <span class="price red" data-price="280.00"><i>USD</i><i class="price_num">280.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="106" name="Hair Length">
                                            <span class="val-text">22 inch</span>
                                            <span class="price red" data-price="320.00"><i>USD</i><i class="price_num">320.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="107" name="Hair Length">
                                            <span class="val-text">24''</span>
                                            <span class="price red" data-price="360.00"><i>USD</i><i class="price_num">360.00</i></span>
                                        </label>
                                    </li>
                                </ul>
                                 {{-- 对应的图片的位置 --}}
                                <div class="block-img">
                                    <img src="https://www.lyricalhair.com/storage/original/201909/HD-0.jpg" alt="lyricalhair.com">
                                </div>
                            </div>
                        </li>
                        <li class="top-level hair-color-tip">
                            <h6 class="block-title required">
                                <span class="red iconfont"></span>           
                                <span class="select-title" title="Hair Color">Hair Color</span>
                                <span class="selected-option hairColorOption" title=""></span>
                                <span class="opener iconfont"></span>
                            </h6>
                            <div class="block-content">
                                {{-- 一级 --}}
                                <ul class="block-list" data-url="">
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="99" name="Hair Color">
                                            <span class="val-text">Match the sample I'll send in(Recommended)</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="60" name="Hair Color">
                                            <span class="val-text">I'll send in an old system as sample</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="61" name="Hair Color">
                                            <span class="val-text">Use my sample already on file</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="62" name="Hair Color">
                                            <span class="val-text">Use your color code</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input hasChildTwo hairColorNote" value="63" name="Hair Color">
                                            <span class="val-text">please refer to my special instructions</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                        {{-- 二级 --}}
                                        {{-- 发色自定义文本域内容 --}}
                                        <ul class="hair-color-textarea block-list-level-2">
                                            <li>
                                                <textarea class="hair-color-note unrequired" name="Hair Color Additional Instruction" rows="3" cols="80" placeholder="please refer to my special instructions" style="width: 90%;"></textarea>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                 {{-- 对应的图片的位置 --}}
                                <div class="block-img">
                                    <img src="https://www.lyricalhair.com/storage/original/201909/HD-0.jpg" alt="lyricalhair.com">
                                </div>
                            </div>
                        </li>
                        <li class="top-level">
                            <h6 class="block-title required">
                                <span class="red iconfont"></span>           
                                <span class="select-title" title="Hair Type">Hair Type</span>
                                <span class="selected-option" title=""></span>
                                <span class="opener iconfont"></span>
                            </h6>
                            <div class="block-content">
                                {{-- 一级 --}}
                                <ul class="block-list" data-url="">
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="82" name="Hair Type">
                                            <span class="val-text">Synthetic hair</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="81" name="Hair Type">
                                            <span class="val-text">Chinese hair (coarse, good for extremely straight)</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="80" name="Hair Type">
                                            <span class="val-text">European hair (fine, thin &amp; soft, 7" and up is not available)</span>
                                            <span class="price red" data-price="70.00"><i>USD</i><i class="price_num">70.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="79" name="Hair Type">
                                            <span class="val-text">Indian human hair</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="78" name="Hair Type">
                                            <span class="val-text">Remy hair (best)</span>
                                            <span class="price red" data-price="20.00"><i>USD</i><i class="price_num">20.00</i></span>
                                        </label>
                                    </li>
                                </ul>
                                {{-- 对应的图片的位置 --}}
                                <div class="block-img">
                                    <img src="https://www.lyricalhair.com/storage/original/201909/HD-0.jpg" alt="lyricalhair.com">
                                </div>
                            </div>
                        </li>
                        <li class="top-level">
                            <h6 class="block-title required">
                                <span class="red iconfont"></span>           
                                <span class="select-title" title="Grey Hair">Grey Hair</span>
                                <span class="selected-option" title=""></span>
                                <span class="opener iconfont"></span>
                            </h6>
                            <div class="block-content">
                                {{-- 一级 --}}
                                <ul class="block-list multilevel-menu" data-url="">
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="69" name="Grey Hair">
                                            <span class="val-text">No need grey hair</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input hasChildTwo" value="68" name="Grey Hair">
                                            <span class="val-text Choose-grey-hair-text">I want grey hair</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                        {{-- 二级菜单 --}}
                                        {{-- 发色自定义文本域内容 --}}
                                        <ul class="block-list-level-2">
                                            <li>
                                                <p>Choose grey hair type</p>
                                                <ul>
                                                    <li>
                                                        <label>
                                                            <input type="radio" class="block-list-level2-input" value="69" name="Choose Grey Hair Type">
                                                            <span class="val-text">Human grey hair</span>
                                                            <span class="price red" data-price="20.00"><i>USD</i><i class="price_num">20.00</i></span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="radio" class="block-list-level2-input" value="69" name="Choose Grey Hair Type">
                                                            <span class="val-text">Synthetic grey hair (best choice)</span>
                                                            <span class="price red" data-price="0"></span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="radio" class="block-list-level2-input" value="69" name="Choose Grey Hair Type">
                                                            <span class="val-text">Yak (similar to human but thicker and shinny)</span>
                                                            <span class="price red" data-price="0"></span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <p>How much grey hair do you need?</p>
                                                <ul>
                                                    <li>
                                                        <label>
                                                            <input type="radio" class="block-list-level2-input" value="69" name="Need Grey Hair Type">
                                                            <span class="val-text">The same as the old unit I′ll send in</span>
                                                            <span class="price red" data-price="0"></span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="radio" class="block-list-level2-input" value="69" name="Need Grey Hair Type">
                                                            <span class="val-text">Same grey percentage as hair sample I′ll send in</span>
                                                            <span class="price red" data-price="0"></span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="radio" class="block-list-level2-input" value="69" name="Need Grey Hair Type">
                                                            <span class="val-text">Use my sample already on file</span>
                                                            <span class="price red" data-price="0"></span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="radio" class="block-list-level2-input" value="69" name="Need Grey Hair Type">
                                                            <span class="val-text">Same as my last order</span>
                                                            <span class="price red" data-price="0"></span>
                                                        </label>
                                                    </li>
                                                    <li class="Customize-percentage">
                                                        <label>
                                                            <input type="radio" class="block-list-level2-input hasChild Customize-percentage" value="69" name="Need Grey Hair Type">
                                                            <span class="val-text">Customize my grey distribution and percentage</span>
                                                            <span class="price red" data-price="0"></span>
                                                        </label>
                                                        {{-- 三级菜单 --}}
                                                        <ul class="block-list-level-3 select-groups">
                                                            <li>
                                                                <span>1.Front</span>
                                                                <select name="Front">
                                                                    <option value="0%">0%</option>
                                                                    <option value="5%">5%</option>
                                                                    <option value="10%">10%</option>
                                                                    <option value="15%">15%</option>
                                                                    <option value="20%">20%</option>
                                                                    <option value="25%">25%</option>
                                                                    <option value="30%">30%</option>
                                                                    <option value="35%">35%</option>
                                                                    <option value="40%">40%</option>
                                                                    <option value="45%">45%</option>
                                                                    <option value="50%">50%</option>
                                                                    <option value="55%">55%</option>
                                                                    <option value="60%">60%</option>
                                                                    <option value="65%">65%</option>
                                                                    <option value="70%">70%</option>
                                                                    <option value="75%">75%</option>
                                                                    <option value="80%">80%</option>
                                                                    <option value="85%">85%</option>
                                                                    <option value="90%">90%</option>
                                                                    <option value="95%">95%</option>
                                                                    <option value="100%">100%</option>
                                                                </select>
                                                            </li>
                                                            <li>
                                                                <span>2.Top</span>
                                                                <select name="Top">
                                                                    <option value="0%">0%</option>
                                                                    <option value="5%">5%</option>
                                                                    <option value="10%">10%</option>
                                                                    <option value="15%">15%</option>
                                                                    <option value="20%">20%</option>
                                                                    <option value="25%">25%</option>
                                                                    <option value="30%">30%</option>
                                                                    <option value="35%">35%</option>
                                                                    <option value="40%">40%</option>
                                                                    <option value="45%">45%</option>
                                                                    <option value="50%">50%</option>
                                                                    <option value="55%">55%</option>
                                                                    <option value="60%">60%</option>
                                                                    <option value="65%">65%</option>
                                                                    <option value="70%">70%</option>
                                                                    <option value="75%">75%</option>
                                                                    <option value="80%">80%</option>
                                                                    <option value="85%">85%</option>
                                                                    <option value="90%">90%</option>
                                                                    <option value="95%">95%</option>
                                                                    <option value="100%">100%</option>
                                                                </select>
                                                            </li>
                                                            <li>
                                                                <span>3.Crown</span>
                                                                <select name="Crown">
                                                                    <option value="0%">0%</option>
                                                                    <option value="5%">5%</option>
                                                                    <option value="10%">10%</option>
                                                                    <option value="15%">15%</option>
                                                                    <option value="20%">20%</option>
                                                                    <option value="25%">25%</option>
                                                                    <option value="30%">30%</option>
                                                                    <option value="35%">35%</option>
                                                                    <option value="40%">40%</option>
                                                                    <option value="45%">45%</option>
                                                                    <option value="50%">50%</option>
                                                                    <option value="55%">55%</option>
                                                                    <option value="60%">60%</option>
                                                                    <option value="65%">65%</option>
                                                                    <option value="70%">70%</option>
                                                                    <option value="75%">75%</option>
                                                                    <option value="80%">80%</option>
                                                                    <option value="85%">85%</option>
                                                                    <option value="90%">90%</option>
                                                                    <option value="95%">95%</option>
                                                                    <option value="100%">100%</option>
                                                                </select>
                                                            </li>
                                                            <li>
                                                                <span>4.Back</span>
                                                                <select name="Back">
                                                                    <option value="0%">0%</option>
                                                                    <option value="5%">5%</option>
                                                                    <option value="10%">10%</option>
                                                                    <option value="15%">15%</option>
                                                                    <option value="20%">20%</option>
                                                                    <option value="25%">25%</option>
                                                                    <option value="30%">30%</option>
                                                                    <option value="35%">35%</option>
                                                                    <option value="40%">40%</option>
                                                                    <option value="45%">45%</option>
                                                                    <option value="50%">50%</option>
                                                                    <option value="55%">55%</option>
                                                                    <option value="60%">60%</option>
                                                                    <option value="65%">65%</option>
                                                                    <option value="70%">70%</option>
                                                                    <option value="75%">75%</option>
                                                                    <option value="80%">80%</option>
                                                                    <option value="85%">85%</option>
                                                                    <option value="90%">90%</option>
                                                                    <option value="95%">95%</option>
                                                                    <option value="100%">100%</option>
                                                                </select>
                                                            </li>
                                                            <li>
                                                                <span>5,6.Temples</span>
                                                                <select name="Temples">
                                                                    <option value="0%">0%</option>
                                                                    <option value="5%">5%</option>
                                                                    <option value="10%">10%</option>
                                                                    <option value="15%">15%</option>
                                                                    <option value="20%">20%</option>
                                                                    <option value="25%">25%</option>
                                                                    <option value="30%">30%</option>
                                                                    <option value="35%">35%</option>
                                                                    <option value="40%">40%</option>
                                                                    <option value="45%">45%</option>
                                                                    <option value="50%">50%</option>
                                                                    <option value="55%">55%</option>
                                                                    <option value="60%">60%</option>
                                                                    <option value="65%">65%</option>
                                                                    <option value="70%">70%</option>
                                                                    <option value="75%">75%</option>
                                                                    <option value="80%">80%</option>
                                                                    <option value="85%">85%</option>
                                                                    <option value="90%">90%</option>
                                                                    <option value="95%">95%</option>
                                                                    <option value="100%">100%</option>
                                                                </select>
                                                            </li>
                                                            <li>
                                                                <span>7,8.Sides</span>
                                                                <select name="Sides">
                                                                    <option value="0%">0%</option>
                                                                    <option value="5%">5%</option>
                                                                    <option value="10%">10%</option>
                                                                    <option value="15%">15%</option>
                                                                    <option value="20%">20%</option>
                                                                    <option value="25%">25%</option>
                                                                    <option value="30%">30%</option>
                                                                    <option value="35%">35%</option>
                                                                    <option value="40%">40%</option>
                                                                    <option value="45%">45%</option>
                                                                    <option value="50%">50%</option>
                                                                    <option value="55%">55%</option>
                                                                    <option value="60%">60%</option>
                                                                    <option value="65%">65%</option>
                                                                    <option value="70%">70%</option>
                                                                    <option value="75%">75%</option>
                                                                    <option value="80%">80%</option>
                                                                    <option value="85%">85%</option>
                                                                    <option value="90%">90%</option>
                                                                    <option value="95%">95%</option>
                                                                    <option value="100%">100%</option>
                                                                </select>
                                                            </li>
                                                            <li>
                                                                <textarea class="Grey-Hair-Instruction" name="Grey Hair Additional Instruction" rows="3" cols="80" placeholder="Please type in your special instruction." style="width: 100%;"></textarea>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="top-level">
                            <h6 class="block-title required">
                                <span class="red iconfont"></span>           
                                <span class="select-title" title="Highlight">Highlight</span>
                                <span class="selected-option" title=""></span>
                                <span class="opener iconfont"></span>
                            </h6>
                            <div class="block-content">
                                {{-- 一级 --}}
                                <ul class="block-list color-choose-list" data-url="">
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="71" name="Highlight">
                                            <span class="val-text">No need highlights</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input hasChildTwo" value="70" name="Highlight">
                                            <span class="val-text">I want highlights to my hair</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                        {{-- 二级 --}}
                                        <ul class="block-list-level-2 multilevel-menu">
                                            <li>
                                                <label>
                                                    <input type="radio" class="block-list-level2-input" value="69" name="Highlight Type">
                                                    <span class="val-text">Same as the old unit I′ll send in</span>
                                                    <span class="price red" data-price="0"></span>
                                                </label>
                                            </li>
                                            <li>
                                                <label>
                                                    <input type="radio" class="block-list-level2-input" value="69" name="Highlight Type">
                                                    <span class="val-text">Same as my last order</span>
                                                    <span class="price red" data-price="0"></span>
                                                </label>
                                            </li>
                                            <li>
                                                <label>
                                                    <input type="radio" class="block-list-level2-input hasChild customize-highlight" value="69" name="Highlight Type">
                                                    <span class="val-text">I want to customize highlight</span>
                                                    <span class="price red" data-price="0"></span>
                                                </label>
                                                {{-- 三级 --}}
                                                <ul class="block-list-level-3 multilevel-menu Highlight-Color">
                                                    <li>
                                                        <p>Highlight Color</p>
                                                        <ul>
                                                            <li>
                                                                <label>
                                                                    <input type="radio" class="block-list-level3-input" value="69" name="Highlight Color">
                                                                    <span class="val-text">Match the sample I′ll send in</span>
                                                                    <span class="price red" data-price="0"></span>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label>
                                                                    <input type="radio" class="block-list-level3-input" value="69" name="Highlight Color">
                                                                    <span class="val-text">The same as my old unit I′ll send in</span>
                                                                    <span class="price red" data-price="0"></span>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label>
                                                                    <input type="radio" class="block-list-level3-input hasChildThree color-codes" value="69" name="Highlight Color">
                                                                    <span class="val-text">Choose the color code</span>
                                                                    <span class="price red" data-price="0"></span>
                                                                </label>
                                                                {{-- 四级 --}}
                                                                {{-- 颜色选择表 --}}
                                                                <div class="Color-choose-table block-list-level-4">
                                                                    <ul>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#1" name="hairColorChart">
                                                                                <span class="val-text">#1</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#1B" name="hairColorChart">
                                                                                <span class="val-text">#1B</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#1B05" name="hairColorChart">
                                                                                <span class="val-text">#1B05</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#1B10" name="hairColorChart">
                                                                                <span class="val-text">#1B10</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#1B20" name="hairColorChart">
                                                                                <span class="val-text">#1B20</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#1B30" name="hairColorChart">
                                                                                <span class="val-text">#1B40</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#1B50" name="hairColorChart">
                                                                                <span class="val-text">#1B50</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#1B65" name="hairColorChart">
                                                                                <span class="val-text">#1B65</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#1B80" name="hairColorChart">
                                                                                <span class="val-text">#1B80</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#2" name="hairColorChart">
                                                                                <span class="val-text">#2</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#210" name="hairColorChart">
                                                                                <span class="val-text">#210</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#220" name="hairColorChart">
                                                                                <span class="val-text">#220</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#230" name="hairColorChart">
                                                                                <span class="val-text">#230</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#240" name="hairColorChart">
                                                                                <span class="val-text">#240</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#250" name="hairColorChart">
                                                                                <span class="val-text">#250</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#3" name="hairColorChart">
                                                                                <span class="val-text">#3</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#310" name="hairColorChart">
                                                                                <span class="val-text">#310</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#320" name="hairColorChart">
                                                                                <span class="val-text">#320</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#330" name="hairColorChart">
                                                                                <span class="val-text">#330</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#340" name="hairColorChart">
                                                                                <span class="val-text">#340</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#350" name="hairColorChart">
                                                                                <span class="val-text">#350</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#4" name="hairColorChart">
                                                                                <span class="val-text">#4</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#410" name="hairColorChart">
                                                                                <span class="val-text">#410</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#420" name="hairColorChart">
                                                                                <span class="val-text">#420</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#430" name="hairColorChart">
                                                                                <span class="val-text">#430</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#440" name="hairColorChart">
                                                                                <span class="val-text">#440</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#5" name="hairColorChart">
                                                                                <span class="val-text">#5</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#510" name="hairColorChart">
                                                                                <span class="val-text">#510</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#520" name="hairColorChart">
                                                                                <span class="val-text">#520</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#540" name="hairColorChart">
                                                                                <span class="val-text">#540</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#550" name="hairColorChart">
                                                                                <span class="val-text">#550</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#560" name="hairColorChart">
                                                                                <span class="val-text">#560</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#580" name="hairColorChart">
                                                                                <span class="val-text">#580</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#6" name="hairColorChart">
                                                                                <span class="val-text">#6</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#610" name="hairColorChart">
                                                                                <span class="val-text">#610</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#620" name="hairColorChart">
                                                                                <span class="val-text">#620</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#640" name="hairColorChart">
                                                                                <span class="val-text">#640</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#7" name="hairColorChart">
                                                                                <span class="val-text">#7</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#710" name="hairColorChart">
                                                                                <span class="val-text">#710</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#720" name="hairColorChart">
                                                                                <span class="val-text">#720</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#17" name="hairColorChart">
                                                                                <span class="val-text">#17</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#18" name="hairColorChart">
                                                                                <span class="val-text">#18</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#20" name="hairColorChart">
                                                                                <span class="val-text">#20</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#2020" name="hairColorChart">
                                                                                <span class="val-text">#2020</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#4ASH" name="hairColorChart">
                                                                                <span class="val-text">#4ASH</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#7ASH" name="hairColorChart">
                                                                                <span class="val-text">#7ASH</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#6R" name="hairColorChart">
                                                                                <span class="val-text">#6R</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#12R" name="hairColorChart">
                                                                                <span class="val-text">#12R</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#17R" name="hairColorChart">
                                                                                <span class="val-text">#17R</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#20R" name="hairColorChart">
                                                                                <span class="val-text">#20R</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#22R" name="hairColorChart">
                                                                                <span class="val-text">#22R</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#30R" name="hairColorChart">
                                                                                <span class="val-text">#30R</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" class="block-list-level4-input" value="#60RY" name="hairColorChart">
                                                                                <span class="val-text">#60RY</span>
                                                                                <span class="price red" data-price="0"></span>
                                                                            </label>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="percentInp">
                                                        <span>Highlight Percentage</span>
                                                        <input type="text" name="hp">
                                                        <span>%</span>
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="radio" class="block-list-level3-input" value="69" name="EvenlySpot">
                                                            <span class="val-text">Evenly Blend</span>
                                                            <span class="price red" data-price="0"></span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="radio" class="block-list-level3-input" value="69" name="EvenlySpot">
                                                            <span class="val-text">Spot/Dot</span>
                                                            <span class="price red" data-price="0"></span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <textarea rows="3" cols="20" style="width: 100%" class="Highlight-Instruction" name="Highlight Additional Instruction" placeholder="Please type in your special instruction."></textarea>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="top-level">
                            <h6 class="block-title required">
                                <span class="red iconfont"></span>           
                                <span class="select-title" title="Bleached Knot">Bleached Knot</span>
                                <span class="selected-option" title=""></span>
                                <span class="opener iconfont"></span>
                            </h6>
                            <div class="block-content">
                                <ul class="block-list" data-url="">
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="75" name="Bleached Knot">
                                            <span class="val-text">Bleach knots all over the head</span>
                                            <span class="price red" data-price="14.00"><i>USD</i><i class="price_num">14.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="74" name="Bleached Knot">
                                            <span class="val-text">Bleach knots 1" in front</span>
                                            <span class="price red" data-price="13.00"><i>USD</i><i class="price_num">13.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="73" name="Bleached Knot">
                                            <span class="val-text">Bleach knots 1/2" in front</span>
                                            <span class="price red" data-price="10.00"><i>USD</i><i class="price_num">10.00</i></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="72" name="Bleached Knot">
                                            <span class="val-text">No bleached knot</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="top-level">
                            <h6 class="block-title required">
                                <span class="red iconfont"></span>           
                                <span class="select-title" title="Under Knotting">Under Knotting</span>
                                <span class="selected-option" title=""></span>
                                <span class="opener iconfont"></span>
                            </h6>
                            <div class="block-content">
                                <ul class="block-list" data-url="">
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="128" name="Under Knotting">
                                            <span class="val-text">Yes, 1 line in front</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="129" name="Under Knotting">
                                            <span class="val-text">Yes,2 lines in front</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="130" name="Under Knotting">
                                            <span class="val-text">Yes,1 line all around</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="131" name="Under Knotting">
                                            <span class="val-text">Yes, 2 lines all around</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="132" name="Under Knotting">
                                            <span class="val-text">No Underknotting</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="top-level">
                            <h6 class="block-title">                    
                                <span class="select-title" title="Baby Hair">Baby Hair</span>
                                <span class="selected-option" title=""></span>
                                <span class="opener iconfont"></span>
                            </h6>
                            <div class="block-content">
                                <ul class="block-list" data-url="">
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="133" name="Baby Hair">
                                            <span class="val-text">Yes, baby hair in front</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                    <li class="block-list-level">
                                        <label>
                                            <input type="radio" class="block-list-level-input" value="134" name="Baby Hair">
                                            <span class="val-text">No babyhair</span>
                                            <span class="price red" data-price="0"></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptsAfterJs')
    <script type="text/javascript">
        // {{-- 验证当前选项卡的必选项是否已经全部被选中 --}}
        function isALLChoosed(domId) {
        var notSelect = true;
        // domId是当前活跃的选项卡的ID
        // 当前dom节点面板下的所有必填项的集合
        var requiredAll = $(domId).find(".required");
        $.each(requiredAll, function (i, n) {
            if ($(n).find(".selected-option").html() == "") {
                notSelect = false
                return notSelect;
            }
        });
        // 判断是否填写完成如果填写完成这再次点击此选项卡时不需要判断当前页面是否已经填写完成
        if (notSelect == true) {
            $(".custom-title-center").find("a[data-href='" + domId + "']").addClass("Completed");
        }
        return notSelect;
        }
        // {{-- 点击选项卡切换对应的页面内容 --}}
        $(".custom-title-center").on("click", "a", function () {
        var _that = $(this);
        //  页面切换的时候进行验证，验证用户是否已选择了所有的必选项,如果已经选择了则进行下一步，如果不可以则提示
        var nowactiveDom = $(".custom-title-center").find("li.active").find("a").attr("data-href"), // 当前活跃的选项卡的ID
            activeDom = $(this).attr("data-href"); // 即将要切换到的选项卡的ID
        var getResult = isALLChoosed(nowactiveDom);
        if ($(this).hasClass("Completed") != true) {
            //    如果点击的选项卡不存在已完成的clas则需要判断当前页面是否已经填写完成，
            //    如果包含已经完成的标志，则直接跳转即可
            if (getResult == false) {
                layer.alert("Please make sure that you have set every REQUIRED custom attribute");
                return;
            }
            // else {
            // //    如果当前页面的所有的必填选项都已经选择完成则所有的选择拼接为一个小字符串
            //     var getCheckedVal = $(nowactiveDom).find(".selected-option");
            //     $.each(getCheckedVal,function (i,n) {
            //         if($(n).text()!=""){
            //             console.log($(n).text());
            //         }
            //     })
            // };
        }
        var total_tabs = $(".custom-title-center").find("li").length;
        var active_num = $(this).parent("li").index();
        $(".custom-title-center").find("li").removeClass("active");
        $(this).parents("li").addClass("active");
        $(".customizations-slide").find(".customizations-slide-content").removeClass("active")
        $(activeDom).addClass("active");
        // 判断当前页是否是第一页，如果不是第一页则上一页按钮不显示
        if (active_num != 0) {
            $(".previous").css("display", "inline-block");
            $(".next").css("display", "inline-block");
            $(".addtocart").css("display", "none");
        }
        if (active_num == total_tabs - 1) {
            // 添加购物车按钮显示
            $(".addtocart").css("display", "inline-block");
            $(".next").css("display", "none");
        }
        })
        ;
        // 点击下一页按钮
        $(".next").on("click", function () {
            var index_active = $(".custom-title-center").find("li.active").index() + 1;
            var choose_index_arr = $(".custom-title-center").find("li");
            var activeDom = $(".custom-title-center").find("li.active").find("a").attr("data-href");
            var getResult = isALLChoosed(activeDom);
            if (getResult == false) {
                layer.alert("Please make sure that you have set every REQUIRED custom attribute");
                return;
            }
            $(".custom-title-center").find("li").removeClass("active");
            if (index_active == 1) {
                $(".previous").css("display", "inline-block");
                $(".next").css("display", "inline-block");
                $(".addtocart").css("display", "none");
            }
            if (index_active == choose_index_arr.length - 1) {
                $(this).css("display", "none");
                $(".addtocart").css("display", "inline-block");
            }
            $.each(choose_index_arr, function (i, n) {
                if (i == index_active) {
                    $(n).addClass("active");
                    var activeDomNext = $(n).find("a").attr("data-href");
                    $(".customizations-slide").find(".customizations-slide-content").removeClass("active");
                    $(activeDomNext).addClass("active");
                }
            });
        });
        // 点击上一页按钮
        $(".previous").on("click", function () {
            var index_active_pre = $(".custom-title-center").find("li.active").index() - 1;
            var choose_index_arr_pre = $(".custom-title-center").find("li");
            $(".custom-title-center").find("li").removeClass("active");
            if (index_active_pre == 0) {
                $(".previous").css("display", "none");
                $(".next").css("display", "inline-block");
                $(".addtocart").css("display", "none");
            }
            if (index_active_pre != choose_index_arr_pre.length - 3) {
                $(".addtocart").css("display", "none");
                $(".next").css("display", "inline-block");
            }
            $.each(choose_index_arr_pre, function (i, n) {
                if (i == index_active_pre) {
                    $(n).addClass("active");
                    var activeDomNext_pre = $(n).find("a").attr("data-href");
                    $(".customizations-slide").find(".customizations-slide-content").removeClass("active");
                    $(activeDomNext_pre).addClass("active");
                }
            })
        });
        // 点击添加到购物车
        var dataString = {};  // 用于存储数据提交的字符串
        $(".addtocart").on("click", function () {
            // 点击添加到购物车同时判断最后一页的内容中的必选项是否已经选择完成
            var index_active = $(".custom-title-center").find("li.active").index() + 1;
            var choose_index_arr = $(".custom-title-center").find("li");
            var activeDom = $(".custom-title-center").find("li.active").find("a").attr("data-href");
            var getResult = isALLChoosed(activeDom);
            if (getResult == false) {
                layer.alert("Please select the required option!!");
                return;
            }
            // var getCheckedVal = $(".customizations-slide").find(".selected-option");
            var getCheckedVal = $(".customizations-slide").find(".block-title");
            $.each(getCheckedVal, function (i, n) {
                if ($(n).text() != "") {
                    // dataString += $(n).attr("data-id") + ","
                    dataString[$(n).find(".select-title").text()] = $(n).find(".selected-option").text()
                }
            });
            // dataString = dataString.substring(0, dataString.length - 1);
            // 对特殊多选情况进行判断
            // Hair Color   Hair Color
            // Grey Hair 判断选中的内容是否为Customize my grey distribution and percentage
            // 判断Grey Hair的选择结果
            var GHairFirstChoose = $("input[name='Grey Hair']:checked").hasClass("hasChildTwo");  // 判断是否有子菜单，如果有子菜单进行下一类判断
            if(GHairFirstChoose){
                // 有子菜单
                dataString["Grey Hair"] = "I want grey hair";
                dataString["Grey Hair Type"] = $("input[name='Choose Grey Hair Type']:checked").parents("label").find(".val-text").text();
                var GhairSecondChoose = $("input[name='Need Grey Hair Type']:checked").hasClass("Customize-percentage");
                if(GhairSecondChoose){
                    dataString["Grey Hair Need"] = $("input[name='Need Grey Hair Type']:checked").parents("label").find(".val-text").text();
                    dataString["Grey Hair Need Front"] = $("select[name='Front']").val();
                    dataString["Grey Hair Need Top"] = $("select[name='Top']").val();
                    dataString["Grey Hair Need Crown"] = $("select[name='Crown']").val();
                    dataString["Grey Hair Need Back"] = $("select[name='Back']").val();
                    dataString["Grey Hair Need Temples"] = $("select[name='Temples']").val();
                    dataString["Grey Hair Need Sides"] = $("select[name='Sides']").val();
                    dataString["Grey Hair Need Note"] = $(".Highlight-Instruction").val();
                }else {
                    dataString["Grey Hair Need"] = $("input[name='Need Grey Hair Type']:checked").parents("label").find(".val-text").text();
                }
                
            }else {
                // 没有子菜单
                dataString["Grey Hair"] = "No need grey hair";
            }
            // Highlight 判断选中的内容是否为 I want to customize highlight和Choose the color code
            var HighlightFirstChoose = $("input[name='Highlight']:checked").hasClass("hasChildTwo");  // 判断是否有子菜单，如果有子菜单进行下一类判断
            if(HighlightFirstChoose){
                // 有子菜单
                dataString["Highlight"] = "I want highlights to my hair";
                var HighlightSecondChoose = $("input[name='Highlight Type']:checked").hasClass("customize-highlight");
                if(HighlightSecondChoose){
                    dataString["Highlight Type"] = "I want to customize highlight";
                    var HighlightthreeChoose = $("input[name='Highlight Color']:checked").hasClass("color-codes");
                    if(HighlightthreeChoose) {
                        dataString["Highlight Color"] = "Choose the color code"
                        dataString["hairColorChart"] = $("input[name='hairColorChart']:checked").parents("label").find(".val-text").text()
                    }else {
                        dataString["Highlight Color"] = $("input[name='Highlight Color']:checked").parents("label").find(".val-text").text();
                    }
                    dataString["Highlight Percentage"] = $("input[name='hp']").val();
                    dataString["EvenlySpot"] = $("input[name='EvenlySpot']:checked").parents("label").find(".val-text").text();
                    dataString["Highlight Note"] = $("input[name='EvenlySpot']:checked").parents("label").find(".val-text").text();

                }else {
                    dataString["Highlight Type"] = $("input[name='Highlight Type']:checked").parents("label").find(".val-text").text();
                }
            }else {
                // 没有子菜单
                dataString["Highlight"] = "No need highlights";
            }
            console.log(dataString)
            var data = {
                _token: "{{ csrf_token() }}",
                custom_attr_value_ids: dataString
            };
            $.ajax({
                type: "post",
                url: $("#addToCartUrl").val(),
                data: data,
                success: function (data) {
                    window.location.href = $(".addToCartSuccess").val();
                },
                error: function (err) {
                    if (err.status == 422) {
                        var exception = err.responseJSON.exception;
                        if (exception) {
                            layer.msg(exception.message);
                        }
                        var arr = [];
                        var errors = err.responseJSON.errors;
                        for (let i in errors) {
                            arr.push(errors[i]); //属性
                        }
                        layer.msg(arr[0][0]);
                    }
                },
            });
        });

        //数据计算方法
        function float_multiply_by_100(float) {
            float = String(float);
            // float = float.toString();
            var index_of_dec_point = float.indexOf('.');
            if (index_of_dec_point == -1) {
                float += '00';
            } else {
                var float_splitted = float.split('.');
                var dec_length = float_splitted[1].length;
                if (dec_length == 1) {
                    float_splitted[1] += '0';
                } else if (dec_length > 2) {
                    float_splitted[1] = float_splitted[1].substring(0, 1);
                }
                float = float_splitted.join('');
            }
            return Number(float);
        }

        function js_number_format(number) {
            number = String(number);
            var index_of_dec_point = number.indexOf('.');
            if (index_of_dec_point == -1) {
                number += '.00';
            } else {
                var number_splitted = number.split('.');
                var dec_length = number_splitted[1].length;
                if (dec_length == 1) {
                    number += '0';
                } else if (dec_length > 2) {
                    number_splitted[1] = number_splitted[1].substring(0, 2);
                    number = number_splitted.join('.');
                }
            }
            return number;
        }

        // {{--点击title出现一级列表--}}
        $(".customizations-slide").on("click", ".block-title", function () {
        var img_url_default = "{{ $product->photo_urls[0] }}";
        var img_url = $(this).parents(".top-level").find(".block-list").attr("data-url");
        var isOpened = $(this).hasClass("opened");
        if (isOpened) {
            $(this).removeClass("opened");
            $(".customizations-slide").find(".block-content").slideUp();
            $(".customizations-img").find("img").prop("src", img_url_default);
        } else {
            $(".customizations-slide").find(".block-title").removeClass("opened");
            $(".customizations-slide").find(".block-content").slideUp();
            $(this).addClass("opened");
            $(this).parents("li").find(".block-content").slideDown();
            if (img_url != "") {
                $(".customizations-img").find("img").prop("src", img_url);
            }
        }
        // 对hair color进行特殊处理
        if($(".hairColorOption").text() == ""&&$("#tab-HAIR").hasClass("active")) {
            var hairColorChoosed = $(".hair-color-tip").find("input[name='Hair Color']:checked").hasClass("hairColorNote");
            if(hairColorChoosed) {
                $(".hairColorOption").text($(".hair-color-note").val());
            }
        }
        });
        // 用于价格记录的计算变量参数
        var _CHOOSEPRICE = 0,
            _INITIALPRICE = float_multiply_by_100($(".custom-price").attr("data-price")),  // 页面的初始价格
            _NEWPRICE = float_multiply_by_100($(".custom-price").attr("data-price")),    // 新的价格数
            _CHOOSEPRICEARR = [],            // 用来存储所有选择的价格的数组
            _PRECHOOSENAME = "";  // 记录上一次选择的
        // 点击一级分类，判断是否有二级分类如果有二级分类显示二级分类，没有则将该选项内容添加到标题中
        $(".block-list-level").on("click",".block-list-level-input",function(){
            var isHasChild = $(this).hasClass("hasChildTwo");
            var _this = $(this);
            var chooseText = '';
            if(isHasChild){
                // 如果有二级菜单 ，显示子菜单
                _this.parents(".block-list").find(".block-list-level-2").slideUp();
                _this.parents(".block-list-level").find(".block-list-level-2").slideDown();
                if(_this.prop("name") == "Grey Hair") {
                    chooseText = _this.parent("label").find(".val-text").text();
                }
            }else {
                // 没有子菜单，直接将内容显示并计算价格,并收起所有的二级子菜单,并将选中的值赋值给option
                chooseText = _this.parent("label").find(".val-text").text();
                _this.parents(".block-list").find(".block-list-level-2").slideUp();
            }
            // 将选中的选项的值赋值给option
            _this.parents(".top-level").find(".selected-option").text(chooseText);
            _this.parents(".top-level").find(".selected-option").prop("title", chooseText);
            _this.parents(".top-level").find(".selected-option").attr("data-id", _this.val());
            // 判断是否有价格参数
            priceTotal(_this)
        })
        // 点击二级出现三级 hasChild
        $(".block-list-level-2").on("click",".block-list-level2-input",function(){
            var isHasChild = $(this).hasClass("hasChild");
            var _this = $(this);
            var chooseText = '';
            if(isHasChild){
                // 如果有二级菜单 ，显示子菜单
                _this.parents(".block-list").find(".block-list-level-3").slideUp();
                _this.parents(".block-list-level-2").find(".block-list-level-3").slideDown();
                if(_this.prop("name") == "Need Grey Hair Type") {
                    chooseText = $("select[name='Front']").val()+
                                 $("select[name='Top']").val()+ 
                                 $("select[name='Crown']").val()+ 
                                 $("select[name='Back']").val()+ 
                                 $("select[name='Temples']").val()+ 
                                 $("select[name='Sides']").val()+ 
                                 $(".Grey-Hair-Instruction").val()+
                                 _this.parent("label").find(".val-text").text();
                }
                
            }else {
                // 没有子菜单，直接将内容显示并计算价格,并收起所有的二级子菜单
                chooseText = _this.parent("label").find(".val-text").text();
                _this.parents(".block-list").find(".block-list-level-3").slideUp();
            }
            // 将选中的选项的值赋值给option
            if(_this.prop("name") == "Choose Grey Hair Type") {
                chooseText = chooseText + $(".Choose-grey-hair-text").text();
            }
            if(_this.prop("name") == "Grey Hair Type") {
                chooseText = chooseText + "I want highlights to my hair";
            }
            _this.parents(".top-level").find(".selected-option").text(chooseText);
            _this.parents(".top-level").find(".selected-option").prop("title", chooseText);
            _this.parents(".top-level").find(".selected-option").attr("data-id", _this.val());
            // 判断是否有价格参数
            priceTotal(_this);
        })
        // 点击三级分类出现四级分类
        $(".block-list-level-3").on("click",".block-list-level3-input",function(){
            var isHasChild = $(this).hasClass("hasChildThree");
            var _this = $(this);
            var chooseText = '';
            if(isHasChild){
                // 如果有二级菜单 ，显示子菜单
                _this.parents(".block-list").find(".block-list-level-4").slideUp();
                _this.parents(".block-list-level-3").find(".block-list-level-4").slideDown();
                if(_this.prop("name") == "color-codes") {
                    chooseText = _this.parent("label").find(".val-text").text();
                }
            }else {
                // 没有子菜单，直接将内容显示并计算价格,并收起所有的二级子菜单
                chooseText = _this.parent("label").find(".val-text").text();
                _this.parents(".block-list").find(".block-list-level-4").slideUp();
            }
            // 将选中的选项的值赋值给option color-codes
            if(_this.prop("name") == "Highlight Color") {
                chooseText = chooseText + "I want to customize highlight";
            }
            if(_this.prop("name") == "EvenlySpot") {
                chooseText = chooseText + 
                            $("input[name='Highlight Color']:checked").parents("label").find(".val-text").text() + 
                            $("input[name='hp']").val()+
                            "I want to customize highlight";
            }
            if(_this.prop("name") == "color-codes") {
                chooseText = chooseText + 
                            $("input[name='Highlight Color']:checked").parents("label").find(".val-text").text() + 
                            $("input[name='hp']").val()+
                            "I want to customize highlight";
            }
            _this.parents(".top-level").find(".selected-option").text(chooseText);
            _this.parents(".top-level").find(".selected-option").prop("title", chooseText);
            _this.parents(".top-level").find(".selected-option").attr("data-id", _this.val());
            // 判断是否有价格参数
            priceTotal(_this);
        })
        // 价格合计函数
        function priceTotal(Dom){
            // 判断是否有价格参数
            var isExist = false;
            if (Dom.parent("label").find(".price").length != 0) {
                var _inputThat = Dom;
                // var old_price = js_number_format(Math.imul(float_multiply_by_100(origin_price), 12) / 1000);
                if (_CHOOSEPRICEARR.length == 0) {
                    _PRECHOOSENAME = Dom.prop("name");
                    // _CHOOSEPRICE = Number(Dom.parent("label").find(".price").attr("data-price"));
                    _CHOOSEPRICE = float_multiply_by_100(Dom.parent("label").find(".price").attr("data-price"));
                    _NEWPRICE = _CHOOSEPRICE + _NEWPRICE;
                    _CHOOSEPRICEARR.push({"name": Dom.prop("name"), "price": _CHOOSEPRICE})
                } else {
                    for (var i in _CHOOSEPRICEARR) {
                        if (_CHOOSEPRICEARR[i].name == _inputThat.prop("name")) {
                            isExist = true;
                            _NEWPRICE = _NEWPRICE - _CHOOSEPRICEARR[i].price;
                            // _CHOOSEPRICE = Number(_inputThat.parent("label").find(".price").attr("data-price"));
                            _CHOOSEPRICE = float_multiply_by_100(_inputThat.parent("label").find(".price").attr("data-price"));
                            _CHOOSEPRICEARR[i].price = _CHOOSEPRICE;
                            _NEWPRICE = _CHOOSEPRICE + _NEWPRICE;
                        }
                    }
                    if (!isExist) {
                        _PRECHOOSENAME = _inputThat.prop("name");
                        // _CHOOSEPRICE = Number(_inputThat.parent("label").find(".price").attr("data-price"));
                        _CHOOSEPRICE = float_multiply_by_100(_inputThat.parent("label").find(".price").attr("data-price"));
                        _NEWPRICE = _CHOOSEPRICE + _NEWPRICE;
                        _CHOOSEPRICEARR.push({"name": _inputThat.prop("name"), "price": _CHOOSEPRICE})
                    }
                }
            }
            $(".custom-price-num").text(js_number_format(_NEWPRICE / 100));
            $(".custom-price").attr("data-price", js_number_format(_NEWPRICE / 100));
        }
        // $("select[name='Front']")
        $("select").on("change",function(){
           var _this = $(this);
           var chooseText = $("select[name='Front']").val()+
                            $("select[name='Top']").val()+ 
                            $("select[name='Crown']").val()+ 
                            $("select[name='Back']").val()+ 
                            $("select[name='Temples']").val()+ 
                            $("select[name='Sides']").val()+ 
                            $(".Grey-Hair-Instruction").val()+
                            _this.parents(".Customize-percentage").find(".val-text").text();
            _this.parents(".top-level").find(".selected-option").text(chooseText);
            _this.parents(".top-level").find(".selected-option").prop("title", chooseText);
        })
        $("input[name='hp']").on("change",function(){
            var _this = $(this);
            var chooseText =$("input[name='EvenlySpot']:checked").parents("label").find(".val-text").text() + 
                            $("input[name='Highlight Color']:checked").parents("label").find(".val-text").text() + 
                            $("input[name='hp']").val()+
                            "I want to customize highlight";
            _this.parents(".top-level").find(".selected-option").text(chooseText);
            _this.parents(".top-level").find(".selected-option").prop("title", chooseText);
        })
    </script>
@endsection
