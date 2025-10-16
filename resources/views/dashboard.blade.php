<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-learning Jurusan Teknik Elektro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    :root {
      --red: #c8102e;
      --dark-red: #a10d25;
    }

    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      background: #fff;
      color: #222;
      display: flex;
      min-height: 100vh;
    }

    /* SIDEBAR */
    .sidebar {
      width: 230px;
      background: var(--red);
      color: #fff;
      height: 100vh;
      border-radius: 0 10px 10px 0;
      display: flex;
      flex-direction: column;
      padding-top: 20px;
      position: fixed;
    }

    .sidebar .brand {
      display: flex;
      align-items: center;
      padding: 0 20px;
      font-weight: bold;
      font-size: 18px;
    }

    .sidebar .brand i {
      font-size: 22px;
      margin-right: 10px;
    }

    .menu {
      margin-top: 30px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .menu a,
    .menu button {
      display: flex;
      align-items: center;
      padding: 12px 20px;
      color: #fff;
      text-decoration: none;
      font-size: 16px;
      border-bottom: 1px solid rgba(255, 255, 255, .2);
      transition: background .3s;
      background: transparent;
      border: none;
      text-align: left;
      cursor: pointer;
    }

    .menu a i,
    .menu button i {
      width: 25px;
      text-align: center;
      margin-right: 10px;
      font-size: 18px;
    }

    .menu a:hover,
    .menu button:hover {
      background: var(--dark-red);
    }

    /* CONTENT */
    .content {
      margin-left: 230px;
      padding: 30px;
      flex: 1;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .header .greeting h1 {
      font-size: 20px;
      margin-bottom: 4px;
    }

    .header .greeting p {
      color: #777;
      font-size: 13px;
    }

    .profile img {
      width: 46px;
      height: 46px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #eee;
      cursor: pointer;
    }

    h2 {
      margin-top: 20px;
      margin-bottom: 10px;
    }

    .card {
      background: var(--red);
      color: #fff;
      padding: 10px 12px;
      border-radius: 8px;
      margin-bottom: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: transform .25s ease, box-shadow .25s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, .2);
    }

    .card.light {
      background: #f28a8a;
      color: #000;
    }

    .muted {
      color: #888;
      font-size: 13px;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        width: 70px;
      }

      .sidebar .brand span {
        display: none;
      }

      .menu a span,
      .menu button span {
        display: none;
      }

      .content {
        margin-left: 70px;
      }
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="brand">
      <i class="fa fa-bars"></i>
      <span>SETRUM</span>
    </div>
    <div class="menu">
      <a href="#"><i class="fa fa-home"></i> <span>Beranda</span></a>
      <a href="#"><i class="fa fa-user"></i> <span>Profil</span></a>
      <a href="#"><i class="fa fa-book"></i> <span>Kelas</span></a>
      <button id="btnLogout"><i class="fa fa-right-from-bracket"></i> <span>Logout</span></button>
    </div>
  </aside>

  <!-- Konten -->
  <main class="content">
    <div class="header">
      <div class="greeting">
        <h1>Hai, {{ $user['name'] ?? 'User' }}!</h1>
        <p id="today"></p>
        <p class="text-muted mb-0">Anda login sebagai <strong>{{ $user['role'] ?? '-' }}</strong></p>
      </div>
      <div class="profile">
        <img src="https://i.pravatar.cc/100" alt="profil" id="profilePhoto">
      </div>
    </div>

    <!-- Informasi Mahasiswa -->
    <div class="card shadow border-0 rounded-4 mb-4">
      <div class="card-body">
        <h3 class="mb-3">Informasi Mahasiswa</h3>
        <table class="table table-bordered">
          <tr>
            <th>NIM</th>
            <td>{{ $mahasiswa['nim'] ?? '-' }}</td>
          </tr>
          <tr>
            <th>Program Studi</th>
            <td>{{ $mahasiswa['prodi'] ?? '-' }}</td>
          </tr>
          <tr>
            <th>Kelas</th>
            <td>{{ $mahasiswa['kelas'] ?? '-' }}</td>
          </tr>
          <tr>
            <th>Tahun Masuk</th>
            <td>{{ $mahasiswa['tahunMasuk'] ?? '-' }}</td>
          </tr>
        </table>
      </div>
    </div>

    <!-- Mata Kuliah -->
    <h2>Mata Kuliah</h2>
    <div id="matkulList"></div>

    <!-- Tugas -->
    <h2>Tugas</h2>
    <div class="card">
      <div><strong>PBL Kelompok</strong></div>
      <span>Sept 25</span>
    </div>
    <div class="card light">
      <div><strong>Project RPL</strong></div>
      <span>Sept 30</span>
    </div>
    <div class="card">
      <div><strong>Project Pemrograman</strong></div>
      <span>Okt 9</span>
    </div>
  </main>

  <script>
    // === Proteksi halaman ===
    (function requireAuth() {
      // Simulasi token dan user dari localStorage
      // Dalam implementasi nyata, ini akan diambil dari backend
      const token = localStorage.getItem('token');
      const user = localStorage.getItem('user');

      if (!token || !user) {
        // Jika tidak ada token/user, redirect ke login
        // location.href = 'form_login.html';
        console.log('Redirect ke halaman login');
      }
    })();

    // === UI awal (sapaan & tanggal) ===
    const user = JSON.parse(localStorage.getItem('user') || '{"name": "{{ $user['name'] ?? 'User' }}", "role": "{{ $user['role'] ?? '-' }}"}');

    // Update sapaan
    document.querySelector('.greeting h1').textContent = `Hai, ${user.name}!`;

    // Update tanggal
    const d = new Date();
    const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
    document.getElementById('today').textContent = d.toLocaleDateString('id-ID', options);

    // Foto profil dari backend kalau ada
    const profilePhoto = document.getElementById('profilePhoto');
    if (user?.avatar) profilePhoto.src = user.avatar;
    profilePhoto.addEventListener('click', () => {
      // location.href = 'profile.html';
      console.log('Redirect ke halaman profil');
    });

    // === Logout ===
    document.getElementById('btnLogout').addEventListener('click', () => {
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      // location.href = 'form_login.html';
      console.log('Logout berhasil, redirect ke halaman login');
    });

    // === Ambil Mata Kuliah lewat proxy backend (anti CORS) ===
    const API_URL = '/api/mata-kuliah';   // route proxy di server.js
    const matkulList = document.getElementById('matkulList');

    async function loadMataKuliah(page = 1) {
      try {
        // Simulasi fetch API
        // const res = await fetch(`${API_URL}?page=${page}`);
        // if (!res.ok) throw new Error('HTTP ' + res.status);
        // const json = await res.json();
        // renderMatkul(json.data || []);

        // Untuk demo, gunakan data statis
        renderMatkul([
          { id: 1, mataKuliah: 'Pemrograman Web', sks: 4 },
          { id: 2, mataKuliah: 'Basis Data', sks: 3 },
          { id: 3, mataKuliah: 'Algoritma dan Struktur Data', sks: 2 },
          { id: 4, mataKuliah: 'Jaringan Komputer', sks: 4 },
          { id: 5, mataKuliah: 'Sistem Operasi', sks: 3 },
        ]);
      } catch (e) {
        console.warn('Gagal API, pakai fallback:', e);
        renderMatkul([
          { id: 1, mataKuliah: 'et voluptatem fugit', sks: 4 },
          { id: 2, mataKuliah: 'nobis perspiciatis rerum', sks: 3 },
          { id: 3, mataKuliah: 'maxime et ea', sks: 2 },
          { id: 4, mataKuliah: 'optio vel ducimus', sks: 4 },
          { id: 5, mataKuliah: 'voluptas exercitationem qui', sks: 3 },
        ], true);
      }
    }

    function renderMatkul(list, isFallback = false) {
      matkulList.innerHTML = '';
      list.forEach(m => {
        const el = document.createElement('div');
        el.className = 'card';
        el.innerHTML = `<div><strong>${m.mataKuliah}</strong><br><small>ID: ${m.id}</small></div><span>${m.sks} SKS</span>`;
        matkulList.appendChild(el);
      });
      if (isFallback) {
        const p = document.createElement('p');
        p.className = 'muted';
        p.textContent = '(Menampilkan data fallback karena API tidak dapat diakses)';
        matkulList.appendChild(p);
      }
    }

    loadMataKuliah();
  </script>
</body>

</html>