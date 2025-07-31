<?php

namespace App\Controllers;

class Profile extends BaseController
{
	protected $sekolah;

	function __construct()
	{
		$this->sekolah = model('LembagaModel');
		helper('tahun_ajaran'); // Load helper tahun ajaran
	}
	public function index()
	{
		// Ambil statistik dinamis berdasarkan tahun ajaran yang sedang dilihat
		$currentTahunAjaranId = getCurrentTahunAjaran();
		$tahunAjaranInfo = getViewingTahunAjaranInfo();

		$db = db_connect();

		// Dapatkan field name yang tepat untuk tabel siswa
		$siswaFieldName = getTahunAjaranFieldName('db_siswa');

		// Hitung siswa aktif berdasarkan tahun ajaran (langsung dari tabel siswa)
		$totalSiswa = $db->query("
			SELECT COUNT(*) AS jml 
			FROM db_siswa s
			WHERE s.$siswaFieldName = ? 
			AND s.id_siswa NOT IN (SELECT id_siswa FROM db_mutasi)
		", [$currentTahunAjaranId])->getRow('jml');

		// Total tenaga pengajar
		$totalPengajar = $db->table('db_pendidik')->countAllResults();

		$data = [
			'tahun_ajaran_info' => $tahunAjaranInfo,
			'total_siswa' => $totalSiswa,
			'total_pengajar' => $totalPengajar
		];

		return view('profile/index', $data);
	}

	public function getData($id = null)
	{
		if ($id != null) {
			$sekolah = $this->sekolah->find($id);
			if ($sekolah) {
				return $this->response->setJSON($sekolah);
			} else {
				return $this->response->setStatusCode(404, 'Data not found');
			}
		} else {
			return $this->response->setStatusCode(400, 'Invalid ID');
		}
	}
}
