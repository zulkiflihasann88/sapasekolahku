<?php

namespace App\Models;

use CodeIgniter\Model;

class KepalasekolahModel extends Model
{
	protected $table                = 'db_kepalasekolah';
	protected $primaryKey           = 'id_kepalasekolah';
	protected $returnType           = 'object';
	protected $allowedFields        = ['nama', 'nip', 'status', 'id_tahun_ajaran', 'aktivasi', 'tahun'];
	protected $useTimestamps		= false;
	protected $useSoftDeletes		= false;

	public function getAll()
	{
		$builder = $this->db->table('db_kepalasekolah');
		$builder->join('db_tahunajaran', 'db_tahunajaran.id_tahun_ajaran = db_kepalasekolah.id_tahun_ajaran', 'left');
		$query = $builder->get();
		return $query->getResult();
	}
}
