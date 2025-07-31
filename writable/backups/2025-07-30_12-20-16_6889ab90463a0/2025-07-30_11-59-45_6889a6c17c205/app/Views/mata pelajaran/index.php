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
                    <h4 class="mb-sm-0 font-size-18">Data Mata Pelajaran</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?= site_url('home') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Mata Pelajaran</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <?php if (session()->getFlashdata('success')) : ?>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                toastr.success("<?= session()->getFlashdata('success'); ?>", 'Sukses', {
                    "progressBar": true,
                    "timeOut": "3000",
                    "positionClass": "toast-top-right",
                    "extendedTimeOut": "3000"
                });
            });
            </script>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                toastr.error("<?= session()->getFlashdata('error'); ?>", 'Gagal', {
                    "progressBar": true,
                    "timeOut": "3000",
                    "positionClass": "toast-top-right",
                    "extendedTimeOut": "3000"
                });
            });
            </script>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <a class="btn btn-sm btn-success waves-effect btn-label waves-light mb-2" data-bs-toggle="modal" data-bs-target="#modal-tambah-matpel"><i class="bx bx-plus label-icon"></i> Add</a>
                            <!-- <a class="btn btn-success mb-3"><i class="ri-add-circle-line align-middle me-1"></i>Tambah</a> -->
                        </div>
                        <table id="scroll-horizontal" class="table table-bordered dt-responsive  nowrap w-100" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th class="align-middle">No</th>
                                    <th>Kode Mata Pelajaran</th>
                                    <th>Nama Mata Pelajaran</th>
                                    <th>Kelompok</th>
                                    <th>Singkatan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($matpel as $key => $value) : ?>
                                    <tr>

                                        <td style=" width:10%"><?= $key + 1 ?></td>
                                        <td><?= $value->kode_mapel ?></a></td>
                                        <td><?= $value->nama_mapel ?></td>
                                        <td><?= $value->kelompok ?></td>
                                        <td><?= $value->singkatan ?></td>
                                        <td>
                                            <a class="btn btn-sm btn-success btn-animation waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-edit-matpel-<?= $value->id_pelajaran ?>"><i class='mdi mdi-pencil'></i></a>
                                            <form action="<?= site_url('mata_pelajaran/' . $value->id_pelajaran) ?>" method="post" class="d-inline" id="sa-warning del-<?= $value->id_pelajaran ?>">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="btn btn-danger btn-sm" data-confirm="Hapus Data?|Apakah Anda yakin?" data-confirm-yes="submitDel(<?= $value->id_pelajaran ?>)">
                                                    <i class='mdi mdi-trash-can-outline'></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="modal-edit-matpel-<?= $value->id_pelajaran ?>" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modal-edit-matpel">Edit Mata Pelajaran</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php $errors = session()->getFlashdata('errors'); ?>
                                                    <form action="<?= site_url('mata_pelajaran/' . $value->id_pelajaran) ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="_method" value="PUT">
                                                        <div class="row g-4">
                                                            <div class="col-xxl-12">
                                                                <div>
                                                                    <label class="form-label">Kode Mata Pelajaran</label>
                                                                    <input type="number" class="form-control" name="kode_mapel" value="<?= $value->kode_mapel ?>">
                                                                </div>
                                                            </div><!--end col-->
                                                            <div class="col-xxl-12">
                                                                <div>
                                                                    <label class="form-label">Nama Mata Pelajaran</label>
                                                                    <input type="text" class="form-control" name="nama_mapel" value="<?= $value->nama_mapel ?>">
                                                                </div>
                                                            </div><!--end col-->
                                                            <div class="col-xxl-12">
                                                                <div>
                                                                    <label class="form-label">Kelompok</label>
                                                                    <select name="kelompok" class="form-control">
                                                                        <option value="">-- Pilih Kelompok --</option>
                                                                        <option value="Kelompok A" <?= $value->kelompok == 'Kelompok A' ? 'selected' : '' ?>>Kelompok A</option>
                                                                        <option value="Kelompok B" <?= $value->kelompok == 'Kelompok B' ? 'selected' : '' ?>>Kelompok B</option>
                                                                        <option value="Umum" <?= $value->kelompok == 'Umum' ? 'selected' : '' ?>>Umum</option>
                                                                    </select>
                                                                </div>
                                                            </div><!--end col-->
                                                            <div class="col-xxl-12">
                                                                <div>
                                                                    <label class="form-label">Singkatan</label>
                                                                    <input type="text" class="form-control" name="singkatan" value="<?= $value->singkatan ?>">
                                                                </div>
                                                            </div><!--end col-->
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
<div class="modal fade" id="modal-tambah-matpel" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-tambah-matpel">Tambah mata pelajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php $errors = session()->getFlashdata('errors'); ?>
                <form action="<?= site_url('mata_pelajaran') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row g-4">
                        <div class="col-xxl-12">
                            <div>
                                <label class="form-label">Kode mata pelajaran</label>
                                <input type="number" name="kode_mapel" class="form-control" id="kode_mapel_input" readonly>
                            <script>
                            // Otomatisasi kode mata pelajaran: 9 digit angka acak
                            document.addEventListener('DOMContentLoaded', function() {
                                var tambahModal = document.getElementById('modal-tambah-matpel');
                                if (tambahModal) {
                                    tambahModal.addEventListener('show.bs.modal', function() {
                                        function random9Digit() {
                                            // Menghasilkan angka 9 digit, tidak diawali 0
                                            return Math.floor(100000000 + Math.random() * 900000000);
                                        }
                                        var kodeInput = document.getElementById('kode_mapel_input');
                                        if (kodeInput) kodeInput.value = random9Digit();
                                    });
                                }
                            });
                            </script>
                            </div>
                        </div><!--end col-->
                        <div class="col-xxl-12">
                            <div>
                                <label class="form-label">Nama mata pelajaran</label>
                                <input type="text" name="nama_mapel" class="form-control" name="nama_matpel">
                            </div>
                        </div><!--end col-->
                        <div class="col-xxl-12">
                            <div>
                                <label class="form-label">Kelompok</label>
                                <select name="kelompok" class="form-control">
                                    <option value="">-- Pilih Kelompok --</option>
                                    <option value="Kelompok A">Kelompok A</option>
                                    <option value="Kelompok B">Kelompok B</option>
                                    <option value="Umum">Umum</option>
                                </select>
                            </div>
                        </div><!--end col-->
                        <div class="col-xxl-12">
                            <div>
                                <label class="form-label">Singkatan</label>
                                <input type="text" name="singkatan" class="form-control" name="ket">
                            </div>
                        </div><!--end col-->
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
<?= $this->endSection() ?>