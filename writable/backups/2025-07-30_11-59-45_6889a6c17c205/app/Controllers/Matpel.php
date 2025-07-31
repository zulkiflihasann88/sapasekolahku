<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;


class Matpel extends ResourceController
{
	function __construct()
	{
		$this->matpel = model('MatpelModel');
	}

	public function index()
	{
		// helper('custom');
		$data['matpel'] = $this->matpel->getAll();

		return view('mata pelajaran/index', $data);
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
		if (!$this->matpel->insert($data)) {
			return redirect()->back()->withInput()->with('error', implode(', ', $this->matpel->errors()));
		}
		return redirect()->to('mata_pelajaran')->with('success', 'Data Berhasil Disimpan');
	}

	public function edit($id = null)
	{
		$matpel = $this->model->where('id_pelajaran', $id)->first();
		if (is_object($matpel)) {
			$data['matpel'] = $matpel;
			return view('mata pelajaran/edit', $data);
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}
	public function update($id = null)
	{
		$data = $this->request->getPost();
		$save = $this->matpel->update($id, $data);
		if (!$save) {
			return redirect()->back()->withInput()->with('errors', $this->matpel->errors());
		} else {
			return redirect()->to(site_url('mata_pelajaran'))->with('success', 'Data Berhasil Diupdate');
		}
	}

	public function delete($id = null)
	{
		$this->matpel->delete($id);
		return redirect('mata_pelajaran')->with('success', 'Data Berhasil Dihapus');
	}
}
