@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between mb-3">
            <h1 class="fw-bold display-6 text-primary">All User</h1>
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All User</li>
                </ol>
            </nav>
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
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <p class="h3 card-title text-dark mb-3">Users</p>

                        <button type="button" class="btn btn-success btn-sm px-3" data-bs-toggle="modal"
                            data-bs-target="#modalCreate"><i class="ti ti-plus me-2"></i>New
                            Data</button>
                    </div>

                    <!--- Model Create --->
                    <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">User Create Form</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="name" class="mb-2 text-dark">Full Name</label>
                                                <input type="text" name="name" value="{{ old('name') }}"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    placeholder="Full Name" aria-label="Full Name">
                                                @error('name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="username" class="mb-2 text-dark">Username</label>
                                                <input type="text" name="username" value="{{ old('username') }}"
                                                    class="form-control @error('username') is-invalid @enderror"
                                                    placeholder="Username" aria-label="Username">
                                                @error('username')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="email" class="mb-2 text-dark">Email</label>
                                                <input type="email" name="email" value="{{ old('email') }}"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    placeholder="Email" aria-label="Email">
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="password" class="mb-2 text-dark">Password</label>
                                                <input type="password" name="password" id="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="Password" aria-label="Password">
                                                @error('password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <div class="progress mt-2">
                                                    <div id="password-strength" class="progress-bar progress-bar-sm"
                                                        role="progressbar" style="width: 0%;" aria-valuenow="0"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>

                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="password_confirmation" class="mb-2 text-dark">Password
                                                    Confirmation</label>
                                                <input type="password" name="password_confirmation"
                                                    value="{{ old('password_confirmation') }}"
                                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                                    placeholder="Password Confirmation" aria-label="Password">
                                                @error('password_confirmation')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="role" class="mb-2 text-dark">Select
                                                    Role</label>
                                                <select id="role" name="role"
                                                    class="form-select @error('role') is-invalid @enderror">
                                                    <option selected disabled>--- Select ---</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->uuid }}"
                                                            {{ old('role') == $role->uuid ? 'selected' : '' }}>
                                                            {{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('role')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="permission"
                                                        name="permission" value="1"
                                                        {{ old('permission') == '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="permission">Give All
                                                        Permission</label>
                                                    <div id="permissionHelp" class="form-text mt-2 text-danger">
                                                        Ignore if you don't want to give all permissions
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-outline-danger px-3"><i
                                                class="ti ti-circle-x me-2"></i>Reset Form</button>
                                        <button type="submit" class="btn btn-success px-3"><i
                                                class="ti ti-circle-check me-2"></i>Save Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal -->

                    <div class="row">
                        <div class="col-md-9 my-2">
                            <div class="d-flex gap-2 align-items-center">
                                <a href="{{ route('user.print') }}" target="_blank"
                                    class="btn btn-sm btn-primary px-3 my-2"><i class="ti ti-printer me-2"></i>Print</a>

                                <a href="{{ route('user.pdf') }}" target="_blank"
                                    class="btn btn-sm btn-primary px-3 my-2"><i class="ti ti-file-text me-2"></i>PDF</a>

                                <a href="{{ route('user.excel') }}" class="btn btn-sm btn-primary px-3 my-2"><i
                                        class="ti ti-file-spreadsheet me-2"></i>Excel</a>

                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle px-3 my-2" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-arrows-sort me-2"></i>Sort By
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('user.index', ['sort_by' => 'name', 'sort_order' => 'asc']) }}">User
                                                Name Ascending</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('user.index', ['sort_by' => 'name', 'sort_order' => 'desc']) }}">User
                                                Name Descending</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 my-2">
                            <form action="{{ route('user.index') }}" method="GET">
                                <input type="search" name="search" value="{{ request('search') }}"
                                    class="form-control form-control-sm" placeholder="Search...">
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered border-dark table-sm table-striped table-hover mt-3">
                            <thead>
                                <tr>
                                    <th class="text-dark" style="width: 100px">No</th>
                                    <th class="text-dark">Name</th>
                                    <th class="text-dark">Role</th>
                                    <th class="text-dark" style="width: 200px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="text-dark">{{ $loop->iteration }}</td>
                                        <td class="text-dark">
                                            <div class="d-flex gap-3 align-items-center">
                                                <img src="{{ 'https://ui-avatars.com/api/?name=' . $user->name . '&rounded=true&background=635bff&color=fff' }}"
                                                    alt="" width="35" height="35" class="rounded-circle">
                                                <p class="text-dark">{{ $user->name }}</p>
                                            </div>
                                        </td>
                                        <td class="text-dark"><span
                                                class="badge text-bg-primary">{{ $user->roles->first()->name }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex justiy-content-center align-items-center gap-3">
                                                <a href="{{ route('user.show', Str::slug($user->name)) }}"
                                                    class="btn btn-sm rounded btn-info px-2 py-1"><i
                                                        class="ti ti-eye"></i></a>
                                                <a href="{{ route('user.destroy', $user->id) }}"
                                                    class="btn btn-sm rounded btn-danger px-2 py-1"
                                                    data-confirm-delete="true"><i class="ti ti-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-dark">Data tidak Ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-dark" style="width: 100px">No</th>
                                    <th class="text-dark">Name</th>
                                    <th class="text-dark">Role</th>
                                    <th class="text-dark" style="width: 200px">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                        {{ $users->links('pagination::bootstrap-5', ['class' => 'pagination-sm px-2']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('password-regex')
    <script>
        document.getElementById('password').addEventListener('input', function() {
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
@endpush
