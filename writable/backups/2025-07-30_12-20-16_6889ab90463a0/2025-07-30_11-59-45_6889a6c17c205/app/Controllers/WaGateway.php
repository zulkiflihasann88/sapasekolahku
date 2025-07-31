<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\WaGatewayModel;
use App\Models\PesanTerkirimModel;
use App\Services\WhatsAppService;

class WaGateway extends Controller
{
    public function index()
    {
        // Ambil log pesan terkirim (limit 100 terakhir)
        $pesan_terkirim = [];
        try {
            $model = new PesanTerkirimModel();
            $pesan_terkirim = $model->orderBy('created_at', 'DESC')->findAll(100);
        } catch (\Throwable $e) {
            // ignore error, show empty log
        }
        return view('wa_gateway/index', compact('pesan_terkirim'));
    }


    // Tampilkan log pesan terkirim (AJAX/partial)
    public function pesanTerkirim()
    {
        $model = new PesanTerkirimModel();
        $pesan_terkirim = $model->orderBy('created_at', 'DESC')->findAll(100); // limit 100 terakhir
        return view('wa_gateway/pesan_terkirim', compact('pesan_terkirim'));
    }

    // Tampilkan halaman log khusus (menu Log)
    public function log()
    {
        $pesan_terkirim = [];
        try {
            $model = new PesanTerkirimModel();
            $pesan_terkirim = $model->orderBy('created_at', 'DESC')->findAll(100);
        } catch (\Throwable $e) {
            // ignore error, show empty log
            log_message('error', 'Error loading message logs: ' . $e->getMessage());
        }
        return view('wa_gateway/log', compact('pesan_terkirim'));
    }

    // Contoh endpoint untuk mengirim pesan WA (POST)
    public function sendMessage()
    {
        $number = $this->request->getPost('number');
        $message = $this->request->getPost('message');

        if (!$number || !$message) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nomor dan pesan harus diisi'
            ]);
        }

        // Ambil domain & apikey dari database
        $model = new \App\Models\WaGatewayModel();
        $config = $model->first();
        if (!$config) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Konfigurasi WhatsApp API belum diatur'
            ]);
        }
        $domain = $config['domain'] ?? $config['api_url'] ?? '';
        $apikey = $config['apikey'] ?? $config['api_key'] ?? '';
        $device_id = $config['device_id'] ?? '';

        // Wamoo API endpoint
        $url = 'https://wamoo.kimonet.my.id/send-message';
        $data = [
            'api_key' => $apikey,
            'sender' => $device_id,
            'number' => $number,
            'message' => $message
        ];

        // Use JSON format as per Wamoo documentation
        $headers = [
            'Content-Type: application/json'
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlerr = curl_error($ch);
        curl_close($ch);

        $responseArr = json_decode($result, true);
        $now = date('Y-m-d H:i:s'); // waktu pengiriman pesan


        // Logging pesan terkirim ke database
        $statusLog = 'pending';
        if ($curlerr) {
            $statusLog = 'gagal';
        } elseif ($httpcode >= 200 && $httpcode < 300) {
            // Check Wamoo response format
            if (isset($responseArr['status']) && $responseArr['status'] === true) {
                $statusLog = 'success';
            } elseif ($httpcode == 200) {
                $statusLog = 'success'; // Assume success if 200 OK
            } else {
                $statusLog = 'gagal';
            }
        } else {
            $statusLog = 'gagal';
        }
        $logModel = new \App\Models\PesanTerkirimModel();
        $logData = [
            'nomor_tujuan' => $number, // nomor tujuan WA
            'tujuan' => $number, // Keep for backward compatibility
            'pesan' => $message,
            'status' => $statusLog,
            'response_api' => $curlerr ? $curlerr : $result,
            'response' => $curlerr ? $curlerr : $result, // Keep for backward compatibility
            'created_at' => $now,
        ];

        try {
            $logModel->insert($logData);
        } catch (\Exception $e) {
            // Log error but continue
            log_message('error', 'Failed to insert WA log: ' . $e->getMessage());
        }

        if ($curlerr) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Curl error: ' . $curlerr
            ]);
        }

        // Add debug information for HTTP errors
        if ($httpcode >= 400) {
            return $this->response->setJSON([
                'success' => false,
                'message' => "HTTP Error $httpcode: " . ($responseArr['msg'] ?? $result),
                'debug' => [
                    'url' => $url,
                    'data_sent' => $data,
                    'http_code' => $httpcode,
                    'response' => $result
                ]
            ]);
        }

        // If response can't be decoded
        if (!is_array($responseArr)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid response from gateway: ' . $result
            ]);
        }

        // Check Wamoo response format
        if (isset($responseArr['status']) && $responseArr['status'] === false) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $responseArr['msg'] ?? 'Error from Wamoo API',
                'response' => $responseArr
            ]);
        }

        // Success
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Pesan berhasil dikirim',
            'response' => $responseArr
        ]);
    }

    // Endpoint untuk menyimpan konfigurasi
    public function saveConfig()
    {
        $api_url = $this->request->getPost('api_url');
        $api_key = $this->request->getPost('api_key');
        $device_id = $this->request->getPost('device_id');
        $status = $this->request->getPost('status');

        if (!$api_key) {
            return $this->response->setJSON(['success' => false, 'message' => 'API Key wajib diisi']);
        }

        $model = new WaGatewayModel();
        // Update allowedFields to match new structure
        $model->setAllowedFields(['domain', 'apikey', 'api_url', 'api_key', 'device_id', 'status']);

        // Convert status to integer (1 for active, 0 for inactive)
        $statusValue = ($status == '1') ? 1 : 0;

        // Hanya simpan satu baris, update jika sudah ada
        $existing = $model->first();
        $configData = [
            'domain' => $api_url, // Keep for backward compatibility
            'apikey' => $api_key, // Keep for backward compatibility
            'api_url' => $api_url,
            'api_key' => $api_key,
            'device_id' => $device_id,
            'status' => $statusValue
        ];

        if ($existing) {
            $model->update($existing['id'], $configData);
        } else {
            $model->insert($configData);
        }
        return $this->response->setJSON(['success' => true]);
    }

    // Endpoint untuk mengambil konfigurasi
    public function getConfig()
    {
        $model = new WaGatewayModel();
        $row = $model->first();

        // Add debug logging
        log_message('info', 'Config query result: ' . ($row ? json_encode($row) : 'NULL'));

        if ($row) {
            return $this->response->setJSON(['success' => true, 'config' => $row]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Konfigurasi belum diatur']);
        }
    }
    // Hapus log pesan terkirim
    public function deleteLog()
    {
        // Validate CSRF token (akan otomatis divalidasi oleh CodeIgniter jika CSRF protection aktif)

        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['success' => false, 'message' => 'Request tidak valid']);
        }

        $id = $this->request->getPost('id');
        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID tidak valid']);
        }

        try {
            $model = new PesanTerkirimModel();
            if ($model->delete($id)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Log berhasil dihapus']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus log']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    // Hapus semua log pesan terkirim
    public function clearAllLogs()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['success' => false, 'message' => 'Request tidak valid']);
        }

        try {
            $model = new PesanTerkirimModel();
            if ($model->truncate()) {
                return $this->response->setJSON(['success' => true, 'message' => 'Semua log berhasil dihapus']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus semua log']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    // Test koneksi ke Wamoo API
    public function testConnection()
    {
        $api_url = $this->request->getPost('api_url');
        $api_key = $this->request->getPost('api_key');
        $device_id = $this->request->getPost('device_id');

        if (!$api_url || !$api_key || !$device_id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'API URL, API Key, dan Device ID harus diisi'
            ]);
        }

        // Test endpoint untuk Wamoo API - using send-message endpoint with test message
        $url = rtrim($api_url, '/') . '/send-message';

        $headers = [
            'Content-Type: application/json'
        ];

        $data = [
            'api_key' => $api_key,
            'sender' => $device_id,
            'number' => $device_id, // Test dengan nomor sender sendiri
            'message' => 'Test connection from Sekolahku system'
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlerr = curl_error($ch);
        curl_close($ch);

        if ($curlerr) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error koneksi: ' . $curlerr
            ]);
        }

        if ($httpcode >= 200 && $httpcode < 300) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Koneksi berhasil! HTTP Code: ' . $httpcode,
                'response' => $result
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'HTTP Error: ' . $httpcode . ' - ' . $result
            ]);
        }
    }

    // Kirim notifikasi pendaftaran siswa menggunakan template
    public function sendRegistrationNotification()
    {
        $nama = $this->request->getPost('nama');
        $no_pendaftaran = $this->request->getPost('no_pendaftaran');
        $nomor_wa = $this->request->getPost('nomor_wa');
        $tanggal_daftar = $this->request->getPost('tanggal_daftar') ?? date('d/m/Y');

        if (!$nama || !$no_pendaftaran || !$nomor_wa) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nama, nomor pendaftaran, dan nomor WhatsApp harus diisi'
            ]);
        }

        // Use WhatsAppService for sending notification
        $whatsAppService = new WhatsAppService();

        $studentData = [
            'nama_lengkap' => $nama,
            'nama' => $nama,
            'no_pendaftaran' => $no_pendaftaran,
            'nomor_wa_ayah' => $nomor_wa,
            'nomor_wa' => $nomor_wa,
            'tanggal_daftar' => $tanggal_daftar
        ];

        $result = $whatsAppService->sendRegistrationNotification($studentData);

        return $this->response->setJSON($result);
    }

    // Helper function untuk format nomor telepon
    private function formatPhoneNumber($number)
    {
        // Hapus semua karakter non-digit
        $number = preg_replace('/[^0-9]/', '', $number);

        // Jika dimulai dengan 0, ganti dengan 62
        if (substr($number, 0, 1) == '0') {
            $number = '62' . substr($number, 1);
        }

        // Jika dimulai dengan +62, hapus +
        if (substr($number, 0, 3) == '+62') {
            $number = substr($number, 1);
        }

        // Pastikan dimulai dengan 62
        if (substr($number, 0, 2) != '62') {
            $number = '62' . $number;
        }

        return $number;
    }

    /**
     * Get list of students for dropdown selection
     */
    public function getStudentList()
    {
        try {
            $spmbModel = new \App\Models\SpmbModel();

            // Get students with basic info for dropdown - use correct field names
            $students = $spmbModel->select('id_peserta, nama_peserta, no_pendaftaran, nomor_hp, tanggal_daftar')
                ->where('nama_peserta !=', '')
                ->orderBy('nama_peserta', 'ASC')
                ->findAll();

            return $this->response->setJSON([
                'success' => true,
                'students' => $students,
                'count' => count($students)
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error getting student list: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memuat daftar siswa: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get detailed student data by ID
     */
    public function getStudentData($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID siswa tidak ditemukan'
            ]);
        }

        try {
            $spmbModel = new \App\Models\SpmbModel();

            // Get student details - use correct field names
            $student = $spmbModel->select('id_peserta, nama_peserta, no_pendaftaran, nomor_hp, tanggal_daftar')
                ->where('id_peserta', $id)
                ->first();

            if (!$student) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data siswa tidak ditemukan'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'student' => $student
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error getting student data: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memuat data siswa: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get message templates
     */
    public function getTemplates()
    {
        try {
            $templateModel = new \App\Models\WaMessageTemplateModel();
            $templates = $templateModel->orderBy('created_at', 'DESC')->findAll();

            // Add debug logging
            log_message('info', 'Templates found: ' . count($templates));
            log_message('info', 'Templates data: ' . json_encode($templates));

            return $this->response->setJSON([
                'success' => true,
                'templates' => $templates
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error getting templates: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memuat template: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get template by ID
     */
    public function getTemplate($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID template tidak ditemukan'
            ]);
        }

        try {
            $templateModel = new \App\Models\WaMessageTemplateModel();
            $template = $templateModel->find($id);

            if (!$template) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Template tidak ditemukan'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'template' => $template
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error getting template: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memuat template: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Save or update template
     */
    public function saveTemplate()
    {
        $templateModel = new \App\Models\WaMessageTemplateModel();

        $data = [
            'template_name' => $this->request->getPost('template_name'),
            'template_type' => $this->request->getPost('template_type'),
            'subject' => $this->request->getPost('subject'),
            'message_template' => $this->request->getPost('message_template'),
            'status' => $this->request->getPost('status') ?: 'active'
        ];

        $id = $this->request->getPost('id');

        try {
            if ($id) {
                // Update existing template
                if ($templateModel->update($id, $data)) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Template berhasil diupdate'
                    ]);
                }
            } else {
                // Create new template
                if ($templateModel->insert($data)) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Template berhasil disimpan'
                    ]);
                }
            }

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menyimpan template',
                'errors' => $templateModel->errors()
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error saving template: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Delete template
     */
    public function deleteTemplate($id = null)
    {
        // Get ID from URL parameter or POST data
        if (!$id) {
            $id = $this->request->getPost('id');
        }

        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID template tidak ditemukan'
            ]);
        }

        try {
            $templateModel = new \App\Models\WaMessageTemplateModel();

            if ($templateModel->delete($id)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Template berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus template'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error deleting template: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Delete template (alternative method using POST)
     */
    public function deleteTemplatePost()
    {
        // Add debugging
        log_message('info', 'Delete template POST called');
        log_message('info', 'Request method: ' . $this->request->getMethod());
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'true' : 'false'));
        log_message('info', 'POST data: ' . json_encode($this->request->getPost()));

        if (!$this->request->isAJAX()) {
            log_message('error', 'Delete template: Not an AJAX request');
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Request tidak valid'
            ]);
        }

        $id = $this->request->getPost('id');
        log_message('info', 'Template ID to delete: ' . $id);

        if (!$id) {
            log_message('error', 'Delete template: No ID provided');
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID template tidak ditemukan'
            ]);
        }

        try {
            $templateModel = new \App\Models\WaMessageTemplateModel();

            // Check if template exists first
            $template = $templateModel->find($id);
            if (!$template) {
                log_message('error', 'Delete template: Template not found with ID ' . $id);
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Template tidak ditemukan'
                ]);
            }

            log_message('info', 'Template found: ' . json_encode($template));

            if ($templateModel->delete($id)) {
                log_message('info', 'Template deleted successfully: ID ' . $id);
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Template berhasil dihapus'
                ]);
            } else {
                log_message('error', 'Failed to delete template: ID ' . $id);
                log_message('error', 'Model errors: ' . json_encode($templateModel->errors()));
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus template'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error deleting template: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Preview template with sample data
     */
    public function previewTemplate()
    {
        $templateContent = $this->request->getPost('template_content');
        $templateType = $this->request->getPost('template_type') ?: 'registration';

        if (!$templateContent) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Template content tidak boleh kosong'
            ]);
        }

        try {
            $templateModel = new \App\Models\WaMessageTemplateModel();

            // Sample data for preview
            $sampleData = [
                'registration' => [
                    'nama' => 'Ahmad Fadli',
                    'no_pendaftaran' => '2025010001',
                    'tanggal_daftar' => date('d/m/Y'),
                    'nama_sekolah' => 'SD Negeri Krengseng 02',
                    'tahun_pelajaran' => '2025/2026',
                    'nomor_admin' => '0819-0395-2785'
                ],
                'general' => [
                    'nama' => 'Ahmad Fadli',
                    'nama_sekolah' => 'SD Negeri Krengseng 02',
                    'tanggal' => date('d/m/Y')
                ],
                'reminder' => [
                    'nama' => 'Ahmad Fadli',
                    'kegiatan' => 'Ujian Praktik',
                    'tanggal' => date('d/m/Y', strtotime('+7 days')),
                    'waktu' => '08:00 WIB',
                    'tempat' => 'Ruang Kelas 1A'
                ]
            ];

            $data = $sampleData[$templateType] ?? $sampleData['general'];
            $preview = $templateModel->replaceVariables($templateContent, $data);

            return $this->response->setJSON([
                'success' => true,
                'preview' => $preview,
                'sample_data' => $data
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error previewing template: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}
