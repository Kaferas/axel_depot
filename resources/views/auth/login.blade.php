<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 07 Sep 2023 09:42:12 GMT -->

<head>
    <meta charset="utf-8" />
    <title>HOME DEPOT | Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully responsive admin theme which can be used to build CRM, CMS,ERP etc." name="description" />
    <meta content="Kaferas" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Theme Config Js -->
    <script src="assets/js/config.js"></script>

    <!-- App css -->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg position-relative">
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10 ">
                    <div class="card p-3 m-3  overflow-hidden">
                        <div class="row g-0 ">
                            <div class="bg-dark col-lg-6 d-none d-lg-block p-2">
                                <img src="{{ asset('assets/images/logo.jpg') }}" alt=""
                                    style="background-size:cover" class="img-fluid rounded h-100">
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex flex-column h-100">
                                    <div class="auth-brand p-4">
                                        <a href="{{ route('login') }}" class="logo-light">
                                            <img src="{{ asset('assets/images/logo.jpg') }}" alt="logo"
                                                height="22">
                                        </a>

                                    </div>
                                    <div class="p-4 my-auto">
                                        <h4 class="fs-20 text-info">Connexion</h4>
                                        <hr>
                                        <!-- form -->
                                        <form action="{{ route('login') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="emailaddress" class="form-label"><i>Email
                                                        address</i></label>
                                                <input class="form-control" type="text" id="emailaddress"
                                                    value="{{ old('email') }}" name="email" required=""
                                                    placeholder="Enter your email">
                                                @error('email')
                                                    <div
                                                        class="mt-2 alert alert-danger text-bg-info bg-warning border-0 fade show">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <a href="auth-forgotpw.html" class="text-muted float-end"></a>
                                                <label for="password" class="form-label"><i>Password</i></label>
                                                <input class="form-control" type="password" required=""
                                                    name="password" id="password" value=""
                                                    placeholder="Enter your password">
                                                @error('password')
                                                    <div
                                                        class="mt-2 alert alert-danger text-bg-info bg-warning border-0 fade show">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="checkbox-signin"
                                                        name="remember">
                                                    <label class="form-check-label"
                                                        for="checkbox-signin"><i>Souviens</i>
                                                        moi</label>
                                                </div>
                                            </div>
                                            <div class="mb-0 text-start">
                                                <button class="btn btn-primary w-100" type="submit"><i
                                                        class="ri-login-circle-fill me-1"></i> <span
                                                        class="fw-bold">Connexion
                                                    </span> </button>
                                            </div>


                                        </form>
                                        <!-- end form-->
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <footer class="footer footer-alt fw-medium">
        <span class="text-dark">
            <script>
                document.write("2023-" + new Date().getFullYear())
            </script> ©HOME DEPOT
        </span>
    </footer>
    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 07 Sep 2023 09:42:12 GMT -->

</html>
