<!-- header -->
<header class="py-0">
    <div class="container">
        <div class="row">
            <!-- mobile and email-->
            <div class="col-sm-12 header-top text-left text-sm-left text-md-right py-2">
                <div class="header-top-link">
                    <a href="tel:{{setting('mobile_no')}}">
                        <span class="icon-screen-smartphone">
                        </span>
                        {{setting('mobile_no') ? setting('mobile_no') : ''}}
                    </a>
                </div>
                <div class="header-top-link">
                    <a href="mailto:{{setting('email')}}">
                        <span class="icon-envelope">
                        </span>
                        {{setting('email') ? setting('email') : ''}}
                    </a>
                </div>
            </div>
            <!-- mobile and email end-->
            <div class="col-12 col-sm-6 col-md-4">
                <!-- logo and title -->
                <a href="{{ route('home') }}">
                    <div class="logo text-sm-left text-center">
                        <img alt="" src="{{ asset('images/logo.png') }}">
                         <div class="site-title text-sm-left">
                             <h1>
                                  General
                                  <br>
                                     Chemical
                                  <br>
                                  Corporation
                             </h1>
                             <span>
                                 #1 IN INDUSTRIAL SERVICES
                             </span>
                         </div>
                    </div>
                </a>
                <!-- logo and title end-->
            </div>
            <div class="col-12 col-sm-6 col-md-8 navigation-row text-sm-left text-center pt-1">
                <!-- navigation -->
                <nav class="navbar top-nav-desktop">
                    <ul class="nav navbar-nav d-none d-sm-none d-md-none d-lg-block">
                        <li class="{{ (\Request::url() == route('home') )? 'active' : '' }}">
                            <a href="{{ route('home') }}">
                                {{__('messages.home')}}
                            </a>
                        </li>
                        <li class="{{ (\Request::url() == route('store') )? 'active' : '' }}">
                            <a href="{{ route('store') }}">
                                {{__('messages.store')}}
                            </a>
                        </li>

                        <li class="{{ (\Request::url() == route('pages.slug', ['slug' => 'about-us']) )? 'active' : '' }}">
                            <a href=" {{ route('pages.slug', ['slug' => 'about-us']) }} ">
                                {{__('messages.about_us')}}
                            </a>
                        </li>
                        <li class="{{ (\Request::url() == route('pages.slug', ['slug' => 'ethics']) )? 'active' : '' }}">
                            <a href=" {{ route('pages.slug', ['slug' => 'ethics']) }} ">
                                {{__('messages.ethics')}}
                            </a>
                        </li>
                        <li class="{{ (\Request::url() == route('sds') )? 'active' : '' }}">
                            <a href="{{ route('sds') }}">
                                sds
                            </a>
                        </li>
                        <li class="{{ (\Request::url() == route('contact_us') )? 'active' : '' }}">
                            <a href="{{ route('contact_us') }}">
                                {{__('messages.contact_us')}}
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- navigation end-->
                <!-- profile and cart -->
                <div class="profile-cart">
                    <ul>
                        <li class="userdetail {{ (auth("web")->check()) ? 'checked' : ''}} ">
                               <div class="usericon">
                                <span class="icon-user">
                                </span>
                                 @if (!auth("web")->check())
                                  <span class="icon-login icons"></span>
                                @else
                                  <span class="icon-logout icons"></span>
                                @endif
                           </div>

                            <div class="dropdown">
                                @if (!auth("web")->check())
                                  <div class="nonloginuser">
                                    <a href="{{ route('login') }}" class="btn btn-primary">{{__('messages.login')}}</a>
                                    <span>{{__('messages.new_customer_question_mark')}} <a href="{{ route('register') }}" class="btn-link">{{__('messages.click_here')}}</a></span>
                                  </div>
                                @else
                               <div class="loginuser">
                                   <div class="name">{{__('messages.welcome')}},<br>
                                   <span>{{Auth::user()->first_name}}&nbsp;{{Auth::user()->last_name}}</</span></div>
                                    <div><a href="{{ route('my_profile') }}"> <i class="icon-user"></i> {{__('messages.my_profile')}}</a></div>
                                    <div><a href="{{ route('my_order') }}"><i class="icon-basket"></i>{{__('messages.my_orders')}}</a></div>
                                    <div><a href="{{ route('my_addresses') }}"><i class="icon-home"></i>{{__('messages.my_addresses')}}</a></div>
                                    @if (!empty(setting('wish_list_in_the_frontend')))
                                    <div><a href="{{ route('wishlist') }}"><i class="icon-heart"></i>{{__('messages.my_wishlist')}}</a></div>
                                    @endif
                                    @auth("web")
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                        <div class="logoutlink"><a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" ><i class="icon-logout"></i>{{__('messages.log_out')}}</a></div>
                                    @endauth
                               </div>
                                @endif
                          </div>
                        </li>
                        <li>
                            <a href="{{ route('cart') }}">
                                <span class="icon-basket">
                                </span>
                                <sup id="cart-count">
                                    {{\App\Helpers\CartStorage::getCount() ?? 0}}
                                </sup>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- profile and cart end-->
                <!-- search box-->
                <div class="searchbox">
                    <form method="get" action="{{route('store')}}">
                        <div class="searchloader" style="display: none;"></div>
                        <input placeholder="What can we help you find today?" type="text" id="search-product"  name = "search_query" value="{{Request::input('search_query')}}">
                        <button class="btn btn-primary">
                            <span class="icon-magnifier">
                            </span>
                            search
                        </button>
                    </form>
                </div>
                <!-- search box end-->
            </div>
        </div>
    </div>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>
</header>
<!-- header end-->
<div class="navht"></div>
<!-- Main navigation row-->
<nav class="navbar navbar-expand-lg navig navbar-default">
    <div class="container">

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="top-nav-mobile">
                <li class="{{ (\Request::url() == route('home') )? 'active' : '' }}">
                    <a href="{{ route('home') }}">
                        Home
                    </a>
                </li>
                <li class="{{ (\Request::url() == route('store') )? 'active' : '' }}" >
                    <a href="{{ route('store') }}">
                        {{__('messages.store')}}
                    </a>
                </li>
                <li class="{{ (\Request::url() == route('pages.slug', ['slug' => 'about-us']) )? 'active' : '' }}">
                    <a href="{{ route('pages.slug', ['slug' => 'about-us']) }}">
                        about us
                    </a>

                </li>
                <li class="{{ (\Request::url() == route('pages.slug', ['slug' => 'ethics']) )? 'active' : '' }}">
                    <a href=" {{ route('pages.slug', ['slug' => 'ethics']) }} ">
                        {{__('messages.ethics')}}
                    </a>
                </li>
                <li class="{{ (\Request::url() == route('sds') )? 'active' : '' }}" >
                    <a href="{{ route('sds') }}">
                        sds
                    </a>
                </li>
                <li class="{{ (\Request::url() == route('pages.slug', ['slug' => 'contact_us']) )? 'active' : '' }}">
                    <a href="{{ route('contact_us') }}">
                        contact
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav mr-auto">
               @if (isset($categories) && $categories->count() > 0)
               @foreach($categories as $category)
                    @if(!empty($category->childs))
                        <li class="nav-item {{ (\Request::url() == route('category.view', ['parentCategory' => $category->slug]) )? 'active' : '' }}" class="">
                             <a class="nav-link dropdown-toggle"  href="{{ route('category.view', ['parentCategory' => $category->slug]) }}">     {{$category->name}}
                             </a>
                             <span class="mob-mwnu-arrow">  <i class="icon-arrow-down"></i></span>
                             <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <div class="row">
                                    @foreach($category->childs as $childCategory)
                                    <div class="col-lg-4 col-md-12">
                                     <a class="dropdown-item" href="{{ route('category.view', ['parentCategory' => $childCategory->slug]) }}">{{$childCategory->name}}</a>
                                   </div>
                                    @endforeach
                              </div>
                           </div>
                        </li>
                    @else
                        <li class="nav-item {{ (\Request::url() == route('category.view', ['parentCategory' => $category->slug]) )? 'active' : '' }} ">
                           <a class="nav-link" href="{{ route('category.view', ['parentCategory' => $category->slug]) }}">
                              {{$category->name}}
                           </a>
                        </li>
                    @endif
                @endforeach
               @endif
            </ul>
        </div>
    </div>
</nav>
<!-- Main navigation row end-->