@extends('layouts.app')

@section('title', 'Kelas')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-semibold">Mata Kuliah</h5>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"
                                class="text-decoration-none text-muted">Kelas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Mata Kuliah</li>
                    </ol>
                </nav>
            </div>
            <div class="text-end">
                <h6 class="mb-0 fw-semibold">Hai, Rhiany!</h6>
                <small class="text-muted">{{ now()->translatedFormat('l, d F Y') }}</small>
            </div>
        </div>

        <!-- Daftar Mata Kuliah -->
        <div class="row">
            @foreach ($mataKuliah as $mk)
                <div class="col-12 mb-3">
                    <div class="card-mk d-flex justify-content-between align-items-center px-4 py-3">
                        <div>
                            <h6 class="mb-1 fw-semibold text-white">{{ $mk['nama'] }}</h6>
                            <small class="text-white-50">{{ $mk['dosen'] }}</small>
                        </div>
                        <div class="kode-kelas">
                            <span>{{ $mk['kode'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .card-mk {
            background-color: #c40000;
            border-radius: 12px;
            transition: 0.2s ease;
        }

        .card-mk:hover {
            transform: scale(1.02);
            background-color: #a50000;
        }

        .kode-kelas {
            background-color: white;
            color: #c40000;
            font-weight: 600;
            padding: 4px 14px;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .breadcrumb-item a {
            color: #6c757d !important;
        }

        .breadcrumb-item.active {
            color: #000;
            font-weight: 500;
        }
    </style>
@endsection