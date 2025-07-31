<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;



class Kepalasekolah extends ResourceController
{
	protected $kepala;
	protected $db;

	function __construct()
	{
		$this->kepala = model('KepalasekolahModel');
		$this->db = db_connect();
	}

	public function index()
	{
		$data['kepala'] = $this->kepala->getAll();
		$tahun = $this->db->table('db_tahunajaran')->get()->getResult();
		$data['tahun'] = $tahun;

		return view('kepala_sekolah/index', $data);
	}

	public function create()
	{
		$data = $this->request->getPost();
		if ($this->kepala->insert($data)) {
			return redirect()->to(site_url('sekolah/kepala_sekolah'))->with('success', 'Kepala Sekolah berhasil ditambahkan');
		} else {
			return redirect()->back()->withInput()->with('error', 'Gagal menambahkan Kepala Sekolah');
		}
	}

	public function update($id = null)
	{
		$data = $this->request->getPost();

		// Debug information to find out what's happening
		log_message('debug', 'Update method called with ID: ' . $id);
		log_message('debug', 'POST data: ' . json_encode($data));

		// Make sure we have a valid ID, either from URL or from form data
		if ($id === null) {
			if (isset($data['id_kepalasekolah']) && !empty($data['id_kepalasekolah'])) {
				$id = $data['id_kepalasekolah'];
				log_message('debug', 'ID retrieved from POST data: ' . $id);
			} else {
				return redirect()->back()->withInput()->with('error', 'ID Kepala Sekolah tidak ditemukan');
			}
		}

		// Ensure ID is valid
		if (!is_numeric($id) || intval($id) <= 0) {
			return redirect()->back()->withInput()->with('error', 'ID Kepala Sekolah tidak valid');
		}

		// Remove any fields that shouldn't be updated
		if (isset($data['_method'])) {
			unset($data['_method']);
		}

		// Perform the update operation
		try {
			$save = $this->kepala->update($id, $data);

			if ($save === false) {
				// Check if there are validation errors
				$errors = $this->kepala->errors();
				if ($errors) {
					return redirect()->back()->withInput()->with('error', json_encode($errors));
				} else {
					return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data Kepala Sekolah');
				}
			} else {
				return redirect()->to(site_url('sekolah/kepala_sekolah'))->with('success', 'Data Berhasil Diupdate');
			}
		} catch (\Exception $e) {
			log_message('error', 'Error updating Kepala Sekolah: ' . $e->getMessage());
			return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
		}
	}
}
