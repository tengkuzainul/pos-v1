@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between mb-3">
            <h1 class="fw-bold display-6 text-primary">Product Edit</h1>
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">All Product</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <form action="{{ route('product.update', $product->uuid) }}" method="POST" enctype="multipart/form-data"
                class="col-6">
                @csrf
                @method('PUT')

                <div class="col-lg-12">
                    <div class="card w-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <p class="h3 card-title text-dark mb-3">Form Edit Product Data</p>
                            </div>

                            <div class="mb-3">
                                <label for="productName" class="form-label">Product Name <span><sup
                                            class="text-danger"><iconify-icon
                                                icon="mdi:required"></iconify-icon></sup></span></label>
                                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                    class="form-control @error('name') is-invalid @enderror" id="productName"
                                    placeholder="Input Product Name">

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Price <span><sup
                                            class="text-danger"><iconify-icon
                                                icon="mdi:required"></iconify-icon></sup></span></label>
                                <input type="number" name="price" value="{{ old('price', $product->price) }}"
                                    class="form-control @error('price') is-invalid @enderror" id="productPrice"
                                    placeholder="Input Price">

                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="productStock" class="form-label">Stock <span><sup
                                            class="text-danger"><iconify-icon
                                                icon="mdi:required"></iconify-icon></sup></span></label>
                                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                                    class="form-control @error('stock') is-invalid @enderror" id="productStock"
                                    placeholder="Input Stock">

                                @error('stock')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Select Category
                                    <span><sup class="text-danger"><iconify-icon
                                                icon="mdi:required"></iconify-icon></sup></span>
                                </label>
                                <select class="form-select select2 @error('category_id') is-invalid @enderror"
                                    id="validationServer04" name="category_id">
                                    <option selected disabled value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->uuid }}" class="text-capitalize"
                                            {{ old('category_id') == $category->uuid || $product->category_id == $category->uuid ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="productDescription" class="form-label">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="productDescription"
                                    placeholder="Description Product">{{ old('description', $product->description) }}</textarea>

                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="float-end align-items-center mt-3">
                                <div class="d-flex gap-2">
                                    <button type="reset" class="btn btn-outline-danger px-3"><i
                                            class="ti ti-circle-x me-2"></i>Reset Form</button>
                                    <button type="submit" class="btn btn-success px-3"><i
                                            class="ti ti-circle-check me-2"></i>Save Data</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <form action="{{ route('product.update.image', $product->uuid) }}" method="POST" enctype="multipart/form-data"
                class="col-6">
                @csrf
                @method('PUT')

                <div class="col-lg-12">
                    <div class="card w-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <p class="h3 card-title text-dark mb-3">Form Update Thumbnail</p>
                            </div>

                            <label class="text-dark mb-2">Old Thumbnail</label>
                            <div class="mb-3">
                                @empty($product->image_thumbnail)
                                    <img src="{{ asset('assets/image/empty-image.webp') }}"
                                        class="img-thumbnail rounded shadow" alt="{{ $product->name }}" width="50">
                                @else
                                    <img src="{{ asset('storage/' . $product->image_thumbnail) }}"
                                        class="img-thumbnail rounded shadow" alt="{{ $product->name }}" width="50">
                                @endempty
                            </div>

                            <div class="mb-3">
                                <label for="image_thumbnail" class="form-label">Product Thumbnails</label>
                                <input class="form-control @error('image_thumbnail') is-invalid @enderror"
                                    id="image_thumbnail" name="image_thumbnail" type="file"
                                    value="{{ old('image_thumbnail') }}">

                                @error('image_thumbnail')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <img src="" alt="" class="d-none" width="300" height="300"
                                    id="preview-image">
                            </div>


                            <div class="float-end align-items-center mt-3">
                                <div class="d-flex gap-2">
                                    <button type="reset" class="btn btn-outline-danger px-3"><i
                                            class="ti ti-circle-x me-2"></i>Reset Form</button>
                                    <button type="submit" class="btn btn-success px-3"><i
                                            class="ti ti-circle-check me-2"></i>Save Image</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>

    </div>
@endsection

@push('imagePreview')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image_thumbnail');
            const previewImage = document.getElementById('preview-image');

            imageInput.addEventListener('change', function() {
                const file = imageInput.files[0];
                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.classList.remove('d-none');
                    };

                    reader.readAsDataURL(file);
                } else {
                    previewImage.src = '';
                    previewImage.classList.add('d-none');
                }
            });

            // Initialize Select2
            $('.select2').select2({
                placeholder: "Select Category",
                allowClear: true
            });
        });
    </script>
@endpush
