<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SETRUM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            overflow-x: hidden;
        }

        .sidebar {
            background-color: #c40000;
            color: white;
            height: 100vh;
            width: 230px;
            position: fixed;
            top: 0;
            left: 0;
            padding: 30px 20px;
        }

        .sidebar h3 {
            font-weight: 700;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            margin: 12px 0;
            font-weight: 500;
            transition: 0.2s;
            padding: 8px 12px;
            border-radius: 8px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: white;
            color: #c40000;
        }

        .content {
            margin-left: 250px;
            padding: 30px 50px;
            min-height: 100vh;
        }

        .card-red {
            background-color: #c40000;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 15px;
            margin-bottom: 10px;
        }

        .section-title {
            font-weight: 700;
            margin-top: 30px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h3>SETRUM</h3>
        <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="bi bi-house"></i>&nbsp; Beranda
        </a>
        <a href="{{ route('kelas') }}" class="{{ request()->is('kelas') ? 'active' : '' }}">
            <i class="bi bi-book"></i>&nbsp; Kelas
        </a>
        <a href="{{ route('profil') }}" class="{{ request()->is('profil') ? 'active' : '' }}">
            <i class="bi bi-person"></i>&nbsp; Profil
        </a>
        <a href="{{ route('logout') }}">
            <i class="bi bi-box-arrow-right"></i>&nbsp; Keluar
        </a>
    </div>

    <div class="content">
        @yield('content')
    </div>
</body>

</html>