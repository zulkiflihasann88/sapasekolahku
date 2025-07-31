<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Anggota Rombel &mdash; SDN Krengseng 02</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-content">
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-white border-0 p-4 d-flex align-items-center justify-content-between">
            <div>
                <h5 class="card-title mb-1 fw-bold text-dark">
                    <i class="bx bx-group text-primary fs-5 me-2"></i>Anggota Rombel: <span class="text-primary"><?= htmlspecialchars($nama_rombel) ?></span>
                </h5>
            </div>
            <div>
                <a href="<?= site_url('wali_kelas/cetak_absen/' . urlencode($nama_rombel)) ?>" target="_blank" class="btn btn-outline-primary btn-sm me-2"><i class="bx bx-printer me-1"></i>Cetak Daftar Hadir</a>
                <a href="<?= site_url('wali_kelas/export_absen_pdf/' . urlencode($nama_rombel)) ?>" target="_blank" class="btn btn-danger btn-sm me-2"><i class="bx bx-file me-1"></i>Export PDF</a>
                <a href="<?= site_url('wali_kelas') ?>" class="btn btn-light btn-sm"><i class="bx bx-arrow-back me-1"></i>Kembali</a>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0" id="anggotaTable">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="50">No</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Jenis Kelamin</th>
                            <th>Kelas</th>
                            <th>Rombel</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($anggota)) : $no = 1;
                            foreach ($anggota as $siswa) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($siswa->nisn) ?></td>
                                    <td><?= htmlspecialchars($siswa->nama_siswa) ?></td>
                                    <td><?= htmlspecialchars($siswa->jk) ?></td>
                                    <td><?= htmlspecialchars($siswa->kelas) ?></td>
                                    <td><?= htmlspecialchars($siswa->rombel) ?></td>
                                </tr>
                            <?php endforeach;
                        else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tidak ada anggota rombel.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#anggotaTable').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data',
                zeroRecords: 'Tidak ditemukan data yang sesuai',
                paginate: {
                    first: '<<',
                    last: '>>',
                    next: '>',
                    previous: '<'
                }
            }
        });
    });
</script>
<?= $this->endSection() ?>