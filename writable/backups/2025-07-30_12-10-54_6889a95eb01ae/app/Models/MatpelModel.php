<?php

namespace App\Models;

use CodeIgniter\Model;

class MatpelModel extends Model
{
	protected $table                = 'db_matpel';
	protected $primaryKey           = 'id_pelajaran';
	protected $returnType           = 'object';
	protected $allowedFields        = ['id_pelajaran', 'kode_mapel', 'nama_mapel', 'kelompok', 'singkatan'];
	protected $useTimestamps		= true;
	protected $useSoftDeletes		= false;
	protected $validationRules 		= [];

	public function getAll()
	{
		$builder = $this->db->table('db_matpel');
		$query = $builder->get();
		return $query->getResult();
	}
}
