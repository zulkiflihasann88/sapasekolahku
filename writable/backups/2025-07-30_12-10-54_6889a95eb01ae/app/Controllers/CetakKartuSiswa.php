<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CetakKartuSiswa extends ResourceController
{
    protected $siswaModel;
    protected $rombelModel;
    protected $tapelModel;
    protected $lembagaModel;
    protected $sekolahModel;
    protected $kepalasekolahModel;
    protected $db;
    function __construct()
    {
        $this->siswaModel = model('SiswaModel');
        $this->rombelModel = model('RombelModel');
        $this->tapelModel = model('TapelModel');
        $this->lembagaModel = model('LembagaModel');
        $this->sekolahModel = model('SekolahModel');
        $this->kepalasekolahModel = model('KepalasekolahModel');
        $this->db = \Config\Database::connect();
    }
    private function getKepalaSekolahAktif()
    {
        try {            // Try to get the active kepala sekolah using the model
            $kepalasekolah = $this->kepalasekolahModel->where('status', 'Aktif')
                ->where('aktivasi', 'Sedang Aktif')
                ->orderBy('id_kepalasekolah', 'DESC')
                ->first();
            if ($kepalasekolah) {
                return $kepalasekolah;
            }

            // If no active kepala sekolah with both conditions, try just with active status
            $kepalasekolah = $this->kepalasekolahModel->where('status', 'Aktif')
                ->orderBy('id_kepalasekolah', 'DESC')
                ->first();

            if ($kepalasekolah) {
                return $kepalasekolah;
            }

            // If no active kepala sekolah, get the latest one
            $kepalasekolah = $this->kepalasekolahModel->orderBy('id_kepalasekolah', 'DESC')->first();

            if ($kepalasekolah) {
                return $kepalasekolah;
            }

            // If still no data, try with raw SQL as fallback
            $sql = "SELECT nama, nip FROM db_kepalasekolah ORDER BY id_kepalasekolah DESC LIMIT 1";
            $query = $this->db->query($sql);
            $result = $query->getRow();

            if ($result) {
                return $result;
            }

            // Last resort - return dummy data with a note
            return (object) [
                'nama' => 'Drs. Suwardi, M.Pd',
                'nip' => '196512151990031008',
                'is_dummy' => true
            ];
        } catch (\Exception $e) {
            // Log the error for debugging
            log_message('error', 'Error getting kepala sekolah: ' . $e->getMessage());

            return (object) [
                'nama' => 'Drs. Suwardi, M.Pd',
                'nip' => '196512151990031008',
                'is_dummy' => true,
                'error' => $e->getMessage()
            ];
        }
    }
    public function index()
    {
        // Load data untuk dropdown dan siswa
        $data['rombel'] = $this->rombelModel->getAll();
        $data['tapel'] = $this->tapelModel->getAll();
        $data['lembaga'] = $this->lembagaModel->find(1);
        $data['kepala_sekolah'] = $this->getKepalaSekolahAktif();        // Load semua siswa untuk select dropdown
        $sql = "SELECT s.id_siswa, s.nisn, s.nis, 
                       s.nama_siswa as nama_lengkap,
                       IFNULL(r.kelas, 'Belum Ada Kelas') as nama_rombel,
                       IFNULL(t.ket_tahun, 'Belum Ada TA') as tahun_pelajaran
                FROM db_siswa s 
                LEFT JOIN db_rombel r ON s.id_rombel = r.id_rombel 
                LEFT JOIN db_tahunajaran t ON r.id_tahun = t.id_tahunajaran
                ORDER BY s.nama_siswa ASC";

        $query = $this->db->query($sql);
        $data['siswa'] = $query->getResult();

        return view('cetak_kartu_siswa/index', $data);
    }
    public function preview($id = null)
    {
        if ($id) {            // Query manual untuk preview
            $sql = "SELECT s.*, 
                           s.nama_siswa as nama_lengkap,
                           s.jk as jenis_kelamin,
                           IFNULL(r.kelas, 'Belum Ada Kelas') as nama_rombel,
                           IFNULL(t.ket_tahun, 'Belum Ada TA') as tahun_pelajaran
                    FROM db_siswa s 
                    LEFT JOIN db_rombel r ON s.id_rombel = r.id_rombel 
                    LEFT JOIN db_tahunajaran t ON r.id_tahun = t.id_tahunajaran
                    WHERE s.id_siswa = ?";
            $query = $this->db->query($sql, [$id]);
            $data['siswa'] = $query->getRow();
            $data['lembaga'] = $this->lembagaModel->find(1);
            $data['sekolah'] = $this->sekolahModel->getSekolah();
            $data['kepala_sekolah'] = $this->getKepalaSekolahAktif();

            if (!$data['siswa']) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

            return view('cetak_kartu_siswa/preview', $data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
    public function cetak($id = null)
    {
        if ($id) {            // Query manual untuk cetak
            $sql = "SELECT s.*, 
                           s.nama_siswa as nama_lengkap,
                           s.jk as jenis_kelamin,
                           IFNULL(r.kelas, 'Belum Ada Kelas') as nama_rombel,
                           IFNULL(t.ket_tahun, 'Belum Ada TA') as tahun_pelajaran
                    FROM db_siswa s 
                    LEFT JOIN db_rombel r ON s.id_rombel = r.id_rombel 
                    LEFT JOIN db_tahunajaran t ON r.id_tahun = t.id_tahunajaran
                    WHERE s.id_siswa = ?";
            $query = $this->db->query($sql, [$id]);
            $data['siswa'] = $query->getRow();
            $data['lembaga'] = $this->lembagaModel->find(1);
            $data['sekolah'] = $this->sekolahModel->getSekolah();
            $data['kepala_sekolah'] = $this->getKepalaSekolahAktif();

            if (!$data['siswa']) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

            return view('cetak_kartu_siswa/cetak', $data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function cetakMasal()
    {
        $rombel_id = $this->request->getPost('rombel_id');
        $tapel_id = $this->request->getPost('tapel_id');
        if ($rombel_id && $tapel_id) {            // Query manual untuk cetak masal
            $sql = "SELECT s.*, 
                           s.nama_siswa as nama_lengkap,
                           IFNULL(r.kelas, 'Belum Ada Kelas') as nama_rombel,
                           IFNULL(t.ket_tahun, 'Belum Ada TA') as tahun_pelajaran
                    FROM db_siswa s 
                    LEFT JOIN db_rombel r ON s.id_rombel = r.id_rombel 
                    LEFT JOIN db_tahunajaran t ON r.id_tahun = t.id_tahunajaran
                    WHERE s.id_rombel = ? AND r.id_tahun = ?";
            $query = $this->db->query($sql, [$rombel_id, $tapel_id]);
            $data['siswa_list'] = $query->getResult();
            $data['lembaga'] = $this->lembagaModel->find(1);
            $data['kepala_sekolah'] = $this->getKepalaSekolahAktif();

            return view('cetak_kartu_siswa/cetak_masal', $data);
        } else {
            return redirect()->back()->with('error', 'Pilih rombel dan tahun pelajaran terlebih dahulu');
        }
    }
    public function uploadTemplate()
    {
        $uploadPath = FCPATH . 'uploads/';

        // Create uploads directory if not exists
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $response = ['success' => false, 'message' => ''];

        // Handle template depan
        $templateDepan = $this->request->getFile('template_depan');
        if ($templateDepan && $templateDepan->isValid() && !$templateDepan->hasMoved()) {
            if ($templateDepan->getSize() > 2 * 1024 * 1024) { // 2MB limit
                $response['message'] = 'File template depan terlalu besar (maksimal 2MB)';
                return redirect()->back()->with('error', $response['message']);
            }

            if (in_array($templateDepan->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {
                $templateDepan->move($uploadPath, 'template_kartu_depan.jpg');
                $response['success'] = true;
            } else {
                $response['message'] = 'Format file template depan tidak didukung';
                return redirect()->back()->with('error', $response['message']);
            }
        }        // Handle template belakang
        $templateBelakang = $this->request->getFile('template_belakang');
        if ($templateBelakang && $templateBelakang->isValid() && !$templateBelakang->hasMoved()) {
            if ($templateBelakang->getSize() > 2 * 1024 * 1024) { // 2MB limit
                $response['message'] = 'File template belakang terlalu besar (maksimal 2MB)';
                return redirect()->back()->with('error', $response['message']);
            }

            if (in_array($templateBelakang->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {
                $templateBelakang->move($uploadPath, 'template_kartu_belakang.jpg');
                $response['success'] = true;
            } else {
                $response['message'] = 'Format file template belakang tidak didukung';
                return redirect()->back()->with('error', $response['message']);
            }
        }

        // Handle logo sekolah
        $logoSekolah = $this->request->getFile('logo_sekolah');
        if ($logoSekolah && $logoSekolah->isValid() && !$logoSekolah->hasMoved()) {
            if ($logoSekolah->getSize() > 1024 * 1024) { // 1MB limit
                $response['message'] = 'File logo sekolah terlalu besar (maksimal 1MB)';
                return redirect()->back()->with('error', $response['message']);
            }

            if (in_array($logoSekolah->getMimeType(), ['image/png', 'image/jpeg', 'image/jpg'])) {
                $logoSekolah->move($uploadPath, 'logo_sekolah.png');
                $response['success'] = true;
            } else {
                $response['message'] = 'Format file logo sekolah tidak didukung (gunakan PNG untuk transparansi)';
                return redirect()->back()->with('error', $response['message']);
            }
        }

        // Handle logo pemda
        $logoPemda = $this->request->getFile('logo_pemda');
        if ($logoPemda && $logoPemda->isValid() && !$logoPemda->hasMoved()) {
            if ($logoPemda->getSize() > 1024 * 1024) { // 1MB limit
                $response['message'] = 'File logo pemda terlalu besar (maksimal 1MB)';
                return redirect()->back()->with('error', $response['message']);
            }

            if (in_array($logoPemda->getMimeType(), ['image/png', 'image/jpeg', 'image/jpg'])) {
                $logoPemda->move($uploadPath, 'logo_pemda.png');
                $response['success'] = true;
            } else {
                $response['message'] = 'Format file logo pemda tidak didukung (gunakan PNG untuk transparansi)';
                return redirect()->back()->with('error', $response['message']);
            }
        }

        if ($response['success']) {
            return redirect()->back()->with('success', 'Template berhasil diupload');
        } else {
            return redirect()->back()->with('error', 'Tidak ada file yang diupload atau terjadi kesalahan');
        }
    }
    public function resetTemplate()
    {
        // Check if user is logged in
        if (!session('id_user')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Unauthorized access'
            ]);
        }

        // Verify CSRF token if enabled
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
        }

        try {
            $uploadPath = FCPATH . 'uploads/';
            $success = true;
            $deletedFiles = [];

            // Delete template files
            if (file_exists($uploadPath . 'template_kartu_depan.jpg')) {
                if (unlink($uploadPath . 'template_kartu_depan.jpg')) {
                    $deletedFiles[] = 'template_kartu_depan.jpg';
                } else {
                    $success = false;
                }
            }

            if (file_exists($uploadPath . 'template_kartu_belakang.jpg')) {
                if (unlink($uploadPath . 'template_kartu_belakang.jpg')) {
                    $deletedFiles[] = 'template_kartu_belakang.jpg';
                } else {
                    $success = false;
                }
            }

            // Delete logo files
            if (file_exists($uploadPath . 'logo_sekolah.png')) {
                if (unlink($uploadPath . 'logo_sekolah.png')) {
                    $deletedFiles[] = 'logo_sekolah.png';
                } else {
                    $success = false;
                }
            }

            if (file_exists($uploadPath . 'logo_pemda.png')) {
                if (unlink($uploadPath . 'logo_pemda.png')) {
                    $deletedFiles[] = 'logo_pemda.png';
                } else {
                    $success = false;
                }
            }

            $message = $success
                ? 'Template dan logo berhasil direset' . (count($deletedFiles) > 0 ? ' (' . implode(', ', $deletedFiles) . ')' : '')
                : 'Gagal mereset template dan logo';

            return $this->response->setJSON([
                'success' => $success,
                'message' => $message,
                'deletedFiles' => $deletedFiles
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in resetTemplate: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ]);
        }
    }

    public function getSiswaOptions()
    {        // Query untuk mendapatkan semua siswa untuk dropdown
        $sql = "SELECT s.id_siswa, s.nisn, s.nis, 
                       s.nama_siswa as nama_lengkap,
                       IFNULL(r.kelas, 'Belum Ada Kelas') as nama_rombel,
                       IFNULL(t.ket_tahun, 'Belum Ada TA') as tahun_pelajaran
                FROM db_siswa s 
                LEFT JOIN db_rombel r ON s.id_rombel = r.id_rombel 
                LEFT JOIN db_tahunajaran t ON r.id_tahun = t.id_tahunajaran
                ORDER BY s.nama_siswa ASC";

        $query = $this->db->query($sql);
        $results = $query->getResult();

        return $this->response->setJSON([
            'success' => true,
            'data' => $results
        ]);
    }

    /**
     * Test method to check uploads directory permissions and access
     */
    public function testUploadsAccess()
    {
        if (!session('id_user')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $uploadPath = FCPATH . 'uploads/';
        $tests = [];

        // Check if uploads directory exists
        $tests['directory_exists'] = is_dir($uploadPath);

        // Check if uploads directory is writable
        $tests['directory_writable'] = is_writable($uploadPath);

        // Check if uploads directory is readable
        $tests['directory_readable'] = is_readable($uploadPath);

        // List existing files
        $tests['existing_files'] = [];
        if ($tests['directory_exists']) {
            $files = scandir($uploadPath);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && is_file($uploadPath . $file)) {
                    $tests['existing_files'][] = [
                        'filename' => $file,
                        'size' => filesize($uploadPath . $file),
                        'writable' => is_writable($uploadPath . $file),
                        'readable' => is_readable($uploadPath . $file)
                    ];
                }
            }
        }

        // Check session info
        $tests['session_info'] = [
            'user_id' => session('id_user'),
            'session_id' => session_id(),
            'last_activity' => session('lastActivity') ?? 'not set'
        ];

        return $this->response->setJSON([
            'success' => true,
            'tests' => $tests,
            'upload_path' => $uploadPath
        ]);
    }
}
