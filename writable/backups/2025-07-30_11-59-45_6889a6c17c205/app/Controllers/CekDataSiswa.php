<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CekDataSiswa extends BaseController
{
    public function index()
    {
        $db = db_connect();

        echo "<h1>Cek Data Siswa di Database</h1>";
        echo "<style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .section { border: 1px solid #ddd; margin: 10px 0; padding: 15px; border-radius: 5px; }
            .header { background-color: #f5f5f5; font-weight: bold; padding: 10px; margin: -15px -15px 10px -15px; }
            .data-table { border-collapse: collapse; width: 100%; margin: 10px 0; }
            .data-table th, .data-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            .data-table th { background-color: #f2f2f2; }
            .alert { padding: 10px; margin: 10px 0; border-radius: 4px; }
            .alert-info { background-color: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; }
            .alert-warning { background-color: #fff3cd; border: 1px solid #ffeeba; color: #856404; }
        </style>";

        // 1. Cek Field Structure
        $this->cekStrukturTabel($db);

        // 2. Cek Sample Data
        $this->cekSampleData($db);

        // 3. Cek Distribusi Data per Tahun Ajaran
        $this->cekDistribusiTahunAjaran($db);

        // 4. Cek Data NULL
        $this->cekDataNull($db);
    }

    private function cekStrukturTabel($db)
    {
        echo "<div class='section'>";
        echo "<div class='header'>1. Struktur Tabel db_siswa</div>";

        $fields = $db->getFieldData('db_siswa');
        echo "<table class='data-table'>";
        echo "<tr><th>Field Name</th><th>Type</th><th>Null</th><th>Key</th></tr>";

        foreach ($fields as $field) {
            echo "<tr>";
            echo "<td>{$field->name}</td>";
            echo "<td>{$field->type}</td>";
            echo "<td>" . ($field->null ? 'YES' : 'NO') . "</td>";
            echo "<td>" . ($field->primary_key ? 'PRI' : '') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }

    private function cekSampleData($db)
    {
        echo "<div class='section'>";
        echo "<div class='header'>2. Sample Data Siswa (10 record pertama)</div>";

        $sampleData = $db->table('db_siswa')
            ->select('id_siswa, nama_siswa, id_tahun_ajaran, id_rombel, nis')
            ->limit(10)
            ->get()->getResult();

        echo "<table class='data-table'>";
        echo "<tr><th>ID Siswa</th><th>Nama</th><th>ID Tahun Ajaran</th><th>ID Rombel</th><th>NIS</th></tr>";

        foreach ($sampleData as $siswa) {
            echo "<tr>";
            echo "<td>{$siswa->id_siswa}</td>";
            echo "<td>{$siswa->nama_siswa}</td>";
            echo "<td>" . ($siswa->id_tahun_ajaran ?: 'NULL') . "</td>";
            echo "<td>" . ($siswa->id_rombel ?: 'NULL') . "</td>";
            echo "<td>" . ($siswa->nis ?: 'NULL') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }

    private function cekDistribusiTahunAjaran($db)
    {
        echo "<div class='section'>";
        echo "<div class='header'>3. Distribusi Siswa per Tahun Ajaran</div>";

        $distribusi = $db->query("
            SELECT 
                COALESCE(id_tahun_ajaran, 'NULL') as tahun_ajaran,
                COUNT(*) as jumlah_siswa
            FROM db_siswa 
            GROUP BY id_tahun_ajaran 
            ORDER BY id_tahun_ajaran
        ")->getResult();

        echo "<table class='data-table'>";
        echo "<tr><th>ID Tahun Ajaran</th><th>Jumlah Siswa</th></tr>";

        $totalSiswa = 0;
        foreach ($distribusi as $data) {
            echo "<tr>";
            echo "<td>{$data->tahun_ajaran}</td>";
            echo "<td>{$data->jumlah_siswa}</td>";
            echo "</tr>";
            $totalSiswa += $data->jumlah_siswa;
        }
        echo "<tr style='font-weight: bold;'>";
        echo "<td>TOTAL</td>";
        echo "<td>{$totalSiswa}</td>";
        echo "</tr>";
        echo "</table>";

        // Warning jika semua data NULL atau sama
        if (count($distribusi) == 1) {
            echo "<div class='alert alert-warning'>";
            echo "<strong>PERINGATAN:</strong> Semua siswa memiliki id_tahun_ajaran yang sama atau NULL. ";
            echo "Ini menyebabkan tidak ada perubahan data saat switch tahun ajaran.";
            echo "</div>";
        }
        echo "</div>";
    }

    private function cekDataNull($db)
    {
        echo "<div class='section'>";
        echo "<div class='header'>4. Analisis Data NULL</div>";

        $totalSiswa = $db->table('db_siswa')->countAllResults();
        $siswaWithTA = $db->table('db_siswa')->where('id_tahun_ajaran IS NOT NULL')->countAllResults();
        $siswaWithoutTA = $totalSiswa - $siswaWithTA;

        echo "<table class='data-table'>";
        echo "<tr><th>Kategori</th><th>Jumlah</th><th>Persentase</th></tr>";
        echo "<tr><td>Total Siswa</td><td>{$totalSiswa}</td><td>100%</td></tr>";
        echo "<tr><td>Siswa dengan ID Tahun Ajaran</td><td>{$siswaWithTA}</td><td>" . ($totalSiswa > 0 ? round($siswaWithTA / $totalSiswa * 100, 2) : 0) . "%</td></tr>";
        echo "<tr><td>Siswa tanpa ID Tahun Ajaran (NULL)</td><td>{$siswaWithoutTA}</td><td>" . ($totalSiswa > 0 ? round($siswaWithoutTA / $totalSiswa * 100, 2) : 0) . "%</td></tr>";
        echo "</table>";

        if ($siswaWithoutTA > 0) {
            echo "<div class='alert alert-warning'>";
            echo "<strong>MASALAH DITEMUKAN:</strong> Ada {$siswaWithoutTA} siswa yang tidak memiliki id_tahun_ajaran (NULL). ";
            echo "Data ini tidak akan muncul dalam filter tahun ajaran dan perlu diperbaiki.";
            echo "</div>";
        }

        if ($siswaWithTA == 0) {
            echo "<div class='alert alert-warning'>";
            echo "<strong>MASALAH UTAMA:</strong> Tidak ada siswa yang memiliki id_tahun_ajaran yang valid. ";
            echo "Semua data siswa memiliki id_tahun_ajaran = NULL. Sistem filter tahun ajaran tidak akan berfungsi.";
            echo "</div>";
        }

        echo "</div>";
    }
}
