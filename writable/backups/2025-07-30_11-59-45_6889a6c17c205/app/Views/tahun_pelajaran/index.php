<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>View Data Mata Pelajaran &mdash; SDN Krengseng 02</title>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Data Tahun Ajaran</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?= site_url('home') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Tahun Ajaran</li>
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
                        <div class="row mb-1">
                            <div class="col-xs-6 col-md-6">
                                <h4 class="alert-heading">Data Tahun Pelajaran</h4>
                            </div>
                            <!-- Right column with 4 buttons -->
                            <div class="col-xs-6 col-md-6 text-end">
                                <a href="#" class="btn btn-sm btn-primary waves-effect waves-light bg-gradient" data-bs-toggle="modal" data-bs-target="#modal-tambah-tapel">
                                    <i class="far fa-calendar-check"></i> Tambah
                                </a>
                            </div>
                        </div>
                        <table id="scroll-horizontal" class="table table-bordered dt-responsive  nowrap w-100" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th class="align-middle">No</th>
                                    <th>Tahun</th>
                                    <th>Keterangan Tahun</th>
                                    <th>Semester</th>
                                    <th>Status</th>
                                    <th>Pimpinan</th>
                                    <th>NIP</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($tapel as $key => $value) : ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $value->tahun ?></td>
                                        <td><?= $value->ket_tahun ?></td>
                                        <td><?= isset($value->semester) ? $value->semester : '-' ?></td>
                                        <td><?php if ($value->status == 'Aktif') : ?>
                                                <span class="badge bg-primary">Aktif</span>
                                            <?php else : ?>
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $value->nama ?></td>
                                        <td><?= $value->nip ?></td>
                                        <td>
                                            <?php if (!empty($value->id_tahun_ajaran)): ?>
                                                <a class="btn btn-sm btn-success btn-animation waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-edit-matpel-<?= $value->id_tahun_ajaran ?>"><i class='fas fa-sliders-h'></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <!-- Modal Edit -->
                                    <?php if (!empty($value->id_tahun_ajaran)): ?>
                                        <div class="modal fade" id="modal-edit-matpel-<?= $value->id_tahun_ajaran ?>" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modal-edit-matpel">Edit Mata Pelajaran</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="<?= site_url('tahun_pelajaran/' . $value->id_tahun_ajaran) ?>" method="post">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="_method" value="PUT">
                                                            <div class="row g-4">
                                                                <div class="col-xxl-12">
                                                                    <div>
                                                                        <label class="form-label">Tahun</label>
                                                                        <input type="text" class="form-control" name="tahun" value="<?= $value->tahun ?>">
                                                                    </div>
                                                                </div><!--end col-->
                                                                <div class="col-xxl-12">
                                                                    <div>
                                                                        <label class="form-label">Tahun Ajaran</label>
                                                                        <input type="text" class="form-control" name="ket_tahun" value="<?= $value->ket_tahun ?>">
                                                                    </div>
                                                                </div><!--end col-->
                                                                <div class="col-xxl-12">
                                                                    <div>
                                                                        <label class="form-label">Semester</label>
                                                                        <select class="form-select" name="semester">
                                                                            <option value="">-- Pilih Semester --</option>
                                                                            <option value="Ganjil" <?= (isset($value->semester) && $value->semester == 'Ganjil') ? 'selected' : '' ?>>Ganjil</option>
                                                                            <option value="Genap" <?= (isset($value->semester) && $value->semester == 'Genap') ? 'selected' : '' ?>>Genap</option>
                                                                        </select>
                                                                    </div>
                                                                </div><!--end col-->
                                                                <div class="col-xxl-12">
                                                                    <div>
                                                                        <label class="form-label">Kepala Sekolah</label>
                                                                        <select class="form-select" name="id_kepalasekolah">
                                                                            <?php foreach ($kepala as $k => $kep): ?>
                                                                                <option value="<?= $kep->id_kepalasekolah ?>" <?= ($kep->id_kepalasekolah == $value->id_kepalasekolah) ? 'selected' : '' ?>> <?= $kep->nama ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div><!--end col-->
                                                                <div class="col-xxl-12">
                                                                    <div>
                                                                        <label class="form-label">Status</label>
                                                                        <select class="form-select" name="status" required>
                                                                            <option value="Aktif" <?= ($value->status == 'Aktif') ? 'selected' : '' ?>>Aktif</option>
                                                                            <option value="Tidak Aktif" <?= ($value->status == 'Tidak Aktif') ? 'selected' : '' ?>>Tidak Aktif</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="hstack gap-2 justify-content-end">
                                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                                    </div>
                                                                </div><!--end col-->
                                                            </div><!--end row-->
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container-fluid -->
</div>

<!-- Grids in modals -->
<div class="modal fade" id="modal-tambah-tapel" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-tambah-tapel">Tambah Tahun Pelajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <?= csrf_field() ?>
                    <div class="row mb-4">
                        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Tahun</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="tahun" placeholder="Tahun ">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-email-input" class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="ket_tahun" placeholder="2022/2023">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-semester-input" class="col-sm-3 col-form-label">Semester</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="semester" id="horizontal-semester-input">
                                <option value="">-- Pilih Semester --</option>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-password-input" name="status" class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="status" id="horizontal-status-input" required>
                                <option value=""> --Pilih--</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div><!--end col-->
            </div>
            </form>
        </div>
    </div>
</div>
</div>
<?= $this->endSection() ?>