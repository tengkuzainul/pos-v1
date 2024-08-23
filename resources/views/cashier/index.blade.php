@extends('layouts.cashier.app')

@section('content')
    <style>
        .scrollable-card-body {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>

    <div class="row mb-5">
        <div class="col-lg-7">
            <p class="h3 text-dark text-center mb-3 font-weight-bold">
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
                <p class="h3 text-dark text-center mb-3 font-weight-bold">Cart</p>
                <div class="card shadow-lg">
                    <div class="card-body p-3 scrollable-card-body">
                        @if ($cart && $cart->isNotEmpty())
                            @foreach ($cart as $item)
                                <div class="d-flex justify-content-between align-items-center gap-2 mb-3 cart-item">
                                    <img src="{{ $item->attributes->image ? asset('storage/' . $item->attributes->image) : asset('assets/image/empty-image.webp') }}"
                                        alt="{{ $item->name }}" class="img-thumbnail border-0" width="50"
                                        height="50">
                                    <div class="d-flex flex-column">
                                        <p class="text-dark mb-0 font-weight-bold">{{ $item->name }}</p>
                                        <p class="text-primary mb-0">Rp. {{ number_format($item->price) }}</p>
                                    </div>
                                    <div class="d-flex flex-column ms-4 align-items-end">
                                        <p class="text-danger mb-1 sub-total">Rp. {{ number_format($item->getPriceSum()) }}
                                        </p>
                                        <div class="d-flex justify-content-end gap-2 align-items-center">
                                            <p class="text-dark mb-0 font-weight-bold">Qty</p>
                                            <input name="qty" type="number"
                                                class="form-control form-control-sm w-25 qty-input" min="1"
                                                value="{{ $item->quantity }}" readonly disabled>
                                        </div>
                                        <form action="{{ route('removeFromCart') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="uuid" value="{{ $item->id }}">
                                            <button type="submit" class="btn btn-sm btn-danger my-2">
                                                <i class="ti ti-trash me-2"></i> Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                            <div
                                class="my-3 d-flex justify-content-between align-items-center border-top border-bottom border-dark">
                                <p class="h4 text-dark my-1 ms-1 font-weight-bold">Total</p>
                                <p class="h4 text-dark my-1 me-1 font-weight-bold" id="totalPayment">Rp.
                                    {{ number_format($total) }}</p>
                            </div>
                            <form action="{{ route('transaction.store') }}" method="POST">
                                @csrf
                                <div class="my-3 d-flex align-items-center justify-content-evenly gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input @error('payment_method') is-invalid @enderror"
                                            type="radio" name="payment_method" value="cash" id="paymentCash">
                                        <label class="form-check-label text-dark" for="paymentCash">Cash</label>
                                        @error('payment_method')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input @error('payment_method') is-invalid @enderror"
                                            type="radio" name="payment_method" value="QRIS" id="paymentQRIS">
                                        <label class="form-check-label text-dark" for="paymentQRIS">QRIS</label>
                                        @error('payment_method')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="my-3 px-3">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <input type="number"
                                            class="form-control @error('payment_amount') is-invalid @enderror"
                                            name="payment_amount" id="payment_amount" placeholder="Payment Amount">
                                        @error('payment_amount')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="my-3 d-flex justify-content-center gap-2 align-items-center">
                                    <button type="submit" class="btn btn-success w-100">Process Payment</button>
                                </div>
                            </form>
                        @else
                            <p class="mb-0 h6 border py-2 border-danger text-danger text-center" id="empty-cart-message">No
                                items in cart</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('invoice'))
        <div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="invoiceModalLabel">Invoice #{{ session('invoice')->invoice_no }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Invoice Details -->
                        <div class="row">
                            <div class="col-md-5">
                                <div class="d-flex flex-column">
                                    <p class="text-dark"><strong>Total Price</strong></p>
                                    <p class="text-dark"><strong>Payment Method</strong></p>
                                    <p class="text-dark"><strong>Payment Amount</strong></p>
                                    <p class="text-dark"><strong>Refund Payment</strong></p>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="d-flex flex-column">
                                    <p class="text-dark"><strong>: Rp.
                                            {{ number_format(session('invoice')->transaction->total_price) }}</strong></p>
                                    <p class="text-dark text-capitalize"><strong>:
                                            {{ session('invoice')->transaction->payment_method }}</strong></p>
                                    <p class="text-dark"><strong>: Rp.
                                            {{ number_format(session('invoice')->transaction->payment_amount) }}</strong>
                                    </p>
                                    <p class="text-dark"><strong>: Rp.
                                            {{ number_format(session('invoice')->transaction->refund_payment) }}</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="my-">
                            <h5 class="text-dark mb-2">Product Items</h5>
                            <ul class="list-group list-group-flush">
                                @foreach (session('invoice')->transaction->transactionItems as $item)
                                    <li class="list-group-item text-dark">{{ $item->product->name }} | Qty :
                                        {{ $item->qty }} | Sub Total: Rp. {{ number_format($item->sub_total) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                class="ti ti-circle-x me-2"></i>Close</button>
                        <button type="button" class="btn btn-primary"><i class="ti ti-printer me-2"></i>Print
                            Invoice</button>
                        @if (session('invoice')->transaction->payment_method === 'QRIS')
                            <button type="button" id="pay-button" class="btn btn-dark"><i
                                    class="ti ti-printer me-2"></i>Pay QRIS</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var invoiceModal = new bootstrap.Modal(document.getElementById('invoiceModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                invoiceModal.show();
            });
        </script>

        <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
        <script type="text/javascript">
            document.getElementById('pay-button').onclick = function() {
                snap.pay("{{ session('snapToken') }}", {
                    onSuccess: function(result) {
                        Swal.fire({
                            title: 'Payment Success!',
                            text: 'Your payment was successful.',
                            icon: 'success',
                            showCloseButton: true, // Show the close button
                            timer: 5000, // Auto close after 5 seconds
                            timerProgressBar: true, // Optional: Show progress bar
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });
                    },
                    onPending: function(result) {
                        alert('Payment pending!');
                        window.location.reload();
                    },
                    onError: function(result) {
                        alert('Payment failed!');
                        window.location.reload();
                    },
                    onClose: function() {
                        alert('Payment popup closed!');
                        window.location.reload();
                    }
                });
            };
        </script>
    @endif
@endsection
