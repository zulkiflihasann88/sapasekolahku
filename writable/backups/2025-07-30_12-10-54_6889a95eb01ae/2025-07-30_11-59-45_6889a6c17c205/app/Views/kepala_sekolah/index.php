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
                    <h4 class="mb-sm-0 font-size-18">Kepala Sekolah</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?= site_url('home') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Kepala Sekolah</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <?php if (session()->getFlashdata('success')) : ?>
            <!-- Secondary Alert -->
            <div class="alert alert-success alert-border-left alert-dismissible fade shadow show" role="alert">
                <i class="ri-check-double-line me-3 align-middle"></i> <strong>Success</strong> - <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">x</button>
                    <b>Error !</b>
                    <?= session()->getFlashdata('error') ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-1">
                            <div class="col-xs-6 col-md-6">
                                <h4 class="alert-heading">Data Kepala Sekolah</h4>
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
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Status</th>
                                    <th>Tahun</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Aktif</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($kepala as $key => $value) : ?>
                                    <tr>

                                        <td><?= $key + 1 ?></td>
                                        <td><?= $value->nama ?></a></td>
                                        <td><?= $value->nip ?></td>
                                        <td>
                                            <?php if ($value->status == 'Aktif') : ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else : ?>
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $value->tahun ?></td>
                                        <td><?= $value->ket_tahun ?></td>
                                        <td>
                                            <?php if ($value->aktivasi == 'Sedang Aktif') : ?>
                                                <span class="badge bg-primary">Sedang Aktif</span>
                                            <?php elseif ($value->aktivasi == 'Sedang Tidak Aktif') : ?>
                                                <span class="badge bg-danger">Sedang Tidak Aktif</span>
                                            <?php else : ?>
                                                <span class="badge bg-secondary">Mutasi</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-success btn-animation waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-edit-matpel-<?= $value->id_kepalasekolah ?>"><i class='fas fa-sliders-h'></i></a>
                                        </td>
                                    </tr>
                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="modal-edit-matpel-<?= $value->id_kepalasekolah ?>" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modal-edit-matpel">Edit Kepala Sekolah</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="<?= site_url('sekolah/kepala_sekolah/' . $value->id_kepalasekolah) ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="_method" value="PUT">
                                                        <input type="hidden" name="id_kepalasekolah" value="<?= $value->id_kepalasekolah ?>">
                                                        <!-- Debug info to see what's being submitted -->
                                                        <!-- ID: <?= $value->id_kepalasekolah ?> -->
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control" name="nama" id="floatingnameInput" value="<?= $value->nama ?>">
                                                            <label for="floatingnameInput">Nama Lengkap</label>
                                                            <p>*Nama ditulis beserta gelar akademik sesuai ijazah</p>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3">
                                                                    <input type="text" class="form-control" name="nip" id="floatingemailInput" value="<?= $value->nip ?>">
                                                                    <label for="floatingemailInput">NIP</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3">
                                                                    <select name="id_tahun_ajaran" id="id_tahun_ajaran" class="form-control">
                                                                        <option value=""> -- Pilih -- </option>
                                                                        <?php foreach ($tahun as $t): ?>
                                                                            <option value="<?= $t->id_tahun_ajaran ?>" <?= $t->id_tahun_ajaran == $value->id_tahun_ajaran ? 'selected' : '' ?>><?= $t->ket_tahun ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    <label for="floatingSelectGrid">Tahun Pelajaran</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3">
                                                                    <select name="status" id="" class="form-control">
                                                                        <option value=""> -- Pilih -- </option>
                                                                        <option value="Aktif" <?= $value->status == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                                                                        <option value="Tidak Aktif" <?= $value->status == 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                                                                    </select>
                                                                    <label for="floatingSelectGrid">Status</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3">
                                                                    <select name="aktivasi" id="aktivasi" class="form-control">
                                                                        <option value=""> -- Pilih -- </option>
                                                                        <option value="Sedang Aktif" <?= $value->aktivasi == 'Sedang Aktif' ? 'selected' : '' ?>>Sedang Aktif</option>
                                                                        <option value="Sedang Tidak Aktif" <?= $value->aktivasi == 'Sedang Tidak Aktif' ? 'selected' : '' ?>>Sedang Tidak Aktif</option>
                                                                        <option value="Mutasi" <?= $value->aktivasi == 'Mutasi' ? 'selected' : '' ?>>Mutasi</option>
                                                                    </select>
                                                                    <label for="floatingSelectGrid">Keaktifan</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-floating mb-3">
                                                                    <input type="text" class="form-control" name="tahun" id="floatingemailInput" value="<?= $value->tahun ?>">
                                                                    <label for="floatingemailInput">Tahun</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </div><!--end col-->
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
    <!-- container-fluid -->
</div>

<!-- Grids in modals -->
<div class="modal fade" id="modal-tambah-tapel" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-tambah-tapel">Tambah Kepala Sekolah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php $errors = session()->getFlashdata('errors'); ?>
                <form action="<?= site_url('sekolah/kepala_sekolah') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="nama" id="floatingnameInput" placeholder="Nama Lengkap">
                        <label for="floatingnameInput">Nama Lengkap</label>
                        <p>*Nama ditulis beserta gelar akademik sesuai ijazah</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="nip" id="floatingemailInput" placeholder="Enter Email address">
                                <label for="floatingemailInput">NIP</label>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select name="id_tahun_ajaran" id="id_tahun_ajaran" class="form-control">
                                    <option value=""> -- Pilih -- </option>
                                    <?php foreach ($tahun as $t): ?>
                                        <option value="<?= $t->id_tahun_ajaran ?>"><?= $t->ket_tahun ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="floatingSelectGrid">Tahun Pelajaran</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div><!--end col-->
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>