<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            width: 420px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            padding: 30px;
        }

        .btn-danger {
            background-color: #c40000;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
        }

        .btn-danger:hover {
            background-color: #a00000;
        }

        a {
            text-decoration: none;
            color: #c40000;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="card text-center">
        <h3 class="fw-bold mb-3">LUPA PASSWORD</h3>
        <p>Masukkan email Anda untuk menerima OTP reset password</p>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('forgotPassword.post') }}" method="POST">
            @csrf
            <div class="mb-3 text-start">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required placeholder="Masukkan email Anda">
            </div>

            <button type="submit" class="btn btn-danger w-100">Kirim Link Reset</button>
        </form>

        <div class="mt-3">
            <a href="{{ url('/login') }}">Kembali ke Login</a>
        </div>
    </div>

</body>

</html>