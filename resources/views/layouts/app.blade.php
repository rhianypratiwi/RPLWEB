<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SETRUM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            height: 100vh;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            background-color: #c40000;
            color: white;
            width: 220px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 25px 15px;
            display: flex;
            flex-direction: column;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .sidebar h4 {
            font-weight: 700;
            margin-bottom: 40px;
            text-align: left;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            padding: 8px 10px;
            border-radius: 10px;
            font-weight: 500;
            margin-bottom: 10px;
            transition: all 0.2s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: white;
            color: #c40000;
        }

        .sidebar i {
            margin-right: 10px;
            font-size: 18px;
        }

        /* ===== CONTENT ===== */
        .content {
            margin-left: 240px;
            padding: 40px;
        }

        .profile-section img {
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h4>SETRUM</h4>
        <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="bi bi-house"></i> Beranda
        </a>
        <a href="{{ route('kelas') }}" class="{{ request()->is('kelas') ? 'active' : '' }}">
            <i class="bi bi-book"></i> Kelas
        </a>
        <a href="{{ route('profil') }}" class="{{ request()->is('profil') ? 'active' : '' }}">
            <i class="bi bi-person"></i> Profil
        </a>
        <a href="{{ route('logout') }}">
            <i class="bi bi-box-arrow-right"></i> Keluar
        </a>
    </div>

    <div class="content">
        @yield('content')
    </div>
</body>

</html>