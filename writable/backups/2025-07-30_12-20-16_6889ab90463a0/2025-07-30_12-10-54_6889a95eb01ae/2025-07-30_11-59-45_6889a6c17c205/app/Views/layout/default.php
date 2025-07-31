<!doctype html>
<html lang="en">

<head>

  <meta charset="utf-8" />
  <title>Dashboard | Sapa Sekolahku</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="Sistem administrasi dan pendataan akademik sekolah" name="description" />
  <meta content="SDN Krengseng 02" name="author" />
  <!-- CSRF Token for AJAX -->
  <meta name="csrf-token" content="<?= csrf_hash() ?>">
  <meta name="csrf-token-name" content="<?= csrf_token() ?>">
  <!-- App favicon -->
  <link rel="shortcut icon" href="<?= base_url() ?>backend/assets/images/favicon.png">
  <link rel="stylesheet" href="<?= base_url() ?>backend/assets/css/prettify.css">
  <link href="<?= base_url() ?>backend/assets/libs/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
  <!-- Sweet Alert-->
  <link href="<?= base_url() ?>backend/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>backend/assets/libs/toastr/toastr.min.css">
  <!-- DataTables -->
  <link href="<?= base_url() ?>backend/assets/libs/datatables/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url() ?>backend/assets/libs/datatables/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

  <!-- Bootstrap Css -->
  <link href="<?= base_url() ?>backend/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
  <!-- Icons Css -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>backend/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
  <!-- Remix Icon CDN for ri-* icons -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <!-- Boxicons CDN for bx-* icons -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <!-- App Css-->
  <link href="<?= base_url() ?>backend/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
  <!-- Custom Dashboard CSS -->
  <link href="<?= base_url() ?>backend/assets/css/custom-dashboard.css" rel="stylesheet" type="text/css" />
  <!-- Image Fallback CSS -->
  <link href="<?= base_url() ?>backend/assets/css/image-fallback.css" rel="stylesheet" type="text/css" />
  <!-- Tahun Ajaran View CSS -->
  <link href="<?= base_url() ?>backend/assets/css/tahun-ajaran-view.css" rel="stylesheet" type="text/css" />
  <!-- App js -->
  <!-- <script src="<?= base_url() ?>backend/assets/js/plugin.js"></script> -->


</head>

<body data-sidebar="light">


  <!-- Load Bar -->
  <div id="load-bar" style="position:fixed;top:0;left:0;width:0;height:3px;z-index:3000;background:linear-gradient(90deg,#ff3c3c,#ffb800,#00d97e,#007bff,#a259ff,#ff3c3c);background-size:200% 100%;transition:width 0.3s,background-position 1.2s;display:block;"></div>

  <!-- <body data-layout="horizontal" data-topbar="dark"> -->

  <!-- Begin page -->
  <div id="layout-wrapper">


    <header id="page-topbar">
      <div class="navbar-header">
        <div class="d-flex align-items-center">
          <!-- LOGO -->
          <div class="navbar-brand-box">
            <a href="index.html" class="logo logo-dark">
              <span class="logo-sm">
                <img src="<?= base_url() ?>backend/assets/images/logo-mini.png" alt="" height="30">
              </span>
              <span class="logo-lg">
                <img src="<?= base_url() ?>backend/assets/images/logo-sapa.png" alt="" height="30">
              </span>
            </a>

            <a href="index.html" class="logo logo-light">
              <span class="logo-sm">
                <img src="<?= base_url() ?>backend/assets/images/logo-mini.png" alt="" height="30">
              </span>
              <span class="logo-lg">
                <img src="<?= base_url() ?>backend/assets/images/logo-sapa.png" alt="" height="30">
              </span>
            </a>
          </div>


          <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
            <i class="fa fa-fw fa-bars"></i>
          </button>

          <!-- Nama Sekolah & Tahun Ajaran di Header-->
          <?php
          // Ambil nama sekolah dan logo dari database
          $sekolahModel = new \App\Models\SekolahModel();
          $dataSekolah = $sekolahModel->getSekolah();
          $namaSekolah = $dataSekolah && isset($dataSekolah->nama_sekolah) ? $dataSekolah->nama_sekolah : 'Nama Sekolah';
          $logoSekolah = isset($dataSekolah->logo) && $dataSekolah->logo ? base_url('uploads/' . $dataSekolah->logo) : base_url('backend/assets/images/logo-sapa.png');
          ?>
          <div class="d-none d-lg-block ms-3">
            <span class="fw-bold" style="font-size: 1.1rem;">
              <?= esc($namaSekolah) ?> -
              <?php
              $ketTahunSession = trim((string)session('ket_tahun'));
              $semesterSession = trim((string)session('semester_aktif'));
              echo esc($ketTahunSession);
              if ($semesterSession) {
                echo ' (Semester ' . esc($semesterSession) . ')';
              }
              ?>
            </span>
          </div> <?php
                  // Ambil tahun ajaran dan semester yang sedang digunakan user (dari session)
                  $ketTahunSession = trim((string)session('ket_tahun'));
                  $semesterSession = trim((string)session('semester_aktif'));
                  $showBadge = ($ketTahunSession !== '' || $semesterSession !== '');

                  // Tahun ajaran yang sedang dilihat
                  $tahunAjaranView = session()->get('ket_tahun_view');
                  $semesterView = session()->get('semester_view');
                  $isViewingDifferent = false;

                  // Jika melihat tahun ajaran yang berbeda dari aktif
                  if ($tahunAjaranView && $ketTahunSession && ($tahunAjaranView != $ketTahunSession || $semesterView != $semesterSession)) {
                    $isViewingDifferent = true;
                  }
                  ?>

          <!-- Indikator Tahun Ajaran -->
          <?php if ($isViewingDifferent): ?>
            <div class="ms-3 d-flex align-items-center">
              <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                <i class="bx bx-calendar me-1"></i>
                Viewing: <?= esc($tahunAjaranView) ?> (Semester <?= esc($semesterView) ?>)
              </span>
            </div>
          <?php endif; ?>
        </div>

        <div class="d-flex">

          <div class="dropdown d-inline-block d-lg-none ms-2">
            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
              data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="mdi mdi-magnify"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
              aria-labelledby="page-header-search-dropdown">

              <form class="p-3">
                <div class="form-group m-0">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <div class="dropdown d-none d-lg-inline-block ms-1">
            <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
              <i class="bx bx-fullscreen"></i>
            </button>
          </div>

          <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
              data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="bx bx-bell bx-tada"></i>
              <span class="badge bg-danger rounded-pill">3</span>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
              aria-labelledby="page-header-notifications-dropdown">
              <div class="p-3">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="m-0" key="t-notifications"> Notifications </h6>
                  </div>
                  <div class="col-auto">
                    <a href="#!" class="small" key="t-view-all"> View All</a>
                  </div>
                </div>
              </div>
              <div data-simplebar style="max-height: 230px;">
                <a href="javascript: void(0);" class="text-reset notification-item">
                  <div class="d-flex">
                    <div class="avatar-xs me-3">
                      <span class="avatar-title bg-primary rounded-circle font-size-16">
                        <i class="bx bx-cart"></i>
                      </span>
                    </div>
                    <div class="flex-grow-1">
                      <h6 class="mb-1" key="t-your-order">Your order is placed</h6>
                      <div class="font-size-12 text-muted">
                        <p class="mb-1" key="t-grammer">If several languages coalesce the grammar</p>
                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">3 min ago</span></p>
                      </div>
                    </div>
                  </div>
                </a>
                <a href="javascript: void(0);" class="text-reset notification-item">
                  <div class="d-flex">
                    <img src="assets/images/users/avatar-3.jpg"
                      class="me-3 rounded-circle avatar-xs" alt="user-pic">
                    <div class="flex-grow-1">
                      <h6 class="mb-1">James Lemire</h6>
                      <div class="font-size-12 text-muted">
                        <p class="mb-1" key="t-simplified">It will seem like simplified English.</p>
                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-hours-ago">1 hours ago</span></p>
                      </div>
                    </div>
                  </div>
                </a>
                <a href="javascript: void(0);" class="text-reset notification-item">
                  <div class="d-flex">
                    <div class="avatar-xs me-3">
                      <span class="avatar-title bg-success rounded-circle font-size-16">
                        <i class="bx bx-badge-check"></i>
                      </span>
                    </div>
                    <div class="flex-grow-1">
                      <h6 class="mb-1" key="t-shipped">Your item is shipped</h6>
                      <div class="font-size-12 text-muted">
                        <p class="mb-1" key="t-grammer">If several languages coalesce the grammar</p>
                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">3 min ago</span></p>
                      </div>
                    </div>
                  </div>
                </a>

                <a href="javascript: void(0);" class="text-reset notification-item">
                  <div class="d-flex">
                    <img src="assets/images/users/avatar-4.jpg"
                      class="me-3 rounded-circle avatar-xs" alt="user-pic">
                    <div class="flex-grow-1">
                      <h6 class="mb-1">Salena Layfield</h6>
                      <div class="font-size-12 text-muted">
                        <p class="mb-1" key="t-occidental">As a skeptical Cambridge friend of mine occidental.</p>
                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-hours-ago">1 hours ago</span></p>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
              <div class="p-2 border-top d-grid">
                <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                  <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View More..</span>
                </a>
              </div>
            </div>
          </div>

          <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
              data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img class="rounded-circle header-profile-user" src="<?= $logoSekolah ?>"
                alt="Logo Sekolah" style="object-fit:cover;">
              <span class="d-none d-xl-inline-block ms-1" key="t-henry"></span>
              <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
              <!-- item-->
              <a class="dropdown-item" href="<?= site_url('profile') ?>"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
              <a class="dropdown-item" href="#"><i class="bx bx-wallet font-size-16 align-middle me-1"></i> <span key="t-my-wallet">My Wallet</span></a>
              <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end">11</span><i class="bx bx-wrench font-size-16 align-middle me-1"></i> <span key="t-settings">Settings</span></a>
              <a class="dropdown-item" href="#"><i class="bx bx-lock-open font-size-16 align-middle me-1"></i> <span key="t-lock-screen">Lock screen</span></a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item text-danger" href="<?= site_url('auth/logout') ?>">
                <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                <span key="t-logout">Logout</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">

      <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
          <!-- Left Menu Start -->
          <ul class="metismenu list-unstyled" id="side-menu">
            <?= $this->include('layout/menu') ?>
          </ul>
        </div>
        <!-- Sidebar -->
      </div>
    </div>
    <!-- Left Sidebar End -->

    <!-- Start right Content here -->
    <script src="<?= base_url() ?>backend/assets/js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="<?= base_url() ?>backend/assets/libs/toastr/toastr.min.js"></script>
    <script src="<?= base_url() ?>backend/assets/js/toastr.init.js"></script>
    <!-- Sweet Alerts js -->
    <script src="<?= base_url() ?>backend/assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- Sweet alert init js-->
    <script src="<?= base_url() ?>backend/assets/js/sweet-alerts.init.js"></script>

    <div class="main-content">

      <?= $this->renderSection('content') ?>

      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <script>
                document.write(new Date().getFullYear())
              </script> © Sapa Sekolahku.
            </div>
            <div class="col-sm-6">
              <div class="text-sm-end d-none d-sm-block">
                Design & Develop by Afikrfkn
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
    <!-- end main content-->

  </div>
  <!-- END layout-wrapper -->


  <!-- JAVASCRIPT -->
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.min.js"></script>
  <script>
    // Always show SweetAlert2 above Bootstrap modal, and center vertically in viewport
    if (window.Swal) {
      // Always set z-index and vertical centering for SweetAlert2
      document.addEventListener('DOMContentLoaded', function() {
        const style = document.createElement('style');
        style.innerHTML = `
          .swal2-container { 
            z-index: 2050 !important; 
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
          }
          .swal2-popup { 
            position: relative !important;
            top: auto !important; 
            left: auto !important; 
            transform: none !important; 
            margin: 0 auto !important;
            max-width: 90vw !important;
            max-height: 90vh !important;
          }
          body.modal-open .swal2-container { z-index: 2050 !important; }
          .swal2-backdrop-show { background: rgba(0, 0, 0, 0.4) !important; }
          
          /* Additional positioning fixes for all screen sizes */
          @media (max-width: 768px) {
            .swal2-popup {
              max-width: 95vw !important;
              margin: 10px !important;
            }
          }
          
          /* Fix for loading state */
          .swal2-loading .swal2-popup {
            position: relative !important;
          }
        `;
        document.head.appendChild(style);
      });

      // Set default configurations for all Swal instances
      Swal.mixin({
        customClass: {
          container: 'swal2-container-center'
        },
        position: 'center',
        backdrop: true,
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true
      });

      // Force focus to Swal when open, so not trapped in modal
      document.addEventListener('shown.bs.modal', function() {
        setTimeout(function() {
          const swal = document.querySelector('.swal2-container');
          if (swal) swal.focus();
        }, 100);
      });
    }
  </script>
  <!-- Jika ingin pakai lokal, ganti baris di atas dengan baris di bawah ini dan pastikan file sudah asli -->
  <!-- <script src="<?= base_url() ?>backend/assets/js/sweetalert2.min.js"></script> -->
  <script src="<?= base_url() ?>backend/assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>backend/assets/libs/metismenu/metisMenu.min.js"></script>
  <script src="<?= base_url() ?>backend/assets/libs/simplebar/simplebar.min.js"></script>
  <script src="<?= base_url() ?>backend/assets/libs/node-waves/waves.min.js"></script>
  <script src="<?= base_url() ?>backend/assets/libs/datepicker/js/bootstrap-datepicker.min.js"></script>
  <!--datatable js-->
  <script src="<?= base_url() ?>backend/assets/libs/datatables/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>backend/assets/libs/datatables/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url() ?>backend/assets/libs/datatables/js/datatables.init.js"></script>
  <script src="<?= base_url() ?>backend/assets/libs/datatables/js/dataTables.buttons.min.js"></script>
  <script src="<?= base_url() ?>backend/assets/libs/datatables/js/buttons.bootstrap4.min.js"></script>
  <!-- toastr plugin -->
  <!-- apexcharts -->
  <script src="<?= base_url() ?>backend/assets/libs/apexcharts/apexcharts.min.js"></script>
  <!-- fontawesome icons init -->
  <!-- jquery step -->
  <!-- form wizard init -->
  <script src="<?= base_url() ?>backend/assets/js/fontawesome.init.js"></script>

  <!-- dashboard init -->
  <script src="<?= base_url() ?>backend/assets/js/dashboard.init.js"></script>
  <!-- toastr init -->
  <!--select2 cdn-->
  <!-- App js -->
  <script src="<?= base_url() ?>backend/assets/js/select2.init.js"></script>
  <script src="<?= base_url() ?>backend/assets/js/parsley.min.js"></script>
  <script src="<?= base_url() ?>backend/assets/js/form-validation.init.js"></script>
  <script src="<?= base_url() ?>backend/assets/js/app.js"></script>
  <script src="<?= base_url() ?>backend/assets/js/custom.js"></script>


  <script>
    // Load bar logic: show/hide progress bar at the top
    function startLoadBar() {
      var bar = document.getElementById('load-bar');
      if (bar) {
        bar.style.width = '0';
        bar.style.display = 'block';
        bar.style.backgroundPosition = '0% 0';
        setTimeout(function() {
          bar.style.width = '60%';
          bar.style.backgroundPosition = '100% 0';
        }, 50);
      }
    }

    function finishLoadBar() {
      var bar = document.getElementById('load-bar');
      if (bar) {
        bar.style.width = '100%';
        bar.style.backgroundPosition = '200% 0';
        setTimeout(function() {
          bar.style.display = 'none';
          bar.style.width = '0';
          bar.style.backgroundPosition = '0% 0';
        }, 400);
      }
    }
    // Example: auto start/finish on page load
    document.addEventListener('DOMContentLoaded', startLoadBar);
    window.addEventListener('load', finishLoadBar);
  </script>

</body>

</html>