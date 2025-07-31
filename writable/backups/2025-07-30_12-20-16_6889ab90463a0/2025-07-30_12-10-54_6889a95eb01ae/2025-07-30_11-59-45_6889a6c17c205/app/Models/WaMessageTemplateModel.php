<?php

namespace App\Models;

use CodeIgniter\Model;

class WaMessageTemplateModel extends Model
{
    protected $table = 'wa_message_templates';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'template_name',
        'template_type',
        'subject',
        'message_template',
        'variables',
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'template_name' => 'required|min_length[3]|max_length[100]',
        'template_type' => 'required|in_list[registration,general,reminder]',
        'message_template' => 'required|min_length[10]',
        'status' => 'required|in_list[active,inactive]'
    ];

    protected $validationMessages = [
        'template_name' => [
            'required' => 'Nama template harus diisi',
            'min_length' => 'Nama template minimal 3 karakter',
            'max_length' => 'Nama template maksimal 100 karakter'
        ],
        'template_type' => [
            'required' => 'Tipe template harus dipilih',
            'in_list' => 'Tipe template tidak valid'
        ],
        'message_template' => [
            'required' => 'Template pesan harus diisi',
            'min_length' => 'Template pesan minimal 10 karakter'
        ],
        'status' => [
            'required' => 'Status harus dipilih',
            'in_list' => 'Status tidak valid'
        ]
    ];

    /**
     * Get active template by type
     */
    public function getActiveTemplateByType(string $type): ?array
    {
        return $this->where([
            'template_type' => $type,
            'status' => 'active'
        ])->first();
    }

    /**
     * Get all templates by type
     */
    public function getTemplatesByType(string $type): array
    {
        return $this->where('template_type', $type)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get available variables for template
     */
    public function getAvailableVariables(string $type): array
    {
        $defaultVariables = [
            'registration' => [
                'nama' => 'Nama siswa',
                'no_pendaftaran' => 'Nomor pendaftaran',
                'tanggal_daftar' => 'Tanggal pendaftaran',
                'nama_sekolah' => 'Nama sekolah',
                'tahun_pelajaran' => 'Tahun pelajaran',
                'nomor_admin' => 'Nomor HP admin'
            ],
            'general' => [
                'nama' => 'Nama penerima',
                'nama_sekolah' => 'Nama sekolah',
                'tanggal' => 'Tanggal'
            ],
            'reminder' => [
                'nama' => 'Nama siswa',
                'kegiatan' => 'Nama kegiatan',
                'tanggal' => 'Tanggal kegiatan',
                'waktu' => 'Waktu kegiatan',
                'tempat' => 'Tempat kegiatan'
            ]
        ];

        return $defaultVariables[$type] ?? [];
    }

    /**
     * Replace template variables with actual data
     */
    public function replaceVariables(string $template, array $data): string
    {
        $message = $template;

        foreach ($data as $key => $value) {
            $message = str_replace('{' . $key . '}', $value, $message);
        }

        return $message;
    }
}
