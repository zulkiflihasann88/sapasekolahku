<?php
namespace App\Models;

use CodeIgniter\Model;

class KelompokModel extends Model
{
    protected $table      = 'kelompok_project';
    protected $primaryKey = 'id_kelompok_project';
    protected $allowedFields = ['nama_kelompok', 'tingkat', 'fase', 'koordinator'];
}