<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> DEPOT | @yield('header_title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully responsive admin theme which can be used to build CRM, CMS,ERP etc." name="description" />
    <meta content="Techzaa" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-ico.ico') }}">
    <link rel="text/css" href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}">
    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datetimepicker/jquery.datetimepicker.css') }}">
    <!-- Vector Map css -->
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}">
    <link href="{{ asset('assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Datatables css -->
    <link href="{{ asset('assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Theme Config Js -->
    <script src="{{ asset('assets/js/config.js') }}"></script>

    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">



        <!-- ========== Topbar Start ========== -->
        <div class="navbar-custom">
            <div class="topbar container-fluid">
                <div class="d-flex align-items-center gap-1">

                    <!-- Topbar Brand Logo -->
                    <div class="logo-topbar">
                        <!-- Logo light -->
                        <a href="" class="logo-light">
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/logo.jpg') }}" alt="logo">
                            </span>
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo.jpg') }}" alt="small logo">
                            </span>
                        </a>

                        <!-- Logo Dark -->
                        <a href="" class="logo-dark">
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/logo.jpg') }}" alt="dark logo">
                            </span>
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo.jpg') }}" alt="small logo">
                            </span>
                        </a>
                    </div>

                    <button class="button-toggle-menu">
                        <i class="ri-menu-line"></i>
                    </button>

                    <!-- Horizontal Menu Toggle Button -->
                    <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>

                    <!-- Topbar Search Form -->

                </div>

                <ul class="topbar-menu d-flex align-items-center gap-3">
                    <li class="dropdown d-lg-none">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ri-search-line fs-22"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                            <form class="p-3">
                                <input type="search" class="form-control" placeholder="Search ..."
                                    aria-label="Recipient's username">
                            </form>
                        </div>
                    </li>

                    @php
                        // dd(App\Helpers\allowedStore()[0]);
                        $store_current = is_null(session('currentStore'))
                            ? App\Models\Depot::where('deleted_status', 0)
                                ->whereIn('id', App\Helpers\allowedStore())
                                ->orderBy('id', 'DESC')
                                ->first()->id
                            : session('currentStore');
                    @endphp
                    <span class="text text-info">Boutique: (
                        {{ App\Helpers\getStoreName($store_current) }})</span>
                    </li>
                    <li class="dropdown notification-list">
                        <a title="Annee Academique" class="nav-link dropdown-toggle arrow-none"
                            data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                            aria-expanded="false">
                            <i class="ri-store-2-line text-info fs-22"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg py-0">
                            <div class="p-2 border-top-0 border-start-0 border-end-0 border-dashed border">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold">Choisissez Depot</h6>
                                    </div>
                                    @php
                                        $currentStores = App\Helpers\getStores();
                                        $allowedStore = App\Helpers\allowedStore();
                                    @endphp
                                </div>
                            </div>
                            @foreach ($currentStores as $item)
                                @if (in_array($item->id, $allowedStore))
                                    <a onclick="setIsCurrent('{{ $item->id }}')"
                                        data-name="{{ $item->nom_depot }}" data-id="{{ $item->id }}"
                                        style="cursor: pointer" id="budgettery{{ $item->id }}"
                                        class="dropdown-item text-primary fw-bold border-top text-primary">
                                        Depot : {{ $item->nom_depot }}
                                    </a>
                                @endif
                            @endforeach

                        </div>
                    </li>
                    <li class="h5 mt-2">

                        <span class="text text-info"> </span>
                    </li>

                    <li class="d-none d-sm-inline-block">
                        <div class="nav-link" id="light-dark-mode">
                            <i class="ri-moon-line fs-22"></i>
                        </div>
                    </li>
                    <li class="text text-warning"><b>[ {{ App\Helpers\roleName() }} ]</b></li>
                    <li class="h5 mt-2">
                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle arrow-none nav-user" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <div class="border border-dark p-1">
                                <span class="text text-primary">
                                    {{ Auth::user()->name }}
                                </span>
                                <span class="account-user-avatar">
                                    <img src="{{ asset('assets/images/avatar.png') }}" alt="user-image"
                                        width="32" class="rounded-circle">
                                </span>
                            </div>



                            <span class="d-lg-block d-none">
                                <h5 class="my-0 fw-normal"> <i
                                        class="ri-arrow-down-s-line d-none d-sm-inline-block align-middle"></i></h5>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                            <!-- item-->

                            <!-- item-->
                            <a href="" class="dropdown-item">
                                <i class="ri-account-circle-line text text-info fs-18 align-middle me-1"></i>
                                <span>Mon Compte</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" class="dropdown-item"
                                    onclick="event.preventDefault();
            this.closest('form').submit();">
                                    <i class="ri-logout-box-line fs-18 align-middle me-1"></i>
                                    <span>Deconnexion</span>
                                </a>
                            </form>

                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- ========== Topbar End ========== -->


        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">

            <!-- Brand Logo Light -->
            <a href="index.html" class="logo logo-light">
                <span class="logo-lg">
                    <img src="{{ asset('assets/images/logo.jpg') }}" alt="logo" style="width:100%; height:60%">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('assets/images/logo.jpg') }}" alt="small logo"
                        style="width:100%; height:60%">
                </span>
            </a>

            <!-- Brand Logo Dark -->
            <a href="index.html" class="logo logo-dark">
                <span class="logo-lg">
                    <img src="{{ asset('assets/images/logo.jpg') }}" alt="dark logo" style="width:100%; height:60%">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('assets/images/logo.jpg') }}" alt="small logo"
                        style="width:100%; height:60%">
                </span>
            </a>

            <!-- Sidebar -left -->
            <div class="h-100 pl-2" id="leftside-menu-container" data-simplebar>
                <!--- Sidemenu -->
                <ul class="side-nav">
                    <li class="side-nav-title text-warning opacity-50">Gestion des Depots</li>

                    @canany(['is_caissier', 'is_gerant'])
                        <li class="side-nav-item">
                            <a href="{{ route('fournisseurs.index') }}" class="side-nav-link">
                                <i class="ri-truck-fill"></i> <span> Fournisseurs </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('clients.index') }}" class="side-nav-link">
                                <i class="ri-service-fill"></i>
                                <span> Clients </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('categories.index') }}" class="side-nav-link">
                                <i class="ri-group-fill"></i><span> Categories </span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('articles.index') }}" class="side-nav-link">
                                <i class="ri-goblet-fill"></i>
                                <span> Articles </span>
                            </a>
                        </li>
                        @can('is_caissier')
                            <li class="side-nav-item">
                                <a href="{{ route('sells.index') }}" class="side-nav-link">
                                    <i class="ri-shopping-cart-2-line"></i>
                                    <span> Ventes </span>
                                </a>
                            </li>
                        @endcan

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarPagesReport" aria-expanded="false"
                                aria-controls="sidebarPagesReport" class="side-nav-link">
                                <i class="ri-file-list-line"></i>
                                <span>Gestion Stocks</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarPagesReport">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="{{ route('approvisionnements.index') }}">Approvisionnements</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('inventaires.index') }}">Inventaires</a>
                                    </li>
                                    {{-- <li>
                                    <a href="">Sorties</a>
                                </li> --}}
                                </ul>
                            </div>
                        </li>
                    @endcanany
                    <li class="side-nav-item">
                        <a href="{{ route('invoices.index') }}" class="side-nav-link">
                            <i class="ri-currency-fill"></i>
                            <span> Factures </span>
                        </a>
                    </li>
                    @can('is_admin')
                        <li class="side-nav-item">
                            <a href="{{ route('depots.index') }}" class="side-nav-link">
                                <i class="ri-building-3-fill"></i> <span> Depot </span>
                            </a>
                        </li>
                        <hr>
                    @endcan
                    <li class="side-nav-item">
                        <a href="{{ route('users.index') }}" class="side-nav-link">
                            <i class="ri-p2p-line"></i>
                            <span> Utilisateurs </span>
                        </a>
                    </li>
                </ul>
                <br>
                <br class="mb-4">
                <!--- End Sidemenu -->

                <div class="clearfix"></div>
            </div>
        </div>
        <!-- ========== Left Sidebar End ========== -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container -->

            </div>
            <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 text-center">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © <b>DEPOT-</b>Burundi
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Theme Settings -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="theme-settings-offcanvas">
        <div class="d-flex align-items-center bg-primary p-3 offcanvas-header">
            <h5 class="text-white m-0">Theme Settings</h5>
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>

        <div class="offcanvas-body p-0">
            <div data-simplebar class="h-100">
                <div class="p-3">
                    <h5 class="mb-3 fs-16 fw-bold">Color Scheme</h5>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-check form-switch card-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="data-bs-theme"
                                    id="layout-color-light" value="light">
                                <label class="form-check-label" for="layout-color-light">
                                    <img src="{{ asset('assets/images/layouts/light.png') }}" alt=""
                                        class="img-fluid">
                                </label>
                            </div>
                            <h5 class="font-14 text-center text-muted mt-2">Light</h5>
                        </div>

                        <div class="col-4">
                            <div class="form-check form-switch card-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="data-bs-theme"
                                    id="layout-color-dark" value="dark">
                                <label class="form-check-label" for="layout-color-dark">
                                    <img src="{{ asset('assets/images/layouts/dark.png') }}" alt=""
                                        class="img-fluid">
                                </label>
                            </div>
                            <h5 class="font-14 text-center text-muted mt-2">Dark</h5>
                        </div>
                    </div>

                    <div id="layout-width">
                        <h5 class="my-3 fs-16 fw-bold">Layout Mode</h5>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-check form-switch card-switch mb-1">
                                    <input class="form-check-input" type="checkbox" name="data-layout-mode"
                                        id="layout-mode-fluid" value="fluid">
                                    <label class="form-check-label" for="layout-mode-fluid">
                                        <img src="{{ asset('assets/images/layouts/light.png') }}" alt=""
                                            class="img-fluid">
                                    </label>
                                </div>
                                <h5 class="font-14 text-center text-muted mt-2">Fluid</h5>
                            </div>

                            <div class="col-4">
                                <div id="layout-boxed">
                                    <div class="form-check form-switch card-switch mb-1">
                                        <input class="form-check-input" type="checkbox" name="data-layout-mode"
                                            id="layout-mode-boxed" value="boxed">
                                        <label class="form-check-label" for="layout-mode-boxed">
                                            <img src="{{ asset('assets/images/layouts/boxed.png') }}" alt=""
                                                class="img-fluid">
                                        </label>
                                    </div>
                                    <h5 class="font-14 text-center text-muted mt-2">Boxed</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="my-3 fs-16 fw-bold">Topbar Color</h5>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-check form-switch card-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="data-topbar-color"
                                    id="topbar-color-light" value="light">
                                <label class="form-check-label" for="topbar-color-light">
                                    <img src="{{ asset('assets/images/layouts/light.png') }}" alt=""
                                        class="img-fluid">
                                </label>
                            </div>
                            <h5 class="font-14 text-center text-muted mt-2">Light</h5>
                        </div>

                        <div class="col-4">
                            <div class="form-check form-switch card-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="data-topbar-color"
                                    id="topbar-color-dark" value="dark">
                                <label class="form-check-label" for="topbar-color-dark">
                                    <img src="{{ asset('assets/images/layouts/topbar-dark.png') }}" alt=""
                                        class="img-fluid">
                                </label>
                            </div>
                            <h5 class="font-14 text-center text-muted mt-2">Dark</h5>
                        </div>
                    </div>

                    <div>
                        <h5 class="my-3 fs-16 fw-bold">Menu Color</h5>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-check form-switch card-switch mb-1">
                                    <input class="form-check-input" type="checkbox" name="data-menu-color"
                                        id="leftbar-color-light" value="light">
                                    <label class="form-check-label" for="leftbar-color-light">
                                        <img src="{{ asset('assets/images/layouts/sidebar-light.png') }}"
                                            alt="" class="img-fluid">
                                    </label>
                                </div>
                                <h5 class="font-14 text-center text-muted mt-2">Light</h5>
                            </div>

                            <div class="col-4">
                                <div class="form-check form-switch card-switch mb-1">
                                    <input class="form-check-input" type="checkbox" name="data-menu-color"
                                        id="leftbar-color-dark" value="dark">
                                    <label class="form-check-label" for="leftbar-color-dark">
                                        <img src="{{ asset('assets/images/layouts/light.png') }}" alt=""
                                            class="img-fluid">
                                    </label>
                                </div>
                                <h5 class="font-14 text-center text-muted mt-2">Dark</h5>
                            </div>
                        </div>
                    </div>

                    <div id="sidebar-size">
                        <h5 class="my-3 fs-16 fw-bold">Sidebar Size</h5>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-check form-switch card-switch mb-1">
                                    <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                        id="leftbar-size-default" value="default">
                                    <label class="form-check-label" for="leftbar-size-default">
                                        <img src="{{ asset('assets/images/layouts/light.png') }}" alt=""
                                            class="img-fluid">
                                    </label>
                                </div>
                                <h5 class="font-14 text-center text-muted mt-2">Default</h5>
                            </div>

                            <div class="col-4">
                                <div class="form-check form-switch card-switch mb-1">
                                    <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                        id="leftbar-size-compact" value="compact">
                                    <label class="form-check-label" for="leftbar-size-compact">
                                        <img src="{{ asset('assets/images/layouts/compact.png') }}" alt=""
                                            class="img-fluid">
                                    </label>
                                </div>
                                <h5 class="font-14 text-center text-muted mt-2">Compact</h5>
                            </div>

                            <div class="col-4">
                                <div class="form-check form-switch card-switch mb-1">
                                    <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                        id="leftbar-size-small" value="condensed">
                                    <label class="form-check-label" for="leftbar-size-small">
                                        <img src="{{ asset('assets/images/layouts/sm.png') }}" alt=""
                                            class="img-fluid">
                                    </label>
                                </div>
                                <h5 class="font-14 text-center text-muted mt-2">Condensed</h5>
                            </div>


                            <div class="col-4">
                                <div class="form-check form-switch card-switch mb-1">
                                    <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                        id="leftbar-size-full" value="full">
                                    <label class="form-check-label" for="leftbar-size-full">
                                        <img src="{{ asset('assets/images/layouts/full.png') }}" alt=""
                                            class="img-fluid">
                                    </label>
                                </div>
                                <h5 class="font-14 text-center text-muted mt-2">Full Layout</h5>
                            </div>
                        </div>
                    </div>

                    <div id="layout-position">
                        <h5 class="my-3 fs-16 fw-bold">Layout Position</h5>

                        <div class="btn-group checkbox" role="group">
                            <input type="radio" class="btn-check" name="data-layout-position"
                                id="layout-position-fixed" value="fixed">
                            <label class="btn btn-soft-primary w-sm" for="layout-position-fixed">Fixed</label>

                            <input type="radio" class="btn-check" name="data-layout-position"
                                id="layout-position-scrollable" value="scrollable">
                            <label class="btn btn-soft-primary w-sm ms-0"
                                for="layout-position-scrollable">Scrollable</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas-footer border-top p-3 text-center">
            <div class="row">
                <div class="col-6">
                    <button type="button" class="btn btn-light w-100" id="reset-layout">Reset</button>
                </div>
                <div class="col-6">
                    <a href="https://1.envato.market/velonic" target="_blank" role="button"
                        class="btn btn-primary w-100">Buy Now</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->

    <!-- Modal -->
    <div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document" id="hoo">
            <div class="modal-content">
                <div class="text text-center">
                    <h5 class="p-2 modal-title h4 fw-bold text-center" id="exampleModalLabel">Changer la Boutique</h5>
                </div>
                <hr>
                <div class="modal-body text-center h4  text-success">
                    <i class="ri-store-2-line text-info fs-22"></i>
                    <p class="mb-3">Changer la Boutique Courant</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                        id="closeModal">Fermer</button>
                    <button type="button" class="btn btn-primary" id="approveChanges">Oui,Changer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor js -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>

    <!-- Daterangepicker js -->
    <script src="{{ asset('assets/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Bootstrap Datepicker Plugin js -->
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <!-- Apex Charts js -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>

    <!-- sweetalert2 js  -->
    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <!-- Daterangepicker js -->
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
    <!-- Apex Charts js -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <!-- Vector Map js -->
    <script src="{{ asset('assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}">
    </script>
    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>

    <!-- Dashboard App js -->
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>

    <!-- DataTable Js  -->
    <script src="{{ asset('assets/js/pages/datatable.init.js') }}"></script>

    <!--  Select2 Plugin Js -->
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>


    <script src="{{ asset('assets/vendor/sheetjs/xlsx.full.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datetimepicker/build/jquery.datetimepicker.full.js') }}"></script>

    <!-- Custom content script for each module -->
    <!-- Dashboard App js -->

    @if (Session::has('success'))
        <div class="alert alert-success">
            <script>
                Swal.fire({
                    position: 'top-center',
                    icon: 'success',
                    title: "{{ Session::get('success') }}",
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>
        </div>
    @endif
    @if (Session::has('update'))
        <div class="alert alert-warning">
            <script>
                Swal.fire({
                    position: 'top-center',
                    icon: 'info',
                    title: "{{ Session::get('update') }}",
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>
        </div>
    @endif
    @if (Session::has('delete'))
        <div class="alert alert-danger">
            <script>
                Swal.fire({
                    position: 'top-center',
                    icon: 'warning',
                    title: "{{ Session::get('delete') }}",
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>
        </div>
    @endif
    <script>
        const setIsCurrent = (id) => {
            let year = document.getElementById(`budgettery${id}`);
            let current = year.getAttribute("data-name");
            $("#approvalModal").modal("show", true);
            $("#closeModal").on("click", function() {
                $("#approvalModal").hide();
                window.location.reload();
            })
            $("#approveChanges").on("click", function() {
                $.ajax({
                    url: "{{ url('changeworkingYear') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        store: current
                    },
                    success: function(data) {
                        console.log(data)
                        if (data.status == 200) {
                            window.location.reload();
                        }
                    },
                });
            })

        }
    </script>

    @yield('js_content')

</body>

<!-- Mirrored from techzaa.getappui.com/velonic/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 07 Sep 2023 09:39:49 GMT -->

</html>
