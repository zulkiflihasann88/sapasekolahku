<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Tenaga Kependidikan &mdash; SDN Krengseng 02</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-content">
    <!-- Header Section -->
    <div class="profile-header-card">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="profile-avatar me-3">
                        <i class="bx bxs-group fs-2 text-white"></i>
                    </div>
                    <div class="text-white">
                        <h3 class="text-white mb-1 fw-bold">Tenaga Kependidikan</h3>
                        <p class="text-white-50 mb-0">Kelola data tenaga kependidikan sekolah</p>
                    </div>
                </div>
                <button class="btn btn-light btn-sm profile-btn px-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bx bx-plus fs-6 me-1"></i>Tambah Data
                </button>
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row mt-4">
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-primary rounded p-3 flex-shrink-0">
                            <i class="bx bxs-group fs-4 text-white"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-2">Total Tenaga Kependidikan</p>
                            <h4 class="mb-0"><?= count($tenaga_kependidikan) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-success rounded p-3 flex-shrink-0">
                            <i class="bx bx-male fs-4 text-white"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-2">Laki-laki</p>
                            <h4 class="mb-0"><?= count(array_filter($tenaga_kependidikan, fn($item) => $item->jenis_kelamin == 'L')) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-info rounded p-3 flex-shrink-0">
                            <i class="bx bx-female fs-4 text-white"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-2">Perempuan</p>
                            <h4 class="mb-0"><?= count(array_filter($tenaga_kependidikan, fn($item) => $item->jenis_kelamin == 'P')) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-warning rounded p-3 flex-shrink-0">
                            <i class="bx bx-briefcase fs-4 text-white"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-2">PNS</p>
                            <h4 class="mb-0"><?= count(array_filter($tenaga_kependidikan, fn($item) => $item->status_kepegawaian == 'PNS')) ?></h4>
                        </div>
                    </div>
                </div>
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
                                <i class="bx bx-list-ul text-primary fs-5 me-2"></i>Daftar Tenaga Kependidikan
                            </h5>
                            <p class="text-muted mb-0 small">Kelola data tenaga kependidikan sekolah</p>
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
                    <div class="table-responsive mx-2">
                        <table class="table table-hover mb-0" id="datatable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" width="50">No</th>
                                    <th>Nama Lengkap</th>
                                    <th>NIP/NUPTK</th>
                                    <th>Jabatan</th>
                                    <th>Status</th>
                                    <th>L/P</th>
                                    <th>Kontak</th>
                                    <th class="text-center" width="120">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($tenaga_kependidikan)) : ?>
                                    <?php $no = 1;
                                    foreach ($tenaga_kependidikan as $item) : ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-xs bg-light rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                        <i class="bx bx-user text-muted"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-semibold"><?= $item->nama_lengkap ?></h6>
                                                        <small class="text-muted"><?= $item->tempat_lahir ?? '-' ?>, <?= date('d/m/Y', strtotime($item->tanggal_lahir ?? '1970-01-01')) ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <?php if (!empty($item->nip)) : ?>
                                                        <small class="badge bg-primary mb-1 d-block">NIP: <?= $item->nip ?></small>
                                                    <?php endif; ?>
                                                    <?php if (!empty($item->nuptk)) : ?>
                                                        <small class="badge bg-secondary">NUPTK: <?= $item->nuptk ?></small>
                                                    <?php endif; ?>
                                                    <?php if (empty($item->nip) && empty($item->nuptk)) : ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?= $item->jabatan ?? '-' ?></span>
                                            </td>
                                            <td>
                                                <?php
                                                $status_class = '';
                                                switch ($item->status_kepegawaian ?? '') {
                                                    case 'PNS':
                                                        $status_class = 'bg-success';
                                                        break;
                                                    case 'Honorer':
                                                        $status_class = 'bg-warning';
                                                        break;
                                                    case 'Kontrak':
                                                        $status_class = 'bg-secondary';
                                                        break;
                                                    default:
                                                        $status_class = 'bg-light text-dark';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge <?= $status_class ?>"><?= $item->status_kepegawaian ?? '-' ?></span>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($item->jenis_kelamin == 'L') : ?>
                                                    <span class="badge bg-primary">L</span>
                                                <?php elseif ($item->jenis_kelamin == 'P') : ?>
                                                    <span class="badge bg-danger">P</span>
                                                <?php else : ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div>
                                                    <?php if (!empty($item->telepon)) : ?>
                                                        <small class="d-block"><i class="bx bx-phone me-1"></i><?= $item->telepon ?></small>
                                                    <?php endif; ?>
                                                    <?php if (!empty($item->email)) : ?>
                                                        <small class="d-block text-muted"><i class="bx bx-envelope me-1"></i><?= $item->email ?></small>
                                                    <?php endif; ?>
                                                    <?php if (empty($item->telepon) && empty($item->email)) : ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-outline-primary btn-sm edit-btn" onclick="editData(<?= $item->id_tenaga_kependidikan ?>)" title="Edit">
                                                        <i class="bx bx-edit-alt"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" onclick="deleteData(<?= $item->id_tenaga_kependidikan ?>)" title="Hapus">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bx bx-info-circle fs-1 mb-3 d-block"></i>
                                                <h6>Belum ada data tenaga kependidikan</h6>
                                                <p class="mb-0">Klik tombol "Tambah Data" untuk menambahkan data tenaga kependidikan.</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bx bx-plus-circle me-2"></i>
                    <span id="modal-title">Tambah Tenaga Kependidikan</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formTenagaKependidikan" method="POST">
                <input type="hidden" id="id_tenaga_kependidikan" name="id_tenaga_kependidikan" value="">
                <input type="hidden" id="form_action" value="create">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap" required>
                                <label for="nama_lengkap"><i class="bx bx-user me-2"></i>Nama Lengkap <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">Pilih...</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                <label for="jenis_kelamin"><i class="bx bx-male-female me-2"></i>Jenis Kelamin <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nip" name="nip" placeholder="NIP">
                                <label for="nip"><i class="bx bx-id-card me-2"></i>NIP</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nuptk" name="nuptk" placeholder="NUPTK">
                                <label for="nuptk"><i class="bx bx-id-card me-2"></i>NUPTK</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir" required>
                                <label for="tempat_lahir"><i class="bx bx-map-pin me-2"></i>Tempat Lahir <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                                <label for="tanggal_lahir"><i class="bx bx-calendar me-2"></i>Tanggal Lahir <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="agama" name="agama" required>
                                    <option value="">Pilih Agama...</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                                <label for="agama"><i class="bx bx-book me-2"></i>Agama <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Jabatan" required>
                                <label for="jabatan"><i class="bx bx-briefcase me-2"></i>Jabatan <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="status_kepegawaian" name="status_kepegawaian" required>
                                    <option value="">Pilih Status...</option>
                                    <option value="PNS">PNS</option>
                                    <option value="Honorer">Honorer</option>
                                    <option value="Kontrak">Kontrak</option>
                                </select>
                                <label for="status_kepegawaian"><i class="bx bx-award me-2"></i>Status Kepegawaian <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="tmt_kerja" name="tmt_kerja">
                                <label for="tmt_kerja"><i class="bx bx-calendar-check me-2"></i>TMT Kerja</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat" style="height: 80px" required></textarea>
                                <label for="alamat"><i class="bx bx-home me-2"></i>Alamat <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="tel" class="form-control" id="telepon" name="telepon" placeholder="Telepon">
                                <label for="telepon"><i class="bx bx-phone me-2"></i>Telepon</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                <label for="email"><i class="bx bx-envelope me-2"></i>Email</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <select class="form-select" id="pendidikan_terakhir" name="pendidikan_terakhir">
                                    <option value="">Pilih Pendidikan Terakhir</option>
                                    <?php foreach ($pendidikan as $pend): ?>
                                        <option value="<?= $pend->pendidikan ?>"><?= $pend->pendidikan ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="pendidikan_terakhir"><i class="bx bx-graduation me-2"></i>Pendidikan Terakhir</label>
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

<style>
    /* Pastikan table-responsive hanya mengatur overflow-x */
    .table-responsive {
        overflow-x: auto;
        margin-bottom: 0;
        /* Hapus height/overflow lain */
    }

    /* Pastikan DataTable lebar penuh dan tidak terpotong */
    #datatable {
        margin-bottom: 0;
        width: 100% !important;
    }

    /* DataTables scroll body agar tidak terpotong */
    .dataTables_scrollBody {
        overflow-x: auto !important;
        width: 100% !important;
        /* Hapus height jika ada, biarkan auto */
    }

    /* DataTables scroll wrapper agar tidak menutupi data */
    .dataTables_scroll {
        margin-bottom: 0.5rem;
    }

    .dataTables_wrapper .dataTables_paginate,
    .dataTables_wrapper .dataTables_info {
        padding-top: 1rem;
        background: #fff;
        position: relative;
        z-index: 1;
    }
</style>

<script>
    $(document).ready(function() {
        // Wait a bit for DOM to be fully ready
        setTimeout(function() {
            initializeComponents();
        }, 100);
    });

    function initializeComponents() {
        // Konfigurasi Toastr
        if (typeof toastr !== 'undefined') {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "4000"
            };
        }

        // Initialize DataTable with proper error handling
        initializeDataTable();

        // Initialize event handlers
        initializeEventHandlers();
    }

    // Helper function untuk Toastr
    function showToastr(message, title, type) {
        if (typeof toastr !== 'undefined') {
            toastr[type](message, title);
        } else {
            alert((title ? title + ': ' : '') + message);
        }
    }

    // Initialize DataTable function
    function initializeDataTable() {
        if (!$.fn.DataTable || !$('#datatable').length) {
            console.warn('DataTable not available or table not found');
            return;
        } // Destroy existing DataTable if it exists
        if ($.fn.DataTable.isDataTable('#datatable')) {
            try {
                $('#datatable').DataTable().destroy();
            } catch (e) {
                console.warn('Error destroying existing DataTable:', e);
            }
        }

        // Check table structure and data
        var $table = $('#datatable');
        var $tbody = $table.find('tbody');
        var $thead = $table.find('thead');
        var headerCols = $thead.find('th').length;
        var bodyRows = $tbody.find('tr').length;

        console.log('DataTable check - Header cols:', headerCols, 'Body rows:', bodyRows);

        // Validate table structure
        if (headerCols !== 8) {
            console.error('Invalid table structure - expected 8 columns, found:', headerCols);
            return;
        }

        // Check if we have real data or just "no data" message
        var $colspanCell = $tbody.find('td[colspan="8"]');
        var hasRealData = bodyRows > 0 && $colspanCell.length === 0;

        console.log('Has real data:', hasRealData, 'Colspan cells:', $colspanCell.length);

        // Only initialize DataTable if we have proper table structure
        if (hasRealData) {
            try {
                $('#datatable').DataTable({
                    responsive: true,
                    destroy: true,
                    paging: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    scrollX: true, // Aktifkan scroll horizontal
                    columnDefs: [{
                        targets: [0, 7], // No column and Action column
                        orderable: false,
                        searchable: false
                    }, {
                        targets: [5], // Gender column
                        className: 'text-center'
                    }, {
                        targets: [0], // No column
                        className: 'text-center'
                    }],
                    order: [
                        [1, 'asc']
                    ], // Sort by name
                    pageLength: 10,
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, "Semua"]
                    ],
                    language: {
                        "sProcessing": "Sedang memproses...",
                        "sLengthMenu": "Tampilkan _MENU_ entri",
                        "sZeroRecords": "Tidak ditemukan data yang sesuai",
                        "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                        "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                        "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                        "sInfoPostFix": "",
                        "sSearch": "Cari:",
                        "sUrl": "",
                        "oPaginate": {
                            "sFirst": "Pertama",
                            "sPrevious": "Sebelumnya",
                            "sNext": "Selanjutnya",
                            "sLast": "Terakhir"
                        }
                    }
                });
                console.log('DataTable initialized successfully');
            } catch (error) {
                console.error('DataTable initialization error:', error);
            }
        } else {
            console.log('No real data found - DataTable not initialized');
        }
    }

    function initializeEventHandlers() {
        // Form submit
        $('#formTenagaKependidikan').off('submit').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            let action = $('#form_action').val();
            let id = $('#id_tenaga_kependidikan').val();

            let url = '';
            if (action === 'create') {
                url = '<?= site_url('tenaga_kependidikan/create') ?>';
            } else {
                url = '<?= site_url('tenaga_kependidikan/update') ?>/' + id;
            }

            // Tambahkan CSRF token
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
                        $('#modalTambah').modal('hide');
                        showToastr(response.message, 'Sukses!', 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        let errorMessage = response.message || 'Gagal menyimpan data.';
                        if (response.errors) {
                            errorMessage += '\n' + Object.values(response.errors).join('\n');
                        }
                        showToastr(errorMessage, 'Error!', 'error');
                    }
                },
                error: function(xhr) {
                    let message = 'Gagal menyimpan data.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    showToastr(message, 'Error!', 'error');
                }
            });
        }); // Reset modal when opening for add
        $('#modalTambah').off('show.bs.modal').on('show.bs.modal', function(e) {
            // Hanya reset jika modal dibuka dari tombol tambah (bukan dari JS/edit)
            if (e.relatedTarget && $(e.relatedTarget).hasClass('profile-btn')) {
                resetForm();
            }
        });
        // Tampilkan tombol tambah lagi saat modal ditutup
        $('#modalTambah').off('hidden.bs.modal').on('hidden.bs.modal', function() {
            $('.profile-header-card .profile-btn').show();
        });
    }

    function resetForm() {
        $('#formTenagaKependidikan')[0].reset();
        $('#formTenagaKependidikan').find('input, select, textarea').val('');
        $('#id_tenaga_kependidikan').val('');
        $('#form_action').val('create');
        $('#modal-title').html('<i class="bx bx-plus-circle me-2"></i>Tambah Tenaga Kependidikan');
        $('.modal-header').removeClass('bg-warning').addClass('bg-primary');
        // Reset semua select dan trigger change agar UI update
        $('#jenis_kelamin').val('').trigger('change');
        $('#agama').val('').trigger('change');
        $('#status_kepegawaian').val('').trigger('change');
        $('#pendidikan_terakhir').val('').trigger('change');
        // Tampilkan tombol tambah di header lagi
        $('.profile-header-card .profile-btn').show();
    }

    function editData(id) {
        // Set form untuk edit mode
        $('#form_action').val('edit');
        $('#id_tenaga_kependidikan').val(id);
        $('#modal-title').html('<i class="bx bx-edit-alt me-2"></i>Edit Tenaga Kependidikan');
        $('.modal-header').removeClass('bg-primary').addClass('bg-warning');
        // Sembunyikan tombol tambah di header
        $('.profile-header-card .profile-btn').hide();

        // Ambil data dari server
        $.ajax({
            url: '<?= site_url('tenaga_kependidikan/getData') ?>/' + id,
            type: 'GET',
            dataType: 'JSON',
            success: function(response) {
                console.log('AJAX response:', response);
                if (response.status === 'success') {
                    let data = response.data;
                    console.log('Data for edit:', data);

                    // Populate form dengan data
                    $('#nama_lengkap').val(data.nama_lengkap || '');
                    $('#jenis_kelamin').val(data.jenis_kelamin || '').trigger('change');
                    $('#nip').val(data.nip || '');
                    $('#nuptk').val(data.nuptk || '');
                    $('#tempat_lahir').val(data.tempat_lahir || '');
                    // Format tanggal agar sesuai input type date (yyyy-mm-dd)
                    let tgl_lahir = data.tanggal_lahir ? data.tanggal_lahir.substring(0, 10) : '';
                    $('#tanggal_lahir').val(tgl_lahir);
                    $('#agama').val(data.agama || '').trigger('change');
                    $('#jabatan').val(data.jabatan || '');
                    $('#status_kepegawaian').val(data.status_kepegawaian || '').trigger('change');
                    let tmt_kerja = data.tmt_kerja ? data.tmt_kerja.substring(0, 10) : '';
                    $('#tmt_kerja').val(tmt_kerja);
                    $('#alamat').val(data.alamat || '');
                    $('#telepon').val(data.telepon || '');
                    $('#email').val(data.email || '');
                    // Jika value pendidikan_terakhir tidak ada di option, tambahkan option baru
                    let pendidikanVal = data.pendidikan_terakhir || '';
                    if (pendidikanVal && $("#pendidikan_terakhir option").filter(function() {
                            return $(this).val() === pendidikanVal;
                        }).length === 0) {
                        // Escape HTML untuk value dan text
                        let safeVal = $('<div>').text(pendidikanVal).html();
                        $('#pendidikan_terakhir').append('<option value="' + safeVal + '">' + safeVal + '</option>');
                    }
                    $('#pendidikan_terakhir').val(pendidikanVal).trigger('change');
                    // Tampilkan modal setelah data diisi
                    setTimeout(function() {
                        $('#modalTambah').modal('show');
                    }, 100);
                } else {
                    showToastr(response.message || 'Gagal mengambil data.', 'Error!', 'error');
                }
            },
            error: function(xhr) {
                let message = 'Gagal mengambil data untuk edit.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                showToastr(message, 'Error!', 'error');
            }
        });
    }

    function deleteData(id) {
        if (confirm('Yakin ingin menghapus data ini?')) {
            $.ajax({
                url: '<?= site_url('tenaga_kependidikan/delete') ?>/' + id,
                type: 'DELETE',
                success: function(response) {
                    showToastr('Data berhasil dihapus.', 'Sukses!', 'success');
                    setTimeout(() => location.reload(), 1500);
                },
                error: function(xhr) {
                    let message = 'Gagal menghapus data.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    showToastr(message, 'Error!', 'error');
                }
            });
        }
    }
</script>

<?= $this->endSection() ?>