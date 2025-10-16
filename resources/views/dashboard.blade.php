<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 Free CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />


  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
      height: 100vh;
      overflow: hidden;
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
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: white;
      color: #c40000;
      border-radius: 8px;
      padding: 8px 12px;
    }

    .content {
      margin-left: 250px;
      padding: 30px 50px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header img {
      width: 45px;
      height: 45px;
      border-radius: 50%;
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
    <a href="#" class="active">
      <i class="bi bi-house"></i> Beranda
    </a>
    <a href="#">
      <i class="bi bi-book"></i> Kelas
    </a>
    <a href="#">
      <i class="bi bi-person"></i> Profil
    </a>
    <a href="{{ route('logout') }}">
      <i class="bi bi-box-arrow-right"></i> Keluar
    </a>
  </div>




  <div class="content">
    <div class="header mb-4">
      <div>
        <h5>Hai, {{ $user['name'] ?? 'User' }}!</h5>
        <p class="text-muted">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
      </div>
      <img src="https://i.pravatar.cc/100" alt="Avatar">
    </div>

    <div class="section">
      <h5 class="section-title">Mata Kuliah Hari Ini</h5>
      @foreach ($mataKuliah as $mk)
        <div class="card-red">
          <strong>{{ $mk['nama'] }}</strong> <br>
          <small>{{ $mk['dosen'] }} - {{ $mk['waktu'] }}</small>
        </div>
      @endforeach
    </div>

    <div class="section">
      <h5 class="section-title">Tugas</h5>
      @foreach ($tugas as $t)
        <div class="card-red">
          <strong>{{ $t['judul'] }}</strong>
          <div class="float-end">{{ $t['deadline'] }}</div>
        </div>
      @endforeach
    </div>
  </div>

</body>

</html>