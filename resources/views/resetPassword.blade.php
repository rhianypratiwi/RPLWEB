<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container-box {
            background: white;
            padding: 50px 60px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
            width: 720px;
            text-align: center;
        }

        .otp-input {
            width: 60px;
            height: 65px;
            text-align: center;
            font-size: 26px;
            font-weight: 600;
            border: 2px solid #ccc;
            border-radius: 10px;
            margin: 0 8px;
            transition: all 0.2s ease;
        }

        .otp-input:focus {
            border-color: #c8102e;
            outline: none;
            box-shadow: 0 0 5px rgba(200, 16, 46, 0.3);
        }

        .form-control {
            height: 55px;
            font-size: 18px;
            border-radius: 10px;
        }

        .btn-red {
            background-color: #c8102e;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 14px 50px;
            font-weight: bold;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .btn-red:hover {
            background-color: #a00d25;
        }

        label {
            font-weight: 600;
            font-size: 16px;
        }
    </style>
</head>

<body>

    <div class="container-box">
        <h2 class="fw-bold mb-2">Change Password</h2>
        <p class="text-muted mb-4">Masukkan kode OTP dan buat password baru Anda</p>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('reset-password.post') }}">
            @csrf
            <label class="form-label mb-2">Kode OTP</label>
            <div class="d-flex justify-content-center mb-5">
                @for($i = 0; $i < 6; $i++)
                    <input type="text" name="otp[]" maxlength="1" class="otp-input" required>
                @endfor
            </div>

            <div class="row justify-content-center g-4">
                <div class="col-md-5 text-start">
                    <label for="new_password" class="form-label">Password Baru</label>
                    <input type="password" name="new_password" id="new_password" class="form-control" required
                        placeholder="Masukkan password baru">
                </div>

                <div class="col-md-5 text-start">
                    <label for="new_password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                        class="form-control" required placeholder="Ulangi password baru">
                </div>
            </div>

            <button type="submit" class="btn-red mt-5">Change Password</button>
        </form>
    </div>

    <script>
        // Otomatis pindah antar OTP box
        const inputs = document.querySelectorAll('.otp-input');
        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });
    </script>
</body>

</html>