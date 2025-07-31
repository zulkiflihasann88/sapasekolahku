<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Sleksi Penerimaan murid baru &mdash; SDN Krengseng 02</title>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
  .upload-card {
    border: 1px solid #dde2ec;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    transition: all 0.3s;
  }

  .upload-card:hover {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }

  .upload-icon {
    font-size: 1.5rem;
  }

  .upload-berkas-form {
    margin-bottom: 0;
  }

  #verifikasi-berkas-file-buttons .btn-primary,
  #verifikasi-berkas-file-buttons .btn-outline-primary,
  #verifikasi-berkas-file-buttons .btn-danger {
    border-radius: 4px;
    padding: 8px 12px;
  }

  #verifikasi-berkas-file-buttons .alert {
    padding: 8px 12px;
    margin-bottom: 10px;
    border-radius: 4px;
  }

  .modal-title {
    font-weight: 600;
  }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4 class="mb-sm-0 font-size-18">Calon Peserta didik</h4>

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
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="row mb-3">
              <!-- Left column with 2 buttons -->
              <div class="col-xs-6 col-md-6">
                <a href="<?= site_url('calon_siswa/new') ?>" class="btn btn-sm btn-success waves-effect waves-light bg-gradient">
                  <i class="fas fa-plus"></i> Tambah
                </a>
                <a href="<?= site_url('peserta_didik/new') ?>" class="btn btn-sm btn-danger waves-effect waves-light bg-gradient">
                  <i class="fas fa-trash"></i> Hapus Data Terpilih
                </a>
                <a href="javascript:void(0);" id="btn-export-excel" class="btn btn-sm btn-info waves-effect waves-light bg-gradient">
                  <i class="fas fa-file-excel"></i> Export Excel
                </a>
              </div>

              <!-- Right column with 4 buttons -->
              <div class="col-xs-6 col-md-6 text-end">
                <a href="<?= site_url('peserta_didik/new') ?>" class="btn btn-sm btn-warning waves-effect waves-light bg-gradient"><i class="fas fa-user-check"></i> Reset Hasil
                </a>
                <button type="button" id="btn-terima-semua" class="btn btn-sm btn-success waves-effect waves-light bg-gradient">
                  <i class="fas fa-user-check label-icon"></i> Terima semua
                </button>
                <script>
                  document.addEventListener('DOMContentLoaded', function() {
                    // TOMBOL TERIMA SEMUA
                    var btnTerimaSemua = document.getElementById('btn-terima-semua');
                    if (btnTerimaSemua) {
                      btnTerimaSemua.addEventListener('click', function() {
                        Swal.fire({
                          title: 'Terima Semua Peserta?',
                          text: 'Semua peserta yang memenuhi syarat akan diterima. Lanjutkan?',
                          icon: 'question',
                          showCancelButton: true,
                          confirmButtonText: 'Ya, Terima Semua',
                          cancelButtonText: 'Batal',
                          confirmButtonColor: '#28a745'
                        }).then(function(result) {
                          if (result.isConfirmed) {
                            fetch('<?= site_url('calon_siswa/terima_semua') ?>', {
                                method: 'POST',
                                headers: {
                                  'Content-Type': 'application/json',
                                  'X-Requested-With': 'XMLHttpRequest',
                                  'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                                },
                                body: JSON.stringify({
                                  action: 'terima_semua'
                                })
                              })
                              .then(response => response.json())
                              .then(data => {
                                if (data.success) {
                                  Swal.fire('Sukses', 'Semua peserta berhasil diterima.', 'success').then(() => window.location.reload());
                                } else {
                                  Swal.fire('Gagal', data.message || 'Gagal menerima semua peserta.', 'error');
                                }
                              })
                              .catch(() => Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error'));
                          }
                        });
                      });
                    }

                    // PATCH: Modal Konfirmasi Hapus - add null checks for modalHapusNama and btn-modal-hapus-ya
                    var modalEl = document.getElementById('modalKonfirmasiHapus');
                    var modalInstance = null;
                    if (modalEl) {
                      modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                    }
                    document.querySelectorAll('.btn-delete-modal').forEach(function(btn) {
                      btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        var idForm = this.getAttribute('data-idform');
                        var nama = this.getAttribute('data-nama');
                        var modalHapusNama = document.getElementById('modalHapusNama');
                        var btnModalHapusYa = document.getElementById('btn-modal-hapus-ya');
                        if (modalHapusNama) modalHapusNama.textContent = nama || '';
                        if (btnModalHapusYa) btnModalHapusYa.setAttribute('data-idform', idForm);
                        if (modalInstance) modalInstance.show();
                      });
                    });
                    var btnHapus = document.getElementById('btn-modal-hapus-ya');
                    if (btnHapus) {
                      btnHapus.addEventListener('click', function() {
                        var idForm = this.getAttribute('data-idform');
                        if (idForm) {
                          var form = document.getElementById(idForm);
                          if (form) {
                            if (modalInstance) modalInstance.hide();
                            setTimeout(function() {
                              form.submit();
                            }, 250);
                          }
                        }
                      });
                    }
                    if (modalEl) {
                      modalEl.addEventListener('hidden.bs.modal', function() {
                        var modalHapusNama = document.getElementById('modalHapusNama');
                        var btnModalHapusYa = document.getElementById('btn-modal-hapus-ya');
                        if (modalHapusNama) modalHapusNama.textContent = '';
                        if (btnModalHapusYa) btnModalHapusYa.removeAttribute('data-idform');
                        var backdrops = document.querySelectorAll('.modal-backdrop');
                        backdrops.forEach(function(bd) {
                          if (bd && bd.parentNode) bd.parentNode.removeChild(bd);
                        });
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                      });
                    }
                  });
                </script>
                <a href="<?= site_url('peserta_didik/new') ?>" class="btn btn-sm btn-info waves-effect waves-light bg-gradient">
                  <i class="fas fa-print label-icon"></i> Print
                </a> <a href="<?= site_url('calon_siswa/jurnal_spmb') ?>" class="btn btn-sm btn-primary waves-effect waves-light bg-gradient">
                  <i class="fas fa-book label-icon"></i> Jurnal SPMB
                </a>
              </div>
            </div>
            <table id="scroll-horizontal" class="table table-bordered dt-responsive  nowrap w-100">
              <thead class="table-light">
                <tr>
                  <th class="align-middle">No</th>
                  <th class="align-middle">No Pendaftaran</th>
                  <th class="align-middle">Nama Peserta</th>
                  <th class="align-middle">Sekolah Asal</th>
                  <th class="align-middle">Jalur</th>
                  <th class="align-middle">Status</th>
                  <th class="align-middle">Hasil</th>
                  <th class="align-middle">Daftar Ulang</th>
                  <th class="align-middle text-center">AKSI</th>
                </tr>
              </thead>
              <!-- Pastikan modalVerifikasiBerkas hanya satu kali, di luar loop tabel -->
              <div id="modals-container">
                <div class="modal fade" id="modalVerifikasiBerkas" tabindex="-1" aria-labelledby="modalVerifikasiBerkasLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalVerifikasiBerkasLabel">Verifikasi Berkas Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="mb-3 text-center">
                          <div class="fw-bold" id="verifikasi-berkas-nama" style="font-size:2rem;"></div>
                        </div>
                        <div class="d-grid gap-2 mt-3">
                          <div id="verifikasi-berkas-file-buttons" class="row mb-2 align-items-center g-2"></div>
                        </div>
                      </div>
                      <div class="modal-footer flex-wrap gap-2 justify-content-between">
                        <input type="hidden" id="verifikasi-berkas-id-peserta" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" id="btn-verifikasi-berkas-lulus" class="btn btn-success"><i class="mdi mdi-check-circle"></i> Verifikasi Berkas Lengkap</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <tbody>
                <?php foreach ($calon_siswa as $key => $value) : ?>
                  <tr>
                    <td class="align-middle"><?= $key + 1 ?></td>
                    <td class="align-middle">

                      <div class="d-flex align-items-center gap-2">
                        <a href="#" class="text-primary no-pendaftaran-link"
                          data-tahun="<?= htmlspecialchars($value->tahun_pelajaran ?? '-') ?>"
                          data-tanggal="<?= htmlspecialchars($value->tanggal_daftar ?? '-') ?>"
                          data-nisn="<?= htmlspecialchars($value->nisn ?? '-') ?>"
                          data-nama="<?= isset($value->nama_peserta) ? ucwords(strtolower($value->nama_peserta)) : '-' ?>"
                          data-nopendaftaran="<?= htmlspecialchars($value->no_pendaftaran ?? '-') ?>"
                          data-bs-toggle="modal" data-bs-target="#modalDetailSiswa-<?= $value->id_peserta ?>">
                          <?= $value->no_pendaftaran ?? '-' ?>
                        </a>

                      </div>

                      <!-- Modal Detail Siswa (per siswa) -->
                      <div class="modal fade" id="modalDetailSiswa-<?= $value->id_peserta ?>" tabindex="-1" aria-labelledby="modalDetailSiswaLabel-<?= $value->id_peserta ?>" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="modalDetailSiswaLabel-<?= $value->id_peserta ?>">Detail Siswa</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <table class="table table-bordered">
                                <tr>
                                  <th>No. Pendaftaran</th>
                                  <td><?= htmlspecialchars($value->no_pendaftaran ?? '-') ?></td>
                                </tr>
                                <tr>
                                  <th>Nama</th>
                                  <td><?= isset($value->nama_peserta) ? ucwords(strtolower(htmlspecialchars($value->nama_peserta))) : '-' ?></td>
                                </tr>
                                <tr>
                                  <th>NISN</th>
                                  <td><?= htmlspecialchars($value->nisn ?? '-') ?></td>
                                </tr>
                                <tr>
                                  <th>Tanggal Lahir</th>
                                  <td>
                                    <?php
                                    $ttl = ($value->tempat_lahir ?? '') . ', ' . ($value->tanggal_lahir ?? '-');
                                    echo htmlspecialchars($ttl);
                                    // Hitung usia jika tanggal_lahir valid
                                    if (!empty($value->tanggal_lahir) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value->tanggal_lahir)) {
                                      $lahir = new DateTime($value->tanggal_lahir);
                                      $today = new DateTime();
                                      $diff = $today->diff($lahir);
                                      $usia_tahun = $diff->y;
                                      $usia_bulan = $diff->m;
                                      echo " <span class='badge bg-info ms-2'>(Usia: {$usia_tahun} tahun {$usia_bulan} bulan)</span>";
                                    }
                                    ?>
                                  </td>
                                </tr>
                                <tr>
                                  <th>Tahun Pelajaran</th>
                                  <td><?= htmlspecialchars($value->tahun_pelajaran_penerimaan ?? '-') ?></td>
                                </tr>
                                <tr>
                                  <th>Tanggal Daftar</th>
                                  <td><?= htmlspecialchars($value->tanggal_daftar ?? '-') ?></td>
                                </tr>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="align-middle"><?= isset($value->nama_peserta) ? ucwords(strtolower($value->nama_peserta)) : '-' ?></td>
                    <td class="align-middle"><?= $value->sekolah_asal ?? '-' ?></td>
                    <td class="align-middle">
                      <?php
                      $jalur = strtolower(trim($value->jalur ?? ''));
                      if ($jalur === 'zonasi') {
                        echo '<span class="badge bg-primary">Zonasi</span>';
                      } elseif ($jalur === 'afirmasi') {
                        echo '<span class="badge bg-success">Afirmasi</span>';
                      } elseif ($jalur === 'prestasi') {
                        echo '<span class="badge bg-warning text-dark">Prestasi</span>';
                      } elseif ($jalur === 'mutasi') {
                        echo '<span class="badge bg-info text-dark">Mutasi</span>';
                      } else {
                        echo '<span class="badge bg-secondary">-</span>';
                      }
                      ?>
                    </td>
                    <td class="align-middle"><?= $value->status ?? '-' ?></td>
                    <td class="align-middle">
                      <?php
                      $status = strtolower(trim($value->status_hasil ?? ''));
                      if ($status === 'lulus') {
                        echo '<span class="badge bg-success"><i class="mdi mdi-check"></i> Diterima</span>';
                      } elseif ($status === 'tidak lulus') {
                        echo '<span class="badge bg-danger"><i class="mdi mdi-close"></i> Tidak Diterima</span>';
                      } else {
                        echo '<span class="badge bg-secondary">Belum Diverifikasi</span>';
                      }
                      ?>
                    </td>
                    <td class="align-middle">
                      <?php
                      // Status daftar ulang: 0 = belum, 1 = sudah, 2 = pending, 3 = perlu verifikasi
                      // Jika semua file sudah terupload, tampilkan Terverifikasi
                      $kk_uploaded = false;
                      $akte_uploaded = false;
                      $ijazah_uploaded = false;
                      $kk_path = FCPATH . 'uploads/berkas/' . ($value->id_peserta ?? '') . '/';
                      if (count(glob($kk_path . 'kk_' . ($value->id_peserta ?? '') . '.*')) > 0) $kk_uploaded = true;
                      if (count(glob($kk_path . 'akte_' . ($value->id_peserta ?? '') . '.*')) > 0) $akte_uploaded = true;
                      if (count(glob($kk_path . 'ijazah_' . ($value->id_peserta ?? '') . '.*')) > 0) $ijazah_uploaded = true;
                      // Jika verifikasi berkas sudah dilakukan dan statusnya terverifikasi, dan semua berkas sudah diupload, tampilkan Terverifikasi
                      // Tambahkan pengecekan untuk memastikan semua berkas sudah diupload
                      $all_files_uploaded = ($kk_uploaded && $akte_uploaded && $ijazah_uploaded);
                      $has_verification_status = (!empty($value->status_verifikasi_berkas) && strtolower($value->status_verifikasi_berkas) === 'terverifikasi');
                      $has_daftar_ulang_status = (!empty($value->status_daftar_ulang) && $value->status_daftar_ulang == '1');

                      // Jika status terverifikasi tapi file belum lengkap, ubah status jadi "Perlu Verifikasi"
                      if (($has_verification_status || $has_daftar_ulang_status) && !$all_files_uploaded) {
                        // Update status di database juga (tandai perlu verifikasi)
                        echo '<span class="badge bg-danger d-block w-100 text-center">Berkas Belum Lengkap</span>';
                      } elseif ($has_verification_status || $has_daftar_ulang_status) {
                        echo '<span class="badge bg-success d-block w-100 text-center">Terverifikasi</span>';
                      } elseif (!empty($value->status_daftar_ulang) && $value->status_daftar_ulang == '3') {
                        echo '<span class="badge bg-warning text-dark d-block w-100 text-center">Perlu Verifikasi</span>';
                      } else {
                        echo '<span class="badge bg-info text-dark d-block w-100 text-center">Pending</span>';
                      }
                      ?>
                    </td>
                    <td class="align-middle text-center">
                      <?php
                      // Slugify nama peserta: non-alphanumeric to _, trim _
                      $nama_peserta = trim($value->nama_peserta ?? '');
                      $nama_peserta_cap = ucwords(strtolower($nama_peserta));
                      $slug_nama = preg_replace('/[^a-z0-9]+/i', '_', $nama_peserta_cap);
                      $slug_nama = trim($slug_nama, '_');
                      // Kapital di awal kata, underscore tetap (contoh: Utri_Ntan_Priyani)
                      $slug_nama = str_replace('_', ' ', $slug_nama);
                      $slug_nama = ucwords($slug_nama);
                      $slug_nama = str_replace(' ', '_', $slug_nama);
                      ?>

                      <a href="<?= site_url('calon_siswa/edit/' . $value->id_peserta) ?>" class="btn btn-sm btn-primary waves-effect waves-light bg-gradient" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit">
                        <i class="mdi mdi-pencil"></i>
                      </a>
                      <button type="button" class="btn btn-warning btn-sm bg-gradient btn-verifikasi-berkas"
                        data-id="<?= $value->id_peserta ?>"
                        data-nama="<?= htmlspecialchars($value->nama_peserta) ?>"
                        data-bs-toggle="modal" data-bs-target="#modalVerifikasiBerkas"
                        title="Verifikasi Berkas">
                        <i class="mdi mdi-file-upload-outline"></i>
                      </button>
                      <!-- Modal Verifikasi Berkas (hanya satu, di luar loop tabel) -->
                      <?php if ($key === 0): // Only render modal once 
                      ?>
                        <div class="modal fade" id="modalVerifikasiBerkas" tabindex="-1" aria-labelledby="modalVerifikasiBerkasLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalVerifikasiBerkasLabel">Verifikasi Berkas Siswa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="mb-3 text-center">
                                  <div class="fw-bold" id="verifikasi-berkas-nama" style="font-size:2rem;"></div>
                                </div>
                                <div class="d-grid gap-2 mt-3">
                                  <div id="verifikasi-berkas-file-buttons" class="row mb-2 align-items-center g-2"></div>
                                </div>
                              </div>
                              <div class="modal-footer flex-wrap gap-2 justify-content-between">
                                <input type="hidden" id="verifikasi-berkas-id-peserta" value="">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="button" id="btn-verifikasi-berkas-lulus" class="btn btn-success"><i class="mdi mdi-check-circle"></i> Verifikasi Berkas Lengkap</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php endif; ?>
                      <button type="button" class="btn btn-success btn-sm bg-gradient btn-verifikasi-hasil"
                        data-id="<?= $value->id_peserta ?>"
                        data-nama="<?= htmlspecialchars($value->nama_peserta) ?>"
                        data-nokk="<?= htmlspecialchars($value->nomor_kk ?? '') ?>"
                        data-nik="<?= htmlspecialchars($value->nik ?? '') ?>"
                        data-kk="<?= $kk_uploaded ? '1' : '0' ?>"
                        data-akte="<?= $akte_uploaded ? '1' : '0' ?>"
                        data-ijazah="<?= $ijazah_uploaded ? '1' : '0' ?>"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Verifikasi Hasil">
                        <i class="mdi mdi-check-decagram"></i>
                      </button>
                      <!-- Modal Info Data/Berkas Belum Lengkap -->
                      <div class="modal fade" id="modalInfoBelumLengkap" tabindex="-1" aria-labelledby="modalInfoBelumLengkapLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="modalInfoBelumLengkapLabel">Verifikasi Belum Dapat Dilakukan</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <div class="text-center mb-3">
                                <i class="mdi mdi-alert-circle-outline text-warning display-4"></i>
                              </div>
                              <h5 class="mb-2">Data atau Berkas Belum Lengkap</h5>
                              <div id="info-belum-lengkap-detail" class="mb-2"></div>
                              <div class="alert alert-warning" role="alert" style="white-space:pre-line">
                                Verifikasi belum dapat dilakukan karena data diri atau berkas belum lengkap. Silakan lengkapi data dan upload berkas terlebih dahulu.
                              </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <a href="<?= site_url('calon_siswa/cetak_buktidaftar/' . $value->id_peserta) ?>" class="btn btn-sm btn-primary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Detail">
                        <i class="fas fa-print"></i>
                      </a>
                      <!-- <a href="" target="_blank" class="btn btn-sm btn-info bg-gradient" data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak Bukti Pendaftaran">
                                                <i class="fas fa-print"></i>
                                            </a> -->
                      <form action="<?= site_url('calon_siswa/' . $value->id_peserta) ?>" method="post" class="d-inline form-delete" id="del-<?= $value->id_peserta ?>">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-danger btn-sm bg-gradient btn-delete-modal" data-idform="del-<?= $value->id_peserta ?>" data-nama="<?= htmlspecialchars($value->nama_peserta) ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Siswa">
                          <i class="mdi mdi-trash-can-outline"></i>
                        </button>
                      </form>

                      <!-- Modal Konfirmasi Hapus (global, satu saja di luar loop) -->
                      <?php if ($key === 0): ?>
                        <div class="modal fade" id="modalKonfirmasiHapus" tabindex="-1" aria-labelledby="modalKonfirmasiHapusLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalKonfirmasiHapusLabel">Konfirmasi Hapus Data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="text-center mb-3">
                                  <i class="mdi mdi-alert-circle-outline text-danger display-4"></i>
                                </div>
                                <h5 class="mb-2">Apakah Anda yakin ingin menghapus data ini?</h5>
                                <div id="modalHapusNama" class="fw-bold mb-2"></div>
                                <div class="alert alert-warning mt-3" role="alert">
                                  Data yang sudah dihapus tidak dapat dikembalikan!
                                </div>
                              </div>
                              <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="button" id="btn-modal-hapus-ya" class="btn btn-danger">Hapus</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php endif; ?>
                      <!-- Modal Konfirmasi Daftar Ulang (hanya satu, di luar loop tabel) -->
                      <div class="modal fade" id="modalKonfirmasiDaftarUlang" tabindex="-1" aria-labelledby="modalKonfirmasiDaftarUlangLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="modalKonfirmasiDaftarUlangLabel">Konfirmasi Daftar Ulang</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="form-konfirmasi-daftar-ulang" method="post" action="<?= site_url('calon_siswa/konfirmasi_daftar_ulang') ?>">
                              <?= csrf_field() ?>
                              <div class="modal-body">
                                <input type="hidden" name="id_peserta" id="konfirmasi-id-peserta">
                                <div class="mb-3">
                                  <div class="fw-bold" id="konfirmasi-nama-peserta" style="font-size:22px;"></div>
                                  <p class="mt-2">Apakah Anda yakin ingin mengkonfirmasi daftar ulang untuk peserta ini?</p>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Konfirmasi &amp; Simpan</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                      <!-- Modal Verifikasi Hasil (hanya satu, di luar loop tabel) -->
                      <div class="modal fade" id="modalVerifikasiHasil" tabindex="-1" aria-labelledby="modalVerifikasiHasilLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="modalVerifikasiHasilLabel">Verifikasi Hasil Seleksi</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="form-verifikasi-hasil" method="post" action="<?= site_url('calon_siswa/verifikasi_hasil') ?>">
                              <?= csrf_field() ?>
                              <div class="modal-body">
                                <input type="hidden" name="id_peserta" id="verifikasi-id-peserta">
                                <div class="mb-3">
                                  <div class="text-muted" id="verifikasi-no-pendaftaran" style="font-size:23px; font-weight:600; margin-bottom:2px;"></div>
                                  <div class="fw-bold" id="verifikasi-nama-peserta" style="font-size:30px;"></div>
                                </div>
                                <div class="mb-3">
                                  <div class="form-label mb-1" style="font-weight:500;">Pilih Hasil Verifikasi</div>
                                  <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="status_hasil" id="hasil-lulus" value="Lulus" required>
                                    <label class="btn btn-outline-success" for="hasil-lulus"><i class="mdi mdi-check"></i> Lulus</label>
                                    <input type="radio" class="btn-check" name="status_hasil" id="hasil-tidaklulus" value="Tidak Lulus" required>
                                    <label class="btn btn-outline-danger" for="hasil-tidaklulus"><i class="mdi mdi-close"></i> Tidak Lulus</label>
                                  </div>
                                  <div class="invalid-feedback">Pilih hasil kelulusan.</div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Simpan Hasil</button>
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
          </div>
          <!-- end table-responsive -->
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Modal Verifikasi Berkas
      document.querySelectorAll('.btn-verifikasi-berkas').forEach(function(btn) {
        btn.addEventListener('click', function() {
          var id = this.getAttribute('data-id');
          var nama = this.getAttribute('data-nama');
          var namaEl = document.getElementById('verifikasi-berkas-nama');
          var idPesertaEl = document.getElementById('verifikasi-berkas-id-peserta');
          var fileButtonsWrap = document.getElementById('verifikasi-berkas-file-buttons');
          var modalEl = document.getElementById('modalVerifikasiBerkas');
          if (!namaEl || !idPesertaEl || !fileButtonsWrap || !modalEl) {
            Swal.fire('Error', 'Elemen modal verifikasi berkas tidak ditemukan.', 'error');
            return;
          }
          namaEl.textContent = nama;
          idPesertaEl.value = id;
          fileButtonsWrap.innerHTML = '';

          // Daftar berkas
          var files = [{
              prefix: 'kk',
              label: 'KK'
            },
            {
              prefix: 'akte',
              label: 'Akte'
            },
            {
              prefix: 'ijazah',
              label: 'Ijazah'
            }
          ];

          // Untuk setiap berkas, cek status upload via API, lalu render tombol jika sudah upload atau form upload jika belum
          var berkasLoaded = 0;
          files.forEach(function(file) {
            fetch('<?= site_url('calon_siswa/get_berkas_files') ?>/' + id + '/' + file.prefix, {
                method: 'GET',
                headers: {
                  'X-Requested-With': 'XMLHttpRequest'
                }
              })
              .then(function(response) {
                return response.json();
              })
              .then(function(data) {
                var html = '';
                html += '<div class="col-12 mb-2">';

                if (data.success && data.file_url) {
                  // File exists, show view and tolak buttons
                  html += '<div class="d-flex flex-wrap gap-2 align-items-center">';
                  html += '<a id="btn-view-' + file.prefix + '" class="btn btn-outline-primary btn-sm flex-fill" target="_blank" href="' + data.file_url + '"><i class="mdi mdi-eye"></i> Lihat ' + file.label + '</a>';
                  html += '<button type="button" id="btn-upload-ulang-' + file.prefix + '" class="btn btn-warning btn-sm d-none"><i class="mdi mdi-upload"></i> Upload Ulang ' + file.label + '</button>';
                  html += '<button type="button" id="btn-tolak-' + file.prefix + '" class="btn btn-danger btn-sm"><i class="mdi mdi-close"></i> Tolak</button>';
                  html += '</div>';
                  html += '<div id="alasan-tolak-' + file.prefix + '-wrap" class="mt-2 d-none">';
                  html += '<input type="text" id="alasan-tolak-' + file.prefix + '" class="form-control" placeholder="Alasan penolakan ' + file.label + ' (wajib)">';
                  html += '</div>';
                } else {
                  // File doesn't exist, show upload form
                  html += '<div class="card upload-card">';
                  html += '<div class="card-header bg-light d-flex align-items-center">';
                  html += '<div class="upload-icon me-2"><i class="mdi mdi-file-document-outline text-primary"></i></div>';
                  html += '<h6 class="mb-0">' + file.label + ' belum diupload</h6>';
                  html += '</div>';
                  html += '<div class="card-body">';
                  html += '<form id="form-upload-' + file.prefix + '" class="upload-berkas-form">';
                  html += '<?= csrf_field() ?>';
                  html += '<div class="mb-2">';
                  html += '<label for="file-' + file.prefix + '" class="form-label small">Upload ' + file.label + ' (PDF/JPG/PNG, max 2MB)</label>';
                  html += '<input type="file" class="form-control form-control-sm" id="file-' + file.prefix + '" name="file" required accept=".pdf,.jpg,.jpeg,.png">';
                  html += '<input type="hidden" name="type" value="' + file.prefix + '">';
                  html += '</div>';
                  html += '<div id="upload-status-' + file.prefix + '" class="small"></div>';
                  html += '<div class="d-grid">';
                  html += '<button type="submit" class="btn btn-primary btn-sm"><i class="mdi mdi-upload me-1"></i> Upload ' + file.label + '</button>';
                  html += '</div>';
                  html += '</form>';
                  html += '</div>';
                  html += '</div>';
                }

                html += '</div>';
                fileButtonsWrap.insertAdjacentHTML('beforeend', html);

                // Set up event listeners for the newly added form
                if (!data.success || !data.file_url) {
                  setupUploadForm(file.prefix, id);
                }

                berkasLoaded++;
                // Setelah semua berkas dimuat, pasang event handler tombol tolak
                if (berkasLoaded === files.length) {
                  ['kk', 'akte', 'ijazah'].forEach(function(prefix) {
                    var btnTolak = document.getElementById('btn-tolak-' + prefix);
                    var alasanWrap = document.getElementById('alasan-tolak-' + prefix + '-wrap');
                    var alasanInput = document.getElementById('alasan-tolak-' + prefix);
                    if (btnTolak && alasanWrap && alasanInput) {
                      btnTolak.addEventListener('click', function() {
                        // Sembunyikan semua input alasan lain dulu
                        ['kk', 'akte', 'ijazah'].forEach(function(p) {
                          if (p !== prefix) {
                            var wrapLain = document.getElementById('alasan-tolak-' + p + '-wrap');
                            var inputLain = document.getElementById('alasan-tolak-' + p);
                            if (wrapLain && inputLain) {
                              wrapLain.classList.add('d-none');
                              inputLain.value = '';
                            }
                          }
                        });
                        alasanWrap.classList.remove('d-none');
                        alasanInput.focus();
                      });
                      alasanInput.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter') {
                          e.preventDefault();
                          submitTolakBerkas(prefix);
                        }
                      });
                      alasanInput.addEventListener('blur', function() {
                        if (alasanInput.value.trim() !== '') {
                          submitTolakBerkas(prefix);
                        } else {
                          alasanWrap.classList.add('d-none');
                        }
                      });
                    }
                  });
                }
              });
          });

          // Attach handler for btn-verifikasi-berkas-lulus every time modal dibuka (karena bisa hilang saat pagination)
          setTimeout(function() {
            var btnLulus = document.getElementById('btn-verifikasi-berkas-lulus');
            if (document.getElementById('modalVerifikasiBerkas') && btnLulus) {
              attachVerifikasiBerkasLulusHandler();
            }
          }, 100);
          // Cek ulang modalEl sebelum panggil Modal
          if (!modalEl) return;
          var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
          modal.show();
          modalEl.addEventListener('hidden.bs.modal', function handler() {
            fileButtonsWrap.innerHTML = '';
            modalEl.removeEventListener('hidden.bs.modal', handler);
          });
        });
      });

      function attachVerifikasiBerkasLulusHandler() {
        var btnLulus = document.getElementById('btn-verifikasi-berkas-lulus');
        if (!btnLulus || !btnLulus.parentNode) return;
        var newBtn = btnLulus.cloneNode(true);
        btnLulus.parentNode.replaceChild(newBtn, btnLulus);
        newBtn.addEventListener('click', function() {
          var idPeserta = document.getElementById('verifikasi-berkas-id-peserta');
          var modalEl = document.getElementById('modalVerifikasiBerkas');
          if (!idPeserta || !modalEl) return;
          idPeserta = idPeserta.value;
          Swal.fire({
            title: 'Verifikasi Berkas?',
            text: 'Pastikan semua berkas sudah benar dan lengkap.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Verifikasi',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#28a745'
          }).then(function(result) {
            if (result.isConfirmed) {
              fetch('<?= site_url('calon_siswa/verifikasi_berkas') ?>', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                  },
                  body: JSON.stringify({
                    id_peserta: idPeserta,
                    status: 'terverifikasi'
                  })
                })
                .then(response => response.json())
                .then(data => {
                  if (data.success) {
                    Swal.fire('Terverifikasi', 'Berkas berhasil diverifikasi.', 'success').then(() => window.location.reload());
                  } else {
                    Swal.fire('Gagal', data.message || 'Gagal verifikasi berkas.', 'error');
                  }
                })
                .catch(() => Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error'));
            }
          });
        });
      }
    });
  </script>

  <script>
    // Fungsi modal konfirmasi hapus
    document.addEventListener('DOMContentLoaded', function() {
      var modalEl = document.getElementById('modalKonfirmasiHapus');
      var modalInstance = null;
      // Gunakan instance yang sama, jangan buat baru setiap klik
      if (modalEl) {
        modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
      }
      document.querySelectorAll('.btn-delete-modal').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
          e.preventDefault();
          var idForm = this.getAttribute('data-idform');
          var nama = this.getAttribute('data-nama');
          document.getElementById('modalHapusNama').textContent = nama || '';
          document.getElementById('btn-modal-hapus-ya').setAttribute('data-idform', idForm);
          if (modalInstance) modalInstance.show();
        });
      });
      var btnHapus = document.getElementById('btn-modal-hapus-ya');
      if (btnHapus) {
        btnHapus.addEventListener('click', function() {
          var idForm = this.getAttribute('data-idform');
          if (idForm) {
            var form = document.getElementById(idForm);
            if (form) {
              // Sembunyikan modal sebelum submit agar backdrop hilang
              if (modalInstance) modalInstance.hide();
              setTimeout(function() {
                form.submit();
              }, 250);
            }
          }
        });
      }
      // Pastikan modal benar-benar tertutup saat klik batal/close
      if (modalEl) {
        modalEl.addEventListener('hidden.bs.modal', function() {
          document.getElementById('modalHapusNama').textContent = '';
          document.getElementById('btn-modal-hapus-ya').removeAttribute('data-idform');
          // Paksa hapus backdrop jika masih ada (antisipasi bug Bootstrap)
          var backdrops = document.querySelectorAll('.modal-backdrop');
          backdrops.forEach(function(bd) {
            bd.parentNode.removeChild(bd);
          });
          document.body.classList.remove('modal-open');
          document.body.style.overflow = '';
          document.body.style.paddingRight = '';
        });
      }
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Export Excel button functionality
      const btnExportExcel = document.getElementById('btn-export-excel');
      if (btnExportExcel) {
        btnExportExcel.addEventListener('click', function() {
          // Show loading indicator
          Swal.fire({
            title: 'Memproses Export',
            html: 'Sedang menyiapkan data untuk export.<br>Mohon tunggu...',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });

          // Redirect to export URL after a short delay to allow the loading indicator to show
          setTimeout(function() {
            window.location.href = '<?= site_url('calon_siswa/export_excel') ?>';

            // Close the loading indicator after 3 seconds (assuming the download has started)
            setTimeout(function() {
              Swal.close();
            }, 3000);
          }, 500);
        });
      }
    });
  </script>

  <script>
    function submitTolakBerkas(prefix) {
      var alasanInput = document.getElementById('alasan-tolak-' + prefix);
      var alasanWrap = document.getElementById('alasan-tolak-' + prefix + '-wrap');
      var idPeserta = document.getElementById('verifikasi-berkas-id-peserta');

      if (!alasanInput || !idPeserta) return;

      var alasan = alasanInput.value.trim();
      if (alasan === '') {
        Swal.fire('Error', 'Alasan penolakan harus diisi', 'error');
        return;
      }

      // Sembunyikan input alasan
      if (alasanWrap) alasanWrap.classList.add('d-none');

      // Kirim data penolakan ke server
      fetch('<?= site_url('calon_siswa/verifikasi_berkas') ?>', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
          },
          body: JSON.stringify({
            id_peserta: idPeserta.value,
            status: 'ditolak',
            prefix: prefix,
            alasan: alasan
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Swal.fire('Berhasil', 'Berkas ' + prefix.toUpperCase() + ' berhasil ditolak.', 'success');

            // Update UI untuk berkas yang ditolak
            var viewBtn = document.getElementById('btn-view-' + prefix);
            if (viewBtn) {
              viewBtn.classList.add('btn-outline-danger');
              viewBtn.classList.remove('btn-outline-primary');
            }
          } else {
            Swal.fire('Gagal', data.message || 'Gagal menolak berkas.', 'error');
          }
        })
        .catch(() => Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error'));
    }

    // Function to set up AJAX file upload form
    function setupUploadForm(filePrefix, idPeserta) {
      const form = document.getElementById('form-upload-' + filePrefix);
      if (!form) return;

      form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);
        const uploadStatus = document.getElementById('upload-status-' + filePrefix);

        // Show upload in progress
        uploadStatus.innerHTML = '<div class="alert alert-info"><i class="mdi mdi-loading mdi-spin me-2"></i>Sedang mengupload...</div>';

        fetch('<?= site_url('uploadberkas/upload_ajax/') ?>' + idPeserta, {
            method: 'POST',
            body: formData,
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              uploadStatus.innerHTML = '<div class="alert alert-success"><i class="mdi mdi-check-circle me-2"></i>' + data.message + '</div>';

              // Refresh the file buttons display after successful upload
              setTimeout(() => {
                refreshBerkasDisplay(idPeserta);
              }, 1000);
            } else {
              uploadStatus.innerHTML = '<div class="alert alert-danger"><i class="mdi mdi-alert-circle me-2"></i>' + (data.message || 'Gagal upload file') + '</div>';
            }
          })
          .catch(error => {
            console.error('Error:', error);
            uploadStatus.innerHTML = '<div class="alert alert-danger"><i class="mdi mdi-alert-circle me-2"></i>Terjadi kesalahan. Silakan coba lagi.</div>';
          });
      });
    }

    // Function to refresh the display of files in the modal after upload
    function refreshBerkasDisplay(idPeserta) {
      const fileButtonsWrap = document.getElementById('verifikasi-berkas-file-buttons');
      const idPesertaEl = document.getElementById('verifikasi-berkas-id-peserta');
      const namaEl = document.getElementById('verifikasi-berkas-nama');

      if (!fileButtonsWrap || !idPesertaEl || !namaEl) return;

      const nama = namaEl.textContent;

      // Clear current content
      fileButtonsWrap.innerHTML = '';

      // Simulate click on the verifikasi berkas button to reload content
      const modal = bootstrap.Modal.getInstance(document.getElementById('modalVerifikasiBerkas'));
      if (modal) {
        modal.hide();
        setTimeout(() => {
          // Find the corresponding button and click it to reload the modal
          document.querySelector('.btn-verifikasi-berkas[data-id="' + idPeserta + '"]').click();
        }, 500);
      }
    }
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Event listener for verifikasi hasil buttons
      document.querySelectorAll('.btn-verifikasi-hasil').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
          e.preventDefault();

          // Get data attributes
          var id = this.getAttribute('data-id');
          var nama = this.getAttribute('data-nama');
          var nokk = this.getAttribute('data-nokk') || '';
          var nik = this.getAttribute('data-nik') || '';
          var kk = this.getAttribute('data-kk') === '1';
          var akte = this.getAttribute('data-akte') === '1';
          var ijazah = this.getAttribute('data-ijazah') === '1';

          // Check if all required data is available
          var dataBelumLengkap = [];
          if (!nokk || nokk.length < 10) dataBelumLengkap.push('Nomor KK');
          if (!nik || nik.length < 10) dataBelumLengkap.push('NIK');
          if (!kk) dataBelumLengkap.push('Berkas KK');
          if (!akte) dataBelumLengkap.push('Berkas Akte Kelahiran');
          if (!ijazah) dataBelumLengkap.push('Berkas Ijazah');

          // If data is incomplete, show warning modal
          if (dataBelumLengkap.length > 0) {
            var modalBelumLengkap = document.getElementById('modalInfoBelumLengkap');
            var detailElement = document.getElementById('info-belum-lengkap-detail');

            if (modalBelumLengkap && detailElement) {
              // Populate the details into the existing element
              detailElement.innerHTML = `
                <p>Berikut data/berkas yang belum lengkap:</p>
                <ul>
                  ${dataBelumLengkap.map(item => `<li>${item}</li>`).join('')}
                </ul>
                <p>Silakan lengkapi terlebih dahulu sebelum melakukan verifikasi.</p>
              `;

              var modalInstance = bootstrap.Modal.getOrCreateInstance(modalBelumLengkap);
              modalInstance.show();
            } else {
              Swal.fire('Perhatian', 'Data/berkas belum lengkap: ' + dataBelumLengkap.join(', '), 'warning');
            }
            return;
          }

          // All data is available, show verifikasi hasil modal
          var modal = document.getElementById('modalVerifikasiHasil');
          if (!modal) {
            Swal.fire('Error', 'Modal verifikasi hasil tidak ditemukan.', 'error');
            return;
          }

          // Set values in the modal
          var idPesertaInput = document.getElementById('verifikasi-id-peserta');
          var namaPesertaElement = document.getElementById('verifikasi-nama-peserta');

          if (idPesertaInput) idPesertaInput.value = id;
          if (namaPesertaElement) namaPesertaElement.textContent = nama;

          // Reset radio buttons
          document.getElementById('hasil-lulus').checked = false;
          document.getElementById('hasil-tidaklulus').checked = false;

          // Show the modal
          var modalInstance = bootstrap.Modal.getOrCreateInstance(modal);
          modalInstance.show();
        });
      });
    });
  </script>

  <script>
    // Form validation for verifikasi hasil
    document.addEventListener('DOMContentLoaded', function() {
      var formVerifikasiHasil = document.getElementById('form-verifikasi-hasil');
      if (formVerifikasiHasil) {
        formVerifikasiHasil.addEventListener('submit', function(e) {
          var hasilLulus = document.getElementById('hasil-lulus').checked;
          var hasilTidakLulus = document.getElementById('hasil-tidaklulus').checked;

          if (!hasilLulus && !hasilTidakLulus) {
            e.preventDefault();
            var feedbackElement = document.querySelector('.invalid-feedback');
            if (feedbackElement) {
              feedbackElement.style.display = 'block';
            } else {
              Swal.fire('Perhatian', 'Silakan pilih hasil kelulusan terlebih dahulu.', 'warning');
            }
          }
        });
      }
    });
  </script>

  <a href="<?= site_url('calon_siswa/koreksi_verifikasi') ?>" class="btn btn-sm btn-primary waves-effect waves-light bg-gradient" onclick="return confirm('Koreksi verifikasi akan memeriksa semua data siswa yang terverifikasi tapi belum upload berkas. Lanjutkan?')">
    <i class="fas fa-check-double"></i> Koreksi Verifikasi
  </a>

  <script>
    // Initialize file input listeners for the berkas upload forms
    document.addEventListener('DOMContentLoaded', function() {
      // Add file input change listeners for each upload form in the modal
      document.querySelectorAll('.file-upload').forEach(function(input) {
        input.addEventListener('change', function() {
          const fileName = this.value.split('\\').pop();
          const fileNameDisplay = this.closest('form').querySelector('.file-name');
          if (fileNameDisplay) {
            fileNameDisplay.textContent = fileName || '';
          }

          // Get form parent
          const form = this.closest('form');
          const formId = form.id;
          const fileType = form.querySelector('input[name="type"]').value;
          const idPeserta = document.getElementById('verifikasi-berkas-id-peserta').value;
          const uploadStatus = document.getElementById('upload-status');

          // Show upload in progress
          uploadStatus.innerHTML = '<div class="alert alert-info"><i class="mdi mdi-loading mdi-spin me-2"></i>Sedang mengupload ' + fileType.toUpperCase() + '...</div>';

          // Create FormData object
          const formData = new FormData(form);

          // Send AJAX request
          fetch('<?= site_url('uploadberkas/upload_ajax/') ?>' + idPeserta, {
              method: 'POST',
              body: formData,
              headers: {
                'X-Requested-With': 'XMLHttpRequest'
              }
            })
            .then(response => response.text())
            .then(data => {
              try {
                // Try to parse as JSON first
                const jsonData = JSON.parse(data);
                if (jsonData.success) {
                  uploadStatus.innerHTML = '<div class="alert alert-success"><i class="mdi mdi-check-circle me-2"></i>' + jsonData.message + '</div>';

                  // Refresh the file buttons display
                  refreshBerkasDisplay(idPeserta);
                } else {
                  uploadStatus.innerHTML = '<div class="alert alert-danger"><i class="mdi mdi-alert-circle me-2"></i>' + (jsonData.message || 'Gagal upload file') + '</div>';
                }
              } catch (e) {
                // If not valid JSON, check if contains success message
                if (data.includes('berhasil diupload')) {
                  uploadStatus.innerHTML = '<div class="alert alert-success"><i class="mdi mdi-check-circle me-2"></i>Berkas berhasil diupload</div>';

                  // Refresh the file buttons display
                  refreshBerkasDisplay(idPeserta);
                } else if (data.includes('error')) {
                  uploadStatus.innerHTML = '<div class="alert alert-danger"><i class="mdi mdi-alert-circle me-2"></i>Gagal upload file</div>';
                } else {
                  // Full page response received, likely a redirect - success case
                  uploadStatus.innerHTML = '<div class="alert alert-success"><i class="mdi mdi-check-circle me-2"></i>Berkas berhasil diupload</div>';

                  // Refresh the file buttons display
                  refreshBerkasDisplay(idPeserta);
                }
              }
            })
            .catch(error => {
              console.error('Error:', error);
              uploadStatus.innerHTML = '<div class="alert alert-danger"><i class="mdi mdi-alert-circle me-2"></i>Terjadi kesalahan: ' + error.message + '</div>';
            });
        });
      });
    });

    // Function to refresh the display of files after an upload
    function refreshBerkasDisplay(idPeserta) {
      const fileButtonsWrap = document.getElementById('verifikasi-berkas-file-buttons');
      if (!fileButtonsWrap) return;

      // Clear existing buttons
      fileButtonsWrap.innerHTML = '';

      // Daftar berkas
      const files = [{
          prefix: 'kk',
          label: 'KK'
        },
        {
          prefix: 'akte',
          label: 'Akte'
        },
        {
          prefix: 'ijazah',
          label: 'Ijazah'
        }
      ];

      // Untuk setiap berkas, cek status upload via API, lalu render tombol jika sudah upload
      let berkasLoaded = 0;
      files.forEach(function(file) {
        fetch('<?= site_url('calon_siswa/get_berkas_files') ?>/' + idPeserta + '/' + file.prefix, {
            method: 'GET',
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success && data.file_url) {
              var html = '';
              html += '<div class="col-12 mb-2">';
              html += '<div class="d-flex flex-wrap gap-2 align-items-center">';
              html += '<a id="btn-view-' + file.prefix + '" class="btn btn-outline-primary btn-sm flex-fill" target="_blank" href="' + data.file_url + '"><i class="mdi mdi-eye"></i> Lihat ' + file.label + '</a>';
              html += '<button type="button" id="btn-tolak-' + file.prefix + '" class="btn btn-danger btn-sm"><i class="mdi mdi-close"></i> Tolak</button>';
              html += '</div>';
              html += '<div id="alasan-tolak-' + file.prefix + '-wrap" class="mt-2 d-none">';
              html += '<input type="text" id="alasan-tolak-' + file.prefix + '" class="form-control" placeholder="Alasan penolakan ' + file.label + ' (wajib)">';
              html += '</div>';
              html += '</div>';
              fileButtonsWrap.insertAdjacentHTML('beforeend', html);
            }

            berkasLoaded++;
            // Setelah semua berkas dimuat, pasang event handler tombol tolak
            if (berkasLoaded === files.length) {
              ['kk', 'akte', 'ijazah'].forEach(function(prefix) {
                var btnTolak = document.getElementById('btn-tolak-' + prefix);
                var alasanWrap = document.getElementById('alasan-tolak-' + prefix + '-wrap');
                var alasanInput = document.getElementById('alasan-tolak-' + prefix);

                if (btnTolak && alasanWrap && alasanInput) {
                  btnTolak.addEventListener('click', function() {
                    // Sembunyikan semua input alasan lain dulu
                    ['kk', 'akte', 'ijazah'].forEach(function(p) {
                      if (p !== prefix) {
                        var wrapLain = document.getElementById('alasan-tolak-' + p + '-wrap');
                        var inputLain = document.getElementById('alasan-tolak-' + p);
                        if (wrapLain && inputLain) {
                          wrapLain.classList.add('d-none');
                          inputLain.value = '';
                        }
                      }
                    });
                    alasanWrap.classList.remove('d-none');
                    alasanInput.focus();
                  });

                  alasanInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                      e.preventDefault();
                      submitTolakBerkas(prefix);
                    }
                  });

                  alasanInput.addEventListener('blur', function() {
                    if (alasanInput.value.trim() !== '') {
                      submitTolakBerkas(prefix);
                    } else {
                      alasanWrap.classList.add('d-none');
                    }
                  });
                }
              });
            }
          });
      });
    }
  </script>

  <?= $this->endSection() ?>