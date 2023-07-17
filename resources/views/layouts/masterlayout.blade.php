<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>E-Absensi Karyawan</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="{{ asset('assets') }}/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets') }}/img/icon/192x192.png">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style.css">
    <link rel="manifest" href="{{ asset('__manifest.json') }}">
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />


</head>

<body style="background-color:#e9ecef;">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <!-- App Header -->
    @yield('header')
    <!-- * App Header -->



    <!-- App Capsule -->
    <div id="appCapsule">
        @yield('content')
    </div>
    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
    @include('layouts.bottomNav')
    <!-- * App Bottom Menu -->




    {{-- script --}}
    @include('layouts.script')

    {{-- script --}}


</body>

</html>
