<?php

namespace App\Services;

use App\Models\WaGatewayModel;
use App\Models\PesanTerkirimModel;

class WhatsAppService
{
    private $waGatewayModel;
    private $pesanTerkirimModel;

    public function __construct()
    {
        $this->waGatewayModel = new WaGatewayModel();
        $this->pesanTerkirimModel = new PesanTerkirimModel();
    }

    /**
     * Check if WhatsApp Gateway is enabled
     */
    public function isEnabled(): bool
    {
        $config = $this->waGatewayModel->first();
        return $config && isset($config['status']) && ($config['status'] === 'active' || $config['status'] == 1 || $config['status'] === '1');
    }

    /**
     * Get WhatsApp Gateway configuration
     */
    public function getConfig(): ?array
    {
        return $this->waGatewayModel->first();
    }

    /**
     * Send registration notification to parent
     */
    public function sendRegistrationNotification(array $studentData): array
    {
        // Check if gateway is enabled
        if (!$this->isEnabled()) {
            return [
                'success' => false,
                'message' => 'WhatsApp Gateway tidak aktif'
            ];
        }

        // Get configuration
        $config = $this->getConfig();
        if (!$config) {
            return [
                'success' => false,
                'message' => 'Konfigurasi WhatsApp Gateway belum diatur'
            ];
        }

        $apikey = $config['apikey'] ?? $config['api_key'] ?? '';
        $device_id = $config['device_id'] ?? '';

        if (!$apikey || !$device_id) {
            return [
                'success' => false,
                'message' => 'API Key dan Sender Number belum dikonfigurasi'
            ];
        }

        // Extract required data
        $nama = $studentData['nama_lengkap'] ?? $studentData['nama'] ?? '';
        $no_pendaftaran = $studentData['no_pendaftaran'] ?? '';
        $nomor_wa = $studentData['nomor_hp'] ?? $studentData['nomor_wa_ayah'] ?? $studentData['nomor_wa'] ?? '';
        $tanggal_daftar = $studentData['tanggal_daftar'] ?? date('d/m/Y');

        if (!$nama || !$no_pendaftaran || !$nomor_wa) {
            return [
                'success' => false,
                'message' => 'Data siswa tidak lengkap (nama, nomor pendaftaran, atau nomor WhatsApp kosong)'
            ];
        }

        // Generate message from template
        $message = $this->generateRegistrationMessage($nama, $no_pendaftaran, $tanggal_daftar);

        // Format phone number
        $nomor_wa = $this->formatPhoneNumber($nomor_wa);

        // Send message via Wamoo API
        return $this->sendMessage($nomor_wa, $message, $apikey, $device_id);
    }

    /**
     * Generate registration notification message
     */
    private function generateRegistrationMessage(string $nama, string $no_pendaftaran, string $tanggal_daftar): string
    {
        // Get template from database
        $templateModel = new \App\Models\WaMessageTemplateModel();
        $template = $templateModel->getActiveTemplateByType('registration');

        if ($template) {
            // Use template from database
            $messageTemplate = $template['message_template'];
        } else {
            // Fallback to hardcoded template
            $messageTemplate = 'Halo, Orang Tua Murid! {nama},

Terimakasih! telah melakukan pendaftaran sebagai calon peserta didik baru di 
{nama_sekolah}
Tahun Pelajaran {tahun_pelajaran}.
Nomor Pendaftaran : {no_pendaftaran}
Nama                           : {nama}
Tanggal Daftar         : {tanggal_daftar}

Silakan pantau perkembangan registrasi ananda melalui link www.spmb.sdnkrengseng02.sch.id dengan mencari nama peserta didik.

Terima kasih.
Admin SPMB

Ini adalah pesan otomatis. mohon untuk tidak membalas.
Informasi lebih lanjut, silakan hubungi admin SPMB di nomor {nomor_admin} atau datang langsung ke sekolah.';
        }

        // Data untuk replace template variables
        $templateData = [
            'nama' => $nama,
            'no_pendaftaran' => $no_pendaftaran,
            'tanggal_daftar' => $tanggal_daftar,
            'nama_sekolah' => 'SD Negeri Krengseng 02',
            'tahun_pelajaran' => '2025/2026',
            'nomor_admin' => '0819-0395-2785'
        ];

        // Replace template variables dengan data aktual
        return $templateModel->replaceVariables($messageTemplate, $templateData);
    }

    /**
     * Send WhatsApp message via Wamoo API
     */
    private function sendMessage(string $nomor_wa, string $message, string $apikey, string $device_id): array
    {
        $url = 'https://wamoo.kimonet.my.id/send-message';
        $data = [
            'api_key' => $apikey,
            'sender' => $device_id,
            'number' => $nomor_wa,
            'message' => $message
        ];

        $headers = [
            'Content-Type: application/json'
        ];

        // Log request for debugging
        log_message('info', 'WhatsApp API Request - URL: ' . $url);
        log_message('info', 'WhatsApp API Request - Data: ' . json_encode($data));

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

        // Log response for debugging
        log_message('info', 'WhatsApp API Response - HTTP Code: ' . $httpcode);
        log_message('info', 'WhatsApp API Response - Body: ' . $result);
        if ($curlerr) {
            log_message('error', 'WhatsApp API cURL Error: ' . $curlerr);
        }

        // Log to database
        $statusLog = 'pending';
        if ($curlerr) {
            $statusLog = 'gagal';
        } elseif ($httpcode >= 200 && $httpcode < 300) {
            $responseArr = json_decode($result, true);
            if (isset($responseArr['status']) && $responseArr['status'] === true) {
                $statusLog = 'success';
            } elseif ($httpcode == 200) {
                $statusLog = 'success';
            }
        } else {
            $statusLog = 'gagal';
        }

        $logData = [
            'nomor_tujuan' => $nomor_wa,
            'tujuan' => $nomor_wa,
            'pesan' => $message,
            'status' => $statusLog,
            'response_api' => $curlerr ? $curlerr : $result,
            'response' => $curlerr ? $curlerr : $result,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        try {
            $this->pesanTerkirimModel->insert($logData);
        } catch (\Exception $e) {
            log_message('error', 'Failed to insert WA registration log: ' . $e->getMessage());
        }

        if ($curlerr) {
            return [
                'success' => false,
                'message' => 'Error koneksi: ' . $curlerr
            ];
        }

        if ($httpcode >= 400) {
            $responseArr = json_decode($result, true);
            $errorMsg = "HTTP Error $httpcode";

            if ($httpcode == 403) {
                $errorMsg = "Access Forbidden (403) - Periksa API Key dan Device ID";
            } elseif ($httpcode == 401) {
                $errorMsg = "Unauthorized (401) - API Key tidak valid";
            } elseif ($httpcode == 404) {
                $errorMsg = "Not Found (404) - Endpoint tidak ditemukan";
            }

            return [
                'success' => false,
                'message' => $errorMsg . ": " . ($responseArr['msg'] ?? $result),
                'debug' => [
                    'http_code' => $httpcode,
                    'response' => $result,
                    'api_key_length' => strlen($apikey),
                    'device_id' => $device_id
                ]
            ];
        }

        return [
            'success' => true,
            'message' => 'Notifikasi pendaftaran berhasil dikirim ke ' . $nomor_wa,
            'data' => [
                'nomor_wa' => $nomor_wa,
                'status' => $statusLog,
                'response' => $result
            ]
        ];
    }

    /**
     * Format phone number to international format
     */
    private function formatPhoneNumber(string $number): string
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
}
