<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\SiswaModel;
use App\Models\RombelModel;
use App\Models\SpmbModel;
use App\Services\WhatsAppService;
use Mpdf\Mpdf;
use DateTime;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Spmb extends ResourceController
{

    protected $calon_siswa;
    protected $penerimaan;
    protected $rombel;
    protected $transport;
    protected $disability;
    protected $tinggal;
    protected $ayah;
    protected $db;
    protected $agama;
    protected $pekerjaan;
    protected $penghasilan;
    protected $pendidikan;

    function __construct()
    {
        $this->calon_siswa = model('SpmbModel');
        $this->penerimaan = model('TpenerimaanModel');
        $this->rombel = model('RombelModel');
        $this->transport = model('TransportasiModel');
        $this->disability = model('DisabilityModel');
        $this->tinggal = model('TinggalModel');
        $this->ayah = model('AyahModel');
        $this->db = db_connect();
        $this->agama = model('AgamaModel');
        $this->pekerjaan = model('PekerjaanModel');
        $this->penghasilan = model('PenghasilanModel');
        $this->pendidikan = model('PendidikanModel');
    }

    public function index()
    {
        $calon_siswa = $this->calon_siswa->getAll();
        return view('calon_siswa/index', compact('calon_siswa'));
    }
    public function show($id = null)
    {
        if (empty($id) || !is_numeric($id) || (int)$id < 1) {
            // Redirect ke halaman utama jika akses show tanpa ID valid
            return redirect()->to('calon_siswa')->with('error', 'ID tidak valid');
        }
        $model = new \App\Models\SpmbModel();
        $data = $model->find($id);
        if (!$data) {
            return redirect()->to('calon_siswa')->with('error', 'Data tidak ditemukan');
        }
        return $this->response->setJSON($data);
    }

    public function new()
    {
        $data = [];
        $data['db_siswa'] = $this->calon_siswa->findAll();
        $data['agama'] = $this->db->table('db_agama')->get()->getResult();
        $data['tinggal'] = $this->db->table('db_tempat_tinggal')->get()->getResult();
        $data['transport'] = $this->db->table('db_transportasi')->get()->getResult();
        $data['disability'] = $this->db->table('db_disability')->get()->getResult();
        $data['pendidikan'] = $this->db->table('db_pendidikan')->get()->getResult();
        $data['pekerjaan'] = $this->db->table('db_pekerjaan')->get()->getResult();
        $data['penghasilan'] = $this->db->table('db_penghasilan')->get()->getResult();
        $data['registration_number'] = $this->generateRegistrationNumber();
        // Ambil tahun penerimaan aktif (status_tahun = 'Aktif')
        $tahunAktif = $this->penerimaan->where('status_tahun', 'Aktif')->orderBy('id_tahun', 'DESC')->first();
        $data['tahun_aktif'] = $tahunAktif;
        return view('calon_siswa/new', $data);
    }

    private function generateRegistrationNumber()
    {
        $date = date('Ymd'); // Current date in YYYYMMDD format
        $randomDigits = rand(10000, 99999); // Generate 5 random digits
        return $date . $randomDigits;
    }
    public function create()
    {
        $data = $this->request->getPost();

        // Validasi dan normalisasi field jalur
        if (isset($data['jalur'])) {
            $data['jalur'] = strtolower(trim($data['jalur']));
            // Validasi nilai jalur yang valid
            $validJalur = ['zonasi', 'afirmasi', 'prestasi', 'mutasi'];
            if (!in_array($data['jalur'], $validJalur)) {
                return redirect()->back()->withInput()->with('error', 'Jalur pendaftaran tidak valid.');
            }
        } else {
            // Jika jalur tidak ada di POST, kembalikan error
            return redirect()->back()->withInput()->with('error', 'Jalur pendaftaran wajib dipilih.');
        }

        // Set status_daftar_ulang to 2 (pending) by default if not set
        if (!isset($data['status_daftar_ulang']) || $data['status_daftar_ulang'] === '' || $data['status_daftar_ulang'] === null) {
            $data['status_daftar_ulang'] = 2;
        }
        // Validasi: Tahun penerimaan harus ada
        if (empty($data['id_tahun'])) {
            return redirect()->back()->withInput()->with('error', 'Tahun penerimaan tidak boleh kosong.');
        }

        // Konversi nama field dari form ke database
        if (isset($data['id_tinggal'])) {
            $data['id_tempat_tinggal'] = $data['id_tinggal'];
        }
        if (isset($data['id_transportasi'])) {
            $data['id_moda_transportasi'] = $data['id_transportasi'];
        }
        if (isset($data['id_kebutuhan_khusus'])) {
            $data['id_berkebutuhankhusus'] = $data['id_kebutuhan_khusus'];
        }
        if (isset($data['id_kebutuhan_khusus_ayah'])) {
            $data['id_berkebutuhan_khusus_ayah'] = $data['id_kebutuhan_khusus_ayah'];
        }
        if (isset($data['id_kebutuhan_khusus_ibu'])) {
            $data['id_berkebutuhan_khusus_ibu'] = $data['id_kebutuhan_khusus_ibu'];
        }

        // Daftar field select yang nullable/foreign key
        $nullableFields = [
            'id_berkebutuhankhusus',
            'id_tempat_tinggal',
            'id_moda_transportasi',
            'id_pendidikan_ayah',
            'id_pekerjaan_ayah',
            'id_penghasilan_ayah',
            'id_berkebutuhan_khusus_ayah',
            'id_pendidikan_ibu',
            'id_pekerjaan_ibu',
            'id_penghasilan_ibu',
            'id_berkebutuhan_khusus_ibu',
            'id_agama',
            // tambahkan field lain jika ada
        ];
        foreach ($nullableFields as $field) {
            if (isset($data[$field]) && $data[$field] === '') {
                $data[$field] = null;
            }
        }

        // Set tanggal daftar if not already set
        if (!isset($data['tanggal_daftar']) || empty($data['tanggal_daftar'])) {
            $data['tanggal_daftar'] = date('Y-m-d H:i:s');
        }

        if ($this->calon_siswa->insert($data)) {
            // Get the inserted ID to retrieve complete student data
            $insertId = $this->calon_siswa->getInsertID();

            // Send WhatsApp notification if gateway is enabled
            $this->sendWhatsAppNotification($insertId, $data);

            return redirect()->to('calon_siswa')->with('success', 'Siswa berhasil ditambahkan');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan siswa');
        }
    }

    public function edit($id = null)
    {
        // Validate ID
        if (empty($id) || !is_numeric($id) || (int)$id < 1) {
            return redirect()->to('calon_siswa')->with('error', 'ID tidak valid');
        }

        // Ambil data lengkap dengan relasi (join) agar field kebutuhan khusus, ayah, ibu, dsb, terisi benar
        $calon_siswa = $this->calon_siswa
            ->select('db_calonpeserta.*, 
                db_calonpeserta.id_berkebutuhankhusus as id_kebutuhan_khusus,
                db_calonpeserta.id_berkebutuhan_khusus_ayah as id_kebutuhan_khusus_ayah,
                db_calonpeserta.id_berkebutuhan_khusus_ibu as id_kebutuhan_khusus_ibu')
            ->where('id_peserta', $id)
            ->get()
            ->getRow();
        if (is_object($calon_siswa)) {
            $data = [
                'calon_siswa' => $calon_siswa,
                'agama' => $this->agama->findAll(),
                'rombel' => $this->rombel->findAll(),
                'transport' => $this->transport->findAll(),
                'disability' => $this->disability->findAll(),
                'tinggal' => $this->tinggal->findAll(),
                'pendidikan' => $this->pendidikan->findAll(),
                'pekerjaan' => $this->pekerjaan->findAll(),
                'penghasilan' => $this->penghasilan->findAll(),
            ];
            return view('calon_siswa/edit', $data);
        } else {
            return redirect()->to('calon_siswa')->with('error', 'Data tidak ditemukan');
        }
    }

    public function update($id = null)
    {
        // Validate ID
        if (empty($id) || !is_numeric($id) || (int)$id < 1) {
            return redirect()->to('calon_siswa')->with('error', 'ID tidak valid');
        }

        // Check if record exists
        $existingRecord = $this->calon_siswa->find($id);
        if (!$existingRecord) {
            return redirect()->to('calon_siswa')->with('error', 'Data tidak ditemukan');
        }

        $data = $this->request->getPost();
        // Normalisasi dan validasi field jalur
        if (isset($data['jalur'])) {
            $data['jalur'] = strtolower(trim($data['jalur']));
        } else {
            // Jika jalur tidak ada di POST, kembalikan error
            return redirect()->back()->withInput()->with('error', 'Jalur pendaftaran wajib dipilih.');
        }
        // Mapping field form ke field database untuk foreign key
        if (isset($data['id_tinggal'])) {
            $data['id_tempat_tinggal'] = $data['id_tinggal'];
        }
        if (isset($data['id_transportasi'])) {
            $data['id_moda_transportasi'] = $data['id_transportasi'];
        }
        if (isset($data['id_kebutuhan_khusus'])) {
            $data['id_berkebutuhankhusus'] = $data['id_kebutuhan_khusus'];
        }
        if (isset($data['id_kebutuhan_khusus_ayah'])) {
            $data['id_berkebutuhan_khusus_ayah'] = $data['id_kebutuhan_khusus_ayah'];
        }
        if (isset($data['id_kebutuhan_khusus_ibu'])) {
            $data['id_berkebutuhan_khusus_ibu'] = $data['id_kebutuhan_khusus_ibu'];
        }

        // Mapping untuk field KIP
        if (isset($data['punya_kip'])) {
            $data['penerima_kip'] = $data['punya_kip'];
        }
        if (isset($data['nomor_kip'])) {
            $data['no_kip'] = $data['nomor_kip'];
        }

        // Daftar field select yang nullable/foreign key
        $nullableFields = [
            'id_berkebutuhankhusus',
            'id_tempat_tinggal',
            'id_moda_transportasi',
            'id_pendidikan_ayah',
            'id_pekerjaan_ayah',
            'id_penghasilan_bulanan_ayah',
            'id_berkebutuhan_khusus_ayah',
            'id_pendidikan_ibu',
            'id_pekerjaan_ibu',
            'id_penghasilan_bulanan_ibu',
            'id_berkebutuhan_khusus_ibu',
            'id_agama',
            // tambahkan field lain jika ada
        ];
        foreach ($nullableFields as $field) {
            if (isset($data[$field]) && $data[$field] === '') {
                $data[$field] = null;
            }
        }
        $save = $this->calon_siswa->update($id, $data);
        if (!$save) {
            return redirect()->back()->withInput()->with('errors', $this->calon_siswa->errors());
        } else {
            return redirect()->to(site_url('calon_siswa'))->with('success', 'Data Berhasil Diupdate');
        }
    }

    public function delete($id = null)
    {

        if (empty($id) || !is_numeric($id) || (int)$id < 1) {
            return redirect()->to(site_url('calon_siswa'))->with('error', 'ID tidak valid');
        }

        $calon_siswa = $this->calon_siswa->find($id);
        if (!$calon_siswa) {
            return redirect()->to(site_url('calon_siswa'))->with('error', 'Data tidak ditemukan');
        }

        $this->calon_siswa->delete($id);
        return redirect()->to(site_url('calon_siswa'))->with('success', 'Data Berhasil Dihapus');
    }

    public function preview($id = null)
    {
        $calon_siswa = $this->calon_siswa->find($id);
        if (is_object($calon_siswa)) {
            $data['calon_siswa'] = $calon_siswa;
            return view('surat masuk/preview', $data);
        } else {
            throw PageNotFoundException::forPageNotFound();
        }
    }
    function kode()
    {
        return json_encode($this->calon_siswa->generateCode());
    }

    public function previewPdf($id)
    {
        $calon_siswa = $this->calon_siswa->find($id);
        if (is_object($calon_siswa)) {
            $filePath = ROOTPATH . 'public/uploads/dokumen_in/' . $calon_siswa->file_pdf;
            if (!file_exists($filePath)) {
                throw new PageNotFoundException("File not found: " . $calon_siswa->file_pdf);
            }

            return $this->response->setHeader('Content-Type', 'application/pdf')
                ->setHeader('Content-Disposition', 'inline; filename="' . $calon_siswa->file_pdf . '"')
                ->setBody(file_get_contents($filePath));
        } else {
            throw new PageNotFoundException("Surat not found: " . $id);
        }
    }

    public function validasiSiswaTanpaKelas()
    {
        $model = new SiswaModel();
        $rombel = new RombelModel(); // Assuming you have a RombelModel to fetch rombel data
        $data['siswa_tanpa_kelas'] = $model->getSiswaTanpaKelas();
        $data['rombels'] = $rombel->findAll();
        return view('peserta didik/validasi_pd', $data);
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
    public function tahun_penerimaan()
    {
        $data['tahun_penerimaan'] = $this->penerimaan->findAll();
        return view('tahun_penerimaan/index', $data);
    }

    // Endpoint untuk verifikasi hasil kelulusan
    public function verifikasi_hasil()
    {
        $id = $this->request->getPost('id_peserta');
        $hasil = $this->request->getPost('status_hasil');

        // Improved validation with better error handling
        if (empty($id) || $hasil === null || $hasil === '') {
            // Instead of dumping raw data, return a proper response
            return redirect()->back()->with('error', 'Data tidak lengkap. Pastikan ID peserta dan status hasil telah dipilih.');
        }

        // Validate ID first
        if (!is_numeric($id) || intval($id) <= 0) {
            return redirect()->back()->with('error', 'ID peserta tidak valid.');
        }

        // Ambil data peserta dari database
        $peserta = $this->calon_siswa->getByCalonSiswaId($id);
        if (!$peserta) {
            return redirect()->back()->with('error', 'Data peserta tidak ditemukan.');
        }

        // Cek kelengkapan data - make validation less strict
        $dataKurang = [];
        // Cek Nomor KK dan NIK (pastikan nama field sesuai dengan database)
        $no_kk = isset($peserta->nomor_kk) ? trim((string)$peserta->nomor_kk) : '';
        $nik = isset($peserta->nik) ? trim((string)$peserta->nik) : '';

        // Make validation less strict - only check if completely empty
        if ($no_kk === '') {
            $dataKurang[] = 'Nomor KK';
        }
        if ($nik === '') {
            $dataKurang[] = 'NIK';
        }

        // Cek file berkas (pastikan path separator konsisten dan fallback ke scandir jika glob gagal)
        $berkasPath = rtrim(str_replace(['\\', '/'], DIRECTORY_SEPARATOR, FCPATH), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'berkas' . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR;
        $kkFiles = glob($berkasPath . 'kk_*.*');
        $akteFiles = glob($berkasPath . 'akte_*.*');
        $ijazahFiles = glob($berkasPath . 'ijazah_*.*');

        // Jika glob gagal, fallback ke scandir dan cek manual (cross-platform, skip . dan ..)
        if ((!$kkFiles || count($kkFiles) < 1) || (!$akteFiles || count($akteFiles) < 1) || (!$ijazahFiles || count($ijazahFiles) < 1)) {
            $kkFiles = [];
            $akteFiles = [];
            $ijazahFiles = [];
            if (is_dir($berkasPath)) {
                $files = scandir($berkasPath);
                foreach ($files as $file) {
                    if ($file === '.' || $file === '..') continue;
                    $fullPath = $berkasPath . $file;
                    if (is_file($fullPath)) {
                        if (stripos($file, 'kk_') === 0) {
                            $kkFiles[] = $fullPath;
                        } elseif (stripos($file, 'akte_') === 0) {
                            $akteFiles[] = $fullPath;
                        } elseif (stripos($file, 'ijazah_') === 0) {
                            $ijazahFiles[] = $fullPath;
                        }
                    }
                }
            }
        }
        if (count($kkFiles) < 1) {
            $dataKurang[] = 'Berkas KK';
        }
        if (count($akteFiles) < 1) {
            $dataKurang[] = 'Berkas Akte';
        }
        if (count($ijazahFiles) < 1) {
            $dataKurang[] = 'Berkas Ijazah';
        }

        if (!empty($dataKurang)) {
            $detail = [];
            if (in_array('Nomor KK', $dataKurang)) {
                $detail[] = 'Nomor KK: ' . ($no_kk === '' ? 'Kosong' : $no_kk);
            }
            if (in_array('NIK', $dataKurang)) {
                $detail[] = 'NIK: ' . ($nik === '' ? 'Kosong' : $nik);
            }
            if (in_array('Berkas KK', $dataKurang)) {
                $detail[] = 'Berkas KK: Tidak ditemukan file KK di folder ' . $berkasPath;
            }
            if (in_array('Berkas Akte', $dataKurang)) {
                $detail[] = 'Berkas Akte: Tidak ditemukan file Akte di folder ' . $berkasPath;
            }
            if (in_array('Berkas Ijazah', $dataKurang)) {
                $detail[] = 'Berkas Ijazah: Tidak ditemukan file Ijazah di folder ' . $berkasPath;
            }
            // Tambahkan debug peserta
            $pesan = 'Tidak bisa verifikasi. Data berikut belum lengkap:<ul><li>' . implode('</li><li>', $dataKurang) . '</li></ul>';
            $pesan .= '<br>Detail:<ul><li>' . implode('</li><li>', $detail) . '</li></ul>';
            $pesan .= '<br><b>Debug Peserta:</b><pre>' . print_r($peserta, true) . '</pre>';
            return redirect()->back()->with('error', $pesan);
        }

        // Cek apakah status_hasil sudah sama, jika ya tampilkan pesan sukses saja
        if (isset($peserta->status_hasil) && $peserta->status_hasil == $hasil) {
            return redirect()->to(site_url('calon_siswa'))->with('success', 'Status kelulusan sudah sesuai.');
        }

        // Hanya lakukan update jika memang ada perubahan
        try {
            $update = $this->calon_siswa->update($id, ['status_hasil' => $hasil]);
            if ($update) {
                return redirect()->to(site_url('calon_siswa'))->with('success', 'Status kelulusan berhasil diverifikasi.');
            } else {
                return redirect()->back()->with('error', 'Gagal menyimpan hasil kelulusan.');
            }
        } catch (\CodeIgniter\Database\Exceptions\DataException $e) {
            // Tangani error "There is no data to update."
            return redirect()->to(site_url('calon_siswa'))->with('success', 'Status kelulusan sudah sesuai.');
        }
    }

    public function cetakPdf($id_peserta)
    {
        $siswa = new SpmbModel();
        $data['calon_siswa'] = $siswa->getByCalonSiswaId($id_peserta);

        if (!$data['calon_siswa']) {
            return redirect()->to('calon_siswa')->with('error', 'Data siswa belum lengkap');
        }
        $mpdf = new Mpdf();
        $mpdf = new Mpdf([
            'format'        => [210, 330],
            'margin_left'   => 8,
            'margin_right'  => 8,
            'margin_top'    => 5,  // Sesuaikan untuk memberi ruang ke header
            'margin_bottom' => 5,  // Sesuaikan untuk footer
            'margin_header' => 10,
            'margin_footer' => 5
        ]);
        $nama = isset($data['calon_siswa']->nama_peserta) ? $data['calon_siswa']->nama_peserta : '-';
        $mpdf->SetHTMLFooter('
    <table width="100%" style="font-size: 10px">
        <tr>
            <td width="33%">
                <span><a href="https://spmb.sdnkrengseng02.sch.id" style="color:#0074d9;text-decoration:none;">https://spmb.sdnkrengseng02.sch.id</a></span><br>
                <span><b>' . strtoupper($nama) . '</b></span>
            </td>
            <td width="33%" align="right">Halaman {PAGENO}/{nb}</td>
        </tr>
    </table>
');
        $html = view('calon_siswa/cetak_buktidaftar', $data);

        $mpdf->WriteHTML($html);

        // Tampilkan PDF di browser
        $this->response->setContentType('application/pdf');
        $mpdf->Output('Laporan_Siswa.pdf', 'I',); // 'I' = tampil, 'D' = download

    }

    public function jurnal_spmb()
    {
        $data = [];

        // Get all calon siswa data with statistics
        $calon_siswa = $this->calon_siswa->getAll();

        // Calculate scores and add ranking
        foreach ($calon_siswa as $key => $siswa) {
            // Calculate age score - Using years.months format (e.g., 6 years 9 months = 6.9)
            $skor_usia = 0;
            $usia_decimal = 0; // Initialize usia_decimal

            if (!empty($siswa->tanggal_lahir) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $siswa->tanggal_lahir)) {
                $lahir = new DateTime($siswa->tanggal_lahir);
                $referensi = new DateTime('2025-07-01'); // 1 Juli 2025
                $diff = $referensi->diff($lahir);

                // Calculate age using years.months format (6 years 9 months = 6.9)
                $usia_tahun = $diff->y;
                $usia_bulan = $diff->m;

                // Handle months >= 10 by rolling over to next year
                if ($usia_bulan >= 10) {
                    $usia_tahun += floor($usia_bulan / 10);
                    $usia_bulan = $usia_bulan % 10;
                }

                // Convert to decimal: tahun.bulan (e.g., 6 years 9 months = 6.9)
                $usia_decimal = $usia_tahun + ($usia_bulan / 10);

                // Score calculation based on ideal age range
                if ($usia_decimal >= 6.0 && $usia_decimal <= 7.0) {
                    // Ideal range: closer to 6.5 years gets higher score
                    $skor_usia = 10.0 - abs($usia_decimal - 6.5) * 2;
                } elseif ($usia_decimal >= 5.5 && $usia_decimal < 6.0) {
                    // Slightly under ideal range
                    $skor_usia = 8.0 - abs($usia_decimal - 6.0) * 4;
                } elseif ($usia_decimal > 7.0 && $usia_decimal <= 7.5) {
                    // Slightly over ideal range
                    $skor_usia = 8.0 - abs($usia_decimal - 7.0) * 4;
                } else {
                    // Outside acceptable range - lower score
                    $skor_usia = max(5.0, 10.0 - abs($usia_decimal - 6.5) * 3);
                }

                // Ensure score is between 0 and 10
                $skor_usia = max(0, min(10, $skor_usia));
            } else {
                $skor_usia = 6.8; // Default score for missing birth date
                $usia_decimal = 6.8; // Default age for missing birth date
            }

            // Calculate domicile score
            $sekolah_desa = 'krengseng';
            $sekolah_kecamatan = 'gringsing';
            $sekolah_kabupaten = 'batang';

            $skor_domisili = 1; // Default score for different regency
            $alamat_siswa = strtolower(trim($siswa->alamat ?? ''));
            $desa_siswa = strtolower(trim($siswa->desa ?? ''));
            $kelurahan_siswa = strtolower(trim($siswa->kelurahan ?? ''));
            $kecamatan_siswa = strtolower(trim($siswa->kecamatan ?? ''));
            $kabupaten_siswa = strtolower(trim($siswa->kabupaten ?? ''));

            // Check desa or kelurahan for score 4
            if ((!empty($desa_siswa) && strpos($desa_siswa, $sekolah_desa) !== false) ||
                (!empty($kelurahan_siswa) && strpos($kelurahan_siswa, $sekolah_desa) !== false)
            ) {
                $skor_domisili = 4;
            } elseif (!empty($kecamatan_siswa) && strpos($kecamatan_siswa, $sekolah_kecamatan) !== false) {
                $skor_domisili = 3;
            } elseif (!empty($kabupaten_siswa) && strpos($kabupaten_siswa, $sekolah_kabupaten) !== false) {
                $skor_domisili = 2;
            } else {
                $skor_domisili = 1;
            }

            // Fallback: check from full address if specific fields are empty
            if (empty($desa_siswa) && empty($kelurahan_siswa) && empty($kecamatan_siswa) && empty($kabupaten_siswa) && !empty($alamat_siswa)) {
                if (strpos($alamat_siswa, $sekolah_desa) !== false) {
                    $skor_domisili = 4;
                } elseif (strpos($alamat_siswa, $sekolah_kecamatan) !== false) {
                    $skor_domisili = 3;
                } elseif (strpos($alamat_siswa, $sekolah_kabupaten) !== false) {
                    $skor_domisili = 2;
                }
            }

            // Calculate cumulative score using raw age + domicile score
            $nilai_akumulatif = $usia_decimal + $skor_domisili;

            // Add calculated scores to the siswa object
            $calon_siswa[$key]->usia_calculated = $usia_decimal ?? 0; // Store age in years.months format
            $calon_siswa[$key]->skor_usia_calculated = $skor_usia;
            $calon_siswa[$key]->skor_domisili_calculated = $skor_domisili;
            $calon_siswa[$key]->nilai_akumulatif_calculated = $nilai_akumulatif;
        }

        // Sort by cumulative score in descending order (highest score = rank 1)
        usort($calon_siswa, function ($a, $b) {
            if ($a->nilai_akumulatif_calculated == $b->nilai_akumulatif_calculated) {
                return 0;
            }
            return ($a->nilai_akumulatif_calculated > $b->nilai_akumulatif_calculated) ? -1 : 1;
        });

        // Add ranking based on sorted order
        foreach ($calon_siswa as $key => $siswa) {
            $calon_siswa[$key]->peringkat_calculated = $key + 1;
        }

        $data['calon_siswa'] = $calon_siswa;

        // Calculate statistics
        $total_pendaftar = count($calon_siswa);
        $lulus = 0;
        $tidak_lulus = 0;
        $belum_verifikasi = 0;
        $terverifikasi = 0;
        $pending = 0;

        // Statistics by jalur
        $jalur_stats = [
            'zonasi' => 0,
            'afirmasi' => 0,
            'prestasi' => 0,
            'mutasi' => 0
        ];

        foreach ($calon_siswa as $siswa) {
            // Status hasil statistics
            $status = strtolower(trim($siswa->status_hasil ?? ''));
            if ($status === 'lulus') {
                $lulus++;
            } elseif ($status === 'tidak lulus') {
                $tidak_lulus++;
            } else {
                $belum_verifikasi++;
            }

            // Daftar ulang statistics
            if ($siswa->status_daftar_ulang == '1') {
                $terverifikasi++;
            } else {
                $pending++;
            }

            // Jalur statistics
            $jalur = strtolower(trim($siswa->jalur ?? ''));
            if (isset($jalur_stats[$jalur])) {
                $jalur_stats[$jalur]++;
            }
        }

        $data['statistics'] = [
            'total_pendaftar' => $total_pendaftar,
            'lulus' => $lulus,
            'tidak_lulus' => $tidak_lulus,
            'belum_verifikasi' => $belum_verifikasi,
            'terverifikasi' => $terverifikasi,
            'pending' => $pending,
            'jalur_stats' => $jalur_stats
        ];

        return view('calon_siswa/jurnal_spmb', $data);
    }

    public function getCalonPeserta()
    {
        $model = new \App\Models\SpmbModel();
        $result = $model->select('id_peserta, nama_peserta, no_pendaftaran, nomor_hp, tanggal_daftar')
            ->orderBy('nama_peserta', 'asc')
            ->findAll();
        $data = [];
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->id_peserta,
                'nama' => $row->nama_peserta,
                'no_pendaftaran' => $row->no_pendaftaran,
                'nomor_hp' => $row->nomor_hp,
                'tanggal_daftar' => $row->tanggal_daftar // tambahkan ini
            ];
        }
        return $this->response->setJSON($data);
    }

    /**
     * Send WhatsApp notification after successful student registration
     */
    private function sendWhatsAppNotification(int $studentId, array $studentData): void
    {
        try {
            // Debug log
            log_message('info', 'Starting WhatsApp notification for student ID: ' . $studentId);
            log_message('info', 'Student data: ' . json_encode($studentData));

            $whatsAppService = new WhatsAppService();

            // Check if WhatsApp Gateway is enabled
            if (!$whatsAppService->isEnabled()) {
                log_message('info', 'WhatsApp Gateway disabled, skipping notification for student ID: ' . $studentId);
                return;
            }

            // Prepare student data for notification
            $notificationData = [
                'nama_lengkap' => $studentData['nama_peserta'] ?? $studentData['nama_lengkap'] ?? '',
                'nama' => $studentData['nama_peserta'] ?? $studentData['nama_lengkap'] ?? '',
                'no_pendaftaran' => $studentData['no_pendaftaran'] ?? '',
                'nomor_wa_ayah' => $studentData['nomor_hp'] ?? $studentData['nomor_hp_ayah'] ?? $studentData['nomor_wa_ayah'] ?? '',
                'nomor_wa' => $studentData['nomor_hp'] ?? $studentData['nomor_hp_ayah'] ?? $studentData['nomor_wa_ayah'] ?? '',
                'tanggal_daftar' => date('d/m/Y', strtotime($studentData['tanggal_daftar'] ?? 'now'))
            ];

            // Debug log notification data
            log_message('info', 'Notification data prepared: ' . json_encode($notificationData));

            // Send notification
            $result = $whatsAppService->sendRegistrationNotification($notificationData);

            if ($result['success']) {
                log_message('info', 'WhatsApp notification sent successfully for student ID: ' . $studentId . ' to ' . $notificationData['nomor_wa']);
            } else {
                log_message('error', 'Failed to send WhatsApp notification for student ID: ' . $studentId . '. Error: ' . $result['message']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception while sending WhatsApp notification for student ID: ' . $studentId . '. Error: ' . $e->getMessage());
        }
    }

    /**
     * Method for verifying student documents/berkas
     */
    public function verifikasi_berkas()
    {
        // Check if this is an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
        }

        // Get the JSON request body
        $json = $this->request->getJSON(true);
        if (empty($json) || !isset($json['id_peserta']) || !isset($json['status'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak lengkap'
            ]);
        }

        $id_peserta = $json['id_peserta'];
        $status = $json['status'];

        // Validate the peserta ID
        if (!is_numeric($id_peserta) || intval($id_peserta) <= 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID peserta tidak valid'
            ]);
        }

        try {
            // Get the peserta data
            $peserta = $this->calon_siswa->find($id_peserta);
            if (!$peserta) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data peserta tidak ditemukan'
                ]);
            }

            // Handle document rejection with specific alasan
            if ($status === 'ditolak' && isset($json['prefix']) && isset($json['alasan'])) {
                $prefix = $json['prefix'];
                $alasan = $json['alasan'];

                // Valid file prefixes
                $valid_prefixes = ['kk', 'akte', 'ijazah'];
                if (!in_array($prefix, $valid_prefixes)) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Prefix berkas tidak valid'
                    ]);
                }

                // Store the rejection reason in the database
                $field_name = 'alasan_tolak_' . $prefix;

                // Check if field exists, if not, we'll still proceed without storing the reason
                $db = db_connect();
                $fields = $db->getFieldData('db_calonpeserta');
                $field_exists = false;
                foreach ($fields as $field) {
                    if ($field->name === $field_name) {
                        $field_exists = true;
                        break;
                    }
                }

                $data = [];
                if ($field_exists) {
                    $data[$field_name] = $alasan;
                }

                // Update status field for the specific document
                $status_field = 'status_verifikasi_' . $prefix;
                if ($field_exists) {
                    $data[$status_field] = 'ditolak';
                }

                $this->calon_siswa->update($id_peserta, $data);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Berkas ' . strtoupper($prefix) . ' berhasil ditolak'
                ]);
            }
            // Handle full verification (all documents verified)
            else {
                // Periksa apakah semua berkas sudah diupload
                $kk_path = FCPATH . 'uploads/berkas/' . $id_peserta . '/';
                $kk_uploaded = count(glob($kk_path . 'kk_' . $id_peserta . '.*')) > 0;
                $akte_uploaded = count(glob($kk_path . 'akte_' . $id_peserta . '.*')) > 0;
                $ijazah_uploaded = count(glob($kk_path . 'ijazah_' . $id_peserta . '.*')) > 0;

                // Jika ada berkas yang belum diupload, tolak verifikasi
                if (!$kk_uploaded || !$akte_uploaded || !$ijazah_uploaded) {
                    $missing_files = [];
                    if (!$kk_uploaded) $missing_files[] = 'KK';
                    if (!$akte_uploaded) $missing_files[] = 'Akte';
                    if (!$ijazah_uploaded) $missing_files[] = 'Ijazah';

                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Berkas belum lengkap: ' . implode(', ', $missing_files) . ' belum diupload.'
                    ]);
                }

                // Semua berkas sudah diupload, lanjutkan verifikasi
                $data = [
                    'status_verifikasi_berkas' => $status,
                    'status_daftar_ulang' => ($status == 'terverifikasi') ? '1' : '0'
                ];

                $this->calon_siswa->update($id_peserta, $data);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Berkas berhasil diverifikasi'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Method for getting document/berkas files for a student
     */
    public function get_berkas_files($id_peserta = null, $prefix = null)
    {
        // Validate parameters
        if (!$id_peserta || !$prefix) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Parameter tidak lengkap'
            ]);
        }

        // Validate the peserta ID
        if (!is_numeric($id_peserta) || intval($id_peserta) <= 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID peserta tidak valid'
            ]);
        }

        // Check if the document exists
        $file_path = FCPATH . 'uploads/berkas/' . $id_peserta . '/';
        $files = glob($file_path . $prefix . '_' . $id_peserta . '.*');

        if (empty($files)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Berkas tidak ditemukan'
            ]);
        }

        // Get the first file (there should only be one)
        $file = $files[0];
        $file_name = basename($file);
        $file_url = base_url('uploads/berkas/' . $id_peserta . '/' . $file_name);

        return $this->response->setJSON([
            'success' => true,
            'file_url' => $file_url,
            'file_name' => $file_name
        ]);
    }

    public function export_excel()
    {
        try {
            // Get all calon siswa data with related information
            $calon_siswa = $this->calon_siswa->getAll();

            // Check if data exists
            if (empty($calon_siswa)) {
                return redirect()->to(site_url('calon_siswa'))->with('error', 'Tidak ada data untuk diekspor');
            }

            // Create new Spreadsheet object
            $spreadsheet = new Spreadsheet();

            // Set document properties
            $spreadsheet->getProperties()
                ->setCreator('Sekolahku System')
                ->setLastModifiedBy('Sekolahku System')
                ->setTitle('Data Calon Siswa')
                ->setSubject('Data Calon Siswa')
                ->setDescription('Data calon siswa export from Sekolahku System')
                ->setKeywords('calon siswa, data siswa, sekolahku')
                ->setCategory('Student Data');

            // Create Data Siswa worksheet
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Data Siswa');

            // Style for header
            $headerStyle = [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4'],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ];

            // Style for data
            $dataStyle = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ];

            // Set column widths - Auto size can be resource-intensive for large datasets
            // so we pre-define column widths
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(30);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(20);
            $sheet->getColumnDimension('G')->setWidth(20);
            $sheet->getColumnDimension('H')->setWidth(15);
            $sheet->getColumnDimension('I')->setWidth(15);
            $sheet->getColumnDimension('J')->setWidth(40);
            $sheet->getColumnDimension('K')->setWidth(20);
            $sheet->getColumnDimension('L')->setWidth(20);
            $sheet->getColumnDimension('M')->setWidth(20);
            $sheet->getColumnDimension('N')->setWidth(20);
            $sheet->getColumnDimension('O')->setWidth(30);
            $sheet->getColumnDimension('P')->setWidth(20);
            $sheet->getColumnDimension('Q')->setWidth(20);
            $sheet->getColumnDimension('R')->setWidth(20);
            $sheet->getColumnDimension('S')->setWidth(15);
            $sheet->getColumnDimension('T')->setWidth(15);
            $sheet->getColumnDimension('U')->setWidth(15);

            // Set header row with merged title
            $sheet->mergeCells('A1:U1');
            $sheet->setCellValue('A1', 'DATA CALON SISWA');
            $sheet->getStyle('A1')->applyFromArray([
                'font' => [
                    'bold' => true,
                    'size' => 16,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);
            $sheet->getRowDimension(1)->setRowHeight(30);

            // Set header for data columns
            $row = 2;
            $sheet->setCellValue('A' . $row, 'NO');
            $sheet->setCellValue('B' . $row, 'NO PENDAFTARAN');
            $sheet->setCellValue('C' . $row, 'NAMA LENGKAP');
            $sheet->setCellValue('D' . $row, 'JENIS KELAMIN');
            $sheet->setCellValue('E' . $row, 'NISN');
            $sheet->setCellValue('F' . $row, 'NIK');
            $sheet->setCellValue('G' . $row, 'TEMPAT LAHIR');
            $sheet->setCellValue('H' . $row, 'TANGGAL LAHIR');
            $sheet->setCellValue('I' . $row, 'AGAMA');
            $sheet->setCellValue('J' . $row, 'ALAMAT');
            $sheet->setCellValue('K' . $row, 'PROVINSI');
            $sheet->setCellValue('L' . $row, 'KABUPATEN');
            $sheet->setCellValue('M' . $row, 'KECAMATAN');
            $sheet->setCellValue('N' . $row, 'KELURAHAN/DESA');
            $sheet->setCellValue('O' . $row, 'SEKOLAH ASAL');
            $sheet->setCellValue('P' . $row, 'JALUR PENDAFTARAN');
            $sheet->setCellValue('Q' . $row, 'STATUS HASIL');
            $sheet->setCellValue('R' . $row, 'NAMA AYAH');
            $sheet->setCellValue('S' . $row, 'NAMA IBU');
            $sheet->setCellValue('T' . $row, 'NO. HP');
            $sheet->setCellValue('U' . $row, 'EMAIL');

            // Apply header style
            $sheet->getStyle('A2:U2')->applyFromArray($headerStyle);

            // Format cells that should be treated as text but might be interpreted as numbers
            $sheet->getStyle('B3:B1000')->getNumberFormat()->setFormatCode('@'); // No Pendaftaran as text
            $sheet->getStyle('E3:E1000')->getNumberFormat()->setFormatCode('@'); // NISN as text
            $sheet->getStyle('F3:F1000')->getNumberFormat()->setFormatCode('@'); // NIK as text
            $sheet->getStyle('T3:T1000')->getNumberFormat()->setFormatCode('@'); // No. HP as text

            // Populate data
            $row = 3;
            foreach ($calon_siswa as $key => $value) {
                $sheet->setCellValue('A' . $row, ($key + 1));

                // Format No Pendaftaran as text
                $noPendaftaran = $value->no_pendaftaran ?? '-';
                $sheet->setCellValueExplicit('B' . $row, $noPendaftaran, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                $sheet->setCellValue('C' . $row, $value->nama_peserta ?? '-');
                $sheet->setCellValue('D' . $row, ($value->jenis_kelamin == 'L' ? 'Laki-laki' : ($value->jenis_kelamin == 'P' ? 'Perempuan' : '-')));

                // Format NISN as text
                $nisn = $value->nisn ?? '-';
                $sheet->setCellValueExplicit('E' . $row, $nisn, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                // Format NIK as text
                $nik = $value->nik ?? '-';
                $sheet->setCellValueExplicit('F' . $row, $nik, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                $sheet->setCellValue('G' . $row, $value->tempat_lahir ?? '-');
                $sheet->setCellValue('H' . $row, $value->tanggal_lahir ?? '-');
                $sheet->setCellValue('I' . $row, $value->agama ?? '-');
                $sheet->setCellValue('J' . $row, $value->alamat ?? '-');
                $sheet->setCellValue('K' . $row, $value->provinsi ?? '-');
                $sheet->setCellValue('L' . $row, $value->kabupaten ?? '-');
                $sheet->setCellValue('M' . $row, $value->kecamatan ?? '-');
                $sheet->setCellValue('N' . $row, $value->kelurahan ?? '-');
                $sheet->setCellValue('O' . $row, $value->sekolah_asal ?? '-');

                // Format jalur pendaftaran with proper case
                $jalur = strtolower($value->jalur ?? '');
                $jalurFormatted = ucfirst($jalur);
                $sheet->setCellValue('P' . $row, $jalurFormatted);

                // Format status hasil
                $statusHasil = strtolower($value->status_hasil ?? '');
                if ($statusHasil === 'lulus') {
                    $statusHasilFormatted = 'Diterima';
                } elseif ($statusHasil === 'tidak lulus') {
                    $statusHasilFormatted = 'Tidak Diterima';
                } else {
                    $statusHasilFormatted = 'Belum Diverifikasi';
                }
                $sheet->setCellValue('Q' . $row, $statusHasilFormatted);

                // Add parent data
                $sheet->setCellValue('R' . $row, $value->nama_ayah ?? '-');
                $sheet->setCellValue('S' . $row, $value->nama_ibu ?? '-');

                // Format nomor HP as text
                $nomorHp = $value->nomor_hp ?? '-';
                $sheet->setCellValueExplicit('T' . $row, $nomorHp, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                $sheet->setCellValue('U' . $row, $value->email ?? '-');

                $row++;
            }

            // Apply data style
            $lastRow = $row - 1;
            if ($lastRow >= 3) {
                $sheet->getStyle('A3:U' . $lastRow)->applyFromArray($dataStyle);
            }

            // Create a new sheet for parent data
            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex(1);
            $parentSheet = $spreadsheet->getActiveSheet();
            $parentSheet->setTitle('Data Orang Tua');

            // Set header for parent data
            $parentSheet->setCellValue('A1', 'NO');
            $parentSheet->setCellValue('B1', 'NAMA SISWA');
            $parentSheet->setCellValue('C1', 'NAMA AYAH');
            $parentSheet->setCellValue('D1', 'NIK AYAH');
            $parentSheet->setCellValue('E1', 'TAHUN LAHIR AYAH');
            $parentSheet->setCellValue('F1', 'PENDIDIKAN AYAH');
            $parentSheet->setCellValue('G1', 'PEKERJAAN AYAH');
            $parentSheet->setCellValue('H1', 'PENGHASILAN AYAH');
            $parentSheet->setCellValue('I1', 'NAMA IBU');
            $parentSheet->setCellValue('J1', 'NIK IBU');
            $parentSheet->setCellValue('K1', 'TAHUN LAHIR IBU');
            $parentSheet->setCellValue('L1', 'PENDIDIKAN IBU');
            $parentSheet->setCellValue('M1', 'PEKERJAAN IBU');
            $parentSheet->setCellValue('N1', 'PENGHASILAN IBU');

            // Apply header style to parent data
            $parentSheet->getStyle('A1:N1')->applyFromArray($headerStyle);

            // Set column widths for parent sheet
            foreach (range('A', 'N') as $columnID) {
                $parentSheet->getColumnDimension($columnID)->setWidth(20);
            }

            // Format cells that should be treated as text but might be interpreted as numbers
            $parentSheet->getStyle('D2:D1000')->getNumberFormat()->setFormatCode('@'); // NIK Ayah as text
            $parentSheet->getStyle('J2:J1000')->getNumberFormat()->setFormatCode('@'); // NIK Ibu as text

            // Populate parent data
            $row = 2;
            foreach ($calon_siswa as $key => $value) {
                $parentSheet->setCellValue('A' . $row, ($key + 1));
                $parentSheet->setCellValue('B' . $row, $value->nama_peserta ?? '-');
                $parentSheet->setCellValue('C' . $row, $value->nama_ayah ?? '-');

                // Format NIK Ayah as text
                $nikAyah = $value->nik_ayah ?? '-';
                $parentSheet->setCellValueExplicit('D' . $row, $nikAyah, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                $parentSheet->setCellValue('E' . $row, $value->tahun_lahir_ayah ?? '-');
                $parentSheet->setCellValue('F' . $row, $value->pendidikan_ayah ?? '-');
                $parentSheet->setCellValue('G' . $row, $value->pekerjaan_ayah ?? '-');
                $parentSheet->setCellValue('H' . $row, $value->penghasilan_ayah ?? '-');
                $parentSheet->setCellValue('I' . $row, $value->nama_ibu ?? '-');

                // Format NIK Ibu as text
                $nikIbu = $value->nik_ibu ?? '-';
                $parentSheet->setCellValueExplicit('J' . $row, $nikIbu, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                $parentSheet->setCellValue('K' . $row, $value->tahun_lahir_ibu ?? '-');
                $parentSheet->setCellValue('L' . $row, $value->pendidikan_ibu ?? '-');
                $parentSheet->setCellValue('M' . $row, $value->pekerjaan_ibu ?? '-');
                $parentSheet->setCellValue('N' . $row, $value->penghasilan_ibu ?? '-');

                $row++;
            }

            // Apply data style to parent data
            $lastRow = $row - 1;
            if ($lastRow >= 2) {
                $parentSheet->getStyle('A2:N' . $lastRow)->applyFromArray($dataStyle);
            }

            // Set the active sheet to the first sheet
            $spreadsheet->setActiveSheetIndex(0);

            // Set the header for download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Data_Calon_Siswa_' . date('dmY_His') . '.xlsx"');
            header('Cache-Control: max-age=0');

            // Create Excel file and output to browser
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
        } catch (\Exception $e) {
            // Log the error
            log_message('error', 'Error exporting Excel: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->to('calon_siswa')->with('error', 'Terjadi kesalahan saat mengexport data: ' . $e->getMessage());
        }
    }

    /**
     * Automatic correction for verification inconsistencies
     * This method will check all students with verification status and make sure all required files are uploaded
     */
    public function koreksi_verifikasi()
    {
        // Only allow administrators to run this correction
        if (!session()->get('username')) {
            return redirect()->to(site_url('login'))->with('error', 'Anda harus login terlebih dahulu');
        }

        $fixed_count = 0;
        $calon_siswa = $this->calon_siswa->findAll();

        foreach ($calon_siswa as $siswa) {
            $id_peserta = $siswa->id_peserta ?? 0;
            if (!$id_peserta) continue;

            // Check if verification status is set but files are missing
            $has_verification_status = (!empty($siswa->status_verifikasi_berkas) && strtolower($siswa->status_verifikasi_berkas) === 'terverifikasi');
            $has_daftar_ulang_status = (!empty($siswa->status_daftar_ulang) && $siswa->status_daftar_ulang == '1');

            if ($has_verification_status || $has_daftar_ulang_status) {
                // Check if all files are uploaded
                $kk_path = FCPATH . 'uploads/berkas/' . $id_peserta . '/';
                $kk_uploaded = count(glob($kk_path . 'kk_' . $id_peserta . '.*')) > 0;
                $akte_uploaded = count(glob($kk_path . 'akte_' . $id_peserta . '.*')) > 0;
                $ijazah_uploaded = count(glob($kk_path . 'ijazah_' . $id_peserta . '.*')) > 0;

                if (!$kk_uploaded || !$akte_uploaded || !$ijazah_uploaded) {
                    // Files are missing, update status to need verification
                    $this->calon_siswa->update($id_peserta, [
                        'status_verifikasi_berkas' => 'perlu_verifikasi',
                        'status_daftar_ulang' => '3' // 3 = perlu verifikasi
                    ]);
                    $fixed_count++;
                }
            }
        }

        return redirect()->to(site_url('calon_siswa'))->with('success', $fixed_count . ' data telah dikoreksi.');
    }
}
