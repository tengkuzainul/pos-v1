@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between mb-3">
            <h1 class="fw-bold display-6 text-primary">All Category</h1>
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Category</li>
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
                        <p class="h3 card-title text-dark mb-3">Form Create Category Data</p>
                    </div>

                    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div id="dynamic-form-container">
                            <div class="dynamic-form-item d-flex justify-content-start align-items-center gap-2 mb-2">
                                <div class="form-group flex-grow-1">
                                    <label for="name" class="text-dark mb-2">Category Name</label>
                                    <input type="text" name="name[]"
                                        class="form-control @error('name.*') is-invalid @enderror w-100"
                                        placeholder="Category Name" autofocus>
                                    @error('name.*')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group align-self-end">
                                    <button type="button" class="btn btn-danger px-3 remove-dynamic-form">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="float-end align-items-center mt-4">
                            <div class="d-flex gap-2">
                                <button type="button" id="add-dynamic-form" class="btn btn-primary">
                                    <i class="ti ti-circle-plus me-2"></i>Add Form
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="ti ti-circle-check me-2"></i>Save Data
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <p class="h3 card-title text-dark mb-3">Categories</p>
                        </div>

                        <div class="row">
                            <div class="col-md-9 my-2">
                                <div class="d-flex gap-2 align-items-center">
                                    <a href="#" target="_blank" class="btn btn-sm btn-primary px-3 my-2"><i
                                            class="ti ti-printer me-2"></i>Print</a>

                                    <a href="#" target="_blank" class="btn btn-sm btn-primary px-3 my-2"><i
                                            class="ti ti-file-text me-2"></i>PDF</a>

                                    <a href="#" class="btn btn-sm btn-primary px-3 my-2"><i
                                            class="ti ti-file-spreadsheet me-2"></i>Excel</a>

                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-sm dropdown-toggle px-3 my-2" type="button"
                                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-arrows-sort me-2"></i>Sort By
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('category.index', ['sort_by' => 'name', 'sort_order' => 'asc']) }}">Category
                                                    Name Ascending</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('category.index', ['sort_by' => 'name', 'sort_order' => 'desc']) }}">Category
                                                    Name Descending</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 my-2">
                                <form action="{{ route('category.index') }}" method="GET">
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
                                        <th class="text-dark">Category Name</th>
                                        <th class="text-dark" style="width: 200px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($categories as $category)
                                        <tr>
                                            <td class="text-dark">{{ $loop->iteration }}</td>
                                            <td class="text-dark">{{ $category->name }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center gap-3">
                                                    <a href="#" class="btn btn-sm rounded btn-warning px-2 py-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalEdit{{ $category->uuid }}">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm rounded btn-danger px-2 py-1"
                                                        data-confirm-delete="true">
                                                        <i class="ti ti-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="modalEdit{{ $category->uuid }}" tabindex="-1"
                                            aria-labelledby="modalLabel{{ $category->uuid }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalLabel{{ $category->uuid }}">Edit
                                                            Category</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('category.update', $category->uuid) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="name" class="mb-2 text-dark">Category
                                                                        Name</label>
                                                                    <input type="text" name="name" id="name"
                                                                        value="{{ old('name', $category->name) }}"
                                                                        class="form-control @error('name') is-invalid @enderror"
                                                                        placeholder="Category Name"
                                                                        aria-label="Category Name">
                                                                    @error('name')
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="reset" class="btn btn-outline-danger px-3"><i
                                                                    class="ti ti-circle-x me-2"></i>Reset Form</button>
                                                            <button type="submit" class="btn btn-success px-3"><i
                                                                    class="ti ti-circle-check me-2"></i>Save
                                                                Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal End -->
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-dark">Data tidak ditemukan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-dark" style="width: 100px">No</th>
                                        <th class="text-dark">Category Name</th>
                                        <th class="text-dark" style="width: 200px">Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                            {{ $categories->links('pagination::bootstrap-5', ['class' => 'pagination-sm px-2']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('dynamicFormJS')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addButton = document.getElementById('add-dynamic-form');
            const container = document.getElementById('dynamic-form-container');

            addButton.addEventListener('click', function() {
                const newItem = document.createElement('div');
                newItem.classList.add('dynamic-form-item', 'd-flex', 'justify-content-start',
                    'align-items-center', 'gap-2', 'mb-2');
                newItem.innerHTML = `
            <div class="form-group flex-grow-1">
                <label for="name" class="text-dark mb-2">Category Name</label>
                <input type="text" name="name[]" class="form-control w-100" placeholder="Category Name" autofocus>
            </div>
            <div class="form-group align-self-end">
                <button type="button" class="btn btn-danger px-3 remove-dynamic-form">
                    <i class="ti ti-trash"></i>
                </button>
            </div>
        `;
                container.appendChild(newItem);
            });

            container.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-dynamic-form')) {
                    e.target.closest('.dynamic-form-item').remove();
                }
            });
        });
    </script>
@endpush
