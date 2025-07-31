<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Wali Kelas &mdash; SDN Krengseng 02</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-content">
    <!-- Header Section -->
    <div class="profile-header-card">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="profile-avatar me-3">
                        <i class="bx bxs-user-detail fs-2 text-white"></i>
                    </div>
                    <div class="text-white">
                        <h3 class="text-white mb-1 fw-bold">Wali Kelas</h3>
                        <p class="text-white-50 mb-0">Kelola data wali kelas sekolah</p>
                    </div>
                </div>
                <button class="btn btn-light btn-sm profile-btn px-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bx bx-plus fs-6 me-1"></i>Tambah Data
                </button>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white border-0 p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="card-title mb-1 fw-bold text-dark">
                                <i class="bx bx-list-ul text-primary fs-5 me-2"></i>Daftar Wali Kelas
                            </h5>
                            <p class="text-muted mb-0 small">Kelola data wali kelas sekolah</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-export me-1"></i>Export
                            </button>
                            <button class="btn btn-outline-success btn-sm">
                                <i class="bx bx-import me-1"></i>Import
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="mx-2">
                        <table class="table table-hover mb-0" id="datatable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" width="50">No</th>
                                    <th>Jenis Kelas</th>
                                    <th>Tingkat Pendidikan</th>
                                    <th>Kurikulum</th>
                                    <th>Nama Rombel</th>
                                    <th>Nama Wali Kelas</th>
                                    <th>Ruang</th>
                                    <th class="text-center" width="120">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <style>
                        /* Scroll hanya pada tbody, header dan control tetap */
                        #datatable {
                            width: 100% !important;
                        }

                        #datatable_wrapper .dataTables_scrollBody {
                            max-height: 400px;
                            overflow-y: auto !important;
                        }

                        /* Custom styling for DataTables processing indicator */
                        div.dataTables_processing {
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            width: 200px;
                            margin-left: -100px;
                            margin-top: -26px;
                            text-align: center;
                            padding: 10px;
                            background-color: white;
                            border: 1px solid #ddd;
                            border-radius: 5px;
                            font-size: 14px;
                            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16);
                            z-index: 1;
                        }

                        /* Make sure the processing indicator is visible */
                        .dataTables_wrapper .dataTables_processing {
                            background: rgba(255, 255, 255, 0.9);
                            height: 60px;
                            line-height: 60px;
                        }
                    </style>
                    <script>
                        $(document).ready(function() {
                            $('#datatable').DataTable({
                                processing: true,
                                serverSide: true,
                                scrollY: 400,
                                scrollCollapse: true,
                                scroller: true,
                                language: {
                                    processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div> <span class="ms-1">Memuat data...</span>',
                                    emptyTable: "Tidak ada data yang tersedia",
                                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                                    infoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
                                    infoPostFix: "",
                                    search: "Cari:",
                                    searchPlaceholder: "Kata kunci...",
                                    zeroRecords: "Tidak ditemukan data yang sesuai",
                                    paginate: {
                                        first: "Pertama",
                                        last: "Terakhir",
                                        next: "Selanjutnya",
                                        previous: "Sebelumnya"
                                    }
                                },
                                ajax: {
                                    url: '<?= site_url('wali_kelas/datatables') ?>',
                                    type: 'POST',
                                    data: function(d) {
                                        d['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
                                        return d;
                                    }
                                },
                                columns: [{
                                        data: 'no',
                                        className: 'text-center',
                                        orderable: false
                                    },
                                    {
                                        data: 'jenis_kelas'
                                    },
                                    {
                                        data: 'tingkat_pendidikan'
                                    },
                                    {
                                        data: 'kurikulum'
                                    },
                                    {
                                        data: 'nama_rombel'
                                    },
                                    {
                                        data: 'nama_wali'
                                    },
                                    {
                                        data: 'ruang'
                                    },
                                    {
                                        data: 'aksi',
                                        className: 'text-center',
                                        orderable: false,
                                        searchable: false
                                    }
                                ]
                            });
                        });
                    </script>
                    <!-- DataTables & jQuery CDN (gunakan local jika sudah ada) -->
                    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"> -->
                    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
                    <!-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bx bx-plus-circle me-2"></i>
                    <span id="modal-title">Tambah Wali Kelas</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formWaliKelas" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" id="id_wali_kelas" name="id_wali_kelas" value="">
                <input type="hidden" id="form_action" value="create">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="jenis_kelas" name="jenis_kelas" placeholder="Jenis Kelas" required>
                                <label for="jenis_kelas"><i class="bx bx-list-ul me-2"></i>Jenis Kelas <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <select class="form-select" id="tingkat_pendidikan" name="tingkat_pendidikan" required>
                                    <option value="">Pilih Tingkat Pendidikan...</option>
                                    <?php
                                    // Ambil semua kelas unik dari list_rombel (field kelas dari tabel db_rombel)
                                    $kelasArr = [];
                                    if (!empty($list_rombel)) {
                                        foreach ($list_rombel as $rombel) {
                                            $kelasArr[] = $rombel->kelas;
                                        }
                                    }
                                    $kelasArr = array_unique($kelasArr);
                                    sort($kelasArr, SORT_NATURAL);
                                    foreach ($kelasArr as $kelas) : ?>
                                        <option value="<?= htmlspecialchars($kelas) ?>"><?= htmlspecialchars($kelas) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="tingkat_pendidikan"><i class="bx bx-bar-chart me-2"></i>Tingkat Pendidikan <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <select class="form-select" id="kurikulum" name="kurikulum" required>
                                    <option value="">Pilih Kurikulum...</option>
                                    <option value="Kurikulum Merdeka">Kurikulum Merdeka</option>
                                    <option value="Kurikulum Deep Learning">Kurikulum Deep Learning</option>
                                </select>
                                <label for="kurikulum"><i class="bx bx-book me-2"></i>Kurikulum <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <select class="form-select" id="nama_rombel" name="nama_rombel" required>
                                    <option value="">Pilih Nama Rombel...</option>
                                    <?php
                                    // Ambil semua rombel unik dari list_rombel (field rombel dari tabel db_rombel)
                                    $rombelArr = [];
                                    if (!empty($list_rombel)) {
                                        foreach ($list_rombel as $rombel) {
                                            if (!empty($rombel->rombel)) {
                                                $rombelArr[] = $rombel->rombel;
                                            }
                                        }
                                    }
                                    $rombelArr = array_unique($rombelArr);
                                    sort($rombelArr, SORT_NATURAL);
                                    foreach ($rombelArr as $rombelNama) : ?>
                                        <option value="<?= htmlspecialchars($rombelNama) ?>"><?= htmlspecialchars($rombelNama) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="nama_rombel"><i class="bx bx-group me-2"></i>Nama Rombel <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <select class="form-select" id="nama_wali" name="nama_wali" required>
                                    <option value="">Pilih Nama Wali Kelas...</option>
                                    <?php if (!empty($list_pendidik)) : ?>
                                        <?php foreach ($list_pendidik as $pendidik) : ?>
                                            <option value="<?= htmlspecialchars($pendidik->nama) ?>"><?= htmlspecialchars($pendidik->nama) ?><?php if (!empty($pendidik->nip)) echo " (NIP: " . htmlspecialchars($pendidik->nip) . ")"; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <label for="nama_wali"><i class="bx bx-user me-2"></i>Nama Wali Kelas <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="ruang" name="ruang" placeholder="Ruang" required>
                                <label for="ruang"><i class="bx bx-building me-2"></i>Ruang <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <select class="form-select" id="tahun_ajaran" name="tahun_ajaran" required>
                                    <option value="">Pilih Tahun Ajaran...</option>
                                    <?php if (!empty($list_tapel)) : ?>
                                        <?php foreach ($list_tapel as $tapel) : ?>
                                            <option value="<?= htmlspecialchars($tapel->ket_tahun) ?>"><?= htmlspecialchars($tapel->ket_tahun) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <label for="tahun_ajaran"><i class="bx bx-calendar me-2"></i>Tahun Ajaran <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#formWaliKelas').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();
            var formAction = $('#form_action').val();
            var id = $('#id_wali_kelas').val();
            var url = '';
            if (formAction === 'update' && id) {
                url = '<?= site_url('wali_kelas/update') ?>/' + id;
            } else {
                url = '<?= site_url('wali_kelas/create') ?>';
            }
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#modalTambah').modal('hide');
                        if (typeof toastr !== 'undefined') {
                            toastr.success(response.message, 'Sukses!');
                        } else {
                            alert(response.message);
                        }
                        setTimeout(function() {
                            location.reload();
                        }, 1200);
                    } else {
                        if (typeof toastr !== 'undefined') {
                            toastr.error(response.message, 'Gagal!');
                        } else {
                            alert(response.message);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error, xhr.responseText);
                    var errorMsg = 'Terjadi kesalahan server: ' + status;
                    if (xhr.status === 404) {
                        errorMsg = 'URL tidak ditemukan (404): ' + url;
                    }
                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMsg, 'Error!');
                    } else {
                        alert(errorMsg);
                    }
                }
            });
        });
    });

    function editData(id) {
        // Ambil data dari server
        $.ajax({
            url: '<?= site_url('wali_kelas/getData') ?>/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success' && response.data) {
                    var data = response.data;
                    // Set field form
                    $('#id_wali_kelas').val(data.id_wali_kelas);
                    $('#form_action').val('update');
                    $('#jenis_kelas').val(data.jenis_kelas);
                    $('#tingkat_pendidikan').val(data.tingkat_pendidikan);
                    $('#kurikulum').val(data.kurikulum);
                    $('#nama_rombel').val(data.nama_rombel);
                    $('#nama_wali').val(data.nama_wali);
                    $('#ruang').val(data.ruang);
                    $('#kelas').val(data.kelas);
                    $('#tahun_ajaran').val(data.tahun_ajaran);
                    // Buka modal
                    $('#modalTambah').modal('show');
                    $('#modal-title').text('Edit Wali Kelas');
                } else {
                    toastr.error('Data tidak ditemukan.', 'Gagal!');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error, xhr.responseText);
                var errorMsg = 'Gagal mengambil data dari server: ' + status;
                if (xhr.status === 404) {
                    errorMsg = 'Data tidak ditemukan (404)';
                }
                toastr.error(errorMsg, 'Error!');
            }
        });
    }

    function deleteData(id) {
        if (confirm('Yakin ingin menghapus data ini?')) {
            $.ajax({
                url: '<?= site_url('wali_kelas/delete') ?>/' + id,
                type: 'DELETE',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        if (typeof toastr !== 'undefined') {
                            toastr.success(response.message, 'Sukses!');
                        } else {
                            alert(response.message);
                        }
                        setTimeout(function() {
                            location.reload();
                        }, 1200);
                    } else {
                        if (typeof toastr !== 'undefined') {
                            toastr.error(response.message, 'Gagal!');
                        } else {
                            alert(response.message);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error, xhr.responseText);
                    var errorMsg = 'Terjadi kesalahan server: ' + status;
                    if (xhr.status === 404) {
                        errorMsg = 'URL tidak ditemukan (404): hapus data';
                    } else if (xhr.status === 403) {
                        errorMsg = 'Akses ditolak (403): hapus data';
                    }
                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMsg, 'Error!');
                    } else {
                        alert(errorMsg);
                    }
                }
            });
        }
    }

    function showAnggotaRombel(nama_rombel) {
        // Contoh: tampilkan modal atau alert, bisa diganti dengan AJAX ke endpoint anggota rombel
        alert('Tampilkan anggota rombel untuk: ' + nama_rombel);
        // TODO: Implementasi: bisa pakai modal dan AJAX ke endpoint anggota rombel
    } // Ensure the DataTables processing indicator is shown
    $(document).ready(function() {
        // Add event listener for DataTables processing
        $('#datatable').on('processing.dt', function(e, settings, processing) {
            if (processing) {
                console.log('DataTables processing started');
                // Ensure the processing div is visible and prominently displayed
                $('.dataTables_processing').show().css({
                    'display': 'block',
                    'opacity': '1'
                });
            } else {
                console.log('DataTables processing completed');
                // Delay hiding a bit to ensure users see it
                setTimeout(function() {
                    $('.dataTables_processing').fadeOut(300);
                }, 200);
            }
        });

        // Force processing indicator to be visible initially
        $('.dataTables_processing').show();
    });

    // Auto-fill jenis_kelas dan tingkat_pendidikan sesuai pilihan kelas
    $(document).ready(function() {
        $('#kelas').on('change', function() {
            var selected = $(this).find('option:selected');
            var kelasVal = selected.val();
            // Jenis kelas otomatis
            $('#jenis_kelas').val(kelasVal);
            // Tingkat pendidikan otomatis (ambil angka dari kelas, misal "1" dari "1A" atau "1")
            var tingkat = kelasVal.match(/\d+/);
            $('#tingkat_pendidikan').val(tingkat ? tingkat[0] : kelasVal);
        });
    });
</script>

<?= $this->endSection() ?>