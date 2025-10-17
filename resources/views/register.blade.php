<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
    }

    .card {
      border: none;
      border-radius: 0.75rem;
      max-width: 700px;
    }

    .btn-danger {
      background-color: #c10000;
      border: none;
    }

    .btn-danger:hover {
      background-color: #a80000;
    }

    .form-control,
    .form-select {
      border-radius: 0.5rem;
    }

    .text-danger {
      font-size: 0.9rem;
    }
  </style>

</head>

<body>
  <div class="container mt-5">
    <div class="card mx-auto shadow">
      <div class="card-body px-5 py-4">
        <h2 class="text-center fw-bold">Sign Up!</h2>
        <p class="text-center text-muted mb-4">Silakan buat akun terlebih dahulu</p>

        ```
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

        <form method="POST" action="{{ url('/register') }}" autocomplete="off">
          @csrf

          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama lengkap"
              value="{{ old('name', '') }}" autocomplete="off" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email"
              value="{{ old('email', '') }}" autocomplete="off" required>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password"
                minlength="8" autocomplete="new-password" required>
              <small id="passwordHelp" class="text-danger d-none">
                Password minimal 8 karakter.
              </small>
            </div>

            <div class="col-md-6 mb-3">
              <label for="password_confirmation" class="form-label">Confirm Password</label>
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                placeholder="Ulangi password" autocomplete="new-password" required>
            </div>
          </div>

          <div class="mb-4">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" name="role" required>
              <option value="" disabled selected>Pilih role...</option>
              <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
              <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
            </select>
          </div>

          <button type="submit" class="btn btn-danger w-100 py-2">Sign Up</button>
        </form>

        <p class="mt-3 text-center">
          Already have an account? <a href="{{ url('/login') }}" class="text-danger fw-semibold">Sign in</a>
        </p>
      </div>
    </div>
    ```

  </div>

  <script>
    const passwordInput = document.getElementById('password');
    const helpText = document.getElementById('passwordHelp');

    passwordInput.addEventListener('input', () => {
      if (passwordInput.value.length < 8) {
        helpText.classList.remove('d-none');
      } else {
        helpText.classList.add('d-none');
      }
    });
  </script>

</body>

</html>


<script>
  const passwordInput = document.getElementById('password');
  const helpText = document.getElementById('passwordHelp');

  passwordInput.addEventListener('input', () => {
    if (passwordInput.value.length < 8) {
      helpText.classList.remove('d-none');
    } else {
      helpText.classList.add('d-none');
    }
  });
</script>
</body>

</html>