<?php
namespace App\Models;

use CodeIgniter\Model;

class MutasiModel extends Model
{
    protected $table            = 'db_mutasi';
    protected $primaryKey       = 'id_mutasi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_siswa', 'tanggal_mutasi', 'alasan_mutasi', 'tujuan_mutasi', 'keterangan',
        'jenis_pendaftaran', 'hobby', 'cita_cita', 'tanggal_pendaftaran'
    ];
    protected $useTimestamps = false;
    /**
     * Ambil data mutasi join siswa dan rombel
     * @param int $id_siswa
     * @return object|null
     */
    public function getMutasiBySiswa($id_mutasi)
    {
        $builder = $this->db->table('db_mutasi');
        $builder->select('db_mutasi.*, db_siswa.nama_siswa, db_siswa.nisn, db_siswa.tempat_lahir, db_siswa.tanggal_lahir, db_siswa.nama_ayah, db_siswa.nama_ibu, db_siswa.alamat');
        $builder->join('db_siswa', 'db_siswa.id_siswa = db_mutasi.id_siswa');
        $builder->where('db_mutasi.id_siswa', $id_mutasi);
        $query = $builder->get();
        return $query->getRow(); // return as object
    }
}
