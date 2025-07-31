<?php

namespace App\Controllers;

use App\Models\TpenerimaanModel;
use App\Models\KeluarModel;
use App\Services\SemesterService;

class Home extends BaseController
{
	protected $semesterService;

	public function __construct()
	{
		$this->semesterService = new SemesterService();
		helper('tahun_ajaran'); // Load helper tahun ajaran
	}

	public function index()
	{
		// Halaman Home
		return view('home');
	}
	public function dashboard()
	{
		// Ambil ID tahun ajaran yang sedang dilihat
		// Ambil tahun ajaran & semester dari session hasil dropdown login
		$currentTahunAjaranId = (int) session('tahun_ajaran_aktif');
		$currentSemester = session('semester_aktif');
		$tahunAjaranInfo = getViewingTahunAjaranInfo();

		// Hitung statistik berdasarkan tahun ajaran yang sedang dilihat
		$db = db_connect();

		// Dapatkan field name yang tepat untuk tabel siswa dan rombel
		$siswaFieldName = getTahunAjaranFieldName('db_siswa');
		$rombelFieldName = getTahunAjaranFieldName('db_rombel');

		$siswaAktifRow = $db->query(
			"SELECT COUNT(*) AS jml FROM db_siswa_semester_history WHERE id_tahun_ajaran = ? AND semester = ? AND status_siswa = 'aktif' AND id_siswa NOT IN (SELECT id_siswa FROM db_mutasi)",
			[$currentTahunAjaranId, $currentSemester]
		)->getRow();
		$siswaAktif = $siswaAktifRow ? (int)$siswaAktifRow->jml : 0;

		// PTK/GTK (tidak tergantung tahun ajaran, tetap menggunakan total)
		$totalPtk = $db->table('db_pendidik')->countAllResults();

		// Mata pelajaran (tidak tergantung tahun ajaran, tetap menggunakan total)
		$totalMapel = $db->table('db_matpel')->countAllResults();

		// Data untuk chart berdasarkan tahun ajaran
		$chartData = $this->getChartDataByTahunAjaran();

		// Halaman Dashboard
		$data = [
			'viewing_tahun_ajaran' => $this->semesterService->getViewingTahunAjaran(),
			'current_semester' => $this->semesterService->getCurrentActiveSemester(),
			'tahun_ajaran_info' => $tahunAjaranInfo,
			'siswa_aktif' => $siswaAktif,
			'total_ptk' => $totalPtk,
			'total_mapel' => $totalMapel,
			'chart_data' => $chartData
		];

		return view('dashboard', $data);
	}

	/**
	 * Ambil data chart berdasarkan tahun ajaran
	 */
	private function getChartDataByTahunAjaran()
	{
		$db = db_connect();
		$tahunAjaranId = (int) session('tahun_ajaran_aktif');
		$semester = session('semester_aktif');

		// Dapatkan field name yang tepat untuk tabel siswa dan rombel
		$siswaFieldName = getTahunAjaranFieldName('db_siswa');
		$rombelFieldName = getTahunAjaranFieldName('db_rombel');

		// Ambil daftar rombel pada tahun ajaran yang sedang dilihat
		$kelasList = $db->table('db_rombel')
			->select('id_rombel, kelas, rombel')
			->where($rombelFieldName, $tahunAjaranId)
			->orderBy('kelas', 'ASC')
			->orderBy('rombel', 'ASC')
			->get()->getResult();

		$categories = [];
		$dataLaki = [];
		$dataPerempuan = [];

		foreach ($kelasList as $rowKelas) {
			$id_rombel = $rowKelas->id_rombel;
			$nama_kelas = $rowKelas->kelas . ' - ' . $rowKelas->rombel;
			$categories[] = $nama_kelas;

			// Hitung siswa laki-laki di rombel ini (filter tahun ajaran dan tidak mutasi)
			$dataLaki[] = $db->table('db_siswa')
				->where('id_rombel', $id_rombel)
				->where($siswaFieldName, $tahunAjaranId)
				->where('jk', 'L')
				->where('id_siswa NOT IN (SELECT id_siswa FROM db_mutasi)')
				->countAllResults();

			// Hitung siswa perempuan di rombel ini (filter tahun ajaran dan tidak mutasi)
			$dataPerempuan[] = $db->table('db_siswa')
				->where('id_rombel', $id_rombel)
				->where($siswaFieldName, $tahunAjaranId)
				->where('jk', 'P')
				->where('id_siswa NOT IN (SELECT id_siswa FROM db_mutasi)')
				->countAllResults();
		}

		return [
			'categories' => $categories,
			'data_laki' => $dataLaki,
			'data_perempuan' => $dataPerempuan
		];
	}

	public function generate()
	{
		// echo password_hash('12345', PASSWORD_BCRYPT);
	}
}
