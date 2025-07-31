<?= $this->extend('layout/default') ?>
<?= $this->section('title') ?>
<title>Data Alumni &mdash; SDN Krengseng 02</title>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Data Alumni</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Filter Tahun Lulus -->
                        <form method="get" class="mb-3" id="filter-tahun-form">
                            <div class="row align-items-end">
                                <div class="col-md-4">
                                    <label for="tahun_lulus" class="form-label">Filter Tahun Lulus</label> <select name="tahun_lulus" id="tahun_lulus" class="form-select">
                                        <option value="">Semua Tahun</option>
                                        <?php
                                        // Gunakan data tahun dari database terlebih dahulu
                                        $tahunList = [];
                                        if (isset($tahun_lulus_list) && is_array($tahun_lulus_list)) {
                                            $tahunList = $tahun_lulus_list;
                                        }

                                        // Jika tidak ada data dari database, gunakan generator manual
                                        if (empty($tahunList)) {
                                            $currentYear = (int)date('Y');
                                            for ($i = 0; $i < 11; $i++) {
                                                $tahun = $currentYear - $i;
                                                $tahunList[] = $tahun;
                                            }
                                        }

                                        // Urutkan tahun secara descending
                                        rsort($tahunList);

                                        foreach ($tahunList as $tahun) {
                                            $selected = (isset($_GET['tahun_lulus']) && $_GET['tahun_lulus'] == $tahun) ? 'selected' : '';
                                            echo "<option value=\"$tahun\" $selected>$tahun</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="alumni-table" class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NISN</th>
                                        <th>NIS</th>
                                        <th>JK</th>
                                        <th>Tempat, Tanggal Lahir</th>
                                        <th>Tanggal Lulus</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($alumni)): ?>
                                        <?php foreach ($alumni as $i => $row): ?>
                                            <tr>
                                                <td><?= $i + 1 ?></td>
                                                <td><?= esc($row->nama_siswa) ?></td>
                                                <td><?= esc($row->nisn) ?></td>
                                                <td><?= esc($row->nis) ?></td>
                                                <td><?= esc($row->jk) ?></td>
                                                <td><?= esc($row->tempat_lahir) ?>, <?= date('d-m-Y', strtotime($row->tanggal_lahir)) ?></td>
                                                <td><?= isset($row->tanggal_mutasi) ? date('d-m-Y', strtotime($row->tanggal_mutasi)) : '-' ?></td>
                                                <td>
                                                    <a href="<?= site_url('alumni/detail/' . $row->id_siswa) ?>" class="btn btn-info btn-sm">Detail</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data alumni.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                if (window.jQuery && $.fn.DataTable) {
                                    $('#alumni-table').DataTable({
                                        paging: true,
                                        searching: true,
                                        info: true,
                                        ordering: true,
                                        lengthChange: true,
                                        pageLength: 10,
                                        language: {
                                            emptyTable: 'Tidak ada data alumni',
                                            zeroRecords: 'Tidak ditemukan',
                                            info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ alumni',
                                            infoEmpty: 'Menampilkan 0 sampai 0 dari 0 alumni',
                                            paginate: {
                                                previous: 'Sebelumnya',
                                                next: 'Berikutnya'
                                            },
                                            search: 'Cari:'
                                        },
                                        columnDefs: [{
                                            orderable: false,
                                            targets: 0
                                        }]
                                    });
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>