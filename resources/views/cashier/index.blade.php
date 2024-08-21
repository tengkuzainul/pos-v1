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

        <!-- Card Penampung Cart Kolom Kanan -->
        <div class="col-lg-5">
            <div class="position-fixed" style="width: 30%">
                <p class="h3 text-dark text-center mb-3" style="font-weight: 700">Cart</p>
                <div class="card shadow-lg">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-start align-items-center gap-2">
                            <img src="{{ asset('assets/image/empty-image.webp') }}" alt="..."
                                class="img-thumbnail my-2 border-0 " width="50" height="50">
                            <div class="d-flex flex-column">
                                <p class="text-dark mb-0" style="font-weight: 700">Lorem, ipsum dolor.</p>
                                <p class="text-primary mb-0"style="font-weight: 900">Rp. 15,000</p>
                            </div>
                            <div class="d-flex flex-column ms-4">
                                <p class="text-danger mb-1" id="totalPayment">Rp, 30,000</p>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-primary btn-sm" type="button" id="buttonPlus"><i
                                            class="ti ti-minus"></i></button>
                                    <input name="qty" type="text" class="form-control form-control-sm w-25"
                                        min="1" size="1" inputmode="numeric" value="1">
                                    <button class="btn btn-danger btn-sm" type="button" id="buttonPlus"><i
                                            class="ti ti-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <p class="mb-0">No items in cart</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scriptsGetProductByCategoryId')
    <!-- Include jQuery (letakkan sebelum script custom kamu) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.category-link').on('click', function(e) {
                e.preventDefault();
                let categoryId = $(this).data('category-id');
                $.ajax({
                    url: `/cashier/get-product-by-category/${categoryId}`,
                    type: 'GET',
                    success: function(response) {
                        $('#product-list').html(response.html);
                    },
                    error: function() {
                        $('#product-list').html(
                            '<p class="text-center">An error occurred. Please try again later.</p>'
                        );
                    }
                });
            });
        });
    </script>
@endpush
