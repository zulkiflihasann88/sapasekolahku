<?php

namespace App\Models;

use CodeIgniter\Model;

class AgamaModel extends Model
{
	protected $table                = 'db_agama';
	protected $primaryKey           = 'id_agama';
	protected $returnType           = 'object';
	protected $allowedFields        = ['id_agama', 'agama'];
	protected $useTimestamps		= false;
	protected $useSoftDeletes		= false;

	public function getAll()
	{
		$builder = $this->db->table('db_agama');
		$query = $builder->get();
		return $query->getResult();
	}
}
