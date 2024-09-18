<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Fontawesome Icons -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- BoxIcons Css -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Material Design Icons Css -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <script src="{{ asset('assets/js/plugin.js') }}"></script>
    <!-- Custom Css -->
    <link href="{{ asset('assets/css/datatables-custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/0756825c13.js" crossorigin="anonymous"></script>
    <!-- swal -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Login - Maxy</title>
</head>

<body>
    <section style="height: 100vh">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="overflow-hidden card">
                        <div class="bg-primary-subtle">
                            <div class="row">
                                <div class="col-7 col">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Welcome Back!</h5>
                                        <p>Sign in to continue to CMS</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end col"><img
                                        src="{{ asset('assets/images/profile-img.png') }}" alt=""
                                        class="img-fluid"></div>
                            </div>
                        </div>
                        <div class="pt-0 card-body">
                            <div class="auth-logo"><a class="auth-logo-light" href="/">
                                    <div class="avatar-md profile-user-wid mb-4"><span
                                            class="avatar-title rounded-circle bg-light"><img
                                                src="{{ asset('assets/images/logo-m.png') }}" alt=""
                                                class="rounded-circle" height="34"></span></div>
                                </a><a class="auth-logo-dark" href="/">
                                    <div class="avatar-md profile-user-wid mb-4"><span
                                            class="avatar-title rounded-circle bg-light"><img
                                                src="{{ asset('assets/images/logo-m.png') }}" alt=""
                                                class="rounded-circle" height="34"></span></div>
                                </a></div>
                            <div class="p-2">
                                <form class="form-horizontal" {{ route('login') }} method="post">
                                    @csrf
                                    <div class="mb-3"><label class="form-label form-label">Username</label><input
                                            name="username" placeholder="Enter username" type="text"
                                            class="form-control form-control" aria-invalid="false" value=""></div>
                                    <div class="mb-3"><label class="form-label form-label">Password</label>
                                        <div class="input-group auth-pass-inputgroup"><input name="password"
                                                placeholder="Enter Password" id="password" type="password"
                                                class="form-control" aria-invalid="false" value=""><button
                                                class="btn btn-light " type="button" id="password-addon"><i
                                                    class="mdi mdi-eye-outline"></i></button></div>
                                    </div>
                                    <div class="form-check"><input type="checkbox" class="form-check-input"
                                            id="customControlInline"><label class="form-check-label"
                                            for="customControlInline">Remember me</label></div>
                                    <div class="mt-3 d-grid"><button class="btn btn-primary btn-block "
                                            type="submit">Log In</button></div>
                                    <div class="mt-4 text-center">
                                        <h5 class="font-size-14 mb-3">Sign in with</h5>
                                        <ul class="list-inline">
                                            <li class="list-inline-item"><a
                                                    class="social-list-item bg-primary text-white border-primary"
                                                    href="/pages-login"><i class="mdi mdi-facebook"></i></a></li>
                                            <li class="list-inline-item"><a
                                                    class="social-list-item bg-info text-white border-info"
                                                    href="/pages-login"><i class="mdi mdi-twitter"></i></a></li>
                                            <li class="list-inline-item"><a
                                                    class="social-list-item bg-danger text-white border-danger"
                                                    href="/pages-login"><i class="mdi mdi-google"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="mt-4 text-center"><a class="text-muted" href="/pages-forgot-pwd"><i
                                                class="mdi mdi-lock me-1"></i> Forgot your password?</a></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>Don't have an account ? <a class="fw-medium text-primary"
                                href="/register2">
                                Signup now </a> </p>
                        <p>© 2024 Skote. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const passwordInput = document.getElementById('password');
        const passwordInputBtn = document.getElementById('password-addon');

        passwordInputBtn.addEventListener('click', () => {
            passwordInput.type == 'password' ? passwordInput.type = 'text' : passwordInput.type = 'password';
        })
    </script>
</body>

</html>
