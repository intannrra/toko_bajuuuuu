<!DOCTYPE html>
<html>
<head>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body>
    <button id="pay-button">Pay Now</button>

    <script>
        document.getElementById('pay-button').onclick = function() {
            fetch('/payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    amount: 100000, // Contoh total pembayaran
                    first_name: 'John Doe',
                    email: 'john.doe@example.com'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.snap_token) {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) { console.log(result); },
                        onPending: function(result) { console.log(result); },
                        onError: function(result) { console.error(result); },
                    });
                } else {
                    console.error('Error:', data);
                }
            });
        };
    </script>
</body>
</html>
