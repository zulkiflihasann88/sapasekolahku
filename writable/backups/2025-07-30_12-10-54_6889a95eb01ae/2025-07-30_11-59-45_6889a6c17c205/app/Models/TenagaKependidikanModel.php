<?php

namespace App\Models;

use CodeIgniter\Model;

class TenagaKependidikanModel extends Model
{
    protected $table                = 'tenaga_kependidikan';
    protected $primaryKey           = 'id_tenaga_kependidikan';
    protected $returnType           = 'object';
    protected $allowedFields        = [
        'nama_lengkap',
        'nip',
        'nuptk',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'telepon',
        'email',
        'pendidikan_terakhir',
        'jabatan',
        'status_kepegawaian',
        'tmt_kerja',
        'foto'
    ];
    protected $useSoftDeletes       = false;
    protected $validationRules      = [
        'nama_lengkap' => 'required|max_length[255]',
        'jenis_kelamin' => 'required|in_list[L,P]',
        'tempat_lahir' => 'required|max_length[100]',
        'tanggal_lahir' => 'required|valid_date',
        'agama' => 'required|max_length[50]',
        'alamat' => 'required|max_length[500]',
        'jabatan' => 'required|max_length[100]',
        'status_kepegawaian' => 'required|max_length[50]',
        'email' => 'permit_empty|valid_email',
        'telepon' => 'permit_empty|max_length[15]'
    ];
    protected $validationMessages   = [
        'nama_lengkap' => [
            'required' => 'Nama lengkap harus diisi',
            'max_length' => 'Nama lengkap maksimal 255 karakter'
        ],
        'jenis_kelamin' => [
            'required' => 'Jenis kelamin harus dipilih',
            'in_list' => 'Jenis kelamin harus L atau P'
        ],
        'tempat_lahir' => [
            'required' => 'Tempat lahir harus diisi',
            'max_length' => 'Tempat lahir maksimal 100 karakter'
        ],
        'tanggal_lahir' => [
            'required' => 'Tanggal lahir harus diisi',
            'valid_date' => 'Format tanggal lahir tidak valid'
        ],
        'agama' => [
            'required' => 'Agama harus dipilih'
        ],
        'alamat' => [
            'required' => 'Alamat harus diisi',
            'max_length' => 'Alamat maksimal 500 karakter'
        ],
        'jabatan' => [
            'required' => 'Jabatan harus diisi'
        ],
        'status_kepegawaian' => [
            'required' => 'Status kepegawaian harus dipilih'
        ],
        'email' => [
            'valid_email' => 'Format email tidak valid'
        ]
    ];

    public function getAll()
    {
        $builder = $this->db->table('tenaga_kependidikan');
        $query = $builder->orderBy('nama_lengkap', 'ASC')->get();
        return $query->getResult();
    }

    public function getTenagaKependidikanByJabatan($jabatan = null)
    {
        $builder = $this->db->table('tenaga_kependidikan');
        if ($jabatan) {
            $builder->where('jabatan', $jabatan);
        }
        $query = $builder->orderBy('nama_lengkap', 'ASC')->get();
        return $query->getResult();
    }

    public function getStatistik()
    {
        $builder = $this->db->table('tenaga_kependidikan');

        // Total tenaga kependidikan
        $total = $builder->countAllResults();

        // Berdasarkan jenis kelamin
        $laki = $builder->where('jenis_kelamin', 'L')->countAllResults();
        $perempuan = $builder->where('jenis_kelamin', 'P')->countAllResults();

        // Berdasarkan status kepegawaian
        $pns = $builder->where('status_kepegawaian', 'PNS')->countAllResults();
        $honorer = $builder->where('status_kepegawaian', 'Honorer')->countAllResults();

        return [
            'total' => $total,
            'laki_laki' => $laki,
            'perempuan' => $perempuan,
            'pns' => $pns,
            'honorer' => $honorer
        ];
    }
}
