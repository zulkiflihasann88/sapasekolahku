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
                    <h4 class="mb-sm-0 font-size-18">Pendidik</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?= site_url('home') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Pendidik</li>
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
                        <div class="row align-items-center justify-content-between">
                            <div class="col-md-6">
                                <h5 class="alert-heading mb-0">Data Pendidik</h5>
                                <p class="mb-0">Master Data</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="button" class="btn btn-sm btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-pendidik">
                                    <i class="bx bx-user-plus d-block font-size-16"></i>Tambah
                                </button>
                            </div>
                        </div>
                        <hr class="border-success-subtle">
                        <table id="scroll-horizontal" class="table table-bordered dt-responsive  nowrap w-100" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th class="align-middle">No</th>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th>NUPTK</th>
                                    <th>NIP</th>
                                    <th>L/P</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Jenis Pegawai</th>
                                    <th>Jenis PTK</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pendidik as $key => $value) : ?>
                                    <tr>
                                        <td class="align-middle"><?= $key + 1 ?></td>
                                        <td class="align-middle"><?= $value->nama ?></td>
                                        <td class="align-middle"><?= $value->nik ?></td>
                                        <td class="align-middle"><?= $value->nuptk ?></td>
                                        <td class="align-middle"><?= $value->nip ?></td>
                                        <td class="align-middle"><?= $value->jenis_kelamin ?></td>
                                        <td class="align-middle"><?= date('d-m-Y', strtotime($value->tanggal_lahir)) ?></td>
                                        <td class="align-middle"><?= $value->jenis_pegawai ?></td>
                                        <td class="align-middle"><?= $value->jenis_ptk ?></td>
                                        <td class="align-middle">
                                            <?php if ($value->status === 'Aktif') : ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else : ?>
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle">
                                            <a href="javascript:void(0);" class="btn btn-sm btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-pendidik" onclick="editPendidik(<?= htmlspecialchars(json_encode($value), ENT_QUOTES, 'UTF-8') ?>)">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <form action="<?= site_url('pendidik/' . $value->id_pendidik) ?>" method="post" class="d-inline" id="del-<?= $value->id_pendidik ?>">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeletePendidik(<?= $value->id_pendidik ?>)">
                                                    <i class="mdi mdi-trash-can-outline"></i>
                                                </button>
                                            </form>
                                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                            <script>
                                            function confirmDeletePendidik(id) {
                                                Swal.fire({
                                                    title: 'Yakin ingin menghapus?',
                                                    text: 'Data pendidik yang dihapus tidak dapat dikembalikan!',
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#d33',
                                                    cancelButtonColor: '#3085d6',
                                                    confirmButtonText: 'Ya, hapus!',
                                                    cancelButtonText: 'Batal'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        document.getElementById('del-' + id).submit();
                                                    }
                                                });
                                            }
                                            </script>
                                        </td>
                                    </tr>
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
<div class="modal fade" id="modal-pendidik" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-pendidik">Registasi Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php $errors = session()->getFlashdata('errors'); ?>
                <form action="" method="post">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label">Jenis Pegawai</label>
                            <div class="d-flex gap-4 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_pegawai" id="pns" value="PNS">
                                    <label class="form-check-label" for="pns">PNS</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_pegawai" id="pppk" value="PPPK/P3K">
                                    <label class="form-check-label" for="pppk">PPPK/P3K</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_pegawai" id="non_asn" value="NON ASN">
                                    <label class="form-check-label" for="non_asn">NON ASN</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingnameInput" name="nama" placeholder="Enter Name">
                        <label for="floatingnameInput">Nama Pegawai</label>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="floatingemailInput" name="nip" placeholder="Enter Email address">
                                <label for="floatingemailInput">NIP</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="floatingemailInput" name="nuptk" placeholder="Enter Email address">
                                <label for="floatingemailInput">NUPTK</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingnameInput" name="nik" placeholder="Enter Name">
                        <label for="floatingnameInput">NIK</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki-laki" value="L">
                                <label class="form-check-label" for="L">Laki - laki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="P">
                                <label class="form-check-label" for="P">Perempuan</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingemailInput" name="tempat_lahir" placeholder="Enter Email address">
                                <label for="floatingemailInput">Tempat Lahir</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="floatingemailInput" name="tanggal_lahir" placeholder="Enter Email address">
                                <label for="floatingemailInput">Tanggal Lahir</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="pendidikan_akhir" id="pendidikanAkhir">
                                    <option value="" disabled selected>-- Pilih --</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="D1">D1</option>
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                                <label class="form-label">Pendidikan Akhir</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingemailInput" name="email" placeholder="Enter Email address">
                                <label for="floatingemailInput">Email</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" name="jenis_ptk">
                                        <option value="" disabled selected>-- Pilih Jenis PTK --</option>
                                        <option value="Kepal Sekolah">Kepala Sekolah</option>
                                        <option value="Guru">Guru</option>
                                        <option value="Guru Mata Pelajaran">Guru Mata Pelajaran</option>
                                        <option value="Tenaga Administrasi">Tenaga Administrasi</option>
                                        <option value="Penjaga">Penjaga</option>
                                    </select>
                                    <label class="form-label">Jenis PTK</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" name="status">
                                        <option value="" disabled selected>-- Pilih --</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                    </select>
                                    <label class="form-label">Keaktifan</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary waves-effect" style="width:86.5%;">Simpan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function editPendidik(data) {
        // Reset form terlebih dahulu agar tidak ada sisa data
        var form = document.querySelector('#modal-pendidik form');
        form.reset();

        // Set Jenis Pegawai radio (case-insensitive, robust, handle null/undefined)
        var jenisPegawai = (data.jenis_pegawai || '').toString().trim().toUpperCase();
        var jenisPegawaiRadios = form.querySelectorAll('input[name="jenis_pegawai"]');
        // Patch: handle possible whitespace and case issues from DB
        jenisPegawaiRadios.forEach(function(radio) {
            var radioVal = radio.value.toString().trim().toUpperCase();
            // Allow partial match for common mistakes (e.g. "NON ASN" vs "NON-ASN")
            if (radioVal.replace(/[^A-Z]/g, '') === jenisPegawai.replace(/[^A-Z]/g, '') && jenisPegawai !== '') {
                radio.checked = true;
            } else {
                radio.checked = false;
            }
        });

        form.querySelector('input[name="nama"]').value = data.nama || '';
        form.querySelector('input[name="nip"]').value = data.nip || '';
        form.querySelector('input[name="nuptk"]').value = data.nuptk || '';
        form.querySelector('input[name="nik"]').value = data.nik || '';

        // Set Jenis Kelamin radio
        var jenisKelamin = (data.jenis_kelamin || '').toString().trim().toUpperCase();
        var jenisKelaminRadios = form.querySelectorAll('input[name="jenis_kelamin"]');
        var foundJenisKelamin = false;
        jenisKelaminRadios.forEach(function(radio) {
            if (radio.value.toUpperCase() === jenisKelamin) {
                radio.checked = true;
                foundJenisKelamin = true;
            } else {
                radio.checked = false;
            }
        });
        if (!foundJenisKelamin) {
            jenisKelaminRadios.forEach(function(radio) { radio.checked = false; });
        }

        form.querySelector('input[name="tempat_lahir"]').value = data.tempat_lahir || '';
        form.querySelector('input[name="tanggal_lahir"]').value = data.tanggal_lahir || '';
        form.querySelector('select[name="pendidikan_akhir"]').value = data.pendidikan_akhir || '';
        form.querySelector('input[name="email"]').value = data.email || '';
        form.querySelector('select[name="jenis_ptk"]').value = data.jenis_ptk || '';
        form.querySelector('select[name="status"]').value = data.status || '';

        // Ubah action form untuk update
        form.action = '<?= site_url('pendidik') ?>/' + data.id_pendidik;
        // Hapus input _method sebelumnya jika ada
        var oldMethod = form.querySelector('input[name="_method"]');
        if (oldMethod) oldMethod.remove();
        form.insertAdjacentHTML('beforeend', '<input type="hidden" name="_method" value="PUT">');
    }
</script>
<?= $this->endSection() ?>