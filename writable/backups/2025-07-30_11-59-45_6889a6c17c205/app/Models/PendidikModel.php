<?php

namespace App\Models;

use CodeIgniter\Model;

class PendidikModel extends Model
{
	protected $table                = 'db_pendidik';
	protected $primaryKey           = 'id_pendidik';
	protected $returnType           = 'object';
	protected $allowedFields        = ['nama', 'nip', 'nuptk', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'nik', 'email', 'status','jenis_pegawai', 'jenis_ptk','pendidikan_akhir'];
	protected $useTimestamps		= false;
	protected $useSoftDeletes		= false;

	public function getAll()
	{
		$builder = $this->db->table('db_pendidik');
		$query = $builder->get();
		return $query->getResult();
	}
}
