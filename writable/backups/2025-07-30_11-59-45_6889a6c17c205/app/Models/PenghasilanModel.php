<?php

namespace App\Models;

use CodeIgniter\Model;

class PenghasilanModel extends Model
{
protected $table            = 'db_penghasilan';
protected $primaryKey       = 'id_penghasilan';
protected $useAutoIncrement = true;
protected $returnType       = 'object';
protected $useSoftDeletes   = false;
protected $protectFields    = true;
protected $allowedFields    = ['nama_penghasilan'];
public function getAll()
{
	$builder = $this->db->table('db_penghasilan');
	$query = $builder->get();
	return $query->getResult();
}
}
