<?php

namespace App\Models;

use CodeIgniter\Model;

class PendidikanModel extends Model
{
	protected $table            = 'db_pendidikan';
	protected $primaryKey       = 'id_pendidikan';
	protected $useAutoIncrement = true;
	protected $returnType       = 'object';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = ['id_pendidikan', 'pendidikan'];


	public function getAll()
	{
		$builder = $this->db->table('db_pendidikan');
		$query = $builder->get();
		return $query->getResult();
	}
}
