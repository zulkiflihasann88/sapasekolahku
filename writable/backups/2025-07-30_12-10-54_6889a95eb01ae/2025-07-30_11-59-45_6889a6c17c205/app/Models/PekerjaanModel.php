<?php

namespace App\Models;

use CodeIgniter\Model;

class PekerjaanModel extends Model
{
	protected $table            = 'db_pekerjaan';
	protected $primaryKey       = 'id_pekerjaan';
	protected $useAutoIncrement = true;
	protected $returnType       = 'object';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = ['nama_pekerjaan'];
	public function getAll()
	{
		$builder = $this->db->table('db_pekerjaan');
		$query = $builder->get();
		return $query->getResult();
	}
}
