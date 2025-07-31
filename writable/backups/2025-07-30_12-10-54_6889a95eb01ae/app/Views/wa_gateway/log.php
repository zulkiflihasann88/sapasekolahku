<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Log WhatsApp Gateway &mdash; Sekolahku</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Log WhatsApp Gateway</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= site_url('wa_gateway') ?>">WhatsApp Gateway</a></li>
                            <li class="breadcrumb-item active">Log</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Statistik -->
        <div class="row">
            <div class="col-lg-3">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Total Pesan</p>
                                <h4 class="mb-0" id="stat_total"><?= isset($pesan_terkirim) ? count($pesan_terkirim) : 0 ?></h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-message-square-detail font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Berhasil</p>
                                <h4 class="mb-0 text-success" id="stat_success">
                                    <?= isset($pesan_terkirim) ? count(array_filter($pesan_terkirim, function ($item) {
                                        return $item['status'] == 'success';
                                    })) : 0 ?>
                                </h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-success">
                                    <span class="avatar-title">
                                        <i class="bx bx-check-circle font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Pending</p>
                                <h4 class="mb-0 text-warning" id="stat_pending">
                                    <?= isset($pesan_terkirim) ? count(array_filter($pesan_terkirim, function ($item) {
                                        return $item['status'] == 'pending';
                                    })) : 0 ?>
                                </h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-warning">
                                    <span class="avatar-title">
                                        <i class="bx bx-time-five font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Gagal</p>
                                <h4 class="mb-0 text-danger" id="stat_failed">
                                    <?= isset($pesan_terkirim) ? count(array_filter($pesan_terkirim, function ($item) {
                                        return $item['status'] == 'gagal';
                                    })) : 0 ?>
                                </h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-danger">
                                    <span class="avatar-title">
                                        <i class="bx bx-x-circle font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter dan Pencarian -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Filter Log</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="filter_status" class="form-label">Status</label>
                                    <select class="form-select" id="filter_status" onchange="applyFilter()">
                                        <option value="">Semua Status</option>
                                        <option value="success">Berhasil</option>
                                        <option value="pending">Pending</option>
                                        <option value="gagal">Gagal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="filter_date" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="filter_date" onchange="applyFilter()">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="search_number" class="form-label">Cari Nomor</label>
                                    <input type="text" class="form-control" id="search_number" placeholder="Masukkan nomor tujuan" onkeyup="applyFilter()">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div>
                                        <button type="button" class="btn btn-secondary w-100" onclick="resetFilter()">
                                            <i class="mdi mdi-filter-remove me-1"></i>Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="mdi mdi-message-text-outline me-2"></i>
                            Log Pesan Terkirim
                        </h4>
                        <div>
                            <button type="button" class="btn btn-primary btn-sm" onclick="refreshLog()">
                                <i class="mdi mdi-refresh me-1"></i>Refresh
                            </button>
                            <button type="button" class="btn btn-warning btn-sm" onclick="clearAllLogs()">
                                <i class="mdi mdi-delete-sweep me-1"></i>Hapus Semua
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="mdi mdi-information me-2"></i>
                            Log pesan WhatsApp yang dikirim melalui sistem. Menampilkan 100 pesan terakhir.
                        </div>

                        <div id="logContainer">
                            <?= $this->include('wa_gateway/pesan_terkirim') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Setup CSRF token untuk semua AJAX requests
    $.ajaxSetup({
        beforeSend: function(xhr, settings) {
            if (settings.type == 'POST' && !this.crossDomain) {
                const csrfName = $('meta[name=csrf-token-name]').attr('content') || 'csrf_test_name';
                const csrfHash = $('meta[name=csrf-token]').attr('content') || '';
                if (csrfHash && !settings.data) {
                    settings.data = {};
                }
                if (csrfHash && typeof settings.data === 'string') {
                    settings.data += '&' + csrfName + '=' + csrfHash;
                } else if (csrfHash && typeof settings.data === 'object') {
                    settings.data[csrfName] = csrfHash;
                }
            }
        }
    });

    // Fungsi untuk memuat ulang log
    function refreshLog() {
        $.get('<?= site_url('wa_gateway/pesan_terkirim') ?>', function(data) {
            $('#logContainer').html(data);
            updateStats();
        });
    }

    // Fungsi untuk menghapus semua log
    function clearAllLogs() {
        Swal.fire({
            title: 'Hapus Semua Log?',
            text: 'Semua log pesan akan dihapus secara permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus Semua!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Get CSRF token
                const csrfName = $('meta[name=csrf-token-name]').attr('content') || 'csrf_test_name';
                const csrfHash = $('meta[name=csrf-token]').attr('content') || '';

                const postData = {};

                // Add CSRF token if available
                if (csrfHash) {
                    postData[csrfName] = csrfHash;
                }

                $.ajax({
                    url: '<?= site_url('wa_gateway/clearAllLogs') ?>',
                    type: 'POST',
                    data: postData,
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            Swal.fire('Berhasil', 'Semua log berhasil dihapus', 'success');
                            refreshLog();
                        } else {
                            Swal.fire('Error', data.message || 'Gagal menghapus log', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error details:', xhr.responseText);
                        if (xhr.status === 403) {
                            Swal.fire('Error', 'Akses ditolak. Silakan refresh halaman dan coba lagi.', 'error');
                        } else {
                            Swal.fire('Error', 'Gagal menghapus log: ' + error, 'error');
                        }
                    }
                });
            }
        });
    }

    // Fungsi untuk menerapkan filter
    function applyFilter() {
        const status = $('#filter_status').val();
        const date = $('#filter_date').val();
        const number = $('#search_number').val();

        // Implementasi filter di sisi client untuk performa yang lebih baik
        $('tbody tr').each(function() {
            let show = true;
            const row = $(this);

            // Filter berdasarkan status
            if (status && !row.find('.badge').text().toLowerCase().includes(status.toLowerCase())) {
                show = false;
            }

            // Filter berdasarkan tanggal
            if (date) {
                const rowDate = row.find('td:first .fw-medium').text();
                const filterDate = new Date(date).toLocaleDateString('id-ID');
                if (!rowDate.includes(filterDate.replace(/\//g, '/'))) {
                    show = false;
                }
            }

            // Filter berdasarkan nomor
            if (number && !row.find('td:nth-child(2) .badge').text().includes(number)) {
                show = false;
            }

            row.toggle(show);
        });
    }

    // Fungsi untuk reset filter
    function resetFilter() {
        $('#filter_status').val('');
        $('#filter_date').val('');
        $('#search_number').val('');
        $('tbody tr').show();
    }

    // Fungsi untuk update statistik
    function updateStats() {
        const rows = $('tbody tr:visible');
        const total = rows.length;
        const success = rows.filter(':contains("Berhasil")').length;
        const pending = rows.filter(':contains("Pending")').length;
        const failed = rows.filter(':contains("Gagal")').length;

        $('#stat_total').text(total);
        $('#stat_success').text(success);
        $('#stat_pending').text(pending);
        $('#stat_failed').text(failed);
    }

    // Auto refresh setiap 30 detik
    setInterval(refreshLog, 30000);
</script>

<?= $this->endSection() ?>