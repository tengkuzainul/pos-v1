<div class="row">
    <!-- Kategori Kolom Kiri -->
    <div class="col-lg-2">
        <p class="h3 text-dark mb-3" style="font-weight: 700">Categories</p>
        @foreach ($categories as $category)
            <div class="col-md-12">
                <div class="d-flex flex-column mb-3">
                    <div class="card shadow-lg">
                        <div class="card-body p-3">
                            <h3 class="display-6 font-weight-bold text-center mb-2">
                                <iconify-icon icon="ph:coffee-fill"></iconify-icon>
                            </h3>
                            <button name="" type="button"
                                class="btn btn-dark w-100 px-3 text-center">{{ $category->name }}</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Semua Produk Kolom Tengah -->
    <div class="col-lg-6">
        <p class="h3 text-dark text-center mb-3" style="font-weight: 700">All Products</p>
        <div class="row align-items-center">
            @foreach ($products as $product)
                <div class="col-md-3">
                    <div class="card shadow">
                        <div class="card-body p-2">
                            <div class="card-image">
                                <img src="{{ $product->image_thumbnail ? asset('storage/' . $product->image_thumbnail) : asset('assets/image/empty-image.webp') }}"
                                    alt="" class="img-thumbnail rounded mb-2" width="100" height="100"
                                    loading="lazy">
                            </div>
                            <div class="card-text">
                                <div class="d-flex justify-content-between gap-1 align-items-center">
                                    <div class="text-dark">
                                        <p class="mb-0">{{ $product->name }}</p>
                                        <p class="mb-0" style="font-weight: 400">Rp.
                                            {{ number_format($product->price) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Card Penampung Cart Kolom Kanan -->
    <div class="col-lg-4">
        <p class="h3 text-dark text-center mb-3" style="font-weight: 700">Cart</p>
        <div class="card shadow-lg">
            <div class="card-body p-3">
                <!-- Konten Cart di sini -->
                <p class="mb-0">No items in cart</p>
                <!-- Tambahkan logika cart di sini -->
            </div>
        </div>
    </div>
</div>
