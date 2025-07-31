<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Validasi Siswa &mdash; SDN Krengseng 02</title>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4 class="mb-sm-0 font-size-18">Validasi Siswa</h4>
        </div>
      </div>
    </div>
    <?php if (session()->getFlashdata('success')) : ?>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            html: `<?= str_replace(["\n", "\r"], ['<br>', ''], session()->getFlashdata('success')) ?>`,
            timer: 5000,
            timerProgressBar: true,
            showConfirmButton: true,
            confirmButtonText: 'OK',
            confirmButtonColor: '#28a745'
          });
        });
      </script>
    <?php endif; ?>
    <?php if (session()->getFlashdata('warning')) : ?>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            html: `<?= str_replace(["\n", "\r"], ['<br>', ''], session()->getFlashdata('warning')) ?>`,
            timer: 8000,
            timerProgressBar: true,
            showConfirmButton: true,
            confirmButtonText: 'OK',
            confirmButtonColor: '#ffc107',
            customClass: {
              htmlContainer: 'text-start'
            }
          });
        });
      </script>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            html: `<?= str_replace(["\n", "\r"], ['<br>', ''], session()->getFlashdata('error')) ?>`,
            timer: 8000,
            timerProgressBar: true,
            showConfirmButton: true,
            confirmButtonText: 'OK',
            confirmButtonColor: '#dc3545',
            customClass: {
              htmlContainer: 'text-start'
            }
          });
        });
      </script>
    <?php endif; ?>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body"> <!-- Tombol Modal Tarik di atas tabel -->
            <button type="button" class="btn <?= empty($siswa_lulus) ? 'btn-secondary' : 'btn-info' ?> mb-3" id="btn-tarik-massal" data-bs-toggle="modal" data-bs-target="#modalTarikSiswa">
              <i class="mdi mdi-account-arrow-right"></i> Tarik Siswa
              <?php if (!empty($siswa_lulus)): ?>
                <span class="badge bg-light text-dark"><?= count($siswa_lulus) ?></span>
              <?php endif; ?>
            </button>
            <div class="table-responsive mb-4">
              <?php if (!empty($siswa_validasi)) : ?>
                <h5 class="mb-2">Tabel Siswa Hasil Tarik (Belum Masuk Database)</h5>
                <table class="table table-bordered table-striped">
                  <thead class="table-light">
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>JK</th>
                      <th>NISN</th>
                      <th>NIK</th>
                      <th>Tempat Lahir</th>
                      <th>Tanggal Lahir</th>
                      <th>Kelas</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1;
                    foreach ($siswa_validasi as $idx => $siswa) : ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($siswa['nama_siswa'] ?? '-') ?></td>
                        <td><?= $siswa['jk'] ?? '-' ?></td>
                        <td><?= $siswa['nisn'] ?? '-' ?></td>
                        <td><?= $siswa['nik'] ?? '-' ?></td>
                        <td><?= $siswa['tempat_lahir'] ?? '-' ?></td>
                        <td><?= $siswa['tanggal_lahir'] ?? '-' ?></td>
                        <td>
                          <?php
                          $rombelNama = '-';
                          if (!empty($siswa['id_rombel']) && !empty($rombels)) {
                            foreach ($rombels as $rombel) {
                              if ($rombel->id_rombel == $siswa['id_rombel']) {
                                // Tampilkan hanya satu kali jika rombel sama dengan kelas atau kosong
                                if (empty($rombel->rombel) || $rombel->rombel === $rombel->kelas) {
                                  $rombelNama = $rombel->kelas;
                                } else {
                                  $rombelNama = $rombel->kelas . ' ' . $rombel->rombel;
                                }
                                break;
                              }
                            }
                          }
                          echo $rombelNama;
                          ?>
                        </td>
                        <td>
                          <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalValidasi<?= $idx ?>">Validasi</button>
                          <!-- Modal Konfirmasi Validasi Siswa -->
                          <div class="modal fade" id="modalValidasi<?= $idx ?>" tabindex="-1" aria-labelledby="modalValidasiLabel<?= $idx ?>" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="modalValidasiLabel<?= $idx ?>">Konfirmasi Validasi Siswa</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="<?= site_url('peserta_didik/validasi_siswa') ?>" method="post">
                                  <?= csrf_field() ?>
                                  <?php
                                  // Ambil NIS terbesar dari db_siswa (langsung di view)
                                  $db = \Config\Database::connect();
                                  $lastNisRow = $db->table('db_siswa')
                                    ->select('nis')
                                    ->where('nis IS NOT NULL')
                                    ->where('nis !=', '')
                                    ->orderBy('CAST(nis AS UNSIGNED)', 'DESC')
                                    ->limit(1)
                                    ->get()->getRow();
                                  $lastNis = ($lastNisRow && !empty($lastNisRow->nis)) ? (int)$lastNisRow->nis : 2300;
                                  $nextNis = $lastNis + 1;
                                  ?>
                                  <?php foreach ($siswa as $k => $v): ?>
                                    <input type="hidden" name="siswa[<?= htmlspecialchars($k) ?>]" value="<?= htmlspecialchars($v) ?>">
                                  <?php endforeach; ?>
                                  <input type="hidden" name="siswa[nis]" value="<?= $nextNis ?>">
                                  <div class="modal-body">
                                    <div class="table-responsive">
                                      <table class="table table-bordered mb-3">
                                        <tr>
                                          <th style="width: 120px;">Nama</th>
                                          <td><?= htmlspecialchars($siswa['nama_siswa'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                          <th>NISN</th>
                                          <td><?= $siswa['nisn'] ?? '-' ?></td>
                                        </tr>
                                        <tr>
                                          <th>NIS (Akan Diberikan)</th>
                                          <td><span class="text-success fw-bold"><?= $nextNis ?></span></td>
                                        </tr>
                                      </table>
                                    </div>
                                    <div class="alert alert-info small">Pastikan data sudah benar sebelum menyimpan.</div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Kirim / Simpan</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              <?php else : ?>
                <table id="scroll-horizontal" class="table table-bordered dt-responsive nowrap w-100">
                  <thead class="table-light">
                    <tr>
                      <th class="align-middle">No</th>
                      <th class="align-middle">Nama</th>
                      <th class="align-middle">JK</th>
                      <th class="align-middle">NISN</th>
                      <th class="align-middle">NIK</th>
                      <th class="align-middle">Tempat Lahir</th>
                      <th class="align-middle">Tanggal Lahir</th>
                      <th class="align-middle">Kelas</th>
                      <th class="align-middle">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($siswa_tanpa_kelas as $key => $value) : ?>
                      <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= mb_strimwidth($value->nama_siswa, 0, 20, "...") ?></td>
                        <td><?= $value->jk ?></td>
                        <td><?= $value->nisn ?></td>
                        <td><?= $value->nik ?></td>
                        <td><?= $value->tempat_lahir ?></td>
                        <td><?= $value->tanggal_lahir ?></td>
                        <form action="<?= site_url('peserta_didik/update_class/' . $value->id_siswa) ?>" method="post">
                          <td>
                            <?= csrf_field() ?>
                            <select name="id_rombel" class="form-control">
                              <?php foreach ($rombels as $rombel) : ?>
                                <option value="<?= $rombel->id_rombel ?>"><?= $rombel->kelas ?></option>
                              <?php endforeach; ?>
                            </select>
                          </td>
                          <td>
                            <button type="submit" class="btn btn-sm btn-success bg-gradient mt-2">Update</button>
                          </td>
                        </form>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              <?php endif; ?>
            </div>
            <div class="modal fade" id="modalTarikSiswa" tabindex="-1" aria-labelledby="modalTarikSiswaLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalTarikSiswaLabel">
                      Tarik Siswa Lulus ke Kelas Baru
                      <?php if (!empty($siswa_lulus)): ?>
                        <span class="badge bg-primary"><?= count($siswa_lulus) ?> Siswa</span>
                      <?php else: ?>
                        <span class="badge bg-secondary">Tidak Ada Siswa</span>
                      <?php endif; ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form id="form-tarik-lulus" action="<?= site_url('peserta_didik/update_class_lulus') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                      <div class="mb-3">
                        <label for="id_rombel_lulus" class="form-label">Kelas Tujuan</label>
                        <select name="id_rombel" id="id_rombel_lulus" class="form-select" required>
                          <?php foreach ($rombels as $rombel): ?>
                            <option value="<?= $rombel->id_rombel ?>"
                              <?php if (stripos($rombel->kelas, '1') !== false): ?>selected<?php endif; ?>>
                              <?= $rombel->kelas ?> <?= $rombel->rombel ? $rombel->rombel : '' ?>
                            </option>
                          <?php endforeach; ?>
                          <?php if (empty($rombels)): ?>
                            <option value="">Tidak ada kelas tersedia</option>
                          <?php endif; ?>
                        </select>
                        <div class="form-text">
                          <small class="text-muted">
                            <i class="mdi mdi-information-outline me-1"></i>
                            Pastikan memilih kelas yang sesuai. Kelas 1 dipilih secara otomatis untuk siswa baru.
                          </small>
                        </div>
                      </div>
                      <?php if (!empty($siswa_lulus)): ?>
                        <div class="alert alert-success">
                          <i class="mdi mdi-check-circle me-2"></i>
                          <strong><?= count($siswa_lulus) ?> siswa</strong> siap untuk ditarik ke database aktif.
                          <br><small>Pilih siswa dengan menggunakan checkbox, atau gunakan tombol "Pilih Semua" di bawah.</small>
                        </div>
                      <?php endif; ?>
                      <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                          <thead class="table-light">
                            <tr>
                              <th style="width:40px;">
                                <div class="form-check">
                                  <input type="checkbox" id="select-all-lulus" class="form-check-input">
                                  <label class="form-check-label" for="select-all-lulus">
                                    <small>Semua</small>
                                  </label>
                                </div>
                              </th>
                              <th>Nama</th>
                              <th>JK</th>
                              <th>NISN</th>
                              <th>NIK</th>
                              <th>Tempat Lahir</th>
                              <th>Tanggal Lahir</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if (!empty($siswa_lulus)) : ?>
                              <?php foreach ($siswa_lulus as $siswa) : ?>
                                <tr>
                                  <td><input type="checkbox" name="siswa[]" value="<?= $siswa->id_peserta ?>"></td>
                                  <td><?= htmlspecialchars($siswa->nama_peserta ?? $siswa->nama_siswa ?? '-') ?></td>
                                  <td><?= $siswa->jk ?? $siswa->jenis_kelamin ?? '-' ?></td>
                                  <td><?= $siswa->nisn ?? '-' ?></td>
                                  <td><?= $siswa->nik ?? '-' ?></td>
                                  <td><?= $siswa->tempat_lahir ?? '-' ?></td>
                                  <td><?= $siswa->tanggal_lahir ?? '-' ?></td>
                                </tr>
                              <?php endforeach; ?>
                            <?php else : ?>
                              <tr>
                                <td colspan="7" class="text-center py-4">
                                  <div class="alert alert-info mb-0">
                                    <i class="mdi mdi-information-outline me-2"></i>
                                    <strong>Tidak ada siswa lulus yang tersedia untuk ditarik.</strong>
                                    <br>
                                    <small class="text-muted">
                                      Kemungkinan penyebab:
                                      <br>• Semua siswa lulus sudah ditarik ke database
                                      <br>• Belum ada siswa baru yang diterima/lulus
                                      <br>• Status siswa belum diubah menjadi "Lulus" atau "Diterima"
                                    </small>
                                  </div>
                                </td>
                              </tr>
                            <?php endif; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <div class="me-auto">
                        <small class="text-muted">
                          <span id="selected-count">0</span> dari <span id="total-count"><?= count($siswa_lulus) ?></span> siswa dipilih
                        </small>
                      </div>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                      <button type="submit" class="btn btn-success" <?= empty($siswa_lulus) ? 'disabled' : '' ?>>
                        <i class="mdi mdi-account-arrow-right me-1"></i> Tarik ke Kelas
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <script>
              document.addEventListener('DOMContentLoaded', function() {
                // Select all checkbox for siswa lulus
                var selectAllLulus = document.getElementById('select-all-lulus');
                if (selectAllLulus) {
                  selectAllLulus.addEventListener('change', function() {
                    var checkboxes = document.querySelectorAll('input[name="siswa[]"]');
                    console.log('Toggling ' + checkboxes.length + ' checkboxes');
                    checkboxes.forEach(function(cb) {
                      cb.checked = selectAllLulus.checked;
                    });
                    updateSelectedCount();
                  });
                }

                // Update selected count when individual checkboxes change
                document.addEventListener('change', function(e) {
                  if (e.target.name === 'siswa[]') {
                    updateSelectedCount();
                    updateSelectAllState();
                  }
                });

                // Function to update selected count display
                function updateSelectedCount() {
                  var checkboxes = document.querySelectorAll('input[name="siswa[]"]:checked');
                  var selectedCountElement = document.getElementById('selected-count');
                  if (selectedCountElement) {
                    selectedCountElement.textContent = checkboxes.length;
                  }
                }

                // Function to update "select all" checkbox state
                function updateSelectAllState() {
                  var allCheckboxes = document.querySelectorAll('input[name="siswa[]"]');
                  var checkedCheckboxes = document.querySelectorAll('input[name="siswa[]"]:checked');
                  var selectAllCheckbox = document.getElementById('select-all-lulus');

                  if (selectAllCheckbox && allCheckboxes.length > 0) {
                    if (checkedCheckboxes.length === allCheckboxes.length) {
                      selectAllCheckbox.checked = true;
                      selectAllCheckbox.indeterminate = false;
                    } else if (checkedCheckboxes.length > 0) {
                      selectAllCheckbox.checked = false;
                      selectAllCheckbox.indeterminate = true;
                    } else {
                      selectAllCheckbox.checked = false;
                      selectAllCheckbox.indeterminate = false;
                    }
                  }
                }

                // Initialize count display
                updateSelectedCount();
                updateSelectAllState();

                // Check for success message and refresh modal content if needed
                var successMessage = "<?= session()->getFlashdata('success') ?>";
                var warningMessage = "<?= session()->getFlashdata('warning') ?>";
                if (successMessage && successMessage.includes('siswa berhasil ditarik') ||
                  warningMessage && warningMessage.includes('siswa berhasil ditarik')) {
                  // After successful student pull operation, make sure modal refreshes with updated list
                  document.querySelector('#modalTarikSiswa').addEventListener('show.bs.modal', function(event) {
                    // Force a page refresh to get updated student list if the pull was successful
                    if (window.lastRefresh && (new Date() - window.lastRefresh) < 10000) {
                      // Already refreshed recently, don't refresh again
                      return;
                    }
                    window.lastRefresh = new Date();
                    window.location.reload();
                  });
                }

                // Form validation before submit
                var formTarikLulus = document.getElementById('form-tarik-lulus');
                if (formTarikLulus) {
                  formTarikLulus.addEventListener('submit', function(e) {
                    var checkboxes = document.querySelectorAll('input[name="siswa[]"]:checked');
                    var kelasSelect = document.getElementById('id_rombel_lulus');

                    // Validate checkbox selection
                    if (checkboxes.length === 0) {
                      e.preventDefault();
                      Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Siswa',
                        text: 'Silakan pilih minimal satu siswa untuk ditarik ke kelas baru.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6'
                      });
                      return false;
                    }

                    // Validate class selection
                    if (!kelasSelect.value) {
                      e.preventDefault();
                      Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Kelas',
                        text: 'Silakan pilih kelas tujuan untuk siswa yang akan ditarik.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6'
                      });
                      return false;
                    }

                    e.preventDefault(); // Prevent default submission

                    // Show confirmation with SweetAlert2
                    var kelasText = kelasSelect.options[kelasSelect.selectedIndex].text;

                    Swal.fire({
                      title: 'Konfirmasi Penarikan Siswa',
                      html: `
                          <div class="text-start">
                            <p class="mb-3"><strong>Apakah Anda yakin ingin menarik ${checkboxes.length} siswa ke kelas "${kelasText}"?</strong></p>
                            
                            <div class="alert alert-info text-start mb-3">
                              <h6 class="mb-2"><i class="mdi mdi-information-outline me-1"></i>Proses ini akan:</h6>
                              <ul class="mb-0 ps-3">
                                <li>Menambahkan siswa baru yang belum ada di database</li>
                                <li>Memperbarui data siswa yang sudah ada (sinkronisasi)</li>
                                <li>Memindahkan/mengupdate kelas sesuai pilihan</li>
                                <li>Memberikan NIS otomatis untuk siswa kelas 1 baru</li>
                                <li>Mengupdate status siswa menjadi aktif</li>
                              </ul>
                            </div>
                            
                            <div class="alert alert-warning text-start mb-0">
                              <p class="mb-1"><i class="mdi mdi-shield-check me-1"></i><strong>Deteksi Duplikasi:</strong></p>
                              <p class="mb-0 small">Sistem akan mendeteksi duplikasi berdasarkan NISN, NIK, atau kombinasi nama+tanggal lahir.</p>
                            </div>
                          </div>
                        `,
                      icon: 'question',
                      showCancelButton: true,
                      confirmButtonColor: '#28a745',
                      cancelButtonColor: '#6c757d',
                      confirmButtonText: '<i class="mdi mdi-account-arrow-right me-1"></i>Ya, Tarik Siswa',
                      cancelButtonText: '<i class="mdi mdi-close me-1"></i>Batal',
                      reverseButtons: true,
                      width: '600px',
                      customClass: {
                        htmlContainer: 'text-start'
                      }
                    }).then((result) => {
                      if (result.isConfirmed) {
                        // Show loading state
                        Swal.fire({
                          title: 'Memproses Data Siswa',
                          html: `
                              <div class="text-center">
                                <div class="spinner-border text-primary mb-3" role="status">
                                  <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mb-1">Sedang memproses ${checkboxes.length} siswa...</p>
                                <small class="text-muted">Mohon tunggu, proses ini mungkin membutuhkan beberapa detik.</small>
                              </div>
                            `,
                          allowOutsideClick: false,
                          allowEscapeKey: false,
                          showConfirmButton: false,
                          customClass: {
                            htmlContainer: 'text-center'
                          }
                        });

                        // Update button state
                        var submitButton = formTarikLulus.querySelector('button[type="submit"]');
                        if (submitButton) {
                          submitButton.disabled = true;
                          submitButton.innerHTML = '<i class="mdi mdi-loading mdi-spin me-1"></i> Memproses...';
                        }

                        // Submit the form
                        console.log('Submitting form with ' + checkboxes.length + ' selected students to class ID: ' + kelasSelect.value);
                        formTarikLulus.submit();
                      }
                    });
                  });
                }
              });
            </script>
          </div>
        </div>
        <!-- end table-responsive -->
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>