<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Manajemen Semester &mdash; Aplikasi Sekolah</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-sm-0 font-size-18">
                            <i class="mdi mdi-calendar-clock me-2 text-primary"></i>
                            Manajemen Semester
                        </h4>
                        <p class="text-muted mb-0">Kelola perpindahan semester dan backup data historis</p>
                    </div>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manajemen Semester</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Semester Info -->
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="mdi mdi-calendar-today me-2"></i>
                            Status Semester Aktif
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if ($current_semester): ?>
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="text-primary mb-2">Semester Sedang Berjalan</h6>
                                    <p class="mb-1"><strong>Tahun Ajaran:</strong>
                                        <?php
                                        $tahun_info = null;
                                        foreach ($tahun_ajaran as $ta) {
                                            if ($ta->id_tahun_ajaran == $current_semester->id_tahun_ajaran) {
                                                $tahun_info = $ta;
                                                break;
                                            }
                                        }
                                        echo $tahun_info ? $tahun_info->ket_tahun : 'Tidak ditemukan';
                                        ?>
                                    </p>
                                    <p class="mb-1"><strong>Semester:</strong> <?= $current_semester->semester == '1' ? 'Ganjil (1)' : 'Genap (2)' ?></p>
                                    <p class="mb-1"><strong>Periode:</strong> <?= date('d/m/Y', strtotime($current_semester->tanggal_mulai)) ?> - <?= date('d/m/Y', strtotime($current_semester->tanggal_selesai)) ?></p>
                                    <?php if ($current_semester->keterangan): ?>
                                        <p class="mb-0"><strong>Keterangan:</strong> <?= $current_semester->keterangan ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-4 text-end">
                                    <span class="badge bg-success font-size-12 px-3 py-2">
                                        <i class="mdi mdi-check-circle me-1"></i>AKTIF
                                    </span>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning" role="alert">
                                <i class="mdi mdi-alert-circle me-2"></i>
                                Belum ada semester yang aktif. Silakan aktifkan semester terlebih dahulu.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="mdi mdi-cog-outline me-2"></i>
                            Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="<?= base_url('semester-management/change-form') ?>" class="btn btn-primary btn-sm">
                                <i class="mdi mdi-swap-horizontal me-2"></i>
                                Pindah Semester
                            </a>
                            <button type="button" class="btn btn-info btn-sm" onclick="manualBackup()">
                                <i class="mdi mdi-backup-restore me-2"></i>
                                Backup Manual
                            </button>
                            <a href="<?= base_url('semester-management/naik-kelas-form') ?>" class="btn btn-success btn-sm">
                                <i class="mdi mdi-account-group me-2"></i>
                                Naik Kelas Otomatis
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- History Semester -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="mdi mdi-history me-2"></i>
                            Riwayat Semester
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Tahun Ajaran</th>
                                        <th>Semester</th>
                                        <th>Periode</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($available_semesters)): ?>
                                        <?php foreach ($available_semesters as $semester): ?>
                                            <tr>
                                                <td><?= $semester->ket_tahun ?></td>
                                                <td>
                                                    <span class="badge bg-<?= $semester->semester == '1' ? 'primary' : 'secondary' ?>">
                                                        <?= $semester->semester == '1' ? 'Ganjil (1)' : 'Genap (2)' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?= date('d/m/Y', strtotime($semester->tanggal_mulai)) ?> -
                                                    <?= date('d/m/Y', strtotime($semester->tanggal_selesai)) ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?= $semester->status == 'aktif' ? 'success' : 'secondary' ?>">
                                                        <?= strtoupper($semester->status) ?>
                                                    </span>
                                                </td>
                                                <td><?= $semester->keterangan ?: '-' ?></td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="<?= base_url('semester-management/history/' . $semester->id_tahun_ajaran . '/' . $semester->semester) ?>"
                                                            class="btn btn-outline-primary" title="Lihat History">
                                                            <i class="mdi mdi-eye"></i>
                                                        </a>
                                                        <a href="<?= base_url('semester-management/export/' . $semester->id_tahun_ajaran . '/' . $semester->semester) ?>"
                                                            class="btn btn-outline-success" title="Export Laporan">
                                                            <i class="mdi mdi-download"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                <i class="mdi mdi-information-outline me-2"></i>
                                                Belum ada data riwayat semester
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Sistem -->
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    <h6 class="alert-heading">
                        <i class="mdi mdi-information me-2"></i>
                        Informasi Penting
                    </h6>
                    <ul class="mb-0">
                        <li><strong>Backup Otomatis:</strong> Sistem akan otomatis mem-backup data sebelum pindah semester</li>
                        <li><strong>Data Historis:</strong> Semua data semester sebelumnya akan tersimpan dan dapat diakses kapan saja</li>
                        <li><strong>Naik Kelas:</strong> Fitur naik kelas otomatis akan memindahkan siswa ke tingkat yang lebih tinggi</li>
                        <li><strong>Keamanan Data:</strong> Semua perubahan menggunakan sistem transaksi untuk menjamin integritas data</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function manualBackup() {
        if (confirm('Apakah Anda yakin ingin mem-backup data semester saat ini?')) {
            // Show loading
            Swal.fire({
                title: 'Memproses...',
                text: 'Sedang mem-backup data semester',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading()
                }
            });

            // Ajax request
            fetch('<?= base_url('semester-management/manual-backup') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        Swal.fire('Berhasil!', data.message, 'success');
                    } else {
                        Swal.fire('Gagal!', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.close();
                    Swal.fire('Error!', 'Terjadi kesalahan sistem', 'error');
                });
        }
    }
</script>

<?= $this->endSection() ?>