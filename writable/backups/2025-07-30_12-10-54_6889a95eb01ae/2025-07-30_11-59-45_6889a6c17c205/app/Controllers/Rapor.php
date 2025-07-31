<?php
namespace App\Controllers;

use App\Models\TargetCapaianModel;
use App\Models\ProjectModel;

class Rapor extends BaseController

{
    // Tambah relasi project ke kelompok (tombol "+ Tambahkan")
    public function tambahProjectKeKelompok()
    {
        $id_kelompok_project = $this->request->getPost('id_kelompok_project');
        $id_project = $this->request->getPost('id_project');

        $db = \Config\Database::connect();
        // Cek apakah sudah ada, agar tidak dobel
        $exists = $db->table('kelompok_project_detail')
            ->where('id_kelompok_project', $id_kelompok_project)
            ->where('id_project', $id_project)
            ->countAllResults();

        if ($exists == 0) {
            $db->table('kelompok_project_detail')->insert([
                'id_kelompok_project' => $id_kelompok_project,
                'id_project' => $id_project
            ]);
            return redirect()->back()->with('success', 'Project berhasil ditambahkan ke kelompok!');
        } else {
            return redirect()->back()->with('success', 'Project sudah ada di kelompok!');
        }
    }
    public function index()
    {
        $model = new TargetCapaianModel();
        $dimensi = $this->request->getGet('dimensi');
        $fase = $this->request->getGet('fase');
        $capaian = [];
        if ($dimensi && $fase) {
            $capaian = $model->where('dimensi_profil', $dimensi)
                            ->where('fase', $fase)
                            ->orderBy('id_capaian', 'ASC')
                            ->findAll();
        }
        return view('rapor/target_capaian', [
            'capaian' => $capaian,
            'dimensi' => $dimensi,
            'fase' => $fase
        ]);
    }

    public function saveTargetCapaian()
    {
        $model = new TargetCapaianModel();
        $data = [
            'dimensi_profil' => $this->request->getPost('dimensi'),
            'fase' => $this->request->getPost('fase'),
            'elemen' => $this->request->getPost('elemen'),
            'sub_elemen' => $this->request->getPost('sub_elemen'),
            'capaian' => $this->request->getPost('capaian'),
        ];
        $model->save($data);
        return redirect()->to('/rapor/target_capaian?dimensi=' . urlencode($data['dimensi_profil']) . '&fase=' . urlencode($data['fase']))->with('success', 'Data capaian berhasil disimpan.');
    }

    // Endpoint AJAX untuk filter dinamis capaian dengan error handling
    public function ajax()
    {
        try {
            $model = new TargetCapaianModel();
            $dimensi = $this->request->getGet('dimensi');
            $fase = $this->request->getGet('fase');
            $data = [];
            if ($dimensi && $fase) {
                $all = $model->findAll();
                $filtered = array_filter($all, function($row) use ($dimensi, $fase) {
                    // Pastikan field array sesuai struktur database
                    $rowDimensi = strtolower(trim(isset($row['dimensi_profil']) ? $row['dimensi_profil'] : (isset($row->dimensi_profil) ? $row->dimensi_profil : '')));
                    $rowFase = strtolower(trim(isset($row['fase']) ? $row['fase'] : (isset($row->fase) ? $row->fase : '')));
                    $filterDimensi = strtolower(trim($dimensi));
                    $filterFase = strtolower(trim($fase));
                    $rowFaseNoPrefix = preg_replace('/^fase /', '', $rowFase);
                    $filterFaseNoPrefix = preg_replace('/^fase /', '', $filterFase);
                    return (
                        ($rowDimensi === $filterDimensi) &&
                        (
                            $rowFase === $filterFase ||
                            $rowFase === $filterFaseNoPrefix ||
                            $rowFaseNoPrefix === $filterFase ||
                            $rowFaseNoPrefix === $filterFaseNoPrefix
                        )
                    );
                });
                $data = array_values($filtered);
            }
            return $this->response->setJSON(['data' => $data]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => $e->getMessage()]);
        }
    }

        // Halaman input nilai rapor untuk guru kelas
        public function input_nilai_guru_kelas()
        {
            // Data kelas dan siswa bisa diambil dari model sesuai kebutuhan
            // Contoh: $kelas = ...; $siswa = ...;
            return view('rapor/input_nilai_guru_kelas');
        }
    
    // Halaman input nilai rapor untuk guru mapel
    public function input_nilai_guru_mapel()
    {
        // Data mapel, kelas, dan siswa bisa diambil dari model sesuai kebutuhan
        // Contoh: $mapel = ...; $kelas = ...; $siswa = ...;
        return view('rapor/input_nilai_guru_mapel');
    }

    public function dataProject()
    {
        $tema = $this->request->getGet('dimensi');
        $fase = $this->request->getGet('fase');
        $projectModel = new \App\Models\ProjectModel();
        $projects = [];
        // Hanya isi variabel jika filter benar-benar dipilih
        if ($tema !== null && $tema !== '' && $fase !== null && $fase !== '') {
            $projects = $projectModel->where('tema', $tema)->where('fase', $fase)->findAll();
        } else {
            $tema = null;
            $fase = null;
        }
        return view('rapor/data_project', [
            'tema' => $tema,
            'fase' => $fase,
            'projects' => $projects
        ]);
    }

    public function saveDataProject()
    {
        $model = new ProjectModel();
        $data = [
            'nomor_project' => $this->request->getPost('nomor_project'),
            'nama_project' => $this->request->getPost('nama_project'),
            'deskripsi_project' => $this->request->getPost('deskripsi_project'),
            'tema' => $this->request->getPost('dimensi'),
            'fase' => $this->request->getPost('fase'),
        ];
        $model->insert($data);
        // Redirect dengan query string agar filter tetap sesuai input terakhir
        return redirect()->to('rapor/data_project?dimensi=' . urlencode($data['tema']) . '&fase=' . urlencode($data['fase']))->with('success', 'Data project berhasil disimpan.');
    }

    // Endpoint AJAX untuk modal cek capaian projek sekolah
    public function ajax_capaian()
    {
        try {
            $model = new TargetCapaianModel();
            $dimensi = $this->request->getGet('dimensi');
            $fase = $this->request->getGet('fase');
            $data = [];
            if ($fase) {
                $all = $model->findAll();
                $filterFase = strtolower(trim($fase));
                $filterFaseNoPrefix = preg_replace('/^fase /', '', $filterFase);
                // Jika request AJAX dari modal Tambah (ada ?tambah=1), filter hanya fase saja
                if ($this->request->getGet('tambah') == '1') {
                    $filtered = array_filter($all, function($row) use ($filterFase, $filterFaseNoPrefix) {
                        $rowFase = strtolower(trim(is_array($row) ? $row['fase'] : $row->fase));
                        $rowFaseNoPrefix = preg_replace('/^fase /', '', $rowFase);
                        return (
                            $rowFase === $filterFase ||
                            $rowFase === $filterFaseNoPrefix ||
                            $rowFaseNoPrefix === $filterFase ||
                            $rowFaseNoPrefix === $filterFaseNoPrefix
                        );
                    });
                } else {
                    // Modal lain: filter tetap berdasarkan dimensi & fase
                    $dimensi = $this->request->getGet('dimensi');
                    $filterDimensi = strtolower(preg_replace('/\s+/', '', $dimensi));
                    $filtered = array_filter($all, function($row) use ($filterDimensi, $filterFase, $filterFaseNoPrefix) {
                        $rowDimensi = strtolower(preg_replace('/\s+/', '', is_array($row) ? $row['dimensi_profil'] : $row->dimensi_profil));
                        $rowFase = strtolower(trim(is_array($row) ? $row['fase'] : $row->fase));
                        $rowFaseNoPrefix = preg_replace('/^fase /', '', $rowFase);
                        return (
                            $rowDimensi === $filterDimensi && (
                                $rowFase === $filterFase ||
                                $rowFase === $filterFaseNoPrefix ||
                                $rowFaseNoPrefix === $filterFase ||
                                $rowFaseNoPrefix === $filterFaseNoPrefix
                            )
                        );
                    });
                }
                $data = array_values($filtered);
            }
            return $this->response->setJSON(['data' => $data]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => $e->getMessage()]);
        }
    }

    public function ajax_tambah_capaian_project()
    {
        $data = $this->request->getJSON(true);
        $project_id = $data['project_id'] ?? null;
        $dimensi = $data['dimensi'] ?? null;
        $elemen = $data['elemen'] ?? null;
        $sub_elemen = $data['sub_elemen'] ?? null;
        $capaian = $data['capaian'] ?? null;

        // Always return new CSRF token for AJAX POST (for frontend rotation)
        $csrf_token = csrf_hash();

        if (!$project_id || !$dimensi || !$elemen || !$sub_elemen || !$capaian) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Ada data yang kosong',
                'debug' => $data,
                'csrf_token' => $csrf_token
            ]);
        }

        $model = new \App\Models\ProjectCapaianModel();
        $model->insert([
            'project_id' => $project_id,
            'dimensi' => $dimensi,
            'elemen' => $elemen,
            'sub_elemen' => $sub_elemen,
            'capaian' => $capaian,
        ]);
        return $this->response->setJSON(['success' => true, 'csrf_token' => $csrf_token]);
    }
    // Hapus satu capaian dari project
    public function ajax_hapus_capaian_project()
    {
        $csrf_token = csrf_hash();
        $data = $this->request->getJSON(true);
        $id_project_capaian = isset($data['id']) ? $data['id'] : (isset($data['id_project_capaian']) ? $data['id_project_capaian'] : null);
        $project_id = isset($data['project_id']) ? $data['project_id'] : null;
        if ($id_project_capaian && $project_id) {
            $model = new \App\Models\ProjectCapaianModel();
            $deleted = $model->where('id_project_capaian', $id_project_capaian)->delete();
            $affectedRows = $model->db->affectedRows();
            return $this->response->setJSON([
                'success' => ($deleted && $affectedRows > 0),
                'csrf_token' => $csrf_token
            ]);
        }
        return $this->response->setJSON([
            'success' => false,
            'csrf_token' => $csrf_token
        ]);
}
    

    // Hapus semua capaian untuk satu project
    public function ajax_hapus_semua_capaian_project()
    {
        $csrf_token = csrf_hash();
        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getJSON(true);
            $project_id = $data['project_id'] ?? null;
            if ($project_id) {
                $model = new \App\Models\ProjectCapaianModel();
                // Jalankan query hapus, anggap sukses meskipun tidak ada baris yang dihapus
                $model->where('project_id', $project_id)->delete();
                return $this->response->setJSON(['success' => true, 'csrf_token' => $csrf_token]);
            }
        }
        return $this->response->setJSON(['success' => false, 'csrf_token' => $csrf_token]);
    }

    public function ajax_project()
{
    // Ambil parameter dari GET
    $dimensi = $this->request->getGet('dimensi');
    $fase = $this->request->getGet('fase');

    // Query ke database sesuai kebutuhan Anda
    // Contoh: ambil semua project untuk tema (dimensi) dan fase tertentu
    $model = new \App\Models\ProjectModel(); // Pastikan model ini sesuai dengan tabel project Anda
    $data = $model->where('tema', $dimensi)
                  ->where('fase', $fase)
                  ->findAll();

    return $this->response->setJSON(['data' => $data]);
}

    // Endpoint AJAX: Ambil semua capaian yang sudah ditambahkan ke project tertentu
    public function ajax_capaian_project()
    {
        $project_id = $this->request->getGet('project_id');
        if (!$project_id) {
            return $this->response->setJSON(['data' => []]);
        }
        $model = new \App\Models\ProjectCapaianModel();
        $data = $model->where('project_id', $project_id)->findAll();
        // Pastikan selalu return primary key 'id' (bukan id_project_capaian atau null)
        $result = array_map(function($row) {
            return [
                'id' => isset($row['id_project_capaian']) ? $row['id_project_capaian'] : null,
                'dimensi_profil' => isset($row['dimensi']) ? $row['dimensi'] : '',
                'elemen' => isset($row['elemen']) ? $row['elemen'] : '',
                'sub_elemen' => isset($row['sub_elemen']) ? $row['sub_elemen'] : '',
                'capaian' => isset($row['capaian']) ? $row['capaian'] : '',
            ];
        }, $data);
        return $this->response->setJSON(['data' => $result]);
    }

        // Halaman Data Kelompok Project
        public function kelompok_project()
        {
            $kelompokModel = new \App\Models\KelompokModel();
            $data['kelompok'] = $kelompokModel->findAll();

            $pendidikModel = new \App\Models\PendidikModel();
            $data['daftar_koordinator'] = $pendidikModel->getAll();

            $projectModel = new \App\Models\ProjectModel();
            $data['all_projects'] = $projectModel->findAll();

            // Ambil data projek yang sudah dipilih per kelompok
            $db = \Config\Database::connect();
            $kelompok_projects = [];
            foreach ($data['kelompok'] as $k) {
                $kelompok_projects[$k['id_kelompok_project']] = $db->table('kelompok_project_detail')
                    ->select('db_project.*, kelompok_project_detail.id_kelompok_project')
                    ->join('db_project', 'db_project.id_project = kelompok_project_detail.id_project')
                    ->where('kelompok_project_detail.id_kelompok_project', $k['id_kelompok_project'])
                    ->get()->getResultArray();
            }
            $data['kelompok_projects'] = $kelompok_projects;

            return view('rapor/kelompok_project', $data);
        }

        public function simpanKelompok()
        {
            $data = [
                'nama_kelompok' => $this->request->getPost('nama_kelompok'),
                'tingkat'       => $this->request->getPost('tingkat'),
                'fase'          => $this->request->getPost('fase'),
                'koordinator'   => $this->request->getPost('koordinator'),
            ];

            $kelompokModel = new \App\Models\KelompokModel();
            $kelompokModel->insert($data);

            return redirect()->back()->with('success', 'Data kelompok berhasil disimpan!');
        }

        public function updateKelompok($id_kelompok_project)
        {
            $data = [
                'nama_kelompok' => $this->request->getPost('nama_kelompok'),
                'tingkat'       => $this->request->getPost('tingkat'),
                'fase'          => $this->request->getPost('fase'),
                'koordinator'   => $this->request->getPost('koordinator'),
            ];
            $kelompokModel = new \App\Models\KelompokModel();
            $kelompokModel->update($id_kelompok_project, $data);

            return redirect()->back()->with('success', 'Data kelompok berhasil diupdate!');
        }

        
    // Tampilkan halaman Data Tujuan Pembelajaran (TP)
    public function data_tp()
    {
        return view('rapor/data_tp');
    }

    // Tampilkan halaman Mapping Tujuan Pembelajaran (TP)
    public function mapping_tp()
    {
        // Ambil daftar mapel dari tabel db_matpel
        $matpelModel = new \App\Models\MatpelModel();
        $daftar_mapel = $matpelModel->findAll();
        // Ambil daftar kelas/tingkat dari db_rombel (kelas 1-6 unik)
        $rombelModel = new \App\Models\RombelModel();
        $rombels = $rombelModel->findAll();
        // Ambil hanya angka tingkat dari field kelas (misal: 'Kelas 1' -> 1)
        $daftar_tingkat = [];
        foreach ($rombels as $r) {
            if (isset($r->kelas)) {
                if (preg_match('/(\d+)/', $r->kelas, $m)) {
                    $num = (int)$m[1];
                    if ($num >= 1 && $num <= 6 && !in_array($num, $daftar_tingkat)) {
                        $daftar_tingkat[] = $num;
                    }
                }
            }
        }
        sort($daftar_tingkat);
        return view('rapor/mapping_tp', [
            'daftar_mapel' => $daftar_mapel,
            'daftar_tingkat' => $daftar_tingkat
        ]);
    }
    
     // Halaman Status Penilaian
     public function status_penilaian()
     {
         $rombelModel = new \App\Models\RombelModel();
         $rombels = $rombelModel->findAll();
         return view('rapor/cek_penilaian/status_penilaian', [
             'rombels' => $rombels
         ]);
     }

     // Dashboard method (add this before the last closing bracket)
     public function dashboard()
     {
         // Dashboard Guru: gunakan view erapor.php
         return view('rapor/erapor');
     }
}
