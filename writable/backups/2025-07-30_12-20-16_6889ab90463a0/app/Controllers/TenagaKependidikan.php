<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class TenagaKependidikan extends ResourceController
{
    protected $tenagaKependidikan;
    protected $pendidikan;
    protected $db;
    function __construct()
    {
        $this->tenagaKependidikan = model('TenagaKependidikanModel');
        $this->pendidikan = model('PendidikanModel');
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data['tenaga_kependidikan'] = $this->tenagaKependidikan->getAll();
        $data['pendidikan'] = $this->pendidikan->getAll();
        return view('tenaga_kependidikan/index', $data);
    }

    /**
     * Process the creation/insertion of a new resource object.
     * This should be a POST.
     *
     * @return mixed
     */    public function create()
    {
        if ($this->request->isAJAX()) {
            try {
                $data = $this->request->getPost();
                $save = $this->tenagaKependidikan->insert($data);

                if (!$save) {
                    $errors = $this->tenagaKependidikan->errors();
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Gagal menyimpan data',
                        'errors' => $errors
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'message' => 'Data berhasil disimpan'
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        } else {
            // Fallback untuk non-AJAX request
            $data = $this->request->getPost();
            $save = $this->tenagaKependidikan->insert($data);
            if (!$save) {
                return redirect()->back()->withInput()->with('errors', $this->tenagaKependidikan->errors());
            } else {
                return redirect()->to('tenaga_kependidikan')->with('success', 'Data Berhasil Disimpan');
            }
        }
    }

    public function edit($id = null)
    {
        if ($id != null) {
            $query = $this->db->table('tenaga_kependidikan')->getWhere(['id_tenaga_kependidikan' => $id]);
            if ($query->getNumRows() > 0) {
                $data['tenaga_kependidikan'] = $query->getRowArray();
                return view('tenaga_kependidikan/edit', $data);
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
    public function update($id = null)
    {
        if ($this->request->isAJAX()) {
            try {
                $data = $this->request->getPost();
                $save = $this->tenagaKependidikan->update($id, $data);

                if (!$save) {
                    $errors = $this->tenagaKependidikan->errors();
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Gagal memperbarui data',
                        'errors' => $errors
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'message' => 'Data berhasil diperbarui'
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        } else {
            // Fallback untuk non-AJAX request
            $data = $this->request->getPost();
            $save = $this->tenagaKependidikan->update($id, $data);
            if (!$save) {
                return redirect()->back()->withInput()->with('errors', $this->tenagaKependidikan->errors());
            } else {
                return redirect()->to('tenaga_kependidikan')->with('success', 'Data Berhasil Diupdate');
            }
        }
    }

    public function delete($id = null)
    {
        if ($id != null) {
            if ($this->tenagaKependidikan->delete($id)) {
                return redirect()->to('tenaga_kependidikan')->with('success', 'Data berhasil dihapus');
            } else {
                return redirect()->back()->with('error', 'Data gagal dihapus');
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function getData($id = null)
    {
        if ($this->request->isAJAX()) {
            if ($id != null) {
                $data = $this->tenagaKependidikan->find($id);
                if ($data) {
                    // Format tanggal agar sesuai input type="date"
                    if (!empty($data->tanggal_lahir)) {
                        $data->tanggal_lahir = date('Y-m-d', strtotime($data->tanggal_lahir));
                    }
                    if (!empty($data->tmt_kerja)) {
                        $data->tmt_kerja = date('Y-m-d', strtotime($data->tmt_kerja));
                    }
                    return $this->response->setJSON([
                        'status' => 'success',
                        'data' => $data
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Data tidak ditemukan'
                    ])->setStatusCode(404);
                }
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'ID tidak valid'
                ])->setStatusCode(400);
            }
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Request tidak valid'
            ])->setStatusCode(400);
        }
    }
}
