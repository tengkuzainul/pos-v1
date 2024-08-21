@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between mb-3">
            <h1 class="fw-bold display-6 text-primary">Role</h1>
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Role</li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-12">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <p class="h3 card-title text-dark mb-3">Roles</p>

                        {{-- <button type="button" class="btn btn-success btn-sm px-3"><i class="ti ti-plus me-2"></i>New
                            Data</button> --}}
                    </div>

                    <div class="row">
                        <div class="col-md-9 my-2">
                            <div class="d-flex gap-2 align-items-center">
                                <a href="{{ route('role.print') }}" target="_blank"
                                    class="btn btn-sm btn-primary px-3 my-2"><i class="ti ti-printer me-2"></i>Print</a>

                                <a href="{{ route('role.pdf') }}" target="_blank"
                                    class="btn btn-sm btn-primary px-3 my-2"><i class="ti ti-file-text me-2"></i>PDF</a>

                                <a href="{{ route('role.excel') }}" class="btn btn-sm btn-primary px-3 my-2"><i
                                        class="ti ti-file-spreadsheet me-2"></i>Excel</a>

                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle px-3 my-2" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-arrows-sort me-2"></i>Sort By
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('role.index', ['sort_by' => 'name', 'sort_order' => 'asc']) }}">Role
                                                Name Ascending</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('role.index', ['sort_by' => 'name', 'sort_order' => 'desc']) }}">Role
                                                Name Descending</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 my-2">
                            <form action="{{ route('role.index') }}" method="GET">
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
                                    <th class="text-dark">Role Name</th>
                                    <th class="text-dark" style="width: 200px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($roles as $role)
                                    <tr>
                                        <td class="text-dark">{{ $loop->iteration }}</td>
                                        <td class="text-dark">{{ $role->name }}</td>
                                        <td>
                                            <div class="d-flex justiy-content-center align-items-center gap-3">
                                                <a href="{{ route('role.show', $role->name) }}"
                                                    class="btn btn-sm rounded btn-warning px-2 py-1"><i
                                                        class="ti ti-eye"></i></a>
                                                <a href="{{ route('role.destroy', $role->uuid) }}"
                                                    class="btn btn-sm rounded btn-danger px-2 py-1"
                                                    data-confirm-delete="true"><i class="ti ti-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-dark">Data tidak Ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-dark" style="width: 100px">No</th>
                                    <th class="text-dark">Role Name</th>
                                    <th class="text-dark" style="width: 200px">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                        {{ $roles->links('pagination::bootstrap-5', ['class' => 'pagination-sm px-2']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
