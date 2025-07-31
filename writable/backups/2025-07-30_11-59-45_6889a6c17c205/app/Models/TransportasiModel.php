<?php

namespace App\Models;

use CodeIgniter\Model;

class TransportasiModel extends Model
{
	protected $table            = 'db_transportasi';
	protected $primaryKey       = 'id_transportasi';
	protected $useAutoIncrement = true;
	protected $returnType       = 'object';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = ['id_transportasi', 'moda_transportasi'];
	public function getAll()
	{
		$builder = $this->db->table('db_transportasi');
		$query = $builder->get();
		return $query->getResult();
	}
}
