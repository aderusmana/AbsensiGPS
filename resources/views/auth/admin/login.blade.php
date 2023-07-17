<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Login - Admin E-Absensi </title>
    <!-- CSS files -->
    <link href="{{ asset('assetsAdmin') }}/dist/css/tabler.min.css?1684106062" rel="stylesheet" />
    <link href="{{ asset('assetsAdmin') }}/dist/css/tabler-flags.min.css?1684106062" rel="stylesheet" />
    <link href="{{ asset('assetsAdmin') }}/dist/css/tabler-payments.min.css?1684106062" rel="stylesheet" />
    <link href="{{ asset('assetsAdmin') }}/dist/css/tabler-vendors.min.css?1684106062" rel="stylesheet" />
    <link href="{{ asset('assetsAdmin') }}/dist/css/demo.min.css?1684106062" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body class=" d-flex flex-column">
    <script src="{{ asset('assetsAdmin') }}/dist/js/demo-theme.min.js?1684106062"></script>
    <div class="page page-center">
        <div class="container container-normal py-4">
            <div class="row align-items-center g-4">
                <div class="col-lg">
                    <div class="container-tight">
                        <div class="text-center mb-4">
                            <a href="." class="navbar-brand navbar-brand-autodark"><img
                                    src="{{ asset('assetsAdmin') }}/static/logo.svg" height="36" alt=""></a>
                        </div>
                        <div class="card card-md">
                            <div class="card-body">
                                <h2 class="h2 text-center mb-4">Login to your account</h2>
                                @if (session('error'))
                                    <div class="alert alert-outline alert-danger">
                                        <p>{{ session('error') }}</p>
                                    </div>
                                @endif
                                <form action="/admin/proseslogin" method="post" autocomplete="off" novalidate>
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Email address</label>
                                        <input type="email" class="form-control" placeholder="your@email.com"
                                            name="email" autocomplete="off">
                                    </div>
                                    <div class="mb-2">
                                        <div class="input-group input-group-flat">
                                            <input type="password" class="form-control" placeholder="Your password"
                                                name="password" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-check">
                                            <input type="checkbox" class="form-check-input" />
                                            <span class="form-check-label">Remember me on this device</span>
                                        </label>
                                    </div>
                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg d-none d-lg-block">
                    <img src="{{ asset('assetsAdmin') }}/static/illustrations/undraw_secure_login_pdn4.svg"
                        height="300" class="d-block mx-auto" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{ asset('assetsAdmin') }}/dist/js/tabler.min.js?1684106062" defer></script>
    <script src="{{ asset('assetsAdmin') }}/dist/js/demo.min.js?1684106062" defer></script>
</body>

</html>
