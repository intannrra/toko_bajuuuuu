@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Transaction Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Shipping Information</h5>
            <p><strong>Address:</strong> {{ $data['address'] }}</p>
            <p><strong>Shipping Service:</strong> {{ $data['shipping_service'] }}</p>

            <h5 class="mt-4">Payment Information</h5>
            <p><strong>Payment Method:</strong> {{ $data['payment_method'] }}</p>

            @if (isset($data['payment_proof']))
                <p><strong>Bukti Pembayaran:</strong></p>
                <a href="{{ asset('storage/' . $data['payment_proof']) }}" target="_blank" class="btn btn-sm btn-primary">View Payment Proof</a>
            @else
                <p><strong>Bukti Pembayaran:</strong> Belum DiUpload</p>
            @endif
        </div>
    </div>

    <a href="{{ route('home') }}" class="btn btn-success mt-4">Back to Home</a>
</div>
@endsection
