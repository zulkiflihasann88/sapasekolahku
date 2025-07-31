<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;


class Pendidik extends ResourceController
{
	function __construct()
	{
		$this->pendidik = model('PendidikModel');
	}

	public function index()
	{
		$data['pendidik'] = $this->pendidik->getAll();
		return view('pendidik/index', $data);
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
		$this->pendidik->insert($data);
		return redirect()->to('pendidik')->with('success', 'Data Berhasil Disimpan');
	}

	public function edit($id = null)
	{
		$pendidik = $this->model->where('id_pendidik', $id)->first();
		if (is_object($rombel)) {
			$data['rombel'] = $pendidik;
			return view('rombongan_belajar/edit', $data);
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}
	public function update($id = null)
	{
		$data = $this->request->getPost();
		$save = $this->pendidik->update($id, $data);
		if (!$save) {
			return redirect()->back()->withInput()->with('errors', $this->pendidik->errors());
		} else {
			return redirect()->to(site_url('pendidik'))->with('success', 'Data Berhasil Diupdate');
		}
	}

	public function delete($id = null)
	{
		$this->rombel->delete($id);
		return redirect('rombongan_belajar')->with('success', 'Data Berhasil Dihapus');
	}
}
