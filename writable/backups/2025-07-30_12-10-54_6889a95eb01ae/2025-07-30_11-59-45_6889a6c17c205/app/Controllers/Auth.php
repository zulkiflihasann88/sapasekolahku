<?php

namespace App\Controllers;

class Auth extends BaseController
{
	public function index()
	{
		return redirect()->to(site_url('login'));
	}

	public function login()
	{
		if (session('id_user')) {
			return redirect()->to(site_url('dashboard'));
		}
		// Cek jika ada parameter tipe=admin/guru di URL
		$tipe = $this->request->getGet('tipe');
		// Ambil semua tahun ajaran untuk dropdown
		$tapelModel = new \App\Models\TapelModel();
		$tahunAjaranList = $tapelModel->findAll();
		$data = ['tahunAjaranList' => $tahunAjaranList];
		if ($tipe === 'guru') {
			return view('auth/login_guru', $data);
		}
		return view('auth/login', $data);
	}

	public function loginProcess()
	{
		$session = session();
		$post = $this->request->getPost();

		// Validasi username dan password (hanya username)
		$db = \Config\Database::connect();
		$user = $db->table('users')->where('username', $post['username'])->get()->getRow();
		$tipe_pengguna = $post['tipe_pengguna'] ?? '';
		// Jika gagal login dan tipe pengguna guru_kelas, redirect ke login_guru
		if (!$user) {
			if ($tipe_pengguna === 'guru_kelas') {
				return redirect()->to(site_url('login_guru'))->with('error', 'Username tidak ditemukan.');
			}
			return redirect()->back()->with('error', 'Username tidak ditemukan.');
		}

		if (!password_verify($post['password'], $user->password_user)) {
			if ($tipe_pengguna === 'guru_kelas') {
				return redirect()->to(site_url('login_guru'))->with('error', 'Password salah atau tidak sesuai dengan database.');
			}
			return redirect()->back()->with('error', 'Password salah atau tidak sesuai dengan database.');
		}

		// Jika valid, set session dan arahkan ke dashboard

		// Ambil tahun ajaran dari input user (select login)
		$tapelModel = new \App\Models\TapelModel();
		$id_tapel = $post['tapel'] ?? null;
		$tapelDipilih = $id_tapel ? $tapelModel->find($id_tapel) : null;
		if (!$tapelDipilih) {
			return redirect()->back()->with('error', 'Tahun ajaran tidak ditemukan atau belum dipilih. Silakan pilih tahun ajaran yang benar.');
		}

		$tipe_pengguna = $post['tipe_pengguna'] ?? '';
		// Kompatibilitas: cek apakah field id_tahun_ajaran
		$id_tahunajaran_aktif = null;
		// Cek semua kemungkinan nama field, gunakan get_object_vars agar tidak error
		// Cek apakah $tapelDipilih benar-benar object dan properti yang diakses ada
		$id_tahunajaran_aktif = null;
		if (is_object($tapelDipilih)) {
			// Try both possible column names for maximum compatibility
			if (property_exists($tapelDipilih, 'id_tahunajaran') && !empty($tapelDipilih->id_tahunajaran)) {
				$id_tahunajaran_aktif = $tapelDipilih->id_tahunajaran;
			} elseif (property_exists($tapelDipilih, 'id_tahun_ajaran') && !empty($tapelDipilih->id_tahun_ajaran)) {
				$id_tahunajaran_aktif = $tapelDipilih->id_tahun_ajaran;
			} elseif (property_exists($tapelDipilih, 'id_tapel') && !empty($tapelDipilih->id_tapel)) {
				$id_tahunajaran_aktif = $tapelDipilih->id_tapel;
			} elseif (property_exists($tapelDipilih, 'id') && !empty($tapelDipilih->id)) {
				$id_tahunajaran_aktif = $tapelDipilih->id;
			} else {
				// Log all available properties for debugging
				$available_props = array_keys(get_object_vars($tapelDipilih));
				log_message('error', 'Available properties in TapelModel: ' . implode(', ', $available_props));
				log_message('error', 'Full object dump: ' . print_r($tapelDipilih, true));
				return redirect()->back()->with('error', 'Data tahun ajaran tidak valid. Silakan hubungi admin.');
			}
		} else {
			return redirect()->back()->with('error', 'Data tahun ajaran tidak valid. Silakan hubungi admin.');
		}
		$sessionData = [
			'id_user' => $user->id_user,
			'username' => $user->username,
			'logged_in' => true,
			'tipe_pengguna' => $tipe_pengguna,
			// Hanya gunakan id_tahunajaran_aktif sebagai tahun_ajaran_aktif
			'tahun_ajaran_aktif' => $id_tahunajaran_aktif,
			'id_tahunajaran_aktif' => $id_tahunajaran_aktif,
			'ket_tahun' => $tapelDipilih ? ($tapelDipilih->ket_tahun ?? null) : null,
			'semester_aktif' => ($tapelDipilih && isset($tapelDipilih->semester)) ?
				(is_numeric($tapelDipilih->semester) ? (int)$tapelDipilih->semester : (strtolower($tapelDipilih->semester) == 'genap' ? 2 : 1))
				: null,
			'id_tahun_ajaran_view' => $id_tahunajaran_aktif
		];
		// Set role guru jika tipe_pengguna guru_kelas atau guru_mapel
		if ($tipe_pengguna === 'guru_kelas' || $tipe_pengguna === 'guru_mapel') {
			$sessionData['role'] = 'guru';
		} else {
			// Ambil role dari database jika ada (untuk admin/operator)
			if (isset($user->role) && $user->role) {
				$sessionData['role'] = $user->role;
			} else {
				$sessionData['role'] = 'admin'; // fallback default
			}
		}
		$session->set($sessionData);

		// Redirect ke dashboard guru setelah login
		if ($tipe_pengguna === 'guru_kelas' || $tipe_pengguna === 'guru_mapel') {
			// --- AUTO BACKUP/MIGRASI DATA SISWA KE db_siswa_semester_history ---
			$db = \Config\Database::connect();
			$id_tahunajaran = $id_tahunajaran_aktif;
			// Pastikan semester berupa angka (1=Ganjil, 2=Genap)
			$semester = ($tapelDipilih && isset($tapelDipilih->semester)) ?
				(is_numeric($tapelDipilih->semester) ? (int)$tapelDipilih->semester : (strtolower($tapelDipilih->semester) == 'genap' ? 2 : 1))
				: null;
			if ($id_tahunajaran && $semester) {
				// Ambil semua siswa dari db_siswa
				$siswaList = $db->table('db_siswa')->get()->getResult();
				foreach ($siswaList as $siswa) {
					// Cek apakah sudah ada data untuk kombinasi siswa, tahun ajaran, semester
					$cek = $db->table('db_siswa_semester_history')
						->where('id_siswa', $siswa->id_siswa)
						->where('id_tahun_ajaran', $id_tahunajaran)
						->where('semester', $semester)
						->countAllResults();
					if ($cek == 0) {
						$dataInsert = [
							'id_siswa' => $siswa->id_siswa,
							'id_rombel' => $siswa->id_rombel ?? null,
							'id_tahun_ajaran' => $id_tahunajaran,
							'semester' => $semester,
							'status_siswa' => 'aktif',
							'tanggal_snapshot' => date('Y-m-d'),
							'created_at' => date('Y-m-d H:i:s')
						];
						$db->table('db_siswa_semester_history')->insert($dataInsert);
					}
				}
			}
			// --- END AUTO BACKUP/MIGRASI ---
			return redirect()->to(site_url('rapor/dashboard'));
		} else {
			// --- AUTO BACKUP/MIGRASI DATA SISWA KE db_siswa_semester_history ---
			$db = \Config\Database::connect();
			$id_tahunajaran = $id_tahunajaran_aktif;
			// Pastikan semester berupa angka (1=Ganjil, 2=Genap)
			$semester = ($tapelDipilih && isset($tapelDipilih->semester)) ?
				(is_numeric($tapelDipilih->semester) ? (int)$tapelDipilih->semester : (strtolower($tapelDipilih->semester) == 'genap' ? 2 : 1))
				: null;
			if ($id_tahunajaran && $semester) {
				$siswaList = $db->table('db_siswa')->get()->getResult();
				foreach ($siswaList as $siswa) {
					// Pastikan semester valid (1 atau 2)
					if ($semester === 1 || $semester === 2) {
						$cek = $db->table('db_siswa_semester_history')
							->where('id_siswa', $siswa->id_siswa)
							->where('id_tahun_ajaran', $id_tahunajaran)
							->where('semester', $semester)
							->countAllResults();
						if ($cek == 0) {
							$dataInsert = [
								'id_siswa' => $siswa->id_siswa,
								'id_rombel' => $siswa->id_rombel ?? null,
								'id_tahun_ajaran' => $id_tahunajaran,
								'semester' => $semester,
								'status_siswa' => 'aktif',
								'tanggal_snapshot' => date('Y-m-d'),
								'created_at' => date('Y-m-d H:i:s')
							];
							$db->table('db_siswa_semester_history')->insert($dataInsert);
						}
					}
				}
			}
			// --- END AUTO BACKUP/MIGRASI ---
			return redirect()->to(site_url('dashboard'));
		}

		// Validasi username dan password
		$db = \Config\Database::connect();
		$user = $db->table('users')->getWhere(['username' => $post['username']])->getRow();
		if (!$user) {
			return redirect()->back()->with('error', 'Username tidak ditemukan.');
		}

		if (!password_verify($post['password'], $user->password_user)) {
			return redirect()->back()->with('error', 'Password salah atau tidak sesuai dengan database.');
		}

		// Jika valid, set session dan arahkan ke dashboard
		$session->set([
			'id_user' => $user->id_user,
			'username' => $user->username,
			'logged_in' => true
		]);

		return redirect()->to(site_url('dashboard'));
	}

	public function validatePassword()
	{
		if ($this->request->isAJAX()) {
			$username = $this->request->getPost('username');
			$password = $this->request->getPost('password');

			$db = \Config\Database::connect();
			$user = $db->table('users')->getWhere(['username' => $username])->getRow();

			if ($user && password_verify($password, $user->password_user)) {
				return $this->response->setJSON(['success' => true]);
			}

			return $this->response->setJSON(['success' => false]);
		}

		throw new \CodeIgniter\Exceptions\PageNotFoundException();
	}

	// Captcha logic removed

	public function logout()
	{
		// Ambil tipe_pengguna dan role dari session sebelum menghapus
		$tipe_pengguna = session('tipe_pengguna');
		$role = session('role');

		// Log logout activity
		log_message('info', 'User logged out: ' . session('username') . ' from IP: ' . $this->request->getIPAddress());

		// Hapus semua session dan destroy session sepenuhnya
		session()->destroy();

		// Set pesan logout
		session()->setFlashdata('success', 'Anda telah berhasil logout.');

		// Redirect sesuai tipe pengguna
		if (($tipe_pengguna === 'guru_kelas' || $tipe_pengguna === 'guru_mapel') || $role === 'guru') {
			return redirect()->to(site_url('login_guru'));
		} else {
			return redirect()->to(site_url('login'));
		}
	}

	public function loginProcessNoCSRF()
	{
		$session = session();
		$post = $this->request->getPost();

		// Validasi username dan password (hanya username)
		$db = \Config\Database::connect();
		$user = $db->table('users')->where('username', $post['username'])->get()->getRow();
		$tipe_pengguna = $post['tipe_pengguna'] ?? '';

		// Jika gagal login dan tipe pengguna guru_kelas, redirect ke login_guru
		if (!$user) {
			if ($tipe_pengguna === 'guru_kelas') {
				return redirect()->to(site_url('login_guru'))->with('error', 'Username tidak ditemukan.');
			}
			return redirect()->back()->with('error', 'Username tidak ditemukan.');
		}

		if (!password_verify($post['password'], $user->password_user)) {
			if ($tipe_pengguna === 'guru_kelas') {
				return redirect()->to(site_url('login_guru'))->with('error', 'Password salah atau tidak sesuai dengan database.');
			}
			return redirect()->back()->with('error', 'Password salah atau tidak sesuai dengan database.');
		}

		// Jika valid, set session dan arahkan ke dashboard
		// Simpan tipe pengguna ke session
		$tipe_pengguna = $post['tipe_pengguna'] ?? '';
		$sessionData = [
			'id_user' => $user->id_user,
			'username' => $user->username,
			'logged_in' => true,
			'tipe_pengguna' => $tipe_pengguna
		];
		// Set role guru jika tipe_pengguna guru_kelas atau guru_mapel
		if ($tipe_pengguna === 'guru_kelas' || $tipe_pengguna === 'guru_mapel') {
			$sessionData['role'] = 'guru';
		} else {
			// Ambil role dari database jika ada (untuk admin/operator)
			if (isset($user->role) && $user->role) {
				$sessionData['role'] = $user->role;
			} else {
				$sessionData['role'] = 'admin'; // fallback default
			}
		}
		$session->set($sessionData);

		// Redirect ke dashboard guru setelah login
		if ($tipe_pengguna === 'guru_kelas' || $tipe_pengguna === 'guru_mapel') {
			return redirect()->to(site_url('rapor/dashboard'));
		} else {
			return redirect()->to(site_url('dashboard'));
		}
	}
}
