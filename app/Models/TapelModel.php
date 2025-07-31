<?php

namespace App\Models;

use CodeIgniter\Model;
use PhpParser\Node\Expr\AssignOp\ShiftLeft;

class TapelModel extends Model
{
	protected $table                = 'db_tahunajaran';
	protected $primaryKey           = 'id_tahun_ajaran';
	protected $returnType           = 'object';
	protected $allowedFields        = ['tahun', 'ket_tahun', 'status', 'id_kepalasekolah', 'semester'];
	protected $useTimestamps		= false;
	protected $useSoftDeletes		= false;

	function getAll()
	{
		$builder = $this->db->table('db_tahunajaran');
		$builder->select('db_tahunajaran.*, db_kepalasekolah.nama, db_kepalasekolah.nip');
		$builder->join('db_kepalasekolah', 'db_kepalasekolah.id_kepalasekolah = db_tahunajaran.id_kepalasekolah', 'Left');
		// Urutkan status Aktif paling atas, lalu tahun terbaru
		$builder->orderBy("FIELD(db_tahunajaran.status, 'Aktif')");
		$builder->orderBy('tahun', 'DESC');
		$query = $builder->get();
		return $query->getResult();
	}
	// Ambil tahun ajaran aktif terbaru
	function getActiveLatest()
	{
		$builder = $this->db->table('db_tahunajaran');
		$builder->where('status', 'Aktif');
		$builder->orderBy('tahun', 'DESC');
		$builder->limit(1);
		$query = $builder->get();
		return $query->getRow();
	}
}
