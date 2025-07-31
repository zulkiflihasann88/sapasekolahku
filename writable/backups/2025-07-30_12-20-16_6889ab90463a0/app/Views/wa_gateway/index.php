<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>WhatsApp Gateway &mdash; Sekolahku</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">WhatsApp Gateway</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">WhatsApp Gateway</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Gateway Status Alert -->
        <div class="row">
            <div class="col-12">
                <div id="gateway_status_alert" class="alert alert-secondary d-none" role="alert">
                    <i class="mdi mdi-information me-2"></i>
                    <span id="gateway_status_message">Memuat status gateway...</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Konfigurasi WhatsApp Gateway</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="mdi mdi-information me-2"></i>
                            Konfigurasi API WhatsApp Gateway Wamoo (wamoo.kimonet.my.id) untuk mengirim pesan otomatis.
                            <br><small class="text-muted">Format nomor: 62888xxxx (tanpa +), contoh: 628123456789</small>
                        </div>

                        <form id="configForm">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="api_url" class="form-label">API URL Wamoo</label>
                                        <input type="text" class="form-control" id="api_url" placeholder="https://wamoo.kimonet.my.id" value="https://wamoo.kimonet.my.id">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="api_key" class="form-label">API Key Wamoo</label>
                                        <input type="text" class="form-control" id="api_key" placeholder="Masukkan API Key dari Wamoo">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="device_id" class="form-label">Sender Number (Nomor WhatsApp Anda)</label>
                                        <input type="text" class="form-control" id="device_id" placeholder="Contoh: 628123456789 (tanpa tanda +)">
                                        <div class="form-text">
                                            <small>Nomor WhatsApp yang terdaftar di Wamoo, format: 62888xxxx</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status Gateway</label>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="status_toggle" onchange="updateStatusDisplay()">
                                                <label class="form-check-label" for="status_toggle" id="status_label">
                                                    Nonaktif
                                                </label>
                                            </div>
                                            <span class="ms-3" id="status_badge">
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            </span>
                                        </div>
                                        <input type="hidden" id="status" value="0">
                                        <div class="form-text">
                                            <small>Aktifkan untuk mengirim notifikasi WhatsApp otomatis saat pendaftaran siswa</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-primary" onclick="saveConfig()">
                                    <i class="mdi mdi-content-save me-1"></i> Simpan Konfigurasi
                                </button>
                                <button type="button" class="btn btn-success" onclick="testConnection()">
                                    <i class="mdi mdi-wifi me-1"></i> Test Koneksi
                                </button>
                            </div>
                        </form>

                        <!-- Display Current Configuration -->
                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="text-muted mb-0">Konfigurasi Saat Ini</h5>
                            </div>
                            <div class="row" id="currentConfig">
                                <div class="col-lg-6">
                                    <div class="mb-2">
                                        <small class="text-muted">API URL:</small>
                                        <div id="display_api_url" class="fw-bold">-</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-2">
                                        <small class="text-muted">API Key:</small>
                                        <div id="display_api_key" class="fw-bold">-</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-2">
                                        <small class="text-muted">Sender Number:</small>
                                        <div id="display_device_id" class="fw-bold">-</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-2">
                                        <small class="text-muted">Status:</small>
                                        <div id="display_status" class="fw-bold gateway-status-indicator">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Template Management Section -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Template Pesan WhatsApp</h4>
                        <button type="button" class="btn btn-primary btn-sm" onclick="openTemplateModal()">
                            <i class="mdi mdi-plus me-1"></i> Tambah Template
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="mdi mdi-message-text me-2"></i>
                            Kelola template pesan WhatsApp untuk berbagai keperluan. Gunakan variabel seperti {nama}, {no_pendaftaran}, {tanggal_daftar} untuk data dinamis.
                        </div>

                        <!-- Template List -->
                        <div class="table-responsive">
                            <table class="table table-striped" id="templatesTable">
                                <thead>
                                    <tr>
                                        <th>Nama Template</th>
                                        <th>Tipe</th>
                                        <th>Status</th>
                                        <th>Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="templatesTableBody">
                                    <tr>
                                        <td colspan="5" class="text-center">Memuat template...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Current Active Template Preview -->
                        <div class="mt-4">
                            <h5>Preview Template Aktif (Pendaftaran)</h5>
                            <div class="alert alert-light border" id="activeTemplatePreview">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <strong id="activeTemplateName">Memuat template...</strong>
                                        <div class="mt-2">
                                            <pre id="activeTemplateContent" class="mb-0" style="white-space: pre-wrap; font-family: inherit; background: none; border: none; padding: 0;">Memuat konten template...</pre>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="previewActiveTemplate()">
                                        <i class="mdi mdi-eye me-1"></i> Preview dengan Data Sample
                                    </button>
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
                    <div class="card-header">
                        <h4 class="card-title mb-0">Kirim Notifikasi Pendaftaran Siswa</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <i class="mdi mdi-send me-2"></i>
                            Gunakan form ini untuk mengirim notifikasi konfirmasi pendaftaran kepada calon siswa baru menggunakan template yang telah disiapkan.
                        </div>

                        <form id="registrationForm">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="reg_siswa_select" class="form-label">Pilih Calon Siswa <span class="text-danger">*</span></label>
                                        <select class="form-select" id="reg_siswa_select" onchange="loadStudentData()" required>
                                            <option value="">-- Pilih Calon Siswa --</option>
                                        </select>
                                        <div class="form-text">
                                            <small>Pilih nama calon siswa untuk mengisi data otomatis</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="reg_nama" class="form-label">Nama Calon Siswa</label>
                                        <input type="text" class="form-control" id="reg_nama" placeholder="Masukkan nama lengkap calon siswa" required readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="reg_no_pendaftaran" class="form-label">Nomor Pendaftaran</label>
                                        <input type="text" class="form-control" id="reg_no_pendaftaran" placeholder="Contoh: 2025052126626" required readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="reg_nomor_wa" class="form-label">Nomor WhatsApp Orang Tua</label>
                                        <input type="text" class="form-control" id="reg_nomor_wa" placeholder="Contoh: 08123456789 atau 628123456789" required>
                                        <div class="form-text">
                                            <small>Nomor WhatsApp orang tua/wali yang akan menerima notifikasi</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="reg_tanggal_daftar" class="form-label">Tanggal Pendaftaran</label>
                                        <input type="date" class="form-control" id="reg_tanggal_daftar" value="<?= date('Y-m-d') ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Preview Template Pesan:</label>
                                <div class="border rounded p-3 bg-light" style="white-space: pre-line; font-family: monospace; font-size: 14px;">
                                    Halo, Orang Tua Murid! [NAMA],

                                    Terimakasih! telah melakukan pendaftaran sebagai calon peserta didik baru di
                                    SD Negeri Krengseng 02
                                    Tahun Pelajaran 2025/2026.
                                    Nomor Pendaftaran : [NO_PENDAFTARAN]
                                    Nama : [NAMA]
                                    Tanggal Daftar : [TANGGAL_DAFTAR]

                                    Silakan pantau perkembangan registrasi ananda melalui link www.spmb.sdnkrengseng02.sch.id dengan mencari nama peserta didik.

                                    Terima kasih.
                                    Admin SPMB

                                    Ini adalah pesan otomatis. mohon untuk tidak membalas.
                                    Informasi lebih lanjut, silakan hubungi admin SPMB di nomor 0819-0395-2785 atau datang langsung ke sekolah.
                                </div>
                                <small class="text-muted">Template akan diisi otomatis dengan data yang Anda masukkan di form.</small>
                            </div>

                            <div class="text-end">
                                <button type="button" class="btn btn-primary" onclick="sendRegistrationNotification()">
                                    <i class="mdi mdi-send me-1"></i> Kirim Notifikasi Pendaftaran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Template Modal -->
        <div class="modal fade" id="templateModal" tabindex="-1" aria-labelledby="templateModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="templateModalLabel">Tambah Template</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="templateForm">
                            <input type="hidden" id="template_id" name="id">

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="template_name" class="form-label">Nama Template <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="template_name" name="template_name" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="template_type" class="form-label">Tipe Template <span class="text-danger">*</span></label>
                                        <select class="form-select" id="template_type" name="template_type" required>
                                            <option value="registration">Pendaftaran</option>
                                            <option value="general">Umum</option>
                                            <option value="reminder">Pengingat</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject (Opsional)</label>
                                <input type="text" class="form-control" id="subject" name="subject">
                            </div>

                            <div class="mb-3">
                                <label for="message_template" class="form-label">Template Pesan <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="message_template" name="message_template" rows="10" required placeholder="Masukkan template pesan...

Gunakan variabel berikut:
{nama} - Nama siswa/penerima
{no_pendaftaran} - Nomor pendaftaran
{tanggal_daftar} - Tanggal pendaftaran
{nama_sekolah} - Nama sekolah
{tahun_pelajaran} - Tahun pelajaran
{nomor_admin} - Nomor HP admin"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="template_status" class="form-label">Status</label>
                                        <select class="form-select" id="template_status" name="status">
                                            <option value="active">Aktif</option>
                                            <option value="inactive">Nonaktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Preview</label>
                                        <button type="button" class="btn btn-outline-info w-100" onclick="previewTemplate()">
                                            <i class="mdi mdi-eye me-1"></i> Preview dengan Data Sample
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Preview Area -->
                            <div id="templatePreviewArea" style="display: none;">
                                <div class="alert alert-light border">
                                    <h6>Preview Template:</h6>
                                    <pre id="templatePreviewContent" style="white-space: pre-wrap; font-family: inherit;"></pre>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="saveTemplate()">
                            <i class="mdi mdi-content-save me-1"></i> Simpan Template
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Global functions - must be defined at global scope for onclick handlers

    // Fungsi untuk update tampilan status toggle
    function updateStatusDisplay() {
        const isChecked = $('#status_toggle').is(':checked');
        const label = $('#status_label');
        const badge = $('#status_badge');
        const hiddenInput = $('#status');

        if (isChecked) {
            label.text('Aktif');
            badge.html('<span class="badge bg-success">Aktif</span>');
            hiddenInput.val('1');
        } else {
            label.text('Nonaktif');
            badge.html('<span class="badge bg-secondary">Nonaktif</span>');
            hiddenInput.val('0');
        }
    }

    // Fungsi untuk update gateway status alert
    function updateGatewayStatusAlert(isActive, apiKey, deviceId) {
        const alert = $('#gateway_status_alert');
        const message = $('#gateway_status_message');

        let alertClass = 'alert-secondary';
        let iconClass = 'mdi-information';
        let messageText = '';

        if (isActive && apiKey && deviceId) {
            alertClass = 'alert-success';
            iconClass = 'mdi-check-circle';
            messageText = '✅ WhatsApp Gateway AKTIF - Notifikasi pendaftaran akan dikirim otomatis';
        } else if (isActive && (!apiKey || !deviceId)) {
            alertClass = 'alert-warning';
            iconClass = 'mdi-alert';
            messageText = '⚠️ WhatsApp Gateway AKTIF tapi konfigurasi belum lengkap - Silakan lengkapi API Key dan Device ID';
        } else {
            alertClass = 'alert-danger';
            iconClass = 'mdi-close-circle';
            messageText = '❌ WhatsApp Gateway NONAKTIF - Notifikasi pendaftaran tidak akan dikirim';
        }

        alert.removeClass('alert-success alert-warning alert-danger alert-secondary')
            .addClass(alertClass)
            .removeClass('d-none');

        alert.find('i').removeClass('mdi-information mdi-check-circle mdi-alert mdi-close-circle')
            .addClass(iconClass);

        message.text(messageText);
    }

    function saveConfig() {
        const config = {
            api_url: $('#api_url').val(),
            api_key: $('#api_key').val(),
            device_id: $('#device_id').val(),
            status: $('#status').val(),
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
        };

        // Validasi basic
        if (!config.api_key || !config.device_id) {
            Swal.fire('Error', 'API Key dan Device ID wajib diisi', 'error');
            return;
        }

        // Show loading state
        Swal.fire({
            title: 'Menyimpan...',
            text: 'Sedang menyimpan konfigurasi WhatsApp Gateway',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.post('<?= site_url('wa_gateway/saveConfig') ?>', config, function(data) {
            if (data.success) {
                const statusText = config.status === '1' ? 'diaktifkan' : 'dinonaktifkan';
                Swal.fire({
                    title: 'Berhasil!',
                    text: `Konfigurasi WhatsApp Gateway berhasil disimpan dan ${statusText}`,
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
                // Reload configuration display
                loadConfig();

                // Show updated status in alert
                setTimeout(() => {
                    const isActive = config.status === '1';
                    updateGatewayStatusAlert(isActive, config.api_key, config.device_id);
                }, 500);
            } else {
                Swal.fire('Error', data.message || 'Gagal menyimpan konfigurasi', 'error');
            }
        }).fail(function(xhr, status, error) {
            console.log('Error details:', xhr.responseText);
            Swal.fire('Error', 'Gagal menyimpan konfigurasi: ' + error, 'error');
        });
    }

    // Fungsi untuk test koneksi
    function testConnection() {
        const api_url = $('#api_url').val();
        const api_key = $('#api_key').val();
        const device_id = $('#device_id').val();

        if (!api_url || !api_key || !device_id) {
            Swal.fire('Error', 'Lengkapi terlebih dahulu API URL, API Key, dan Sender Number', 'error');
            return;
        }

        Swal.fire({
            title: 'Testing...',
            text: 'Sedang mengecek koneksi ke Wamoo API',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Test connection to Wamoo API
        $.post('<?= site_url('wa_gateway/testConnection') ?>', {
            api_url: api_url,
            api_key: api_key,
            device_id: device_id,
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
        }, function(data) {
            if (data.success) {
                Swal.fire('Berhasil', 'Koneksi ke Wamoo API berhasil!', 'success');
            } else {
                Swal.fire('Error', data.message || 'Gagal terhubung ke Wamoo API', 'error');
            }
        }).fail(function() {
            Swal.fire('Error', 'Gagal menghubungi server untuk test koneksi', 'error');
        });
    }

    // Template pesan yang telah ditentukan
    const messageTemplates = {
        pendaftaran_siswa: `Halo, Orang Tua Murid! {nama},

Terimakasih! telah melakukan pendaftaran sebagai calon peserta didik baru di 
{nama_sekolah}
Tahun Pelajaran {tahun_pelajaran}.
Nomor Pendaftaran : {no_pendaftaran}
Nama : {nama}
Tanggal Daftar : {tanggal_daftar}

Silakan pantau perkembangan registrasi ananda melalui link www.spmb.sdnkrengseng02.sch.id dengan mencari nama peserta didik.

Terima kasih.
Admin SPMB

Ini adalah pesan otomatis. mohon untuk tidak membalas.
Informasi lebih lanjut, silakan hubungi admin SPMB di nomor {nomor_admin} atau datang langsung ke sekolah.`,

        notifikasi_ujian: `Kepada Yth. Orang Tua/Wali Murid {nama},

Diberitahukan bahwa putra/putri Anda akan mengikuti:
- Ujian/Test: [NAMA UJIAN]
- Hari/Tanggal: [TANGGAL UJIAN]
- Waktu: [WAKTU UJIAN]
- Tempat: {nama_sekolah}

Mohon mempersiapkan putra/putri Anda dengan baik.

Terima kasih.
{nama_sekolah}`,

        pengumuman_umum: `Kepada Seluruh Orang Tua Murid {nama_sekolah},

[ISI PENGUMUMAN]

Demikian pengumuman ini, terima kasih atas perhatian dan kerjasamanya.

{nama_sekolah}
Tahun Pelajaran {tahun_pelajaran}`,

        reminder_pembayaran: `Kepada Yth. Orang Tua Murid {nama},

Mengingatkan bahwa pembayaran SPP bulan [BULAN] untuk {nama} belum diterima.

Mohon segera melakukan pembayaran melalui:
- Transfer Bank: [REKENING SEKOLAH]
- Datang langsung ke sekolah

Terima kasih.
{nama_sekolah}`
    };

    // Fungsi untuk membuka modal template
    function openTemplateModal(id = null) {
        $('#templateModal').modal('show');
        $('#templateModalLabel').text(id ? 'Edit Template' : 'Tambah Template');

        if (id) {
            // Load template data for editing
            // Implementation will be added later
        } else {
            // Reset form for new template
            $('#templateForm')[0].reset();
            $('#template_id').val('');
        }
    }

    // Fungsi untuk menyimpan template ke database
    function saveTemplate() {
        const formData = {
            id: $('#template_id').val(),
            template_name: $('#template_name').val(),
            template_type: $('#template_type').val(),
            subject: $('#subject').val(),
            message_template: $('#message_template').val(),
            is_active: $('#template_status').is(':checked') ? 1 : 0,
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
        };

        // Validation
        if (!formData.template_name || !formData.message_template) {
            Swal.fire('Error', 'Nama template dan isi template harus diisi', 'error');
            return;
        }

        // Show loading
        Swal.fire({
            title: 'Menyimpan...',
            text: 'Sedang menyimpan template',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const url = formData.id ? '<?= site_url('wa_gateway/updateTemplate') ?>' : '<?= site_url('wa_gateway/saveTemplate') ?>';

        $.post(url, formData, function(data) {
            if (data.success) {
                Swal.fire('Berhasil', data.message || 'Template berhasil disimpan', 'success');
                $('#templateModal').modal('hide');
                loadTemplates(); // Reload templates
                loadActiveTemplate(); // Reload active template preview
            } else {
                Swal.fire('Error', data.message || 'Gagal menyimpan template', 'error');
            }
        }).fail(function() {
            Swal.fire('Error', 'Gagal menghubungi server', 'error');
        });
    }

    // Fungsi untuk preview template dengan data sample
    function previewActiveTemplate() {
        // Implementation for previewing active template
        const sampleData = {
            nama: 'IDAMAN',
            no_pendaftaran: '2025052126626',
            tanggal_daftar: new Date().toLocaleDateString('id-ID'),
            nama_sekolah: 'SD Negeri Krengseng 02',
            tahun_pelajaran: '2025/2026',
            nomor_admin: '0819-0395-2785'
        };

        // Show sample preview in modal or alert
        Swal.fire({
            title: 'Preview Template dengan Data Sample',
            html: '<pre style="text-align: left; white-space: pre-wrap;">' +
                $('#activeTemplateContent').text().replace(/\{(\w+)\}/g, function(match, key) {
                    return sampleData[key] || match;
                }) + '</pre>',
            icon: 'info',
            confirmButtonText: 'OK'
        });
    }

    // Fungsi untuk memuat data siswa dan mengisi form otomatis
    function loadStudentData() {
        const selectedId = $('#reg_siswa_select').val();

        if (!selectedId) {
            // Reset form jika tidak ada yang dipilih
            $('#reg_nama').val('');
            $('#reg_no_pendaftaran').val('');
            $('#reg_nomor_wa').val('');
            $('#reg_tanggal_daftar').val('<?= date('Y-m-d') ?>');
            return;
        }

        // Show loading
        $('#reg_nama').val('Loading...');
        $('#reg_no_pendaftaran').val('Loading...');
        $('#reg_nomor_wa').val('Loading...');

        // Load student data via AJAX
        $.get('<?= site_url('wa_gateway/getStudentData') ?>/' + selectedId, function(data) {
            if (data.success && data.student) {
                const student = data.student;

                // Fill form with student data
                $('#reg_nama').val(student.nama_peserta || '');
                $('#reg_no_pendaftaran').val(student.no_pendaftaran || '');
                $('#reg_nomor_wa').val(student.nomor_hp || '');

                // Convert tanggal_daftar to date format if available
                if (student.tanggal_daftar) {
                    try {
                        const date = new Date(student.tanggal_daftar);
                        // Check if date is valid
                        if (!isNaN(date.getTime())) {
                            const formattedDate = date.toISOString().split('T')[0];
                            $('#reg_tanggal_daftar').val(formattedDate);
                        } else {
                            // Use current date if invalid
                            const today = new Date().toISOString().split('T')[0];
                            $('#reg_tanggal_daftar').val(today);
                        }
                    } catch (e) {
                        // Use current date if error
                        const today = new Date().toISOString().split('T')[0];
                        $('#reg_tanggal_daftar').val(today);
                    }
                } else {
                    // Use current date if no tanggal_daftar
                    const today = new Date().toISOString().split('T')[0];
                    $('#reg_tanggal_daftar').val(today);
                }
            } else {
                Swal.fire('Error', 'Data siswa tidak ditemukan', 'error');
                // Reset form on error
                $('#reg_nama').val('');
                $('#reg_no_pendaftaran').val('');
                $('#reg_nomor_wa').val('');
                $('#reg_tanggal_daftar').val('<?= date('Y-m-d') ?>');
            }
        }).fail(function() {
            Swal.fire('Error', 'Gagal memuat data siswa', 'error');
            // Reset form on error
            $('#reg_nama').val('');
            $('#reg_no_pendaftaran').val('');
            $('#reg_nomor_wa').val('');
            $('#reg_tanggal_daftar').val('<?= date('Y-m-d') ?>');
        });
    }

    // Fungsi untuk memuat daftar calon siswa
    function loadStudentList() {
        $.get('<?= site_url('wa_gateway/getStudentList') ?>', function(data) {
            if (data.success && data.students) {
                const select = $('#reg_siswa_select');
                select.empty().append('<option value="">-- Pilih Calon Siswa --</option>');

                data.students.forEach(function(student) {
                    const option = $('<option></option>')
                        .attr('value', student.id_peserta)
                        .text(student.nama_peserta + ' - ' + (student.no_pendaftaran || 'No. Pendaftaran: Belum ada'));
                    select.append(option);
                });
            } else {
                console.log('Gagal memuat daftar siswa:', data.message);
            }
        }).fail(function() {
            console.log('Gagal menghubungi server untuk memuat daftar siswa');
        });
    }

    // Fungsi untuk mengirim notifikasi pendaftaran siswa
    function sendRegistrationNotification() {
        const nama = $('#reg_nama').val();
        const no_pendaftaran = $('#reg_no_pendaftaran').val();
        const nomor_wa = $('#reg_nomor_wa').val();
        const tanggal_daftar = $('#reg_tanggal_daftar').val();

        if (!nama || !no_pendaftaran || !nomor_wa) {
            Swal.fire('Error', 'Nama, nomor pendaftaran, dan nomor WhatsApp harus diisi', 'error');
            return;
        }

        // Format tanggal ke format Indonesia
        const tanggal = tanggal_daftar ? new Date(tanggal_daftar).toLocaleDateString('id-ID') : new Date().toLocaleDateString('id-ID');

        Swal.fire({
            title: 'Mengirim Notifikasi...',
            text: 'Sedang mengirim notifikasi pendaftaran kepada ' + nama,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.post('<?= site_url('wa_gateway/sendRegistrationNotification') ?>', {
            nama: nama,
            no_pendaftaran: no_pendaftaran,
            nomor_wa: nomor_wa,
            tanggal_daftar: tanggal,
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
        }, function(data) {
            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Reset form
                    $('#registrationForm')[0].reset();
                    $('#reg_tanggal_daftar').val('<?= date('Y-m-d') ?>');
                });
            } else {
                Swal.fire('Error', data.message || 'Gagal mengirim notifikasi pendaftaran', 'error');
            }
        }).fail(function(xhr, status, error) {
            console.log('Error details:', xhr.responseText);
            Swal.fire('Error', 'Gagal mengirim notifikasi: ' + error, 'error');
        });
    }

    // Fungsi untuk memuat konfigurasi
    function loadConfig() {
        console.log('Loading config from: <?= site_url('wa_gateway/getConfig') ?>');
        $.get('<?= site_url('wa_gateway/getConfig') ?>', function(data) {
            console.log('Config response:', data);
            if (data.success && data.config) {
                console.log('Config data:', data.config);
                // Fill form fields
                $('#api_url').val(data.config.api_url || '');
                $('#api_key').val(data.config.api_key || '');
                $('#device_id').val(data.config.device_id || '');

                // Handle status field - support both string and integer formats
                let isActive = false;
                if (data.config.status === 'active' || data.config.status === '1' || data.config.status == 1 || data.config.status === 1) {
                    isActive = true;
                }

                // Update toggle switch
                $('#status_toggle').prop('checked', isActive);
                $('#status').val(isActive ? '1' : '0');
                updateStatusDisplay();

                // Display current configuration
                $('#display_api_url').text(data.config.api_url || 'Belum diatur');
                $('#display_api_key').text(data.config.api_key ? '****' + data.config.api_key.slice(-4) : 'Belum diatur');
                $('#display_device_id').text(data.config.device_id || 'Belum diatur');

                // Display status with appropriate badge and visual indicator
                let statusDisplay = '<span class="badge bg-secondary">Belum diatur</span>';
                let statusClass = '';
                if (data.config.status === 'active' || data.config.status === '1' || data.config.status == 1 || data.config.status === 1) {
                    statusDisplay = '<span class="badge bg-success">Aktif</span>';
                    statusClass = 'active';
                } else if (data.config.status === 'inactive' || data.config.status === '0' || data.config.status == 0 || data.config.status === 0) {
                    statusDisplay = '<span class="badge bg-danger">Nonaktif</span>';
                    statusClass = 'inactive';
                }
                $('#display_status').html(statusDisplay).removeClass('active inactive').addClass(statusClass);

                // Update gateway status alert
                updateGatewayStatusAlert(isActive, data.config.api_key, data.config.device_id);
            } else {
                console.log('Config error or no data:', data.message);
                // Show default values when no config
                $('#display_api_url').text('Belum diatur');
                $('#display_api_key').text('Belum diatur');
                $('#display_device_id').text('Belum diatur');
                $('#display_status').html('<span class="badge bg-secondary">Belum diatur</span>').removeClass('active inactive');

                // Reset toggle
                $('#status_toggle').prop('checked', false);
                $('#status').val('0');
                updateStatusDisplay();
            }
        }).fail(function(xhr, status, error) {
            console.log('Config AJAX failed:', {
                status: status,
                error: error,
                responseText: xhr.responseText,
                statusCode: xhr.status
            });

            let errorMessage = 'Error memuat data';
            if (xhr.status === 403) {
                errorMessage = 'Akses ditolak';
            } else if (xhr.status === 404) {
                errorMessage = 'Endpoint tidak ditemukan';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error';
            }

            console.log('Gagal memuat konfigurasi');
            // Show error state
            $('#display_api_url').text(errorMessage);
            $('#display_api_key').text(errorMessage);
            $('#display_device_id').text(errorMessage);
            $('#display_status').html('<span class="badge bg-danger">Error</span>').removeClass('active inactive');

            // Reset toggle
            $('#status_toggle').prop('checked', false);
            $('#status').val('0');
            updateStatusDisplay();
        });
    }

    // ===== TEMPLATE MANAGEMENT FUNCTIONS =====

    // Load templates on page load
    function loadTemplates() {
        console.log('Loading templates from: <?= site_url('wa_gateway/templates') ?>');

        // Show loading state
        $('#templatesTableBody').html('<tr><td colspan="5" class="text-center"><i class="mdi mdi-loading mdi-spin"></i> Memuat template...</td></tr>');

        $.get('<?= site_url('wa_gateway/templates') ?>', function(data) {
            console.log('Templates response:', data);
            if (data && data.success) {
                console.log('Templates data:', data.templates);
                displayTemplates(data.templates);
                loadActiveTemplate();
            } else {
                console.log('Templates error:', data ? data.message : 'No response data');
                const message = data && data.message ? data.message : 'Response tidak valid';
                $('#templatesTableBody').html('<tr><td colspan="5" class="text-center text-danger">Gagal memuat template: ' + message + '</td></tr>');
            }
        }).fail(function(xhr, status, error) {
            console.log('Templates AJAX failed:', {
                status: status,
                error: error,
                responseText: xhr.responseText,
                statusCode: xhr.status
            });

            let errorMessage = 'Error memuat template';
            if (xhr.status === 403) {
                errorMessage = 'Akses ditolak - silakan login ulang';
            } else if (xhr.status === 404) {
                errorMessage = 'Endpoint tidak ditemukan';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error - periksa log';
            } else if (error) {
                errorMessage += ': ' + error;
            }

            $('#templatesTableBody').html('<tr><td colspan="5" class="text-center text-danger">' + errorMessage + '</td></tr>');
        });
    }

    // Display templates in table
    function displayTemplates(templates) {
        console.log('Displaying templates:', templates);
        let html = '';

        if (!templates || templates.length === 0) {
            html = '<tr><td colspan="5" class="text-center">Belum ada template</td></tr>';
        } else {
            templates.forEach(function(template) {
                console.log('Processing template:', template);

                const statusBadge = template.status === 'active' ?
                    '<span class="badge bg-success">Aktif</span>' :
                    '<span class="badge bg-secondary">Nonaktif</span>';

                const typeName = {
                    'registration': 'Pendaftaran',
                    'general': 'Umum',
                    'reminder': 'Pengingat'
                } [template.template_type] || template.template_type;

                // Safe date handling
                let createdDate = 'N/A';
                if (template.created_at) {
                    try {
                        createdDate = new Date(template.created_at).toLocaleDateString('id-ID');
                    } catch (e) {
                        createdDate = template.created_at;
                    }
                }

                html += `
                    <tr>
                        <td>
                            <strong>${template.template_name || 'N/A'}</strong>
                            ${template.subject ? '<br><small class="text-muted">' + template.subject + '</small>' : ''}
                        </td>
                        <td>${typeName}</td>
                        <td>${statusBadge}</td>
                        <td>${createdDate}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-primary" onclick="editTemplate(${template.id})" title="Edit">
                                    <i class="mdi mdi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-outline-info" onclick="viewTemplate(${template.id})" title="Lihat">
                                    <i class="mdi mdi-eye"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger" onclick="deleteTemplate(${template.id})" title="Hapus">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </div>
                        </td>
                    </tr>`;
            });
        }

        console.log('Generated HTML:', html);
        $('#templatesTableBody').html(html);
    }

    // Load active template for preview
    function loadActiveTemplate() {
        console.log('Loading active template...');
        $.get('<?= site_url('wa_gateway/templates') ?>', function(data) {
            console.log('Active template response:', data);
            if (data && data.success) {
                const activeTemplate = data.templates.find(t => t.template_type === 'registration' && t.status === 'active');
                console.log('Found active template:', activeTemplate);
                if (activeTemplate) {
                    $('#activeTemplateName').text(activeTemplate.template_name);
                    $('#activeTemplateContent').text(activeTemplate.message_template);
                } else {
                    $('#activeTemplateName').text('Tidak ada template aktif');
                    $('#activeTemplateContent').text('Belum ada template pendaftaran yang aktif');
                }
            } else {
                console.log('Failed to get active template');
                $('#activeTemplateName').text('Error memuat template');
                $('#activeTemplateContent').text('Gagal memuat template aktif');
            }
        }).fail(function(xhr, status, error) {
            console.log('Active template AJAX failed:', xhr, status, error);
            $('#activeTemplateName').text('Error memuat template');
            $('#activeTemplateContent').text('Gagal memuat template aktif');
        });
    }

    // Open template modal for new template
    function openTemplateModal() {
        $('#templateForm')[0].reset();
        $('#template_id').val('');
        $('#templateModalLabel').text('Tambah Template');
        $('#templatePreviewArea').hide();
        $('#templateModal').modal('show');
    }

    // Edit existing template
    function editTemplate(id) {
        $.get('<?= site_url('wa_gateway/template') ?>/' + id, function(data) {
            if (data.success) {
                const template = data.template;
                $('#template_id').val(template.id);
                $('#template_name').val(template.template_name);
                $('#template_type').val(template.template_type);
                $('#subject').val(template.subject || '');
                $('#message_template').val(template.message_template);
                $('#template_status').val(template.status);

                $('#templateModalLabel').text('Edit Template');
                $('#templatePreviewArea').hide();
                $('#templateModal').modal('show');
            } else {
                Swal.fire('Error', data.message || 'Gagal memuat template', 'error');
            }
        }).fail(function() {
            Swal.fire('Error', 'Gagal memuat template', 'error');
        });
    }

    // View template (read-only)
    function viewTemplate(id) {
        $.get('<?= site_url('wa_gateway/template') ?>/' + id, function(data) {
            if (data.success) {
                const template = data.template;
                Swal.fire({
                    title: template.template_name,
                    html: `
                        <div class="text-start">
                            <p><strong>Tipe:</strong> ${template.template_type}</p>
                            ${template.subject ? '<p><strong>Subject:</strong> ' + template.subject + '</p>' : ''}
                            <p><strong>Status:</strong> ${template.status}</p>
                            <hr>
                            <pre style="white-space: pre-wrap; text-align: left; background: #f8f9fa; padding: 15px; border-radius: 5px;">${template.message_template}</pre>
                        </div>
                    `,
                    width: '800px',
                    confirmButtonText: 'Tutup'
                });
            } else {
                Swal.fire('Error', data.message || 'Gagal memuat template', 'error');
            }
        });
    }

    // Save template
    function saveTemplate() {
        const formData = new FormData(document.getElementById('templateForm'));
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        $.ajax({
            url: '<?= site_url('wa_gateway/template/save') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.success) {
                    Swal.fire('Berhasil', data.message, 'success');
                    $('#templateModal').modal('hide');
                    loadTemplates(); // Reload templates
                } else {
                    Swal.fire('Error', data.message || 'Gagal menyimpan template', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Gagal menyimpan template', 'error');
            }
        });
    }

    // Delete template
    function deleteTemplate(id) {
        Swal.fire({
            title: 'Hapus Template?',
            text: 'Template yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Sedang menghapus template',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Get CSRF token from meta tag for better compatibility
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                const csrfName = $('meta[name="csrf-token-name"]').attr('content');

                // Use POST method for better compatibility
                const postData = {
                    id: id
                };

                // Add CSRF token
                if (csrfToken && csrfName) {
                    postData[csrfName] = csrfToken;
                } else {
                    // Fallback to PHP generated token
                    postData['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
                }

                $.post('<?= site_url('wa_gateway/template/delete') ?>', postData, function(data) {
                    console.log('Delete template response:', data);
                    if (data && data.success) {
                        Swal.fire('Dihapus!', data.message || 'Template berhasil dihapus', 'success');
                        loadTemplates(); // Reload templates
                        loadActiveTemplate(); // Reload active template preview
                    } else {
                        console.log('Delete failed:', data);
                        Swal.fire('Error', data.message || 'Gagal menghapus template', 'error');
                    }
                }).fail(function(xhr, status, error) {
                    console.log('Delete template AJAX failed:', {
                        status: xhr.status,
                        statusText: xhr.statusText,
                        error: error,
                        responseText: xhr.responseText
                    });

                    let errorMsg = 'Gagal menghapus template';
                    if (xhr.status === 403) {
                        errorMsg = 'Akses ditolak - silakan login ulang';
                    } else if (xhr.status === 404) {
                        errorMsg = 'Endpoint tidak ditemukan';
                    } else if (xhr.status === 500) {
                        errorMsg = 'Server error - periksa log server';
                    } else if (xhr.responseText) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            errorMsg = response.message || errorMsg;
                        } catch (e) {
                            // Use default error message
                        }
                    }

                    Swal.fire('Error', errorMsg, 'error');
                });
            }
        });
    }

    // Preview template with sample data
    function previewTemplate() {
        const templateContent = $('#message_template').val();
        const templateType = $('#template_type').val();

        if (!templateContent) {
            Swal.fire('Error', 'Template content tidak boleh kosong', 'error');
            return;
        }

        $.post('<?= site_url('wa_gateway/template/preview') ?>', {
            template_content: templateContent,
            template_type: templateType,
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
        }, function(data) {
            if (data.success) {
                $('#templatePreviewContent').text(data.preview);
                $('#templatePreviewArea').show();
            } else {
                Swal.fire('Error', data.message || 'Gagal membuat preview', 'error');
            }
        }).fail(function() {
            Swal.fire('Error', 'Gagal membuat preview', 'error');
        });
    }

    // Preview active template
    function previewActiveTemplate() {
        const templateContent = $('#activeTemplateContent').text();

        if (!templateContent || templateContent === 'Belum ada template pendaftaran yang aktif') {
            Swal.fire('Error', 'Tidak ada template aktif untuk di-preview', 'error');
            return;
        }

        $.post('<?= site_url('wa_gateway/template/preview') ?>', {
            template_content: templateContent,
            template_type: 'registration',
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
        }, function(data) {
            if (data.success) {
                Swal.fire({
                    title: 'Preview Template Aktif',
                    html: '<pre style="white-space: pre-wrap; text-align: left; background: #f8f9fa; padding: 15px; border-radius: 5px;">' + data.preview + '</pre>',
                    width: '800px',
                    confirmButtonText: 'Tutup'
                });
            } else {
                Swal.fire('Error', data.message || 'Gagal membuat preview', 'error');
            }
        });
    }

    // ...existing code...
</script>

<script>
    // DOM Ready - Load data when page is ready
    $(document).ready(function() {
        // Load configurations and templates when page loads
        loadConfig();
        loadTemplates();
        loadStudentList();

        console.log('WhatsApp Gateway page loaded - fetching data...');
    });
</script>

<style>
    .swal-wide {
        width: 600px !important;
    }

    /* Enhanced toggle switch styling */
    .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }

    .form-check-input:focus {
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    /* Status badge animation */
    .status-transition {
        transition: all 0.3s ease;
    }

    /* Gateway status indicator */
    .gateway-status-indicator {
        position: relative;
        padding-left: 1.5rem;
    }

    .gateway-status-indicator::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #6c757d;
        transition: background-color 0.3s ease;
    }

    .gateway-status-indicator.active::before {
        background-color: #198754;
        box-shadow: 0 0 0 2px rgba(25, 135, 84, 0.25);
    }

    .gateway-status-indicator.inactive::before {
        background-color: #dc3545;
    }
</style>

<?= $this->endSection() ?>