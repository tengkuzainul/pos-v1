@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between mb-3">
            <h1 class="fw-bold display-6 text-primary">Product Stock</h1>
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Product Stock</li>
                </ol>
            </nav>
        </div>

        <div class="col-lg-12">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <p class="h3 card-title text-dark mb-3">Product Stocks</p>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-9">
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('product.stock') }}" method="GET">
                                <input type="search" name="search" value="{{ request('search') }}"
                                    class="form-control form-control-sm" placeholder="Search...">
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered border-dark table-sm table-striped table-hover mt-3">
                            <thead>
                                <tr>
                                    <th class="text-dark" style="width: 60px">No</th>
                                    <th class="text-dark">Product Image</th>
                                    <th class="text-dark">Product Name</th>
                                    <th class="text-dark">Product Stock</th>
                                    <th class="text-dark">Avaliable</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td class="text-dark">{{ $loop->iteration }}</td>
                                        <td class="text-dark">
                                        @empty($product->image_thumbnail)
                                            <img src="{{ asset('assets/image/empty-image.webp') }}"
                                                class="img-thumbnail rounded shadow" alt="{{ $product->name }}"
                                                width="50">
                                        @else
                                            <img src="{{ asset('storage/' . $product->image_thumbnail) }}"
                                                class="img-thumbnail rounded shadow" alt="{{ $product->name }}"
                                                width="50">
                                        @endempty
                                    </td>
                                    <td class="text-dark">{{ $product->name }}</td>
                                    <td class="text-dark">{{ $product->stock }} /Pcs</td>
                                    <td class="text-dark"><span
                                            class="badge px-3 py-1 {{ $product->available == true ? 'text-bg-success' : 'text-bg-danger' }}">{{ $product->available == true ? 'Ready' : 'Unready' }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-dark">Data tidak ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-dark" style="width: 60px">No</th>
                                <th class="text-dark">Product Image</th>
                                <th class="text-dark">Product Name</th>
                                <th class="text-dark">Product Stock</th>
                                <th class="text-dark">Avaliable</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $products->links('pagination::bootstrap-5', ['class' => 'pagination-sm px-2']) }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
