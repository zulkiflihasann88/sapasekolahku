<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Update Gawe &mdash; yukNikah</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-content">
    <div class="container-fluid">
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
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Tahun Penerimaan</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Daftar</a></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-5">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h5 class="m-0 font-weight-bold text-danger">Tambah Tahun Pendaftaran</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= site_url('tahun_penerimaan') ?>" method="post" class="needs-validation" novalidate="">
                            <?= csrf_field() ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="varchar">Tahun Pelajaran <span style="color:red;">*</span></label>
                                        <input type="text" class="form-control" name="tahun_pelajaran" id="tahun_penerimaan" placeholder="Contoh : 2020/2021" value="" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="varchar">Kuota <span style="color:red;">*</span></label>
                                        <input type="text" class="form-control" name="kuota" id="kuota" placeholder="Kuota" value="" required />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date">Tanggal Mulai Pendaftaran <span style="color:red;">*</span></label>
                                        <div class="input-group" id="datepicker2">
                                            <input type="text" class="form-control" placeholder="Tanggal Mulai Pendaftaran" name="tanggal_mulai_pendaftaran" id="tanggal_mulai_pendaftaran"
                                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker"
                                                data-date-autoclose="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date">Tanggal Selesai Pendaftaran <span style="color:red;">*</span></label>
                                        <div class="input-group" id="datepicker2">
                                            <input type="text" class="form-control" name="tanggal_selesai_pendaftaran" id="tanggal_selesai_pendaftaran" placeholder="Tanggal Selesai Pendaftaran"
                                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker"
                                                data-date-autoclose="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date">Tanggal Mulai Seleksi <span style="color:red;">*</span> </label>
                                        <div class="input-group" id="datepicker2">
                                            <input type="text" class="form-control" name="tanggal_mulai_seleksi" id="tanggal_mulai_seleksi" placeholder="Tanggal Mulai Seleksi"
                                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker"
                                                data-date-autoclose="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date">Tanggal Selesai Seleksi <span style="color:red;">*</span> </label>
                                        <div class="input-group" id="datepicker2">
                                            <input type="text" class="form-control" name="tanggal_selesai_seleksi" id="tanggal_selesai_seleksi" placeholder="Tanggal Selesai Seleksi"
                                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker"
                                                data-date-autoclose="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="date">Tanggal Pengumuman <span style="color:red;">*</span> </label>
                                <div class="input-group" id="datepicker2">
                                    <input type="text" class="form-control" name="tanggal_pengumuman" id="tanggal_pengumuman" placeholder="Tanggal Pengumuman"
                                        data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker"
                                        data-date-autoclose="true">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date">Tanggal Mulai Daftar Ulang <span style="color:red;">*</span></label>
                                        <div class="input-group" id="datepicker2">
                                            <input type="text" class="form-control" name="tanggal_mulai_daftar_ulang" id="tanggal_mulai_daftar_ulang" placeholder="Tanggal Mulai Daftar Ulang"
                                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker"
                                                data-date-autoclose="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date">Tanggal Selesai Daftar Ulang <span style="color:red;">*</span></label>
                                        <div class="input-group" id="datepicker2">
                                            <input type="text" class="form-control" name="tanggal_selesai_daftar_ulang" id="tanggal_selesai_daftar_ulang" placeholder="Tanggal Selesai Daftar Ulang"
                                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker"
                                                data-date-autoclose="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="enum">Status Tahun <span style="color:red;">*</span> </label>
                                <select type="text" class="form-control" name="status_tahun" id="status_tahun" placeholder="Status Tahun" value="" required />
                                <option value=""> --Pilih status--</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                            </div>
                            <div>
                                <button class="btn btn-primary bg-gradient" type="submit">Submit form</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h5 class="m-0 font-weight-bold text-danger">List Tahun Pendaftaran</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <a class="btn btn-sm btn-danger bg-gradient mb-3"><i class="fa fa-trash align-middle me-1"></i> Hapus Data Terpilih</a>
                        </div>
                        <table id="scroll-horizontal" class="table table-bordered dt-responsive  nowrap w-100" style="width:80%">
                            <thead class="table-light">
                                <tr>
                                    <th class="align-middle">No</th>
                                    <th class="align-middle">Tahun Penerimaan</th>
                                    <th class="align-middle text-center">Kuota</th>
                                    <th class="align-middle text-center">Status</th>
                                    <th class="align-middle text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tahun_penerimaan as $key => $value) : ?>
                                    <tr>
                                        <td class="align-middle"><?= $key + 1 ?></td>
                                        <td class="align-middle"><?= $value->tahun_pelajaran ?></td>
                                        <td class="align-middle"><?= $value->kuota ?></td>
                                        <td class="align-middle text-center"> <?php if ($value->status_tahun == 'Aktif') : ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else : ?>
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="" class="btn btn-sm btn-primary waves-effect waves-light bg-gradient" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Lihat data">
                                                <i class="fas fa-search"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-warning waves-effect waves-light bg-gradient" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit data" onclick="editData(<?= $value->id_tahun ?>, '<?= $value->tahun_pelajaran ?>', '<?= $value->kuota ?>', '<?= $value->tanggal_mulai_pendaftaran ?>', '<?= $value->tanggal_selesai_pendaftaran ?>', '<?= $value->tanggal_mulai_seleksi ?>', '<?= $value->tanggal_selesai_seleksi ?>', '<?= $value->tanggal_pengumuman ?>', '<?= $value->tanggal_mulai_daftar_ulang ?>', '<?= $value->tanggal_selesai_daftar_ulang ?>', '<?= $value->status_tahun ?>')">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <form action="<?= site_url('tahun_penerimaan/' . $value->id_tahun) ?>" method="post" class="d-inline" id="del-<?= $value->id_tahun ?>">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="btn btn-danger btn-sm bg-gradient" data-confirm="Hapus Data?|Apakah Anda yakin?" data-confirm-yes="submitDel(<?= $value->id_tahun ?>)">
                                                    <i class="mdi mdi-trash-can-outline"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editForm" method="post">
                        <?= csrf_field() ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Tahun Penerimaan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="id_tahun" id="edit_id_tahun">
                            <div class="mb-3">
                                <label for="edit_tahun_pelajaran" class="form-label">Tahun Pelajaran</label>
                                <input type="text" class="form-control" id="edit_tahun_pelajaran" name="tahun_pelajaran" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_kuota" class="form-label">Kuota</label>
                                <input type="text" class="form-control" id="edit_kuota" name="kuota" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date">Tanggal Mulai Pendaftaran <span style="color:red;">*</span></label>
                                        <div class="input-group" id="datepicker_modal1">
                                            <input type="text" class="form-control" name="tanggal_mulai_pendaftaran" id="edit_tanggal_mulai_pendaftaran"
                                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker_modal1' data-provide="datepicker"
                                                data-date-autoclose="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date">Tanggal Selesai Pendaftaran <span style="color:red;">*</span></label>
                                        <div class="input-group" id="datepicker_modal2">
                                            <input type="text" class="form-control" name="tanggal_selesai_pendaftaran" id="edit_tanggal_selesai_pendaftaran" placeholder="Tanggal Selesai Pendaftaran"
                                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker_modal2' data-provide="datepicker"
                                                data-date-autoclose="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date">Tanggal Mulai Seleksi <span style="color:red;">*</span> </label>
                                        <div class="input-group" id="datepicker_modal1">
                                            <input type="text" class="form-control" name="tanggal_mulai_seleksi" id="edit_tanggal_mulai_seleksi"
                                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker_modal1' data-provide="datepicker"
                                                data-date-autoclose="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date">Tanggal Selesai Seleksi <span style="color:red;">*</span> </label>
                                        <div class="input-group" id="datepicker_modal2">
                                            <input type="text" class="form-control" name="tanggal_selesai_seleksi" id="edit_tanggal_selesai_seleksi" placeholder="Tanggal Selesai Seleksi"
                                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker_modal2' data-provide="datepicker"
                                                data-date-autoclose="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="date">Tanggal Pengumuman <span style="color:red;">*</span> </label>
                                <div class="input-group" id="datepicker_modal5">
                                    <input type="text" class="form-control" name="tanggal_pengumuman" id="edit_tanggal_pengumuman"
                                        data-date-format="yyyy-mm-dd" data-date-container='#datepicker_modal5' data-provide="datepicker"
                                        data-date-autoclose="true">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date">Tanggal Mulai Daftar Ulang <span style="color:red;">*</span></label>
                                        <div class="input-group" id="datepicker_modal6">
                                            <input type="text" class="form-control" name="tanggal_mulai_daftar_ulang" id="edit_tanggal_mulai_daftar_ulang" _modal
                                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker_modal6' data-provide="datepicker"
                                                data-date-autoclose="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date">Tanggal Selesai Daftar Ulang <span style="color:red;">*</span></label>
                                        <div class="input-group" id="datepicker_modal7">
                                            <input type="text" class="form-control" name="tanggal_selesai_daftar_ulang" id="edit_tanggal_selesai_daftar_ulang"
                                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker_modal7' data-provide="datepicker"
                                                data-date-autoclose="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_status_tahun" class="form-label">Status Tahun</label>
                                <select class="form-control" id="edit_status_tahun" name="status_tahun" required>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            function editData(id, tahun_pelajaran, kuota, tanggal_mulai_pendaftaran, tanggal_selesai_pendaftaran, tanggal_mulai_seleksi, tanggal_selesai_seleksi, tanggal_pengumuman, tanggal_mulai_daftar_ulang, tanggal_selesai_daftar_ulang, status_tahun) {
                $('#edit_id_tahun').val(id);
                $('#edit_tahun_pelajaran').val(tahun_pelajaran);
                $('#edit_kuota').val(kuota);
                $('#edit_tanggal_mulai_pendaftaran').val(tanggal_mulai_pendaftaran);
                $('#edit_tanggal_selesai_pendaftaran').val(tanggal_selesai_pendaftaran);
                $('#edit_tanggal_mulai_seleksi').val(tanggal_mulai_seleksi);
                $('#edit_tanggal_selesai_seleksi').val(tanggal_selesai_seleksi);
                $('#edit_tanggal_pengumuman').val(tanggal_pengumuman);
                $('#edit_tanggal_mulai_daftar_ulang').val(tanggal_mulai_daftar_ulang);
                $('#edit_tanggal_selesai_daftar_ulang').val(tanggal_selesai_daftar_ulang);
                $('#edit_status_tahun').val(status_tahun);
                $('#editForm').attr('action', '<?= site_url('tahun_penerimaan') ?>/' + id);
                $('#editModal').modal('show');
            }
        </script>
    </div>
</div>
<?= $this->endSection() ?>