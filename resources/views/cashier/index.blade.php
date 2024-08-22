@extends('layouts.cashier.app')

@section('content')
    <div class="row mb-5">
        <div class="col-lg-7">
            <p class="h3 text-dark text-center mb-3" style="font-weight: 700">All Products</p>
            <div class="row align-items-top" id="product-list">
                @foreach ($products as $product)
                    @include('cashier.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>

        <!-- Cart Container on the Right Column -->
        <div class="col-lg-5">
            <div class="position-fixed" style="width: 30%">
                <p class="h3 text-dark text-center mb-3" style="font-weight: 700">Cart</p>
                <div class="card shadow-lg">
                    <div class="card-body p-3">
                        <div id="cart-items-container">
                            <!-- Cart items will be appended here -->
                            <p class="mb-0 h6 border py-2 border-danger text-danger text-center" id="empty-cart-message"
                                style="display: none;">No items in cart</p>
                        </div>

                        <!-- Total Payment Display -->
                        <div
                            class="my-3 d-flex justify-content-between align-items-center border-top border-bottom border-dark">
                            <p class="h4 text-dark my-1 ms-1" style="font-weight: 800">Total</p>
                            <p class="h4 text-dark my-1 me-1" style="font-weight: 800" id="totalPayment">Rp. 0</p>
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

                        <div class="my-3" id="paymentFields" style="display: none;">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <input type="text" inputmode="numeric" class="form-control" name="payment_amount"
                                    id="payment_amount" placeholder="Payment Amount">
                                <input type="text" inputmode="numeric" class="form-control" name="refund_payment"
                                    id="refund_payment" placeholder="Refund Payment" readonly>
                            </div>
                        </div>

                        <div class="my-3">
                            <button type="submit" class="btn btn-success w-100" name="submit_transaction">Complete
                                Transaction</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
