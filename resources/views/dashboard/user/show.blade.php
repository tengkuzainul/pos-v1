@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between mb-3">
            <h1 class="fw-bold display-6 text-primary">User Detail</h1>
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">All User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User Detail</li>
                </ol>
            </nav>
        </div>

        <div class="col-lg-8">
            <div class="card w-100">
                <div class="card-body">
                    <form action="{{ route('user.update', Str::slug($user->name)) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <p class="h3 card-title text-dark mb-3">Basic Information</p>
                            <button type="submit" class="btn btn-success px-3"><i class="ti ti-circle-check me-2"></i>Save
                                Update</button>
                        </div>

                        <div class="row g-3 align-items-center">
                            <div class="col-md-2">
                                <label for="name" class="col-form-label">Full Name</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" id="name" name="name"
                                    class="form-control form-control-sm @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="username" class="col-form-label">Username</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" id="username" name="username"
                                    class="form-control form-control-sm @error('username') is-invalid @enderror"
                                    value="{{ old('username', $user->username) }}">
                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="email" class="col-form-label">Email</label>
                            </div>
                            <div class="col-md-10">
                                <input type="email" id="email" name="email"
                                    class="form-control form-control-sm @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="role" class="col-form-label">Role</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" id="role" name="role" class="form-control form-control-sm"
                                    value="{{ $user->roles->first()->name }}" readonly disabled>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-lg-4">
            <div class="card w-100">
                <div class="card-body">
                    <form action="{{ route('user.reset.password', Str::slug($user->name)) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <p class="h3 card-title text-dark mb-3">Reset Password</p>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                id="new_password" name="new_password" placeholder="New Password">
                            @error('new_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="progress mt-2">
                                <div id="password-strength" class="progress-bar progress-bar-sm" role="progressbar"
                                    style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="confirmation_password" class="form-label">Confirmation Password</label>
                            <input type="password" class="form-control @error('confirmation_password') is-invalid @enderror"
                                id="confirmation_password" name="confirmation_password" placeholder="Confirmation Password">
                            @error('confirmation_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success w-100 text-center">
                            <i class="ti ti-circle-check me-2 mb-3"></i>Update Password
                        </button>

                    </form>
                </div>
            </div>
        </div>


        @if ($errors->any())
            <div class="col-lg-12">
                <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>
                                <div class="d-flex align-items-start">
                                    <i class="ti ti-alert-octagon me-2"></i>
                                    <p class="text-dark">{{ $error }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="col-lg-12">
            <div class="card w-100">
                <div class="card-body">
                    <form action="{{ route('user.permissions.update', Str::slug($user->name)) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div class="flex-column">
                                <p class="h3 card-title text-dark mb-3">Give Permission</p>
                                <button type="submit" class="btn btn-sm btn-primary px-3" name="action"
                                    value="give-all"><i class="ti ti-key me-2"></i>Give All
                                    Permission</button>
                            </div>
                            <button type="submit" class="btn btn-success px-3" name="action" value="give-selected"><i
                                    class="ti ti-key me-2"></i>Give User
                                Permission</button>
                        </div>

                        <div class="row align-items-start">
                            @foreach ($allPermissions as $permission)
                                <div class="col-md-3">
                                    <div class="form-check py-3">
                                        <input class="form-check-input primary" type="checkbox" name="permissions[]"
                                            value="{{ $permission->uuid }}" id="flexCheckChecked{{ $permission->uuid }}"
                                            {{ $user->permissions->contains($permission) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark"
                                            for="flexCheckChecked{{ $permission->uuid }}">{{ $permission->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('new_password').addEventListener('input', function() {
                var password = this.value;
                var strengthBar = document.getElementById('password-strength');
                var strength = 0;

                if (password.match(/[a-z]+/)) {
                    strength += 1;
                }
                if (password.match(/[A-Z]+/)) {
                    strength += 1;
                }
                if (password.match(/[0-9]+/)) {
                    strength += 1;
                }
                if (password.length >= 8) {
                    strength += 1;
                }

                switch (strength) {
                    case 1:
                        strengthBar.style.width = '25%';
                        strengthBar.classList.add('bg-danger');
                        strengthBar.classList.remove('bg-warning', 'bg-success');
                        break;
                    case 2:
                        strengthBar.style.width = '50%';
                        strengthBar.classList.add('bg-warning');
                        strengthBar.classList.remove('bg-danger', 'bg-success');
                        break;
                    case 3:
                        strengthBar.style.width = '75%';
                        strengthBar.classList.add('bg-info');
                        strengthBar.classList.remove('bg-danger', 'bg-warning', 'bg-success');
                        break;
                    case 4:
                        strengthBar.style.width = '100%';
                        strengthBar.classList.add('bg-success');
                        strengthBar.classList.remove('bg-danger', 'bg-warning', 'bg-info');
                        break;
                    default:
                        strengthBar.style.width = '0%';
                        strengthBar.classList.remove('bg-danger', 'bg-warning', 'bg-info', 'bg-success');
                }
            });
        </script>
    @endsection
