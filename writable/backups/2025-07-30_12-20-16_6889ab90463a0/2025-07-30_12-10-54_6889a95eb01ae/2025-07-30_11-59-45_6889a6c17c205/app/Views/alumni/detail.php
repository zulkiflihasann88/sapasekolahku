<?= $this->extend('layout/default') ?>
<?= $this->section('title') ?>
<title>Detail Alumni &mdash; SDN Krengseng 02</title>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Detail Alumni</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <?php if (isset($alumni) && $alumni): ?>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Nama</th>
                                    <td><?= esc($alumni->nama_siswa) ?></td>
                                </tr>
                                <tr>
                                    <th>NISN</th>
                                    <td><?= esc($alumni->nisn) ?></td>
                                </tr>
                                <tr>
                                    <th>NIS</th>
                                    <td><?= esc($alumni->nis) ?></td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td><?= esc($alumni->jk) ?></td>
                                </tr>
                                <tr>
                                    <th>Tempat, Tanggal Lahir</th>
                                    <td><?= esc($alumni->tempat_lahir) ?>, <?= date('d-m-Y', strtotime($alumni->tanggal_lahir)) ?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lulus</th>
                                    <td><?= isset($alumni->tanggal_mutasi) ? date('d-m-Y', strtotime($alumni->tanggal_mutasi)) : '-' ?></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td><?= esc($alumni->alamat ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Nama Ayah</th>
                                    <td><?= esc($alumni->nama_ayah ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th>Nama Ibu</th>
                                    <td><?= esc($alumni->nama_ibu ?? '-') ?></td>
                                </tr>
                            </table>
                            <a href="<?= site_url('alumni') ?>" class="btn btn-secondary">Kembali</a>
                        <?php else: ?>
                            <div class="alert alert-warning">Data alumni tidak ditemukan.</div>
                            <a href="<?= site_url('alumni') ?>" class="btn btn-secondary">Kembali</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>