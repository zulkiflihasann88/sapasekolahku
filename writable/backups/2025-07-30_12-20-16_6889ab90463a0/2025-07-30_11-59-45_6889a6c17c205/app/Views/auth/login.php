<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Login | Sapa Sekolahku</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard backend" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>backend/assets/images/favicon.png">

    <!-- preloader css -->
    <link rel="stylesheet" href="<?= base_url() ?>backend/assets/auth_login/preloader.min.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="<?= base_url() ?>backend/assets/auth_login/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url() ?>backend/assets/auth_login/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url() ?>backend/assets/auth_login/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>
    <!-- <body data-layout="horizontal"> -->
    <div class="auth-page">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-xxl-3 col-lg-4 col-md-5">
                    <div class="auth-full-page-content d-flex p-sm-5 p-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100">
                                <div class="mb-4 mb-md-5 text-center position-relative">
                                    <a href="index" class="d-block auth-logo">
                                        <img src="<?= base_url() ?>backend/assets/images/logo-sapa.png" alt="" height="35"> <span class="logo-txt"></span>
                                    </a>
                                    <!-- Tambahkan logo sekolah di kanan atas -->
                                </div>
                                <div class="auth-content my-auto">
                                    <div class="text-center">
                                        <h5 class="mb-0">Selamat Datang</h5>
                                        <p class="text-muted mt-2">Di halaman login admin.</p>
                                        <div id="info"></div>
                                        <div id="notification" class="alert alert-danger alert-dismissible fade show mt-3 d-none" role="alert">
                                            <span id="notificationMessage"></span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        <?php if (session()->getFlashdata('error')) : ?>
                                            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                                <?= session()->getFlashdata('error') ?>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <form class="mt-4 pt-2" id="loginform" method="POST" action="<?= site_url('auth/loginProcess') ?>">

                                        <?= csrf_field() ?>
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control" name="username" id="user" placeholder="Masukkan NPSN">
                                        </div>
                                        <div class="mb-4">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Password</label>
                                                </div>
                                            </div>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input name="password" type="password" class="form-control" placeholder="Masukkan password" aria-label="Password" aria-describedby="password-addon">
                                                <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><span class="mdi mdi-eye-outline"></span></button>
                                            </div>
                                        </div>
                                        <?php include(APPPATH . 'Views/auth/_semester_tapel_options.php'); ?>
                                        <div class="mb-3">
                                            <button id="loginButton" type="submit" class="login btn btn-primary w-100 waves-effect waves-light">
                                                Log In
                                            </button>
                                            <button id="loadingButton" style="display:none;" type="button" disabled class="loding btn btn-primary w-100 waves-effect waves-light">
                                                <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>
                                                Loading...
                                            </button>
                                        </div>
                                    </form>

                                    <div class="mt-5 text-center">
                                        <p class="text-muted mb-0">Kembali ke <a href="" class="text-primary fw-semibold"> Beranda </a> </p>
                                    </div>


                                </div>
                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">©
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> SD Negeri Krengseng 02<br> Versi <b>2025.1</b>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end auth full page content -->
                </div>
                <!-- end col -->
                <div class="col-xxl-9 col-lg-8 col-md-7">
                    <div class="auth-bg pt-md-5 p-4 d-flex">
                        <div class="bg-overlay bg-primary"></div>
                        <ul class="bg-bubbles">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                        <!-- end bubble effect -->
                        <img src="<?= base_url() ?>backend/assets/images/logo sd.png" alt="Logo Sekolah" class="position-absolute top-0 end-0 me-3 mt-3" style="height: 70px;">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-xl-7">
                                <div class="p-0 p-sm-4 px-xl-0">
                                    <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-indicators carousel-indicators-rounded justify-content-start ms-0 mb-0">
                                            <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                            <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                            <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                        </div>
                                        <!-- end carouselIndicators -->
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <div class="testi-contain text-white">
                                                    <i class="bx bxs-quote-alt-left text-success display-6"></i>
                                                    <h4 class="mt-4 fw-medium lh-base text-white">“Setiap data memiliki nilai tersendiri; mengelola dan menyimpan data penting merupakan suatu bentuk pertanggung jawaban.”
                                                    </h4>
                                                    <div class="mt-4 pt-3 pb-5">
                                                        <div class="d-flex align-items-start">
                                                            <div class="flex-shrink-0">
                                                                <img src="<?= base_url() ?>backend/assets/images/layouts/gerbang.jpg" class="avatar-md img-fluid rounded-circle" alt="...">
                                                            </div>
                                                            <div class="flex-grow-1 ms-3 mb-4">
                                                                <h5 class="font-size-18 text-white">Nama
                                                                </h5>
                                                                <p class="mb-0 text-white-50">Kepala Kepala Sekolah</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="carousel-item">
                                                <div class="testi-contain text-white">
                                                    <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                    <h4 class="mt-4 fw-medium lh-base text-white">"Data yang akurat adalah pondasi pendidikan yang kuat. Dapodik adalah jantung dari perencanaan pendidikan Indonesia.”</h4>
                                                    <div class="mt-4 pt-3 pb-5">
                                                        <div class="d-flex align-items-start">
                                                            <div class="flex-shrink-0">
                                                                <img src="<?= base_url() ?>backend/assets/images/layouts/gerbang.jpg" class="avatar-md img-fluid rounded-circle" alt="...">
                                                            </div>
                                                            <div class="flex-grow-1 ms-3 mb-4">
                                                                <h5 class="font-size-18 text-white">Nama
                                                                </h5>
                                                                <p class="mb-0 text-white-50">Guru Kelas</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="carousel-item">
                                                <div class="testi-contain text-white">
                                                    <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                    <h4 class="mt-4 fw-medium lh-base text-white">“Kualitas pendidikan dimulai dari kualitas data. Dapodik menjadi landasan utama perencanaan dan evaluasi pendidikan nasional.”</h4>
                                                    <div class="mt-4 pt-3 pb-5">
                                                        <div class="d-flex align-items-start">
                                                            <img src="https://dashboard-srikandi.kendalkab.go.id/public/assets/images/demo/kendal1.png" class="avatar-md img-fluid rounded-circle" alt="...">
                                                            <div class="flex-1 ms-3 mb-4">
                                                                <h5 class="font-size-18 text-white">Nama</h5>
                                                                <p class="mb-0 text-white-50">Masyarakat
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end carousel-inner -->
                                    </div>
                                    <!-- end review carousel -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container fluid -->
    </div>

    <!-- JAVASCRIPT -->
    <script src="<?= base_url() ?>backend/assets/auth_login/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>backend/assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>backend/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url() ?>backend/assets/libs/node-waves/waves.min.js"></script>
    <!-- pace js -->
    <script src="<?= base_url() ?>backend/assets/auth_login/js/pace.min.js"></script>
    <!-- password addon init -->
    <script src="<?= base_url() ?>backend/assets/auth_login/js/pass-addon.init.js"></script>
    <script>
        function showLoading() {
            document.getElementById('loginButton').style.display = 'none';
            document.getElementById('loadingButton').style.display = 'block';
        }

        // Aktifkan validasi form
        (function() {
            'use strict';
            const form = document.getElementById('loginform');
            form.addEventListener('submit', function(event) {
                const username = document.getElementById('user').value.trim();
                const password = document.querySelector('input[name="password"]').value.trim();

                const notification = document.getElementById('notification');
                const notificationMessage = document.getElementById('notificationMessage');

                if (!username || !password) {
                    event.preventDefault();
                    if (!password) {
                        notificationMessage.textContent = 'Password perlu diisi!';
                    } else {
                        notificationMessage.textContent = 'Semua field harus diisi!';
                    }
                    notification.classList.remove('d-none');
                } else {
                    // Validasi password di server-side
                    fetch('<?= site_url('auth/validatePassword') ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                            },
                            body: JSON.stringify({
                                username,
                                password
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showLoading(); // Tampilkan tombol loading
                                notification.classList.add('d-none'); // Sembunyikan notifikasi
                                form.submit();
                                //  Lanjutkan login
                            } else {
                                event.preventDefault();
                                notificationMessage.textContent = 'Akun berhasil diverifikasi, silahkan login!';
                                notification.classList.remove('d-none');
                            }
                        })
                        .catch(error => {
                            event.preventDefault();
                            notificationMessage.textContent = 'Terjadi kesalahan saat memvalidasi password!';
                            notification.classList.remove('d-none');
                        });
                }
            });
        })();

        document.addEventListener('DOMContentLoaded', function() {
            const toastElList = [].slice.call(document.querySelectorAll('.toast'));
            toastElList.map(function(toastEl) {
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            });
        });
    </script>
</body>

</html>