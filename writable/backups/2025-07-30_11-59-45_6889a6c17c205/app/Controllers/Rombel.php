<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;


class Rombel extends ResourceController
{
	function __construct()
	{
		$this->rombel = model('RombelModel');
		$this->tapel = model('TapelModel');
	}

	public function index()
	{
		// helper('custom');

		$data['rombel'] = $this->rombel->getAll();
		$data['tapel'] = $this->tapel->getAll();
		// Ambil data pendidik untuk wali kelas
		$pendidikModel = new \App\Models\PendidikModel();
		$data['pendidik'] = $pendidikModel->getAll();

		// Ambil semua id_siswa yang sudah mutasi
		$mutasiIds = \Config\Database::connect()->table('db_mutasi')->select('id_siswa')->get()->getResultArray();
		$excludeIds = array_column($mutasiIds, 'id_siswa');

		// Ambil data siswa per kelas, exclude siswa mutasi
		$siswaModel = new \App\Models\SiswaModel();
		$siswa_per_kelas = [];
		$rekap_per_kelas = [];
		foreach ($data['rombel'] as $r) {
			$siswa_list = $siswaModel->getSiswaByKelas($r->id_rombel, $excludeIds);
			if (!empty($siswa_list)) {
				usort($siswa_list, function($a, $b) {
					return strcmp(strtolower($a->nama_siswa), strtolower($b->nama_siswa));
				});
			}
			$siswa_per_kelas[$r->id_rombel] = $siswa_list;
			$laki = 0;
			$perempuan = 0;
			foreach ($siswa_list as $s) {
				if (isset($s->jk)) {
					$jk = strtolower(trim($s->jk));
					if ($jk == 'laki-laki' || $jk == 'l') $laki++;
					if ($jk == 'perempuan' || $jk == 'p') $perempuan++;
				}
			}
			$rekap_per_kelas[$r->id_rombel] = [
				'laki' => $laki,
				'perempuan' => $perempuan,
				'total' => count($siswa_list),
				'wali_kelas' => isset($r->wali_kelas) ? $r->wali_kelas : ''
			];
		}
		// Untuk tabel siswa: hanya tampilkan siswa aktif (tidak mutasi)
		$data['siswa_aktif'] = [];
		foreach ($siswa_per_kelas as $id_rombel => $list) {
			foreach ($list as $siswa) {
				$data['siswa_aktif'][] = $siswa;
			}
		}
		$data['siswa_per_kelas'] = $siswa_per_kelas;
		$data['rekap_per_kelas'] = $rekap_per_kelas;

		return view('rombongan belajar/index', $data);
	}

	/**
	 * Process the creation/insertion of a new resource object.
	 * This should be a POST.
	 *
	 * @return mixed
	 */
	public function create()
	{
		$data = $this->request->getPost();
		// Validasi id_tahun harus terisi
		if (empty($data['id_tahun'])) {
			return redirect()->back()->withInput()->with('error', 'Tahun pelajaran wajib dipilih!');
		}
		// Pastikan field kelas diisi dengan format "Kelas 1" dst
		if (isset($data['kelas_tingkat'])) {
			$angka = (int)$data['kelas_tingkat'];
			if ($angka >= 1 && $angka <= 6) {
				$data['kelas'] = 'Kelas ' . $angka;
			} else {
				$data['kelas'] = $data['kelas_tingkat'];
			}
		}
		// Hitung jumlah siswa untuk rombel ini (jika id_rombel sudah diketahui setelah insert, update lagi)
		$insertId = $this->rombel->insert($data, true); // true agar dapatkan insert id
		// Jika insert sukses dan id_rombel tersedia, update field siswa (hanya siswa aktif, exclude mutasi)
		if ($insertId) {
			$siswaModel = new \App\Models\SiswaModel();
			$mutasiIds = \Config\Database::connect()->table('db_mutasi')->select('id_siswa')->get()->getResultArray();
			$excludeIds = array_column($mutasiIds, 'id_siswa');
			$jumlahSiswa = $siswaModel->where('id_rombel', $insertId)
				->whereNotIn('id_siswa', $excludeIds)
				->countAllResults();
			$this->rombel->update($insertId, ['siswa' => $jumlahSiswa]);
		}
		return redirect()->to('rombongan_belajar')->with('success', 'Data Berhasil Disimpan');
	}

	public function edit($id = null)
	{
		$rombel = $this->model->where('id_pelajaran', $id)->first();
		if (is_object($rombel)) {
			$data['rombel'] = $rombel;
			return view('rombongan_belajar/edit', $data);
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}
	public function update($id = null)
	{
		$data = $this->request->getPost();
		// Pastikan field kelas diisi dengan format "Kelas 1" dst jika update dari kelas_tingkat
		if (isset($data['kelas_tingkat'])) {
			$angka = (int)$data['kelas_tingkat'];
			if ($angka >= 1 && $angka <= 6) {
				$data['kelas'] = 'Kelas ' . $angka;
			} else {
				$data['kelas'] = $data['kelas_tingkat'];
			}
		}
		$save = $this->rombel->update($id, $data);
		// Update jumlah siswa setelah edit, pastikan field di database adalah 'siswa' atau 'jumlah_siswa'
		$siswaModel = new \App\Models\SiswaModel();
		$mutasiIds = \Config\Database::connect()->table('db_mutasi')->select('id_siswa')->get()->getResultArray();
		$excludeIds = array_column($mutasiIds, 'id_siswa');
		$jumlahSiswa = $siswaModel->where('id_rombel', $id)
			->whereNotIn('id_siswa', $excludeIds)
			->countAllResults();
		// Cek field mana yang ada di database
		$db = \Config\Database::connect();
		$fields = $db->getFieldNames('db_rombel');
		if (in_array('jumlah_siswa', $fields)) {
			$this->rombel->update($id, ['jumlah_siswa' => $jumlahSiswa]);
		} else if (in_array('siswa', $fields)) {
			$this->rombel->update($id, ['siswa' => $jumlahSiswa]);
		}
		if (!$save) {
			return redirect()->back()->withInput()->with('errors', $this->rombel->errors());
		} else {
			return redirect()->to(site_url('rombongan_belajar'))->with('success', 'Data Berhasil Diupdate');
		}
	}

	public function delete($id = null)
	{
		// Set id_rombel siswa yang terkait menjadi NULL sebelum hapus rombel
		$db = \Config\Database::connect();
		$db->table('db_siswa')->where('id_rombel', $id)->update(['id_rombel' => null]);
		$this->rombel->delete($id);
		return redirect('rombongan_belajar')->with('success', 'Data Berhasil Dihapus');
	}
}
