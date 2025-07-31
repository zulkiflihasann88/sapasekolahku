<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\SiswaModel;
use App\Models\RombelModel;
use App\Models\TapelModel;
use App\Models\MutasiModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use Mpdf\Mpdf;

class Siswa extends ResourceController
{
    protected $peserta_didik;
    protected $agama;
    protected $rombel;
    protected $transport;
    protected $disability;
    protected $tinggal;
    protected $pekerjaan;
    protected $penghasilan;
    protected $pendidikan;
    protected $db;

    function __construct()
    {
        helper('tahun_ajaran'); // Load helper tahun ajaran
        $this->peserta_didik = new \App\Models\SiswaModel();
        $this->agama = class_exists('App\\Models\\AgamaModel') ? new \App\Models\AgamaModel() : null;
        $this->rombel = class_exists('App\\Models\\RombelModel') ? new \App\Models\RombelModel() : null;
        $this->transport = class_exists('App\\Models\\TransportasiModel') ? new \App\Models\TransportasiModel() : null;
        $this->disability = class_exists('App\\Models\\DisabilityModel') ? new \App\Models\DisabilityModel() : null;
        $this->tinggal = class_exists('App\\Models\\TinggalModel') ? new \App\Models\TinggalModel() : null;
        $this->pekerjaan = class_exists('App\\Models\\PekerjaanModel') ? new \App\Models\PekerjaanModel() : null;
        $this->penghasilan = class_exists('App\\Models\\PenghasilanModel') ? new \App\Models\PenghasilanModel() : null;
        $this->pendidikan = class_exists('App\\Models\\PendidikanModel') ? new \App\Models\PendidikanModel() : null;
        $this->db = db_connect();
    }
    public function index()
    {
        // Ambil semua id_siswa yang sudah mutasi
        $mutasiIds = $this->db->table('db_mutasi')->select('id_siswa')->get()->getResultArray();
        $ids = array_column($mutasiIds, 'id_siswa');

        // Gunakan helper untuk mendapatkan tahun ajaran yang tepat
        $id_tahun_ajaran = getCurrentTahunAjaran();

        // Pastikan tahun ajaran aktif digunakan jika tidak ada sesi
        if (!$id_tahun_ajaran) {
            // Dapatkan tahun ajaran aktif dari database dan simpan ke session
            $tapelModel = new \App\Models\TapelModel();
            $active_year = $tapelModel->getActiveLatest();
            if ($active_year) {
                $id_tahun_ajaran = $active_year->id_tahun_ajaran;
                session()->set('id_tahun_ajaran_aktif', $id_tahun_ajaran);
                session()->set('id_tahun_ajaran_view', $id_tahun_ajaran);
            }
        }

        // Ambil filter kelas dari request
        $filter_kelas = $this->request->getGet('filter_kelas');

        // Ambil siswa yang id-nya tidak ada di db_mutasi dan hanya untuk tahun ajaran yang sedang dilihat
        $peserta_didik = $this->peserta_didik->getAllWithFilter($ids, $id_tahun_ajaran, $filter_kelas);

        // Ambil daftar kelas untuk filter dropdown berdasarkan tahun ajaran yang sedang dilihat
        $daftar_kelas = [];

        if ($id_tahun_ajaran) {
            $rombel_list = $this->db->table('db_rombel')
                ->select('kelas, rombel')
                ->where('id_tahun', $id_tahun_ajaran)
                ->orderBy('kelas', 'ASC')
                ->orderBy('rombel', 'ASC')
                ->get()->getResult();

            foreach ($rombel_list as $rombel) {
                $key = $rombel->kelas . '|' . $rombel->rombel;
                $label = $rombel->kelas . ' - ' . $rombel->rombel;
                $daftar_kelas[$key] = $label;
            }
        }

        return view('peserta didik/index', compact('peserta_didik', 'daftar_kelas'));
    }


    public function new()
    {
        $siswaModel = new SiswaModel();
        $data['nis'] = $siswaModel->generateCode(); // Generate the NIS code
        $data['db_siswa'] = $this->peserta_didik->findAll();
        $data['agama'] = $this->agama->findAll();
        $data['tinggal'] = $this->tinggal->findAll();
        $data['transport'] = $this->transport->findAll();
        $data['disability'] = $this->disability->findAll();
        $data['pekerjaan'] = $this->pekerjaan->findAll();
        $data['penghasilan'] = $this->penghasilan->findAll();
        $data['pendidikan'] = $this->pendidikan->findAll();
        $data['rombel'] = $this->rombel->findAll(); // Add rombel data for dropdown
        return view('peserta didik/new', $data);
    }
    public function create()
    {
        $data = $this->request->getPost();

        // If the NIS is not provided or empty, generate it based on student type
        if (empty($data['nis'])) {
            $siswaModel = new SiswaModel();

            // Check if this is a new class 1 student
            $isNewClass1Student = false;
            if (isset($data['id_rombel_masuk'])) {
                $rombelInfo = $this->db->table('db_rombel')->where('id_rombel', $data['id_rombel_masuk'])->get()->getRow();
                if ($rombelInfo && (trim($rombelInfo->kelas) === '1' || trim($rombelInfo->kelas) === 'I')) {
                    $isNewClass1Student = true;
                }
            }

            // Check if this is a transfer student
            $isTransferStudent = false;
            $entryDate = null;
            if (isset($data['asal_sekolah']) && !empty($data['asal_sekolah'])) {
                $isTransferStudent = true;
                $entryDate = isset($data['tanggal_diterima']) ? $data['tanggal_diterima'] : date('Y-m-d');
            }

            // Generate NIS with appropriate parameters
            $data['nis'] = $siswaModel->generateNIS(
                $isNewClass1Student,           // Is new class 1 student?
                $isTransferStudent,            // Is transfer student?
                $data['nama_siswa'] ?? '',     // Student name for alphabetical ordering
                $entryDate                     // Entry date for transfer students
            );
        }
        if ($this->peserta_didik->insert($data)) {
            // Kirim notifikasi WhatsApp dengan template dari menu WA Gateway
            $nama = $data['nama_siswa'] ?? '';
            $nis = $data['nis'] ?? '';
            $nomor_hp = $data['telephone'] ?? '';
            $no_pendaftaran = $data['nis'] ?? '';
            $pesan = null;
            // Ambil template pesan dari file JS wa_gateway (atau bisa dari DB jika sudah disimpan di DB)
            // Fallback template jika tidak ada di DB
            $template = "Halo,Orang Tua Murid! *{nama}*,\n\nTerimakasih! telah melakukan pendaftaran sebagai calon peserta didik baru di SD Negeri Krengseng 02.\nNomor Pendaftaran : *{no_pendaftaran}*\n\nSilakan pantau perkembangan registrasi ananda melalui link www.spmb.sdnkrengseng02.sch.id dengan mencari nama peserta didik.\n\nTerima kasih.\nAdmin SPMB";
            $pesan = str_replace(['{nama}', '{no_pendaftaran}'], [$nama, $no_pendaftaran], $template);
            if ($nomor_hp && strlen($nomor_hp) > 8) {
                try {
                    $client = \Config\Services::curlrequest();
                    $client->setHeader('Content-Type', 'application/x-www-form-urlencoded');
                    $client->post(site_url('wa_gateway/sendMessage'), [
                        'number' => $nomor_hp,
                        'message' => $pesan,
                    ]);
                } catch (\Throwable $e) {
                    log_message('error', 'Gagal kirim WA: ' . $e->getMessage());
                }
            }
            return redirect()->to('peserta_didik')->with('success', 'Siswa berhasil ditambahkan & notifikasi dikirim');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan siswa');
        }
    }

    public function edit($id = null)
    {
        try {
            // Ambil data siswa beserta nama_rombel dan relasi lengkap (menggunakan getSiswaById)
            // Don't pass any tahun_ajaran parameter to avoid the column not found error
            $peserta_didik = $this->peserta_didik->getSiswaById($id);

            if (is_object($peserta_didik)) {
                // Kompatibilitas: cek semua kemungkinan nama field id tahun ajaran
                $tahun_ajaran_aktif = null;
                $siswaArr = get_object_vars($peserta_didik);

                // Check for different possible field names
                if (!empty($siswaArr['id_tahun_ajaran'])) {
                    $tahun_ajaran_aktif = $siswaArr['id_tahun_ajaran'];
                } elseif (!empty($siswaArr['id_tapel'])) {
                    $tahun_ajaran_aktif = $siswaArr['id_tapel'];
                } elseif (!empty($siswaArr['id_tahun'])) {
                    $tahun_ajaran_aktif = $siswaArr['id_tahun'];
                }

                // If no tahun ajaran found in student record, try to get it from session
                if ($tahun_ajaran_aktif === null) {
                    $tahun_ajaran_aktif = getCurrentTahunAjaran();
                }

                $data = [
                    'peserta_didik' => $peserta_didik,
                    'agama' => $this->agama->findAll(),
                    'rombel' => $this->rombel->findAll(),
                    'transport' => $this->transport->findAll(),
                    'disability' => $this->disability->findAll(),
                    'tinggal' => $this->tinggal->findAll(),
                    'pekerjaan' => $this->pekerjaan->findAll(),
                    'penghasilan' => $this->penghasilan->getAll(),
                    'pendidikan' => $this->pendidikan->findAll(),
                    // Tambahkan tahun ajaran aktif dan list tahun ajaran
                    'tahun_ajaran_aktif' => $tahun_ajaran_aktif,
                    'list_tahun_ajaran' => (new TapelModel())->findAll(),
                ];
                return view('peserta didik/edit', $data);
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        } catch (\Exception $e) {
            // Log error for debugging
            log_message('error', 'Error in Siswa::edit: ' . $e->getMessage());

            // Fall back to simpler query if we hit database issues
            $peserta_didik = $this->peserta_didik->find($id);
            if ($peserta_didik) {
                $data = [
                    'peserta_didik' => $peserta_didik,
                    'agama' => $this->agama->findAll(),
                    'rombel' => $this->rombel->findAll(),
                    'transport' => $this->transport->findAll(),
                    'disability' => $this->disability->findAll(),
                    'tinggal' => $this->tinggal->findAll(),
                    'pekerjaan' => $this->pekerjaan->findAll(),
                    'penghasilan' => $this->penghasilan->getAll(),
                    'pendidikan' => $this->pendidikan->findAll(),
                    'tahun_ajaran_aktif' => getCurrentTahunAjaran(),
                    'list_tahun_ajaran' => (new TapelModel())->findAll(),
                ];
                return view('peserta didik/edit', $data);
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        }
    }

    public function update($id = null)
    {
        try {
            $data = $this->request->getPost();

            // Kompatibilitas: cek semua kemungkinan nama field id tahun ajaran dari input
            $id_tahun_ajaran = $data['id_tahun_ajaran'] ?? $data['id_tapel'] ?? $data['id_tahun'] ?? null;

            if (!$id_tahun_ajaran) {
                // fallback: ambil tahun ajaran aktif dari model jika ada
                $tapelModel = new \App\Models\TapelModel();
                $tahunAktif = $tapelModel->getActiveLatest();
                $tahunAktifArr = $tahunAktif ? get_object_vars($tahunAktif) : [];

                if (!empty($tahunAktifArr['id_tahun_ajaran'])) {
                    $id_tahun_ajaran = $tahunAktifArr['id_tahun_ajaran'];
                } elseif (!empty($tahunAktifArr['id_tapel'])) {
                    $id_tahun_ajaran = $tahunAktifArr['id_tapel'];
                } elseif (!empty($tahunAktifArr['id'])) {
                    $id_tahun_ajaran = $tahunAktifArr['id'];
                } elseif (!empty($tahunAktifArr['id_tahun'])) {
                    $id_tahun_ajaran = $tahunAktifArr['id_tahun'];
                }
            }

            // Check which column name is used in the db_siswa table for tahun ajaran
            $tahun_ajaran_column = 'id_tahun_ajaran'; // default

            // Check if the id_tahun_ajaran column exists
            $fields = $this->db->getFieldData('db_siswa');
            $column_exists = false;

            foreach ($fields as $field) {
                if ($field->name === 'id_tahun_ajaran') {
                    $column_exists = true;
                    $tahun_ajaran_column = 'id_tahun_ajaran';
                    break;
                } elseif ($field->name === 'id_tapel') {
                    $column_exists = true;
                    $tahun_ajaran_column = 'id_tapel';
                    break;
                } elseif ($field->name === 'id_tahun') {
                    $column_exists = true;
                    $tahun_ajaran_column = 'id_tahun';
                    break;
                }
            }

            // Cek apakah data siswa untuk tahun ajaran ini sudah ada (NIS/NISN)
            $existing = $this->peserta_didik->getByNisOrNisnAndTahunAjaran(
                $data['nis'],
                $data['nisn'] ?? null,
                $id_tahun_ajaran,
                $tahun_ajaran_column
            );

            if ($existing) {
                // Update hanya data di tahun ajaran ini
                $idSiswa = is_array($existing) ? $existing['id_siswa'] : $existing->id_siswa;
                $save = $this->peserta_didik->update($idSiswa, $data);
            } else {
                // Insert data baru untuk tahun ajaran baru
                // Only add tahun ajaran data if the column exists
                if ($column_exists) {
                    $data[$tahun_ajaran_column] = $id_tahun_ajaran;
                }
                $save = $this->peserta_didik->insert($data);
            }
        } catch (\Exception $e) {
            // Log error for debugging
            log_message('error', 'Error in Siswa::update: ' . $e->getMessage());

            // Simplify the update if we encounter errors
            $save = $this->peserta_didik->update($id, $data);
        }

        // Jika siswa keluar karena mutasi, pindahkan ke tabel db_mutasi
        if (isset($data['keluar_karena']) && $data['keluar_karena'] === 'Mutasi') {
            $mutasiModel = new \App\Models\MutasiModel();
            // Cek apakah sudah ada data mutasi untuk siswa ini agar tidak double
            $existingMutasi = $mutasiModel->where('id_siswa', $id)->first();
            if (!$existingMutasi) {
                $mutasiModel->insert([
                    'id_siswa' => $id,
                    'tanggal_mutasi' => $data['tanggal_keluar'] ?? date('Y-m-d'),
                    'alasan_mutasi' => $data['alasan_keluar'] ?? '',
                    'tujuan_mutasi' => $data['tujuan_mutasi'] ?? '',
                    'keterangan' => 'Mutasi dari menu keluar',
                ]);
                // Notifikasi sukses mutasi
                return redirect()->to(site_url('peserta_didik'))->with('success', 'Siswa sudah dimutasi dan dipindahkan ke menu Mutasi.');
            }
        }

        if (!$save) {
            return redirect()->back()->withInput()->with('errors', $this->peserta_didik->errors());
        } else {
            return redirect()->to(site_url('peserta_didik'))->with('success', 'Data Berhasil Diupdate');
        }
    }

    public function delete($id = null)
    {
        // Hapus data terkait di db_siswa_semester_history sebelum menghapus siswa
        $db = \Config\Database::connect();
        if ($id) {
            $db->table('db_siswa_semester_history')->where('id_siswa', $id)->delete();
        }
        $this->peserta_didik->delete($id);
        return redirect()->to(site_url('peserta_didik'))->with('success', 'Data Berhasil Dihapus');
    }

    // public function preview($id = null)
    // {
    //     $peserta_didik = $this->peserta_didik->getSiswaById($id);
    //     if (is_object($peserta_didik)) {
    //         $data['peserta_didik'] = $peserta_didik;
    //         return view('surat masuk/preview', $data);
    //     } else {
    //         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    //     }
    // }
    function kode()
    {
        return json_encode($this->peserta_didik->generateCode());
    }

    public function previewPdf($id)
    {
        $peserta_didik = $this->peserta_didik->find($id);
        if (is_object($peserta_didik)) {
            $filePath = ROOTPATH . 'public/uploads/dokumen_in/' . $peserta_didik->file_pdf;
            if (!file_exists($filePath)) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException("File not found: " . $peserta_didik->file_pdf);
            }

            return $this->response->setHeader('Content-Type', 'application/pdf')
                ->setHeader('Content-Disposition', 'inline; filename="' . $peserta_didik->file_pdf . '"')
                ->setBody(file_get_contents($filePath));
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Surat not found: " . $id);
        }
    }

    public function validasiSiswaTanpaKelas()
    {
        $model = new SiswaModel();
        $rombel = new RombelModel();
        // Ambil semua id_siswa yang sudah mutasi
        $mutasiIds = $this->db->table('db_mutasi')->select('id_siswa')->get()->getResultArray();
        $excludeIds = array_column($mutasiIds, 'id_siswa');
        $data['siswa_tanpa_kelas'] = $model->getSiswaTanpaKelas($excludeIds);
        $data['siswa_lulus'] = $model->getCalonSiswaLulus(); // Ambil siswa lulus dari db_calonpeserta
        $data['rombels'] = $rombel->findAll();
        return view('peserta didik/validasi_pd', $data);
    }

    public function SiswaNaikkelas()
    {
        $model = new SiswaModel();
        $rombel = new RombelModel();
        $tapel = new TapelModel();
        // Ambil semua id_siswa yang sudah mutasi
        $mutasiIds = $this->db->table('db_mutasi')->select('id_siswa')->get()->getResultArray();
        $excludeIds = array_column($mutasiIds, 'id_siswa');
        $data['siswa_perkelas'] = $model->getSiswaPerkelas($excludeIds);
        $data['rombels'] = $rombel->findAll(); // Fetch class data
        $data['tapel'] = $tapel->findAll(); // Fetch class data
        return view('peserta didik/siswa_naik', $data);
    }

    public function getSiswaByKelas($id_rombel)
    {
        $model = new SiswaModel();
        // Ambil semua id_siswa yang sudah mutasi
        $mutasiIds = $this->db->table('db_mutasi')->select('id_siswa')->get()->getResultArray();
        $excludeIds = array_column($mutasiIds, 'id_siswa');
        $siswa = $model->getSiswaByKelas($id_rombel, $excludeIds);
        return $this->response->setJSON($siswa);
    }

    public function updateClass($id)
    {
        $model = new SiswaModel();
        $data = [
            'id_rombel' => $this->request->getPost('id_rombel')
        ];
        if ($model->update($id, $data)) {
            return redirect()->to(site_url('validasi_pd'))->with('success', 'Kelas berhasil diperbarui');
        } else {
            return redirect()->to(site_url('validasi_pd'))->with('error', 'Gagal memperbarui kelas');
        }
    }

    public function import_excel()
    {
        $file = $this->request->getFile('excelFile');
        if ($file->isValid() && !$file->hasMoved()) {
            $filePath = WRITEPATH . 'uploads/' . $file->store();
            // Load the spreadsheet library and process the file
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            // Ambil tahun ajaran aktif dari input (kompatibel semua field id)
            $id_tahun_ajaran = $this->request->getPost('id_tahun_ajaran')
                ?? $this->request->getPost('id_tahun_ajaran')
                ?? $this->request->getPost('id_tapel')
                ?? $this->request->getPost('id');
            if (!$id_tahun_ajaran) {
                // fallback: ambil tahun ajaran aktif dari model jika ada
                $tapelModel = new \App\Models\TapelModel();
                $tahunAktif = $tapelModel->getActiveLatest();
                $tahunAktifArr = $tahunAktif ? get_object_vars($tahunAktif) : [];
                if (!empty($tahunAktifArr['id_tahun_ajaran'])) {
                    $id_tahun_ajaran = $tahunAktifArr['id_tahun_ajaran'];
                } elseif (!empty($tahunAktifArr['id_tahun_ajaran'])) {
                    $id_tahun_ajaran = $tahunAktifArr['id_tahun_ajaran'];
                } elseif (!empty($tahunAktifArr['id_tapel'])) {
                    $id_tahun_ajaran = $tahunAktifArr['id_tapel'];
                } elseif (!empty($tahunAktifArr['id'])) {
                    $id_tahun_ajaran = $tahunAktifArr['id'];
                }
            }

            foreach ($sheetData as $row) {
                // Skip the header row
                if ($row[0] == 'No') {
                    continue;
                }
                // Validate the required fields
                if (empty($row[2])) { // Check if 'nis' is empty
                    continue; // Skip the row if 'nis' is null
                }

                // Prepare the data
                // Kompatibilitas: masukkan semua kemungkinan nama field id tahun ajaran
                $data = [
                    'nama_siswa' => $row[1],
                    'nis' => $row[2],
                    'jk' => $row[3],
                    'nisn' => $row[4],
                    'tempat_lahir' => $row[5],
                    'tanggal_lahir' => date('Y-m-d', strtotime($row[6])),
                    'nik' => $row[7],
                    'nama_agama' => $row[8],
                    'alamat' => $row[9],
                    'rt' => $row[10],
                    'rw' => $row[11],
                    // Add other fields as necessary
                    'id_tahun_ajaran' => $id_tahun_ajaran,
                    'id_tapel' => $id_tahun_ajaran,
                    // Jangan isi 'id' secara manual!
                ];

                // Cek apakah sudah ada data siswa dengan nis/nisn dan tahun ajaran ini
                $existingRecord = $this->peserta_didik->getByNisOrNisnAndTahunAjaran($row[2], $row[4], $id_tahun_ajaran, 'id_tahun_ajaran');

                if ($existingRecord) {
                    // Update data siswa untuk tahun ajaran ini
                    $idSiswa = is_array($existingRecord) ? $existingRecord['id_siswa'] : $existingRecord->id_siswa;
                    $this->peserta_didik->update($idSiswa, $data);
                } else {
                    // Insert data baru (duplikasi untuk tahun ajaran baru)
                    $this->peserta_didik->insert($data);
                }
            }

            return redirect()->to(site_url('peserta_didik'))->with('success', 'Data berhasil diimport.');
        }

        return redirect()->to(site_url('peserta_didik'))->with('error', 'Gagal mengupload file.');
    }

    public function exportPdf()
    {
        // Load the data you want to export
        $peserta_didik = $this->peserta_didik->findAll();

        // Initialize Dompdf
        $options = new Options();
        $options->set('enabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Load the view and pass the data
        $html = view('peserta didik/cetak_siswa', ['peserta_didik' => $peserta_didik]);

        // Load HTML content into Dompdf
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("peserta_didik.pdf", array("Attachment" => 0));
    }

    public function cetakPdf($id_siswa)
    {
        // Ambil data siswa beserta relasi (join), agar field seperti agama, rombel, dsb tersedia
        $siswa = $this->peserta_didik->getSiswaById($id_siswa);
        if (!$siswa) {
            return redirect()->to('peserta_didik')->with('error', 'Data siswa belum lengkap');
        }
        $mpdf = new Mpdf([
            'format'        => [210, 330],
            'margin_left'   => 14,
            'margin_right'  => 14,
            'margin_top'    => 5,
            'margin_bottom' => 5,
            'margin_header' => 10,
            'margin_footer' => 5
        ]);
        $mpdf->SetHTMLFooter('
    <table width="100%" style="font-size: 10px">
        <tr>
            <td width="33%"><i>Pusat Data Siswa SDN Krengseng 02</i></td>
            <td width="33%" align="right">Halaman {PAGENO}/{nb}</td>
        </tr>
    </table>
');
        $html = view('peserta didik/cetak_detail', ['siswa' => $siswa]);
        $mpdf->WriteHTML($html);
        $this->response->setContentType('application/pdf');
        $mpdf->Output('Laporan_Siswa.pdf', 'I');
    }
    public function lulusan()
    {
        $model = new SiswaModel();
        $rombel = new RombelModel();
        $tapel = new TapelModel();
        // Ambil semua id_siswa yang sudah mutasi
        $mutasiIds = $this->db->table('db_mutasi')->select('id_siswa')->get()->getResultArray();
        $excludeIds = array_column($mutasiIds, 'id_siswa');
        $data['siswa_kelas_akhir'] = $model->getSiswaAkhir($excludeIds);
        $data['rombels'] = $rombel->findAll();
        $data['tapel'] = $tapel->findAll();
        return view('peserta didik/lulusan', $data);
    }

    // Proses naik kelas massal


    public function naikKelas()
    {
        $siswaIds = $this->request->getPost('siswa');
        $kelasBaru = $this->request->getPost('kelas_baru');
        $tahunAjaranBaru = $this->request->getPost('tahun_ajaran_baru');

        if (!$siswaIds || !$kelasBaru || !$tahunAjaranBaru) {
            return redirect()->back()->with('error', 'Data tidak lengkap. Pilih siswa, kelas, dan tahun ajaran.');
        }

        $model = new SiswaModel();
        $updated = 0;
        foreach ($siswaIds as $id) {
            // Kompatibilitas: gunakan semua kemungkinan nama field id tahun ajaran
            $data = [
                'id_rombel' => $kelasBaru,
                'id_tahun_ajaran' => $tahunAjaranBaru,
                'id_tahun_ajaran' => $tahunAjaranBaru,
                'id_tapel' => $tahunAjaranBaru,
                'id' => $tahunAjaranBaru
            ];
            if ($model->update($id, $data)) {
                $updated++;
            }
        }

        if ($updated > 0) {
            return redirect()->to(site_url('siswa_naik'))->with('success', 'Siswa berhasil dinaikkan ke kelas dan tahun ajaran baru.');
        } else {
            return redirect()->back()->with('error', 'Tidak ada siswa yang berhasil diproses.');
        }
    }


    public function prosesLulus()
    {
        $siswaIds = $this->request->getPost('siswa');
        $statusKelulusan = $this->request->getPost('status_kelulusan');
        $tanggalKelulusan = $this->request->getPost('tanggal_kelulusan');
        $tahunAjaran = $this->request->getPost('tahun_ajaran');

        if (!$siswaIds || !$statusKelulusan || !$tanggalKelulusan || !$tahunAjaran) {
            return redirect()->back()->with('error', 'Data tidak lengkap. Pilih siswa, status kelulusan, tanggal, dan tahun ajaran.');
        }

        $model = new \App\Models\SiswaModel();
        $updated = 0;
        foreach ($siswaIds as $id) {
            $data = [
                'status_kelulusan' => $statusKelulusan,
                'tanggal_kelulusan' => $tanggalKelulusan,
                'id_tahun_lulus' => $tahunAjaran
            ];
            if ($model->update($id, $data)) {
                $updated++;
                // Jika siswa dinyatakan lulus, masukkan ke validasi siswa tanpa kelas (reset id_rombel)
                if (strtolower($statusKelulusan) === 'lulus') {
                    $model->update($id, ['id_rombel' => null]);
                }
            }
        }

        if ($updated > 0) {
            return redirect()->to(site_url('validasi_pd'))->with('success', 'Siswa berhasil diluluskan dan masuk ke menu validasi.');
        } else {
            return redirect()->back()->with('error', 'Tidak ada siswa yang berhasil diluluskan.');
        }
    }

    // Halaman mutasi siswa
    public function mutasiSiswa()
    {
        // Ambil data siswa mutasi dari tabel db_mutasi (join ke db_siswa dan db_rombel untuk detail kelas/rombel)
        $db = \Config\Database::connect();
        $siswa_mutasi = $db->table('db_mutasi')
            ->select('db_mutasi.*, db_siswa.nama_siswa, db_siswa.nisn, db_siswa.nis, db_siswa.jk, db_siswa.id_rombel, db_rombel.kelas, db_rombel.rombel, db_siswa.tanggal_keluar')
            ->join('db_siswa', 'db_siswa.id_siswa = db_mutasi.id_siswa')
            ->join('db_rombel', 'db_rombel.id_rombel = db_siswa.id_rombel', 'left')
            ->where('db_mutasi.alasan_mutasi !=', 'Lulus')
            ->get()->getResult();
        $rombels = $this->rombel->findAll();
        $tapel = (new TapelModel())->findAll();
        return view('peserta didik/mutasi_siswa', [
            'siswa_mutasi' => $siswa_mutasi,
            'rombels' => $rombels,
            'tapel' => $tapel,
        ]);
    }
    public function import_register()
    {
        $data = $this->request->getPost();
        // Paksa ambil tanggal_pendaftaran dari POST (agar update selalu sesuai input user)
        $data['tanggal_pendaftaran'] = $this->request->getPost('tanggal_pendaftaran') ?: date('Y-m-d');
        $nis = isset($data['nis']) ? $data['nis'] : null;
        $existing = null;
        if ($nis) {
            $existing = $this->peserta_didik->where('nis', $nis)->first();
        }

        // Proses mutasi jika trigger_mutasi=1
        if (isset($data['trigger_mutasi']) && $data['trigger_mutasi'] == '1' && $existing && (isset($existing['id_siswa']) || isset($existing->id_siswa))) {
            $mutasiModel = new \App\Models\MutasiModel();
            $id_siswa = is_array($existing) ? $existing['id_siswa'] : $existing->id_siswa;
            // Cek apakah sudah ada data mutasi untuk siswa ini
            $sudah_mutasi = $mutasiModel->where('id_siswa', $id_siswa)->first();
            if (!$sudah_mutasi) {
                $mutasiModel->insert([
                    'id_siswa' => $id_siswa,
                    'tanggal_mutasi' => $data['tanggal_keluar'] ?? date('Y-m-d'),
                    'alasan_mutasi' => $data['alasan_keluar'] ?? '',
                    'tujuan_mutasi' => $data['tujuan_mutasi'] ?? '',
                    'keterangan' => 'Mutasi dari menu registrasi',
                ]);
            }
            return redirect()->to('peserta_didik')->with('success', 'Siswa berhasil dimutasi dan dipindahkan ke menu Mutasi.');
        }

        // Proses update/insert biasa
        if ($existing && (isset($existing['id_siswa']) || isset($existing->id_siswa))) {
            // Update jika sudah ada
            $idSiswa = is_array($existing) ? $existing['id_siswa'] : $existing->id_siswa;
            if ($this->peserta_didik->update($idSiswa, $data)) {
                return redirect()->to('peserta_didik')->with('success', 'Data siswa berhasil diupdate.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data siswa');
            }
        } else {
            // Insert jika belum ada
            if ($this->peserta_didik->insert($data)) {
                return redirect()->to('peserta_didik')->with('success', 'Siswa berhasil ditambahkan (Tanggal: ' . $data['tanggal_pendaftaran'] . ')');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menambahkan siswa');
            }
        }
    }
    /**
     * Cetak PDF Surat Keterangan Mutasi Siswa (mPDF)
     */
    public function cetakMutasi($id_mutasi)
    {
        $siswa = new MutasiModel();
        $data['mutasi'] = $siswa->getMutasiBySiswa($id_mutasi);

        if (!$data['mutasi']) {
            return redirect()->to('peserta_didik')->with('error', 'Data siswa belum lengkap');
        }
        $mpdf = new Mpdf([
            'format'        => [215, 330],
            'margin_left'   => 10,
            'margin_right'  => 10,
            'margin_top'    => 10,  // Sesuaikan untuk memberi ruang ke header
            'margin_bottom' => 5,  // Sesuaikan untuk footer
            'margin_header' => 10,
            'margin_footer' => 5
        ]);
        $tanggalSekarang = date('j F Y');
        $namaAdmin = 'AFIK ROFIKAN'; // Ganti sesuai kebutuhan jika ingin dinamis
        $mpdf->SetHTMLFooter('
        <table width="100%" style="font-size: 10px">
            <tr>
                <td width="33%"><i>Diunduh dari sistem sapa sekolahku pada ' . $tanggalSekarang . ' oleh ' . $namaAdmin . '</i></td>
                <td width="33%" align="right">Halaman {PAGENO}/{nb}</td>
            </tr>
        </table>
    ');
        $html = view('peserta didik/cetak_mutasi', $data);
        $mpdf->WriteHTML($html);


        // Tampilkan PDF di browser
        $this->response->setContentType('application/pdf');
        $mpdf->Output('Laporan_Siswa.pdf', 'I'); // 'I' = tampil, 'D' = download
    }

    /**
     * Halaman Nilai (bukan nilai rapor)
     */
    public function nilai()
    {
        // Ambil data rombel dari model
        $rombelModel = new \App\Models\RombelModel();
        $rombels = $rombelModel->findAll();
        return view('peserta didik/nilai', [
            'rombels' => $rombels
        ]);
    }

    public function mutasi()
    {
        $data = $this->request->getPost();
        $nis = isset($data['nis']) ? $data['nis'] : null;
        $existing = null;
        if ($nis) {
            $existing = $this->peserta_didik->where('nis', $nis)->first();
        }

        // Proses mutasi jika data valid
        if ($existing && isset($existing->id_siswa)) {
            $mutasiModel = new \App\Models\MutasiModel();
            $id_siswa = $existing->id_siswa;
            // Cek apakah sudah ada data mutasi untuk siswa ini
            $sudah_mutasi = $mutasiModel->where('id_siswa', $id_siswa)->first();
            if (!$sudah_mutasi) {
                $mutasiModel->insert([
                    'id_siswa' => $id_siswa,
                    'tanggal_mutasi' => $data['tanggal_keluar'] ?? date('Y-m-d'),
                    'alasan_mutasi' => $data['alasan_keluar'] ?? '',
                    'tujuan_mutasi' => $data['tujuan_mutasi'] ?? '',
                    'keterangan' => 'Mutasi',
                ]);
                // Update status siswa
                $this->peserta_didik->update($id_siswa, [
                    'keluar_karena' => 'Mutasi',
                    'tanggal_keluar' => $data['tanggal_keluar'] ?? date('Y-m-d'),
                    'alasan_keluar' => $data['alasan_keluar'] ?? '',
                    'tujuan_mutasi' => $data['tujuan_mutasi'] ?? ''
                ]);
            }
            session()->setFlashdata('success', 'Mutasi berhasil diproses dan data siswa dipindahkan ke menu PD Keluar/Mutasi.');
            return redirect()->to(site_url('mutasi_siswa'));
        } else {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to(site_url('peserta_didik'));
        }
    }
}
