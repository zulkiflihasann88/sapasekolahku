<?php

namespace App\Models;

use CodeIgniter\Model;

class TinggalModel extends Model
{
	protected $table            = 'db_tempat_tinggal';
	protected $primaryKey       = 'id_tempat_tinggal';
	protected $useAutoIncrement = true;
	protected $returnType       = 'object';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = ['tempat_tinggal'];
	public function getAll()
	{
		$builder = $this->db->table('db_tempat_tinggal');
		$query = $builder->get();
		return $query->getResult();
	}
}
