<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WaliKelasModel;
use App\Models\PendidikModel;
use App\Models\RombelModel;
use App\Models\TapelModel;
use App\Models\MutasiModel;
use CodeIgniter\HTTP\ResponseInterface;

class WaliKelas extends BaseController
{
    public function index()
    {
        $waliKelasModel = new WaliKelasModel();
        $pendidikModel = new PendidikModel();
        $rombelModel = new RombelModel();
        $tapelModel = new TapelModel();

        $data['wali_kelas'] = $waliKelasModel->findAll();
        // Pastikan hasil findAll() dikembalikan sebagai objek, bukan array
        if (!empty($data['wali_kelas']) && is_array($data['wali_kelas']) && is_array($data['wali_kelas'][0])) {
            $data['wali_kelas'] = array_map(function ($item) {
                return (object)$item;
            }, $data['wali_kelas']);
        }
        $data['list_pendidik'] = $pendidikModel->findAll();
        $data['list_rombel'] = $rombelModel->findAll();
        $data['list_tapel'] = $tapelModel->findAll();
        return view('wali_kelas/index', $data);
    }

    public function getData($id)
    {
        $model = new WaliKelasModel();
        $data = $model->find($id);
        if ($data) {
            return $this->response->setJSON(['status' => 'success', 'data' => $data]);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
    }

    public function create()
    {
        $model = new WaliKelasModel();
        $data = $this->request->getPost();
        if ($model->insert($data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menambah data', 'errors' => $model->errors()]);
    }

    public function update($id)
    {
        $model = new WaliKelasModel();
        $data = $this->request->getPost();
        if ($model->update($id, $data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil diupdate']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal update data', 'errors' => $model->errors()]);
    }

    public function delete($id)
    {
        $model = new WaliKelasModel();
        if ($model->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menghapus data']);
    }

    // Tampilkan anggota rombel dalam view sendiri
    public function anggotaRombel($nama_rombel = null, $tahun_ajaran = null)
    {
        if (!$nama_rombel) {
            return redirect()->to('wali_kelas');
        }
        $db = \Config\Database::connect();
        // Ambil semua id_siswa yang sudah mutasi
        $mutasiModel = new MutasiModel();
        $mutasiIds = $mutasiModel->select('id_siswa')->findAll();
        $excludeIds = array_column($mutasiIds, 'id_siswa');
        // Ambil data siswa berdasarkan nama_rombel dan tahun_ajaran (jika ada)
        $builder = $db->table('db_siswa');
        $builder->join('db_rombel', 'db_rombel.id_rombel = db_siswa.id_rombel', 'left');
        $builder->where('db_rombel.rombel', $nama_rombel);
        if (!empty($excludeIds)) {
            $builder->whereNotIn('db_siswa.id_siswa', $excludeIds);
        }
        $anggota = $builder->get()->getResult();
        $data = [
            'anggota' => $anggota,
            'nama_rombel' => $nama_rombel
        ];
        return view('wali_kelas/anggota_rombel', $data);
    }

    public function datatables()
    {
        $request = service('request');
        $model = new \App\Models\WaliKelasModel();
        $columns = [
            0 => 'id_wali_kelas',
            1 => 'jenis_kelas',
            2 => 'tingkat_pendidikan',
            3 => 'kurikulum',
            4 => 'nama_rombel',
            5 => 'nama_wali',
            6 => 'ruang',
        ];
        $draw = $request->getPost('draw');
        $start = $request->getPost('start');
        $length = $request->getPost('length');
        $order = $request->getPost('order');
        $search = $request->getPost('search')['value'] ?? '';

        $builder = $model;
        if ($search) {
            $builder = $builder->groupStart()
                ->like('jenis_kelas', $search)
                ->orLike('tingkat_pendidikan', $search)
                ->orLike('kurikulum', $search)
                ->orLike('nama_rombel', $search)
                ->orLike('nama_wali', $search)
                ->orLike('ruang', $search)
                ->groupEnd();
        }

        $total = $model->countAll();
        $filtered = $builder->countAllResults(false);

        // Order
        if (!empty($order)) {
            foreach ($order as $ord) {
                $colIdx = $ord['column'];
                $dir = $ord['dir'];
                if (isset($columns[$colIdx])) {
                    $builder = $builder->orderBy($columns[$colIdx], $dir);
                }
            }
        } else {
            $builder = $builder->orderBy('id_wali_kelas', 'desc');
        }

        $data = $builder->findAll($length, $start);

        $result = [];
        $no = $start + 1;
        foreach ($data as $row) {
            $result[] = [
                'no' => $no++,
                'jenis_kelas' => $row['jenis_kelas'] ?? $row->jenis_kelas ?? '',
                'tingkat_pendidikan' => $row['tingkat_pendidikan'] ?? $row->tingkat_pendidikan ?? '',
                'kurikulum' => $row['kurikulum'] ?? $row->kurikulum ?? '',
                'nama_rombel' => $row['nama_rombel'] ?? $row->nama_rombel ?? '',
                'nama_wali' => $row['nama_wali'] ?? $row->nama_wali ?? '',
                'ruang' => $row['ruang'] ?? $row->ruang ?? '',
                'aksi' => view('wali_kelas/_aksi', ['item' => (object)$row])
            ];
        }

        return $this->response->setJSON([
            'draw' => intval($draw),
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $result
        ]);
    }
    // Cetak daftar hadir kelas
    public function cetakAbsen($nama_rombel = null)
    {
        if (!$nama_rombel) {
            return redirect()->to('wali_kelas');
        }
        $db = \Config\Database::connect();
        $builder = $db->table('db_siswa');
        $builder->join('db_rombel', 'db_rombel.id_rombel = db_siswa.id_rombel', 'left');
        $builder->where('db_rombel.rombel', $nama_rombel);
        $anggota = $builder->get()->getResult();

        // Ambil nama wali kelas dan tahun ajaran dari db_rombel

        $rombel = $db->table('db_rombel')->where('rombel', $nama_rombel)->get()->getRow();
        $tahun_ajaran = isset($rombel->tahun_ajaran) ? $rombel->tahun_ajaran : '-';

        // Ambil nama wali dari tabel pendidik jika wali_kelas berupa id
        $nama_wali = '-';
        if (isset($rombel->wali_kelas) && $rombel->wali_kelas) {
            // Cek jika isinya angka/id
            if (is_numeric($rombel->wali_kelas)) {
                $pendidik = $db->table('db_pendidik')->where('id', $rombel->wali_kelas)->get()->getRow();
                $nama_wali = $pendidik && isset($pendidik->nama) ? $pendidik->nama : $rombel->wali_kelas;
            } else {
                $nama_wali = $rombel->wali_kelas;
            }
        }

        $data = [
            'anggota' => $anggota,
            'nama_rombel' => $nama_rombel,
            'nama_wali' => $nama_wali,
            'tahun_ajaran' => $tahun_ajaran
        ];
        return view('wali_kelas/cetak_absen', $data);
    }

    // Export daftar hadir kelas ke PDF
    public function exportAbsenPdf($nama_rombel = null)
    {
        if (!$nama_rombel) {
            return redirect()->to('wali_kelas');
        }
        $db = \Config\Database::connect();
        $builder = $db->table('db_siswa');
        $builder->join('db_rombel', 'db_rombel.id_rombel = db_siswa.id_rombel', 'left');
        $builder->where('db_rombel.rombel', $nama_rombel);
        $anggota = $builder->get()->getResult();

        // Ambil nama wali kelas dan tahun ajaran dari db_rombel

        $rombel = $db->table('db_rombel')->where('rombel', $nama_rombel)->get()->getRow();
        $tahun_ajaran = isset($rombel->tahun_ajaran) ? $rombel->tahun_ajaran : '-';

        // Ambil nama wali dari tabel pendidik jika wali_kelas berupa id
        $nama_wali = '-';
        if (isset($rombel->wali_kelas) && $rombel->wali_kelas) {
            if (is_numeric($rombel->wali_kelas)) {
                // Ganti 'id' dengan nama kolom primary key sebenarnya, misal 'nip' atau 'kode_pendidik'
                $pendidik = $db->table('db_pendidik')->where('nama', $rombel->wali_kelas)->get()->getRow();
                $nama_wali = $pendidik && isset($pendidik->nama) ? $pendidik->nama : '-';
            } else {
                $nama_wali = $rombel->wali_kelas;
            }
        }

        $data = [
            'anggota' => $anggota,
            'nama_rombel' => $nama_rombel,
            'nama_wali' => $nama_wali,
            'tahun_ajaran' => $tahun_ajaran
        ];
        $html = view('wali_kelas/cetak_absen', $data);
        // Load Dompdf
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        // Set ukuran kertas F4 manual (karena Dompdf tidak support 'F4' langsung)
        // F4 = 210mm x 330mm = 595 x 935 points
        // Landscape: width > height
        $dompdf->setPaper([0, 0, 935, 595], 'landscape');
        $dompdf->render();
        $dompdf->stream('daftar_siswa_' . $nama_rombel . '.pdf', ['Attachment' => false]);
        exit;
    }
}
