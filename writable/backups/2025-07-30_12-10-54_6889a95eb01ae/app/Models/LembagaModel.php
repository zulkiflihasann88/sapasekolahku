<?php

namespace App\Models;

use CodeIgniter\Model;

class LembagaModel extends Model
{
	protected $table                = 'sekolah';
	protected $primaryKey           = 'id_sekolah';
	protected $returnType           = 'object';
	protected $allowedFields        = ['nama_sekolah', 'alamat', 'telp', 'email', 'website', 'logo'];
	protected $useSoftDeletes		= false;

	public function getAll()
	{
		$builder = $this->db->table('sekolah');
		$query = $builder->get();
		return $query->getResult();
	}
}
