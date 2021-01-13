<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/') }}/css/sb-admin-2.min.css" rel="stylesheet">
    @stack('css')
</head>
<body>
    <div id="app">
 
        {{-- <main class="py-4"> --}}
            <div id="wrapper">
                <x-partial.backend.side-bar/>
                <div id="content-wrapper" class="d-flex flex-column">
                   
                    <!-- Main Content -->
                    <div id="content">
                        <x-partial.backend.nav-bar/>
                        <div class="container-fluid">
                            <x-partial.frontend.flash />
                        </div>
                        @yield('content')
                    </div>
                    <x-partial.backend.footer/>
                </div>
            </div>
        {{-- </main> --}}
    </div>
    <script src="{{ asset('js/app.js') }}" ></script>
    <!-- Bootstrap core JavaScript-->
     {{-- <script src="{{ asset('backend/') }}/vendor/jquery/jquery.min.js"></script> --}}
     {{-- <script src="{{ asset('backend/') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
     <!-- Core plugin JavaScript-->
     {{-- <script src="{{ asset('backend/') }}/vendor/jquery-easing/jquery.easing.min.js"></script> --}}
 
     <!-- Custom scripts for all pages-->
     <script src="{{ asset('backend/') }}/js/sb-admin-2.min.js"></script>
 
     <!-- Page level plugins -->
     <script src="{{ asset('backend/') }}/vendor/chart.js/Chart.min.js"></script>
 
     <!-- Page level custom scripts -->
     {{-- <script src="{{ asset('backend/') }}/js/demo/chart-area-demo.js"></script> --}}
     {{-- <script src="{{ asset('backend/') }}/js/demo/chart-pie-demo.js"></script> --}}
    @stack('js')
</body>
</html>
