<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Profil Instansi &mdash; SDN Krengseng 02</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-content">
    <!-- Header Section -->
    <div class="profile-header-card">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="profile-avatar me-3">
                    <i class="bx bxs-school fs-2 text-white"></i>
                </div>
                <div class="text-white">
                    <h3 class="text-white mb-1 fw-bold">Profil Instansi</h3>
                    <p class="text-white-50 mb-0">Kelola informasi profil sekolah</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Profile Detail Card -->
    <div id="frm-detail" class="row mt-4">
        <div class="col-lg-8">
            <div class="profile-card">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="card-title mb-1 fw-bold text-dark">
                                <i class="bx bx-info-circle text-primary fs-5 me-2"></i>Informasi Instansi
                            </h5>
                            <p class="text-muted mb-0 small">Detail informasi profil sekolah</p>
                        </div>
                        <button id="btn-ubah" type="button" class="btn btn-primary btn-sm profile-btn px-3">
                            <i class="bx bxs-edit-alt fs-6 me-1"></i>Edit Profil
                        </button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="profile-info-item border-primary">
                                <label class="text-muted small text-uppercase fw-semibold">Nama Instansi</label>
                                <p id="detail_nama" class="mb-0 fs-6 fw-medium text-dark">-</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="profile-info-item border-success">
                                <label class="text-muted small text-uppercase fw-semibold">Alamat</label>
                                <p id="detail_alamat" class="mb-0 fs-6 fw-medium text-dark">-</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-info-item border-info">
                                <label class="text-muted small text-uppercase fw-semibold">Telepon</label>
                                <p id="detail_telepon" class="mb-0 fs-6 fw-medium text-dark">-</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-info-item border-warning">
                                <label class="text-muted small text-uppercase fw-semibold">Email</label>
                                <p id="detail_email" class="mb-0 fs-6 fw-medium text-dark">-</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="profile-info-item border-secondary">
                                <label class="text-muted small text-uppercase fw-semibold">Website</label>
                                <p id="detail_website" class="mb-0 fs-6 fw-medium text-dark">-</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="profile-card h-100">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <h6 class="card-title mb-0 fw-bold text-dark">
                        <i class="bx bx-image text-primary fs-5 me-2"></i>Logo Instansi
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="profile-logo-container">
                        <img id="detail_logo"
                            src="<?= base_url('backend/assets/images/logo sd.png') ?>"
                            class="img-fluid rounded-3 shadow"
                            style="max-width: 200px; max-height: 200px; object-fit: contain;"
                            alt="Logo Instansi"
                            onerror="this.src='<?= base_url('backend/assets/images/logo-light.png') ?>'">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div id="frm-ubah" class="d-none mt-4">
        <div class="profile-card">
            <div class="card-header profile-header-card text-white border-0 py-4 px-4">
                <div class="d-flex align-items-center">
                    <div class="profile-avatar me-3">
                        <i class="bx bxs-edit-alt fs-5 text-white"></i>
                    </div>
                    <div>
                        <h5 class="text-white mb-1 fw-bold">Edit Profil Instansi</h5>
                        <p class="text-white-50 mb-0 small">Perbarui informasi profil sekolah</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <form id="frm-profil" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="row g-4">
                        <!-- Form Fields Column -->
                        <div class="col-lg-8">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-floating profile-form-floating">
                                        <input type="text" id="nama" name="nama_sekolah" class="form-control" placeholder="Nama Instansi" required>
                                        <label for="nama">
                                            <i class="bx bxs-school text-primary me-2"></i>Nama Instansi <span class="text-danger">*</span>
                                        </label>
                                        <div class="invalid-feedback">Nama instansi tidak boleh kosong.</div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating profile-form-floating">
                                        <textarea id="alamat" name="alamat" class="form-control" placeholder="Alamat" style="height: 100px" required></textarea>
                                        <label for="alamat">
                                            <i class="bx bx-map-pin text-success me-2"></i>Alamat <span class="text-danger">*</span>
                                        </label>
                                        <div class="invalid-feedback">Alamat tidak boleh kosong.</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating profile-form-floating">
                                        <input type="text" id="telepon" name="telp" class="form-control" placeholder="Telepon" maxlength="13" onKeyPress="return goodchars(event,'0123456789',this)" required>
                                        <label for="telepon">
                                            <i class="bx bx-phone text-info me-2"></i>Telepon <span class="text-danger">*</span>
                                        </label>
                                        <div class="invalid-feedback">Telepon tidak boleh kosong.</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating profile-form-floating">
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                                        <label for="email">
                                            <i class="bx bx-envelope text-warning me-2"></i>Email <span class="text-danger">*</span>
                                        </label>
                                        <div class="invalid-feedback">Email tidak boleh kosong.</div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating profile-form-floating">
                                        <input type="text" id="website" name="website" class="form-control" placeholder="Website" required>
                                        <label for="website">
                                            <i class="bx bx-globe text-secondary me-2"></i>Website <span class="text-danger">*</span>
                                        </label>
                                        <div class="invalid-feedback">Masukkan website yang valid (contoh: www.example.com atau https://www.example.com)</div>
                                        <div class="form-text">
                                            <small class="text-muted">Masukkan tanpa atau dengan protokol (http:// atau https://)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Logo Upload Column -->
                        <div class="col-lg-4">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body p-4">
                                    <h6 class="card-title fw-bold text-dark mb-3 text-center">
                                        <i class="bx bx-cloud-upload text-primary me-2"></i>Upload Logo
                                    </h6>

                                    <div class="profile-upload-area mb-3">
                                        <input type="file" accept=".jpg, .jpeg, .png" id="logo" name="logo" class="form-control mb-3">

                                        <div class="text-center">
                                            <img id="logo_preview" class="img-fluid rounded-3 shadow" style="max-width: 180px; max-height: 180px; object-fit: contain;" alt="Logo Preview">
                                        </div>
                                    </div>

                                    <div class="alert alert-info border-0 py-2 px-3">
                                        <small class="mb-0">
                                            <i class="bx bx-info-circle me-1"></i>
                                            <strong>Keterangan:</strong><br>
                                            • Format: JPG, JPEG, PNG<br>
                                            • Ukuran maksimal: 1 MB
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer bg-white border-0 p-4">
                <div class="d-flex gap-2 justify-content-end">
                    <button id="btn-batal" type="button" class="btn btn-light border profile-btn px-4">
                        <i class="bx bx-x me-1"></i>Batal
                    </button>
                    <button id="btn-simpan" type="submit" class="btn btn-primary profile-btn px-4">
                        <i class="bx bx-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        // Konfigurasi Toastr
        if (typeof toastr !== 'undefined') {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "4000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
        }

        // Helper function untuk Toastr notification
        function showToastr(message, title, type) {
            if (typeof toastr !== 'undefined') {
                toastr[type](message, title, {
                    timeOut: type === 'success' ? 3000 : 5000,
                    progressBar: true,
                    closeButton: true
                });
            } else {
                alert((title ? title + ': ' : '') + message);
            }
        }

        /** Onload
         ********************
         * Tampil Data Detail
         */
        // Tampilkan detail data profil instansi
        tampil_data_detail();

        /** Tampil Data
         ********************
         * Tampil Data Detail
         * Tampil Data Ubah
         */
        // Menampilkan detail data profil instansi ke form detail
        function tampil_data_detail() {
            // ajax request untuk mengambil data profil
            $.ajax({
                url: "<?= site_url('lembaga/getData/' . $sekolah[0]->id_sekolah) ?>", // file proses get data
                dataType: "JSON", // menggunakan tipe data JSON
                // fungsi yang dijalankan ketika ajax request berhasil
                success: function(result) {
                    // Debug: log result to console
                    console.log('Data received:', result);

                    // Pastikan result ada dan tidak null
                    if (!result) {
                        console.warn('No data received from server');
                        return;
                    }

                    // tampilkan data ke form detail
                    $('#detail_nama').text(result.nama_sekolah || '-');
                    $('#detail_alamat').text(result.alamat || '-');
                    $('#detail_telepon').text(result.telp || '-');
                    $('#detail_email').text(result.email || '-');
                    $('#detail_website').text(result.website || '-');

                    // Set logo dengan error handling
                    var $detailLogo = $('#detail_logo');
                    $detailLogo.off('error').on('error', function() {
                        $(this).attr('src', '<?= base_url("backend/assets/images/logo sd.png") ?>');
                    });

                    // Cek apakah logo ada dan tidak kosong
                    if (result.logo && result.logo.trim() !== '' && result.logo !== 'null') {
                        console.log('Loading logo:', result.logo);
                        $detailLogo.attr('src', '<?= base_url("backend/uploads/logo/") ?>' + result.logo);
                    } else {
                        console.log('Using default logo - no custom logo found');
                        // Jika logo kosong, gunakan logo default
                        $detailLogo.attr('src', '<?= base_url("backend/assets/images/logo sd.png") ?>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data: ", status, error);
                    alert("Failed to load data. Please try again later.");
                }
            });
        }

        // Menampilkan data profil instansi ke form ubah
        function tampil_data_ubah() {
            $.ajax({
                url: "<?= site_url('lembaga/getData/' . $sekolah[0]->id_sekolah) ?>", // file proses get data
                dataType: "JSON", // menggunakan tipe data JSON
                // fungsi yang dijalankan sebelum ajax request dikirim
                beforeSend: function() {
                    // tampilkan preloader
                    $('.preloader').fadeIn('slow');
                    // tampilkan file logo default
                    $('#logo_preview').attr('src', '<?= base_url("backend/assets/images/logo sd.png") ?>');
                },
                // fungsi yang dijalankan ketika ajax request berhasil
                success: function(result) {
                    // memberikan interval waktu sebelum fungsi dijalankan
                    setTimeout(function() {
                        // tutup preloader
                        $('.preloader').fadeOut('fast');

                        // tampilkan data ke form ubah
                        $('#nama').val(result.nama_sekolah || '');
                        $('#alamat').val(result.alamat || '');
                        $('#telepon').val(result.telp || '');
                        $('#email').val(result.email || '');
                        $('#website').val(result.website || '');

                        // Set logo preview dengan error handling
                        var $logoPreview = $('#logo_preview');
                        $logoPreview.off('error').on('error', function() {
                            $(this).attr('src', '<?= base_url("backend/assets/images/logo sd.png") ?>');
                        });

                        // Cek apakah logo ada dan tidak kosong
                        if (result.logo && result.logo.trim() !== '' && result.logo !== 'null') {
                            console.log('Loading preview logo:', result.logo);
                            $logoPreview.attr('src', '<?= base_url("backend/uploads/logo/") ?>' + result.logo);
                        } else {
                            console.log('Using default preview logo - no custom logo found');
                            // Jika logo kosong, gunakan logo default
                            $logoPreview.attr('src', '<?= base_url("backend/assets/images/logo sd.png") ?>');
                        }

                        // Add smooth animations
                        $('.form-floating input, .form-floating textarea').each(function(index) {
                            $(this).delay(index * 100).fadeIn(300);
                        });
                    }, 500);
                }
            });
        }

        /** Form
         ********************
         * Form Ubah Data
         * Form Detail Data
         * Validasi dan Preview File
         */
        // Menampilkan Form Ubah Data
        $('#btn-ubah').click(function() {
            // reset form
            $('#frm-profil')[0].reset();
            // hapus class was-validated pada form
            $("#frm-profil").removeClass('was-validated');

            /** tampilkan form ubah data */
            // hapus class d-none pada Card form ubah
            $('#frm-ubah').removeClass('d-none').hide().fadeIn(500);
            // tambahkan class d-none pada Card form detail
            $('#frm-detail').fadeOut(300, function() {
                $(this).addClass('d-none');
            });

            // tampilkan data profil instansi
            tampil_data_ubah();
        });

        // Menampilkan Form Detail Data
        $('#btn-batal').click(function() {
            /** tampilkan form detail data */
            // hapus class d-none pada Card form detail
            $('#frm-detail').removeClass('d-none').hide().fadeIn(500);
            // tambahkan class d-none pada Card form ubah
            $('#frm-ubah').fadeOut(300, function() {
                $(this).addClass('d-none');
            });

            // tampilkan data profil instansi
            tampil_data_detail();
        });

        // Validasi file dan preview logo sebelum diunggah
        $('#logo').change(function() {
            // mengambil value dari file
            var filePath = $('#logo').val();
            var fileSize = $('#logo')[0].files[0].size;
            // tentukan extension file yang diperbolehkan
            var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

            // Jika tipe file yang diunggah tidak sesuai dengan "allowedExtensions"
            if (!allowedExtensions.exec(filePath)) {
                // tampilkan pesan peringatan tipe file tidak sesuai menggunakan Toastr
                showToastr('Tipe file tidak sesuai. Harap unggah file yang memiliki tipe *.jpg atau *.png.', 'Peringatan!', 'warning');

                // reset input file
                $('#logo').val('');
                // tampilkan file default
                $('#logo_preview').attr('src', '<?= base_url("backend/assets/images/logo sd.png") ?>').addClass('border-danger');

                return false;
            }
            // jika ukuran file yang diunggah lebih dari 1 Mb
            else if (fileSize > 1000000) {
                // tampilkan pesan peringatan ukuran file tidak sesuai menggunakan Toastr
                showToastr('Ukuran file lebih dari 1 Mb. Harap unggah file yang memiliki ukuran maksimal 1 Mb.', 'Peringatan!', 'warning');

                // reset input file
                $('#logo').val('');
                // tampilkan file default
                $('#logo_preview').attr('src', '<?= base_url("backend/assets/images/logo sd.png") ?>').addClass('border-danger');

                return false;

                return false;
            }
            // jika file yang diunggah sudah sesuai, tampilkan preview file
            else {
                // mengambil value dari file
                var fileInput = $('#logo')[0];

                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        // preview file dengan animasi
                        $('#logo_preview')
                            .fadeOut(200, function() {
                                $(this)
                                    .attr('src', e.target.result)
                                    .removeClass('border-danger')
                                    .addClass('border-success')
                                    .fadeIn(300);
                            });
                    };
                };
                // membaca file sebagai data URL
                reader.readAsDataURL(fileInput.files[0]);
            }
        });

        // Website input formatting dan validasi
        $('#website').on('blur', function() {
            var website = $(this).val().trim();
            if (website && !website.match(/^https?:\/\//)) {
                // Auto-add https:// jika user belum menambahkan protokol
                $(this).val('https://' + website);
            }
        });

        // Real-time website validation feedback
        $('#website').on('input', function() {
            var website = $(this).val().trim();

            if (website) {
                // Simple validation: check if it looks like a domain/URL
                var isValid = false;

                // Check if it's a valid domain format
                if (website.includes('.') && website.length > 3) {
                    // Basic domain validation
                    var parts = website.split('.');
                    if (parts.length >= 2 && parts[parts.length - 1].length >= 2) {
                        isValid = true;
                    }
                }

                if (isValid) {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                } else {
                    $(this).removeClass('is-valid').addClass('is-invalid');
                }
            } else {
                $(this).removeClass('is-valid is-invalid');
            }
        });

        /** Proses
         ********************
         * Update Data
         */
        // Proses Update Data
        $('#btn-simpan').click(function(event) {
            event.preventDefault(); // Mencegah form submit default

            // Auto-format website URL sebelum validasi
            var website = $('#website').val().trim();
            if (website && !website.match(/^https?:\/\//)) {
                // Tambahkan https:// jika tidak ada protokol
                website = 'https://' + website;
                $('#website').val(website);
            }

            // Validasi form input
            if (!$('#frm-profil')[0].checkValidity()) {
                event.stopPropagation();
                $('#frm-profil').addClass('was-validated');
                return;
            }

            // Tampilkan preloader
            $('.preloader').fadeIn('slow');

            // Buat objek FormData untuk mengirim data termasuk file
            var formData = new FormData($('#frm-profil')[0]);

            // Tambahkan CSRF token
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

            // Debug: log form data
            console.log('Sending form data...');
            for (var pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            $.ajax({
                url: "<?= site_url('lembaga/updateData/' . $sekolah[0]->id_sekolah) ?>", // Sesuaikan dengan endpoint update
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "JSON",
                timeout: 30000, // 30 detik timeout
                success: function(response) {
                    $('.preloader').fadeOut('fast');
                    console.log('Server response:', response);

                    if (response && response.status === 'success') {
                        // Gunakan Toastr untuk notifikasi sukses
                        showToastr('Profil instansi berhasil diperbarui.', 'Sukses!', 'success');

                        // Redirect ke halaman data_sekolah setelah delay
                        setTimeout(function() {
                            window.location.href = '<?= base_url("sekolah/data_sekolah") ?>';
                        }, 1500);
                    } else {
                        var errorMessage = 'Terjadi kesalahan saat memperbarui data.';
                        if (response && response.message) {
                            errorMessage = response.message;
                        } else if (response && response.errors) {
                            errorMessage = 'Validasi error: ' + Object.values(response.errors).join(', ');
                        }

                        // Gunakan Toastr untuk notifikasi error
                        showToastr(errorMessage, 'Error!', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    $('.preloader').fadeOut('fast');
                    console.error("AJAX Error Details:");
                    console.error("Status:", status);
                    console.error("Error:", error);
                    console.error("Response Text:", xhr.responseText);
                    console.error("Status Code:", xhr.status);

                    var errorMessage = 'Gagal memperbarui data. ';

                    if (xhr.status === 0) {
                        errorMessage += 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                    } else if (xhr.status === 404) {
                        errorMessage += 'Endpoint tidak ditemukan (404). Periksa URL controller.';
                    } else if (xhr.status === 500) {
                        errorMessage += 'Error server internal (500). Periksa log server.';
                    } else if (xhr.status === 413) {
                        errorMessage += 'File terlalu besar untuk diupload.';
                    } else if (status === 'timeout') {
                        errorMessage += 'Request timeout. Server terlalu lama merespons.';
                    } else if (status === 'parsererror') {
                        errorMessage += 'Error parsing JSON response dari server.';
                    } else {
                        errorMessage += 'Error: ' + error + ' (Code: ' + xhr.status + ')';
                    }

                    // Gunakan Toastr untuk notifikasi error AJAX
                    showToastr(errorMessage, 'Error!', 'error');
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>