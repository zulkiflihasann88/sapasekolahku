<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;


class Lembaga extends ResourceController
{
	protected $sekolah;
	protected $db;

	function __construct()
	{
		$this->sekolah = model('LembagaModel');
		$this->db = \Config\Database::connect();
	}
	public function index()
	{
		// helper('custom');
		$data['sekolah'] = $this->sekolah->getAll();
		return view('profile/lembaga', $data);
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

	public function edit($id = null)
	{

		if ($id != null) {
			$query = $this->db->table('sekolah')->getWhere(['id_sekolah' => $id]);
			if ($query->getNumRows() > 0) {
				$data['sekolah'] = $query->getRowArray(); // Use getRowArray() to get the result as an associative array
				return view('lembaga/edit', $data);
			} else {
				throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			}
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}

	public function updateData($id = null)
	{
		// Cek apakah ini AJAX request
		if ($this->request->isAJAX()) {
			try {
				// Ambil data dari POST
				$data = $this->request->getPost();

				// Log data yang diterima untuk debugging
				log_message('info', 'Update data received: ' . json_encode($data));

				// Handle file upload jika ada
				$logoFile = $this->request->getFile('logo');
				if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
					// Validasi file
					$allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
					if (!in_array($logoFile->getMimeType(), $allowedTypes)) {
						return $this->response->setJSON([
							'status' => 'error',
							'message' => 'Tipe file logo harus JPG atau PNG.'
						]);
					}

					if ($logoFile->getSize() > 1048576) { // 1MB
						return $this->response->setJSON([
							'status' => 'error',
							'message' => 'Ukuran file logo maksimal 1MB.'
						]);
					}

					// Pastikan direktori upload ada (public/uploads/)
					$uploadPath = FCPATH . 'uploads/';
					if (!is_dir($uploadPath)) {
						mkdir($uploadPath, 0755, true);
					}

					// Upload file ke public/uploads/
					$newName = $logoFile->getRandomName();
					if ($logoFile->move($uploadPath, $newName)) {
						$data['logo'] = $newName;
					} else {
						return $this->response->setJSON([
							'status' => 'error',
							'message' => 'Gagal mengupload file logo.'
						]);
					}
				}

				// Dapatkan ID sekolah dari session atau request
				if (!$id) {
					// Jika ID tidak ada di parameter, ambil dari data atau session
					$id = $data['id_sekolah'] ?? session()->get('id_sekolah') ?? 1;
				}

				// Hapus id_sekolah dari data jika ada (karena ini primary key)
				unset($data['id_sekolah']);

				// Validasi dan normalisasi website URL
				if (isset($data['website']) && !empty($data['website'])) {
					$website = trim($data['website']);
					// Jika tidak ada protokol, tambahkan https://
					if (!preg_match('/^https?:\/\//', $website)) {
						$website = 'https://' . $website;
					}
					$data['website'] = $website;
				}

				// Manual validation untuk field yang wajib
				$errors = [];
				if (empty($data['nama_sekolah'])) {
					$errors['nama_sekolah'] = 'Nama sekolah harus diisi';
				}
				if (empty($data['alamat'])) {
					$errors['alamat'] = 'Alamat harus diisi';
				}
				if (empty($data['telp'])) {
					$errors['telp'] = 'Telepon harus diisi';
				}
				if (empty($data['email'])) {
					$errors['email'] = 'Email harus diisi';
				} elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
					$errors['email'] = 'Format email tidak valid';
				}

				if (!empty($errors)) {
					return $this->response->setJSON([
						'status' => 'error',
						'message' => 'Data tidak valid',
						'errors' => $errors
					]);
				}

				// Update data menggunakan query builder untuk lebih robust
				$builder = $this->db->table('sekolah');
				$save = $builder->where('id_sekolah', $id)->update($data);

				if (!$save) {
					return $this->response->setJSON([
						'status' => 'error',
						'message' => 'Gagal menyimpan data ke database.',
						'db_error' => $this->db->error()
					]);
				} else {
					return $this->response->setJSON([
						'status' => 'success',
						'message' => 'Data berhasil diperbarui.'
					]);
				}
			} catch (\Exception $e) {
				log_message('error', 'Error updating lembaga data: ' . $e->getMessage());
				log_message('error', 'Stack trace: ' . $e->getTraceAsString());
				return $this->response->setJSON([
					'status' => 'error',
					'message' => 'Terjadi kesalahan server: ' . $e->getMessage(),
					'file' => $e->getFile(),
					'line' => $e->getLine()
				]);
			}
		} else {
			// Handle non-AJAX request (fallback)
			$data = $this->request->getPost();
			$save = $this->sekolah->update($id, $data);
			if (!$save) {
				return redirect()->back()->withInput()->with('errors', $this->sekolah->errors());
			} else {
				return redirect()->to(site_url('lembaga'))->with('success', 'Data Berhasil Diupdate');
			}
		}
	}

	public function delete($id = null)
	{
		if ($id != null) {
			if ($this->sekolah->delete($id)) {
				return redirect()->to('/lembaga')->with('success', 'Data berhasil dihapus');
			} else {
				return redirect()->back()->with('error', 'Data gagal dihapus');
			}
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}
}
