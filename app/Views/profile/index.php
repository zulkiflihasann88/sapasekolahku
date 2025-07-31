<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>View Kode Klasifikasi &mdash; SDN Krengseng 02</title>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="page-content">
    <div class="container-fluid">
        <div class="profile-foreground position-relative mx-n4 mt-n4">
            <div class="profile-wid-bg">
                <img src="<?= base_url() ?>backend/assets/images/profile-bg.jpg" alt="" class="profile-wid-img">
            </div>
        </div>
        <div class="pt-4 mb-4 mb-lg-3 pb-lg-4 profile-wrapper">
            <div class="row g-4">
                <div class="col-auto">
                    <div class="avatar-lg">
                        <img src="<?= base_url() ?>backend/assets/images/users/avatar-1.jpg" alt="user-img" class="img-thumbnail rounded-circle">
                    </div>
                </div>
                <!--end col-->
                <div class="col">
                    <div class="p-2">
                        <h3 class="text-white mb-1"><?= userLogin()->name_user ?></h3>
                        <p class="text-white text-opacity-75"><?= userLogin()->username ?></p>
                        <div class="hstack text-white-50 gap-1">
                            <div class="me-2"><i class="ri-map-pin-user-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>Tangerang Selatan, Indonesia</div>
                            <div>
                                <i class="ri-building-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>Sekolah Dasar Negeri
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
                <div class="col-12 col-lg-auto order-last order-lg-0">
                    <div class="row text text-white-50 text-center">
                        <div class="col-lg-6 col-4">
                            <div class="p-2">
                                <h4 class="text-white mb-1"><?= isset($total_siswa) ? $total_siswa : '0' ?></h4>
                                <p class="fs-14 mb-0">Total Siswa</p>
                                <?php if (isset($tahun_ajaran_info) && is_object($tahun_ajaran_info) && isset($tahun_ajaran_info->tahun_ajaran)): ?>
                                    <small class="text-white-50">TA <?= $tahun_ajaran_info->tahun_ajaran ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-4">
                            <div class="p-2">
                                <h4 class="text-white mb-1"><?= isset($total_pengajar) ? $total_pengajar : '0' ?></h4>
                                <p class="fs-14 mb-0">Tenaga Pengajar</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->

            </div>
            <!--end row-->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div>
                    <div class="d-flex profile-wrapper">
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link fs-14 active" data-bs-toggle="tab" href="#overview-tab" role="tab" aria-selected="true">
                                    <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Overview</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link fs-14" data-bs-toggle="tab" href="#activities" role="tab" aria-selected="false" tabindex="-1">
                                    <i class="ri-list-unordered d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Activities</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link fs-14" data-bs-toggle="tab" href="#projects" role="tab" aria-selected="false" tabindex="-1">
                                    <i class="ri-price-tag-line d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Projects</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link fs-14" data-bs-toggle="tab" href="#documents" role="tab" aria-selected="false" tabindex="-1">
                                    <i class="ri-folder-4-line d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Documents</span>
                                </a>
                            </li>
                        </ul>
                        <div class="flex-shrink-0">
                            <a href="<?= site_url('lembaga') ?>" class="btn btn-success"><i class="ri-edit-box-line align-bottom"></i> Edit Profile</a>
                        </div>
                    </div>
                    <!-- Tab panes -->
                    <div class="tab-content pt-4 text-muted">
                        <div class="tab-pane active" id="overview-tab" role="tabpanel">
                            <div class="row">
                                <div class="col-xxl-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mb-5">Kelengkapan Profil Sekolah</h5>
                                            <div class="progress animated-progress custom-progress progress-label">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="label">85%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">Info Sekolah</h5>
                                            <div class="table-responsive">
                                                <table class="table table-borderless mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th class="ps-0" scope="row">Nama Sekolah :</th>
                                                            <td class="text-muted">SDN Krengseng 02</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="ps-0" scope="row">Telp :</th>
                                                            <td class="text-muted">(021) 7301-234</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="ps-0" scope="row">E-mail :</th>
                                                            <td class="text-muted">sdnkrengseng02@gmail.com</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="ps-0" scope="row">Alamat :</th>
                                                            <td class="text-muted">Jl. Raya Krengseng No. 02, Kecamatan Graha Raya, Tangerang Selatan
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="ps-0" scope="row">Tahun Ajaran</th>
                                                            <td class="text-muted"> 2024/2025</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->

                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mb-4">Media Sosial</h5>
                                            <div class="d-flex flex-wrap gap-2">
                                                <div>
                                                    <a href="javascript:void(0);" class="avatar-xs d-block">
                                                        <span class="avatar-title rounded-circle fs-16 bg-primary material-shadow">
                                                            <i class="ri-facebook-fill"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0);" class="avatar-xs d-block">
                                                        <span class="avatar-title rounded-circle fs-16 bg-danger material-shadow">
                                                            <i class="ri-instagram-fill"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0);" class="avatar-xs d-block">
                                                        <span class="avatar-title rounded-circle fs-16 bg-success material-shadow">
                                                            <i class=" ri-chrome-fill"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0);" class="avatar-xs d-block">
                                                        <span class="avatar-title rounded-circle fs-16 bg-danger material-shadow">
                                                            <i class="ri-youtube-fill"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->

                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mb-4">Kelas</h5>
                                            <div class="d-flex flex-wrap gap-2 fs-15">
                                                <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary">Kelas I</a>
                                                <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary">Kelas II</a>
                                                <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary">Kelas III</a>
                                                <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary">Kelas IV</a>
                                                <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary">Kelas V</a>
                                                <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary">Kelas VI</a>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->

                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-4">
                                                <div class="flex-grow-1">
                                                    <h5 class="card-title mb-0">Tenaga Pengajar</h5>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="dropdown">
                                                        <a href="#" role="button" id="dropdownMenuLink2" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-2-fill fs-14"></i>
                                                        </a>

                                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink2">
                                                            <li><a class="dropdown-item" href="#">View</a></li>
                                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                                            <li><a class="dropdown-item" href="#">Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="d-flex align-items-center py-3">
                                                    <div class="avatar-xs flex-shrink-0 me-3">
                                                        <img src="<?= base_url() ?>backend/assets/images/users/avatar-3.jpg" alt="" class="img-fluid rounded-circle material-shadow">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div>
                                                            <h5 class="fs-14 mb-1">Siti Nurhaliza, S.Pd</h5>
                                                            <p class="fs-13 text-muted mb-0">Guru Kelas I</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <button type="button" class="btn btn-sm btn-outline-primary material-shadow-none"><i class="ri-eye-line align-middle"></i></button>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center py-3">
                                                    <div class="avatar-xs flex-shrink-0 me-3">
                                                        <img src="<?= base_url() ?>backend/assets/images/users/avatar-4.jpg" alt="" class="img-fluid rounded-circle material-shadow">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div>
                                                            <h5 class="fs-14 mb-1">Ahmad Wijaya, S.Pd</h5>
                                                            <p class="fs-13 text-muted mb-0">Guru Matematika</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <button type="button" class="btn btn-sm btn-outline-primary material-shadow-none"><i class="ri-eye-line align-middle"></i></button>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center py-3">
                                                    <div class="avatar-xs flex-shrink-0 me-3">
                                                        <img src="<?= base_url() ?>backend/assets/images/users/avatar-1.jpg" alt="" class="img-fluid rounded-circle material-shadow">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div>
                                                            <h5 class="fs-14 mb-1">Rina Marlina, S.Pd</h5>
                                                            <p class="fs-13 text-muted mb-0">Guru Bahasa Indonesia</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <button type="button" class="btn btn-sm btn-outline-primary material-shadow-none"><i class="ri-eye-line align-middle"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div>
                                    <!--end card-->

                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-4">
                                                <div class="flex-grow-1">
                                                    <h5 class="card-title mb-0">Kegiatan Terbaru</h5>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="dropdown">
                                                        <a href="#" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-2-fill fs-14"></i>
                                                        </a>

                                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink1">
                                                            <li><a class="dropdown-item" href="#">View</a></li>
                                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                                            <li><a class="dropdown-item" href="#">Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex mb-4">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 50px; width: 80px;">
                                                        <i class="ri-flag-line text-muted"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3 overflow-hidden">
                                                    <a href="javascript:void(0);">
                                                        <h6 class="text-truncate fs-14">Upacara Peringatan Hari Pendidikan Nasional</h6>
                                                    </a>
                                                    <p class="text-muted mb-0">02 Mei 2024</p>
                                                </div>
                                            </div>
                                            <div class="d-flex mb-4">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 50px; width: 80px;">
                                                        <i class="ri-book-line text-muted"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3 overflow-hidden">
                                                    <a href="javascript:void(0);">
                                                        <h6 class="text-truncate fs-14">Pelaksanaan Ujian Tengah Semester</h6>
                                                    </a>
                                                    <p class="text-muted mb-0">15 Maret 2024</p>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 50px; width: 80px;">
                                                        <i class="ri-trophy-line text-muted"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3 overflow-hidden">
                                                    <a href="javascript:void(0);">
                                                        <h6 class="text-truncate fs-14">Perlombaan Olahraga Antar Kelas</h6>
                                                    </a>
                                                    <p class="text-muted mb-0">10 Februari 2024</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end card-body-->
                                    </div>
                                    <!--end card-->
                                </div>
                                <!--end col-->
                                <div class="col-xxl-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">VISI - MISI</h5>
                                            <p>SDN Krengseng 02 berkomitmen untuk memberikan pendidikan berkualitas yang membangun karakter siswa dengan landasan nilai-nilai keagamaan dan budaya. Kami mengutamakan pembelajaran yang menyenangkan dan inovatif untuk mewujudkan generasi yang cerdas dan berkarakter.</p>
                                            <div class="mb-4">
                                                <h6 class="text-primary fw-semibold mb-2"><i class="ri-eye-line me-2"></i>VISI</h6>
                                                <p class="bg-light p-3 rounded mb-3">"Mewujudkan sekolah yang unggul dalam prestasi, berkarakter mulia, dan berwawasan lingkungan berdasarkan iman dan taqwa."</p>

                                                <h6 class="text-primary fw-semibold mb-2"><i class="ri-flag-line me-2"></i>MISI</h6>
                                                <ul class="list-unstyled mb-0">
                                                    <li class="mb-2"><i class="ri-check-line text-success me-2"></i>Melaksanakan pembelajaran yang aktif, inovatif, kreatif, efektif dan menyenangkan</li>
                                                    <li class="mb-2"><i class="ri-check-line text-success me-2"></i>Menumbuhkan semangat keunggulan kepada seluruh warga sekolah</li>
                                                    <li class="mb-2"><i class="ri-check-line text-success me-2"></i>Menciptakan lingkungan sekolah yang bersih, sehat, dan nyaman</li>
                                                    <li class="mb-2"><i class="ri-check-line text-success me-2"></i>Menanamkan nilai-nilai agama dan budaya dalam kehidupan sehari-hari</li>
                                                </ul>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 col-md-4">
                                                    <div class="d-flex mt-4">
                                                        <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                                            <div class="avatar-title bg-light rounded-circle fs-16 text-primary material-shadow">
                                                                <i class="ri-user-2-fill"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="mb-1">Kepala Sekolah :</p>
                                                            <h6 class="text-truncate mb-0">Dra. Siti Aminah, M.Pd</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-6 col-md-4">
                                                    <div class="d-flex mt-4">
                                                        <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                                            <div class="avatar-title bg-light rounded-circle fs-16 text-primary material-shadow">
                                                                <i class="ri-global-line"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="mb-1">Website :</p>
                                                            <a href="http://sdnkrengseng02.sch.id" class="fw-semibold">www.sdnkrengseng02.sch.id</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </div>
                                        <!--end card-body-->
                                    </div><!-- end card -->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header align-items-center d-flex">
                                                    <h4 class="card-title mb-0  me-2">Kegiatan Terbaru</h4>
                                                    <div class="flex-shrink-0 ms-auto">
                                                        <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link active" data-bs-toggle="tab" href="#today" role="tab" aria-selected="true">
                                                                    Hari Ini
                                                                </a>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link" data-bs-toggle="tab" href="#weekly" role="tab" aria-selected="false" tabindex="-1">
                                                                    Mingguan
                                                                </a>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link" data-bs-toggle="tab" href="#monthly" role="tab" aria-selected="false" tabindex="-1">
                                                                    Bulanan
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="tab-content text-muted">
                                                        <div class="tab-pane active" id="today" role="tabpanel">
                                                            <div class="profile-timeline">
                                                                <div class="accordion accordion-flush" id="todayExample">
                                                                    <div class="accordion-item border-0">
                                                                        <div class="accordion-header" id="headingOne">
                                                                            <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="true">
                                                                                <div class="d-flex">
                                                                                    <div class="flex-shrink-0">
                                                                                        <img src="<?= base_url() ?>backend/assets/images/users/avatar-2.jpg" alt="" class="avatar-xs rounded-circle material-shadow">
                                                                                    </div>
                                                                                    <div class="flex-grow-1 ms-3">
                                                                                        <h6 class="fs-14 mb-1">
                                                                                            Jacqueline Steve
                                                                                        </h6>
                                                                                        <small class="text-muted">We has changed 2 attributes on 05:16PM</small>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                                            <div class="accordion-body ms-2 ps-5">
                                                                                In an awareness campaign, it is vital for people to begin put 2 and 2 together and begin to recognize your cause. Too much or too little spacing, as in the example below, can make things unpleasant for the reader. The goal is to make your text as comfortable to read as possible. A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="accordion-item border-0">
                                                                        <div class="accordion-header" id="headingTwo">
                                                                            <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseTwo" aria-expanded="false">
                                                                                <div class="d-flex">
                                                                                    <div class="flex-shrink-0 avatar-xs">
                                                                                        <div class="avatar-title bg-light text-success rounded-circle material-shadow">
                                                                                            M
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="flex-grow-1 ms-3">
                                                                                        <h6 class="fs-14 mb-1">
                                                                                            Megan Elmore
                                                                                        </h6>
                                                                                        <small class="text-muted">Adding a new event with attachments - 04:45PM</small>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                        <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                                            <div class="accordion-body ms-2 ps-5">
                                                                                <div class="row g-2">
                                                                                    <div class="col-auto">
                                                                                        <div class="d-flex border border-dashed p-2 rounded position-relative">
                                                                                            <div class="flex-shrink-0">
                                                                                                <i class="ri-image-2-line fs-17 text-danger"></i>
                                                                                            </div>
                                                                                            <div class="flex-grow-1 ms-2">
                                                                                                <h6>
                                                                                                    <a href="javascript:void(0);" class="stretched-link">Business Template - UI/UX design</a>
                                                                                                </h6>
                                                                                                <small>685 KB</small>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-auto">
                                                                                        <div class="d-flex border border-dashed p-2 rounded position-relative">
                                                                                            <div class="flex-shrink-0">
                                                                                                <i class="ri-file-zip-line fs-17 text-info"></i>
                                                                                            </div>
                                                                                            <div class="flex-grow-1 ms-2">
                                                                                                <h6 class="mb-0">
                                                                                                    <a href="javascript:void(0);" class="stretched-link">Bank Management System - PSD</a>
                                                                                                </h6>
                                                                                                <small>8.78 MB</small>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="accordion-item border-0">
                                                                        <div class="accordion-header" id="headingThree">
                                                                            <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapsethree" aria-expanded="false">
                                                                                <div class="d-flex">
                                                                                    <div class="flex-shrink-0">
                                                                                        <img src="<?= base_url() ?>backend/assets/images/users/avatar-2.jpg" alt="" class="avatar-xs rounded-circle material-shadow">
                                                                                    </div>
                                                                                    <div class="flex-grow-1 ms-3">
                                                                                        <h6 class="fs-14 mb-1"> New ticket received</h6>
                                                                                        <small class="text-muted mb-2">User <span class="text-secondary">Erica245</span> submitted a ticket - 02:33PM</small>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="accordion-item border-0">
                                                                        <div class="accordion-header" id="headingFour">
                                                                            <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseFour" aria-expanded="true">
                                                                                <div class="d-flex">
                                                                                    <div class="flex-shrink-0 avatar-xs">
                                                                                        <div class="avatar-title bg-light text-muted rounded-circle material-shadow">
                                                                                            <i class="ri-user-3-fill"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="flex-grow-1 ms-3">
                                                                                        <h6 class="fs-14 mb-1">
                                                                                            Nancy Martino
                                                                                        </h6>
                                                                                        <small class="text-muted">Commented on 12:57PM</small>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                        <div id="collapseFour" class="accordion-collapse collapse show" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                                                            <div class="accordion-body ms-2 ps-5 fst-italic">
                                                                                " A wonderful serenity has
                                                                                taken possession of my
                                                                                entire soul, like these
                                                                                sweet mornings of spring
                                                                                which I enjoy with my whole
                                                                                heart. Each design is a new,
                                                                                unique piece of art birthed
                                                                                into this world, and while
                                                                                you have the opportunity to
                                                                                be creative and make your
                                                                                own style choices. "
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="accordion-item border-0">
                                                                        <div class="accordion-header" id="headingFive">
                                                                            <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseFive" aria-expanded="true">
                                                                                <div class="d-flex">
                                                                                    <div class="flex-shrink-0">
                                                                                        <img src="<?= base_url() ?>backend/assets/images/users/avatar-2.jpg" alt="" class="avatar-xs rounded-circle material-shadow">
                                                                                    </div>
                                                                                    <div class="flex-grow-1 ms-3">
                                                                                        <h6 class="fs-14 mb-1">
                                                                                            Lewis Arnold
                                                                                        </h6>
                                                                                        <small class="text-muted">Create new project buildng product - 10:05AM</small>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                        <div id="collapseFive" class="accordion-collapse collapse show" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                                                            <div class="accordion-body ms-2 ps-5">
                                                                                <p class="text-muted mb-2"> Every team project can have a velzon. Use the velzon to share information with your team to understand and contribute to your project.</p>
                                                                                <div class="avatar-group">
                                                                                    <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="" data-bs-original-title="Christi">
                                                                                        <img src="<?= base_url() ?>backend/assets/images/users/avatar-4.jpg" alt="" class="rounded-circle avatar-xs material-shadow">
                                                                                    </a>
                                                                                    <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="" data-bs-original-title="Frank Hook">
                                                                                        <img src="<?= base_url() ?>backend/assets/images/users/avatar-3.jpg" alt="" class="rounded-circle avatar-xs material-shadow">
                                                                                    </a>
                                                                                    <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="" data-bs-original-title=" Ruby">
                                                                                        <div class="avatar-xs">
                                                                                            <div class="avatar-title rounded-circle bg-light text-primary material-shadow">
                                                                                                R
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                    <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="" data-bs-original-title="more">
                                                                                        <div class="avatar-xs">
                                                                                            <div class="avatar-title rounded-circle material-shadow">
                                                                                                2+
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!--end accordion-->
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="weekly" role="tabpanel">
                                                            <div class="profile-timeline">
                                                                <div class="accordion accordion-flush" id="weeklyExample">
                                                                    <div class="accordion-item border-0">
                                                                        <div class="accordion-header" id="heading6">
                                                                            <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapse6" aria-expanded="true">
                                                                                <div class="d-flex">
                                                                                    <div class="flex-shrink-0">
                                                                                        <img src="<?= base_url() ?>backend/assets/images/users/avatar-3.jpg" alt="" class="avatar-xs rounded-circle material-shadow">
                                                                                    </div>
                                                                                    <div class="flex-grow-1 ms-3">
                                                                                        <h6 class="fs-14 mb-1">
                                                                                            Joseph Parker
                                                                                        </h6>
                                                                                        <small class="text-muted">New people joined with our company - Yesterday</small>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                        <div id="collapse6" class="accordion-collapse collapse show" aria-labelledby="heading6" data-bs-parent="#accordionExample">
                                                                            <div class="accordion-body ms-2 ps-5">
                                                                                It makes a statement, it’s
                                                                                impressive graphic design.
                                                                                Increase or decrease the
                                                                                letter spacing depending on
                                                                                the situation and try, try
                                                                                again until it looks right,
                                                                                and each letter has the
                                                                                perfect spot of its own.
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="accordion-item border-0">
                                                                        <div class="accordion-header" id="heading7">
                                                                            <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapse7" aria-expanded="false">
                                                                                <div class="d-flex">
                                                                                    <div class="avatar-xs">
                                                                                        <div class="avatar-title rounded-circle bg-light text-danger material-shadow">
                                                                                            <i class="ri-shopping-bag-line"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="flex-grow-1 ms-3">
                                                                                        <h6 class="fs-14 mb-1">
                                                                                            Your order is placed <span class="badge bg-success-subtle text-success align-middle">Completed</span>
                                                                                        </h6>
                                                                                        <small class="text-muted">These customers can rest assured their order has been placed - 1 week Ago</small>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="accordion-item border-0">
                                                                        <div class="accordion-header" id="heading8">
                                                                            <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapse8" aria-expanded="true">
                                                                                <div class="d-flex">
                                                                                    <div class="flex-shrink-0 avatar-xs">
                                                                                        <div class="avatar-title bg-light text-success rounded-circle material-shadow">
                                                                                            <i class="ri-home-3-line"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="flex-grow-1 ms-3">
                                                                                        <h6 class="text-truncate fs-14 mb-1">
                                                                                            Velzon admin dashboard templates layout upload
                                                                                        </h6>
                                                                                        <small class="text-muted">We talked about a project on linkedin - 1 week Ago</small>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                        <div id="collapse8" class="accordion-collapse collapse show" aria-labelledby="heading8" data-bs-parent="#accordionExample">
                                                                            <div class="accordion-body ms-2 ps-5 fst-italic">
                                                                                Powerful, clean &amp; modern
                                                                                responsive bootstrap 5 admin
                                                                                template. The maximum file
                                                                                size for uploads in this demo :
                                                                                <div class="row mt-2">
                                                                                    <div class="col-xxl-6">
                                                                                        <div class="row border border-dashed gx-2 p-2">
                                                                                            <div class="col-3">
                                                                                                <img src="<?= base_url() ?>backend/assets/images/small/img-3.jpg" alt="" class="img-fluid rounded material-shadow">
                                                                                            </div>
                                                                                            <!--end col-->
                                                                                            <div class="col-3">
                                                                                                <img src="<?= base_url() ?>backend/assets/images/small/img-5.jpg" alt="" class="img-fluid rounded material-shadow">
                                                                                            </div>
                                                                                            <!--end col-->
                                                                                            <div class="col-3">
                                                                                                <img src="<?= base_url() ?>backend/assets/images/small/img-7.jpg" alt="" class="img-fluid rounded material-shadow">
                                                                                            </div>
                                                                                            <!--end col-->
                                                                                            <div class="col-3">
                                                                                                <img src="<?= base_url() ?>backend/assets/images/small/img-9.jpg" alt="" class="img-fluid rounded material-shadow">
                                                                                            </div>
                                                                                            <!--end col-->
                                                                                        </div>
                                                                                        <!--end row-->
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="accordion-item border-0">
                                                                        <div class="accordion-header" id="heading9">
                                                                            <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapse9" aria-expanded="false">
                                                                                <div class="d-flex">
                                                                                    <div class="flex-shrink-0">
                                                                                        <img src="<?= base_url() ?>backend/assets/images/users/avatar-1.jpg" alt="" class="avatar-xs rounded-circle material-shadow">
                                                                                    </div>
                                                                                    <div class="flex-grow-1 ms-3">
                                                                                        <h6 class="fs-14 mb-1">
                                                                                            New ticket created <span class="badge bg-info-subtle text-info align-middle">Inprogress</span>
                                                                                        </h6>
                                                                                        <small class="text-muted mb-2">User <span class="text-secondary">Jack365</span> submitted a ticket - 2 week Ago</small>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="accordion-item border-0">
                                                                        <div class="accordion-header" id="heading10">
                                                                            <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapse10" aria-expanded="true">
                                                                                <div class="d-flex">
                                                                                    <div class="flex-shrink-0">
                                                                                        <img src="<?= base_url() ?>backend/assets/images/users/avatar-2.jpg" alt="" class="avatar-xs rounded-circle material-shadow">
                                                                                    </div>
                                                                                    <div class="flex-grow-1 ms-3">
                                                                                        <h6 class="fs-14 mb-1">
                                                                                            Jennifer Carter
                                                                                        </h6>
                                                                                        <small class="text-muted">Commented - 4 week Ago</small>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                        <div id="collapse10" class="accordion-collapse collapse show" aria-labelledby="heading10" data-bs-parent="#accordionExample">
                                                                            <div class="accordion-body ms-2 ps-5">
                                                                                <p class="text-muted fst-italic mb-2">
                                                                                    " This is an awesome
                                                                                    admin dashboard
                                                                                    template. It is
                                                                                    extremely well
                                                                                    structured and uses
                                                                                    state of the art
                                                                                    components (e.g. one of
                                                                                    the only templates using
                                                                                    boostrap 5.1.3 so far).
                                                                                    I integrated it into a
                                                                                    Rails 6 project. Needs
                                                                                    manual integration work
                                                                                    of course but the
                                                                                    template structure made
                                                                                    it easy. "</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!--end accordion-->
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="monthly" role="tabpanel">
                                                            <div class="profile-timeline">
                                                                <div class="accordion accordion-flush" id="monthlyExample">
                                                                    <div class="accordion-item border-0">
                                                                        <div class="accordion-header" id="heading11">
                                                                            <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapse11" aria-expanded="false">
                                                                                <div class="d-flex">
                                                                                    <div class="flex-shrink-0 avatar-xs">
                                                                                        <div class="avatar-title bg-light text-success rounded-circle material-shadow">
                                                                                            M
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="flex-grow-1 ms-3">
                                                                                        <h6 class="fs-14 mb-1">
                                                                                            Megan Elmore
                                                                                        </h6>
                                                                                        <small class="text-muted">Adding a new event with attachments - 1 month Ago.</small>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                        <div id="collapse11" class="accordion-collapse collapse show" aria-labelledby="heading11" data-bs-parent="#accordionExample">
                                                                            <div class="accordion-body ms-2 ps-5">
                                                                                <div class="row g-2">
                                                                                    <div class="col-auto">
                                                                                        <div class="d-flex border border-dashed p-2 rounded position-relative">
                                                                                            <div class="flex-shrink-0">
                                                                                                <i class="ri-image-2-line fs-17 text-danger"></i>
                                                                                            </div>
                                                                                            <div class="flex-grow-1 ms-2">
                                                                                                <h6 class="mb-0">
                                                                                                    <a href="javascript:void(0);" class="stretched-link">Business Template - UI/UX design</a>
                                                                                                </h6>
                                                                                                <small>685 KB</small>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-auto">
                                                                                        <div class="d-flex border border-dashed p-2 rounded position-relative">
                                                                                            <div class="flex-shrink-0">
                                                                                                <i class="ri-file-zip-line fs-17 text-info"></i>
                                                                                            </div>
                                                                                            <div class="flex-grow-1 ms-2">
                                                                                                <h6 class="mb-0">
                                                                                                    <a href="javascript:void(0);" class="stretched-link">Bank Management System - PSD</a>
                                                                                                </h6>
                                                                                                <small>8.78 MB</small>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-auto">
                                                                                        <div class="d-flex border border-dashed p-2 rounded position-relative">
                                                                                            <div class="flex-shrink-0">
                                                                                                <i class="ri-file-zip-line fs-17 text-info"></i>
                                                                                            </div>
                                                                                            <div class="flex-grow-1 ms-2">
                                                                                                <?= $this->endSection() ?>