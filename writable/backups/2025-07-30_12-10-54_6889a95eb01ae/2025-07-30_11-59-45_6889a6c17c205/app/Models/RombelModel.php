<?php

namespace App\Models;

use CodeIgniter\Model;

class RombelModel extends Model
{
	protected $table            = 'db_rombel';
	protected $primaryKey       = 'id_rombel';
	protected $useAutoIncrement = true;
	protected $returnType       = 'object';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = ['id_rombel', 'kelas', 'siswa', 'wali_kelas', 'rombel', 'id_tahun'];

	// Adding timestamps
	protected $useTimestamps = true;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';

	/**
	 * Override insert agar id_tahun otomatis dari session jika belum diisi
	 */
	public function insert($data = null, bool $returnID = true)
	{
		if (is_array($data) && !isset($data['id_tahun'])) {
			$id_tahun_ajaran = getCurrentTahunAjaran();
			if ($id_tahun_ajaran) {
				$data['id_tahun'] = $id_tahun_ajaran;
			}
		}
		return parent::insert($data, $returnID);
	}

	/**
	 * Override update agar id_tahun otomatis dari session jika belum diisi
	 */
	public function update($id = null, $data = null): bool
	{
		if (is_array($data) && !isset($data['id_tahun'])) {
			$id_tahun_ajaran = getCurrentTahunAjaran();
			if ($id_tahun_ajaran) {
				$data['id_tahun'] = $id_tahun_ajaran;
			}
		}
		return parent::update($id, $data);
	}

	public function getAll()
	{
		$builder = $this->db->table($this->table);
		$builder->select('db_rombel.*, db_tahunajaran.ket_tahun, db_pendidik.nama, COUNT(db_siswa.id_siswa) as jumlah_siswa');
		$builder->join('db_tahunajaran', 'db_rombel.id_tahun = db_tahunajaran.id_tahun_ajaran', 'left');
		$builder->join('db_pendidik', 'db_rombel.wali_kelas = db_pendidik.id_pendidik', 'left');
		$builder->join('db_siswa', 'db_rombel.id_rombel = db_siswa.id_rombel', 'left');

		// Gunakan helper untuk mendapatkan tahun ajaran yang tepat
		$id_tahun_ajaran = getCurrentTahunAjaran();
		if ($id_tahun_ajaran) {
			$builder->where('db_rombel.id_tahun', $id_tahun_ajaran);
		}
		$builder->groupBy('db_rombel.id_rombel');
		$query = $builder->get();
		return $query->getResult();
	}
}
