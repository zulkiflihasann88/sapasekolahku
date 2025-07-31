<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TenagaKependidikanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_lengkap' => 'Ahmad Susanto, S.Pd.',
                'nip' => '197801012005011001',
                'nuptk' => '1234567890123456',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1978-01-01',
                'agama' => 'Islam',
                'alamat' => 'Jl. Pendidikan No. 123, Jakarta',
                'telepon' => '081234567890',
                'email' => 'ahmad.susanto@sekolah.sch.id',
                'pendidikan_terakhir' => 'S1 Pendidikan',
                'jabatan' => 'Kepala Tata Usaha',
                'status_kepegawaian' => 'PNS',
                'tmt_kerja' => '2005-01-01',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_lengkap' => 'Siti Nurhaliza, A.Md.',
                'nip' => '198506152010022001',
                'nuptk' => '2345678901234567',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1985-06-15',
                'agama' => 'Islam',
                'alamat' => 'Jl. Administrasi No. 456, Bandung',
                'telepon' => '082345678901',
                'email' => 'siti.nurhaliza@sekolah.sch.id',
                'pendidikan_terakhir' => 'D3 Administrasi',
                'jabatan' => 'Staff Administrasi',
                'status_kepegawaian' => 'PNS',
                'tmt_kerja' => '2010-02-01',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_lengkap' => 'Budi Santoso',
                'nip' => '',
                'nuptk' => '',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1990-03-20',
                'agama' => 'Islam',
                'alamat' => 'Jl. Kebersihan No. 789, Surabaya',
                'telepon' => '083456789012',
                'email' => '',
                'pendidikan_terakhir' => 'SMA',
                'jabatan' => 'Cleaning Service',
                'status_kepegawaian' => 'Honorer',
                'tmt_kerja' => '2020-01-15',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_lengkap' => 'Indah Permatasari, S.Kom.',
                'nip' => '',
                'nuptk' => '3456789012345678',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '1992-08-10',
                'agama' => 'Kristen',
                'alamat' => 'Jl. Teknologi No. 321, Yogyakarta',
                'telepon' => '084567890123',
                'email' => 'indah.permatasari@sekolah.sch.id',
                'pendidikan_terakhir' => 'S1 Sistem Informasi',
                'jabatan' => 'Operator Komputer',
                'status_kepegawaian' => 'Kontrak',
                'tmt_kerja' => '2022-09-01',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_lengkap' => 'Joko Widodo',
                'nip' => '',
                'nuptk' => '',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Solo',
                'tanggal_lahir' => '1975-12-05',
                'agama' => 'Islam',
                'alamat' => 'Jl. Keamanan No. 555, Solo',
                'telepon' => '085678901234',
                'email' => '',
                'pendidikan_terakhir' => 'SMP',
                'jabatan' => 'Satpam',
                'status_kepegawaian' => 'Honorer',
                'tmt_kerja' => '2015-07-01',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert data
        $this->db->table('tenaga_kependidikan')->insertBatch($data);
    }
}
