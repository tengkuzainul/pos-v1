<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Point Of Sales - V1.0</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/dashboard/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/styles.min.css') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="{{ url('/') }}"
                                    class="text-nowrap fw-bold display-6 logo-img text-center d-block py-3 w-100">
                                    <iconify-icon icon="weui:shop-filled"></iconify-icon> Point Of Sales
                                </a>
                                <p class="text-center">v1.0</p>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Username/Email</label>
                                        <input type="text"
                                            class="form-control @error('username') is-invalid @enderror"
                                            id="exampleInputEmail1" aria-describedby="emailHelp" name="username"
                                            value="{{ old('username') }}" autocomplete="username" autofocus
                                            placeholder="Input Username/Email">

                                        @error('username')
                                            <div class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            id="exampleInputPassword1" name="password" autocomplete="current-password"
                                            placeholder="Input Password">

                                        @error('password')
                                            <div class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>


                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input primary" type="checkbox" name="remember"
                                                id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label text-dark" for="flexCheckChecked">
                                                Remeber this Device
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign
                                        In</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ 'assets/dashboard/libs/jquery/dist/jquery.min.js' }}"></script>
    <script src="{{ 'assets/dashboard/libs/bootstrap/dist/js/bootstrap.bundle.min.js' }}"></script>
    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>
