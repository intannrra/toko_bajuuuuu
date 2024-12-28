@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <h3>Memproses Pembayaran...</h3>
        <p>Anda akan diarahkan ke halaman pembayaran.</p>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <script>
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                // Redirect ke route payment.success dengan parameter transactionId
                window.location.href = '{{ route('payment.success', ['transactionId' => ':transactionId']) }}'.replace(':transactionId', result.transaction_id);
            },
            onPending: function(result) {
                window.location.href = '/payment/pending';
            },
            onError: function(result) {
                window.location.href = '/payment/error';
            }
        });
    </script>
@endsection
