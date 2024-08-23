@extends('layouts.cashier.app')

@section('content')
    <div class="container">
        <h2>QRIS Payment</h2>
        <div class="text-center">
            <img src="{{ $qrCodeUrl }}" alt="QRIS QR Code" style="max-width: 100%; height: auto;">
        </div>
    </div>
@endsection
