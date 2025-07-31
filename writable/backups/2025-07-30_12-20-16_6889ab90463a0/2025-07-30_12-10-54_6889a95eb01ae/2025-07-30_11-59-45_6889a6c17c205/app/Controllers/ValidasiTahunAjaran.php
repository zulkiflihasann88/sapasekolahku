<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ValidasiTahunAjaran extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        echo "<h1>Validasi Sistem Tahun Ajaran</h1>";
        echo "<style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .section { border: 1px solid #ddd; margin: 10px 0; padding: 15px; border-radius: 5px; }
            .header { background-color: #f5f5f5; font-weight: bold; padding: 10px; margin: -15px -15px 10px -15px; }
            .success { color: green; }
            .warning { color: orange; }
            .error { color: red; }
            .data-table { border-collapse: collapse; width: 100%; margin: 10px 0; }
            .data-table th, .data-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            .data-table th { background-color: #f2f2f2; }
            .button { display: inline-block; padding: 8px 16px; margin: 5px; background-color: #007cba; color: white; text-decoration: none; border-radius: 4px; }
            .button:hover { background-color: #005a87; }
        </style>";

        // 1. Cek Session
        $this->cekSession();

        // 2. Cek Data Tahun Ajaran
        $this->cekDataTahunAjaran($db);

        // 3. Cek Data Siswa per Tahun Ajaran
        $this->cekDataSiswaPerTahunAjaran($db);

        // 4. Cek Data Rombel per Tahun Ajaran
        $this->cekDataRombelPerTahunAjaran($db);

        // 5. Cek Query Dashboard Current
        $this->cekQueryDashboard($db);

        // 6. Test Switch Tahun Ajaran
        $this->testSwitchTahunAjaran();

        echo "<br><a href='" . base_url('/validasi-tahun-ajaran/force-switch/1') . "' class='button'>Test Switch ke Tahun Ajaran ID 1</a>";
        echo "<a href='" . base_url('/validasi-tahun-ajaran/force-switch/2') . "' class='button'>Test Switch ke Tahun Ajaran ID 2</a>";
        echo "<a href='" . base_url('/validasi-tahun-ajaran/force-switch/3') . "' class='button'>Test Switch ke Tahun Ajaran ID 3</a>";
        echo "<br><a href='" . base_url('/validasi-tahun-ajaran/clear-session') . "' class='button'>Clear Session</a>";
        echo "<a href='" . base_url('/home') . "' class='button'>Lihat Dashboard</a>";
    }

    private function cekSession()
    {
        echo "<div class='section'>";
        echo "<div class='header'>1. Status Session Tahun Ajaran</div>";

        $viewingTA = session('id_tahun_ajaran_view');
        $activeTA = session('id_tahun_ajaran_aktif');
        $currentTA = getCurrentTahunAjaran();

        echo "<p><strong>Session id_tahun_ajaran_view:</strong> " . ($viewingTA ?: 'NULL') . "</p>";
        echo "<p><strong>Session id_tahun_ajaran_aktif:</strong> " . ($activeTA ?: 'NULL') . "</p>";
        echo "<p><strong>getCurrentTahunAjaran() result:</strong> " . ($currentTA ?: 'NULL') . "</p>";

        if ($currentTA) {
            echo "<p class='success'>✓ Session tahun ajaran tersedia</p>";
        } else {
            echo "<p class='error'>✗ Session tahun ajaran tidak tersedia</p>";
        }

        echo "</div>";
    }

    private function cekDataTahunAjaran($db)
    {
        echo "<div class='section'>";
        echo "<div class='header'>2. Data Tahun Ajaran di Database</div>";

        $tahunAjaranList = $db->table('db_tahunajaran')
            ->orderBy('id_tahun_ajaran', 'DESC')
            ->get()->getResult();

        echo "<table class='data-table'>";
        echo "<tr><th>ID</th><th>Nama Tahun Ajaran</th><th>Status</th></tr>";

        foreach ($tahunAjaranList as $ta) {
            $status = '';
            if (isset($ta->status) && $ta->status == 'Aktif') {
                $status = 'AKTIF';
            }
            echo "<tr>";
            echo "<td>{$ta->id_tahun_ajaran}</td>";
            echo "<td>" . (isset($ta->nama_tahun_ajaran) ? $ta->nama_tahun_ajaran : (isset($ta->tahun_ajaran) ? $ta->tahun_ajaran : 'N/A')) . "</td>";
            echo "<td>{$status}</td>";
            echo "</tr>";
        }
        echo "</table>";

        echo "</div>";
    }

    private function cekDataSiswaPerTahunAjaran($db)
    {
        echo "<div class='section'>";
        echo "<div class='header'>3. Data Siswa per Tahun Ajaran</div>";

        // Cek field name untuk tabel siswa
        $siswaFieldName = getTahunAjaranFieldName('db_siswa');
        echo "<p><strong>Field tahun ajaran di db_siswa:</strong> {$siswaFieldName}</p>";

        $siswaPerTA = $db->query("
            SELECT {$siswaFieldName} as id_tahun_ajaran, COUNT(*) as jumlah_siswa 
            FROM db_siswa 
            WHERE {$siswaFieldName} IS NOT NULL 
            GROUP BY {$siswaFieldName} 
            ORDER BY {$siswaFieldName} DESC
        ")->getResult();

        echo "<table class='data-table'>";
        echo "<tr><th>ID Tahun Ajaran</th><th>Jumlah Siswa</th></tr>";

        foreach ($siswaPerTA as $data) {
            echo "<tr>";
            echo "<td>{$data->id_tahun_ajaran}</td>";
            echo "<td>{$data->jumlah_siswa}</td>";
            echo "</tr>";
        }
        echo "</table>";

        echo "</div>";
    }

    private function cekDataRombelPerTahunAjaran($db)
    {
        echo "<div class='section'>";
        echo "<div class='header'>4. Data Rombel per Tahun Ajaran</div>";

        // Cek field name untuk tabel rombel
        $rombelFieldName = getTahunAjaranFieldName('db_rombel');
        echo "<p><strong>Field tahun ajaran di db_rombel:</strong> {$rombelFieldName}</p>";

        $rombelPerTA = $db->query("
            SELECT {$rombelFieldName} as id_tahun_ajaran, COUNT(*) as jumlah_rombel 
            FROM db_rombel 
            WHERE {$rombelFieldName} IS NOT NULL 
            GROUP BY {$rombelFieldName} 
            ORDER BY {$rombelFieldName} DESC
        ")->getResult();

        echo "<table class='data-table'>";
        echo "<tr><th>ID Tahun Ajaran</th><th>Jumlah Rombel</th></tr>";

        foreach ($rombelPerTA as $data) {
            echo "<tr>";
            echo "<td>{$data->id_tahun_ajaran}</td>";
            echo "<td>{$data->jumlah_rombel}</td>";
            echo "</tr>";
        }
        echo "</table>";

        echo "</div>";
    }

    private function cekQueryDashboard($db)
    {
        echo "<div class='section'>";
        echo "<div class='header'>5. Query Dashboard dengan Tahun Ajaran Current</div>";

        $currentTA = getCurrentTahunAjaran();
        echo "<p><strong>Tahun Ajaran Current:</strong> " . ($currentTA ?: 'NULL') . "</p>";

        if ($currentTA) {
            // Query siswa aktif
            $siswaFieldName = getTahunAjaranFieldName('db_siswa');
            $jumlahSiswa = $db->table('db_siswa')
                ->where($siswaFieldName, $currentTA)
                ->countAllResults();

            // Query rombel
            $rombelFieldName = getTahunAjaranFieldName('db_rombel');
            $jumlahRombel = $db->table('db_rombel')
                ->where($rombelFieldName, $currentTA)
                ->countAllResults();

            // Query guru (asumsi tidak ada field tahun ajaran di tabel guru)
            $jumlahGuru = $db->table('db_guru')->countAllResults();

            // Query mapel (asumsi tidak ada field tahun ajaran di tabel mapel)
            $jumlahMapel = $db->table('db_mapel')->countAllResults();

            echo "<table class='data-table'>";
            echo "<tr><th>Statistik</th><th>Jumlah</th><th>Query Field</th></tr>";
            echo "<tr><td>Siswa Aktif</td><td>{$jumlahSiswa}</td><td>db_siswa.{$siswaFieldName}</td></tr>";
            echo "<tr><td>Rombel</td><td>{$jumlahRombel}</td><td>db_rombel.{$rombelFieldName}</td></tr>";
            echo "<tr><td>Guru</td><td>{$jumlahGuru}</td><td>db_guru (no TA filter)</td></tr>";
            echo "<tr><td>Mapel</td><td>{$jumlahMapel}</td><td>db_mapel (no TA filter)</td></tr>";
            echo "</table>";
        } else {
            echo "<p class='error'>Tidak dapat menjalankan query karena tahun ajaran tidak tersedia</p>";
        }

        echo "</div>";
    }

    private function testSwitchTahunAjaran()
    {
        echo "<div class='section'>";
        echo "<div class='header'>6. Test Switch Tahun Ajaran</div>";
        echo "<p>Gunakan tombol di bawah untuk test switch tahun ajaran dan lihat perubahan data.</p>";
        echo "</div>";
    }

    public function forceSwitch($idTahunAjaran)
    {
        session()->set('id_tahun_ajaran_view', (int)$idTahunAjaran);

        // Clear cache if needed
        cache()->clean();

        return redirect()->to('/validasi-tahun-ajaran')->with('message', "Session tahun ajaran diubah ke ID: {$idTahunAjaran}");
    }

    public function clearSession()
    {
        session()->remove('id_tahun_ajaran_view');
        cache()->clean();

        return redirect()->to('/validasi-tahun-ajaran')->with('message', "Session tahun ajaran di-clear");
    }
}
