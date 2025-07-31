<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;



class Tapel extends ResourceController
{
	protected $tapel;
	protected $kepala;
	public function __construct()
	{
		$this->tapel = model('TapelModel');
		$this->kepala = model('KepalasekolahModel');
	}

	public function index()
	{
		$data['tapel'] = $this->tapel->getAll();
		$data['kepala'] = $this->kepala->findAll();
		return view('tahun_pelajaran/index', $data);
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
		$this->tapel->insert($data);
		return redirect()->to('tahun_pelajaran')->with('success', 'Data Berhasil Disimpan');
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

		// Ambil data tahun pelajaran sebelum update
		$oldTapel = $this->tapel->find($id);

		// Pastikan field status dikirim
		if (!isset($data['status'])) {
			return redirect()->back()->with('error', 'Field status wajib diisi.');
		}

		// Jika status diubah menjadi Aktif, nonaktifkan tapel lain untuk kepala sekolah yang sama dan set id_kepalasekolah tapel lama ke null
		if (isset($data['id_kepalasekolah']) && $data['id_kepalasekolah'] && $data['status'] == 'Aktif') {
			$data['status'] = 'Aktif';
			$save = $this->tapel->update($id, $data);
			if ($save) {
				// Set tapel lain status Tidak Aktif dan id_kepalasekolah menjadi null
				$this->tapel
					->where('id_tahun_ajaran !=', $id)
					->where('id_kepalasekolah', $data['id_kepalasekolah'])
					->set(['status' => 'Tidak Aktif', 'id_kepalasekolah' => null])
					->update();
				return redirect()->to('tahun_pelajaran')->with('success', 'Tahun pelajaran berhasil diupdate. Tapel lama dinonaktifkan dan id kepala sekolah direset.');
			} else {
				return redirect()->back()->with('error', 'Gagal update data: ' . implode(', ', $this->tapel->errors()));
			}
		} else {
			$save = $this->tapel->update($id, $data);
			if ($save) {
				return redirect()->to('tahun_pelajaran')->with('success', 'Tahun pelajaran berhasil diupdate.');
			} else {
				return redirect()->back()->with('error', 'Gagal update data: ' . implode(', ', $this->tapel->errors()));
			}
		}
	}
}
