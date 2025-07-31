<?php

namespace App\Models;

use CodeIgniter\Model;

class DisabilityModel extends Model
{
	protected $table            = 'db_disability';
	protected $primaryKey       = 'id_disability';
	protected $useAutoIncrement = true;
	protected $returnType       = 'object';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = ['id_disability', 'jenis_disability'];
	public function getAll()
	{
		$builder = $this->db->table('db_disability');
		$query = $builder->get();
		return $query->getResult();
	}
}
