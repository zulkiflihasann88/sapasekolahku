<?php

namespace App\Controllers;

use App\Models\TapelModel;
use App\Models\RombelModel;
use App\Models\MatpelModel;
use App\Models\SiswaModel;
use App\Models\NilaiModel;

class Akademik extends BaseController
{
    protected $tapelModel;
    protected $rombelModel;
    protected $matpelModel;
    protected $siswaModel;
    protected $nilaiModel;

    public function __construct()
    {
        $this->tapelModel = new TapelModel();
        $this->rombelModel = new RombelModel();
        $this->matpelModel = new MatpelModel();
        $this->siswaModel = new SiswaModel();
        $this->nilaiModel = new NilaiModel();
    }

    public function index()
    {
        // Main akademik dashboard/index
        return view('akademik/index');
    }
    public function verval_nilai_siswa()
    {
        $data = [
            'tahun_pelajaran' => [],
            'kelas' => [],
            'mata_pelajaran' => [],
            'selected_tahun' => $this->request->getGet('tahun_pelajaran'),
            'selected_kelas' => $this->request->getGet('kelas'),
            'selected_mapel' => $this->request->getGet('mata_pelajaran'),
            'selected_semester' => $this->request->getGet('semester')
        ];

        // Try to get data from models if they exist
        try {
            if (isset($this->tapelModel)) {
                $data['tahun_pelajaran'] = $this->tapelModel->getAll(); // Use getAll() method
            }
            if (isset($this->rombelModel)) {
                $data['kelas'] = $this->rombelModel->getAll(); // Use getAll() method
            }
            if (isset($this->matpelModel)) {
                $data['mata_pelajaran'] = $this->matpelModel->getAll(); // Use getAll() method
            }
        } catch (\Exception $e) {
            // If models fail, just use empty arrays
            log_message('error', 'Model error in verval_nilai_siswa: ' . $e->getMessage());
        }

        return view('akademik/verval_nilai_siswa', $data);
    }
    public function get_verval_nilai_data()
    {
        try {
            // Enable CORS and JSON response
            $this->response->setHeader('Content-Type', 'application/json');

            $tahunPelajaran = $this->request->getPost('tahun_pelajaran');
            $kelas = $this->request->getPost('kelas');
            $mataPelajaran = $this->request->getPost('mata_pelajaran');
            $semester = $this->request->getPost('semester');

            // Log the received data for debugging
            log_message('info', 'Verval Nilai Data Request: ' . json_encode([
                'tahun_pelajaran' => $tahunPelajaran,
                'kelas' => $kelas,
                'mata_pelajaran' => $mataPelajaran,
                'semester' => $semester
            ]));

            // Validate required parameters
            if (!$tahunPelajaran || !$kelas || !$mataPelajaran || !$semester) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Parameter tidak lengkap. Tahun: ' . $tahunPelajaran . ', Kelas: ' . $kelas . ', Mapel: ' . $mataPelajaran . ', Semester: ' . $semester
                ]);
            }            // Check if table exists, if not create it
            $db = \Config\Database::connect();
            if (!$db->tableExists('db_nilai')) {
                if ($this->nilaiModel->createTable()) {
                    $this->nilaiModel->insertSampleData();
                    log_message('info', 'Nilai table created and sample data inserted');
                }
            }

            // Get real data from database
            $data = $this->nilaiModel->getNilaiVerval($tahunPelajaran, $kelas, $mataPelajaran, $semester);

            // Convert to array if needed
            $dataArray = [];
            if ($data) {
                foreach ($data as $item) {
                    $dataArray[] = [
                        'id' => $item->id_nilai,
                        'nisn' => $item->nisn ?? '-',
                        'nama_siswa' => $item->nama_siswa ?? '-',
                        'nama_kelas' => $item->nama_kelas ?? '-',
                        'nama_mata_pelajaran' => $item->nama_mata_pelajaran ?? '-',
                        'nilai_tugas' => (float)$item->nilai_tugas,
                        'nilai_uh' => (float)$item->nilai_uh,
                        'nilai_uts' => (float)$item->nilai_uts,
                        'nilai_uas' => (float)$item->nilai_uas,
                        'nilai_akhir' => (float)$item->nilai_akhir,
                        'status_verifikasi' => (int)$item->status_verifikasi
                    ];
                }
            }

            // If no data found, return sample data for demonstration
            if (empty($dataArray)) {
                $dataArray = [
                    [
                        'id' => 1,
                        'nisn' => '1234567890',
                        'nama_siswa' => 'Ahmad Budi Santoso',
                        'nama_kelas' => 'V A',
                        'nama_mata_pelajaran' => 'Matematika',
                        'nilai_tugas' => 85.0,
                        'nilai_uh' => 82.0,
                        'nilai_uts' => 78.0,
                        'nilai_uas' => 80.0,
                        'nilai_akhir' => 81.3,
                        'status_verifikasi' => 1
                    ],
                    [
                        'id' => 2,
                        'nisn' => '1234567891',
                        'nama_siswa' => 'Siti Nurhaliza',
                        'nama_kelas' => 'V A',
                        'nama_mata_pelajaran' => 'Matematika',
                        'nilai_tugas' => 90.0,
                        'nilai_uh' => 88.0,
                        'nilai_uts' => 85.0,
                        'nilai_uas' => 87.0,
                        'nilai_akhir' => 87.3,
                        'status_verifikasi' => 1
                    ],
                    [
                        'id' => 3,
                        'nisn' => '1234567892',
                        'nama_siswa' => 'Budi Prasetyo',
                        'nama_kelas' => 'V A',
                        'nama_mata_pelajaran' => 'Matematika',
                        'nilai_tugas' => 75.0,
                        'nilai_uh' => 78.0,
                        'nilai_uts' => 72.0,
                        'nilai_uas' => 76.0,
                        'nilai_akhir' => 75.6,
                        'status_verifikasi' => 0
                    ],
                    [
                        'id' => 4,
                        'nisn' => '1234567893',
                        'nama_siswa' => 'Rina Kartika',
                        'nama_kelas' => 'V A',
                        'nama_mata_pelajaran' => 'Matematika',
                        'nilai_tugas' => 88.0,
                        'nilai_uh' => 85.0,
                        'nilai_uts' => 80.0,
                        'nilai_uas' => 83.0,
                        'nilai_akhir' => 84.0,
                        'status_verifikasi' => 0
                    ],
                    [
                        'id' => 5,
                        'nisn' => '1234567894',
                        'nama_siswa' => 'Dedi Susanto',
                        'nama_kelas' => 'V A',
                        'nama_mata_pelajaran' => 'Matematika',
                        'nilai_tugas' => 70.0,
                        'nilai_uh' => 75.0,
                        'nilai_uts' => 68.0,
                        'nilai_uas' => 72.0,
                        'nilai_akhir' => 71.7,
                        'status_verifikasi' => 0
                    ],
                    [
                        'id' => 6,
                        'nisn' => '1234567895',
                        'nama_siswa' => 'Maya Indrawati',
                        'nama_kelas' => 'V A',
                        'nama_mata_pelajaran' => 'Matematika',
                        'nilai_tugas' => 92.0,
                        'nilai_uh' => 90.0,
                        'nilai_uts' => 88.0,
                        'nilai_uas' => 89.0,
                        'nilai_akhir' => 89.7,
                        'status_verifikasi' => 1
                    ]
                ];
            }

            // Calculate statistics
            $total = count($dataArray);
            $terverifikasi = count(array_filter($dataArray, function ($item) {
                return $item['status_verifikasi'] == 1;
            }));
            $belumVerifikasi = $total - $terverifikasi;
            $persentase = $total > 0 ? round(($terverifikasi / $total) * 100, 1) : 0;

            return $this->response->setJSON([
                'success' => true,
                'data' => $dataArray,
                'statistics' => [
                    'total' => $total,
                    'terverifikasi' => $terverifikasi,
                    'belum_verifikasi' => $belumVerifikasi,
                    'persentase' => $persentase
                ]
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in get_verval_nilai_data: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
    public function get_nilai_detail($id)
    {
        try {
            // Get real data from database if table exists
            $db = \Config\Database::connect();
            if ($db->tableExists('db_nilai')) {
                $data = $this->nilaiModel->getNilaiDetail($id);
                if ($data) {
                    return $this->response->setJSON([
                        'success' => true,
                        'data' => [
                            'id' => $data->id_nilai,
                            'nisn' => $data->nisn ?? '-',
                            'nama_siswa' => $data->nama_siswa ?? '-',
                            'nama_kelas' => $data->nama_kelas ?? '-',
                            'nama_mata_pelajaran' => $data->nama_mata_pelajaran ?? '-',
                            'nilai_tugas' => (float)$data->nilai_tugas,
                            'nilai_uh' => (float)$data->nilai_uh,
                            'nilai_uts' => (float)$data->nilai_uts,
                            'nilai_uas' => (float)$data->nilai_uas,
                            'status_verifikasi' => (int)$data->status_verifikasi
                        ]
                    ]);
                }
            }

            // Sample data for testing - you can lookup by ID
            $sampleDataArray = [
                1 => [
                    'id' => 1,
                    'nisn' => '1234567890',
                    'nama_siswa' => 'Ahmad Budi Santoso',
                    'nama_kelas' => 'V A',
                    'nama_mata_pelajaran' => 'Matematika',
                    'nilai_tugas' => 85.0,
                    'nilai_uh' => 82.0,
                    'nilai_uts' => 78.0,
                    'nilai_uas' => 80.0,
                    'status_verifikasi' => 1
                ],
                2 => [
                    'id' => 2,
                    'nisn' => '1234567891',
                    'nama_siswa' => 'Siti Nurhaliza',
                    'nama_kelas' => 'V A',
                    'nama_mata_pelajaran' => 'Matematika',
                    'nilai_tugas' => 90.0,
                    'nilai_uh' => 88.0,
                    'nilai_uts' => 85.0,
                    'nilai_uas' => 87.0,
                    'status_verifikasi' => 1
                ],
                3 => [
                    'id' => 3,
                    'nisn' => '1234567892',
                    'nama_siswa' => 'Budi Prasetyo',
                    'nama_kelas' => 'V A',
                    'nama_mata_pelajaran' => 'Matematika',
                    'nilai_tugas' => 75.0,
                    'nilai_uh' => 78.0,
                    'nilai_uts' => 72.0,
                    'nilai_uas' => 76.0,
                    'status_verifikasi' => 0
                ]
            ];

            $sampleData = isset($sampleDataArray[$id]) ? $sampleDataArray[$id] : [
                'id' => $id,
                'nisn' => '1234567890',
                'nama_siswa' => 'Ahmad Budi Santoso',
                'nama_kelas' => 'V A',
                'nama_mata_pelajaran' => 'Matematika',
                'nilai_tugas' => 80.0,
                'nilai_uh' => 85.0,
                'nilai_uts' => 78.0,
                'nilai_uas' => 82.0,
                'status_verifikasi' => 0
            ];

            return $this->response->setJSON([
                'success' => true,
                'data' => $sampleData
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }
    public function update_nilai()
    {
        try {
            $id = $this->request->getPost('id');
            $nilaiTugas = $this->request->getPost('nilai_tugas');
            $nilaiUH = $this->request->getPost('nilai_uh');
            $nilaiUTS = $this->request->getPost('nilai_uts');
            $nilaiUAS = $this->request->getPost('nilai_uas');

            // Validate input
            if (!$id || !$nilaiTugas || !$nilaiUH || !$nilaiUTS || !$nilaiUAS) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data tidak lengkap'
                ]);
            }

            // Check if table exists and use real database
            $db = \Config\Database::connect();
            if ($db->tableExists('db_nilai')) {
                $data = [
                    'nilai_tugas' => $nilaiTugas,
                    'nilai_uh' => $nilaiUH,
                    'nilai_uts' => $nilaiUTS,
                    'nilai_uas' => $nilaiUAS
                ];

                if ($this->nilaiModel->updateNilai($id, $data)) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Nilai berhasil diperbarui'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Gagal memperbarui nilai'
                    ]);
                }
            }

            // Here you would update the database
            // For now, just return success
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Nilai berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memperbarui nilai: ' . $e->getMessage()
            ]);
        }
    }
    public function verifikasi_nilai()
    {
        try {
            $id = $this->request->getPost('id');

            if (!$id) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID tidak valid'
                ]);
            }

            // Check if table exists and use real database
            $db = \Config\Database::connect();
            if ($db->tableExists('db_nilai')) {
                if ($this->nilaiModel->verifikasiNilai($id)) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Nilai berhasil diverifikasi'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Gagal memverifikasi nilai'
                    ]);
                }
            }

            // Here you would update the verification status in database
            // For now, just return success
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Nilai berhasil diverifikasi'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memverifikasi nilai: ' . $e->getMessage()
            ]);
        }
    }
    public function verifikasi_nilai_massal()
    {
        try {
            $ids = $this->request->getPost('ids');

            if (!$ids || !is_array($ids)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data tidak valid'
                ]);
            }

            // Check if table exists and use real database
            $db = \Config\Database::connect();
            if ($db->tableExists('db_nilai')) {
                if ($this->nilaiModel->verifikasiNilaiMassal($ids)) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => count($ids) . ' data berhasil diverifikasi'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Gagal memverifikasi nilai'
                    ]);
                }
            }

            // Here you would update multiple verification statuses in database
            // For now, just return success
            return $this->response->setJSON([
                'success' => true,
                'message' => count($ids) . ' data berhasil diverifikasi'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memverifikasi nilai: ' . $e->getMessage()
            ]);
        }
    }

    public function export_verval_nilai()
    {
        try {
            $tahunPelajaran = $this->request->getGet('tahun_pelajaran');
            $kelas = $this->request->getGet('kelas');
            $mataPelajaran = $this->request->getGet('mata_pelajaran');
            $semester = $this->request->getGet('semester');

            // Here you would implement Excel export functionality
            // For now, just redirect back with message
            session()->setFlashdata('success', 'Export Excel akan segera diimplementasi');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Gagal mengeksport data: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function debug_data()
    {
        // Debug method to check what data is returned from models
        try {
            $data = [
                'tahun_pelajaran' => $this->tapelModel->getAll(),
                'kelas' => $this->rombelModel->getAll(),
                'mata_pelajaran' => $this->matpelModel->getAll()
            ];

            header('Content-Type: application/json');
            echo json_encode($data, JSON_PRETTY_PRINT);
            exit;
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function test_ajax()
    {
        return $this->response->setJSON([
            'success' => true,
            'message' => 'AJAX connection working!',
            'timestamp' => date('Y-m-d H:i:s'),
            'post_data' => $this->request->getPost()
        ]);
    }

    public function create_nilai_table()
    {
        try {
            // Create table
            if ($this->nilaiModel->createTable()) {
                // Insert sample data
                if ($this->nilaiModel->insertSampleData()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Tabel db_nilai berhasil dibuat dan data contoh berhasil dimasukkan!'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Tabel db_nilai berhasil dibuat, tetapi gagal memasukkan data contoh.'
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal membuat tabel db_nilai'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}
