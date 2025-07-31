<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>View Data Rombongan Belajar &mdash; SDN Krengseng 02</title>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Data Rombongan Belajar</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Rombongan Belajar</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

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
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Daftar Rombongan Belajar</h5>
                            <button class="btn btn-sm btn-success waves-effect btn-label waves-light" data-bs-toggle="modal" data-bs-target="#modal-tambah-rombel">
                                <i class="bx bx-plus label-icon"></i> Tambah
                            </button>
                        </div>
                        <table id="scroll-horizontal" class="table table-bordered dt-responsive nowrap w-100">
                            <thead class="table-light">
                                <tr>
                                    <th class="align-middle">No</th>
                                    <th>Kelas</th>
                                    <th>Siswa</th>
                                    <th>Wali Kelas</th>
                                    <th>Rombel</th>
                                    <th>Tahun</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rombel as $key => $value) : ?>
                                    <tr>
                                        <td class="align-middle text-center"><?= $key + 1 ?></td>
                                        <td class="align-middle">
                                            <?php
                                            if ($value->kelas == 1) echo 'Kelas 1';
                                            else if ($value->kelas == 2) echo 'Kelas 2';
                                            else if ($value->kelas == 3) echo 'Kelas 3';
                                            else if ($value->kelas == 4) echo 'Kelas 4';
                                            else if ($value->kelas == 5) echo 'Kelas 5';
                                            else if ($value->kelas == 6) echo 'Kelas 6';
                                            else if ($value->kelas) echo 'Kelas ' . $value->kelas;
                                            else echo 'None';
                                            ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php
                                            // Hitung jumlah siswa aktif (tidak mutasi) di kelas ini
                                            $jumlah_aktif = 0;
                                            if (isset($siswa_per_kelas[$value->id_rombel]) && is_array($siswa_per_kelas[$value->id_rombel])) {
                                                $jumlah_aktif = count($siswa_per_kelas[$value->id_rombel]);
                                            }
                                            echo $jumlah_aktif . ' siswa';
                                            ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php
                                            // Tampilkan nama wali kelas, bukan id/angka
                                            $nama_wali = 'None';
                                            if (isset($pendidik) && is_array($pendidik) && !empty($value->wali_kelas)) {
                                                foreach ($pendidik as $p) {
                                                    if ($p->id_pendidik == $value->wali_kelas) {
                                                        $nama_wali = $p->nama;
                                                        break;
                                                    }
                                                }
                                            }
                                            echo $nama_wali;
                                            ?>
                                        </td>
                                        <td class="align-middle"><?= $value->rombel ?: 'None' ?></td>
                                        <td class="align-middle"><?= $value->ket_tahun ?: 'None' ?></td>
                                        <td class="align-middle text-center">
                                            <button class="btn btn-sm btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-edit-rombel-<?= $value->id_rombel ?>">
                                                <i class="mdi mdi-pencil"></i>
                                            </button>
                                            <!-- Tombol Lihat Siswa -->
                                            <button class="btn btn-sm btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-siswa-rombel-<?= $value->id_rombel ?>">
                                                <i class="mdi mdi-account-group"></i>
                                            </button>
                                            <form action="<?= site_url('rombongan_belajar/' . $value->id_rombel) ?>" method="post" class="d-inline">
                                                <!-- Modal Lihat Siswa per Kelas -->
                                                <div class="modal fade" id="modal-siswa-rombel-<?= $value->id_rombel ?>" tabindex="-1" aria-labelledby="modalSiswaLabel<?= $value->id_rombel ?>" aria-modal="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalSiswaLabel<?= $value->id_rombel ?>">Daftar Siswa Kelas <?= $value->kelas ?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-2">
                                                                    <strong>Wali Kelas:</strong>
                                                                    <?php
                                                                    $nama_wali = '-';
                                                                    if (isset($pendidik) && is_array($pendidik) && !empty($rekap_per_kelas[$value->id_rombel]['wali_kelas'])) {
                                                                        foreach ($pendidik as $p) {
                                                                            if ($p->id_pendidik == $rekap_per_kelas[$value->id_rombel]['wali_kelas']) {
                                                                                $nama_wali = $p->nama;
                                                                                break;
                                                                            }
                                                                        }
                                                                    }
                                                                    echo esc($nama_wali);
                                                                    ?>
                                                                </div>
                                                                <?php if (!empty($siswa_per_kelas[$value->id_rombel])): ?>
                                                                    <div class="table-responsive" style="max-height:400px; overflow-y:auto;">
                                                                        <table class="table table-bordered table-striped mb-0">
                                                                            <thead class="table-light" style="position:sticky;top:0;z-index:1;">
                                                                                <tr>
                                                                                    <th style="width:40px;">No</th>
                                                                                    <th>Nama</th>
                                                                                    <th>NISN</th>
                                                                                    <th>NIS</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php foreach ($siswa_per_kelas[$value->id_rombel] as $i => $siswa): ?>
                                                                                    <tr>
                                                                                        <td><?= $i + 1 ?></td>
                                                                                        <td><?= esc($siswa->nama_siswa) ?></td>
                                                                                        <td><?= esc($siswa->nisn) ?></td>
                                                                                        <td><?= esc($siswa->nis) ?></td>
                                                                                    </tr>
                                                                                <?php endforeach; ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="mt-2">
                                                                        <span class="badge bg-primary">Laki-laki: <?= $rekap_per_kelas[$value->id_rombel]['laki'] ?></span>
                                                                        <span class="badge bg-pink">Perempuan: <?= $rekap_per_kelas[$value->id_rombel]['perempuan'] ?></span>
                                                                        <span class="badge bg-success">Total: <?= $rekap_per_kelas[$value->id_rombel]['total'] ?></span>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <p>Tidak ada siswa di kelas ini.</p>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="btn btn-sm btn-danger waves-effect waves-light" data-confirm="Hapus Data?|Apakah Anda yakin?" data-confirm-yes="submitDel(<?= $value->id_rombel ?>)">
                                                    <i class="mdi mdi-trash-can-outline"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="modal-edit-rombel-<?= $value->id_rombel ?>" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Rombongan Belajar</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="<?= site_url('rombongan_belajar/' . $value->id_rombel) ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="_method" value="PUT">
                                                        <div class="mb-3">
                                                            <label for="select-kelas-tingkat" class="form-label">Kelas/Tingkat</label>
                                                            <select id="select-kelas-tingkat" class="form-control" name="kelas_tingkat">
                                                                <option value="">Pilih Kelas</option>
                                                                <?php for ($i = 1; $i <= 6; $i++): ?>
                                                                    <option value="<?= $i ?>" <?= (isset($value->kelas) && $value->kelas == 'Kelas ' . $i) ? 'selected' : '' ?>>Kelas <?= $i ?></option>
                                                                <?php endfor; ?>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="select-rombel" class="form-label">Rombel</label>
                                                            <input type="text" class="form-control" name="rombel" value="<?= isset($value->rombel) ? esc($value->rombel) : '' ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="select-tahun" class="form-label">Tahun Pelajaran</label>
                                                            <select id="select-tahun" class="form-control" name="id_tahun">
                                                                <option value="">Pilih Tahun</option>
                                                                <?php if (isset($tapel) && is_array($tapel)): ?>
                                                                    <?php foreach ($tapel as $t): ?>
                                                                        <?php if (isset($t->id_tahunajaran) && isset($t->ket_tahun)): ?>
                                                                            <option value="<?= $t->id_tahunajaran ?>" <?= (isset($value->id_tahun) && $value->id_tahun == $t->id_tahunajaran) ? 'selected' : '' ?>><?= $t->ket_tahun ?></option>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="select-wali" class="form-label">Wali Kelas</label>
                                                            <select id="select-wali" class="form-control" name="wali_kelas">
                                                                <option value="">Pilih Wali Kelas</option>
                                                                <?php if (isset($pendidik) && is_array($pendidik)): ?>
                                                                    <?php foreach ($pendidik as $p): ?>
                                                                        <option value="<?= $p->id_pendidik ?>" <?= (isset($value->wali_kelas) && $value->wali_kelas == $p->id_pendidik) ? 'selected' : '' ?>><?= $p->nama ?></option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                        <div class="text-end modal-footer">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Grids in modals -->
<div class="modal fade" id="modal-tambah-rombel" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-tambah-rombel">Tambah Rombongan Belajar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="select-kelas-tingkat" class="form-label">Kelas/Tingkat</label>
                        <select id="select-kelas-tingkat" class="form-control" name="kelas_tingkat">
                            <option value="">Pilih Kelas</option>
                            <option value="1">Kelas 1</option>
                            <option value="2">Kelas 2</option>
                            <option value="3">Kelas 3</option>
                            <option value="4">Kelas 4</option>
                            <option value="5">Kelas 5</option>
                            <option value="6">Kelas 6</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="select-rombel" class="form-label">Rombel</label>
                        <select id="select-rombel" class="form-control" name="rombel">
                            <option value="">Pilih Rombel</option>
                            <?php foreach ($rombel as $k) : ?>
                                <option value="<?= $k->id_rombel ?>"><?= $k->kelas ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="select-tahun" class="form-label">Tahun Pelajaran</label>
                        <select id="select-tahun" class="form-control" name="id_tahun">
                            <option value="">Pilih Tahun</option>
                            <?php if (isset($tapel) && is_array($tapel)): ?>
                                <?php foreach ($tapel as $t): ?>
                                    <?php if (isset($t->id_tahunajaran) && isset($t->ket_tahun)): ?>
                                        <option value="<?= $t->id_tahunajaran ?>"><?= $t->ket_tahun ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="select-wali" class="form-label">Wali Kelas</label>
                        <select id="select-wali" class="form-control" name="wali_kelas">
                            <option value="">Pilih Wali Kelas</option>
                            <?php if (isset($pendidik) && is_array($pendidik)): ?>
                                <?php foreach ($pendidik as $p): ?>
                                    <option value="<?= $p->id_pendidik ?>"><?= $p->nama ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="text-end modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>