<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Support\Facades\Session;

class MataKuliahController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index()
    {
        // Pastikan user sudah login
        if (!Session::has('token')) {
            return redirect('/login')->withErrors(['session' => 'Silakan login terlebih dahulu.']);
        }

        // Check token validity
        $tokenCheck = $this->apiService->checkToken();
        if (!$tokenCheck['success']) {
            Session::forget('token');
            return redirect('/login')->withErrors(['session' => 'Session expired, please login again.']);
        }

        // Ambil data jadwal dari API
        $jadwalResponse = $this->apiService->getJadwal();

        if ($jadwalResponse['success'] && !empty($jadwalResponse['data'])) {
            // Transform data jadwal menjadi format mata kuliah
            $mataKuliah = $this->transformJadwalToMataKuliah($jadwalResponse['data']);
        } else {
            // Fallback ke data contoh
            $mataKuliah = $this->getSampleData();
            session()->flash('warning', 'Data dari API tidak tersedia, menampilkan data contoh.');
        }

        return view('kelas', compact('mataKuliah'));
    }

    /**
     * Transform data jadwal dari API menjadi format mata kuliah
     */
    private function transformJadwalToMataKuliah($jadwalData)
    {
        // Pre-load data dosen dan mata kuliah untuk efisiensi
        $allDosen = $this->apiService->getDosen();
        $allMataKuliah = $this->apiService->getMataKuliah();

        $dosenMap = [];
        $matkulMap = [];

        if ($allDosen['success']) {
            foreach ($allDosen['data'] as $dosen) {
                $dosenMap[$dosen['id']] = $dosen['nama'] ?? 'Dosen Tidak Diketahui';
            }
        }

        if ($allMataKuliah['success']) {
            foreach ($allMataKuliah['data'] as $matkul) {
                $matkulMap[$matkul['id']] = [
                    'nama' => $matkul['nama'] ?? 'Mata Kuliah Tidak Diketahui',
                    'kode' => $matkul['kode'] ?? 'N/A'
                ];
            }
        }

        $transformedData = [];

        foreach ($jadwalData as $jadwal) {
            $dosenName = $dosenMap[$jadwal['dosenId']] ?? 'Dosen Tidak Diketahui';
            $matkulInfo = $matkulMap[$jadwal['matkulId']] ?? ['nama' => 'Mata Kuliah Tidak Diketahui', 'kode' => 'N/A'];

            $transformedData[] = [
                'id' => $jadwal['id'],
                'nama' => $matkulInfo['nama'],
                'dosen' => $dosenName,
                'kode' => $jadwal['prodi'] . '-' . $jadwal['kelas'],
                'hari' => ucfirst($jadwal['hari']),
                'jam_mulai' => $this->formatTime($jadwal['jamMulai']),
                'jam_selesai' => $this->formatTime($jadwal['jamSelesai']),
                'ruangan' => $jadwal['ruangan'],
                'semester' => $jadwal['semester'],
                'prodi' => $jadwal['prodi'],
                'kelas' => $jadwal['kelas'],
                'dosen_id' => $jadwal['dosenId'],
                'matkul_id' => $jadwal['matkulId'],
            ];
        }

        return $transformedData;
    }

    /**
     * Format waktu dari HH:MM:SS menjadi HH:MM
     */
    private function formatTime($time)
    {
        if (!$time)
            return '-';
        return substr($time, 0, 5);
    }

    /**
     * Data contoh sebagai fallback
     */
    private function getSampleData()
    {
        return [
            [
                'id' => 1,
                'nama' => 'Jaringan Komputer',
                'dosen' => 'Yasir Arafat',
                'kode' => 'TI-11',
                'hari' => 'Senin',
                'jam_mulai' => '08:00',
                'jam_selesai' => '10:00',
                'ruangan' => 'R-101',
                'semester' => 2,
                'prodi' => 'TI',
                'kelas' => 'A'
            ],
            [
                'id' => 2,
                'nama' => 'Rekayasa Perangkat Lunak',
                'dosen' => 'Yusril Eka Mahendra',
                'kode' => 'TI-4',
                'hari' => 'Selasa',
                'jam_mulai' => '10:00',
                'jam_selesai' => '12:00',
                'ruangan' => 'R-102',
                'semester' => 4,
                'prodi' => 'TI',
                'kelas' => 'B'
            ],
        ];
    }
}