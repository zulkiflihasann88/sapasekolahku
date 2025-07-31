<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>System Update &mdash; Sekolahku</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">System Update</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">System Update</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Update Status Alert -->
        <div class="row">
            <div class="col-12">
                <div id="update_status_alert" class="alert d-none" role="alert">
                    <i class="mdi mdi-information me-2"></i>
                    <span id="update_status_message"></span>
                </div>
            </div>
        </div>

        <!-- Version Information -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="mdi mdi-information-outline me-2"></i>
                            Informasi Versi
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Versi Saat Ini</label>
                                    <div class="fw-bold h5 text-primary" id="current_version"><?= isset($currentVersion) ? $currentVersion : (isset($current_version) ? $current_version : '-') ?></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Versi Terbaru</label>
                                    <div class="fw-bold h5" id="latest_version"><?= isset($latestVersion) ? $latestVersion : (isset($latest_version) ? $latest_version : '-') ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Update Terakhir</label>
                                    <div class="text-dark" id="last_update"><?= isset($lastUpdate) ? $lastUpdate : (isset($last_update) ? $last_update : '-') ?></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Status Git</label>
                                    <div id="git_status">
                                        <span class="badge <?= (isset($gitStatus) ? $gitStatus : (isset($git_status) ? $git_status : '')) === 'Clean' ? 'bg-success' : 'bg-warning' ?>">
                                            <?= isset($gitStatus) ? $gitStatus : (isset($git_status) ? $git_status : '-') ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Status Update</label>
                                    <div id="update_status">
                                        <?php if ((isset($updateAvailable) ? $updateAvailable : (isset($update_available) ? $update_available : false))): ?>
                                            <span class="badge bg-warning">
                                                <i class="mdi mdi-download me-1"></i>Update Tersedia
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-success">
                                                <i class="mdi mdi-check-circle me-1"></i>Versi Terbaru
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="mdi mdi-cog-outline me-2"></i>
                            Kontrol Update
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="mdi mdi-information me-2"></i>
                            <strong>Perhatian:</strong> Pastikan melakukan backup sebelum update. Proses update akan membuat backup otomatis.
                        </div>

                        <div class="d-grid gap-3">
                            <button type="button" class="btn btn-outline-primary" onclick="checkForUpdates()">
                                <i class="mdi mdi-refresh me-1"></i>
                                Cek Update
                            </button>

                            <button type="button" class="btn btn-success" onclick="performUpdate()"
                                id="update_btn" <?= !(isset($updateAvailable) ? $updateAvailable : (isset($update_available) ? $update_available : false)) ? 'disabled' : '' ?>>
                                <i class="mdi mdi-download me-1"></i>
                                Lakukan Update
                            </button>

                            <button type="button" class="btn btn-warning" onclick="showBackupList()">
                                <i class="mdi mdi-backup-restore me-1"></i>
                                Kelola Backup
                            </button>

                            <button type="button" class="btn btn-outline-secondary" onclick="viewUpdateLog()">
                                <i class="mdi mdi-file-document-outline me-1"></i>
                                Log Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Configuration -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="mdi mdi-github me-2"></i>
                            Konfigurasi GitHub
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <i class="mdi mdi-alert me-2"></i>
                            <strong>Setup Repository:</strong> Pastikan konfigurasi GitHub sudah benar di file .env
                        </div>

                        <div class="alert alert-info">
                            <i class="mdi mdi-information me-2"></i>
                            <strong>Format Versioning:</strong> Aplikasi menggunakan format tahun-based (2025.1, 2025.2, 2026.1)
                            <br><small>YYYY.N dimana YYYY = tahun, N = nomor rilis dalam tahun tersebut</small>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <h6 class="text-muted mb-3">Konfigurasi yang Diperlukan (.env):</h6>
                                <div class="bg-light p-3 rounded">
                                    <code>
                                        GITHUB_TOKEN=your_github_token_here<br>
                                        GITHUB_REPO_URL=https://github.com/username/sekolahku.git<br>
                                        GITHUB_BRANCH=main
                                    </code>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h6 class="text-muted mb-3">Langkah Setup:</h6>
                                <ol class="text-sm">
                                    <li>Buat repository GitHub (public/private)</li>
                                    <li>Generate Personal Access Token di GitHub</li>
                                    <li>Set permission: repo, workflow</li>
                                    <li>Tambahkan konfigurasi ke .env</li>
                                    <li>Push kode ke repository</li>
                                </ol>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="button" class="btn btn-outline-info" onclick="testGitConnection()">
                                <i class="mdi mdi-connection me-1"></i>
                                Test Koneksi Git
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Progress Modal -->
        <div class="modal fade" id="updateProgressModal" tabindex="-1" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="mdi mdi-download me-2"></i>
                            Proses Update
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div id="update_progress_text" class="text-center">
                            Memulai proses update...
                        </div>
                        <div class="progress mt-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%" id="update_progress_bar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let updateProgress = 0;
    let updateModal;

    $(document).ready(function() {
        updateModal = new bootstrap.Modal(document.getElementById('updateProgressModal'));
        // Tidak auto cek update saat halaman dibuka
    });

    function checkForUpdates() {
        showLoading('Mengecek update...');

        $.get('<?= site_url('system-update/check-update') ?>', function(data) {
            hideLoading();

            if (data.success) {
                // Update tampilan versi
                $('#current_version').text(data.current_version);
                $('#latest_version').text(data.latest_version);

                // Update status
                updateStatusDisplay(data.update_available);

                Swal.fire({
                    title: data.update_available ? 'Update Tersedia!' : 'Sudah Terbaru',
                    text: data.message,
                    icon: data.update_available ? 'info' : 'success'
                });
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        }).fail(function() {
            hideLoading();
            Swal.fire('Error', 'Gagal mengecek update', 'error');
        });
    }

    function performUpdate() {
        Swal.fire({
            title: 'Konfirmasi Update',
            text: 'Proses update akan membuat backup otomatis dan memperbarui aplikasi. Lanjutkan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Update!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                startUpdateProcess();
            }
        });
    }

    function startUpdateProcess() {
        updateModal.show();
        updateProgress = 0;
        updateProgressBar(20, 'Membuat backup...');


        // Ambil CSRF token dari meta tag atau hidden input
        let csrfName = '<?= csrf_token() ?>';
        let csrfHash = '<?= csrf_hash() ?>';

        let postData = {};
        postData[csrfName] = csrfHash;

        $.post('<?= site_url('system-update/perform-update') ?>', postData, function(data) {
            if (data.success) {
                updateProgressBar(100, 'Update selesai!');
                setTimeout(() => {
                    updateModal.hide();
                    Swal.fire({
                        title: 'Update Berhasil!',
                        text: `Aplikasi berhasil diupdate ke versi ${data.new_version}`,
                        icon: 'success',
                        confirmButtonText: 'Reload Halaman'
                    }).then(() => {
                        location.reload();
                    });
                }, 1000);
            } else {
                updateModal.hide();
                Swal.fire('Update Gagal', data.message, 'error');
            }
        }).fail(function() {
            updateModal.hide();
            Swal.fire('Error', 'Gagal melakukan update', 'error');
        });

        // Simulate progress
        simulateProgress();
    }

    function simulateProgress() {
        const steps = [{
                progress: 40,
                text: 'Mengunduh perubahan...'
            },
            {
                progress: 60,
                text: 'Menjalankan migrasi...'
            },
            {
                progress: 80,
                text: 'Membersihkan cache...'
            },
            {
                progress: 95,
                text: 'Finalizing...'
            }
        ];

        let stepIndex = 0;
        const interval = setInterval(() => {
            if (stepIndex < steps.length) {
                const step = steps[stepIndex];
                updateProgressBar(step.progress, step.text);
                stepIndex++;
            } else {
                clearInterval(interval);
            }
        }, 2000);
    }

    function updateProgressBar(progress, text) {
        $('#update_progress_bar').css('width', progress + '%');
        $('#update_progress_text').text(text);
    }

    function testGitConnection() {
        showLoading('Testing koneksi Git dan GitHub...');

        $.get('<?= site_url('system-update/test-connection') ?>', function(data) {
            hideLoading();

            if (data.success) {
                // Create detailed test results HTML
                let resultsHtml = '<div class="test-results">';
                resultsHtml += `<div class="mb-3 text-center">`;
                resultsHtml += `<div class="badge ${data.all_passed ? 'bg-success' : 'bg-warning'} fs-6">`;
                resultsHtml += `${data.summary.passed}/${data.summary.total} Tests Passed (${data.summary.percentage}%)`;
                resultsHtml += `</div></div>`;

                // Add each test result
                Object.keys(data.tests).forEach(testKey => {
                    const test = data.tests[testKey];
                    const iconClass = test.status ? 'mdi-check-circle text-success' : 'mdi-close-circle text-danger';
                    const statusText = test.status ? 'PASS' : 'FAIL';

                    resultsHtml += `<div class="d-flex align-items-start mb-2 p-2 border rounded">`;
                    resultsHtml += `<i class="mdi ${iconClass} me-2 mt-1"></i>`;
                    resultsHtml += `<div class="flex-grow-1">`;
                    resultsHtml += `<div class="fw-bold">${test.message}</div>`;
                    if (typeof test.details === 'object') {
                        resultsHtml += `<small class="text-muted">${JSON.stringify(test.details, null, 2)}</small>`;
                    } else {
                        resultsHtml += `<small class="text-muted">${test.details}</small>`;
                    }
                    resultsHtml += `</div>`;
                    resultsHtml += `<span class="badge ${test.status ? 'bg-success' : 'bg-danger'} ms-2">${statusText}</span>`;
                    resultsHtml += `</div>`;
                });

                resultsHtml += '</div>';

                Swal.fire({
                    title: data.all_passed ? '✅ Test Koneksi Berhasil!' : '⚠️ Test Koneksi Sebagian Berhasil',
                    html: resultsHtml,
                    icon: data.all_passed ? 'success' : 'warning',
                    customClass: {
                        popup: 'swal-wide'
                    },
                    confirmButtonText: 'OK'
                });

                // Update status display if needed
                if (data.all_passed) {
                    updateConnectionStatus(true);
                }
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        }).fail(function(xhr, status, error) {
            hideLoading();
            console.log('Test connection error:', xhr.responseText);
            Swal.fire('Error', 'Gagal melakukan test koneksi: ' + error, 'error');
        });
    }

    function updateConnectionStatus(isConnected) {
        // Update any connection status indicators in the UI
        const statusIndicators = $('.connection-status');
        if (statusIndicators.length > 0) {
            statusIndicators.removeClass('bg-secondary bg-danger').addClass(isConnected ? 'bg-success' : 'bg-danger');
            statusIndicators.text(isConnected ? 'Connected' : 'Disconnected');
        }
    }

    function showBackupList() {
        Swal.fire({
            title: 'Kelola Backup',
            text: 'Fitur manajemen backup akan segera tersedia',
            icon: 'info'
        });
    }

    function viewUpdateLog() {
        $.get('<?= site_url('system-update/get-update-log') ?>', function(data) {
            Swal.fire({
                title: 'Log Update',
                html: `<pre style="white-space:pre-wrap;word-break:break-word;">${data.log}</pre>`,
                icon: 'info',
                customClass: {
                    popup: 'swal-wide'
                },
                confirmButtonText: 'OK'
            });
        }).fail(function() {
            Swal.fire('Error', 'Gagal mengambil log update', 'error');
        });
    }

    function updateStatusDisplay(updateAvailable) {
        const statusEl = $('#update_status');
        const alertEl = $('#update_status_alert');
        const updateBtn = $('#update_btn');

        if (updateAvailable) {
            statusEl.html('<span class="badge bg-warning"><i class="mdi mdi-download me-1"></i>Update Tersedia</span>');
            alertEl.removeClass('d-none alert-success').addClass('alert-warning');
            $('#update_status_message').text('Update baru tersedia! Klik "Lakukan Update" untuk memperbarui aplikasi.');
            updateBtn.prop('disabled', false);
        } else {
            statusEl.html('<span class="badge bg-success"><i class="mdi mdi-check-circle me-1"></i>Versi Terbaru</span>');
            alertEl.removeClass('d-none alert-warning').addClass('alert-success');
            $('#update_status_message').text('Aplikasi Anda sudah menggunakan versi terbaru.');
            updateBtn.prop('disabled', true);
        }
    }

    // function checkUpdateStatus() {
    //     // Auto check for updates on page load
    //     setTimeout(checkForUpdates, 1000);
    // }

    function showLoading(message) {
        Swal.fire({
            title: message,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    function hideLoading() {
        Swal.close();
    }
</script>

<style>
    .swal-wide {
        width: 80% !important;
        max-width: 800px !important;
    }

    .test-results {
        text-align: left;
        max-height: 400px;
        overflow-y: auto;
    }

    .test-results .border {
        border-color: #dee2e6 !important;
    }

    .test-results small {
        font-family: monospace;
        background-color: #f8f9fa;
        padding: 2px 4px;
        border-radius: 3px;
        display: block;
        margin-top: 4px;
        white-space: pre-wrap;
    }
</style>

<?= $this->endSection() ?>