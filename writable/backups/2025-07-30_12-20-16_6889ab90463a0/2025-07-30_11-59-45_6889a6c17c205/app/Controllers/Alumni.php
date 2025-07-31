<?php

namespace App\Controllers;

use App\Models\MutasiModel;
use CodeIgniter\Controller;

class Alumni extends Controller
{
    public function index()
    {
        // Add debugging to catch the exact error
        try {
            $mutasiModel = new MutasiModel();
            $tahunLulus = $this->request->getGet('tahun_lulus');

            // Base query untuk alumni (siswa yang lulus)
            $query = $mutasiModel
                ->select('db_mutasi.*, db_siswa.nama_siswa, db_siswa.nisn, db_siswa.nis, db_siswa.jk, db_siswa.tanggal_lahir, db_siswa.tempat_lahir')
                ->join('db_siswa', 'db_siswa.id_siswa = db_mutasi.id_siswa')
                ->where('db_mutasi.alasan_mutasi', 'Lulus')
                ->where('db_mutasi.tanggal_mutasi IS NOT NULL')
                ->where('db_mutasi.tanggal_mutasi !=', '');

            // Jika ada filter tahun lulus
            if (!empty($tahunLulus) && $tahunLulus !== '') {
                // Gunakan LIKE untuk mencocokkan tahun di awal tanggal
                $query = $query->where("db_mutasi.tanggal_mutasi LIKE", $tahunLulus . '%');
            }

            log_message('info', 'About to execute alumni query');
            $alumni = $query->orderBy('db_mutasi.tanggal_mutasi', 'DESC')->findAll();
            log_message('info', 'Alumni query executed successfully');

            // Ambil daftar tahun lulus unik dari database untuk dropdown filter
            log_message('info', 'About to execute tahun_lulus_list query');
            $tahun_lulus_list = $mutasiModel
                ->select('DISTINCT(LEFT(tanggal_mutasi, 4)) as tahun')
                ->where('alasan_mutasi', 'Lulus')
                ->where('tanggal_mutasi IS NOT NULL')
                ->where('tanggal_mutasi !=', '')
                ->orderBy('tahun', 'DESC')
                ->findAll();
            log_message('info', 'Tahun lulus list query executed successfully');

            $tahun_lulus_list = array_map(function ($row) {
                return $row->tahun;
            }, $tahun_lulus_list);

            log_message('info', 'About to load view');
            return view('alumni/index', [
                'alumni' => $alumni,
                'tahun_lulus_list' => $tahun_lulus_list
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Alumni controller error: ' . $e->getMessage());
            log_message('error', 'Alumni controller trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    public function update($id)
    {
        $mutasiModel = new MutasiModel();

        $data = [
            'tanggal_mutasi' => $this->request->getPost('tanggal_mutasi'),
            'alasan_mutasi' => $this->request->getPost('alasan_mutasi') ?: 'Lulus',
            'keterangan_mutasi' => $this->request->getPost('keterangan_mutasi')
        ];

        if ($mutasiModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data alumni berhasil diperbarui');
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui data alumni');
        }

        return redirect()->to('alumni');
    }

    public function detail($id_siswa)
    {
        $db = \Config\Database::connect();
        $alumni = $db->table('db_siswa')
            ->select('db_siswa.*, db_mutasi.tanggal_mutasi')
            ->join('db_mutasi', 'db_mutasi.id_siswa = db_siswa.id_siswa', 'left')
            ->where('db_siswa.id_siswa', $id_siswa)
            ->get()->getRow();
        return view('alumni/detail', ['alumni' => $alumni]);
    }
}
