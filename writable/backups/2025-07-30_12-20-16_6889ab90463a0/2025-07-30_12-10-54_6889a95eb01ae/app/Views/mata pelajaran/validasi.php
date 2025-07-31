<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Validasi Siswa Tanpa Kelas &mdash; SDN Krengseng 02</title>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Validasi Siswa Tanpa Kelas</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table id="students-without-class" class="table table-bordered dt-responsive nowrap w-100">
                            <thead class="table-light">
                                <tr>
                                    <th class="align-middle">No</th>
                                    <th class="align-middle">Nama</th>
                                    <th class="align-middle">JK</th>
                                    <th class="align-middle">NISN</th>
                                    <th class="align-middle">NIK</th>
                                    <th class="align-middle">No KK</th>
                                    <th class="align-middle">Tempat Lahir</th>
                                    <th class="align-middle">Tanggal Lahir</th>
                                    <th class="align-middle">Rombel</th>
                                    <th class="align-middle">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($siswa_tanpa_kelas as $key => $value) : ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $value->nama_siswa ?></td>
                                        <td><?= $value->jk ?></td>
                                        <td><?= $value->nisn ?></td>
                                        <td><?= $value->nik ?></td>
                                        <td><?= $value->no_kk ?></td>
                                        <td><?= $value->tempat_lahir ?></td>
                                        <td><?= $value->tanggal_lahir ?></td>
                                        <td><?= $value->nama_rombel ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Detail">
                                                <i class="mdi mdi-account-details-outline"></i>
                                            </button>
                                            <a href="<?= site_url('peserta_didik/' . $value->id_siswa . '/edit') ?>" class="btn btn-sm btn-success waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit data">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <form action="<?= site_url('peserta_didik/' . $value->id_siswa) ?>" method="post" class="d-inline" id="del-<?= $value->id_siswa ?>">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="btn btn-danger btn-sm" data-confirm="Hapus Data?|Apakah Anda yakin?" data-confirm-yes="submitDel(<?= $value->id_siswa ?>)">
                                                    <i class="mdi mdi-trash-can-outline"></i>
                                                </button>
                                            </form>
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
    <?= $this->endSection() ?>