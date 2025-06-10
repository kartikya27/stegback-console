<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/jpg" sizes="96x96" href="https://stegbackdotcomcdn.b-cdn.net/root/storage/media/2024_09_11/1726063492-0.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title', 'Stegback Console | Admin CRM and Product management tool')</title>
    <meta name="robots" content="noindex, follow">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    {{-- <meta http-equiv="refresh" content="2"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/vc-owl-bootstrap-photoswipe.css') }}" /> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/vc-admin-18-11-01.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <style>
        html,
        body {
            background-color: #efefef47;
        }
    </style>
    @stack('style')
    @yield('style')
</head>

<body>
@auth
    <div id="app">
        <nav class="navbar navbar-fixed navbar-expand-md navbar-light shadow-sm">
            <div class="container-fluid">
                <div class="row w-100">
                    <div class="col-md-6">
                        <table style="width:100%;height:100%;">
                            <tr>
                                <td class="align-middle" style="width:100%;height:100%;">
                                    <a class="navbar-brand d-inline-flex align-items-end" href="{{ url('admin') }}">
                                        <img class="icon stegback-icon img-fluid" src="https://epp.stegback.com/root/storage/uploads/white-logo.png">
                                        <span class="ms-1 lh-1 fs-4 fw-light">
                                            {{ __('.Console') }}
                                        </span>
                                    </a>
                                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                                        <span class="navbar-toggler-icon"></span>
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="col-md-6 text-right">
                        <table style="width:100%;height:100%;">
                            <tr>
                                <td class="align-middle" style="width:100%;height:100%;">
                                    <div class="collapse navbar-collapse mb-0 justify-content-end" id="navbarSupportedContent">
                                        <ul class="navbar-nav ml-auto">
                                            
                                        @php
                                            $user = Auth::user();
                                            $pic = 'https://ui-avatars.com/api/?name=' . str_replace(' ', '+', $user->name) . '&color=34205c&background=eae8ee';
                                            $isSeller = Auth::guard('seller')->check();
                                        @endphp

                                            <li class="nav-item dropdown">
                                                <a id="navbarDropdown" class="nav-link dropdown-toggle"
                                                href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false" style="line-height:28px;">
                                                    @if (!$isSeller)
                                                        <img style="width:28px;height:auto;margin-right:5px;border-radius:50%;" src="{{ $pic }}" />
                                                        {{ $user->name }}
                                                    @else
                                                        {{ Auth::guard('seller')->user()->email }}
                                                    @endif
                                                    <span class="caret"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        {{ __('Logout') }}
                                                    </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </li>
                                            

                                            <li class="nav-item dropdown">
                                                <a id="navbarDropdown" class="nav-link dropdown-toggle"
                                                    href="#" role="button" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" v-pre
                                                    style="line-height:28px;">
                                                    EN<span class="caret"></span>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right"
                                                    aria-labelledby="navbarDropdown">
                                                    <a class="dropdown-item" href="/lang/en">
                                                        <img class="tax-flag"
                                                            src="https://media.istockphoto.com/id/486407806/vector/union-jack.jpg?s=612x612&w=0&k=20&c=KPRndA_Czak9T0w_Eq3GnhRaNxERiEiw2cjZe5GBY-E=" />
                                                        EN</a>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div> 
                
            </div>
        </nav>

        <main>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2 admin-menu-cont">
                        @if(Auth::user() && Auth::user()->role === 'admin')
                            <a href="/admin" class="admin-menu home"><i class="fas fa-home"></i>Home</a>

                            <a href="/admin/orders" class="admin-menu orders">
                                <i class="fas fa-shopping-cart"></i>Orders
                            </a>

                            <div class="collapse" id="ordersCollapse">
                                <a href="{{ route('admin.orders') }}" class="admin-menu1 orders">Orders</a>
                                <a href="/admin/checkouts" class="admin-menu1 checkouts">Abandoned checkouts</a>
                            </div>

                            <a href="{{ route('admin.products') }}" class="admin-menu products">
                                <i class="fas fa-tag"></i>Products
                            </a>

                            <a href="/admin/customers" class="admin-menu customers">
                                <i class="fas fa-user"></i>Customers
                            </a>

                            <a href="/admin/sellers" class="admin-menu discounts mb-4">
                                <i class="fas fa-money-check-alt"></i>Seller and Sales Report
                            </a>

                            <a class="admin-subheading">SALES CHANNELS</a>
                            <a class="admin-menu store" onclick="storeCollapse();">
                                <i class="fas fa-store"></i>Online Store
                            </a> 
                            <button class="btn btn-link storeBtn" onclick="window.open('{{ env('STORE_URL') }}', '_blank');">
                                <i class="far fa-eye"></i>
                            </button>

                            <div class="collapse" id="storeCollapse">
                                <a href="/admin/homepage/announcement" class="admin-menu1 announcement">Announcement</a>
                                <a href="{{route('slider.list')}}" class="admin-menu1 slider">Image slider</a>
                                <a href="/admin/homepage/image-with-text-overlay" class="admin-menu1 imageWithText">Image with text</a>
                                <a href="/admin/homepage/services" class="admin-menu1 services">Image with text 2</a>
                            </div>

                            <a href="/admin/settings" class="admin-menu settings">
                                <i class="fas fa-cog"></i>Settings
                            </a>
                        @elseif(Auth::guard('seller')->check())

                            <a href="{{ route('ads.campaigns.seller.auth.ads') }}" class="admin-menu orders">Ads Campaign</a>
                            <!-- <a href="/admin/checkouts" class="admin-menu1 checkouts">Ads Group</a>
                            <a href="/admin/checkouts" class="admin-menu1 checkouts">Ads</a> -->
                        @endif
                    </div>
                    <div class="col-md-10 admin-main-cont">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/vc-jQuery-popper-bootstrap-owl-photoswipe.js') }}"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ"
        crossorigin="anonymous">
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    @yield('scriptContent')

    <script>
        function storeCollapse() {
            $('#storeCollapse').collapse('toggle');
        }
    </script>

    @else
    <script>
        window.location = "/";
    </script>
    @endauth

    @stack('scripts')
</body>
</html>
