<?php

namespace App\Models;

use CodeIgniter\Model;

class TpenerimaanModel extends Model
{
	protected $table            = 'db_tpenerimaan';
	protected $primaryKey       = 'id_tahun';
	protected $allowedFields    = ['id_tahun', 'tahun_pelajaran', 'kuota', 'tanggal_mulai_pendaftaran', 'tanggal_selesai_pendaftaran', 'tanggal_mulai_seleksi', 'tanggal_selesai_seleksi', 'tanggal_pengumuman', 'tanggal_mulai_daftar_ulang', 'tanggal_selesai_daftar_ulang', 'status_tahun'];
	protected $useAutoIncrement = true;
	protected $returnType       = 'object';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;

	public function getAll()
	{
		$builder = $this->db->table('db_tpenerimaan');
		$query = $builder->get();
		return $query->getResult();
	}

}
