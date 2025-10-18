<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ApiService
{
    protected $baseUrl;
    protected $timeout;
    protected $retryAttempts;

    public function __construct()
    {
        $this->baseUrl = config('services.academic_api.base_url');
        $this->timeout = config('services.academic_api.timeout');
        $this->retryAttempts = config('services.academic_api.retry_attempts');
    }

    /**
     * Get headers dengan authentication
     */
    protected function getHeaders()
    {
        $token = Session::get('token');

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if ($token) {
            $headers['Authorization'] = 'Bearer ' . $token;
        }

        return $headers;
    }

    /**
     * Method GET ke API
     */
    public function get($endpoint, $params = [])
    {
        $url = $this->baseUrl . $endpoint;

        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout($this->timeout)
                ->retry($this->retryAttempts, 100)
                ->get($url, $params);

            return $this->handleResponse($response);

        } catch (\Exception $e) {
            Log::error('API GET Error', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
            return $this->handleError($e);
        }
    }

    /**
     * Method POST ke API
     */
    public function post($endpoint, $data = [])
    {
        $url = $this->baseUrl . $endpoint;

        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout($this->timeout)
                ->retry($this->retryAttempts, 100)
                ->post($url, $data);

            return $this->handleResponse($response);

        } catch (\Exception $e) {
            Log::error('API POST Error', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
            return $this->handleError($e);
        }
    }

    /**
     * Handle response dari API
     */
    protected function handleResponse($response)
    {
        if ($response->successful()) {
            return [
                'success' => true,
                'data' => $response->json(),
                'status' => $response->status(),
            ];
        }

        return [
            'success' => false,
            'error' => 'API Request Failed',
            'status' => $response->status(),
            'message' => $response->body(),
            'details' => $response->json() ?? null,
        ];
    }

    /**
     * Handle error
     */
    protected function handleError($exception)
    {
        return [
            'success' => false,
            'error' => 'Connection Error',
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
        ];
    }

    /**
     * ==============================================
     * AUTHENTICATION ENDPOINTS
     * ==============================================
     */

    public function login($credentials)
    {
        return $this->post('/login', $credentials);
    }

    public function logout()
    {
        return $this->post('/logout');
    }

    public function checkToken()
    {
        return $this->get('/check-token');
    }

    public function refreshToken()
    {
        return $this->post('/refresh-token');
    }

    /**
     * ==============================================
     * ACADEMIC ENDPOINTS
     * ==============================================
     */

    /**
     * Get semua jadwal kuliah
     */
    public function getJadwal()
    {
        $cacheKey = 'jadwal_kuliah_' . md5(Session::get('token') ?? 'guest');

        return Cache::remember($cacheKey, 300, function () {
            return $this->get('/jadwal');
        });
    }

    /**
     * Get jadwal by ID
     */
    public function getJadwalById($id)
    {
        return $this->get('/jadwal/' . $id);
    }

    /**
     * Get semua data dosen
     */
    public function getDosen()
    {
        $cacheKey = 'all_dosen_data';

        return Cache::remember($cacheKey, 3600, function () {
            return $this->get('/dosen');
        });
    }

    /**
     * Get dosen by ID
     */
    public function getDosenById($dosenId)
    {
        $cacheKey = 'dosen_data_' . $dosenId;

        return Cache::remember($cacheKey, 3600, function () use ($dosenId) {
            return $this->get('/dosen/' . $dosenId);
        });
    }

    /**
     * Get semua mata kuliah
     */
    public function getMataKuliah()
    {
        $cacheKey = 'all_mata_kuliah';

        return Cache::remember($cacheKey, 3600, function () {
            return $this->get('/mata-kuliah');
        });
    }

    /**
     * Get mata kuliah by ID
     */
    public function getMataKuliahById($matkulId)
    {
        $cacheKey = 'mata_kuliah_' . $matkulId;

        return Cache::remember($cacheKey, 3600, function () use ($matkulId) {
            return $this->get('/mata-kuliah/' . $matkulId);
        });
    }

    /**
     * Get data mahasiswa
     */
    public function getMahasiswa()
    {
        return $this->get('/mahasiswa');
    }

    /**
     * Get KRS (Kartu Rencana Studi)
     */
    public function getKrs()
    {
        $cacheKey = 'krs_data_' . md5(Session::get('token') ?? 'guest');

        return Cache::remember($cacheKey, 300, function () {
            return $this->get('/krs');
        });
    }

    /**
     * Get tugas
     */
    public function getTugas()
    {
        $cacheKey = 'tugas_data_' . md5(Session::get('token') ?? 'guest');

        return Cache::remember($cacheKey, 300, function () {
            return $this->get('/tugas');
        });
    }

    /**
     * Get postingan
     */
    public function getPostingan()
    {
        return $this->get('/postingan');
    }

    /**
     * Get submisi
     */
    public function getSubmisi()
    {
        return $this->get('/submisi');
    }

    /**
     * Test connection
     */
    public function testConnection()
    {
        return $this->get('/test-time');
    }
}