<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MataKuliahController extends Controller
{
    public function index()
    {
        // Pastikan user sudah login
        if (!Session::has('token')) {
            return redirect('/login')->withErrors(['session' => 'Silakan login terlebih dahulu.']);
        }

        // Data dummy (bisa diganti nanti dari API)
        $kelasList = [
            ['nama' => 'KELAS A', 'jumlah' => 28, 'warna' => '#c40000'],
            ['nama' => 'KELAS B', 'jumlah' => 25, 'warna' => '#e07b7b'],
            ['nama' => 'KELAS C', 'jumlah' => 30, 'warna' => '#9b0000'],
        ];

        // arahkan ke file view: resources/views/kelas.blade.php
        return view('kelas', compact('kelasList'));
    }
}
