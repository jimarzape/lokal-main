<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="referrer" content="strict-origin" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="modal-login" content="{{route('modal_signin')}}">
    @yield('meta')
    <meta name="robots" content="index, follow" />
    <title>LokaldatPH</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('media/img/logo.png')}}">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{asset('custom/css/style.css?'.time())}}">
    <link rel="stylesheet" type="text/css" href="{{asset('bootstrap-4.3.1-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugin/star-rating/css/star-rating-svg.css')}}">
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
    <script type="text/javascript" src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/a076d05399.js')}}"></script>
    <!-- <script src="https://kit.fontawesome.com/a076d05399.js"></script> -->
    @yield('css')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm nav-lokal">
            <div class="container">
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="row w-100">
                    <div class="collapse navbar-collapse color-white col-md-12 f-15 f-bold" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="http://lokalseller.lokaldatph.com/">HOME SELLER</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="#">DOWNLOAD APP</a>
                            </li> -->
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('LOGIN') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('SIGNUP') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle custom-dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->userFullName }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right custom-dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a href="{{route('account')}}" class="dropdown-item "><span class="color-gray">Account</span></a>
                                        <a href="{{route('order')}}" class="dropdown-item "><span class="color-gray">Order History</span></a>
                                        <a href="{{route('wish')}}" class="dropdown-item "><span class="color-gray">Wish List</span></a>
                                        <a href="#" class="dropdown-item "><span class="color-gray">Following Store</span>/a>
                                        <a href="#" class="dropdown-item "><span class="color-gray">Reviews</span></a>
                                        <a class="dropdown-item " href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            <span class="color-gray">{{ __('Logout') }}</span>
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                               
                            @endguest
                        </ul>
                    </div>
                    <div class="collapse navbar-collapse color-white col-md-12">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto w-100">
                            <li class="">
                                <a class="navbar-brand" href="{{ url('/') }}">
                                    <img src="/media/img/white-long.png" class="img-logo-long">
                                </a>
                            </li>
                            <li class="w-65">
                                <form class="input-group" method="GET" action="{{route('product_seach')}}">
                                    <input type="search" class="form-control mtop-11" name="search" placeholder="Search here" value="{{Request::input('search')}}">
                                    <div class="input-group-append search-btn-group" >
                                        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                                    </div>
                                </form>
                            </li>
                            <li class="cart-li">
                                <a href="{{route('cart')}}">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                                <span class="cart-badge cart-main-qty {{isset($cart_qty) ? $cart_qty <= 0 ? 'hide' : '' : 'hide'}}">{{isset($cart_qty) ? $cart_qty : 0}}</span>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        
        <footer>
            <div class="custom-footer">
                <div class="row ">
                    <div class="col-md-12 text-justify mb-2m">
                        <h4>LokaldatPH</h4>
                        <p class="f-12">LokaldatPH is a street style fashion community platform where select Filipino designers and boutiques showcase their unique artistic products and styles online.</p>
                    </div>
                    <div class="col-md-12 mb-2m">
                        <ul class=" nav-footer">
                            <li class="nav-item">
                                <a href="#" class="nav-link f-bold">CUSTOMER SERVICE</a>
                                <ul class="footer-list">
                                    <li>
                                        <a href="#">Help Center</a>
                                    </li>
                                    <li>
                                        <a href="#">How to Buy</a>
                                    </li>
                                    <li>
                                        <a href="#">Shipping & Delivery</a>
                                    </li>
                                    <li>
                                        <a href="#">Product Policy</a>
                                    </li>
                                    <li>
                                        <a href="#">How to Return</a>
                                    </li>
                                    <li>
                                        <a href="#">Contact Us</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link f-bold">ABOUT LOKALDATPH</a>
                                <ul class="footer-list">
                                    <li>
                                        <a href="#">About Us</a>
                                    </li>
                                    <li>
                                        <a href="{{route('privacy_policy')}}">Privacy & Policy</a>
                                    </li>
                                    <li>
                                        <a href="http://lokalseller.lokaldatph.com/">Home Seller</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link f-bold">FOLLOW US</a>
                                <ul class="footer-list">
                                    <li>
                                        <a href="https://www.facebook.com/lokaldatphofficial/"><i class="fab fa-facebook-square"></i>&nbsp;Facebook</a>
                                    </li>
                                   <!--  <li>
                                        <a href="#"><i class="fab fa-twitter-square"></i>&nbsp;Twitter</a>
                                    </li> -->
                                    <li>
                                        <a href="https://www.instagram.com/lokaldatph/"><i class="fab fa-instagram-square"></i>&nbsp;Instagram</a>
                                    </li>
                                   <!--  <li>
                                        <a href="#"><i class="fab fa-google-plus-square"></i>&nbsp;Google Plus</a>
                                    </li> -->
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link f-bold">LOKALDATPH APP</a>
                                <ul class="footer-list">
                                    <li>
                                        <a href="https://play.google.com/store/apps/details?id=com.app.lokaldatph&fbclid=IwAR1-chv81oFNTx6aGXKR3hK9FkSWCTgRZTauTz15KfwoJbCr0uJHJ5f1yBg">
                                            <img src="/media/img/google-play.png" class="img-app-footer">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="/media/img/apple-store.png" class="img-app-footer">
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>

<script type="text/javascript" src="{{asset('bootstrap-4.3.1-dist/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugin/star-rating/jquery.star-rating-svg.min.js')}}"></script>
<script type="text/javascript" src="{{asset('custom/js/star.min.js')}}"></script>
<script type="text/javascript" src="{{asset('custom/js/global.js?'.time())}}"></script>
@yield('js')
</html>
