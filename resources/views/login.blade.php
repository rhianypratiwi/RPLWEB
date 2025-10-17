<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Sign In</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #ffffff;
    }

    .card {
      border: none;
      border-radius: 0.75rem;
      max-width: 500px;
      /* ✅ dilebarkan dari 400px ke 500px */
      width: 100%;
    }

    .btn-danger {
      background-color: #c10000;
      border: none;
    }

    .btn-danger:hover {
      background-color: #a80000;
    }

    a.text-danger {
      text-decoration: none;
    }

    a.text-danger:hover {
      text-decoration: underline;
    }

    .form-control {
      border-radius: 0.5rem;
      padding: 10px 12px;
    }
  </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow px-5 py-4">
    <div class="card-body">
      <h2 class="text-center fw-bold">Sign In!</h2>
      <p class="text-center text-muted mb-4">Masukkan email dan password Anda</p>

      {{-- Pesan sukses dari register --}}
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      {{-- Pesan error --}}
      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Form Login -->
      <form method="POST" action="{{ url('/login') }}" autocomplete="off">
        @csrf

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email Anda"
            autocomplete="off" required>
        </div>

        <div class="mb-1">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password"
            autocomplete="new-password" required>
        </div>

        <div class="text-end mb-3">
          <a href="{{ route('forgotPassword') }}">Lupa Password?</a>
        </div>

        <button type="submit" class="btn btn-danger w-100 py-2">Sign In</button>
      </form>

      <p class="mt-3 text-center">
        Don’t have an account?
        <a href="{{ url('/register') }}" class="text-danger fw-semibold">Sign Up</a>
      </p>
    </div>
  </div>
</body>

</html>