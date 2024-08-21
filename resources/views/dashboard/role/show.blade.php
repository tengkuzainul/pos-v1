@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between mb-3">
            <h1 class="fw-bold display-6 text-primary">Role Information</h1>
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Role</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Role Information</li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-12">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <p class="h3 card-title text-dark">Information</p>
                    </div>

                    <div class="row align-items-start">
                        <div class="col-md-2">
                            <p class="text-dark fw-bold my-3">Name</p>
                            <p class="text-dark fw-bold my-3">Guard</p>
                            <p class="text-dark fw-bold my-3">User List</p>
                        </div>

                        <div class="col-md-10">
                            <p class="text-dark fw-bold my-3">: {{ $role->name }}</p>
                            <p class="text-dark fw-bold my-3">: {{ $role->guard_name }}</p>
                            <ul>
                                <div class="d-flex gap-1">
                                    <li>:</li>
                                    @foreach ($role->users as $users)
                                        <li class="text-dark fw-bold">{{ $users->name }}</li>
                                    @endforeach
                                </div>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
