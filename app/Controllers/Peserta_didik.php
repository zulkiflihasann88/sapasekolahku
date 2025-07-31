<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\MutasiModel;
use App\Models\SiswaModel;

class Peserta_didik extends Controller
{
    /**
     * Show form to edit an existing student
     */
    public function edit($id)
    {
        $db = \Config\Database::connect();
        // Fetch student data
        $peserta_didik = $db->table('db_siswa')->where('id_siswa', $id)->get()->getRow();
        if (!$peserta_didik) {
            return redirect()->to('peserta_didik')->with('error', 'Data siswa tidak ditemukan.');
        }
        // Fetch supporting data for selects
        $agama = $db->table('db_agama')->get()->getResult();
        $disability = $db->table('db_disability')->get()->getResult();
        $tinggal = $db->table('db_tempat_tinggal')->get()->getResult();
        $transport = $db->table('db_transportasi')->get()->getResult();
        $rombel = $db->table('db_rombel')->orderBy('kelas', 'ASC')->orderBy('rombel', 'ASC')->get()->getResult();
        $pendidikan = $db->table('db_pendidikan')->get()->getResult();
        $pekerjaan = $db->table('db_pekerjaan')->get()->getResult();
        $penghasilan = $db->table('db_penghasilan')->get()->getResult();
        // Use TapelModel to get tahun ajaran with ket_tahun
        $tapelModel = new \App\Models\TapelModel();
        $tahun_ajaran = $tapelModel->findAll();
        // Fetch prestasi if needed
        $prestasi = $db->table('db_prestasi')->where('id_siswa', $id)->get()->getResult();
        // Pass all data to the view
        return view('peserta didik/edit', compact('peserta_didik', 'agama', 'disability', 'tinggal', 'transport', 'rombel', 'pendidikan', 'pekerjaan', 'penghasilan', 'tahun_ajaran', 'prestasi'));
    }
    /**
     * Validasi satu siswa hasil tarik: generate NIS, insert ke db_siswa, hapus dari session
     */
    /**
     * Show form to add a new student
     */
    public function new()
    {
        $db = \Config\Database::connect();
        $agama = $db->table('db_agama')->get()->getResult();
        $disability = $db->table('db_disability')->get()->getResult();
        $tinggal = $db->table('db_tempat_tinggal')->get()->getResult();
        $transport = $db->table('db_transportasi')->get()->getResult();
        $rombel = $db->table('db_rombel')->orderBy('kelas', 'ASC')->orderBy('rombel', 'ASC')->get()->getResult();
        $pendidikan = $db->table('db_pendidikan')->get()->getResult();
        $pekerjaan = $db->table('db_pekerjaan')->get()->getResult();
        // Ambil NIS terakhir dari db_siswa, urutkan numerik
        $lastNisRow = $db->table('db_siswa')
            ->select('nis')
            ->orderBy('CAST(nis AS UNSIGNED)', 'DESC')
            ->get(1)
            ->getRow();
        $nis = '';
        if ($lastNisRow && is_numeric($lastNisRow->nis)) {
            $nis = (string)($lastNisRow->nis + 1);
        }
        $tahun_ajaran = $db->table('db_tahunajaran')->orderBy('id_tahun_ajaran', 'DESC')->get()->getResult();
        return view('peserta didik/new', compact('agama', 'disability', 'tinggal', 'transport', 'rombel', 'pendidikan', 'pekerjaan', 'nis', 'tahun_ajaran'));
    }
    public function validasi_siswa()
    {
        $session = session();
        $db = \Config\Database::connect();
        $request = service('request');
        $data = $request->getPost('siswa');
        if (!$data) {
            return redirect()->to('peserta_didik/validasi')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Generate NIS
        $siswaModel = new SiswaModel();
        $rombelInfo = null;
        if (!empty($data['id_rombel'])) {
            $rombelInfo = $db->table('db_rombel')->where('id_rombel', $data['id_rombel'])->get()->getRow();
        }
        $isNewStudent = false;
        $isTransferStudent = false;
        if ($rombelInfo && !empty($rombelInfo->kelas)) {
            $isNewStudent = (strtolower($rombelInfo->kelas) === '1' || strtolower($rombelInfo->kelas) === 'i' || strpos(strtolower($rombelInfo->kelas), 'kelas 1') !== false);
            if (!$isNewStudent) {
                $isTransferStudent = true;
            }
        }
        $studentName = $data['nama_siswa'] ?? '';
        $entryDate = $data['tanggal_pendaftaran'] ?? null;
        $generatedNIS = $siswaModel->generateNIS($isNewStudent, $isTransferStudent, $studentName, $entryDate);
        $data['nis'] = $generatedNIS;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        // Insert ke db_siswa
        $insertResult = $db->table('db_siswa')->insert($data);
        if ($insertResult) {
            // Hapus dari session siswa_validasi
            $siswa_validasi = $session->get('siswa_validasi') ?? [];
            // Cari dan hapus siswa yang sudah divalidasi
            foreach ($siswa_validasi as $i => $row) {
                if (
                    (isset($row['nisn']) && isset($data['nisn']) && $row['nisn'] === $data['nisn']) ||
                    (isset($row['nik']) && isset($data['nik']) && $row['nik'] === $data['nik'])
                ) {
                    unset($siswa_validasi[$i]);
                    break;
                }
            }
            $session->set('siswa_validasi', array_values($siswa_validasi));
            return redirect()->to('peserta_didik/validasi')->with('success', 'Siswa berhasil divalidasi dan dimasukkan ke database.');
        } else {
            return redirect()->to('peserta_didik/validasi')->with('error', 'Gagal validasi siswa.');
        }
    }

    public function savePrestasi($id_siswa)
    {
        $db = \Config\Database::connect();
        $request = service('request');

        // Get the prestasi data from the form
        $prestasi_nama = $request->getPost('prestasi_nama');
        $prestasi_tingkat = $request->getPost('prestasi_tingkat');
        $prestasi_juara = $request->getPost('prestasi_juara');
        $prestasi_tanggal = $request->getPost('prestasi_tanggal');
        $prestasi_penyelenggara = $request->getPost('prestasi_penyelenggara');
        $prestasi_keterangan = $request->getPost('prestasi_keterangan');

        if (!empty($prestasi_nama)) {
            // Delete existing prestasi for this student
            $db->table('db_prestasi')->where('id_siswa', $id_siswa)->delete();

            // Insert new prestasi
            for ($i = 0; $i < count($prestasi_nama); $i++) {
                if (!empty($prestasi_nama[$i])) {
                    $db->table('db_prestasi')->insert([
                        'id_siswa' => $id_siswa,
                        'nama_prestasi' => $prestasi_nama[$i],
                        'tingkat' => $prestasi_tingkat[$i] ?? '',
                        'juara' => $prestasi_juara[$i] ?? '',
                        'tanggal' => $prestasi_tanggal[$i] ?? null,
                        'penyelenggara' => $prestasi_penyelenggara[$i] ?? '',
                        'keterangan' => $prestasi_keterangan[$i] ?? '',
                    ]);
                }
            }

            return true;
        }

        return false;
    }

    /**
     * Validasi siswa (validasi_pd) page
     */
    public function validasi()
    {
        $db = \Config\Database::connect();
        $siswaModel = new SiswaModel();
        $session = session();

        // Get students without a class
        $siswa_tanpa_kelas = $db->table('db_siswa')
            ->where('id_rombel IS NULL OR id_rombel = ""')
            ->get()->getResult();

        // Get all rombles (classes)
        $rombels = $db->table('db_rombel')
            ->orderBy('kelas', 'ASC')
            ->orderBy('rombel', 'ASC')
            ->get()->getResult();

        // Ambil data siswa hasil tarik dari session
        $siswa_validasi = $session->get('siswa_validasi') ?? [];

        // Data siswa_lulus tetap untuk modal tarik siswa baru
        $siswa_lulus = $db->table('db_calonpeserta')
            ->groupStart()
            ->where('status', 'Lulus')
            ->orWhere('status', 'Diterima')
            ->orWhere('status_hasil', 'Lulus')
            ->groupEnd()
            ->where('status !=', 'Diterima dan Terdaftar')
            ->groupStart()
            ->where('status_daftar_ulang !=', '1')
            ->orWhere('status_daftar_ulang IS NULL')
            ->orWhere('status_daftar_ulang', '')
            ->groupEnd()
            ->orderBy('nama_peserta', 'ASC')
            ->get()->getResult();

        return view('peserta didik/validasi_pd', [
            'siswa_tanpa_kelas' => $siswa_tanpa_kelas,
            'rombels' => $rombels,
            'siswa_lulus' => $siswa_lulus,
            'siswa_validasi' => $siswa_validasi
        ]);
    }


    /**
     * Transfer/Update students from db_calonpeserta (candidates) to db_siswa (active students)
     * and assign them to a specific class. This method supports both new additions and updates
     * to existing student records for data synchronization.
     */
    public function update_class_lulus()
    {
        $request = service('request');
        $db = \Config\Database::connect();

        // Get the selected students and target class
        $selectedPesertaIds = $request->getPost('siswa');
        $targetRombel = $request->getPost('id_rombel');
        $forceUpdate = $request->getPost('force_update') === '1'; // New parameter for forcing updates

        log_message('debug', 'Starting update_class_lulus with POST data: ' . json_encode($request->getPost(null)));
        log_message('debug', 'Selected student IDs: ' . json_encode($selectedPesertaIds));
        log_message('debug', 'Target class ID: ' . $targetRombel);
        log_message('debug', 'Force update mode: ' . ($forceUpdate ? 'Yes' : 'No'));

        if (empty($selectedPesertaIds)) {
            log_message('error', 'No students selected in update_class_lulus');
            return redirect()->to('peserta_didik/validasi')->with('error', 'Tidak ada siswa yang dipilih. Silakan pilih siswa yang akan ditarik.');
        }

        if (empty($targetRombel)) {
            log_message('error', 'No target class selected in update_class_lulus');
            return redirect()->to('peserta_didik/validasi')->with('error', 'Kelas tujuan tidak dipilih. Silakan pilih kelas tujuan.');
        }

        $addedCount = 0;      // New students added
        $updatedCount = 0;    // Existing students updated
        $skippedCount = 0;    // Students skipped due to issues
        $errors = [];
        $session = session();
        $siswa_validasi = [];

        // Add detailed logging for debugging
        log_message('debug', 'Starting to process ' . count($selectedPesertaIds) . ' selected candidates');

        // Process each selected candidate

        foreach ($selectedPesertaIds as $pesertaId) {
            // Ambil data kandidat dari db_calonpeserta
            $peserta = $db->table('db_calonpeserta')->where('id_peserta', $pesertaId)->get()->getRow();

            if (!$peserta) {
                $errors[] = "Data kandidat dengan ID $pesertaId tidak ditemukan";
                log_message('error', "Candidate data with ID $pesertaId not found");
                continue;
            }

            log_message('debug', "Processing candidate ID $pesertaId: " . (property_exists($peserta, 'nama_peserta') ? $peserta->nama_peserta : 'Unknown'));
            log_message('debug', 'Raw candidate data for ID ' . $pesertaId . ': ' . json_encode($peserta, JSON_PARTIAL_OUTPUT_ON_ERROR));

            // Siapkan data siswa hasil mapping
            $newSiswaData = $this->prepareStudentData($peserta, $targetRombel);
            // Simpan ke array validasi untuk session
            $siswa_validasi[] = $newSiswaData;

            // NIS boleh kosong, akan digenerate otomatis jika belum ada

            // Temukan siswa existing jika ada
            $existingStudent = $this->findExistingStudent($db, $peserta);
            $isUpdate = false;
            $matchedBy = '';

            if ($existingStudent) {
                $isUpdate = true;
                $matchedBy = $this->getMatchType($existingStudent, $peserta);
                $idSiswa = is_array($existingStudent) ? $existingStudent['id_siswa'] : $existingStudent->id_siswa;
                log_message('info', "Found existing student ID {$idSiswa} for candidate " . (property_exists($peserta, 'nama_peserta') ? $peserta->nama_peserta : 'Unknown') . " (matched by: {$matchedBy})");
            }

            try {
                // --- Tambahan: Isi otomatis data keluar jika status mutasi/lulus ---
                $isMutasiOrLulus = false;
                $jenisKeluar = '';
                if (isset($peserta->status) && strtolower($peserta->status) === 'mutasi') {
                    $isMutasiOrLulus = true;
                    $jenisKeluar = 'Mutasi';
                } elseif (isset($peserta->status) && strtolower($peserta->status) === 'lulus') {
                    $isMutasiOrLulus = true;
                    $jenisKeluar = 'Lulus';
                }
                $tanggalKeluar = date('Y-m-d');
                $alasanKeluar = $jenisKeluar ? ('Siswa ' . $jenisKeluar) : '';

                if ($isUpdate) {
                    // Update existing student record
                    $idSiswa = is_array($existingStudent) ? $existingStudent['id_siswa'] : $existingStudent->id_siswa;
                    log_message('debug', "Attempting to update existing student ID {$idSiswa}");
                    $success = $this->updateExistingStudent($db, $existingStudent, $newSiswaData, $targetRombel);
                    if ($success) {
                        $updatedCount++;
                        log_message('info', "Successfully updated existing student ID {$idSiswa}");

                        // Jika mutasi/lulus, update field keluar di db_siswa
                        if ($isMutasiOrLulus) {
                            $db->table('db_siswa')->where('id_siswa', $idSiswa)->update([
                                'keluar_karena' => $jenisKeluar,
                                'tanggal_keluar' => $tanggalKeluar,
                                'alasan_keluar' => $alasanKeluar
                            ]);
                        }

                        // Update status in db_calonpeserta
                        $updateResult = $db->table('db_calonpeserta')->where('id_peserta', $pesertaId)->update([
                            'status' => 'Diterima dan Terdaftar',
                            'status_daftar_ulang' => '1'
                        ]);

                        if (!$updateResult) {
                            log_message('warning', "Failed to update status in db_calonpeserta for ID $pesertaId");
                        }
                    } else {
                        $idSiswa = is_array($existingStudent) ? $existingStudent['id_siswa'] : $existingStudent->id_siswa;
                        throw new \Exception("Failed to update existing student ID {$idSiswa}");
                    }
                } else {
                    // Add new student record
                    log_message('debug', "Attempting to add new student from candidate ID $pesertaId");
                    $insertId = $this->addNewStudent($db, $newSiswaData);
                    if ($insertId) {
                        $addedCount++;
                        log_message('info', "Successfully added new student from candidate ID $pesertaId with new ID: $insertId");

                        // Jika mutasi/lulus, update field keluar di db_siswa
                        if ($isMutasiOrLulus) {
                            $db->table('db_siswa')->where('id_siswa', $insertId)->update([
                                'keluar_karena' => $jenisKeluar,
                                'tanggal_keluar' => $tanggalKeluar,
                                'alasan_keluar' => $alasanKeluar
                            ]);
                        }

                        // Update status in db_calonpeserta
                        $updateResult = $db->table('db_calonpeserta')->where('id_peserta', $pesertaId)->update([
                            'status' => 'Diterima dan Terdaftar',
                            'status_daftar_ulang' => '1'
                        ]);

                        if (!$updateResult) {
                            log_message('warning', "Failed to update status in db_calonpeserta for ID $pesertaId");
                        }
                    } else {
                        throw new \Exception('Failed to add new student record');
                    }
                }
            } catch (\Exception $e) {
                $errorDetail = "Gagal memproses siswa ID $pesertaId";
                $candidateName = property_exists($peserta, 'nama_peserta') ? $peserta->nama_peserta : 'Unknown';

                if ($isUpdate) {
                    $idSiswa = is_array($existingStudent) ? $existingStudent['id_siswa'] : $existingStudent->id_siswa;
                    $errorDetail .= " (update existing student ID {$idSiswa} - {$candidateName})";
                } else {
                    $errorDetail .= " (add new student - {$candidateName})";
                }

                $errorDetail .= ": " . $e->getMessage();
                $errors[] = $errorDetail;
                $skippedCount++;

                log_message('error', $errorDetail);
                log_message('error', "Candidate data: " . json_encode($peserta, JSON_PARTIAL_OUTPUT_ON_ERROR));
                log_message('error', "Prepared student data: " . json_encode($newSiswaData, JSON_PARTIAL_OUTPUT_ON_ERROR));

                continue;
            }
        }

        // Prepare success/error messages based on results
        $messages = [];

        if ($addedCount > 0) {
            $messages[] = "$addedCount siswa baru berhasil ditambahkan";
        }

        if ($updatedCount > 0) {
            $messages[] = "$updatedCount siswa berhasil diperbarui";
        }

        if ($skippedCount > 0) {
            $messages[] = "$skippedCount siswa dilewati karena ada masalah";
        }

        $totalProcessed = $addedCount + $updatedCount + $skippedCount;
        log_message('info', "Process completed: {$addedCount} added, {$updatedCount} updated, {$skippedCount} skipped from {$totalProcessed} total");

        // Clear any potential cache issues after successful processing
        if ($addedCount > 0 || $updatedCount > 0) {
            // Force data refresh by clearing query cache if enabled
            if (method_exists($db, 'query')) {
                $db->query('RESET QUERY CACHE');  // Clear MySQL query cache if available
            }

            // Add cache-busting headers to prevent browser caching
            $this->response->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
            $this->response->setHeader('Pragma', 'no-cache');
            $this->response->setHeader('Expires', '0');
        }

        // Return appropriate response based on results
        if ($addedCount > 0 || $updatedCount > 0) {
            $successMessage = implode(', ', $messages);
            // Simpan data hasil tarik ke session agar muncul di tabel validasi
            $session->set('siswa_validasi', $siswa_validasi);
            if (!empty($errors)) {
                $successMessage .= "\n\nDetail error:\n• " . implode("\n• ", array_slice($errors, 0, 5));
                if (count($errors) > 5) {
                    $successMessage .= "\n• ...dan " . (count($errors) - 5) . " error lainnya";
                }
                return redirect()->to('peserta_didik/validasi')->with('warning', $successMessage);
            }
            return redirect()->to('peserta_didik/validasi')->with('success', $successMessage);
        } else {
            // Jika tidak ada yang berhasil, hapus session validasi
            $session->remove('siswa_validasi');
            $errorMessage = 'Tidak ada siswa yang berhasil diproses.';
            if (!empty($errors)) {
                $errorMessage .= "\n\nDetail error:\n• " . implode("\n• ", array_slice($errors, 0, 10));
            }
            return redirect()->to('peserta_didik/validasi')->with('error', $errorMessage);
        }
    }

    /**
     * Generate NIS for all class 1 students who don't have an NIS yet
     * Assigns NIS based on incrementing the last NIS
     */
    public function generateNISForClass1Students()
    {
        // Create model instance
        $siswaModel = new SiswaModel();

        // Generate NIS for class 1 students without NIS
        $updatedCount = $siswaModel->generateNISForClass1Students();

        // Provide feedback to user
        if ($updatedCount > 0) {
            return redirect()->to('peserta_didik')->with('success', $updatedCount . ' siswa kelas 1 berhasil diberikan NIS.');
        } else {
            return redirect()->to('peserta_didik')->with('info', 'Tidak ditemukan siswa kelas 1 yang memerlukan NIS.');
        }
    }

    /**
     * Batch generate NIS for all class 1 students who don't have an NIS yet
     * This assigns NIS based on alphabetical order of names
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function batchGenerateNISForClass1Students()
    {
        $siswaModel = new SiswaModel();
        $updatedCount = $siswaModel->generateNISForClass1Students();

        if ($updatedCount > 0) {
            return redirect()->back()->with('success', "Berhasil membuat NIS untuk {$updatedCount} siswa kelas 1.");
        } else {
            return redirect()->back()->with('info', 'Tidak ada siswa kelas 1 yang perlu dibuat NIS.');
        }
    }

    /**
     * Batch generate NIS for Class 1 students in alphabetical order
     * This method ensures proper sequential NIS assignment based on student names
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function batchGenerateNISClass1Alphabetical()
    {
        $siswaModel = new SiswaModel();
        $updatedCount = $siswaModel->batchGenerateNISForClass1StudentsAlphabetical();

        if ($updatedCount > 0) {
            return redirect()->back()->with('success', "Berhasil membuat NIS untuk {$updatedCount} siswa kelas 1 sesuai urutan abjad.");
        } else {
            return redirect()->back()->with('info', 'Tidak ada siswa kelas 1 yang perlu dibuat NIS.');
        }
    }

    /**
     * Batch generate NIS for transfer students ordered by registration date
     * This method ensures proper sequential NIS assignment based on registration date
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function batchGenerateNISTransferByDate()
    {
        $siswaModel = new SiswaModel();
        $updatedCount = $siswaModel->batchGenerateNISForTransferStudentsByDate();

        if ($updatedCount > 0) {
            return redirect()->back()->with('success', "Berhasil membuat NIS untuk {$updatedCount} siswa mutasi sesuai urutan tanggal daftar.");
        } else {
            return redirect()->back()->with('info', 'Tidak ada siswa mutasi yang perlu dibuat NIS.');
        }
    }

    /**
     * Sync asal sekolah data from candidates to students
     * This method ensures that asal_sekolah data is properly synchronized
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function syncAsalSekolahData()
    {
        $db = \Config\Database::connect();

        try {
            // Update query to sync asal sekolah data
            $query = "
                UPDATE db_siswa s 
                JOIN db_calonpeserta p ON (
                    (p.nisn = s.nisn AND p.nisn IS NOT NULL AND p.nisn != '' AND s.nisn IS NOT NULL AND s.nisn != '')
                    OR (p.nik = s.nik AND p.nik IS NOT NULL AND p.nik != '' AND s.nik IS NOT NULL AND s.nik != '')
                )
                SET s.sekolah_asal = p.sekolah_asal, s.npsn = p.npsn_asal
                WHERE p.sekolah_asal IS NOT NULL AND p.sekolah_asal != ''
                AND (s.sekolah_asal IS NULL OR s.sekolah_asal = '')
            ";

            $result = $db->query($query);
            $affectedRows = $db->affectedRows();

            if ($affectedRows > 0) {
                return redirect()->back()->with('success', "Berhasil sinkronisasi data asal sekolah untuk {$affectedRows} siswa.");
            } else {
                return redirect()->back()->with('info', 'Tidak ada data asal sekolah yang perlu disinkronisasi.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error syncing asal sekolah data: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal sinkronisasi data asal sekolah: ' . $e->getMessage());
        }
    }

    /**
     * Generate NIS untuk siswa yang belum memiliki NIS
     * Method ini akan men-generate NIS untuk semua siswa yang belum punya NIS
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function generateMissingNIS()
    {
        $db = \Config\Database::connect();
        $siswaModel = new SiswaModel();

        try {
            // Get all students without NIS
            $studentsWithoutNIS = $db->table('db_siswa')
                ->where('(nis IS NULL OR nis = "")')
                ->orderBy('nama_siswa', 'ASC')
                ->get()
                ->getResult();

            if (empty($studentsWithoutNIS)) {
                return redirect()->back()->with('info', 'Semua siswa sudah memiliki NIS.');
            }

            $updatedCount = 0;
            $errors = [];

            foreach ($studentsWithoutNIS as $student) {
                try {
                    // Get rombel info to determine student type
                    $rombelInfo = null;
                    if (!empty($student->id_rombel)) {
                        $rombelInfo = $db->table('db_rombel')
                            ->where('id_rombel', $student->id_rombel)
                            ->get()
                            ->getRow();
                    }

                    // Determine student type
                    $isNewStudent = false;
                    $isTransferStudent = false;

                    if ($rombelInfo && !empty($rombelInfo->kelas)) {
                        // Check if this is class 1 (new student)
                        $isNewStudent = (strtolower($rombelInfo->kelas) === '1' ||
                            strtolower($rombelInfo->kelas) === 'i' ||
                            strpos(strtolower($rombelInfo->kelas), 'kelas 1') !== false);

                        // If not class 1, consider as transfer student
                        if (!$isNewStudent) {
                            $isTransferStudent = true;
                        }
                    }

                    // Generate NIS
                    $studentName = $student->nama_siswa ?? '';
                    $entryDate = $student->tanggal_pendaftaran ?? null;

                    $generatedNIS = $siswaModel->generateNIS(
                        $isNewStudent,
                        $isTransferStudent,
                        $studentName,
                        $entryDate
                    );

                    // Update student with generated NIS
                    $idSiswa = is_array($student) ? $student['id_siswa'] : $student->id_siswa;
                    $updateResult = $db->table('db_siswa')
                        ->where('id_siswa', $idSiswa)
                        ->update(['nis' => $generatedNIS]);

                    if ($updateResult) {
                        $updatedCount++;
                        $idSiswa = is_array($student) ? $student['id_siswa'] : $student->id_siswa;
                        log_message('info', "Generated NIS {$generatedNIS} for student ID {$idSiswa}: {$studentName}");
                    } else {
                        $errors[] = "Gagal update NIS untuk siswa: {$studentName}";
                    }
                } catch (\Exception $e) {
                    $errors[] = "Error generating NIS for student {$student->nama_siswa}: " . $e->getMessage();
                    $idSiswa = is_array($student) ? $student['id_siswa'] : $student->id_siswa;
                    log_message('error', "Error generating NIS for student ID {$idSiswa}: " . $e->getMessage());
                }
            }

            // Prepare response message
            if ($updatedCount > 0) {
                $message = "Berhasil men-generate NIS untuk {$updatedCount} siswa.";
                if (!empty($errors)) {
                    $message .= " Ada " . count($errors) . " error.";
                }
                return redirect()->back()->with('success', $message);
            } else {
                $errorMessage = 'Gagal men-generate NIS untuk semua siswa.';
                if (!empty($errors)) {
                    $errorMessage .= "\n\nError: " . implode(", ", array_slice($errors, 0, 3));
                }
                return redirect()->back()->with('error', $errorMessage);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error in generateMissingNIS: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi error: ' . $e->getMessage());
        }
    }

    /**
     * Helper method to find existing student using comprehensive matching
     * 
     * @param object $db Database connection
     * @param object $peserta Candidate data
     * @return object|null Existing student data or null if not found
     */
    private function findExistingStudent($db, $peserta)
    {
        // First try NISN match (most reliable)
        if (!empty($peserta->nisn)) {
            $existing = $db->table('db_siswa')
                ->where('nisn', $peserta->nisn)
                ->get()
                ->getRow();
            if ($existing) {
                return $existing;
            }
        }

        // Then try NIK match
        if (!empty($peserta->nik)) {
            $existing = $db->table('db_siswa')
                ->where('nik', $peserta->nik)
                ->get()
                ->getRow();
            if ($existing) {
                return $existing;
            }
        }

        // Finally try name and birth date match
        if (!empty($peserta->nama_peserta) && !empty($peserta->tanggal_lahir)) {
            $existing = $db->table('db_siswa')
                ->where('nama_siswa', $peserta->nama_peserta)
                ->where('tanggal_lahir', $peserta->tanggal_lahir)
                ->get()
                ->getRow();
            if ($existing) {
                return $existing;
            }
        }

        return null;
    }

    /**
     * Determine how the student was matched
     * 
     * @param object $existingStudent
     * @param object $peserta
     * @return string
     */
    private function getMatchType($existingStudent, $peserta)
    {
        if (!empty($peserta->nisn) && $existingStudent->nisn == $peserta->nisn) {
            return 'NISN';
        }
        if (!empty($peserta->nik) && $existingStudent->nik == $peserta->nik) {
            return 'NIK';
        }
        if (
            !empty($peserta->nama_peserta) && !empty($peserta->tanggal_lahir) &&
            $existingStudent->nama_siswa == $peserta->nama_peserta &&
            $existingStudent->tanggal_lahir == $peserta->tanggal_lahir
        ) {
            return 'Nama dan Tanggal Lahir';
        }
        return 'Unknown';
    }

    /**
     * Update existing student with new data
     * 
     * @param object $db Database connection
     * @param object $existingStudent Existing student data
     * @param array $newSiswaData New student data
     * @param int $targetRombel Target class ID
     * @return bool Success status
     */
    private function updateExistingStudent($db, $existingStudent, $newSiswaData, $targetRombel)
    {
        // Define fields that should be synchronized from candidate to student
        $fieldsToSync = [
            'nisn',
            'nik',
            'nama_siswa',
            'jk',
            'tempat_lahir',
            'tanggal_lahir',
            'id_agama',
            'alamat',
            'rt',
            'rw',
            'dusun',
            'kelurahan',
            'kecamatan',
            'kodepos',
            'hp',
            'email',
            'nama_ayah',
            'nama_ibu',
            'sekolah_asal',
            'npsn',
            'tanggal_pendaftaran',
            'id_tahun_ajaran'
        ];

        $updateData = ['id_rombel' => $targetRombel, 'updated_at' => date('Y-m-d H:i:s')];

        // Note: kelas and rombel information is accessed through id_rombel foreign key
        // to db_rombel table, not stored directly in db_siswa

        // Sync only the specified fields
        foreach ($fieldsToSync as $field) {
            if (isset($newSiswaData[$field]) && !empty($newSiswaData[$field])) {
                $updateData[$field] = $newSiswaData[$field];
            }
        }

        $idSiswa = is_array($existingStudent) ? $existingStudent['id_siswa'] : $existingStudent->id_siswa;
        return $db->table('db_siswa')
            ->where('id_siswa', $idSiswa)
            ->update($updateData);
    }

    private function addNewStudent($db, $newSiswaData)
    {
        // Generate NIS sebelum insert
        $siswaModel = new SiswaModel();
        $rombelInfo = null;
        if (!empty($newSiswaData['id_rombel'])) {
            $rombelInfo = $db->table('db_rombel')
                ->where('id_rombel', $newSiswaData['id_rombel'])
                ->get()
                ->getRow();
        }
        $isNewStudent = false;
        $isTransferStudent = false;
        if ($rombelInfo && !empty($rombelInfo->kelas)) {
            $isNewStudent = (strtolower($rombelInfo->kelas) === '1' ||
                strtolower($rombelInfo->kelas) === 'i' ||
                strpos(strtolower($rombelInfo->kelas), 'kelas 1') !== false);
            if (!$isNewStudent) {
                $isTransferStudent = true;
            }
        }
        $studentName = $newSiswaData['nama_siswa'] ?? '';
        $entryDate = $newSiswaData['tanggal_pendaftaran'] ?? null;
        $generatedNIS = $siswaModel->generateNIS(
            $isNewStudent,
            $isTransferStudent,
            $studentName,
            $entryDate
        );
        $newSiswaData['nis'] = $generatedNIS;
        // Insert siswa baru dengan NIS langsung
        $insertResult = $db->table('db_siswa')->insert($newSiswaData);
        if ($insertResult) {
            $insertId = $db->insertID();
            log_message('info', "Successfully generated NIS {$generatedNIS} for new student ID {$insertId}: {$studentName}");
            return $insertId;
        }
        return false;
    }

    /**
     * Prepare student data from candidate data with proper field mapping
     * Handles all the field mapping from db_calonpeserta to db_siswa format
     * 
     * @param object $peserta The candidate data from db_calonpeserta
     * @param int $targetRombel Target class ID
     * @return array Prepared data array for insertion into db_siswa
     */
    private function prepareStudentData($peserta, $targetRombel)
    {
        $db = \Config\Database::connect();

        // Get target rombel info
        $rombelInfo = $db->table('db_rombel')->where('id_rombel', $targetRombel)->get()->getRow();

        // Helper function to safely get numeric values
        $getNumericValue = function ($peserta, $field, $default = null) {
            if (isset($peserta->$field) && $peserta->$field !== '' && $peserta->$field !== null) {
                return (int)$peserta->$field;
            }
            return $default;
        };

        // Basic student information
        $data = [
            'nama_siswa' => $peserta->nama_peserta ?? $peserta->nama ?? '',
            'nisn' => $peserta->nisn ?? '',
            'nis' => $peserta->nis ?? '',
            'nik' => $peserta->nik ?? '',
            'jk' => $peserta->jenis_kelamin ?? '',
            'tempat_lahir' => $peserta->tempat_lahir ?? '',
            'tanggal_lahir' => $peserta->tanggal_lahir ?? null,
            'id_agama' => $peserta->id_agama ?? '',
            'alamat' => $peserta->alamat_lengkap ?? $peserta->alamat ?? '',
            'rt' => $peserta->rt ?? '',
            'rw' => $peserta->rw ?? '',
            'nama_dusun' => $peserta->nama_dusun ?? '',
            'kelurahan' => $peserta->kelurahan ?? '',
            'kecamatan' => $peserta->kecamatan ?? '',
            'kodepos' => $peserta->kode_pos ?? '',
            'telephone' => $peserta->telephone ?? '',
            // 'email' => $peserta->email ?? '',
            'nama_ayah' => $peserta->nama_ayah ?? '',
            'nama_ibu' => $peserta->nama_ibu ?? '',
        ];

        // Map asal sekolah data
        if (!empty($peserta->sekolah_asal)) {
            $data['sekolah_asal'] = $peserta->sekolah_asal;
        }
        if (!empty($peserta->npsn_asal)) {
            $data['npsn'] = $peserta->npsn_asal;
        }

        // Map registration date from candidate to student
        if (!empty($peserta->tanggal_daftar)) {
            $data['tanggal_pendaftaran'] = $peserta->tanggal_daftar;
        }

        // Set current academic year from active academic year in db_tahunajaran
        $currentTahunAjaran = $db->table('db_tahunajaran')
            ->where('status', 'Aktif')
            ->get()
            ->getRow();

        if ($currentTahunAjaran) {
            $data['id_tahun_ajaran'] = $currentTahunAjaran->id_tahun_ajaran;
        }

        // Set class information based on target rombel
        if ($rombelInfo) {
            // Only set id_rombel - kelas and rombel info is accessed via JOIN with db_rombel
            $data['id_rombel'] = $rombelInfo->id_rombel;
        }

        // Set timestamps
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        return $data;
    }
}
