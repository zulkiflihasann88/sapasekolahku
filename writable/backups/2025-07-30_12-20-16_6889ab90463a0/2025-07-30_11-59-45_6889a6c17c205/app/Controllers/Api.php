<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PekerjaanModel;
use App\Models\PendidikanModel;

class Api extends ResourceController
{
    public function __construct()
    {
        helper('tahun_ajaran'); // Load helper tahun ajaran
    }
    public function disability()
    {
        $term = $this->request->getGet('term');
        $model = new \App\Models\DisabilityModel();
        $builder = $model;
        if ($term) {
            $builder = $builder->like('jenis_disability', $term);
        }
        $data = $builder->select('id_disability, jenis_disability')->findAll(20); // limit 20
        return $this->response->setJSON($data);
    }

    public function tinggal()
    {
        $term = $this->request->getGet('term');
        $model = new \App\Models\TinggalModel();
        $builder = $model;
        if ($term) {
            $builder = $builder->like('tempat_tinggal', $term);
        }
        $data = $builder->select('id_tempat_tinggal, tempat_tinggal')->findAll(20); // limit 20
        return $this->response->setJSON($data);
    }

    public function transportasi()
    {
        $term = $this->request->getGet('term');
        $model = new \App\Models\TransportasiModel();
        $builder = $model;
        if ($term) {
            $builder = $builder->like('moda_transportasi', $term);
        }
        $data = $builder->select('id_transportasi, moda_transportasi')->findAll(20); // limit 20
        return $this->response->setJSON($data);
    }

    public function pekerjaan()
    {
        $term = $this->request->getGet('term');
        $model = new PekerjaanModel();
        $builder = $model;
        if ($term) {
            $builder = $builder->like('nama_pekerjaan', $term);
        }
        $data = $builder->select('id_pekerjaan, nama_pekerjaan')->findAll(20); // limit 20
        return $this->response->setJSON($data);
    }

    public function pendidikan()
    {
        $term = $this->request->getGet('term');
        $model = new PendidikanModel();
        $builder = $model;
        if ($term) {
            $builder = $builder->like('pendidikan', $term);
        }
        $data = $builder->select('id_pendidikan, pendidikan')->findAll(20); // limit 20
        return $this->response->setJSON($data);
    }
    public function penghasilan()
    {
        $term = $this->request->getGet('term');
        $model = new \App\Models\PenghasilanModel();
        $builder = $model;
        if ($term) {
            $builder = $builder->like('penghasilan', $term);
        }
        $data = $builder->select('id_penghasilan, penghasilan')->findAll(20); // limit 20
        return $this->response->setJSON($data);
    }
    // API Key untuk integrasi (ganti sesuai kebutuhan)
    private $apiKey = 'SEKOLAHKU-API-2025';

    // Validasi API Key/token
    private function validateToken()
    {
        $token = $this->request->getGet('token') ?? $this->request->getHeaderLine('X-API-KEY');
        if ($token !== $this->apiKey) {
            return false;
        }
        return true;
    }

    // Endpoint utama: Ambil semua data penting (siswa, sekolah, dll)
    public function all()
    {
        if (!$this->validateToken()) {
            return $this->failUnauthorized('Token/API Key tidak valid.');
        }

        $data = [];
        try {
            // Gunakan helper untuk mendapatkan tahun ajaran yang sedang dilihat
            $currentTahunAjaranId = getCurrentTahunAjaran();
            $tahunAjaranInfo = getViewingTahunAjaranInfo();

            $db = db_connect();

            // Siswa berdasarkan tahun ajaran yang sedang dilihat (gunakan field yang benar: id_tahun)
            $data['siswa'] = $db->query('
                SELECT s.* 
                FROM db_siswa s
                JOIN db_rombel r ON s.id_rombel = r.id_rombel
                WHERE r.id_tahun = ?
                ORDER BY s.nama_siswa ASC
            ', [$currentTahunAjaranId])->getResult();

            $data['sekolah'] = (new \App\Models\LembagaModel())->findAll();
            $data['mapel'] = (new \App\Models\MatpelModel())->findAll();
            $data['guru'] = (new \App\Models\PendidikModel())->findAll();

            // Kelas/rombel berdasarkan tahun ajaran yang sedang dilihat (gunakan field yang benar: id_tahun)
            $data['kelas'] = (new \App\Models\RombelModel())->where('id_tahun', $currentTahunAjaranId)->findAll();

            $data['tahun_ajaran'] = (new \App\Models\TapelModel())->findAll();

            // Tambahkan metadata
            $data['metadata'] = [
                'timestamp' => date('Y-m-d H:i:s'),
                'tahun_ajaran_aktif' => $tahunAjaranInfo['tahun_ajaran'],
                'id_tahun_ajaran_aktif' => $currentTahunAjaranId,
                'total_siswa' => count($data['siswa']),
                'total_guru' => count($data['guru']),
                'total_kelas' => count($data['kelas']),
                'total_mapel' => count($data['mapel'])
            ];
        } catch (\Exception $e) {
            return $this->failServerError('Error mengambil data: ' . $e->getMessage());
        }

        return $this->respond([
            'status' => 'success',
            'message' => 'Data berhasil diambil',
            'data' => $data
        ]);
    }    // Endpoint untuk data siswa
    public function siswa()
    {
        if (!$this->validateToken()) {
            return $this->failUnauthorized('Token/API Key tidak valid.');
        }

        try {
            // Gunakan helper untuk mendapatkan tahun ajaran yang sedang dilihat
            $currentTahunAjaranId = getCurrentTahunAjaran();
            $tahunAjaranInfo = getViewingTahunAjaranInfo();

            $db = db_connect();

            // Dapatkan field name yang tepat untuk tabel siswa
            $siswaFieldName = getTahunAjaranFieldName('db_siswa');

            // Query siswa berdasarkan tahun ajaran yang sedang dilihat (langsung dari tabel siswa)
            $data = $db->query("
                SELECT s.* 
                FROM db_siswa s
                WHERE s.$siswaFieldName = ?
                ORDER BY s.nama_siswa ASC
            ", [$currentTahunAjaranId])->getResult();

            return $this->respond([
                'status' => 'success',
                'message' => 'Data siswa berhasil diambil',
                'tahun_ajaran' => $tahunAjaranInfo ? $tahunAjaranInfo->tahun_ajaran : 'Unknown',
                'total' => count($data),
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return $this->failServerError('Error mengambil data siswa: ' . $e->getMessage());
        }
    }

    // Endpoint untuk data guru/pendidik
    public function guru()
    {
        if (!$this->validateToken()) {
            return $this->failUnauthorized('Token/API Key tidak valid.');
        }

        try {
            $model = new \App\Models\PendidikModel();
            $data = $model->findAll();

            return $this->respond([
                'status' => 'success',
                'message' => 'Data guru berhasil diambil',
                'total' => count($data),
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return $this->failServerError('Error mengambil data guru: ' . $e->getMessage());
        }
    }

    // Endpoint untuk data mata pelajaran
    public function mapel()
    {
        if (!$this->validateToken()) {
            return $this->failUnauthorized('Token/API Key tidak valid.');
        }

        try {
            $model = new \App\Models\MatpelModel();
            $data = $model->findAll();

            return $this->respond([
                'status' => 'success',
                'message' => 'Data mata pelajaran berhasil diambil',
                'total' => count($data),
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return $this->failServerError('Error mengambil data mata pelajaran: ' . $e->getMessage());
        }
    }    // Endpoint untuk data kelas/rombel
    public function kelas()
    {
        if (!$this->validateToken()) {
            return $this->failUnauthorized('Token/API Key tidak valid.');
        }

        try {
            // Gunakan helper untuk mendapatkan tahun ajaran yang sedang dilihat
            $currentTahunAjaranId = getCurrentTahunAjaran();
            $tahunAjaranInfo = getViewingTahunAjaranInfo();

            // Dapatkan field name yang tepat untuk tabel rombel
            $rombelFieldName = getTahunAjaranFieldName('db_rombel');

            $model = new \App\Models\RombelModel();
            $data = $model->where($rombelFieldName, $currentTahunAjaranId)->findAll();

            return $this->respond([
                'status' => 'success',
                'message' => 'Data kelas berhasil diambil',
                'tahun_ajaran' => $tahunAjaranInfo ? $tahunAjaranInfo->tahun_ajaran : 'Unknown',
                'total' => count($data),
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return $this->failServerError('Error mengambil data kelas: ' . $e->getMessage());
        }
    }

    // Endpoint untuk data sekolah/lembaga
    public function sekolah()
    {
        if (!$this->validateToken()) {
            return $this->failUnauthorized('Token/API Key tidak valid.');
        }

        try {
            $model = new \App\Models\LembagaModel();
            $data = $model->findAll();

            return $this->respond([
                'status' => 'success',
                'message' => 'Data sekolah berhasil diambil',
                'total' => count($data),
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return $this->failServerError('Error mengambil data sekolah: ' . $e->getMessage());
        }
    }

    // Endpoint untuk data tahun ajaran
    public function tahun_ajaran()
    {
        if (!$this->validateToken()) {
            return $this->failUnauthorized('Token/API Key tidak valid.');
        }

        try {
            $model = new \App\Models\TapelModel();
            $data = $model->findAll();

            return $this->respond([
                'status' => 'success',
                'message' => 'Data tahun ajaran berhasil diambil',
                'total' => count($data),
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return $this->failServerError('Error mengambil data tahun ajaran: ' . $e->getMessage());
        }
    }

    // Endpoint untuk informasi API
    public function info()
    {
        return $this->respond([
            'api_name' => 'SEKOLAHKU API',
            'version' => '1.0',
            'description' => 'API untuk integrasi data sekolah dengan aplikasi lain',
            'base_url' => base_url(),
            'documentation' => base_url('api/menu'),
            'timestamp' => date('Y-m-d H:i:s'),
            'endpoints' => [
                'GET /api/info' => 'Informasi API (tidak perlu token)',
                'GET /api/debug' => 'Debug informasi (tidak perlu token)',
                'GET /api/all' => 'Semua data sekaligus',
                'GET /api/siswa' => 'Data siswa',
                'GET /api/guru' => 'Data guru/pendidik',
                'GET /api/mapel' => 'Data mata pelajaran',
                'GET /api/kelas' => 'Data kelas/rombel',
                'GET /api/sekolah' => 'Data sekolah/lembaga',
                'GET /api/tahun_ajaran' => 'Data tahun ajaran'
            ],
            'authentication' => 'Token via query parameter (?token=...) atau header (X-API-KEY)'
        ]);
    }

    // Endpoint untuk debugging
    public function debug()
    {
        $debug = [
            'timestamp' => date('Y-m-d H:i:s'),
            'environment' => ENVIRONMENT,
            'codeigniter_version' => \CodeIgniter\CodeIgniter::CI_VERSION,
            'php_version' => PHP_VERSION,
            'models_check' => [
                'SiswaModel' => class_exists('\App\Models\SiswaModel'),
                'LembagaModel' => class_exists('\App\Models\LembagaModel'),
                'MatpelModel' => class_exists('\App\Models\MatpelModel'),
                'PendidikModel' => class_exists('\App\Models\PendidikModel'),
                'RombelModel' => class_exists('\App\Models\RombelModel'),
                'TapelModel' => class_exists('\App\Models\TapelModel')
            ]
        ];

        return $this->respond($debug);
    }

    // Tabel API Key sederhana (bisa dikembangkan ke database jika perlu)
    private $apiKeys = [
        [
            'key' => 'SEKOLAHKU-API-2025',
            'created_at' => '2025-06-02',
            'desc' => 'Default API Key',
        ],
        // Tambahkan key lain jika perlu
    ];

    // Endpoint untuk generate dan melihat daftar API Key
    public function apiKeys()
    {
        // Untuk demo, generate key random baru (bisa diubah ke POST/DB di produksi)
        if ($this->request->getMethod() === 'post') {
            $newKey = 'KEY-' . bin2hex(random_bytes(8));
            $this->apiKeys[] = [
                'key' => $newKey,
                'created_at' => date('Y-m-d'),
                'desc' => 'Generated at ' . date('Y-m-d H:i:s'),
            ];
        }
        // Tampilkan dalam bentuk tabel HTML sederhana
        $html = '<h4>Daftar API Key</h4>';
        $html .= '<table class="table table-bordered"><thead><tr><th>API Key</th><th>Dibuat</th><th>Keterangan</th></tr></thead><tbody>';
        foreach ($this->apiKeys as $row) {
            $html .= '<tr><td><code>' . esc($row['key']) . '</code></td><td>' . esc($row['created_at']) . '</td><td>' . esc($row['desc']) . '</td></tr>';
        }
        $html .= '</tbody></table>';
        return $this->response->setContentType('text/html')->setBody($html);
    }
}
