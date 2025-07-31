<?php

namespace App\Controllers;

use App\Services\SemesterService;
use CodeIgniter\RESTful\ResourceController;

class SemesterManagement extends ResourceController
{
    protected $semesterService;
    protected $tapelModel;

    public function __construct()
    {
        $this->semesterService = new SemesterService();
        $this->tapelModel = model('TapelModel');
    }

    /**
     * Dashboard manajemen semester
     */
    public function index()
    {
        $data = [
            'current_semester' => $this->semesterService->getCurrentActiveSemester(),
            'available_semesters' => $this->semesterService->getAvailableSemesters(),
            'tahun_ajaran' => $this->tapelModel->findAll()
        ];

        return view('semester_management/index', $data);
    }

    /**
     * Form pindah semester
     */
    public function changeSemesterForm()
    {
        $data = [
            'current_semester' => $this->semesterService->getCurrentActiveSemester(),
            'tahun_ajaran' => $this->tapelModel->findAll()
        ];

        return view('semester_management/change_form', $data);
    }

    /**
     * Proses pindah semester
     */
    public function processSemesterChange()
    {
        $rules = [
            'id_tahun_ajaran' => 'required|integer',
            'semester' => 'required|in_list[1,2]',
            'tanggal_mulai' => 'required|valid_date',
            'tanggal_selesai' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $id_tahun_ajaran = $this->request->getPost('id_tahun_ajaran');
        $semester = $this->request->getPost('semester');
        $tanggal_mulai = $this->request->getPost('tanggal_mulai');
        $tanggal_selesai = $this->request->getPost('tanggal_selesai');
        $keterangan = $this->request->getPost('keterangan');

        // Backup otomatis jika dicentang
        if ($this->request->getPost('backup_otomatis')) {
            $currentSemester = $this->semesterService->getCurrentActiveSemester();
            if ($currentSemester) {
                $backupResult = $this->semesterService->backupCurrentSemester(
                    $currentSemester->id_tahun_ajaran,
                    $currentSemester->semester
                );

                if (!$backupResult['success']) {
                    return redirect()->back()->with('error', $backupResult['message']);
                }
            }
        }

        // Proses pindah semester
        $result = $this->semesterService->changeSemester(
            $id_tahun_ajaran,
            $semester,
            $tanggal_mulai,
            $tanggal_selesai,
            $keterangan
        );

        if ($result['success']) {
            return redirect()->to('semester-management')->with('success', $result['message']);
        } else {
            return redirect()->back()->with('error', $result['message']);
        }
    }

    /**
     * Form naik kelas otomatis
     */
    public function naikKelasForm()
    {
        $data = [
            'tahun_ajaran' => $this->tapelModel->orderBy('tahun', 'DESC')->findAll()
        ];

        return view('semester_management/naik_kelas_form', $data);
    }

    /**
     * Proses naik kelas otomatis
     */
    public function processNaikKelas()
    {
        $rules = [
            'id_tahun_ajaran_lama' => 'required|integer',
            'id_tahun_ajaran_baru' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $id_tahun_ajaran_lama = $this->request->getPost('id_tahun_ajaran_lama');
        $id_tahun_ajaran_baru = $this->request->getPost('id_tahun_ajaran_baru');

        $result = $this->semesterService->naikKelasOtomatis($id_tahun_ajaran_lama, $id_tahun_ajaran_baru);

        if ($result['success']) {
            return redirect()->to('semester-management')->with('success', $result['message']);
        } else {
            return redirect()->back()->with('error', $result['message']);
        }
    }

    /**
     * Lihat history semester
     */
    public function viewHistory($id_tahun_ajaran, $semester)
    {
        $data = [
            'siswa_history' => $this->semesterService->getSiswaHistoryBySemester($id_tahun_ajaran, $semester),
            'rombel_history' => $this->semesterService->getRombelHistoryBySemester($id_tahun_ajaran, $semester),
            'tahun_ajaran' => $this->tapelModel->find($id_tahun_ajaran),
            'semester' => $semester
        ];

        return view('semester_management/history', $data);
    }

    /**
     * Manual backup semester
     */
    public function manualBackup()
    {
        $currentSemester = $this->semesterService->getCurrentActiveSemester();

        if (!$currentSemester) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tidak ada semester aktif untuk di-backup'
            ]);
        }

        $result = $this->semesterService->backupCurrentSemester(
            $currentSemester->id_tahun_ajaran,
            $currentSemester->semester
        );

        return $this->response->setJSON($result);
    }

    /**
     * Get data semester via AJAX
     */
    public function getSemesterData()
    {
        $currentSemester = $this->semesterService->getCurrentActiveSemester();

        return $this->response->setJSON([
            'current_semester' => $currentSemester,
            'session_data' => [
                'id_tahun_ajaran_aktif' => session('id_tahun_ajaran_aktif'),
                'semester_aktif' => session('semester_aktif'),
            ]
        ]);
    }

    /**
     * Export laporan semester
     */
    public function exportSemesterReport($id_tahun_ajaran, $semester)
    {
        $siswaHistory = $this->semesterService->getSiswaHistoryBySemester($id_tahun_ajaran, $semester);
        $rombelHistory = $this->semesterService->getRombelHistoryBySemester($id_tahun_ajaran, $semester);
        $tahunAjaran = $this->tapelModel->find($id_tahun_ajaran);

        // Generate Excel/PDF report
        $data = [
            'siswa_history' => $siswaHistory,
            'rombel_history' => $rombelHistory,
            'tahun_ajaran' => $tahunAjaran,
            'semester' => $semester,
            'tanggal_export' => date('d/m/Y H:i:s')
        ];

        return view('semester_management/export_report', $data);
    }

    /**
     * Form untuk beralih ke tahun ajaran tertentu
     */
    public function switchTahunAjaranForm()
    {
        $data = [
            'current_tahun_ajaran' => $this->semesterService->getViewingTahunAjaran(),
            'tahun_ajaran_list' => $this->tapelModel->orderBy('tahun', 'DESC')->findAll()
        ];

        return view('semester_management/switch_tahun_ajaran_form', $data);
    }

    /**
     * Proses beralih ke tahun ajaran tertentu
     */
    public function processSwitchTahunAjaran()
    {
        // Debug information - log the request method and POST data
        log_message('debug', 'Processing switch tahun ajaran. Method: ' . $this->request->getMethod());
        log_message('debug', 'POST data: ' . json_encode($this->request->getPost()));
        log_message('debug', 'Session ID: ' . session_id());
        log_message('debug', 'User ID in session: ' . session('id_user'));

        $rules = [
            'id_tahun_ajaran' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            log_message('error', 'Validation failed: ' . json_encode($this->validator->getErrors()));

            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Validasi gagal: ' . implode(', ', $this->validator->getErrors())
                ]);
            }

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $id_tahun_ajaran = $this->request->getPost('id_tahun_ajaran');
        $result = $this->semesterService->switchTahunAjaran($id_tahun_ajaran);

        // If this is an AJAX request, return JSON
        if ($this->request->isAJAX()) {
            return $this->response->setJSON($result);
        }

        // For normal form submissions, do a redirect
        if ($result['success']) {
            return redirect()->to('/')->with('success', $result['message']);
        } else {
            return redirect()->back()->with('error', $result['message']);
        }
    }

    /**
     * Reset ke tahun ajaran aktif
     */
    public function resetTahunAjaranView()
    {
        $result = $this->semesterService->resetTahunAjaranView();

        if ($result['success']) {
            return redirect()->to('/')->with('success', $result['message']);
        } else {
            return redirect()->back()->with('error', $result['message']);
        }
    }

    /**
     * Test method to check session and auth
     */
    public function checkSession()
    {
        $data = [
            'session_id' => session_id(),
            'user_id' => session('id_user'),
            'username' => session('username'),
            'csrf_token' => csrf_hash(),
            'csrf_name' => csrf_token(),
            'all_session' => session()->get(),
            'is_ajax' => $this->request->isAJAX(),
            'user_agent' => $this->request->getUserAgent()->getAgentString(),
        ];

        return $this->response->setJSON($data);
    }
}
