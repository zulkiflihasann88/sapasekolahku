<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .select-siswa {
        border-radius: 10px !important;
        padding: 12px !important;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        background: #ffffff !important;
        color: #495057 !important;
        font-size: 14px !important;
        min-height: 48px !important;
    }

    .select-siswa:focus,
    .select-siswa:hover {
        border-color: #667eea !important;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
        transform: translateY(-2px);
        background: #f8f9fa !important;
        color: #495057 !important;
    }

    .select-siswa option {
        background: #ffffff !important;
        color: #495057 !important;
        padding: 8px 12px !important;
        line-height: 1.4 !important;
        white-space: normal !important;
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
    }

    .select-siswa option:hover,
    .select-siswa option:focus,
    .select-siswa option:selected {
        background: #f8f9fa !important;
        color: #495057 !important;
        font-weight: 500 !important;
    }

    /* Fix untuk dropdown yang dapat terbaca */
    .select-siswa:focus option:checked,
    .select-siswa option:checked {
        background: #667eea !important;
        color: #ffffff !important;
        font-weight: bold !important;
    }

    .btn-lg {
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-lg:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    .card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .alert {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .form-floating {
        position: relative;
    }

    .form-floating>.form-select {
        padding-top: 1.625rem;
        padding-bottom: 0.625rem;
    }

    .search-highlight {
        animation: highlight 2s ease-in-out;
    }

    @keyframes highlight {
        0% {
            background-color: rgba(102, 126, 234, 0.1);
        }

        50% {
            background-color: rgba(102, 126, 234, 0.3);
        }

        100% {
            background-color: transparent;
        }
    }

    /* Responsive fixes untuk info siswa */
    .info-siswa-responsive {
        word-wrap: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
        max-width: 100%;
        white-space: normal;
    }

    .info-nama-container {
        min-height: 40px;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .select-siswa {
            font-size: 12px !important;
            padding: 10px !important;
        }

        .col-md-3 {
            margin-bottom: 10px;
        }

        .info-nama-container {
            min-height: auto;
        }
    }

    /* Additional Sweet Alert Centering Fixes */
    .swal2-container-center {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        z-index: 2050 !important;
    }

    .swal2-popup {
        position: relative !important;
        transform: none !important;
        margin: 0 !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
        border-radius: 12px !important;
    }

    .swal2-title {
        font-size: 1.5rem !important;
        font-weight: 600 !important;
    }

    .swal2-content {
        font-size: 1rem !important;
        line-height: 1.5 !important;
    }

    .swal2-actions {
        gap: 10px !important;
    }

    .swal2-styled.swal2-confirm {
        background-color: #667eea !important;
        border: none !important;
        border-radius: 8px !important;
        padding: 10px 20px !important;
        font-weight: 500 !important;
    }

    .swal2-styled.swal2-cancel {
        background-color: #dc3545 !important;
        border: none !important;
        border-radius: 8px !important;
        padding: 10px 20px !important;
        font-weight: 500 !important;
    }

    /* Animation for Sweet Alert */
    .animated.fadeIn {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: scale(0.9);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Cetak Kartu Siswa</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Akademik</a></li>
                            <li class="breadcrumb-item active">Cetak Kartu Siswa</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title --> <!-- Search Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-primary shadow-sm">
                    <div class="card-header bg-gradient-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-id-card me-2"></i>Pilih Siswa untuk Cetak Kartu
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="select_siswa" class="form-label text-primary fw-bold mb-2">
                                        <i class="bx bx-user me-1"></i>Pilih Siswa
                                    </label>
                                    <select class="form-select form-select-lg select-siswa" id="select_siswa" style="font-size: 14px; background: linear-gradient(45deg, #f8f9fa, #e9ecef); border: 2px solid #dee2e6; min-height: 58px; padding: 15px 12px;">
                                        <option value="">-- Pilih Siswa untuk Cetak Kartu --</option>
                                        <?php foreach ($siswa as $s): ?>
                                            <option value="<?= $s->id_siswa ?>"
                                                data-nisn="<?= $s->nisn ?>"
                                                data-nis="<?= $s->nis ?? '-' ?>"
                                                data-kelas="<?= $s->nama_rombel ?>"
                                                style="padding: 10px; line-height: 1.4; word-wrap: break-word;">
                                                <?= $s->nama_lengkap ?> - <?= $s->nisn ?> (<?= $s->nama_rombel ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-grid gap-3">
                                    <button type="button" class="btn btn-info btn-lg shadow-sm" id="btn_preview" disabled style="border-radius: 12px; background: linear-gradient(45deg, #17a2b8, #138496);">
                                        <i class="bx bx-show me-2"></i>👁️ Preview Kartu
                                    </button>
                                    <button type="button" class="btn btn-primary btn-lg shadow-sm" id="btn_cetak" disabled style="border-radius: 12px; background: linear-gradient(45deg, #667eea, #764ba2);">
                                        <i class="bx bx-printer me-2"></i>🖨️ Cetak Kartu
                                    </button>
                                </div>
                            </div>
                        </div> <!-- Info Siswa Terpilih -->
                        <div class="row mt-3" id="info_siswa" style="display: none;">
                            <div class="col-12">
                                <div class="alert alert-light border-primary shadow-sm" role="alert" style="border-radius: 12px; border-left: 5px solid #667eea;">
                                    <h6 class="alert-heading mb-3 text-primary fw-bold">
                                        <i class="bx bx-info-circle me-2"></i>Informasi Siswa Terpilih
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <div class="p-2 bg-light rounded info-nama-container">
                                                <small class="text-muted d-block mb-1">📝 Nama Lengkap:</small>
                                                <strong id="info_nama" class="text-dark info-siswa-responsive">-</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="p-2 bg-light rounded">
                                                <small class="text-muted d-block mb-1">🆔 NISN:</small>
                                                <strong id="info_nisn" class="text-dark">-</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="p-2 bg-light rounded">
                                                <small class="text-muted d-block mb-1">🎯 NIS:</small>
                                                <strong id="info_nis" class="text-dark">-</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="p-2 bg-light rounded">
                                                <small class="text-muted d-block mb-1">🏫 Kelas:</small>
                                                <strong id="info_kelas" class="text-dark">-</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- Filter untuk Cetak Masal -->
                        <div class="row mt-4 pt-4 border-top">
                            <div class="col-12">
                                <h6 class="text-primary mb-3 fw-bold d-flex align-items-center">
                                    <i class="bx bx-printer me-2 fs-5"></i>🎯 Cetak Masal Berdasarkan Kelas
                                </h6>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="rombel_id" class="form-label text-primary fw-bold mb-2">
                                        <i class="bx bx-group me-1"></i>🏫 Rombel
                                    </label>
                                    <select class="form-select form-select-lg" id="rombel_id" name="rombel_id" style="border-radius: 10px; border: 2px solid #dee2e6;">
                                        <option value="">Pilih Rombel</option>
                                        <?php foreach ($rombel as $r): ?>
                                            <option value="<?= $r->id_rombel ?>"><?= $r->kelas ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tapel_id" class="form-label text-primary fw-bold mb-2">
                                        <i class="bx bx-calendar me-1"></i>📅 Tahun Pelajaran
                                    </label>
                                    <select class="form-select form-select-lg" id="tapel_id" name="tapel_id" style="border-radius: 10px; border: 2px solid #dee2e6;">
                                        <option value="">Pilih Tahun Pelajaran</option>
                                        <?php foreach ($tapel as $t): ?>
                                            <option value="<?= $t->id_tahunajaran ?>"><?= $t->ket_tahun ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-success btn-lg w-100 h-100 shadow-sm" id="btn_cetak_masal" style="border-radius: 12px; background: linear-gradient(45deg, #28a745, #20c997); min-height: 58px;">
                                    <i class="bx bx-printer me-2"></i>🖨️ Cetak Masal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upload Template Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-upload me-2"></i>Upload Template Kartu
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="<?= site_url('cetak_kartu_siswa/uploadTemplate') ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="template_depan" class="form-label">Template Kartu Depan</label>
                                        <input type="file" class="form-control" id="template_depan" name="template_depan" accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG, maksimal 2MB</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="template_belakang" class="form-label">Template Kartu Belakang</label>
                                        <input type="file" class="form-control" id="template_belakang" name="template_belakang" accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG, maksimal 2MB</small>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-3">
                            <h6 class="text-success mb-3">
                                <i class="bx bx-image me-2"></i>Upload Logo Kop Surat
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="logo_sekolah" class="form-label">Logo Sekolah</label>
                                        <input type="file" class="form-control" id="logo_sekolah" name="logo_sekolah" accept="image/*">
                                        <small class="text-muted">Format: PNG (transparent), maksimal 1MB</small>
                                        <?php if (file_exists(FCPATH . 'uploads/logo_sekolah.png')): ?>
                                            <div class="mt-2">
                                                <img src="<?= base_url('uploads/logo_sekolah.png') ?>" alt="Logo Sekolah" style="width: 30px; height: 30px; object-fit: contain;">
                                                <small class="text-success ms-2">✓ Logo sudah diupload</small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="logo_pemda" class="form-label">Logo Pemda</label>
                                        <input type="file" class="form-control" id="logo_pemda" name="logo_pemda" accept="image/*">
                                        <small class="text-muted">Format: PNG (transparent), maksimal 1MB</small>
                                        <?php if (file_exists(FCPATH . 'uploads/logo_pemda.png')): ?>
                                            <div class="mt-2">
                                                <img src="<?= base_url('uploads/logo_pemda.png') ?>" alt="Logo Pemda" style="width: 30px; height: 30px; object-fit: contain;">
                                                <small class="text-success ms-2">✓ Logo sudah diupload</small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success">
                                        <i class="bx bx-upload me-2"></i>Upload Template
                                    </button>
                                    <button type="button" class="btn btn-warning ms-2" id="btn_reset_template">
                                        <i class="bx bx-refresh me-2"></i>Reset ke Default
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for better search experience
            try {
                $('#select_siswa').select2({
                    placeholder: "🔍 Ketik nama siswa, NISN, atau NIS untuk mencari...",
                    allowClear: true,
                    width: '100%',
                    dropdownAutoWidth: true,
                    language: {
                        noResults: function() {
                            return "❌ Tidak ada siswa yang ditemukan";
                        },
                        searching: function() {
                            return "🔍 Mencari siswa...";
                        },
                        loadingMore: function() {
                            return "📄 Memuat lebih banyak hasil...";
                        }
                    },
                    templateResult: function(data) {
                        if (data.loading) return data.text;

                        if (data.element && $(data.element).data('nisn')) {
                            var nisn = $(data.element).data('nisn');
                            var nis = $(data.element).data('nis') || '-';
                            var kelas = $(data.element).data('kelas');

                            return $('<div class="select2-result-siswa">' +
                                '<div class="fw-bold text-primary">' + data.text.split(' - ')[0] + '</div>' +
                                '<small class="text-muted">NISN: ' + nisn + ' | NIS: ' + nis + ' | Kelas: ' + kelas + '</small>' +
                                '</div>');
                        }
                        return data.text;
                    }
                });

                // Initialize Select2 after DOM is ready
                setTimeout(function() {
                    $('#select_siswa').trigger('change');
                }, 100); // Custom CSS for Select2
                $('<style>').prop('type', 'text/css').html(`
                    .select2-container--bootstrap-5 .select2-selection--single {
                        border-radius: 10px !important;
                        border: 2px solid #dee2e6 !important;
                        height: calc(3.5rem + 2px) !important;
                        padding: 12px !important;
                        background: #ffffff !important;
                        color: #495057 !important;
                    }
                    .select2-container--bootstrap-5 .select2-selection--single:focus,
                    .select2-container--bootstrap-5 .select2-selection--single:hover {
                        border-color: #667eea !important;
                        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
                        background: #f8f9fa !important;
                    }
                    .select2-container--bootstrap-5 .select2-selection__rendered {
                        color: #495057 !important;
                        font-weight: 500 !important;
                        line-height: 1.5 !important;
                        padding-left: 0 !important;
                        padding-right: 30px !important;
                        padding-top: 0 !important;
                        margin-top: 0 !important;
                    }
                    .select2-container--bootstrap-5 .select2-selection__placeholder {
                        color: #6c757d !important;
                        font-style: italic !important;
                        margin-top: 0 !important;
                        padding-top: 0 !important;
                    }
                    .select2-container--bootstrap-5 .select2-selection__arrow {
                        right: 12px !important;
                        top: 50% !important;
                        transform: translateY(-50%) !important;
                    }
                    .select2-result-siswa {
                        padding: 10px 15px !important;
                        border-bottom: 1px solid #eee !important;
                        background: #ffffff !important;
                        color: #495057 !important;
                        transition: all 0.2s ease !important;
                    }
                    .select2-result-siswa:hover,
                    .select2-results__option--highlighted .select2-result-siswa {
                        background: #f8f9fa !important;
                        color: #495057 !important;
                        border-left: 4px solid #667eea !important;
                    }
                    .select2-dropdown {
                        border-radius: 10px !important;
                        border: 2px solid #667eea !important;
                        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
                        z-index: 9999 !important;
                    }
                    .select2-results__option {
                        background: #ffffff !important;
                        color: #495057 !important;
                        padding: 0 !important;
                    }
                    .select2-results__option--highlighted {
                        background: #f8f9fa !important;
                        color: #495057 !important;
                    }
                `).appendTo('head');

            } catch (e) {
                console.log('Select2 not available, using standard select');
            } // Handle siswa selection (works for both select2 and standard select)
            $('#select_siswa').on('change select2:select', function(e) {
                var selectedValue = $(this).val();
                var selectedOption = $(this).find('option:selected');

                if (selectedValue) {
                    // Add highlight animation
                    $('#info_siswa').addClass('search-highlight');

                    // Show siswa info
                    var namaLengkap = selectedOption.text().split(' - ')[0];
                    $('#info_nama').html('<i class="bx bx-user me-1"></i>' + namaLengkap);
                    $('#info_nisn').html('<i class="bx bx-id-card me-1"></i>' + selectedOption.data('nisn'));
                    $('#info_nis').html('<i class="bx bx-credit-card me-1"></i>' + (selectedOption.data('nis') || '-'));
                    $('#info_kelas').html('<i class="bx bx-building me-1"></i>' + selectedOption.data('kelas'));

                    $('#info_siswa').slideDown(300);
                    $('#btn_preview, #btn_cetak').prop('disabled', false)
                        .removeClass('btn-secondary').addClass('shadow-sm');

                    // Remove highlight after animation
                    setTimeout(() => {
                        $('#info_siswa').removeClass('search-highlight');
                    }, 2000);
                } else {
                    // Hide siswa info
                    $('#info_siswa').slideUp(300);
                    $('#btn_preview, #btn_cetak').prop('disabled', true)
                        .removeClass('shadow-sm');
                }
            }); // Clear selection
            $('#select_siswa').on('select2:clear', function() {
                $('#info_siswa').slideUp(300);
                $('#btn_preview, #btn_cetak').prop('disabled', true).removeClass('shadow-sm');
            });

            // Preview button with loading state
            $('#btn_preview').click(function() {
                var siswaId = $('#select_siswa').val();
                if (siswaId) {
                    var originalText = $(this).html();
                    $(this).html('<i class="bx bx-loader-alt bx-spin me-2"></i>Loading...');

                    setTimeout(() => {
                        window.open('<?= site_url("cetak_kartu_siswa/preview/") ?>' + siswaId, '_blank');
                        $(this).html(originalText);
                    }, 800);
                }
            });

            // Cetak button with loading state
            $('#btn_cetak').click(function() {
                var siswaId = $('#select_siswa').val();
                if (siswaId) {
                    var originalText = $(this).html();
                    $(this).html('<i class="bx bx-loader-alt bx-spin me-2"></i>Mencetak...');

                    setTimeout(() => {
                        window.open('<?= site_url("cetak_kartu_siswa/cetak/") ?>' + siswaId, '_blank');
                        $(this).html(originalText);
                    }, 800);
                }
            });

            // Cetak Masal with enhanced validation
            $('#btn_cetak_masal').click(function() {
                var rombel_id = $('#rombel_id').val();
                var tapel_id = $('#tapel_id').val();

                if (rombel_id === '' || tapel_id === '') {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: '⚠️ Pilih Rombel dan Tahun Pelajaran',
                            text: 'Harap pilih rombel dan tahun pelajaran terlebih dahulu',
                            confirmButtonColor: '#667eea',
                            confirmButtonText: 'OK, Mengerti'
                        });
                    } else {
                        alert('Pilih rombel dan tahun pelajaran terlebih dahulu');
                    }
                    return;
                }

                // Loading state
                var originalText = $(this).html();
                $(this).html('<i class="bx bx-loader-alt bx-spin me-2"></i>Memproses...');

                // Create and submit form
                var form = $('<form>', {
                    method: 'POST',
                    action: '<?= site_url("cetak_kartu_siswa/cetakMasal") ?>',
                    target: '_blank'
                });

                form.append($('<input>', {
                    type: 'hidden',
                    name: 'rombel_id',
                    value: rombel_id
                }));

                form.append($('<input>', {
                    type: 'hidden',
                    name: 'tapel_id',
                    value: tapel_id
                }));

                $('body').append(form);
                form.submit();
                form.remove();

                // Reset button after delay
                setTimeout(() => {
                    $(this).html(originalText);
                }, 2000);
            }); // Reset Template with confirmation
            $('#btn_reset_template').click(function() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: '🔄 Reset Template?',
                        html: '<p class="mb-3">Template akan dikembalikan ke pengaturan default</p>' +
                            '<div class="alert alert-warning mb-0">' +
                            '<i class="fas fa-exclamation-triangle"></i> ' +
                            'Semua template dan logo yang telah diupload akan dihapus!' +
                            '</div>',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#667eea',
                        cancelButtonColor: '#dc3545',
                        confirmButtonText: '<i class="fas fa-check"></i> Ya, Reset!',
                        cancelButtonText: '<i class="fas fa-times"></i> Batal',
                        reverseButtons: true,
                        position: 'center',
                        backdrop: true,
                        allowOutsideClick: false,
                        customClass: {
                            popup: 'animated fadeIn',
                            confirmButton: 'btn btn-primary mx-2',
                            cancelButton: 'btn btn-secondary mx-2'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            resetTemplate();
                        }
                    });
                } else {
                    if (confirm('Yakin ingin reset template ke default? Semua template dan logo yang telah diupload akan dihapus!')) {
                        resetTemplate();
                    }
                }
            });

            function resetTemplate() {
                // Show loading state
                const loadingToast = Swal.fire({
                    title: '🔄 Mereset Template...',
                    text: 'Mohon tunggu sebentar',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajaxSetup({
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    }
                });

                $.ajax({
                    url: '<?= site_url("cetak_kartu_siswa/resetTemplate") ?>',
                    type: 'POST',
                    dataType: 'json',
                    timeout: 10000, // 10 second timeout
                    success: function(response) {
                        loadingToast.close();

                        if (response.success) {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'success',
                                    title: '✅ Berhasil!',
                                    text: response.message || 'Template berhasil direset',
                                    confirmButtonColor: '#667eea',
                                    timer: 3000,
                                    timerProgressBar: true,
                                    position: 'center',
                                    backdrop: true,
                                    allowOutsideClick: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                alert('Template berhasil direset');
                                location.reload();
                            }
                        } else {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'error',
                                    title: '❌ Error!',
                                    text: response.message || 'Gagal mereset template',
                                    confirmButtonColor: '#dc3545',
                                    position: 'center',
                                    backdrop: true
                                });
                            } else {
                                alert('Error: ' + (response.message || 'Gagal mereset template'));
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        loadingToast.close();

                        let errorMessage = 'Terjadi kesalahan saat reset template';

                        if (xhr.status === 403) {
                            errorMessage = 'Akses ditolak. Silakan login ulang.';
                        } else if (xhr.status === 404) {
                            errorMessage = 'Halaman tidak ditemukan.';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Kesalahan server internal.';
                        } else if (status === 'timeout') {
                            errorMessage = 'Request timeout. Silakan coba lagi.';
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: '❌ Error!',
                                text: errorMessage,
                                confirmButtonColor: '#dc3545',
                                position: 'center',
                                backdrop: true,
                                footer: xhr.status ? `Status: ${xhr.status}` : ''
                            });
                        } else {
                            alert('Error: ' + errorMessage);
                        }

                        // If 403, redirect to login after a delay
                        if (xhr.status === 403) {
                            setTimeout(() => {
                                window.location.href = '<?= site_url("login") ?>';
                            }, 2000);
                        }
                    }
                });
            }
        });
    </script>

    <?= $this->endSection() ?>