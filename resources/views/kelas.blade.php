@extends('layouts.app')

@section('title', 'Kelas')


@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Daftar Kelas</h3>
            <small class="text-muted">Kelas > Daftar Kelas</small>
        </div>
        <div class="text-end">
            <h6 class="fw-bold mb-0">Selamat mengajar, Lia!</h6>
            <small class="text-muted">Kamis, 18 September 2025</small>
            <img src="https://i.pravatar.cc/40" alt="Profile" class="rounded-circle ms-2" width="40" height="40">
        </div>
    </div>

    <div class="kelas-list">
        @foreach($kelasList as $kelas)
            <div class="card mb-3 border-0" style="background-color: {{ $kelas['warna'] }}; color: white; border-radius: 10px;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1 fw-bold">{{ $kelas['nama'] }}</h5>
                        <small>{{ $kelas['jumlah'] }} Mahasiswa</small>
                    </div>
                    <i class="bi bi-three-dots-vertical fs-5"></i>
                </div>
            </div>
        @endforeach
    </div>
@endsection