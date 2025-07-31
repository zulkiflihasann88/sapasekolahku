<?php

namespace App\Models;

use CodeIgniter\Model;

class WaliKelasModel extends Model
{
    protected $table = 'wali_kelas';
    protected $primaryKey = 'id_wali_kelas';
    protected $allowedFields = [
        'jenis_kelas',
        'tingkat_pendidikan',
        'kurikulum',
        'nama_rombel',
        'nama_wali',
        'ruang'
    ];
    protected $useTimestamps = false;
}
