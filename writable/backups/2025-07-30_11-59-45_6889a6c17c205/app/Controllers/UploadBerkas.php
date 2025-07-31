<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class UploadBerkas extends BaseController
{
    public function delete_file()
    {
        $file = $this->request->getGet('file');
        $id_peserta = $this->request->getGet('id_peserta');
        if (!$file || !$id_peserta) {
            return redirect()->back()->with('error', 'Parameter tidak valid.');
        }
        $allowed = ['kk', 'akte', 'ijazah'];
        if (!in_array($file, $allowed)) {
            return redirect()->back()->with('error', 'File tidak dikenali.');
        }
        // Path upload HARUS di public/uploads/berkas agar bisa diakses browser
        $dir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'berkas' . DIRECTORY_SEPARATOR . $id_peserta . DIRECTORY_SEPARATOR;
        $pattern = $dir . $file . '_' . $id_peserta . '.*';
        $deleted = false;
        foreach (glob($pattern) as $f) {
            if (is_file($f)) {
                unlink($f);
                $deleted = true;
            }
        }
        if ($deleted) {
            return redirect()->to(site_url('uploadberkas/' . $id_peserta))->with('success', 'File ' . ucfirst($file) . ' berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }
    }

    public function index($id_peserta = null)
    {
        $pesertaModel = new \App\Models\SpmbModel();
        $calon_siswa_belum_upload = [];
        $calon_siswa_sudah_upload = [];
        $status_daftar_ulang = null;
        $nama_peserta = null;
        $no_pendaftaran = null;
        // Pastikan id_peserta selalu valid (int/null)
        $id_peserta_view = !empty($id_peserta) ? $id_peserta : null;

        // Ambil semua siswa dengan status daftar ulang pending/belum verifikasi
        // GUNAKAN FIELD SESUAI DATABASE: 'status_daftar_ulang'
        $belum = $pesertaModel->whereIn('status_daftar_ulang', ['2', 2, '0', 0])->findAll();
        foreach ($belum as $siswa) {
            // Cek status upload berkas berdasarkan id_peserta (cek semua ekstensi, return setelah ketemu)
            $kk_uploaded = false;
            $akte_uploaded = false;
            $ijazah_uploaded = false;
            $kk_path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'berkas' . DIRECTORY_SEPARATOR . $siswa->id_peserta . DIRECTORY_SEPARATOR;
            if (!$kk_uploaded && count(glob($kk_path . 'kk_' . $siswa->id_peserta . '.*')) > 0) $kk_uploaded = true;
            if (!$akte_uploaded && count(glob($kk_path . 'akte_' . $siswa->id_peserta . '.*')) > 0) $akte_uploaded = true;
            if (!$ijazah_uploaded && count(glob($kk_path . 'ijazah_' . $siswa->id_peserta . '.*')) > 0) $ijazah_uploaded = true;

            $siswa->status_kk = $kk_uploaded ? 'sudah' : 'belum';
            $siswa->status_akte = $akte_uploaded ? 'sudah' : 'belum';
            $siswa->status_ijazah = $ijazah_uploaded ? 'sudah' : 'belum';

            // Jika semua berkas sudah upload (100%), pindahkan ke array sudah upload
            if ($kk_uploaded && $akte_uploaded && $ijazah_uploaded) {
                $calon_siswa_sudah_upload[] = $siswa;
            } else {
                // Jika belum lengkap, masukkan ke array belum upload
                $calon_siswa_belum_upload[] = $siswa;
            }
        }

        // Ambil semua siswa yang sudah upload (status daftar ulang sudah verifikasi)
        $sudah = $pesertaModel->whereIn('status_daftar_ulang', ['1', 1])->findAll();
        foreach ($sudah as $siswa) {
            $calon_siswa_sudah_upload[] = $siswa;
        }

        // Jika ada id_peserta, ambil detailnya
        if (!empty($id_peserta)) {
            $peserta = $pesertaModel->where('id_peserta', $id_peserta)->first();
            // DEBUG: log ke file jika ingin
            // file_put_contents(WRITEPATH . 'debug_uploadberkas.txt', print_r($peserta, true));
            if ($peserta && is_object($peserta)) {
                $status_daftar_ulang = property_exists($peserta, 'status_daftar_ulang') ? $peserta->status_daftar_ulang : null;
                $nama_peserta = property_exists($peserta, 'nama_peserta') ? $peserta->nama_peserta : null;
                $no_pendaftaran = property_exists($peserta, 'no_pendaftaran') ? $peserta->no_pendaftaran : null;
                $id_peserta_view = property_exists($peserta, 'id_peserta') ? $peserta->id_peserta : $id_peserta;
            } else {
                // DEBUG: log jika tidak ditemukan
                // file_put_contents(WRITEPATH . 'debug_uploadberkas.txt', "NOT FOUND: $id_peserta\n", FILE_APPEND);
                $id_peserta_view = $id_peserta;
            }
        }

        return view('calon_siswa/verifikasi', [
            'id_peserta' => $id_peserta_view,
            'status_daftar_ulang' => $status_daftar_ulang,
            'nama_peserta' => $nama_peserta,
            'no_pendaftaran' => $no_pendaftaran,
            'calon_siswa_belum_upload' => $calon_siswa_belum_upload,
            'calon_siswa_sudah_upload' => $calon_siswa_sudah_upload,
        ]);
    }

    public function upload($id_peserta = null)
    {
        helper(['form', 'url']);

        $fields = ['kk', 'akte', 'ijazah'];
        $uploaded = false;
        foreach ($fields as $field) {
            $file = $this->request->getFile($field);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Hanya izinkan PDF
                if (strtolower($file->getExtension()) !== 'pdf') {
                    return redirect()->back()->with('error', 'Hanya file PDF yang diperbolehkan.');
                }
                $uploaded = $field;
                break;
            }
        }

        if (!$uploaded) {
            return redirect()->back()->with('error', 'Tidak ada file yang diupload.');
        }

        $validationRule = [
            $uploaded => [
                'label' => ucfirst($uploaded),
                'rules' => "uploaded[$uploaded]|max_size[$uploaded,2048]|ext_in[$uploaded,pdf]",
            ]
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile($uploaded);
        $uploadPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'berkas' . DIRECTORY_SEPARATOR . $id_peserta . DIRECTORY_SEPARATOR;
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        $file->move($uploadPath, $uploaded . '_' . $id_peserta . '.pdf', true);

        // Update status upload di database jika ingin (opsional, jika ada kolom di tabel)
        // Jika hanya ingin update badge di tampilan, cukup reload data dari folder upload (sudah dilakukan di index)

        // Agar badge langsung berubah, redirect ke halaman index uploadberkas supaya status dicek ulang
        return redirect()->to(site_url('uploadberkas/' . $id_peserta))->with('success', ucfirst($uploaded) . ' berhasil diupload.');
    }

    /**
     * AJAX file upload handler specifically for the modal
     */
    public function upload_ajax($id_peserta = null)
    {
        helper(['form', 'url']);

        // Check if this is an AJAX request
        if (!$this->request->isAJAX()) {
            // Fall back to regular upload method for non-AJAX requests
            return $this->upload($id_peserta);
        }

        if (!$id_peserta) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID Peserta tidak valid.'
            ]);
        }

        $type = $this->request->getPost('type');
        if (!in_array($type, ['kk', 'akte', 'ijazah'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tipe berkas tidak valid.'
            ]);
        }

        $file = $this->request->getFile('file');
        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'File tidak valid atau tidak ditemukan.'
            ]);
        }

        // Validate file
        $validationRule = [
            'file' => [
                'label' => ucfirst($type),
                'rules' => 'uploaded[file]|max_size[file,2048]|ext_in[file,pdf,jpg,jpeg,png]',
            ]
        ];

        if (!$this->validate($validationRule)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $this->validator->getErrors()['file'] ?? 'Validasi file gagal.'
            ]);
        }

        // Create upload directory if not exists
        $uploadPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'berkas' . DIRECTORY_SEPARATOR . $id_peserta . DIRECTORY_SEPARATOR;
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Delete existing files with the same prefix (to avoid multiple files)
        $pattern = $uploadPath . $type . '_' . $id_peserta . '.*';
        foreach (glob($pattern) as $existingFile) {
            if (is_file($existingFile)) {
                unlink($existingFile);
            }
        }

        // Get file extension
        $ext = $file->getExtension();
        if (empty($ext)) {
            $ext = $file->getClientExtension();
        }

        // Move file with proper extension
        if ($file->move($uploadPath, $type . '_' . $id_peserta . '.' . $ext, true)) {
            // Return success response with file URL for preview
            $fileUrl = base_url('uploads/berkas/' . $id_peserta . '/' . $type . '_' . $id_peserta . '.' . $ext);

            return $this->response->setJSON([
                'success' => true,
                'message' => ucfirst($type) . ' berhasil diupload.',
                'file_url' => $fileUrl
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengupload file. Silakan coba lagi.'
            ]);
        }
    }
}
