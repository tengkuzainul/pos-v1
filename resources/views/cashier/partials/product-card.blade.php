<div class="col-md-3">
    <div class="card shadow">
        <div class="card-body p-2">
            <div class="card-image">
                <img src="{{ $product->image_thumbnail ? asset('storage/' . $product->image_thumbnail) : asset('assets/image/empty-image.webp') }}"
                    alt="{{ $product->name }}" class="img-thumbnail rounded mb-2" width="100" height="100"
                    loading="lazy">
            </div>
            <div class="card-text">
                <div class="d-flex justify-content-between gap-1 align-items-center">
                    <div class="text-dark">
                        <p class="mb-0" style="font-size: 10px; font-weight: 800">{{ $product->name }}</p>
                        <p class="mb-0" style="font-weight: 700">Rp. {{ number_format($product->price) }}</p>
                    </div>
                </div>
                <div class="my-2">
                    <form action="{{ route('addToCart') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->uuid }}">
                        <button type="submit" class="btn btn-sm btn-dark w-100"
                            {{ $product->available === false || $product->stock === 0 ? 'disabled' : '' }}
                            aria-disabled="{{ $product->available === false || $product->stock === 0 ? 'true' : 'false' }}">
                            <i
                                class="ti ti-shopping-cart-{{ $product->available === false || $product->stock === 0 ? 'off' : 'plus' }}"></i>
                            {{ $product->available === false || $product->stock === 0 ? ' Empty' : ' Add to cart' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
