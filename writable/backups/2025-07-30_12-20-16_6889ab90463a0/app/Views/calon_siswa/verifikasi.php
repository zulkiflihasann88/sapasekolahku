<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Sleksi Penerimaan murid baru &mdash; SDN Krengseng 02</title>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4 class="mb-sm-0 font-size-18">Upload Verifikasi Berkas</h4>

          <div class="page-title-right">
            <ol class="breadcrumb m-0">
              <li class="breadcrumb-item"><a href="<?= site_url('home') ?>">Dashboard</a></li>
              <li class="breadcrumb-item active">Data calon peserta didik</li>
            </ol>
          </div>

        </div>
      </div>
    </div>
    <?php if (session()->getFlashdata('success')) : ?>
      <script>
        toastr.success("<?= session()->getFlashdata('success'); ?>", 'Sukses', {
          "progressBar": true,
          "timeOut": "3000",
          "positionClass": "toast-top-right",
          "extendedTimeOut": "3000",
        });
      </script>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
      <script>
        toastr.error("<?= session()->getFlashdata('error'); ?>", 'Gagal', {
          "progressBar": true,
          "timeOut": "3000",
          "positionClass": "toast-top-right",
          "extendedTimeOut": "3000",
        });
      </script>
    <?php endif; ?>

    <!-- Card Daftar Siswa yang Sudah Upload Berkas -->
    <!-- Tidak ditampilkan sesuai permintaan -->

    <!-- Form upload untuk siswa tertentu (jika $id_peserta ada dan status daftar ulang pending) -->
    <?php if (!empty($calon_siswa_belum_upload)): ?>
      <div class="row">
        <?php /* DEBUG: tampilkan isi array untuk memastikan data benar */ ?>
        <?php //echo '<pre>'; print_r($calon_siswa_belum_upload); echo '</pre>'; 
        ?>
        <?php foreach ($calon_siswa_belum_upload as $siswa): ?>
          <?php
          // Refresh file status for each siswa (in case new files are uploaded after page load)
          $basePath = base_url('uploads/berkas/' . $siswa->id_peserta . '/');
          $kk_file = glob(FCPATH . 'uploads/berkas/' . $siswa->id_peserta . '/kk_' . $siswa->id_peserta . '.*');
          $akte_file = glob(FCPATH . 'uploads/berkas/' . $siswa->id_peserta . '/akte_' . $siswa->id_peserta . '.*');
          $ijazah_file = glob(FCPATH . 'uploads/berkas/' . $siswa->id_peserta . '/ijazah_' . $siswa->id_peserta . '.*');
          ?>
          <div class="col-md-6 col-xl-4 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="d-flex">
                  <div class="flex-shrink-0 me-4">
                    <div class="avatar-md">
                      <span class="avatar-title rounded-circle bg-primary text-white font-size-34 d-flex align-items-center justify-content-center" style="width:70px; height:70px; font-size:45px;">
                        <?= strtoupper(mb_substr($siswa->nama_peserta, 0, 1, 'UTF-8')) ?>
                      </span>
                    </div>
                  </div>
                  <div class="flex-grow-1 overflow-hidden">
                    <h5 class="card-title text-warning"><i class="bx bx-time-five"></i> <?= esc($siswa->nama_peserta) ?></h5>
                    <p class="card-text mb-1"><b>No. Pendaftaran:</b> <?= esc($siswa->no_pendaftaran) ?></p>
                    <p class="card-text mb-1"><b>Sekolah Asal:</b> <?= esc($siswa->sekolah_asal) ?></p>
                    <p class="card-text mb-1"><b>Jalur:</b> <?= esc($siswa->jalur) ?></p>

                    <!-- Upload buttons and status badges centered below avatar and identity -->
                    <div class="d-flex flex-column align-items-center justify-content-center mt-3 w-100">
                      <div class="d-flex gap-2 justify-content-center mb-2">
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalUploadKK-<?= $siswa->id_peserta ?>">Upload KK</button>
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalUploadAkte-<?= $siswa->id_peserta ?>">Upload Akte</button>
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalUploadIjazah-<?= $siswa->id_peserta ?>">Upload Ijazah</button>
                      </div>
                      <div class="d-flex gap-2 justify-content-center mt-1">
                        <?php
                        $basePath = base_url('uploads/berkas/' . $siswa->id_peserta . '/');
                        $kk_file = glob(FCPATH . 'uploads/berkas/' . $siswa->id_peserta . '/kk_' . $siswa->id_peserta . '.*');
                        $akte_file = glob(FCPATH . 'uploads/berkas/' . $siswa->id_peserta . '/akte_' . $siswa->id_peserta . '.*');
                        $ijazah_file = glob(FCPATH . 'uploads/berkas/' . $siswa->id_peserta . '/ijazah_' . $siswa->id_peserta . '.*');
                        ?>
                        <span class="badge bg-<?= !empty($siswa->status_kk) && $siswa->status_kk === 'sudah' ? 'success' : 'danger' ?>">
                          KK: <?= !empty($siswa->status_kk) && $siswa->status_kk === 'sudah' ? 'Terupload' : 'Belum' ?>
                          <?php if (!empty($kk_file)) : ?>
                            <a href="<?= $basePath . basename($kk_file[0]) ?>" target="_blank" class="text-white ms-1" title="Lihat"><i class="mdi mdi-eye"></i></a>
                            <a href="<?= site_url('uploadberkas/delete_file?file=kk&id_peserta=' . $siswa->id_peserta) ?>" class="text-white ms-1" title="Hapus" onclick="return confirm('Yakin ingin menghapus file KK?')"><i class="mdi mdi-delete"></i></a>
                          <?php endif; ?>
                        </span>
                        <span class="badge bg-<?= !empty($siswa->status_akte) && $siswa->status_akte === 'sudah' ? 'success' : 'danger' ?>">
                          Akte: <?= !empty($siswa->status_akte) && $siswa->status_akte === 'sudah' ? 'Terupload' : 'Belum' ?>
                          <?php if (!empty($akte_file)) : ?>
                            <a href="<?= $basePath . basename($akte_file[0]) ?>" target="_blank" class="text-white ms-1" title="Lihat"><i class="mdi mdi-eye"></i></a>
                            <a href="<?= site_url('uploadberkas/delete_file?file=akte&id_peserta=' . $siswa->id_peserta) ?>" class="text-white ms-1" title="Hapus" onclick="return confirm('Yakin ingin menghapus file Akte?')"><i class="mdi mdi-delete"></i></a>
                          <?php endif; ?>
                        </span>
                        <span class="badge bg-<?= !empty($siswa->status_ijazah) && $siswa->status_ijazah === 'sudah' ? 'success' : 'danger' ?>">
                          Ijazah: <?= !empty($siswa->status_ijazah) && $siswa->status_ijazah === 'sudah' ? 'Terupload' : 'Belum' ?>
                          <?php if (!empty($ijazah_file)) : ?>
                            <a href="<?= $basePath . basename($ijazah_file[0]) ?>" target="_blank" class="text-white ms-1" title="Lihat"><i class="mdi mdi-eye"></i></a>
                            <a href="<?= site_url('uploadberkas/delete_file?file=ijazah&id_peserta=' . $siswa->id_peserta) ?>" class="text-white ms-1" title="Hapus" onclick="return confirm('Yakin ingin menghapus file Ijazah?')"><i class="mdi mdi-delete"></i></a>
                          <?php endif; ?>
                        </span>
                      </div>
                    </div>

                    <!-- Modal Upload KK -->
                    <div class="modal fade" id="modalUploadKK-<?= $siswa->id_peserta ?>" tabindex="-1" aria-labelledby="modalUploadKKLabel-<?= $siswa->id_peserta ?>" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="modalUploadKKLabel-<?= $siswa->id_peserta ?>">Upload Kartu Keluarga</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="<?= site_url('uploadberkas/upload/' . ($siswa->id_peserta ?? '')) ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="modal-body">
                              <div class="mb-3">
                                <label for="kk-<?= $siswa->id_peserta ?>" class="form-label">Pilih file KK (PDF/JPG/PNG, max 2MB)</label>
                                <input type="file" class="form-control" id="kk-<?= $siswa->id_peserta ?>" name="kk" required>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                              <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Upload Akte -->
                    <div class="modal fade" id="modalUploadAkte-<?= $siswa->id_peserta ?>" tabindex="-1" aria-labelledby="modalUploadAkteLabel-<?= $siswa->id_peserta ?>" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="modalUploadAkteLabel-<?= $siswa->id_peserta ?>">Upload Akte Kelahiran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="<?= site_url('uploadberkas/upload/' . ($siswa->id_peserta ?? '')) ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="modal-body">
                              <div class="mb-3">
                                <label for="akte-<?= $siswa->id_peserta ?>" class="form-label">Pilih file Akte (PDF/JPG/PNG, max 2MB)</label>
                                <input type="file" class="form-control" id="akte-<?= $siswa->id_peserta ?>" name="akte" required>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                              <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Upload Ijazah -->
                    <div class="modal fade" id="modalUploadIjazah-<?= $siswa->id_peserta ?>" tabindex="-1" aria-labelledby="modalUploadIjazahLabel-<?= $siswa->id_peserta ?>" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="modalUploadIjazahLabel-<?= $siswa->id_peserta ?>">Upload Ijazah</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="<?= site_url('uploadberkas/upload/' . ($siswa->id_peserta ?? '')) ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="modal-body">
                              <div class="mb-3">
                                <label for="ijazah-<?= $siswa->id_peserta ?>" class="form-label">Pilih file Ijazah (PDF/JPG/PNG, max 2MB)</label>
                                <input type="file" class="form-control" id="ijazah-<?= $siswa->id_peserta ?>" name="ijazah" required>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                              <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>

                    <!-- Modal Upload Akte -->
                    <div class="modal fade" id="modalUploadAkte" tabindex="-1" aria-labelledby="modalUploadAkteLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="modalUploadAkteLabel">Upload Akte Kelahiran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="<?= site_url('uploadberkas/upload/' . ($siswa->id_peserta ?? '')) ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="modal-body">
                              <div class="mb-3">
                                <label for="akte" class="form-label">Pilih file Akte (PDF/JPG/PNG, max 2MB)</label>
                                <input type="file" class="form-control" id="akte" name="akte" required>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                              <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>

                    <!-- Modal Upload Ijazah -->
                    <div class="modal fade" id="modalUploadIjazah" tabindex="-1" aria-labelledby="modalUploadIjazahLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="modalUploadIjazahLabel">Upload Ijazah</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="<?= site_url('uploadberkas/upload/' . ($siswa->id_peserta ?? '')) ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="modal-body">
                              <div class="mb-3">
                                <label for="ijazah" class="form-label">Pilih file Ijazah (PDF/JPG/PNG, max 2MB)</label>
                                <input type="file" class="form-control" id="ijazah" name="ijazah" required>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                              <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="px-4 py-3 border-top">
                <ul class="list-inline mb-0">
                  <li class="list-inline-item me-3">
                    <?php
                    $total = 3;
                    $done = 0;
                    if (!empty($siswa->status_kk) && $siswa->status_kk === 'sudah') $done++;
                    if (!empty($siswa->status_akte) && $siswa->status_akte === 'sudah') $done++;
                    if (!empty($siswa->status_ijazah) && $siswa->status_ijazah === 'sudah') $done++;
                    $percent = round(($done / $total) * 100);
                    ?>
                    <div class="progress" style="height: 28px; width: 120px; background: #f8f9fa;">
                      <div class="progress-bar bg-success d-flex align-items-center justify-content-center" role="progressbar" style="width: <?= $percent ?>%; font-weight:bold; font-size:15px;" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100">
                        <?= $percent ?>%
                      </div>
                    </div>
                  </li>
                  <li class="list-inline-item me-3">
                    <i class="bx bx-calendar me-1"></i> 15 Oct, 19
                  </li>
                  <li class="list-inline-item me-3">
                    <i class="bx bx-comment-dots me-1"></i> 214
                  </li>
                </ul>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="col-12">
        <div class="alert alert-success">Semua peserta sudah upload berkas.</div>
      </div>
    <?php endif; ?>
  </div>
  <?= $this->endSection() ?>