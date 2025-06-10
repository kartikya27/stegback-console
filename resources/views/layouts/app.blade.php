<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title', 'Panel Pulse')</title>
    <meta name="description" content="@yield('description')" />
    <meta name="keywords" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="facebook-domain-verification" content="6c8f5q9rss6przago6vc41myxc9xsx" />

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <meta property="og:locale" content="en" />
    <meta property="og:type" content="Website" />
    <meta property="og:url" content="" />
    <meta property="og:title" content="@yield('title', 'Stegback Console')" />
    <meta property="og:description" content="@yield('description')" />
    <meta property="og:image" content="{{ asset('images/vitality-club-main-logo.jpg') }}" />
    <meta property="og:site_name" content="Stegback Console" />
    <meta name="robots" content="index,follow" />
    <meta name="robots" content="All" />
    <link rel="canonical" href="@yield('canonical')">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/vc-owl-bootstrap-photoswipe.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/vc-30-11-1.css') }}" />

    @yield('style')
    <style>

    </style>

</head>

<body>
    <div id="app" style="position:relative;">
        <header>
            <nav id="navbar" class="navbar fixed-top navbar-expand-md navbar-light">

                <div id="announcementBar" class="container-fluid announcementBar" style="background-color:#cf597e">
                    <div class="container containerLimit" style="flex-direction:column;">
                        <p class="heading mb-0" style="color:#fff">
                            Text Here</p>

                    </div>
                </div>

                <div class="container containerLimit menuBar">
                    <a class="navbar-brand" href="{{ url('admin') }}">
                        {{-- <img class="icon img-responsive" src="https://stegbackdotcomcdn.b-cdn.net/root/storage/media/2024_09_11/1726063492-0.jpg"> --}}
                        {{ __('Stegback Console') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto mr-auto">
                            <li class="nav-item"> <a id="home" class="nav-link" href="/">Home</a></li>
                            <li class="nav-item dropdown">
                                <a id="shop" class="nav-link dropbtn" style="cursor:pointer;" id="navbardrop1"
                                    data-toggle="dropdown">Shop</a>
                                <ul class="dropdown-content">
                                    <li class="shopMenu-subheading"><a href="/shop" class="menu-item">All Products</a>
                                    </li>


                                    <li class="shopMenu-subheading dropright"><a href="/shop/"
                                            class="menu-item">Category 1<span class="caret"></span></a>
                                        <ul class="dropdown-menu">

                                            <li class="shopMenu-subheading1"><a href="/shop/"
                                                    class="menu-item">Category 2 </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="shopMenu-subheading"><a href="/shop/" class="menu-item">Category3</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item"> <a id="contactUs" class="nav-link" href="/contact-us">Contact
                                    Us</a></li>
                            <li class="nav-item dropdown">
                                <a id="more" class="nav-link dropbtn" style="cursor:pointer;" id="navbardrop1"
                                    data-toggle="dropdown">More</a>
                                <ul class="dropdown-content">
                                    <li class="shopMenu-subheading"><a href="/vitality-quiz"
                                            class="menu-item">Vitality Quiz</a></li>
                                    <li class="shopMenu-subheading"><a href="/roots-of-vitality"
                                            class="menu-item">Roots of Vitality</a></li>
                                    <li class="shopMenu-subheading"><a href="/blog" class="menu-item"
                                            target="_blank">Blog</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="ecom-actions">
                            <button id="accountBtn" class="accountBtn" onclick="window.location='/login'"
                                title="Account"><i class="fas fa-user"></i></button>
                            <button id="searchBtn" class="searchBtn" onclick="showSearchBar()" title="Search"><i
                                    class="fas fa-search"></i></button>
                            <div class="cartdropbtn" style="position:relative">
                                <button id="shoppingBagBtn" class="shoppingBagBtn" onclick="window.location='/cart'"
                                    title="Shopping Cart" data-toggle="dropdown"><i
                                        class="fas fa-shopping-cart"></i><span id="cartCount"
                                        class="cartCount">@php echo count((array) session('cart')) @endphp</span></button>
                                <div class="dropdown-menu dropdown-menu-right m-0">
                                    <div id="cartProduct" class="cartProduct">
                                        @if (count((array) session('cart')) > 0)
                                            @foreach (session('cart') as $products => $product)
                                                <div class="row cart-row">
                                                    <img class="img-block"
                                                        src="/storage/shop/@php echo str_replace(' ','-',strtoupper($product['code'])) @endphp/{{ $product['image'] }}" />
                                                    <div class="info-block">
                                                        <p><a
                                                                href="/shop/<?php echo strtolower(str_replace(' ', '-', $product['category'])); ?>/{{ $product['url'] }}">{{ $product['name'] }}</a>
                                                        </p>
                                                        @if ($product['variantValue'] != '')
                                                            <p>{{ $product['variantValue'] }}</p>
                                                        @endif
                                                        <p>Quantity: {{ $product['quantity'] }}</p>
                                                        <p class="mb-0">USD <?php echo number_format($product['price'] * $product['quantity']); ?></p>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <button class="btn viewCartBtn" onclick="window.location='/cart'">View
                                                Cart</button>
                                        @else
                                            <p class="emptyCart text-center mb-0">Your shopping cart is currently
                                                empty.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <main id="mainContent">@yield('content')</main>
        <footer>
            <div class="container containerLimit">
                <div class="row">
                    <div class="col-md-3">
                        <p class="footer-heading">Stegback Console</p>
                        <p class="footer-link"><a href="/about-us">About Us</a></p>
                        <p class="footer-link"><a href="/privacy-policy">Privacy Policy</a></p>
                        <p class="footer-link"><a href="/terms-of-service">Terms of Service</a></p>
                        <p class="footer-link"><a href="/faqs">FAQs</a></p>
                        <p class="footer-link"><a href="/contact-us">Contact Us</a></p>
                    </div>
                    <div class="col-md-3">
                        <p class="footer-heading">Customer Care</p>
                        <p class="footer-link"><a href="/shipping-policy">Shipping Policy</a></p>
                        <p class="footer-link"><a href="/cancellation-policy">Cancellation Policy</a></p>
                        <p class="footer-link"><a href="/return-policy">Return Policy</a></p>
                        <p class="footer-text"><img style="width:33.33%;height:auto;" src="/images/fssai.png" /></p>
                        <p class="footer-text">FSSAI License: <span
                                style="color:black;text-decoration:none;">10020011008074</span></p>
                    </div>
                    <div class="col-md-3">
                        <p class="footer-heading">Stay in touch</p>
                        <p class="footer-text">Follow us to know more about the latest products and offers.</p>
                        <p class="footer-link"><a href="mailto:hello@vitalityclub.in"
                                style="color:black">hello@vitalityclub.in</a></p>
                        <p class="footer-link"><a href="https://www.instagram.com/vitalityclub.in" target="_blank"><i
                                    class="fab fa-instagram"></i></a> <a
                                href="https://www.facebook.com/vitalityclub.in" target="_blank"><i
                                    class="fab fa-facebook-square"></i></a></p>
                    </div>
                    <div class="col-md-3">
                        <p class="footer-heading">Newsletter</p>
                        <p class="footer-text">Subscribe to get special offers, free giveaways, and once-in-a-lifetime
                            deals.</p>
                        <form id="signUp-form" action="/sign-up" method="post" class="footer-signupForm">
                            @csrf
                            <div class="form-row">
                                <div class="col-12">
                                    <input type="email" class="form-control email_field" id="validationCustom01"
                                        name="email" value="{{ old('email') }}" placeholder="Your email address"
                                        required>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary signup_btn" type="submit">Subscribe</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row last-row">
                    <div class="col-md-12">
                        <p class="footer-text mb-0">© 'Stegback Console' and its logo and likeness are a trademark of
                            Candid India. Any unauthorised use or imitation may result in legal action. All Rights
                            Reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
        <div class="back-to-top-box"><a class="back-to-top"><i class="fas fa-chevron-up"></i></a></div>
    </div>
    <div id="searchBar" class="searchBar">
        <form class="searchForm">
            <div class="form-group">
                <input type="text" class="form-control" id="searchInput" name="searchInput"
                    placeholder="Search our store" autocomplete="off" autofocus>
            </div>
        </form>
        <button class="btn btn-link closeSearchBtn" onclick="closeSearchBar()">&times;</button>
        <div class="container">
            <div id="searchRow" class="row"></div>
        </div>
    </div>
    <script src="{{ asset('js/vc-jQuery-popper-bootstrap-owl-photoswipe.js') }}"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    @yield('scriptContent')
    <script>
        $(document).ready(function() {
            if (screen.width > 767) {
                var nav1 = $(".fixed-top");
                var nav2 = $(".menuBar");
                var navHeight1 = nav1.height();
                var navHeight2 = nav2.height();

                $(function() {
                    $(document).scroll(function() {
                        nav1.toggleClass('scrolled', $(this).scrollTop() > navHeight1);
                    });
                });

                var navbarHeight = navHeight1 + 'px';
                var menuItemHeight = navHeight2 + 'px';

                var navLinksCont = document.getElementById("navbar");
                var navLinks = navLinksCont.getElementsByClassName("nav-link");
                var navLinksCounter;
                for (navLinksCounter = 0; navLinksCounter < navLinks.length; navLinksCounter++) {
                    navLinks[navLinksCounter].style.lineHeight = menuItemHeight;
                }
                document.getElementById("accountBtn").style.height = menuItemHeight;
                document.getElementById("searchBtn").style.height = menuItemHeight;
                document.getElementById("shoppingBagBtn").style.height = menuItemHeight;
                document.getElementById("mainContent").style.paddingTop = navbarHeight;

            } else {
                var nav = $(".mobileNav");
                var navHeight = nav.height();

                $(document).scroll(function() {
                    $nav.toggleClass('scrolled', $(this).scrollTop() > 0);
                });
                var menuItemHeight = navHeight + 'px';
                document.getElementById("mainContent").style.paddingTop = menuItemHeight;
            }
        });

        function openSideNav() {
            document.getElementById("mySidenav").style.width = "100%";
            $('body').css('overflow', 'hidden');
        }

        function closeSideNav() {
            document.getElementById("mySidenav").style.width = "0";
            $('body').css('overflow', 'auto');
        }

        function showSearchBar() {
            document.getElementById("searchBar").style.height = "100vh";
            $('body').css('overflow', 'hidden');
        }

        function closeSearchBar() {
            document.getElementById("searchBar").style.height = "0";
            $('body').css('overflow', 'auto');
            document.getElementById("searchInput").value = "";
            $('#searchRow').html('');
        }

        var amountScrolled = 250;
        $(window).scroll(function() {
            $(window).scrollTop() > amountScrolled ? $(".back-to-top").fadeIn("slow") : $(".back-to-top").fadeOut(
                "slow")
        }), $(".back-to-top").click(function() {
            return $("html, body").animate({
                scrollTop: 0
            }, 700), !1
        })
    </script>
    @yield('endscripts')
    <script type="text/javascript">
        $('#searchInput').on('keyup', function() {
            $value = $(this).val();
            $.ajax({
                type: 'get',
                url: '{{ URL::to('search') }}',
                data: {
                    'search': $value
                },
                success: function(data) {
                    $('#searchRow').html(data);
                }
            });
        });
    </script>
</body>

</html>
