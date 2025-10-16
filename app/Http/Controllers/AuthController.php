<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('register'); // file view: resources/views/register.blade.php
    }

    // ======== REGISTER =========
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|string', // ✅ tambahkan validasi role
        ]);

        // Kirim data ke API register kamu
        $response = Http::post('http://192.168.18.21:8000/api/v2/registrasi', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
            'role' => $request->role, // ✅ tambahkan field role
        ]);

        if ($response->successful()) {
            return redirect('/login')->with('success', 'Pendaftaran berhasil! Silakan login.');
        } else {
            return back()->withErrors(['register' => 'Gagal mendaftar. Pastikan data sudah benar.']);
        }
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $response = Http::post('http://192.168.18.21:8000/api/v2/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            $json = $response->json();

            if (isset($json['data'])) {
                $data = $json['data'];

                // Simpan data ke session
                Session::put('token', $data['token']);
                Session::put('token_expires_at', $data['token_expires_at']);
                Session::put('user', $data['user']);
                Session::put('mahasiswa', $data['mahasiswa']);

                return redirect('/dashboard');
            } else {
                return back()->withErrors(['login' => 'Format respon API tidak sesuai.']);
            }
        } else {
            return back()->withErrors(['login' => 'Email atau password salah']);
        }
    }

    public function dashboard()
    {
        $token = Session::get('token');
        $user = Session::get('user');

        if (!$token) {
            return redirect('/login')->withErrors(['session' => 'Silakan login terlebih dahulu.']);
        }

        // Contoh data dummy (nanti bisa diganti dengan API)
        $mataKuliah = [
            ['nama' => 'Jaringan Komputer', 'dosen' => 'Yasir Arafat', 'waktu' => 'TIF-11'],
            ['nama' => 'Rekayasa Perangkat Lunak', 'dosen' => 'Yusril Eka Mahendra', 'waktu' => 'TIF-11'],
            ['nama' => 'Pemrograman Web', 'dosen' => 'Ferry Faisal', 'waktu' => 'TIF-12'],
        ];

        $tugas = [
            ['judul' => 'PBL Kelompok', 'deadline' => 'Sept 15'],
            ['judul' => 'Project PBL', 'deadline' => 'Sept 30'],
            ['judul' => 'Project Pemrograman', 'deadline' => 'Okt 10'],
        ];

        return view('dashboard', compact('user', 'mataKuliah', 'tugas'));
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login')->with('success', 'Anda telah logout.');
    }


    // ======== FORGOT PASSWORD (LUPA PASSWORD) ========
    public function showForgotPasswordForm()
    {
        return view('forgotPassword');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Kirim ke API lupa password
        $response = Http::post('https://ecd08a6c5ece.ngrok-free.app/api/v2/forgot-password', [
            'email' => $request->email,
        ]);

        if ($response->successful()) {
            $data = $response->json()['data'];

            // Simpan email ke session agar bisa dipakai di halaman berikut
            session(['reset_email' => $data['email']]);

            // Redirect ke halaman reset password
            return redirect()->route('reset-password')
                ->with('success', 'Kode OTP telah dikirim ke email Anda. Silakan masukkan kode untuk mengubah password.');
        } else {
            return back()->withErrors(['email' => 'Gagal mengirim kode OTP. Pastikan email benar.']);
        }
    }

    // ======== CHANGE PASSWORD ========
    public function showResetPasswordForm()
    {
        $email = session('reset_email');
        return view('resetPassword', compact('email'));
    }


    public function verifyOtpAndChangePassword(Request $request)
    {
        $request->validate([
            'otp' => 'required|array|size:6',
            'otp.*' => 'digits:1',
            'new_password' => 'required|min:8|confirmed',
            'email' => 'required|email',
        ]);

        $otpCode = implode('', $request->otp);

        $response = Http::post('https://ecd08a6c5ece.ngrok-free.app/api/v2/reset-password', [
            'email' => $request->email,
            'token' => $otpCode,
            'password' => $request->new_password,
            'password_confirmation' => $request->new_password_confirmation,
        ]);

        if ($response->successful()) {
            // Bersihkan email dari session biar aman
            session()->forget('reset_email');

            return redirect('/login')->with('success', 'Password berhasil diubah! Silakan login.');
        } else {
            return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kadaluarsa.']);
        }
    }



}
