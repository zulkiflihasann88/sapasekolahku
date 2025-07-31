<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Home &mdash; Aplikasi Age</title>
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-content">
    <div class="container-fluid">

        <!-- Enhanced Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-sm-0 font-size-18">
                            <i class="mdi mdi-view-dashboard me-2 text-primary"></i>
                            Dashboard Sekolah
                        </h4>
                        <p class="text-muted mb-0">Sistem Informasi Manajemen Sekolah</p>
                    </div>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);" class="text-decoration-none">
                                    <i class="mdi mdi-home-outline me-1"></i>Beranda
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->include('components/tahun_ajaran_indicator') ?>

        <div class="row">
            <div class="col-xl-4">
                <!-- Welcome Card Enhancement -->
                <div class="card dashboard-card welcome-card">
                    <div class="welcome-content">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-white p-3">
                                    <h5 class="text-white mb-1">Selamat Datang !</h5>
                                    <p class="mb-0 opacity-75">Sistem Informasi Sekolah</p>
                                    <small class="opacity-75">Dashboard Administrator</small>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <div class="img-container">
                                    <img src="<?= base_url() ?>backend/assets/images/profile-img.svg" alt="" class="img-fluid" style="filter: brightness(1.1);" onerror="this.parentElement.classList.add('error')">
                                    <div class="fallback profile-img-fallback">
                                        <div class="content">
                                            <i class="mdi mdi-school font-size-24 mb-2"></i>
                                            <div>Sekolahku</div>
                                            <small>Dashboard</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Section Enhancement -->
                <div class="card dashboard-card profile-section">
                    <div class="card-body pt-3">
                        <div class="row align-items-center">
                            <div class="col-sm-4 text-center">
                                <div class="profile-avatar mb-3">
                                    <div class="img-container">
                                        <img src="<?= base_url() ?>backend/assets/images/users/avatar-2.jpg" alt="" class="img-thumbnail rounded-circle" style="width: 80px; height: 80px; object-fit: cover;" onerror="this.parentElement.classList.add('error')">
                                        <div class="fallback avatar-fallback">
                                            <i class="mdi mdi-account"></i>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="font-size-15 text-white mb-1">Admin Sekolah</h6>
                                <p class="text-white-50 mb-0 small">Administrator</p>
                            </div>

                            <div class="col-sm-8">
                                <div class="pt-2">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <h5 class="font-size-18 text-white mb-1"><?= date('d') ?></h5>
                                            <p class="text-white-50 mb-0 small">Hari Ini</p>
                                        </div>
                                        <div class="col-6">
                                            <h5 class="font-size-18 text-white mb-1"><?= date('m') ?></h5>
                                            <p class="text-white-50 mb-0 small">Bulan Ini</p>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <a href="<?= base_url('profile') ?>" class="btn btn-light btn-enhanced waves-effect waves-light btn-sm">
                                            <i class="mdi mdi-account-circle me-1"></i>Lihat Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Enhanced Statistics Cards -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card mini-stats-wid dashboard-card stat-card-enhanced">
                            <div class="card-body bg-gradient-blue text-white position-relative">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-users stat-icon"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3 text-end">
                                        <?php
                                        // Hitung total pendaftar dari tabel calon siswa
                                        $db = db_connect();
                                        $total_pendaftar = $db->table('db_calonpeserta')->countAllResults();
                                        ?>
                                        <h3 class="mb-0 stat-number"><?= $total_pendaftar ?></h3>
                                        <div class="notification-dot"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body border-top py-3 bg-white">
                                <h6 class="mb-0 text-enhanced">
                                    <i class="fas fa-users font-size-14 me-2 text-primary"></i>
                                    Total Pendaftar
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card mini-stats-wid dashboard-card stat-card-enhanced">
                            <div class="card-body bg-gradient-green text-white position-relative">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="far fa-check-circle stat-icon"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3 text-end">
                                        <?php
                                        // Patch: tampilkan semua calon peserta yang status_daftar_ulang != 1 (bukan sudah verifikasi/daftar ulang)
                                        $perlu_verifikasi = $db->table('db_calonpeserta')->where('status_daftar_ulang !=', 1)->countAllResults();
                                        ?>
                                        <h3 class="mb-0 stat-number"><?= $perlu_verifikasi ?></h3>
                                        <div class="notification-dot" style="background: #ffc107;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body border-top py-3 bg-white">
                                <h6 class="mb-0 text-enhanced">
                                    <i class="far fa-check-circle font-size-14 me-2 text-success"></i>
                                    Perlu Verifikasi
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Gender Statistics Cards -->
                <div class="row">
                    <?php
                    // Hitung jumlah laki-laki dan perempuan yang mendaftar dari db_calonpeserta
                    $db = db_connect();
                    $laki_daftar = $db->table('db_calonpeserta')->where('jenis_kelamin', 'L')->countAllResults();
                    $perempuan_daftar = $db->table('db_calonpeserta')->where('jenis_kelamin', 'P')->countAllResults();
                    ?>
                    <div class="col-lg-6">
                        <div class="card mini-stats-wid dashboard-card stat-card-enhanced">
                            <div class="card-body bg-gradient-yellow text-white position-relative">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="far fa-user stat-icon"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3 text-end">
                                        <h3 class="mb-0 stat-number"><?= $laki_daftar ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body border-top py-3 bg-white">
                                <h6 class="mb-0 text-enhanced">
                                    <i class="far fa-user font-size-14 me-2 text-warning"></i>
                                    Laki - laki
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card mini-stats-wid dashboard-card stat-card-enhanced">
                            <div class="card-body bg-gradient-pink text-white position-relative">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="far fa-user stat-icon"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3 text-end">
                                        <h3 class="mb-0 stat-number"><?= $perempuan_daftar ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body border-top py-3 bg-white">
                                <h6 class="mb-0 text-enhanced">
                                    <i class="far fa-user font-size-14 me-2 text-danger"></i>
                                    Perempuan
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Enhanced Monthly Earning Card -->
                <div class="card dashboard-card earning-card">
                    <div class="card-body">
                        <h4 class="card-title mb-4 text-white">
                            <i class="mdi mdi-chart-line me-2"></i>Statistik Bulanan
                        </h4>
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <p class="text-white-50 mb-2">Bulan ini</p>
                                <h3 class="earning-value mb-2"><?= date('M Y') ?></h3>
                                <p class="text-white-50 mb-3">
                                    <span class="text-warning me-2">
                                        <i class="mdi mdi-trending-up"></i> +12%
                                    </span>
                                    Dari periode sebelumnya
                                </p>

                                <div class="mt-4">
                                    <a href="javascript: void(0);" class="btn btn-light btn-enhanced waves-effect waves-light btn-sm">
                                        <i class="mdi mdi-chart-bar me-1"></i>Lihat Detail
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mt-4 mt-sm-0 text-center">
                                    <div class="glass-effect p-3 rounded">
                                        <h5 class="text-white mb-1"><?= $total_pendaftar + $laki_daftar + $perempuan_daftar ?></h5>
                                        <p class="text-white-50 mb-0 small">Total Aktivitas</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-white-50 mb-0 mt-3">
                            <i class="mdi mdi-information-outline me-1"></i>
                            Data terupdate secara real-time
                        </p>
                    </div>
                </div>

            </div>
            <div class="col-xl-8">
                <!-- Enhanced Top Statistics Row -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid dashboard-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium mb-2">Siswa Aktif</p>
                                        <h4 class="mb-0 text-primary stat-number">
                                            <?= isset($siswa_aktif) ? $siswa_aktif : 0 ?>
                                        </h4>
                                        <small class="text-muted">
                                            <i class="mdi mdi-trending-up text-success"></i>
                                            <?php
                                            if (isset($tahun_ajaran_info) && is_object($tahun_ajaran_info) && isset($tahun_ajaran_info->tahun_ajaran)) {
                                                echo 'TA ' . $tahun_ajaran_info->tahun_ajaran;
                                            } else {
                                                echo 'Siswa terdaftar';
                                            }
                                            ?>
                                        </small>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                            <span class="avatar-title">
                                                <i class="mdi mdi-account-outline font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid dashboard-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium mb-2">PTK/GTK</p>
                                        <h4 class="mb-0 text-success stat-number"><?= isset($total_ptk) ? $total_ptk : 0 ?></h4>
                                        <small class="text-muted">
                                            <i class="mdi mdi-account-check text-success"></i>
                                            Tenaga pendidik
                                        </small>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="avatar-sm rounded-circle bg-success mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-success">
                                                <i class="bx bx-user-check font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid dashboard-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium mb-2">Mata Pelajaran</p>
                                        <h4 class="mb-0 text-info stat-number"><?= isset($total_mapel) ? $total_mapel : 0 ?></h4>
                                        <small class="text-muted">
                                            <i class="mdi mdi-book-open text-info"></i>
                                            Mapel tersedia
                                        </small>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="avatar-sm rounded-circle bg-info mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-info">
                                                <i class="bx bx-book-bookmark font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Enhanced Chart Section -->
                <?php
                // Gunakan data dari controller jika ada, fallback ke query lama jika tidak ada
                if (isset($chart_data) && !empty($chart_data)) {
                    $categories = $chart_data['categories'];
                    $dataLaki = $chart_data['data_laki'];
                    $dataPerempuan = $chart_data['data_perempuan'];
                } else {
                    // Fallback: gunakan query lama (tidak filtered tahun ajaran)
                    $db = db_connect();
                    // Ambil siswa aktif dari semester history, join ke rombel
                    $kelasList = $db->table('db_siswa_semester_history sh')
                        ->select('sh.id_rombel')
                        ->where('sh.status_siswa', 'aktif')
                        ->groupBy('sh.id_rombel')
                        ->orderBy('sh.id_rombel', 'ASC')
                        ->get()->getResult();
                    $categories = [];
                    $dataLaki = [];
                    $dataPerempuan = [];
                    foreach ($kelasList as $rowKelas) {
                        $id_rombel = $rowKelas->id_rombel;
                        $rombel = $db->table('db_rombel')->select('kelas, rombel')->where('id_rombel', $id_rombel)->get()->getRow();
                        $nama_kelas = $rombel ? ($rombel->kelas . ' - ' . $rombel->rombel) : 'Tanpa Kelas';
                        $categories[] = $nama_kelas;
                        $dataLaki[] = $db->table('db_siswa_semester_history')
                            ->where('id_rombel', $id_rombel)
                            ->where('status_siswa', 'aktif')
                            ->where('jk', 'L')
                            ->countAllResults();
                        $dataPerempuan[] = $db->table('db_siswa_semester_history')
                            ->where('id_rombel', $id_rombel)
                            ->where('status_siswa', 'aktif')
                            ->where('jk', 'P')
                            ->countAllResults();
                    }
                }
                ?>
                <div class="card dashboard-card chart-container">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h4 class="card-title mb-0">
                                <i class="mdi mdi-chart-bar me-2 text-primary"></i>
                                Rekap Laki-laki & Perempuan per Kelas
                            </h4>
                            <div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="mdi mdi-filter-variant me-1"></i>Filter
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Semua Kelas</a></li>
                                    <li><a class="dropdown-item" href="#">Kelas X</a></li>
                                    <li><a class="dropdown-item" href="#">Kelas XI</a></li>
                                    <li><a class="dropdown-item" href="#">Kelas XII</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div style="width: 12px; height: 12px; background: #556ee6; border-radius: 2px;"></div>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <small class="text-muted">Laki-laki: <strong><?= array_sum($dataLaki) ?> siswa</strong></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div style="width: 12px; height: 12px; background: #f46a6a; border-radius: 2px;"></div>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <small class="text-muted">Perempuan: <strong><?= array_sum($dataPerempuan) ?> siswa</strong></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="stacked-column-chart" class="apex-charts" style="min-height: 380px;"></div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var options = {
                                    chart: {
                                        height: 380,
                                        type: 'bar',
                                        stacked: true,
                                        toolbar: {
                                            show: true,
                                            tools: {
                                                download: false,
                                                selection: false,
                                                zoom: false,
                                                zoomin: false,
                                                zoomout: false,
                                                pan: false,
                                                reset: false
                                            }
                                        },
                                        zoom: {
                                            enabled: false
                                        },
                                        animations: {
                                            enabled: true,
                                            easing: 'easeinout',
                                            speed: 800,
                                            animateGradually: {
                                                enabled: true,
                                                delay: 150
                                            },
                                            dynamicAnimation: {
                                                enabled: true,
                                                speed: 350
                                            }
                                        }
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: false,
                                            columnWidth: '55%',
                                            endingShape: 'rounded',
                                            borderRadius: 6,
                                            dataLabels: {
                                                total: {
                                                    enabled: true,
                                                    style: {
                                                        fontSize: '12px',
                                                        fontWeight: 600,
                                                        color: '#373d3f'
                                                    }
                                                }
                                            }
                                        }
                                    },
                                    dataLabels: {
                                        enabled: false
                                    },
                                    series: [{
                                            name: 'Laki-laki',
                                            data: <?= json_encode($dataLaki) ?>
                                        },
                                        {
                                            name: 'Perempuan',
                                            data: <?= json_encode($dataPerempuan) ?>
                                        }
                                    ],
                                    xaxis: {
                                        categories: <?= json_encode($categories) ?>,
                                        labels: {
                                            rotate: -45,
                                            style: {
                                                fontSize: '11px',
                                                fontWeight: 500,
                                                colors: ['#8c9097']
                                            }
                                        },
                                        axisBorder: {
                                            show: false
                                        },
                                        axisTicks: {
                                            show: false
                                        }
                                    },
                                    yaxis: {
                                        labels: {
                                            style: {
                                                fontSize: '11px',
                                                fontWeight: 500,
                                                colors: ['#8c9097']
                                            }
                                        }
                                    },
                                    colors: ['#556ee6', '#f46a6a'],
                                    legend: {
                                        position: 'top',
                                        horizontalAlign: 'right',
                                        fontSize: '12px',
                                        fontWeight: 500,
                                        markers: {
                                            width: 12,
                                            height: 12,
                                            radius: 3
                                        }
                                    },
                                    fill: {
                                        opacity: 0.9,
                                        gradient: {
                                            shade: 'light',
                                            type: "vertical",
                                            shadeIntensity: 0.3,
                                            gradientToColors: ['#667eea', '#ff9a9e'],
                                            inverseColors: false,
                                            opacityFrom: 0.9,
                                            opacityTo: 0.8,
                                            stops: [0, 100]
                                        }
                                    },
                                    grid: {
                                        borderColor: '#f1f1f1',
                                        strokeDashArray: 3,
                                        xaxis: {
                                            lines: {
                                                show: false
                                            }
                                        }
                                    },
                                    tooltip: {
                                        theme: 'light',
                                        style: {
                                            fontSize: '12px'
                                        },
                                        y: {
                                            formatter: function(val) {
                                                return val + " siswa"
                                            }
                                        }
                                    }
                                };
                                var chart = new ApexCharts(document.querySelector("#stacked-column-chart"), options);
                                chart.render();
                            });
                        </script>
                    </div>
                </div>

                <!-- Quick Actions Panel -->
                <div class="card dashboard-card mt-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="mdi mdi-lightning-bolt me-2 text-warning"></i>
                            Aksi Cepat
                        </h5>
                        <div class="row">
                            <div class="col-md-3 col-6 mb-3">
                                <a href="<?= base_url('peserta_didik/new') ?>" class="btn btn-soft-primary w-100 btn-enhanced">
                                    <i class="mdi mdi-account-plus d-block font-size-20 mb-1"></i>
                                    <small>Tambah Siswa</small>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="<?= base_url('pendidik') ?>" class="btn btn-soft-success w-100 btn-enhanced">
                                    <i class="mdi mdi-account-tie d-block font-size-20 mb-1"></i>
                                    <small>Tambah Guru</small>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="<?= base_url('mata_pelajaran') ?>" class="btn btn-soft-info w-100 btn-enhanced">
                                    <i class="mdi mdi-book-plus d-block font-size-20 mb-1"></i>
                                    <small>Tambah Mapel</small>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <button class="btn btn-soft-warning w-100 btn-enhanced" type="button" data-bs-toggle="modal" data-bs-target="#laporanModal">
                                    <i class="mdi mdi-file-chart d-block font-size-20 mb-1"></i>
                                    <small>Laporan</small>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- end row -->
    </div>
</div>

<!-- Modal Laporan -->
<div class="modal fade" id="laporanModal" tabindex="-1" aria-labelledby="laporanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="laporanModalLabel">
                    <i class="mdi mdi-file-chart me-2"></i>
                    Pilih Jenis Laporan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card h-100 border-primary">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="mdi mdi-account-group display-4 text-primary"></i>
                                </div>
                                <h5 class="card-title">Laporan Siswa</h5>
                                <p class="card-text text-muted">Data lengkap siswa aktif, mutasi, dan statistik siswa</p>
                                <a href="<?= base_url('laporan/siswa') ?>" class="btn btn-primary">
                                    <i class="mdi mdi-download me-2"></i>Generate Laporan
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-success">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="mdi mdi-account-tie display-4 text-success"></i>
                                </div>
                                <h5 class="card-title">Laporan Guru</h5>
                                <p class="card-text text-muted">Data tenaga pendidik dan kependidikan</p>
                                <a href="<?= base_url('laporan/guru') ?>" class="btn btn-success">
                                    <i class="mdi mdi-download me-2"></i>Generate Laporan
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-info">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="mdi mdi-view-list display-4 text-info"></i>
                                </div>
                                <h5 class="card-title">Laporan Kelas</h5>
                                <p class="card-text text-muted">Rekap per kelas dan rombongan belajar</p>
                                <a href="<?= base_url('laporan/kelas') ?>" class="btn btn-info">
                                    <i class="mdi mdi-download me-2"></i>Generate Laporan
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-warning">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="mdi mdi-chart-bar display-4 text-warning"></i>
                                </div>
                                <h5 class="card-title">Statistik Lengkap</h5>
                                <p class="card-text text-muted">Dashboard statistik dan analisis data</p>
                                <a href="<?= base_url('laporan/statistik') ?>" class="btn btn-warning">
                                    <i class="mdi mdi-chart-line me-2"></i>Lihat Statistik
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="mdi mdi-close me-2"></i>Tutup
                </button>
                <a href="<?= base_url('laporan') ?>" class="btn btn-primary">
                    <i class="mdi mdi-folder-open me-2"></i>Lihat Semua Laporan
                </a>
            </div>
        </div>
    </div>
</div>

</div>
<!-- container-fluid -->
</div>
<!-- End Page-content -->
<?= $this->endSection() ?>