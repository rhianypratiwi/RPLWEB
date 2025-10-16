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

        if (!$token) {
            return redirect('/login')->withErrors(['session' => 'Token tidak ditemukan, silakan login lagi.']);
        }

        $response = Http::withToken($token)
            ->get('http://192.168.18.21:8000/api/v2/mahasiswa');

        if ($response->successful()) {
            $userData = $response->json();
            return view('dashboard', compact('userData'));
        } else {
            return redirect('/login')->withErrors(['session' => 'Token tidak valid atau sudah kedaluwarsa.']);
        }
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

        // API reset-password -> mengirim OTP ke email user
        $response = Http::post('https://ecd08a6c5ece.ngrok-free.app/api/v2/forgot-password', [
            'email' => $request->email,
        ]);

        if ($response->successful()) {
            return redirect()->route('reset-password')
                ->with('success', 'Kode OTP telah dikirim ke email Anda. Silakan masukkan kode untuk mengubah password.');
        } else {
            return back()->withErrors(['email' => 'Gagal mengirim kode OTP. Pastikan email benar.']);
        }
    }

    // ======== CHANGE PASSWORD ========
    public function showResetPasswordForm()
    {
        return view('resetPassword');
    }

    public function verifyOtpAndChangePassword(Request $request)
    {
        $request->validate([
            'otp' => 'required|array|size:6',
            'otp.*' => 'digits:1',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $otpCode = implode('', $request->otp);

        // Kirim ke API change-password
        $response = Http::post('https://ecd08a6c5ece.ngrok-free.app/api/v2/reset-password', [
            'otp' => $otpCode,
            'new_password' => $request->new_password,
            'new_password_confirmation' => $request->new_password_confirmation,
        ]);

        if ($response->successful()) {
            return redirect('/login')->with('success', 'Password berhasil diubah! Silakan login.');
        } else {
            return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kadaluarsa.']);
        }
    }

}
