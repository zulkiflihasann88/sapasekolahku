<?php
// c:\xampp\htdocs\sekolahku\app\Models\PesanTerkirimModel.php

namespace App\Models;

use CodeIgniter\Model;

class PesanTerkirimModel extends Model
{
    protected $table = 'pesan_terkirim';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nomor_tujuan',
        'tujuan',
        'pesan',
        'status',
        'response_api',
        'response',
        'created_at'
    ];
    protected $useTimestamps = false;
}
