<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table            = 'db_siswa';
    protected $primaryKey       = 'id_siswa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_pekerjaan_ayah',
        'id_pendidikan_ayah',
        'id_penghasilan_ayah',
        'id_pekerjaan_ibu',
        'id_pendidikan_ibu',
        'id_penghasilan_ibu',
        'id_rombel',
        'id_rombel_masuk',
        'id_tahun_ajaran',
        'id_transportasi',
        'id_kebutuhankhusus',
        'id_tinggal',
        'id_agama',
        'nama_ayah',
        'nik_ayah',
        'tahun_ayah',
        'nama_ibu',
        'nik_ibu',
        'tahun_ibu',
        'nama_siswa',
        'tanggal_lahir',
        'tempat_lahir',
        'nik',
        'nisn',
        'nis',
        'no_kk',
        'kewarganegaraan',
        'reg_akta',
        'jk',
        'rt',
        'rw',
        'nama_dusun',
        'kelurahan',
        'kecamatan',
        'kodepos',
        'telephone',
        'alamat',
        'anak_ke',
        'jumlah_saudara',
        'status_kelulusan',
        'tanggal_kelulusan',
        'id_tahun_lulus',
        'jenis_pendaftaran',
        'tanggal_pendaftaran',
        'sekolah_asal',
        'asal_sekolah',        // Added for compatibility mapping
        'npsn',               // Added NPSN field
        'paud_formal',
        'paud_non_formal',
        'hobby',
        'cita_cita',
        'keluar_karena',
        'tanggal_keluar',
        'alasan_keluar',
        'id_kebutuhankhusus_ayah',  // Added parent special needs fields
        'id_kebutuhankhusus_ibu',   // Added parent special needs fields
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    /**
     * Ambil semua data siswa, dengan opsi pengecualian id_siswa tertentu (misal: sudah mutasi)
     * @param array $excludeIds
     * @return array
     */
    /**
     * Ambil semua data siswa untuk tahun ajaran tertentu (default: semua jika null)
     * @param array $excludeIds
     * @param int|null $id_tahun_ajaran
     * @return array
     */
    public function getAll($excludeIds = [], $id_tahun_ajaran = null)
    {
        $semester = session('semester_aktif');
        $builder = $this->db->table('db_siswa_semester_history');
        $builder->select('db_siswa_semester_history.id_siswa, db_siswa_semester_history.id_tahun_ajaran, db_siswa_semester_history.semester, db_siswa_semester_history.status_siswa, COALESCE(NULLIF(db_siswa.nama_siswa, \'\'), db_siswa_semester_history.nama_siswa) AS nama_siswa, COALESCE(NULLIF(db_siswa.jk, \'\'), db_siswa_semester_history.jk) AS jk, COALESCE(NULLIF(db_siswa.nisn, \'\'), db_siswa_semester_history.nisn) AS nisn, COALESCE(NULLIF(db_siswa.nis, \'\'), db_siswa_semester_history.nis) AS nis, COALESCE(NULLIF(db_siswa.nik, \'\'), db_siswa_semester_history.nik) AS nik, COALESCE(NULLIF(db_siswa.tempat_lahir, \'\'), db_siswa_semester_history.tempat_lahir) AS tempat_lahir, COALESCE(NULLIF(db_siswa.tanggal_lahir, \'\'), db_siswa_semester_history.tanggal_lahir) AS tanggal_lahir, db_rombel.rombel AS rombel, db_rombel.kelas AS kelas_rombel')
            ->join('db_siswa', 'db_siswa.id_siswa = db_siswa_semester_history.id_siswa', 'left')
            ->join('db_rombel', 'db_rombel.id_rombel = db_siswa_semester_history.id_rombel', 'left')
            ->join('db_agama', 'db_agama.id_agama = db_siswa.id_agama', 'left')
            ->join('db_transportasi', 'db_transportasi.id_transportasi = db_siswa.id_transportasi', 'left')
            ->join('db_disability', 'db_disability.id_disability = db_siswa.id_kebutuhankhusus', 'left')
            ->join('db_tempat_tinggal', 'db_tempat_tinggal.id_tempat_tinggal = db_siswa.id_tinggal', 'left')
            ->join('db_pekerjaan AS pekerjaan_ayah', 'pekerjaan_ayah.id_pekerjaan = db_siswa.id_pekerjaan_ayah', 'left')
            ->join('db_pekerjaan AS pekerjaan_ibu', 'pekerjaan_ibu.id_pekerjaan = db_siswa.id_pekerjaan_ibu', 'left')
            ->join('db_penghasilan AS penghasilan_ayah', 'penghasilan_ayah.id_penghasilan = db_siswa.id_penghasilan_ayah', 'left')
            ->join('db_penghasilan AS penghasilan_ibu', 'penghasilan_ibu.id_penghasilan = db_siswa.id_penghasilan_ibu', 'left')
            ->join('db_pendidikan AS pendidikan_ayah', 'pendidikan_ayah.id_pendidikan = db_siswa.id_pendidikan_ayah', 'left')
            ->join('db_pendidikan AS pendidikan_ibu', 'pendidikan_ibu.id_pendidikan = db_siswa.id_pendidikan_ibu', 'left');

        // Filter tahun ajaran dan semester aktif
        if ($id_tahun_ajaran !== null) {
            $builder->where('db_siswa_semester_history.id_tahun_ajaran', $id_tahun_ajaran);
        }
        if ($semester !== null) {
            $builder->where('db_siswa_semester_history.semester', $semester);
        }
        $builder->where('db_siswa_semester_history.status_siswa', 'aktif');

        if (!empty($excludeIds)) {
            $builder->whereNotIn('db_siswa_semester_history.id_siswa', $excludeIds);
        }
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }

    /**
     * Ambil siswa tanpa kelas, bisa exclude siswa mutasi
     * @param array $excludeIds
     * @return array
     */
    /**
     * Ambil siswa tanpa kelas untuk tahun ajaran tertentu, bisa exclude siswa mutasi
     * @param array $excludeIds
     * @param int|null $id_tahun_ajaran
     * @return array
     */
    public function getSiswaTanpaKelas($excludeIds = [], $id_tahun_ajaran = null)
    {
        $builder = $this->db->table('db_siswa');
        $builder->select('db_siswa.*, db_rombel.rombel AS nama_rombel')
            ->join('db_rombel', 'db_rombel.id_rombel = db_siswa.id_rombel', 'left')
            ->where('db_siswa.id_rombel', null);

        // Only add the tahun_ajaran filter if the column exists in the table
        if ($id_tahun_ajaran !== null) {
            // Check if the column exists
            $fields = $this->db->getFieldData('db_siswa');
            $column_exists = false;
            foreach ($fields as $field) {
                if ($field->name === 'id_tahun_ajaran') {
                    $column_exists = true;
                    break;
                }
            }

            if ($column_exists) {
                $builder->where('db_siswa.id_tahun_ajaran', $id_tahun_ajaran);
            }
        }

        if (!empty($excludeIds)) {
            $builder->whereNotIn('db_siswa.id_siswa', $excludeIds);
        }
        $query = $builder->get();
        return $query->getResult();
    }


    public function generateCode()
    {
        $lastRecord = $this->orderBy('nis', 'DESC')->first();
        if ($lastRecord) {
            $lastNis = (int) $lastRecord->nis; // Access the property as an object
            $newNis = $lastNis + 1;
        } else {
            $newNis = 2301; // Starting NIS as specified in requirements
        }
        return str_pad($newNis, 4, '0', STR_PAD_LEFT); // Pad the NIS with leading zeros if needed
    }
    /**
     * Ambil semua siswa per kelas, bisa exclude siswa mutasi
     * @param array $excludeIds
     * @return array
     */
    /**
     * Ambil semua siswa per kelas untuk tahun ajaran tertentu
     * @param array $excludeIds
     * @param int|null $id_tahun_ajaran
     * @return array
     */
    public function getSiswaPerkelas($excludeIds = [], $id_tahun_ajaran = null)
    {
        $builder = $this->db->table('db_siswa');
        $builder->select('db_siswa.*, db_rombel.rombel AS nama_rombel')
            ->join('db_rombel', 'db_rombel.id_rombel = db_siswa.id_rombel');
        if ($id_tahun_ajaran !== null) {
            $builder->where('db_siswa.id_tahun_ajaran', $id_tahun_ajaran);
        }
        if (!empty($excludeIds)) {
            $builder->whereNotIn('db_siswa.id_siswa', $excludeIds);
        }
        $query = $builder->get();
        return $query->getResult();
    }

    /**
     * Ambil siswa berdasarkan kelas, bisa exclude siswa mutasi
     * @param int $id_rombel
     * @param array $excludeIds
     * @return array
     */
    /**
     * Ambil siswa berdasarkan kelas dan tahun ajaran, bisa exclude siswa mutasi
     * @param int $id_rombel
     * @param array $excludeIds
     * @param int|null $id_tahun_ajaran
     * @return array
     */
    public function getSiswaByKelas($id_rombel, $excludeIds = [], $id_tahun_ajaran = null)
    {
        $builder = $this->db->table('db_siswa');
        $builder->select('db_siswa.id_siswa, db_siswa.nama_siswa, db_siswa.nisn, db_siswa.nis, db_siswa.jk, db_rombel.kelas, db_rombel.rombel AS nama_rombel')
            ->join('db_rombel', 'db_rombel.id_rombel = db_siswa.id_rombel', 'left')
            ->where('db_siswa.id_rombel', $id_rombel);
        if ($id_tahun_ajaran !== null) {
            $builder->where('db_siswa.id_tahun_ajaran', $id_tahun_ajaran);
        }
        if (!empty($excludeIds)) {
            $builder->whereNotIn('db_siswa.id_siswa', $excludeIds);
        }
        $query = $builder->get();
        return $query->getResult();
    }

    /**
     * Ambil siswa berdasarkan id_siswa dan tahun ajaran (opsional)
     * @param int $id_siswa
     * @param int|null $id_tahun_ajaran
     * @return object|null
     */
    public function getSiswaById($id_siswa, $id_tahun_ajaran = null)
    {
        $builder = $this->db->table('db_siswa');
        $builder->select('db_siswa.*, db_agama.agama, db_rombel.rombel AS nama_rombel, db_transportasi.moda_transportasi, db_disability.jenis_disability, db_tempat_tinggal.tempat_tinggal, pekerjaan_ayah.nama_pekerjaan AS pekerjaan_ayah, pekerjaan_ibu.nama_pekerjaan AS pekerjaan_ibu, penghasilan_ayah.nominal_penghasilan AS penghasilan_ayah, penghasilan_ibu.nominal_penghasilan AS penghasilan_ibu, pendidikan_ayah.pendidikan AS pendidikan_ayah, pendidikan_ibu.pendidikan AS pendidikan_ibu')
            ->join('db_agama', 'db_agama.id_agama = db_siswa.id_agama', 'left')
            ->join('db_rombel', 'db_rombel.id_rombel = db_siswa.id_rombel', 'left')
            ->join('db_transportasi', 'db_transportasi.id_transportasi = db_siswa.id_transportasi', 'left')
            ->join('db_disability', 'db_disability.id_disability = db_siswa.id_kebutuhankhusus', 'left')
            ->join('db_tempat_tinggal', 'db_tempat_tinggal.id_tempat_tinggal = db_siswa.id_tinggal', 'left')
            ->join('db_pekerjaan AS pekerjaan_ayah', 'pekerjaan_ayah.id_pekerjaan = db_siswa.id_pekerjaan_ayah', 'left')
            ->join('db_pekerjaan AS pekerjaan_ibu', 'pekerjaan_ibu.id_pekerjaan = db_siswa.id_pekerjaan_ibu', 'left')
            ->join('db_penghasilan AS penghasilan_ayah', 'penghasilan_ayah.id_penghasilan = db_siswa.id_penghasilan_ayah', 'left')
            ->join('db_penghasilan AS penghasilan_ibu', 'penghasilan_ibu.id_penghasilan = db_siswa.id_penghasilan_ibu', 'left')
            ->join('db_pendidikan AS pendidikan_ayah', 'pendidikan_ayah.id_pendidikan = db_siswa.id_pendidikan_ayah', 'left')
            ->join('db_pendidikan AS pendidikan_ibu', 'pendidikan_ibu.id_pendidikan = db_siswa.id_pendidikan_ibu', 'left')
            ->where('db_siswa.id_siswa', $id_siswa);

        // Only add the tahun_ajaran filter if the column exists in the table
        if ($id_tahun_ajaran !== null) {
            // Check if the column exists
            $fields = $this->db->getFieldData('db_siswa');
            $column_exists = false;
            foreach ($fields as $field) {
                if ($field->name === 'id_tahun_ajaran') {
                    $column_exists = true;
                    break;
                }
            }

            if ($column_exists) {
                $builder->where('db_siswa.id_tahun_ajaran', $id_tahun_ajaran);
            }
        }

        $query = $builder->get();
        return $query->getRow();
    }
    /**
     * Ambil siswa kelas akhir, bisa exclude siswa mutasi
     * @param array $excludeIds
     * @return array|object|null
     */
    public function getSiswaAkhir($excludeIds = [])
    {
        $builder = $this->db->table('db_siswa');
        $builder->select('db_siswa.*, db_rombel.rombel AS nama_rombel')
            ->join('db_rombel', 'db_rombel.id_rombel = db_siswa.id_rombel')
            ->orderBy('db_siswa.id_siswa', 'DESC');
        if (!empty($excludeIds)) {
            $builder->whereNotIn('db_siswa.id_siswa', $excludeIds);
        }
        $query = $builder->get();
        return $query->getRow();
    }

    // Ambil siswa lulus dari tabel db_calonpeserta (untuk controller, bisa dipanggil statis)
    public static function getCalonSiswaLulus()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('db_calonpeserta');
        $builder->select('*');
        $builder->where('status_hasil', 'lulus');
        $query = $builder->get();
        return $query->getResult();
    }

    /**
     * Duplikasi data siswa ke tahun ajaran baru (sekali saja per siswa per tahun ajaran)
     * @param int $id_tahun_ajaran_baru
     * @return int Jumlah data yang berhasil diduplikasi
     */
    public function duplicateToTahunAjaranBaru($id_tahun_ajaran_baru)
    {
        $db = \Config\Database::connect();
        // Ambil tahun ajaran aktif terakhir (selain tahun ajaran baru)
        $builder = $db->table($this->table);
        $builder->selectMax('id_tahun_ajaran');
        $builder->where('id_tahun_ajaran !=', $id_tahun_ajaran_baru);
        $lastTahun = $builder->get()->getRowArray();
        $id_tahun_ajaran_lama = $lastTahun ? $lastTahun['id_tahun_ajaran'] : null;
        if (!$id_tahun_ajaran_lama) {
            return 0;
        }

        // Ambil semua siswa dari tahun ajaran lama
        $siswaList = $db->table($this->table)
            ->where('id_tahun_ajaran', $id_tahun_ajaran_lama)
            ->orderBy('id_siswa', 'asc')
            ->get()->getResultArray();

        // Filter agar hanya satu siswa per NISN (atau NIS jika NISN kosong)
        $uniqueSiswa = [];
        foreach ($siswaList as $siswa) {
            $key = '';
            if (!empty($siswa['nisn'])) {
                $key = 'nisn_' . $siswa['nisn'];
            } elseif (!empty($siswa['nis'])) {
                $key = 'nis_' . $siswa['nis'];
            } else {
                continue;
            }
            if (!isset($uniqueSiswa[$key])) {
                $uniqueSiswa[$key] = $siswa;
            }
        }

        $count = 0;
        foreach ($uniqueSiswa as $siswa) {
            unset($siswa['id_siswa']);
            $siswa['id_tahun_ajaran'] = $id_tahun_ajaran_baru;
            $siswa['created_at'] = date('Y-m-d H:i:s');
            $siswa['updated_at'] = date('Y-m-d H:i:s');

            $where = [];
            if (!empty($siswa['nisn'])) {
                $where['nisn'] = $siswa['nisn'];
            } elseif (!empty($siswa['nis'])) {
                $where['nis'] = $siswa['nis'];
            } else {
                continue;
            }
            $where['id_tahun_ajaran'] = $id_tahun_ajaran_baru;

            $exists = $db->table($this->table)
                ->where($where)
                ->countAllResults();
            if ($exists == 0) {
                $db->table($this->table)->insert($siswa);
                $count++;
            }
        }
        return $count;
    }

    public function getByNisOrNisnAndTahunAjaran($nis, $nisn, $id_tahun_ajaran, $column_name = 'id_tahun_ajaran')
    {
        $builder = $this->db->table($this->table);

        // Check if the tahun ajaran column exists in the table
        $fields = $this->db->getFieldData($this->table);
        $column_exists = false;
        foreach ($fields as $field) {
            if ($field->name === $column_name) {
                $column_exists = true;
                break;
            }
        }

        // Only filter by tahun ajaran if the column exists
        if ($column_exists && $id_tahun_ajaran !== null) {
            $builder->where($column_name, $id_tahun_ajaran);
        }

        $builder->groupStart();
        $builder->where('nis', $nis);
        if ($nisn) {
            $builder->orWhere('nisn', $nisn);
        }
        $builder->groupEnd();

        $query = $builder->get();
        return $query->getRow();
    }

    /**
     * Override the update method to add better error handling
     */
    public function update($id = null, $data = null): bool
    {
        try {
            return parent::update($id, $data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Ambil semua siswa dengan filter kelas
     * @param array $excludeIds
     * @param int|null $id_tahun_ajaran
     * @param string|null $filter_kelas
     * @return array
     */
    public function getAllWithFilter($excludeIds = [], $id_tahun_ajaran = null, $filter_kelas = null, $semester = null)
    {
        // Ambil semester dari parameter, jika null ambil dari session, jika tetap null default ke 1
        if ($semester === null) {
            $semester = session('semester_aktif');
        }
        if ($semester === null) {
            $semester = 1;
        }
        $selectFields = [
            'db_siswa.id_siswa',
            'db_siswa.nama_siswa',
            'db_siswa.jk',
            'db_siswa.nisn',
            'db_siswa.nis',
            'db_siswa.nik',
            'db_siswa.tempat_lahir',
            'db_siswa.tanggal_lahir',
            'db_siswa.no_kk',
            'db_siswa.id_agama',
            'db_siswa.id_kebutuhankhusus',
            'db_siswa.id_tinggal',
            'db_siswa.id_rombel',
            'db_siswa.id_transportasi',
            'db_rombel.rombel AS rombel',
            'db_rombel.kelas AS kelas_rombel'
        ];
        // Log parameter yang diterima
        // Query utama: ambil data dari db_siswa (bukan histori)
        $builder = $this->db->table('db_siswa');
        $builder->select($selectFields, false)
            ->join('db_rombel', 'db_rombel.id_rombel = db_siswa.id_rombel', 'left');
        if ($id_tahun_ajaran !== null) {
            $fields = $this->db->getFieldData('db_siswa');
            $column_exists = false;
            foreach ($fields as $field) {
                if ($field->name === 'id_tahun_ajaran') {
                    $column_exists = true;
                    break;
                }
            }
            if ($column_exists) {
                $builder->where('db_siswa.id_tahun_ajaran', $id_tahun_ajaran);
            }
        }
        if (!empty($filter_kelas)) {
            $parts = explode('|', $filter_kelas);
            $kelasVal = $parts[0] ?? '';
            $rombelVal = $parts[1] ?? '';
            if ($kelasVal) {
                $builder->where('db_rombel.kelas', $kelasVal);
            }
            if ($rombelVal) {
                $builder->where('db_rombel.rombel', $rombelVal);
            }
        }
        if (!empty($excludeIds)) {
            $builder->whereNotIn('db_siswa.id_siswa', $excludeIds);
        }
        $result = $builder->get()->getResultArray();
        $sample = array_slice($result, 0, 3);
        return $result;

        // Filter tahun ajaran
        if ($id_tahun_ajaran !== null) {
            // Check if the column exists
            $fields = $this->db->getFieldData('db_siswa');
            $column_exists = false;
            foreach ($fields as $field) {
                if ($field->name === 'id_tahun_ajaran') {
                    $column_exists = true;
                    break;
                }
            }

            if ($column_exists) {
                $builder->where('db_siswa.id_tahun_ajaran', $id_tahun_ajaran);
            }

            // Also filter based on the rombel's academic year for joined data
            $builder->join('db_tahunajaran', 'db_siswa.id_tahun_ajaran = db_tahunajaran.id_tahun_ajaran', 'left');
            // Additionally ensure that if a class is assigned, it belongs to the current academic year
            $builder->groupStart()
                ->where('db_rombel.id_tahun', $id_tahun_ajaran)
                ->orWhere('db_siswa.id_rombel IS NULL')
                ->groupEnd();
        }

        // Filter kelas jika ada
        if (!empty($filter_kelas)) {
            // Parse filter kelas (format: "Kelas - Rombel")
            $parts = explode(' - ', $filter_kelas);
            if (count($parts) == 2) {
                $kelas = trim($parts[0]);
                $rombel = trim($parts[1]);
                $builder->where('db_rombel.kelas', $kelas);
                $builder->where('db_rombel.rombel', $rombel);
            }
        }

        if (!empty($excludeIds)) {
            $builder->whereNotIn('db_siswa.id_siswa', $excludeIds);
        }

        log_message('debug', '[SiswaModel:getAllWithFilter] Query: ' . $builder->getCompiledSelect());
        $query = $builder->get();
        log_message('debug', '[SiswaModel:getAllWithFilter] Result count: ' . count($query->getResult()));
        return $query->getResult();
    }
    /**
     * Generate a unique NIS (Nomor Induk Siswa) based on different criteria:
     * - For class 1 students: alphabetical order of student names
     * - For transfer students: based on entry date
     * - Default: incremental NIS
     * 
     * @param boolean $isNewStudent Whether this is a new student (class 1)
     * @param boolean $isTransferStudent Whether this is a transfer student
     * @param string $studentName Student's name for alphabetical ordering
     * @param string $entryDate Entry date for transfer students (YYYY-MM-DD format)
     * @return string The generated NIS
     */
    public function generateNIS($isNewStudent = false, $isTransferStudent = false, $studentName = '', $entryDate = null)
    {
        $db = \Config\Database::connect();

        // Get the last NIS in the database to use as starting point for ALL cases
        $builder = $db->table($this->table);
        $builder->select('nis');
        $builder->where('nis IS NOT NULL');
        $builder->where('nis !=', '');
        $builder->orderBy('CAST(nis AS UNSIGNED)', 'DESC');  // Proper numeric sorting
        $builder->limit(1);
        $lastStudent = $builder->get()->getRow();

        // Determine next NIS number
        if ($lastStudent && !empty($lastStudent->nis)) {
            $lastNis = (int)$lastStudent->nis;
            $newNis = $lastNis + 1;
            $format = '%0' . strlen($lastStudent->nis) . 'd';
        } else {
            $newNis = 2301; // Start with 2301 if no existing NIS found
            $format = '%04d'; // 4 digits
        }

        // CASE 1: New students (Class 1) - NIS incremented but should follow alphabetical order
        if ($isNewStudent) {
            log_message('info', "Generating NIS for new Class 1 student: {$studentName}");

            // Note: For proper alphabetical ordering, we should batch-process all Class 1 students
            // For now, we'll still increment from the last NIS but log this for future batch processing
            log_message('info', "New student NIS generation - should be batch processed by alphabetical order for proper sequencing");

            $nisFormatted = sprintf($format, $newNis);

            // Ensure uniqueness
            while ($this->where('nis', $nisFormatted)->countAllResults() > 0) {
                $newNis++;
                $nisFormatted = sprintf($format, $newNis);
            }

            log_message('info', "Generated NIS {$nisFormatted} for new student: {$studentName}");
            return $nisFormatted;
        }

        // CASE 2: Transfer students - NIS incremented but should follow registration date order
        elseif ($isTransferStudent && $entryDate) {
            log_message('info', "Generating NIS for transfer student: {$studentName}, entry date: {$entryDate}");

            // Note: For proper date ordering, we should batch-process transfer students by date
            // For now, we'll still increment from the last NIS but log this for future batch processing
            log_message('info', "Transfer student NIS generation - should be batch processed by registration date order for proper sequencing");

            $nisFormatted = sprintf($format, $newNis);

            // Ensure uniqueness
            while ($this->where('nis', $nisFormatted)->countAllResults() > 0) {
                $newNis++;
                $nisFormatted = sprintf($format, $newNis);
            }

            log_message('info', "Generated NIS {$nisFormatted} for transfer student: {$studentName}, entry date: {$entryDate}");
            return $nisFormatted;
        }

        // CASE 3: Default - incremental NIS (fallback)
        else {
            log_message('info', "Generating default incremental NIS");

            $nisFormatted = sprintf($format, $newNis);

            // Ensure uniqueness
            while ($this->where('nis', $nisFormatted)->countAllResults() > 0) {
                $newNis++;
                $nisFormatted = sprintf($format, $newNis);
            }

            log_message('info', "Generated default NIS: {$nisFormatted}");
            return $nisFormatted;
        }
    }
    /**
     * Generate NIS for all class 1 students who don't have an NIS yet
     * This assigns NIS based on alphabetical order of names
     * 
     * @return int Number of students updated
     */
    public function generateNISForClass1Students()
    {
        $db = \Config\Database::connect();
        $updatedCount = 0;

        // Step 1: Find all class 1 students without an NIS
        $builder = $db->table($this->table);
        $builder->select('db_siswa.id_siswa, db_siswa.nama_siswa');
        $builder->join('db_rombel', 'db_rombel.id_rombel = db_siswa.id_rombel', 'left');
        $builder->where('(db_siswa.nis IS NULL OR db_siswa.nis = "" OR db_siswa.nis = "0")');
        $builder->groupStart()
            // Find students in rombel (class) with kelas = 1 or I
            ->where('db_rombel.kelas', '1')
            ->orWhere('db_rombel.kelas', 'I')
            ->groupEnd();

        // Get students and sort alphabetically by name
        $builder->orderBy('db_siswa.nama_siswa', 'ASC');
        $students = $builder->get()->getResult();

        if (empty($students)) {
            return 0; // No students to update
        }

        // Step 2: Get the last NIS in the database to use as starting point
        $lastNisBuilder = $db->table($this->table);
        $lastNisBuilder->select('nis');
        $lastNisBuilder->where('nis IS NOT NULL');
        $lastNisBuilder->where('nis !=', '');
        $lastNisBuilder->orderBy('nis', 'DESC');
        $lastNisBuilder->limit(1);
        $lastStudent = $lastNisBuilder->get()->getRow();

        // Determine starting NIS number
        if ($lastStudent && !empty($lastStudent->nis)) {
            $nextNis = (int)$lastStudent->nis + 1;
        } else {
            $nextNis = 2301; // Start with 2301 if no existing NIS found
        }

        // Step 3: Generate sequential NIS numbers for students in alphabetical order
        foreach ($students as $student) {
            // Format with leading zeros if needed
            if ($lastStudent && !empty($lastStudent->nis)) {
                $format = '%0' . strlen($lastStudent->nis) . 'd';
                $nisFormatted = sprintf($format, $nextNis);
            } else {
                $nisFormatted = sprintf('%04d', $nextNis); // 4 digits
            }

            // Ensure uniqueness
            while ($this->where('nis', $nisFormatted)->countAllResults() > 0) {
                $nextNis++;
                if ($lastStudent && !empty($lastStudent->nis)) {
                    $format = '%0' . strlen($lastStudent->nis) . 'd';
                    $nisFormatted = sprintf($format, $nextNis);
                } else {
                    $nisFormatted = sprintf('%04d', $nextNis);
                }
            }

            // Update the student record with the new NIS
            $this->update($student->id_siswa, ['nis' => $nisFormatted]);
            $updatedCount++;
            $nextNis++; // Increment for the next student
        }

        return $updatedCount;
    }

    /**
     * Batch generate NIS for Class 1 students in alphabetical order
     * This ensures proper sequential NIS assignment based on student names
     * 
     * @return int Number of students processed
     */
    public function batchGenerateNISForClass1StudentsAlphabetical()
    {
        $db = \Config\Database::connect();

        // Get all Class 1 students without NIS, ordered alphabetically
        $builder = $db->table($this->table);
        $builder->select('db_siswa.id_siswa, db_siswa.nama_siswa, db_siswa.nis');
        $builder->join('db_rombel', 'db_rombel.id_rombel = db_siswa.id_rombel', 'left');
        $builder->where('(db_siswa.nis IS NULL OR db_siswa.nis = "" OR db_siswa.nis = "0")');
        $builder->groupStart()
            ->where('db_rombel.kelas', '1')
            ->orWhere('db_rombel.kelas', 'I')
            ->groupEnd();
        $builder->orderBy('db_siswa.nama_siswa', 'ASC');  // Alphabetical order
        $studentsWithoutNIS = $builder->get()->getResult();

        if (empty($studentsWithoutNIS)) {
            log_message('info', 'No Class 1 students found needing NIS assignment');
            return 0;
        }

        // Get the last NIS to start from
        $lastNisBuilder = $db->table($this->table);
        $lastNisBuilder->select('nis');
        $lastNisBuilder->where('nis IS NOT NULL');
        $lastNisBuilder->where('nis !=', '');
        $lastNisBuilder->orderBy('CAST(nis AS UNSIGNED)', 'DESC');
        $lastNisBuilder->limit(1);
        $lastStudent = $lastNisBuilder->get()->getRow();

        if ($lastStudent && !empty($lastStudent->nis)) {
            $currentNis = (int)$lastStudent->nis + 1;
            $format = '%0' . strlen($lastStudent->nis) . 'd';
        } else {
            $currentNis = 2301;
            $format = '%04d';
        }

        $updatedCount = 0;
        log_message('info', 'Starting batch NIS generation for ' . count($studentsWithoutNIS) . ' Class 1 students in alphabetical order');

        // Assign NIS sequentially to alphabetically ordered students
        foreach ($studentsWithoutNIS as $student) {
            $nisFormatted = sprintf($format, $currentNis);

            // Ensure uniqueness (should not happen but safety check)
            while ($this->where('nis', $nisFormatted)->countAllResults() > 0) {
                $currentNis++;
                $nisFormatted = sprintf($format, $currentNis);
            }

            // Update the student's NIS
            $updateResult = $this->update($student->id_siswa, ['nis' => $nisFormatted]);

            if ($updateResult) {
                log_message('info', "Assigned NIS {$nisFormatted} to Class 1 student: {$student->nama_siswa} (ID: {$student->id_siswa})");
                $updatedCount++;
                $currentNis++;
            } else {
                log_message('error', "Failed to assign NIS to student ID {$student->id_siswa}: {$student->nama_siswa}");
            }
        }

        log_message('info', "Batch NIS generation completed. Updated {$updatedCount} Class 1 students.");
        return $updatedCount;
    }

    /**
     * Batch generate NIS for transfer students ordered by registration date
     * This ensures proper sequential NIS assignment based on registration date
     * 
     * @return int Number of students processed
     */
    public function batchGenerateNISForTransferStudentsByDate()
    {
        $db = \Config\Database::connect();

        // Get all transfer students (with sekolah_asal) without NIS, ordered by registration date
        $builder = $db->table($this->table);
        $builder->select('db_siswa.id_siswa, db_siswa.nama_siswa, db_siswa.nis, db_siswa.tanggal_pendaftaran, db_siswa.sekolah_asal');
        $builder->where('(db_siswa.nis IS NULL OR db_siswa.nis = "" OR db_siswa.nis = "0")');
        $builder->where('db_siswa.sekolah_asal IS NOT NULL');
        $builder->where('db_siswa.sekolah_asal !=', '');
        $builder->orderBy('db_siswa.tanggal_pendaftaran', 'ASC');  // Date order
        $builder->orderBy('db_siswa.nama_siswa', 'ASC');          // Secondary: alphabetical
        $transferStudentsWithoutNIS = $builder->get()->getResult();

        if (empty($transferStudentsWithoutNIS)) {
            log_message('info', 'No transfer students found needing NIS assignment');
            return 0;
        }

        // Get the last NIS to start from
        $lastNisBuilder = $db->table($this->table);
        $lastNisBuilder->select('nis');
        $lastNisBuilder->where('nis IS NOT NULL');
        $lastNisBuilder->where('nis !=', '');
        $lastNisBuilder->orderBy('CAST(nis AS UNSIGNED)', 'DESC');
        $lastNisBuilder->limit(1);
        $lastStudent = $lastNisBuilder->get()->getRow();

        if ($lastStudent && !empty($lastStudent->nis)) {
            $currentNis = (int)$lastStudent->nis + 1;
            $format = '%0' . strlen($lastStudent->nis) . 'd';
        } else {
            $currentNis = 2301;
            $format = '%04d';
        }

        $updatedCount = 0;
        log_message('info', 'Starting batch NIS generation for ' . count($transferStudentsWithoutNIS) . ' transfer students ordered by registration date');

        // Assign NIS sequentially to date-ordered transfer students
        foreach ($transferStudentsWithoutNIS as $student) {
            $nisFormatted = sprintf($format, $currentNis);

            // Ensure uniqueness (should not happen but safety check)
            while ($this->where('nis', $nisFormatted)->countAllResults() > 0) {
                $currentNis++;
                $nisFormatted = sprintf($format, $currentNis);
            }

            // Update the student's NIS
            $updateResult = $this->update($student->id_siswa, ['nis' => $nisFormatted]);

            if ($updateResult) {
                log_message('info', "Assigned NIS {$nisFormatted} to transfer student: {$student->nama_siswa} (ID: {$student->id_siswa}, Date: {$student->tanggal_pendaftaran}, From: {$student->sekolah_asal})");
                $updatedCount++;
                $currentNis++;
            } else {
                log_message('error', "Failed to assign NIS to transfer student ID {$student->id_siswa}: {$student->nama_siswa}");
            }
        }

        log_message('info', "Batch NIS generation for transfer students completed. Updated {$updatedCount} students.");
        return $updatedCount;
    }

    /**
     * Generate NIS for newly added students who don't have NIS yet
     * This method is called after students are transferred from candidates
     * 
     * @param array $studentIds Array of student IDs to generate NIS for
     * @return int Number of students updated with NIS
     */
    public function generateNISForNewStudents($studentIds = [])
    {
        if (empty($studentIds)) {
            return 0;
        }

        $db = \Config\Database::connect();
        $updatedCount = 0;

        // Get the last NIS in the database to continue sequence
        $lastNisBuilder = $db->table($this->table);
        $lastNisBuilder->select('nis');
        $lastNisBuilder->where('nis IS NOT NULL');
        $lastNisBuilder->where('nis !=', '');
        $lastNisBuilder->where('nis !=', '0');
        $lastNisBuilder->orderBy('CAST(nis AS UNSIGNED)', 'DESC');
        $lastNisBuilder->limit(1);
        $lastStudent = $lastNisBuilder->get()->getRow();

        // Determine starting NIS number
        if ($lastStudent && !empty($lastStudent->nis)) {
            $currentNis = (int)$lastStudent->nis + 1;
            $format = '%0' . strlen($lastStudent->nis) . 'd';
        } else {
            $currentNis = 2301; // Start with 2301 if no existing NIS found
            $format = '%04d';
        }

        // Process each student ID
        foreach ($studentIds as $studentId) {
            // Check if student already has NIS
            $student = $this->find($studentId);
            if (!$student || (!empty($student->nis) && $student->nis != '0')) {
                continue; // Skip if student not found or already has NIS
            }

            // Generate unique NIS
            $nisFormatted = sprintf($format, $currentNis);

            // Ensure uniqueness
            while ($this->where('nis', $nisFormatted)->countAllResults() > 0) {
                $currentNis++;
                $nisFormatted = sprintf($format, $currentNis);
            }

            // Update student with new NIS
            $updateResult = $this->update($studentId, ['nis' => $nisFormatted]);

            if ($updateResult) {
                log_message('info', "Generated NIS {$nisFormatted} for new student ID: {$studentId} ({$student->nama_siswa})");
                $updatedCount++;
                $currentNis++;
            } else {
                log_message('error', "Failed to generate NIS for student ID {$studentId}");
            }
        }

        return $updatedCount;
    }

    /**
     * Generate NIS for a single student
     * 
     * @param int $studentId Student ID to generate NIS for
     * @return string|false Generated NIS or false on failure
     */
    public function generateNISForStudent($studentId)
    {
        $db = \Config\Database::connect();

        // Check if student exists and doesn't have NIS
        $student = $this->find($studentId);
        if (!$student || (!empty($student->nis) && $student->nis != '0')) {
            return false;
        }

        // Get the last NIS
        $lastNisBuilder = $db->table($this->table);
        $lastNisBuilder->select('nis');
        $lastNisBuilder->where('nis IS NOT NULL');
        $lastNisBuilder->where('nis !=', '');
        $lastNisBuilder->where('nis !=', '0');
        $lastNisBuilder->orderBy('CAST(nis AS UNSIGNED)', 'DESC');
        $lastNisBuilder->limit(1);
        $lastStudent = $lastNisBuilder->get()->getRow();

        // Determine NIS number
        if ($lastStudent && !empty($lastStudent->nis)) {
            $nextNis = (int)$lastStudent->nis + 1;
            $format = '%0' . strlen($lastStudent->nis) . 'd';
        } else {
            $nextNis = 2301;
            $format = '%04d';
        }

        // Generate unique NIS
        $nisFormatted = sprintf($format, $nextNis);
        while ($this->where('nis', $nisFormatted)->countAllResults() > 0) {
            $nextNis++;
            $nisFormatted = sprintf($format, $nextNis);
        }

        // Update student
        $updateResult = $this->update($studentId, ['nis' => $nisFormatted]);

        if ($updateResult) {
            log_message('info', "Generated NIS {$nisFormatted} for student ID: {$studentId} ({$student->nama_siswa})");
            return $nisFormatted;
        }

        return false;
    }
}
