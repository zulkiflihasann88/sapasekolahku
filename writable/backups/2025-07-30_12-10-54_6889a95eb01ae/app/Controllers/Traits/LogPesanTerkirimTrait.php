<?php
// c:\xampp\htdocs\sekolahku\app\Controllers\Traits\LogPesanTerkirimTrait.php

namespace App\Controllers\Traits;

use App\Models\PesanTerkirimModel;

trait LogPesanTerkirimTrait
{
    protected function logPesanTerkirim($tujuan, $pesan, $status, $response = null)
    {
        $model = new PesanTerkirimModel();
        $model->insert([
            'tujuan' => $tujuan,
            'pesan' => $pesan,
            'status' => $status,
            'response' => $response,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
