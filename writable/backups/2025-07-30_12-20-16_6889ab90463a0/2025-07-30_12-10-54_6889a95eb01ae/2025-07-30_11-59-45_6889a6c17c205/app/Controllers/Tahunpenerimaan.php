<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\TpenerimaanModel;

class TahunPenerimaan extends ResourceController
{
    function __construct()
    {
        $this->penerimaan = model('TpenerimaanModel');
    }

    public function index()
    {
        $data['tahun_penerimaan'] = $this->penerimaan->findAll();
        return view('tahun_penerimaan/index', $data);
    }
    public function show($id = null)
    {
        //
    }

    public function create()
    {
        $data = $this->request->getPost();
        if ($this->penerimaan->insert($data)) {
            return redirect()->to('tahun_penerimaan')->with('success', 'Tahun pendaftaran berhasil ditambahkan');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan tahun pendaftaran');
        }
    }

    public function edit($id = null)
    {
        $calon_siswa = $this->penerimaan->find($id);
        if (is_object($calon_siswa)) {
            $data = [
                'calon_siswa' => $calon_siswa,
            ];
            return view('tahun penerimaan/index', $data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function update($id = null)
    {
        $data = $this->request->getPost();
        $save = $this->penerimaan->update($id, $data);
        if (!$save) {
            return redirect()->back()->withInput()->with('errors', $this->penerimaan->errors());
        } else {
            return redirect()->to(site_url('tahun_penerimaan'))->with('success', 'Data Berhasil Diupdate');
        }
    }

    public function delete($id = null)
    {
        $this->penerimaan->delete($id);
        return redirect()->to(site_url('tahun_penerimaan'))->with('success', 'Data Berhasil Dihapus');
    }
}
