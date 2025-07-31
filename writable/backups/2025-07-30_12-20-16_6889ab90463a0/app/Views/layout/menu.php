<?php
function getCurrentYearFromTahunPenerimaan()
{
    $db = \Config\Database::connect();
    $query = $db->query("SELECT tahun_pelajaran FROM db_tpenerimaan ORDER BY status_tahun DESC LIMIT 1");
    $result = $query->getRow();
    return $result ? $result->tahun_pelajaran : 'N/A';
}
$currentYear = getCurrentYearFromTahunPenerimaan();
?>
<!--Menu Default (Admin/Operator/Non-Guru)-->
<ul class="nav flex-column">
    <li class="menu-title" key="t-menu">Menu</li>
    <li>
        <a href="<?= site_url('dashboard') ?>" active>
            <i class="mdi mdi-home-variant-outline"></i>
            <span key="t-dashboards">Dashboards</span>
        </a>
    </li>
    <li>
        <a href="javascript: void(0);" class="waves-effect">
            <span class="badge rounded-pill bg-danger float-end" key="t-hot"><?= $currentYear ?></span>
            <i class="bx bx-user"></i>
            <span key="t-layouts">SPMB</span>
        </a>
        <ul class="sub-menu" aria-expanded="true">
            <li><a href="<?= site_url('tahun_penerimaan') ?>">Tahun Penerimaan </a></li>
            <li><a href="<?= site_url('calon_siswa') ?>">Calon Siswa </a></li>
            <li><a href="<?= site_url('verifikasi') ?>">Verifikasi</a></li>
        </ul>
    </li>
    <li class="menu-title" key="t-apps">Master Data</li>
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class='mdi mdi-cog-outline'></i>
            <span key="t-ecommerce">Pengaturan</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="<?= site_url('mata_pelajaran') ?>" key="t-products">Mata Pelajaran</a></li>
            <li><a href="<?= site_url('rombongan_belajar') ?>" key="t-product-detail">Kelas</a></li>
            <li><a href="<?= site_url('tahun_pelajaran') ?>" key="t-orders">Tahun Pelajaran</a></li>
        </ul>
    </li>
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class='mdi mdi-school-outline'></i>
            <span key="t-dashboards">Sekolah</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="<?= site_url('sekolah/data_sekolah') ?>" key="t-tui-calendar">Data Sekolah</a></li>
            <li><a href="<?= site_url('sekolah/kepala_sekolah') ?>" key="t-full-calendar">Kepala Sekolah</a></li>
        </ul>
    </li>
    <!-- <li>
            <a href="chat.html" class="waves-effect">
                <i class="bx bx-chat"></i>
                <span key="t-chat">Chat</span>
            </a>
        </li> -->
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class='mdi mdi-account-group-outline'></i>
            <span key="t-crypto">PTK & GTK</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="<?= site_url('pendidik') ?>" key="t-wallet">Pendidik</a></li>
            <li><a href="<?= site_url('tenaga_kependidikan') ?>" key="t-buy">Tenaga Kependidikan</a></li>
            <li><a href="<?= site_url('wali_kelas') ?>">Wali Kelas</a></li>
        </ul>
    </li>
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class='mdi mdi-account-group-outline'></i>
            <span key="t-crypto">Peserta Didik</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="<?= site_url('peserta_didik') ?>" key="t-wallet">Peserta Didik</a></li>
            <li><a href="<?= site_url('validasi_pd') ?>" key="t-buy">Validasi PD</a></li>
            <li><a href="<?= site_url('siswa_naik') ?>">Pindah/Naik</a></li>
            <li><a href="<?= site_url('lulusan') ?>" key="t-buy">Kelulusan</a></li>
            <li><a href="<?= site_url('mutasi_siswa') ?>" key="t-buy">PD Keluar/Mutasi</a></li>
        </ul>
    </li>
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="far fa-building"></i>
            <span key="t-email">Akademik</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="<?= site_url('akademik/verval_nilai_siswa') ?>" key="t-inbox" class="menu-link">Verval NS</a></li>
            <li><a href="<?= site_url('nilai') ?>" key="t-read-email" class="menu-link">Nilai</a></li>
            <li><a href="<?= site_url('alumni') ?>" key="t-read-email" class="menu-link">Data Alumni</a></li>
            <li><a href="<?= site_url('cetak_kartu_siswa') ?>" key="t-print-card" class="menu-link">Cetak Kartu Siswa</a></li>
        </ul>
    </li>
    <li class="menu-title" key="t-apps">Service</li>
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="mdi mdi-whatsapp"></i>
            <span key="t-wa-gateway">WA Gateway</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="<?= site_url('wa_gateway') ?>">Setting</a></li>
            <li><a href="<?= site_url('wa_gateway/log') ?>">Log</a></li>
        </ul>
    </li>
    <li>
        <a href="<?= site_url('api/menu') ?>" class="waves-effect">
            <i class="mdi mdi-database"></i>
            <span key="t-integrasi">Integrasi Aplikasi</span>
        </a>
    </li>
    <li>
        <a href="<?= site_url('user') ?>" class="waves-effect">
            <i class="bx bx-user-circle"></i>
            <span key="t-invoices">User</span>
        </a>
    </li>
    <li>
        <a href="<?= site_url('system-update') ?>" class="waves-effect">
            <i class="mdi mdi-update"></i>
            <span key="t-system-update">System Update</span>
        </a>
    </li>

</ul>