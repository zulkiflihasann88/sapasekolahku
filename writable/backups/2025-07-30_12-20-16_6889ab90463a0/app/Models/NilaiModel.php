<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiModel extends Model
{
    protected $table            = 'db_nilai';
    protected $primaryKey       = 'id_nilai';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_siswa',
        'id_rombel',
        'id_pelajaran',
        'id_tahun_ajaran',
        'semester',
        'nilai_tugas',
        'nilai_uh',
        'nilai_uts',
        'nilai_uas',
        'nilai_akhir',
        'predikat',
        'status_verifikasi'
    ];


    // Only one block for these properties and methods, no duplication
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Only one block for these methods, no duplication
    /**
     * Override insert agar id_tahun_ajaran otomatis dari session jika belum diisi
     */
    public function insert($data = null, bool $returnID = true)
    {
        if (is_array($data) && !isset($data['id_tahun_ajaran'])) {
            $id_tahun_ajaran = getCurrentTahunAjaran();
            if ($id_tahun_ajaran) {
                $data['id_tahun_ajaran'] = $id_tahun_ajaran;
            }
        }
        return parent::insert($data, $returnID);
    }

    /**
     * Override update agar id_tahun_ajaran otomatis dari session jika belum diisi
     */
    public function update($id = null, $data = null): bool
    {
        if (is_array($data) && !isset($data['id_tahun_ajaran'])) {
            $id_tahun_ajaran = getCurrentTahunAjaran();
            if ($id_tahun_ajaran) {
                $data['id_tahun_ajaran'] = $id_tahun_ajaran;
            }
        }
        return parent::update($id, $data);
    }

    public function getNilaiVerval($tahunPelajaran, $kelas, $mataPelajaran, $semester)
    {
        $builder = $this->db->table($this->table);
        $builder->select('
            db_nilai.*,
            db_siswa.nama_siswa,
            db_siswa.nisn,
            db_rombel.kelas as nama_kelas,
            db_matpel.nama_mapel as nama_mata_pelajaran
        ');
        $builder->join('db_siswa', 'db_nilai.id_siswa = db_siswa.id_siswa', 'left');
        $builder->join('db_rombel', 'db_nilai.id_rombel = db_rombel.id_rombel', 'left');
        $builder->join('db_matpel', 'db_nilai.id_pelajaran = db_matpel.id_pelajaran', 'left');

        // Gunakan helper untuk mendapatkan tahun ajaran yang tepat
        $id_tahun_ajaran = getCurrentTahunAjaran();
        if ($id_tahun_ajaran) {
            $builder->where('db_nilai.id_tahun_ajaran', $id_tahun_ajaran);
        }
        $builder->where('db_nilai.id_rombel', $kelas);
        $builder->where('db_nilai.id_pelajaran', $mataPelajaran);
        $builder->where('db_nilai.semester', $semester);
        $builder->orderBy('db_siswa.nama_siswa', 'ASC');

        $query = $builder->get();
        return $query->getResult();
    }

    public function getNilaiDetail($id)
    {
        $builder = $this->db->table($this->table);
        $builder->select('
            db_nilai.*,
            db_siswa.nama_siswa,
            db_siswa.nisn,
            db_rombel.kelas as nama_kelas,
            db_matpel.nama_mapel as nama_mata_pelajaran
        ');
        $builder->join('db_siswa', 'db_nilai.id_siswa = db_siswa.id_siswa', 'left');
        $builder->join('db_rombel', 'db_nilai.id_rombel = db_rombel.id_rombel', 'left');
        $builder->join('db_matpel', 'db_nilai.id_pelajaran = db_matpel.id_pelajaran', 'left');
        $builder->where('db_nilai.id_nilai', $id);

        $query = $builder->get();
        return $query->getRow();
    }

    public function updateNilai($id, $data)
    {
        // Calculate nilai akhir
        $nilaiAkhir = ($data['nilai_tugas'] * 0.2) +
            ($data['nilai_uh'] * 0.3) +
            ($data['nilai_uts'] * 0.2) +
            ($data['nilai_uas'] * 0.3);

        $data['nilai_akhir'] = round($nilaiAkhir, 2);

        // Calculate predikat
        if ($nilaiAkhir >= 90) {
            $data['predikat'] = 'A';
        } elseif ($nilaiAkhir >= 80) {
            $data['predikat'] = 'B';
        } elseif ($nilaiAkhir >= 70) {
            $data['predikat'] = 'C';
        } elseif ($nilaiAkhir >= 60) {
            $data['predikat'] = 'D';
        } else {
            $data['predikat'] = 'E';
        }

        return $this->update($id, $data);
    }

    public function verifikasiNilai($id)
    {
        return $this->update($id, ['status_verifikasi' => 1]);
    }

    public function verifikasiNilaiMassal($ids)
    {
        $builder = $this->db->table($this->table);
        $builder->whereIn('id_nilai', $ids);
        return $builder->update(['status_verifikasi' => 1]);
    }

    public function createTable()
    {
        $forge = \Config\Database::forge();

        $fields = [
            'id_nilai' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_siswa' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'id_rombel' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'id_pelajaran' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'id_tahun_ajaran' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'semester' => [
                'type'       => 'ENUM',
                'constraint' => ['1', '2'],
                'default'    => '1',
            ],
            'nilai_tugas' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
                'default'    => 0.00,
            ],
            'nilai_uh' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
                'default'    => 0.00,
            ],
            'nilai_uts' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
                'default'    => 0.00,
            ],
            'nilai_uas' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
                'default'    => 0.00,
            ],
            'nilai_akhir' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
                'default'    => 0.00,
            ],
            'predikat' => [
                'type'       => 'VARCHAR',
                'constraint' => 2,
                'null'       => true,
            ],
            'status_verifikasi' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ];

        $forge->addField($fields);
        $forge->addKey('id_nilai', true);

        try {
            $forge->createTable('db_nilai', true);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function insertSampleData()
    {
        $sampleData = [
            [
                'id_siswa' => 1,
                'id_rombel' => 1,
                'id_pelajaran' => 1,
                'id_tahun_ajaran' => 1,
                'semester' => '1',
                'nilai_tugas' => 85.00,
                'nilai_uh' => 82.00,
                'nilai_uts' => 78.00,
                'nilai_uas' => 80.00,
                'nilai_akhir' => 81.30,
                'predikat' => 'B',
                'status_verifikasi' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_siswa' => 2,
                'id_rombel' => 1,
                'id_pelajaran' => 1,
                'id_tahun_ajaran' => 1,
                'semester' => '1',
                'nilai_tugas' => 90.00,
                'nilai_uh' => 88.00,
                'nilai_uts' => 85.00,
                'nilai_uas' => 87.00,
                'nilai_akhir' => 87.30,
                'predikat' => 'B',
                'status_verifikasi' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_siswa' => 3,
                'id_rombel' => 1,
                'id_pelajaran' => 1,
                'id_tahun_ajaran' => 1,
                'semester' => '1',
                'nilai_tugas' => 75.00,
                'nilai_uh' => 78.00,
                'nilai_uts' => 72.00,
                'nilai_uas' => 76.00,
                'nilai_akhir' => 75.60,
                'predikat' => 'C',
                'status_verifikasi' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_siswa' => 4,
                'id_rombel' => 1,
                'id_pelajaran' => 1,
                'id_tahun_ajaran' => 1,
                'semester' => '1',
                'nilai_tugas' => 88.00,
                'nilai_uh' => 85.00,
                'nilai_uts' => 80.00,
                'nilai_uas' => 83.00,
                'nilai_akhir' => 84.00,
                'predikat' => 'B',
                'status_verifikasi' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_siswa' => 5,
                'id_rombel' => 1,
                'id_pelajaran' => 1,
                'id_tahun_ajaran' => 1,
                'semester' => '1',
                'nilai_tugas' => 70.00,
                'nilai_uh' => 75.00,
                'nilai_uts' => 68.00,
                'nilai_uas' => 72.00,
                'nilai_akhir' => 71.70,
                'predikat' => 'C',
                'status_verifikasi' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_siswa' => 6,
                'id_rombel' => 1,
                'id_pelajaran' => 1,
                'id_tahun_ajaran' => 1,
                'semester' => '1',
                'nilai_tugas' => 92.00,
                'nilai_uh' => 90.00,
                'nilai_uts' => 88.00,
                'nilai_uas' => 89.00,
                'nilai_akhir' => 89.70,
                'predikat' => 'B',
                'status_verifikasi' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        return $this->insertBatch($sampleData);
    }
}
