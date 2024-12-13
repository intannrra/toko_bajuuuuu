<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9; /* Light Gray Background */
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff; /* White Container */
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            margin: 20px; /* Add margin for spacing */
            text-align: center;
        }

        h2 {
            color: #333; /* Dark Gray Heading */
            font-size: 24px;
            margin-bottom: 30px; /* Larger spacing below heading */
        }

        .form-group {
            margin-bottom: 20px; /* Even spacing between fields */
            text-align: left;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 14px;
            color: #555;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            width: 100%;
            background-color: #007bff; /* Blue Button */
            color: white;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            margin-top: 10px; /* Add spacing above the button */
        }

        button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            text-align: left;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        p {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        a {
            color: #007bff; /* Blue Link */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
           <!-- Menampilkan pesan flash jika ada -->
           @if(session('success'))
           <div class="alert alert-success">
               {{ session('success') }}
           </div>
       @endif

       @if($errors->any())
           <div class="alert alert-danger">
               <ul>
                   @foreach($errors->all() as $error)
                       <li>{{ $error }}</li>
                   @endforeach
               </ul>
           </div>
       @endif
<!-- Form login -->
        <form action="{{ route('auth.login') }}" method="POST"> 
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        
        <p>Belum punya akun? <a href="{{ route('auth.register') }}">Daftar di sini</a></p>          
    </div>
</body>
</html>
