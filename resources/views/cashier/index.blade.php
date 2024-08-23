@extends('layouts.cashier.app')

@section('content')
    <div class="row mb-5">
        <div class="col-lg-7">
            <p class="h3 text-dark text-center mb-3" style="font-weight: 700">
                {{ request('category_id') ? $categories->firstWhere('uuid', request('category_id'))->name : 'All Products' }}
            </p>
            <div class="row align-items-top" id="product-list">
                @forelse ($products as $product)
                    @include('cashier.partials.product-card', ['product' => $product])
                @empty
                    <p class="text-center">No products found for this category.</p>
                @endforelse
            </div>
        </div>

        <!-- Cart Container on the Right Column -->
        <div class="col-lg-5">
            <div class="position-fixed" style="width: 30%">
                <p class="h3 text-dark text-center mb-3" style="font-weight: 700">Cart</p>
                <div class="card shadow-lg">
                    <div class="card-body p-3">
                        @if ($cart && $cart->isNotEmpty())
                            @foreach ($cart as $item)
                                <div class="d-flex justify-content-between align-items-center gap-2 mb-3 cart-item">
                                    <img src="{{ $item->attributes->image ? asset('storage/' . $item->attributes->image) : asset('assets/image/empty-image.webp') }}"
                                        alt="{{ $item->name }}" class="img-thumbnail border-0" width="50"
                                        height="50">

                                    <div class="d-flex flex-column">
                                        <p class="text-dark mb-0" style="font-weight: 700">{{ $item->name }}</p>
                                        <p class="text-primary mb-0">Rp. {{ number_format($item->price) }}</p>
                                    </div>

                                    <div class="d-flex flex-column ms-4 align-items-end">
                                        <p class="text-danger mb-1 sub-total">
                                            Rp. {{ number_format($item->getPriceSum()) }}
                                        </p>
                                        <div class="d-flex justify-content-end gap-2 align-items-center">
                                            <p class="text-dark mb-0" style="font-weight: 800">Qty</p>
                                            <input name="qty" type="number"
                                                class="form-control form-control-sm w-25 qty-input" min="1"
                                                value="{{ $item->quantity }}" readonly disabled>
                                        </div>
                                        <form action="{{ route('removeFromCart') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="uuid" value="{{ $item->id }}">
                                            <!-- Ensure this is the correct UUID or ID -->
                                            <button type="submit" class="btn btn-sm btn-danger my-2">
                                                <i class="ti ti-trash me-2"></i> Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach

                            <div
                                class="my-3 d-flex justify-content-between align-items-center border-top border-bottom border-dark">
                                <p class="h4 text-dark my-1 ms-1" style="font-weight: 800">Total</p>
                                <p class="h4 text-dark my-1 me-1" style="font-weight: 800" id="totalPayment">Rp.
                                    {{ number_format($total) }}
                                </p>
                            </div>

                            <div class="my-3 d-flex align-items-center justify-content-evenly gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" value="cash"
                                        id="paymentCash">
                                    <label class="form-check-label" for="paymentCash">Cash</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" value="QRIS"
                                        id="paymentQRIS">
                                    <label class="form-check-label" for="paymentQRIS">QRIS</label>
                                </div>
                            </div>

                            <div class="my-3 px-3">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <input type="number" class="form-control" name="payment_amount" id="payment_amount"
                                        placeholder="Payment Amount">
                                </div>
                            </div>

                            <div class="my-3">
                                <button type="submit" class="btn btn-success w-100" name="submit_transaction">Complete
                                    Transaction</button>
                            </div>
                        @else
                            <p class="mb-0 h6 border py-2 border-danger text-danger text-center" id="empty-cart-message">No
                                items in cart</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function decreaseQuantity(button) {
            var input = button.parentNode.querySelector('input[type=number]');
            var currentValue = parseInt(input.value, 10);
            if (currentValue > parseInt(input.min, 10)) {
                input.value = currentValue - 1;
            }
        }

        function increaseQuantity(button) {
            var input = button.parentNode.querySelector('input[type=number]');
            input.value = parseInt(input.value, 10) + 1;
        }
    </script>

@endsection
