<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Point Of Sales - V1.0</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/dashboard/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/styles.min.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('yajra/style.css') }}" /> --}}

    <!-- FilePond styles -->
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>


<body>
    <!--  Sweet Alert RealRashid -->
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!-- Sidebar Start -->
        @include('layouts.cashier.sidebar')
        <!--  Sidebar End -->

        <!--  Main wrapper -->
        <div class="body-wrapper">

            <!--  Header Start -->
            @include('layouts.partials.header')
            <!--  Header End -->

            <div class="body-wrapper-inner">
                <div class="container-fluid">

                    <!--  Content -->
                    @yield('content')

                    <!--  Footer -->
                    <div class="py-6 px-6 d-flex justify-content-between align-items-center">
                        <p class="mb-0 fs-4">&copy; Develop by {{ date('Y') }} <a
                                href="https://github.com/tengkuzainul" target="_blank"
                                class="pe-1 text-primary text-decoration-none">Tengku Muhammad Zainul Aprilizar</a>
                        </p>
                        <p class="mb-0 fs-4">Design & template by <a href="https://adminmart.com/" target="_blank"
                                class="pe-1 text-primary text-decoration-none">AdminMart.com</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery dan Bootstrap -->
    <script src="{{ asset('assets/dashboard/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/dashboard.js') }}"></script>

    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

    @stack('password-regex')
    @stack('dynamicFormJS')


    @stack('imagePreview')

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/dashboard/js/cashier.js') }}"></script>

</body>

</html>
