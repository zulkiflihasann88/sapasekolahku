<?php

namespace App\Models;

use CodeIgniter\Model;

class SpmbModel extends Model
{

    protected $table            = 'db_calonpeserta';
    protected $primaryKey       = 'id_peserta';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        // Data Pribadi
        'id_peserta',
        'no_pendaftaran',
        'nama_peserta',
        'jenis_kelamin',
        'nisn',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'id_agama',
        'id_tahun',
        'kewarganegaraan',
        'id_berkebutuhankhusus',
        'alamat',
        'nama_dusun',
        'rt',
        'rw',
        'provinsi',
        'kabupaten',
        'nama_kelurahan',
        'kelurahan',
        'kecamatan',
        'kode_pos',
        'id_tempat_tinggal',
        'id_moda_transportasi',
        'penerima_kps_pkh',
        'no_kps_pkh',
        'nama_ayah',
        'nik_ayah',
        'tahun_lahir_ayah',
        'id_pendidikan_ayah',
        'id_pekerjaan_ayah',
        'id_penghasilan_bulanan_ayah',
        'id_berkebutuhan_khusus_ayah',
        'nama_ibu',
        'nik_ibu',
        'tahun_lahir_ibu',
        'id_pendidikan_ibu',
        'id_pekerjaan_ibu',
        'id_penghasilan_bulanan_ibu',
        'id_berkebutuhan_khusus_ibu',
        'no_telepon_rumah',
        'nomor_hp',
        'email',
        'sekolah_asal',
        'npsn_asal',
        'alamat_sekolah_asal',
        'status_daftar_ulang',
        'jalur',
        'status_hasil', // <-- allow this field for update
        'status_pendaftaran',
        'nomor_kk',
        'nomor_akta_kelahiran',
        'anak_ke',
        'punya_kip',
        'nomor_kip',
        'penerima_kip',
        'no_kip',
        'tanggal_daftar',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];
    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    =  'datetime';
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getAll()
    {
        $builder = $this->db->table('db_calonpeserta');
        $builder->select('db_calonpeserta.*, db_tpenerimaan.tahun_pelajaran AS tahun_pelajaran_penerimaan');
        $builder->join('db_tpenerimaan', 'db_tpenerimaan.id_tahun = db_calonpeserta.id_tahun', 'left');
        $builder->join('db_agama', 'db_agama.id_agama = db_calonpeserta.id_agama', 'left')
            ->join('db_transportasi', 'db_transportasi.id_transportasi = db_calonpeserta.id_moda_transportasi', 'left')
            ->join('db_disability', 'db_disability.id_disability = db_calonpeserta.id_berkebutuhan_khusus_ayah', 'left')
            ->join('db_tempat_tinggal', 'db_tempat_tinggal.id_tempat_tinggal = db_calonpeserta.id_tempat_tinggal', 'left')
            ->join('db_pekerjaan AS pekerjaan_ayah', 'pekerjaan_ayah.id_pekerjaan = db_calonpeserta.id_pekerjaan_ayah', 'left')
            ->join('db_pekerjaan AS pekerjaan_ibu', 'pekerjaan_ibu.id_pekerjaan = db_calonpeserta.id_pekerjaan_ibu', 'left')
            ->join('db_penghasilan AS penghasilan_ayah', 'penghasilan_ayah.id_penghasilan = db_calonpeserta.id_penghasilan_bulanan_ayah', 'left')
            ->join('db_penghasilan AS penghasilan_ibu', 'penghasilan_ibu.id_penghasilan = db_calonpeserta.id_penghasilan_bulanan_ibu', 'left')
            ->join('db_pendidikan AS pendidikan_ayah', 'pendidikan_ayah.id_pendidikan = db_calonpeserta.id_pendidikan_ayah', 'left')
            ->join('db_pendidikan AS pendidikan_ibu', 'pendidikan_ibu.id_pendidikan = db_calonpeserta.id_pendidikan_ibu', 'left');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getByCalonSiswaId($id_peserta)
    {
        $builder = $this->db->table('db_calonpeserta');
        $builder->select('db_calonpeserta.*, db_tpenerimaan.tahun_pelajaran AS tahun_pelajaran_penerimaan');
        $builder->join('db_tpenerimaan', 'db_tpenerimaan.id_tahun = db_calonpeserta.id_tahun', 'left');
        $builder->join('db_agama', 'db_agama.id_agama = db_calonpeserta.id_agama', 'left')
            ->join('db_transportasi', 'db_transportasi.id_transportasi = db_calonpeserta.id_moda_transportasi', 'left')
            ->join('db_disability', 'db_disability.id_disability = db_calonpeserta.id_berkebutuhan_khusus_ayah', 'left')
            ->join('db_tempat_tinggal', 'db_tempat_tinggal.id_tempat_tinggal = db_calonpeserta.id_tempat_tinggal', 'left')
            ->join('db_pekerjaan AS pekerjaan_ayah', 'pekerjaan_ayah.id_pekerjaan = db_calonpeserta.id_pekerjaan_ayah', 'left')
            ->join('db_pekerjaan AS pekerjaan_ibu', 'pekerjaan_ibu.id_pekerjaan = db_calonpeserta.id_pekerjaan_ibu', 'left')
            ->join('db_penghasilan AS penghasilan_ayah', 'penghasilan_ayah.id_penghasilan = db_calonpeserta.id_penghasilan_bulanan_ayah', 'left')
            ->join('db_penghasilan AS penghasilan_ibu', 'penghasilan_ibu.id_penghasilan = db_calonpeserta.id_penghasilan_bulanan_ibu', 'left')
            ->join('db_pendidikan AS pendidikan_ayah', 'pendidikan_ayah.id_pendidikan = db_calonpeserta.id_pendidikan_ayah', 'left')
            ->join('db_pendidikan AS pendidikan_ibu', 'pendidikan_ibu.id_pendidikan = db_calonpeserta.id_pendidikan_ibu', 'left');
        $builder->where('db_calonpeserta.id_peserta', $id_peserta);
        $query = $builder->get();
        return $query->getRow();
    }
}
