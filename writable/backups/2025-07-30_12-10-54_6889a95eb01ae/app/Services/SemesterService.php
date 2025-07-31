<?php

namespace App\Services;

use CodeIgniter\Database\ConnectionInterface;

class SemesterService
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    /**
     * Backup data semester sebelum pindah ke semester baru
     */
    public function backupCurrentSemester($id_tahun_ajaran, $semester)
    {
        try {
            $this->db->transBegin();

            // 1. Backup data siswa per rombel
            $this->backupSiswaData($id_tahun_ajaran, $semester);

            // 2. Backup data rombel
            $this->backupRombelData($id_tahun_ajaran, $semester);

            $this->db->transCommit();
            return ['success' => true, 'message' => 'Data semester berhasil di-backup'];
        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'Error backup semester: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal backup data: ' . $e->getMessage()];
        }
    }

    /**
     * Backup data siswa
     */
    private function backupSiswaData($id_tahun_ajaran, $semester)
    {
        $siswaData = $this->db->query("
            SELECT 
                s.id_siswa,
                s.id_rombel,
                ? as id_tahun_ajaran,
                ? as semester,
                CASE 
                    WHEN m.id_siswa IS NOT NULL THEN 'mutasi'
                    ELSE 'aktif'
                END as status_siswa,
                NOW() as tanggal_snapshot,
                NOW() as created_at
            FROM db_siswa s
            LEFT JOIN db_mutasi m ON s.id_siswa = m.id_siswa
            WHERE s.id_rombel IN (
                SELECT id_rombel FROM db_rombel WHERE id_tahun = ?
            )
        ", [$id_tahun_ajaran, $semester, $id_tahun_ajaran])->getResult();

        if (!empty($siswaData)) {
            $this->db->table('db_siswa_semester_history')->insertBatch($siswaData);
        }
    }

    /**
     * Backup data rombel
     */
    private function backupRombelData($id_tahun_ajaran, $semester)
    {
        $rombelData = $this->db->query("
            SELECT 
                r.id_rombel,
                ? as id_tahun_ajaran,
                ? as semester,
                r.kelas,
                r.rombel,
                r.wali_kelas,
                COUNT(s.id_siswa) as jumlah_siswa,
                NOW() as tanggal_snapshot,
                NOW() as created_at
            FROM db_rombel r
            LEFT JOIN db_siswa s ON r.id_rombel = s.id_rombel
            WHERE r.id_tahun = ?
            GROUP BY r.id_rombel
        ", [$id_tahun_ajaran, $semester, $id_tahun_ajaran])->getResult();

        if (!empty($rombelData)) {
            $this->db->table('db_rombel_semester_history')->insertBatch($rombelData);
        }
    }

    /**
     * Pindah ke semester baru
     */
    public function changeSemester($id_tahun_ajaran, $semester_baru, $tanggal_mulai, $tanggal_selesai, $keterangan = null)
    {
        try {
            $this->db->transBegin();

            // 1. Nonaktifkan semester sebelumnya
            $this->db->table('db_semester_setting')
                ->where('status', 'aktif')
                ->update(['status' => 'non_aktif', 'updated_at' => date('Y-m-d H:i:s')]);

            // 2. Backup data semester sebelumnya jika ada semester aktif
            $currentSemester = $this->getCurrentActiveSemester();
            if ($currentSemester) {
                $this->backupCurrentSemester($currentSemester->id_tahun_ajaran, $currentSemester->semester);
            }

            // 3. Aktifkan semester baru
            $newSemesterData = [
                'id_tahun_ajaran' => $id_tahun_ajaran,
                'semester' => $semester_baru,
                'status' => 'aktif',
                'tanggal_mulai' => $tanggal_mulai,
                'tanggal_selesai' => $tanggal_selesai,
                'keterangan' => $keterangan,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->table('db_semester_setting')->insert($newSemesterData);

            // 4. Update session dengan semester baru
            session()->set([
                'id_tahun_ajaran_aktif' => $id_tahun_ajaran,
                'semester_aktif' => $semester_baru,
                'tanggal_mulai_semester' => $tanggal_mulai,
                'tanggal_selesai_semester' => $tanggal_selesai
            ]);

            $this->db->transCommit();
            return ['success' => true, 'message' => 'Berhasil pindah ke semester ' . $semester_baru];
        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'Error change semester: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal pindah semester: ' . $e->getMessage()];
        }
    }

    /**
     * Get semester aktif saat ini
     */
    public function getCurrentActiveSemester()
    {
        return $this->db->table('db_semester_setting')
            ->where('status', 'aktif')
            ->get()
            ->getRow();
    }

    /**
     * Get history data siswa per semester
     */
    public function getSiswaHistoryBySemester($id_tahun_ajaran, $semester)
    {
        return $this->db->query("
            SELECT 
                ssh.*,
                s.nama_siswa,
                s.nisn,
                s.nis,
                r.kelas,
                r.rombel
            FROM db_siswa_semester_history ssh
            JOIN db_siswa s ON ssh.id_siswa = s.id_siswa
            LEFT JOIN db_rombel r ON ssh.id_rombel = r.id_rombel
            WHERE ssh.id_tahun_ajaran = ? AND ssh.semester = ?
            ORDER BY r.kelas, r.rombel, s.nama_siswa
        ", [$id_tahun_ajaran, $semester])->getResult();
    }

    /**
     * Get history data rombel per semester
     */
    public function getRombelHistoryBySemester($id_tahun_ajaran, $semester)
    {
        return $this->db->query("
            SELECT 
                rsh.*,
                p.nama as nama_wali_kelas
            FROM db_rombel_semester_history rsh
            LEFT JOIN db_pendidik p ON rsh.wali_kelas = p.id_pendidik
            WHERE rsh.id_tahun_ajaran = ? AND rsh.semester = ?
            ORDER BY rsh.kelas, rsh.rombel
        ", [$id_tahun_ajaran, $semester])->getResult();
    }

    /**
     * Naik kelas otomatis untuk semester genap ke ganjil
     */
    public function naikKelasOtomatis($id_tahun_ajaran_lama, $id_tahun_ajaran_baru)
    {
        try {
            $this->db->transBegin();

            // Mapping kenaikan kelas
            $kelasMapping = [
                'X' => 'XI',
                'XI' => 'XII',
                'XII' => 'LULUS'
            ];

            foreach ($kelasMapping as $kelasLama => $kelasBaru) {
                if ($kelasBaru === 'LULUS') {
                    // Siswa kelas XII otomatis lulus
                    $this->luluskanSiswaKelas12($id_tahun_ajaran_lama);
                } else {
                    // Naikkan kelas siswa
                    $this->naikkanKelas($id_tahun_ajaran_lama, $id_tahun_ajaran_baru, $kelasLama, $kelasBaru);
                }
            }

            $this->db->transCommit();
            return ['success' => true, 'message' => 'Kenaikan kelas berhasil dilakukan'];
        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'Error naik kelas: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal naik kelas: ' . $e->getMessage()];
        }
    }

    /**
     * Luluskan siswa kelas XII
     */
    private function luluskanSiswaKelas12($id_tahun_ajaran)
    {
        $siswaKelas12 = $this->db->query("
            SELECT s.id_siswa 
            FROM db_siswa s
            JOIN db_rombel r ON s.id_rombel = r.id_rombel
            WHERE r.id_tahun = ? AND r.kelas = 'XII'
        ", [$id_tahun_ajaran])->getResult();

        foreach ($siswaKelas12 as $siswa) {
            // Insert ke tabel mutasi sebagai lulus
            $this->db->table('db_mutasi')->insert([
                'id_siswa' => $siswa->id_siswa,
                'tanggal_mutasi' => date('Y-m-d'),
                'alasan_mutasi' => 'Lulus',
                'keterangan_mutasi' => 'Lulus otomatis kenaikan kelas',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Naikkan kelas siswa
     */
    private function naikkanKelas($id_tahun_ajaran_lama, $id_tahun_ajaran_baru, $kelasLama, $kelasBaru)
    {
        // Get siswa dari kelas lama
        $siswaNaik = $this->db->query("
            SELECT s.id_siswa, s.nama_siswa
            FROM db_siswa s
            JOIN db_rombel r ON s.id_rombel = r.id_rombel
            WHERE r.id_tahun = ? AND r.kelas = ?
            AND s.id_siswa NOT IN (SELECT id_siswa FROM db_mutasi)
        ", [$id_tahun_ajaran_lama, $kelasLama])->getResult();

        // Get rombel kelas baru
        $rombelBaru = $this->db->query("
            SELECT id_rombel, kelas, rombel
            FROM db_rombel 
            WHERE id_tahun = ? AND kelas = ?
            ORDER BY rombel
        ", [$id_tahun_ajaran_baru, $kelasBaru])->getResult();

        if (empty($rombelBaru)) {
            throw new \Exception("Rombel untuk kelas {$kelasBaru} belum dibuat");
        }

        // Distribusi siswa ke rombel baru
        $currentRombelIndex = 0;
        $siswaPerRombel = ceil(count($siswaNaik) / count($rombelBaru));
        $currentCount = 0;

        foreach ($siswaNaik as $siswa) {
            if ($currentCount >= $siswaPerRombel && $currentRombelIndex < count($rombelBaru) - 1) {
                $currentRombelIndex++;
                $currentCount = 0;
            }

            // Update rombel siswa
            $this->db->table('db_siswa')
                ->where('id_siswa', $siswa->id_siswa)
                ->update(['id_rombel' => $rombelBaru[$currentRombelIndex]->id_rombel]);

            $currentCount++;
        }
    }

    /**
     * Get daftar semester yang tersedia
     */
    public function getAvailableSemesters()
    {
        return $this->db->query("
            SELECT 
                ss.*,
                ta.ket_tahun,
                ta.tahun
            FROM db_semester_setting ss
            JOIN db_tahunajaran ta ON ss.id_tahun_ajaran = ta.id_tahun_ajaran
            ORDER BY ta.tahun DESC, ss.semester DESC
        ")->getResult();
    }

    /**
     * Memperbarui data semester tanpa mengubah data semester sebelumnya
     */
    public function updateSemesterData($id_tahun_ajaran, $semester, $data)
    {
        try {
            $this->db->transBegin();

            // 1. Simpan versi terbaru dari data semester yang akan diperbarui
            $this->backupCurrentSemester($id_tahun_ajaran, $semester);

            // 2. Perbarui data berdasarkan jenis data yang diupdate
            if (isset($data['rombel_update']) && is_array($data['rombel_update'])) {
                foreach ($data['rombel_update'] as $rombelData) {
                    $this->db->table('db_rombel')
                        ->where('id_rombel', $rombelData['id_rombel'])
                        ->where('id_tahun', $id_tahun_ajaran)
                        ->update($rombelData['data']);
                }
            }

            if (isset($data['siswa_update']) && is_array($data['siswa_update'])) {
                foreach ($data['siswa_update'] as $siswaData) {
                    $this->db->table('db_siswa')
                        ->where('id_siswa', $siswaData['id_siswa'])
                        ->update($siswaData['data']);
                }
            }

            if (isset($data['nilai_update']) && is_array($data['nilai_update'])) {
                foreach ($data['nilai_update'] as $nilaiData) {
                    // Cek apakah nilai untuk siswa, matpel, tahun ajaran dan semester sudah ada
                    $existingNilai = $this->db->table('db_nilai_semester')
                        ->where('id_siswa', $nilaiData['id_siswa'])
                        ->where('id_matpel', $nilaiData['id_matpel'])
                        ->where('id_tahun_ajaran', $id_tahun_ajaran)
                        ->where('semester', $semester)
                        ->get()
                        ->getRow();

                    if ($existingNilai) {
                        // Update nilai yang sudah ada
                        $this->db->table('db_nilai_semester')
                            ->where('id_nilai_semester', $existingNilai->id_nilai_semester)
                            ->update(array_merge($nilaiData, [
                                'updated_at' => date('Y-m-d H:i:s')
                            ]));
                    } else {
                        // Insert nilai baru
                        $this->db->table('db_nilai_semester')
                            ->insert(array_merge($nilaiData, [
                                'id_tahun_ajaran' => $id_tahun_ajaran,
                                'semester' => $semester,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ]));
                    }
                }
            }

            $this->db->transCommit();
            return [
                'success' => true,
                'message' => 'Data semester ' . $semester . ' tahun ajaran ' . $id_tahun_ajaran . ' berhasil diperbarui'
            ];
        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'Error updating semester data: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal memperbarui data semester: ' . $e->getMessage()];
        }
    }

    /**
     * Memulihkan data semester dari backup
     */
    public function restoreSemesterData($id_tahun_ajaran, $semester, $tanggal_backup)
    {
        try {
            $this->db->transBegin();

            // Ambil data siswa dari history
            $siswaHistory = $this->db->table('db_siswa_semester_history')
                ->where('id_tahun_ajaran', $id_tahun_ajaran)
                ->where('semester', $semester)
                ->where('DATE(tanggal_snapshot)', $tanggal_backup)
                ->get()
                ->getResult();

            // Ambil data rombel dari history
            $rombelHistory = $this->db->table('db_rombel_semester_history')
                ->where('id_tahun_ajaran', $id_tahun_ajaran)
                ->where('semester', $semester)
                ->where('DATE(tanggal_snapshot)', $tanggal_backup)
                ->get()
                ->getResult();

            // Proses pemulihan data siswa
            foreach ($siswaHistory as $siswa) {
                $this->db->table('db_siswa')
                    ->where('id_siswa', $siswa->id_siswa)
                    ->update(['id_rombel' => $siswa->id_rombel]);
            }

            // Proses pemulihan data rombel
            foreach ($rombelHistory as $rombel) {
                $this->db->table('db_rombel')
                    ->where('id_rombel', $rombel->id_rombel)
                    ->update([
                        'kelas' => $rombel->kelas,
                        'rombel' => $rombel->rombel,
                        'wali_kelas' => $rombel->wali_kelas
                    ]);
            }

            $this->db->transCommit();
            return [
                'success' => true,
                'message' => 'Data semester ' . $semester . ' tahun ajaran ' . $id_tahun_ajaran . ' berhasil dipulihkan'
            ];
        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'Error restoring semester data: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal memulihkan data semester: ' . $e->getMessage()];
        }
    }

    /**
     * Mendapatkan daftar tanggal backup yang tersedia untuk semester tertentu
     */
    public function getAvailableBackups($id_tahun_ajaran, $semester)
    {
        return $this->db->query("
            SELECT DISTINCT DATE(tanggal_snapshot) as tanggal_backup
            FROM db_siswa_semester_history
            WHERE id_tahun_ajaran = ? AND semester = ?
            ORDER BY tanggal_snapshot DESC
        ", [$id_tahun_ajaran, $semester])->getResult();
    }

    /**
     * Login ke tahun ajaran tertentu
     * Fungsi ini mengubah tahun ajaran aktif di session tanpa mengubah status di database
     */
    public function switchTahunAjaran($id_tahun_ajaran)
    {
        try {
            // Validasi tahun ajaran ada
            $tahunAjaran = $this->db->table('db_tahunajaran')
                ->where('id_tahun_ajaran', $id_tahun_ajaran)
                ->get()->getRow();

            if (!$tahunAjaran) {
                return ['success' => false, 'message' => 'Tahun ajaran tidak ditemukan'];
            }

            // Ambil data semester yang tersedia untuk tahun ajaran ini
            $semesterData = $this->db->table('db_semester_setting')
                ->where('id_tahun_ajaran', $id_tahun_ajaran)
                ->orderBy('semester', 'DESC')
                ->get()->getRow();

            // Jika tidak ada setting semester, gunakan default semester 1
            $semester = $semesterData ? $semesterData->semester : 1;
            $tanggal_mulai = $semesterData ? $semesterData->tanggal_mulai : date('Y-m-d');
            $tanggal_selesai = $semesterData ? $semesterData->tanggal_selesai : date('Y-m-d', strtotime('+6 months'));

            // Simpan di session user
            session()->set([
                'id_tahun_ajaran_view' => $id_tahun_ajaran,
                'semester_view' => $semester,
                'tahun_view' => $tahunAjaran->tahun,
                'ket_tahun_view' => $tahunAjaran->ket_tahun,
                'tanggal_mulai_view' => $tanggal_mulai,
                'tanggal_selesai_view' => $tanggal_selesai
            ]);

            return [
                'success' => true,
                'message' => 'Berhasil beralih ke tahun ajaran ' . $tahunAjaran->ket_tahun,
                'tahun_ajaran' => $tahunAjaran
            ];
        } catch (\Exception $e) {
            log_message('error', 'Error switching tahun ajaran: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal beralih tahun ajaran: ' . $e->getMessage()];
        }
    }
    /**
     * Mendapatkan tahun ajaran yang sedang dilihat
     */
    public function getViewingTahunAjaran()
    {
        $id_tahun_ajaran_view = session()->get('id_tahun_ajaran_view');

        if (!$id_tahun_ajaran_view) {
            // Jika tidak ada di session, gunakan tahun ajaran aktif
            $activeTapel = $this->db->table('db_tahunajaran')
                ->where('status', 'Aktif')
                ->orderBy('tahun', 'DESC')
                ->limit(1)
                ->get()->getRow();

            if ($activeTapel) {
                // Set session dengan tahun ajaran aktif
                if (isset($activeTapel->id_tahun_ajaran)) {
                    $this->switchTahunAjaran($activeTapel->id_tahun_ajaran);
                    return $activeTapel;
                }
            }

            return null;
        }

        // Ambil data tahun ajaran dari database
        return $this->db->table('db_tahunajaran')
            ->where('id_tahun_ajaran', $id_tahun_ajaran_view)
            ->get()->getRow();
    }

    /**
     * Reset view tahun ajaran ke tahun ajaran aktif
     */
    public function resetTahunAjaranView()
    {
        // Hapus session tahun ajaran view
        session()->remove([
            'id_tahun_ajaran_view',
            'semester_view',
            'tahun_view',
            'ket_tahun_view',
            'tanggal_mulai_view',
            'tanggal_selesai_view'
        ]);

        // Set ke tahun ajaran aktif
        $activeTapel = $this->db->table('db_tahunajaran')
            ->where('status', 'Aktif')
            ->orderBy('tahun', 'DESC')
            ->limit(1)
            ->get()->getRow();

        if ($activeTapel) {
            return $this->switchTahunAjaran($activeTapel->id_tahun_ajaran);
        }

        return ['success' => false, 'message' => 'Tidak ada tahun ajaran aktif'];
    }
}
