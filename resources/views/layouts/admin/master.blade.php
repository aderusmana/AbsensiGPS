@include('layouts.admin.head')

<body>
    <script src="{{ asset('assetsAdmin') }}/dist/js/demo-theme.min.js?1684106062"></script>
    <div class="page">
        <!-- Sidebar -->
        @include('layouts.admin.sidebar')
        <!-- Sidebar -->

        <!-- Navbar -->
        @include('layouts.admin.navbar')
        <!-- Navbar -->
        <div class="page-wrapper">
            @yield('content')


            {{-- footer  --}}
            @include('layouts.admin.footer')
            {{-- footer  --}}


        </div>
    </div>

    {{-- //Script  --}}
    @include('layouts.admin.script')
</body>

</html>
