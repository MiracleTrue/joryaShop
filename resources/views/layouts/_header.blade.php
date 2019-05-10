<nav class="navbar navbar-default">
    <div class="navbar-top">
        <div class="m-wrapper">
            <div class="navbar-top-left pull-left">
                <ul>
                    <li>
                        <span>Tel: 400-100-5678</span>
                    </li>
                    {{--<li>
                       <span>@lang('app.switch language')：</span>
                   </li>
                   <li class="dropdown">
                       <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                           <span>{{ App::getLocale() == 'en' ? 'English' : '中文' }}</span>
                           <img src="{{ asset('img/header/down_arrow.png') }}">
                       </button>
                       <ul class="dropdown-menu" aria-labelledby="dLabel">
                           <li>
                               <a href="{{ route('locale.update', ['locale' => 'zh-CN']) }}">
                                   <img src="{{ asset('img/header/cn_flag.png') }}">
                                   <span>中文</span>
                               </a>
                           </li>
                           <li>
                               <a href="{{ route('locale.update', ['locale' => 'en']) }}">
                                   <img src="{{ asset('img/header/en_flag.png') }}">
                                   <span>English</span>
                               </a>
                           </li>
                       </ul>
                   </li>--}}
                </ul>
            </div>
            <div class="navbar-top-right pull-right">
                @guest
                    <a class="login">@lang('app.Log_In')</a>
                    <a class="register">@lang('app.Register')</a>
                    <a class="register">@lang('basic.users.Personal_Center')</a>
                    <a class="about-us" href="{{ route('articles.show', ['slug' => 'contact_us']) }}">@lang('app.Contact_Us')</a>
                @else
                    <a id="user_info_btn" role="button" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false" class="user_name">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="user_info_btn">
                        <li>

                            <a class="touser_center" href="{{ route('users.home') }}">
                                <img class="user_img" src="{{ Auth::user()->avatar_url }}">
                                <span>@lang('app.Account_information')</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" class="login_out_a"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                @lang('app.Sign_out')
                            </a>
                        </li>
                    </ul>
                    <img src="{{ asset('img/header/down_arrow.png') }}">
                    <a class="about-us" href="{{ route('articles.show', ['slug' => 'contact_us']) }}">@lang('app.Contact_Us')</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                @endguest
            </div>
        </div>
    </div>
    <div class="navbar-bottom">
        <div class="m-wrapper">
            <div class="navbar-bottom-top">
                <div class="navbar-bottom-top-left">
                    <div class="header_logo">
                        <a href="{{ route('root') }}">
                            <img src="{{ asset('img/logo2.png') }}">
                            <p>@lang('app.The Best For You')</p>
                        </a>
                    </div>
                    <div class="navbar-bottom-top-left-right">
                        <p>@lang('app.Custom & Stock Hair Systems')</p>
                        <p><span>@lang('app.30-Day Money Back')</span> @lang('app.Guarantee')</p>
                    </div>
                </div>
                <div class="navbar-bottom-top-right">
                    <a href="{{ route('articles.show', ['slug' => 'stock_order']) }}">@lang('app.Stock Order')</a>
                    <a href="{{ route('articles.show', ['slug' => 'custom_order']) }}">@lang('app.Custom Order')</a>
                    <a href="{{ route('articles.show', ['slug' => 'duplicate']) }}">@lang('app.Duplicate')</a>
                    <a href="{{ route('articles.show', ['slug' => 'repair']) }}">@lang('app.Repair')</a>
                </div>
            </div>
            <div class="navbar-bottom-bottom">
                <ul class="navbar-bottom-bottom-left">
                    <li class="img_menu">
                        <a href="{{ route('root') }}">
                            <img src="{{ asset('img/home2.png') }}">
                        </a>
                    </li>
                    @foreach(\App\Models\Menu::pcMenus() as $key => $menu)
                        @if(isset($menu['parent']))
                            <li class="first_menu">
                                <a href="{{ $menu['parent']->link }}">
                                    {{ App::isLocale('zh-CN') ? $menu['parent']->name_zh : $menu['parent']->name_en }}
                                </a>
                                <!--二级菜单内容-->
                                @if(isset($menu['children']))
                                    <div class="nav-panel-dropdown">
                                        <ul>
                                            @foreach($menu['children'] as $child)
                                                <li>
                                                    <a href="{{ $child['link'] }}"><span>{{ App::isLocale('zh-CN') ? $child['name_zh'] : $child['name_en'] }}</span></a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </li>
                        @else
                            <li class="first_menu">
                                <a href="{{ $menu->link }}">{{ App::isLocale('zh-CN') ? $menu->name_zh : $menu->name_en }}</a>
                            </li>
                        @endif
                    @endforeach

                    {{--固定的导航栏目--}}
                    <li class="first_menu">
                        <a href="{{url('articles/starting_a_purchase')}}">STARTING A PURCHASE</a>
                        <div class="nav-panel-dropdown">
                            <ul>
                                <li>
                                    <a href="{{ route('articles.show', ['slug' => 'how_to_send_in_samples']) }}">
                                        <span>How To send in samples</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('articles.show', ['slug' => 'existing_client_reorder']) }}">
                                        <span>Existing client reorder</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('articles.show', ['slug' => 'hair_duplication']) }}">
                                        <span>Hair duplication</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('articles.show', ['slug' => 'repair_old_system']) }}">
                                        <span>Repair old system</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('storage/LYRICAL%20HAIR%20ORDER%20FORM.doc')}}">
                                        <span>Download the Custom Order Form</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('articles.show', ['slug' => 'order_tools_reference']) }}">
                                        <span>Order Tools Reference</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('storage/Download the Catalogue.docx')}}">
                                        <span>Download Catalogue</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('articles.show', ['slug' => 'return_policy']) }}">
                                        <span>Return Policy</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('articles.show', ['slug' => 'positive_comments']) }}">
                                        <span>Positive comments</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('articles.show', ['slug' => 'common_order_mistakes']) }}">
                                        <span>Common Order Mistakes</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('articles.show', ['slug' => 'hair_care']) }}">
                                        <span>Hair care</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('articles.show', ['slug' => 'send_in_templates_&_hair']) }}">
                                        <span>Send in templates & Hair</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('articles.show', ['slug' => 'samples']) }}">
                                        <span>Samples</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                </ul>
                <div class="pull-right header-search">
                    <ul>
                        <li class="for_show_search">
                            <a class="show_btn" href="javascript:void(0);">
                                <img src="{{ asset('img/search_magnifier.png') }}">
                            </a>
                        </li>
                        <li class="show_search">
                            <input type="search" data-url="{{ route('products.search_hint') }}" class="selectInput_header"
                                   placeholder="@lang('app.Please enter the item you are searching for')">
                            <a class="search_btn" href="javascript:void(0);">
                                <img src="{{ asset('img/search_magnifier.png') }}">
                            </a>
                            <div class="selectList dis_n" data-url="{{ route('products.search') }}">
                                <ul></ul>
                            </div>
                        </li>
                        <li class="shppingCart">
                            <a href="{{ route('carts.index') }}" class="shop_cart">
                                <img src="{{ asset('img/header/shop_car.png') }}">
                                @if(isset($cart_count))
                                    <div class="for_cart_num">
                                        <span class="shop_cart_num">{{ $cart_count }}</span>
                                    </div>
                                @else
                                    <div class="for_cart_num">
                                        <span class="shop_cart_num">0</span>
                                    </div>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
