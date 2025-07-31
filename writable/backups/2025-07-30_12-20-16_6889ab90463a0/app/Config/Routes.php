
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Halaman utama langsung ke login
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->get('home', 'Home::index');
$routes->get('dashboard', 'Home::dashboard');

// Debug routes
$routes->get('debug-tahun-ajaran', 'DebugTahunAjaran::index');
$routes->get('check-table-structure', 'CheckTableStructure::index');
$routes->get('force-test-session', 'ForceTestSession::index');
$routes->get('test-dashboard-data', 'TestDashboardData::index');
$routes->get('debug-dashboard', 'DebugDashboard::index');
$routes->get('test-dashboard-view', 'DebugDashboard::testView');
$routes->get('simple-test/(:num)', 'SimpleTest::switchAndTest/$1');
$routes->get('simple-test', 'SimpleTest::switchAndTest/1');
$routes->get('clear-session', 'SimpleTest::clearSession');

// Validasi Tahun Ajaran routes
$routes->get('validasi-tahun-ajaran', 'ValidasiTahunAjaran::index');
$routes->get('validasi-tahun-ajaran/force-switch/(:num)', 'ValidasiTahunAjaran::forceSwitch/$1');
$routes->get('validasi-tahun-ajaran/clear-session', 'ValidasiTahunAjaran::clearSession');

// Test Perubahan Data routes
$routes->get('test-perubahan-data', 'TestPerubahanData::index');
$routes->get('test-perubahan-data/switch/(:num)', 'TestPerubahanData::switch/$1');
$routes->get('test-perubahan-data/clear', 'TestPerubahanData::clear');

// Cek Data Siswa routes
$routes->get('cek-data-siswa', 'CekDataSiswa::index');

// Fix Data Siswa routes
$routes->get('fix-data-siswa', 'FixDataSiswa::index');
$routes->get('fix-data-siswa/execute', 'FixDataSiswa::execute');

// Debug Peserta Didik routes
$routes->get('debug-peserta-didik', 'DebugPesertaDidik::index');
$routes->get('debug-peserta-didik/switch/(:num)', 'DebugPesertaDidik::switch/$1');
$routes->get('debug-peserta-didik/clear', 'DebugPesertaDidik::clear');

// Analisa Relasi Database routes
$routes->get('analisa-relasi-database', 'AnalisaRelasiDatabase::index');
$routes->get('analisa-relasi-database/create-relation', 'AnalisaRelasiDatabase::createRelation');

$routes->get('login', 'Auth::login');
$routes->POST('auth/loginProcess', 'Auth::loginProcess');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('user', 'User::index');
$routes->POST('user/update', 'User::update');
$routes->POST('user/generateGuru', 'User::generateGuru');

$routes->post('peserta_didik/validasi_siswa', 'Peserta_didik::validasi_siswa', ['filter' => 'isLoggedIn']);
$routes->get('peserta_didik/cetak_detail/(:num)', 'Siswa::cetakPdf/$1', ['filter' => 'isLoggedIn']);
$routes->get('peserta_didik/exportPdf', 'Siswa::exportPdf', ['filter' => 'isLoggedIn']);
$routes->get('peserta_didik/cetak_mutasi/(:num)', 'Siswa::cetakMutasi/$1', ['filter' => 'isLoggedIn']);
$routes->POST('peserta_didik/import_excel', 'Siswa::import_excel', ['filter' => 'isLoggedIn']);
$routes->POST('peserta_didik/import_register', 'Siswa::import_register', ['filter' => 'isLoggedIn']);
$routes->POST('peserta_didik/update_asalsekolah/(:num)', 'Siswa::updateClass/$1', ['filter' => 'isLoggedIn']);
$routes->POST('peserta_didik/update_class/(:num)', 'Siswa::updateClass/$1', ['filter' => 'isLoggedIn']);
// $routes->post('peserta_didik/mutasi', 'PesertaDidik::mutasi', ['filter' => 'isLoggedIn']);
$routes->POST('peserta_didik/update_class_lulus', 'Peserta_didik::update_class_lulus', ['filter' => 'isLoggedIn']);
$routes->get('peserta_didik/validasi', 'Peserta_didik::validasi', ['filter' => 'isLoggedIn']);
$routes->match(['GET', 'POST', 'OPTIONS', 'DELETE', 'PUT', 'PATCH'], 'peserta_didik/batal_mutasi/(:num)', 'Peserta_didik::batal_mutasi/$1');
$routes->POST('peserta_didik/luluskan', 'Peserta_didik::luluskan', ['filter' => 'isLoggedIn']);
$routes->get('peserta_didik/edit/(:num)', 'Peserta_didik::edit/$1', ['filter' => 'isLoggedIn']);
$routes->post('peserta_didik/update/(:num)', 'Peserta_didik::update/$1', ['filter' => 'isLoggedIn']);
$routes->resource('peserta_didik', [
    'filter' => 'isLoggedIn',
    'controller' => 'Siswa',
    'only' => ['index', 'create', 'update', 'delete', 'edit']
]);
$routes->get('calon_siswa/edit/(:num)', 'Spmb::edit/$1', ['filter' => 'isLoggedIn']);
$routes->POST('calon_siswa/update/(:num)', 'Spmb::update/$1', ['filter' => 'isLoggedIn']);
$routes->get('calon_siswa/cetak_buktidaftar/(:num)', 'Spmb::cetakPdf/$1', ['filter' => 'isLoggedIn']);
$routes->get('calon_siswa/jurnal_spmb', 'Spmb::jurnal_spmb', ['filter' => 'isLoggedIn']);
$routes->get('calon_siswa/export_excel', 'Spmb::export_excel', ['filter' => 'isLoggedIn']);
$routes->POST('calon_siswa/verifikasi_hasil', 'Spmb::verifikasi_hasil', ['filter' => 'isLoggedIn']);
$routes->POST('calon_siswa/verifikasi_berkas', 'Spmb::verifikasi_berkas', ['filter' => 'isLoggedIn']);
$routes->get('calon_siswa/get_berkas_files/(:num)/(:any)', 'Spmb::get_berkas_files/$1/$2', ['filter' => 'isLoggedIn']);
$routes->get('calon_siswa/getCalonPeserta', 'Spmb::getCalonPeserta');
$routes->resource('calon_siswa', [
    'filter' => 'isLoggedIn',
    'controller' => 'Spmb',
]);
$routes->match(['GET', 'POST'], 'uploadberkas/delete_file', 'UploadBerkas::delete_file');

$routes->resource('tahun_penerimaan', [
    'filter' => 'isLoggedIn',
    'controller' => 'TahunPenerimaan',
]);
$routes->get('validasi_pd', 'Siswa::validasiSiswaTanpaKelas', ['filter' => 'isLoggedIn']);
$routes->get('siswa_naik', 'Siswa::Siswanaikkelas', ['filter' => 'isLoggedIn']);
$routes->get('siswa_naik/getSiswaByKelas/(:num)', 'Siswa::getSiswaByKelas/$1');
$routes->POST('siswa/naikKelas', 'Siswa::naikKelas');

$routes->resource('mata_pelajaran', [
    'filter' => 'isLoggedIn',
    'controller' => 'Matpel',
    'only' => ['index', 'create', 'update', 'delete', 'edit']
]);
$routes->resource('rombongan_belajar', [
    'filter' => 'isLoggedIn',
    'controller' => 'Rombel',
    'only' => ['index', 'create', 'update', 'delete', 'edit']
]);

$routes->resource('pendidik', [
    'filter' => 'isLoggedIn',
    'controller' => 'Pendidik',
]);

$routes->resource('tahun_pelajaran', [
    'filter' => 'isLoggedIn',
    'controller' => 'Tapel',
]);

$routes->resource('sekolah/kepala_sekolah', [
    'filter' => 'isLoggedIn',
    'controller' => 'Kepalasekolah',
    'only' => ['index', 'show', 'create', 'update', 'delete']
]);

$routes->PUT('sekolah/kepala_sekolah/(:num)', 'Kepalasekolah::update/$1', ['filter' => 'isLoggedIn']);
$routes->PUT('sekolah/kepala_sekolah', 'Kepalasekolah::update', ['filter' => 'isLoggedIn']);

$routes->resource('jenis', [
    'filter' => 'isLoggedIn',
    'controller' => 'JenisSurat',
]);
$routes->get('lulusan', 'Siswa::lulusan', ['filter' => 'isLoggedIn']);

$routes->get('/profile', 'Profile::index');

$routes->get('report', 'Report::index');
$routes->get('report/generateReport', 'Report::generateReport');

$routes->get('sekolah/data_sekolah', 'Lembaga::index');
$routes->get('lembaga/getData/(:num)', 'Lembaga::getData/$1');
$routes->get('lembaga/edit/(:num)', 'Lembaga::edit/$1');
$routes->POST('lembaga/updateData/(:num)', 'Lembaga::updateData/$1');

$routes->get('uploadberkas/(:num)', 'UploadBerkas::index/$1');
$routes->POST('uploadberkas/upload/(:num)', 'UploadBerkas::upload/$1');
$routes->POST('uploadberkas/upload_ajax/(:num)', 'UploadBerkas::upload_ajax/$1');
$routes->get('verifikasi', 'UploadBerkas::index');

$routes->get('verifikasi/(:num)', 'UploadBerkas::index/$1');


$routes->get('wa_gateway', 'WaGateway::index', ['filter' => 'isLoggedIn']);
$routes->get('wa_gateway/log', 'WaGateway::log', ['filter' => 'isLoggedIn']);
$routes->POST('wa_gateway/sendMessage', 'WaGateway::sendMessage', ['filter' => 'isLoggedIn']);
$routes->POST('wa_gateway/saveConfig', 'WaGateway::saveConfig', ['filter' => 'isLoggedIn']);
$routes->get('wa_gateway/getConfig', 'WaGateway::getConfig', ['filter' => 'isLoggedIn']);
$routes->get('wa_gateway/pesan_terkirim', 'WaGateway::pesanTerkirim');
$routes->POST('wa_gateway/deleteLog', 'WaGateway::deleteLog', ['filter' => 'isLoggedIn']);


$routes->get('mutasi_siswa', 'Siswa::mutasiSiswa', ['filter' => 'isLoggedIn']);
$routes->get('alumni', 'Alumni::index', ['filter' => 'isLoggedIn']);
$routes->get('alumni/detail/(:num)', 'Alumni::detail/$1', ['filter' => 'isLoggedIn']);

// Cetak Kartu Siswa
$routes->get('cetak_kartu_siswa', 'CetakKartuSiswa::index', ['filter' => 'isLoggedIn']);
$routes->get('cetak_kartu_siswa/getSiswaOptions', 'CetakKartuSiswa::getSiswaOptions', ['filter' => 'isLoggedIn']);
$routes->get('cetak_kartu_siswa/preview/(:num)', 'CetakKartuSiswa::preview/$1', ['filter' => 'isLoggedIn']);
$routes->get('cetak_kartu_siswa/cetak/(:num)', 'CetakKartuSiswa::cetak/$1', ['filter' => 'isLoggedIn']);
$routes->post('cetak_kartu_siswa/cetakMasal', 'CetakKartuSiswa::cetakMasal', ['filter' => 'isLoggedIn']);
$routes->post('cetak_kartu_siswa/uploadTemplate', 'CetakKartuSiswa::uploadTemplate', ['filter' => 'isLoggedIn']);
$routes->post('cetak_kartu_siswa/resetTemplate', 'CetakKartuSiswa::resetTemplate', ['filter' => 'isLoggedIn']);
$routes->get('cetak_kartu_siswa/testUploadsAccess', 'CetakKartuSiswa::testUploadsAccess', ['filter' => 'isLoggedIn']);

// API untuk integrasi eRapor dan aplikasi lain
$routes->group('api', ['filter' => 'corsfilter'], function ($routes) {
    $routes->get('info', 'Api::info'); // Informasi API (tanpa token)
    $routes->get('debug', 'Api::debug'); // Debug informasi (tanpa token)
    $routes->get('all', 'Api::all'); // Semua data sekaligus
    $routes->get('siswa', 'Api::siswa'); // Data siswa
    $routes->get('guru', 'Api::guru'); // Data guru/pendidik
    $routes->get('mapel', 'Api::mapel'); // Data mata pelajaran
    $routes->get('kelas', 'Api::kelas'); // Data kelas/rombel
    $routes->get('sekolah', 'Api::sekolah'); // Data sekolah/lembaga
    $routes->get('tahun_ajaran', 'Api::tahun_ajaran'); // Data tahun ajaran
    $routes->match(['GET', 'POST'], 'keys', 'Api::apiKeys');
});

// Menu dan view integrasi eRapor
$routes->get('api/menu', function () {
    $apiKey = 'SEKOLAHKU-API-2025';
    return view('api_menu', ['apiKey' => $apiKey]);
});

$routes->get('nilai', 'Siswa::nilai', ['filter' => 'isLoggedIn']);

// Tenaga Kependidikan routes
$routes->get('tenaga_kependidikan', 'TenagaKependidikan::index', ['filter' => 'isLoggedIn']);
$routes->get('tenaga_kependidikan/getData/(:num)', 'TenagaKependidikan::getData/$1', ['filter' => 'isLoggedIn']);
$routes->post('tenaga_kependidikan/create', 'TenagaKependidikan::create', ['filter' => 'isLoggedIn']);
$routes->get('tenaga_kependidikan/edit/(:num)', 'TenagaKependidikan::edit/$1', ['filter' => 'isLoggedIn']);
$routes->post('tenaga_kependidikan/update/(:num)', 'TenagaKependidikan::update/$1', ['filter' => 'isLoggedIn']);
$routes->delete('tenaga_kependidikan/delete/(:num)', 'TenagaKependidikan::delete/$1', ['filter' => 'isLoggedIn']);

// Akademik routes
$routes->get('akademik', 'Akademik::index', ['filter' => 'isLoggedIn']);
$routes->get('akademik/verval_nilai_siswa', 'Akademik::verval_nilai_siswa', ['filter' => 'isLoggedIn']);
$routes->post('akademik/get_verval_nilai_data', 'Akademik::get_verval_nilai_data', ['filter' => 'isLoggedIn']);
$routes->get('akademik/get_nilai_detail/(:num)', 'Akademik::get_nilai_detail/$1', ['filter' => 'isLoggedIn']);
$routes->post('akademik/update_nilai', 'Akademik::update_nilai', ['filter' => 'isLoggedIn']);
$routes->post('akademik/verifikasi_nilai', 'Akademik::verifikasi_nilai', ['filter' => 'isLoggedIn']);
$routes->post('akademik/verifikasi_nilai_massal', 'Akademik::verifikasi_nilai_massal', ['filter' => 'isLoggedIn']);
$routes->get('akademik/export_verval_nilai', 'Akademik::export_verval_nilai', ['filter' => 'isLoggedIn']);
$routes->get('akademik/create_nilai_table', 'Akademik::create_nilai_table', ['filter' => 'isLoggedIn']);

// Wali Kelas routes
$routes->get('wali_kelas', 'WaliKelas::index', ['filter' => 'isLoggedIn']);
$routes->get('wali_kelas/getData/(:num)', 'WaliKelas::getData/$1', ['filter' => 'isLoggedIn']);
$routes->post('wali_kelas/create', 'WaliKelas::create', ['filter' => 'isLoggedIn']);
$routes->post('wali_kelas/update/(:num)', 'WaliKelas::update/$1', ['filter' => 'isLoggedIn']);
$routes->delete('wali_kelas/delete/(:num)', 'WaliKelas::delete/$1', ['filter' => 'isLoggedIn']);
$routes->get('wali_kelas/datatables', 'WaliKelas::datatables', ['filter' => 'isLoggedIn']);
$routes->post('wali_kelas/datatables', 'WaliKelas::datatables', ['filter' => 'isLoggedIn']);
$routes->get('wali_kelas/anggotaRombel/(:any)', 'WaliKelas::anggotaRombel/$1', ['filter' => 'isLoggedIn']);
$routes->get('wali_kelas/anggota/(:any)', 'WaliKelas::anggotaRombel/$1', ['filter' => 'isLoggedIn']);
$routes->get('wali_kelas/cetakAbsen/(:any)', 'WaliKelas::cetakAbsen/$1', ['filter' => 'isLoggedIn']);
$routes->get('wali_kelas/exportAbsenPdf/(:any)', 'WaliKelas::exportAbsenPdf/$1', ['filter' => 'isLoggedIn']);


// Testing routes (remove in production)
$routes->get('test-tahun-ajaran', 'TestTahunAjaran::testSwitchTahunAjaran', ['filter' => 'isLoggedIn']);
$routes->get('test-tahun-ajaran/switch/(:num)', 'TestTahunAjaran::testSwitchToTahunAjaran/$1', ['filter' => 'isLoggedIn']);

$routes->get('calon_siswa/koreksi_verifikasi', 'Spmb::koreksi_verifikasi', ['filter' => 'isLoggedIn']);

// Test Switch Tahun Ajaran routes (untuk validasi dinamis data)
$routes->get('test-switch-tahun-ajaran', 'TestSwitchTahunAjaran::index');
$routes->get('test-switch-tahun-ajaran/switch/(:num)', 'TestSwitchTahunAjaran::switch_tahun_ajaran/$1');
$routes->get('test-switch-tahun-ajaran/data-dinamis', 'TestSwitchTahunAjaran::get_data_dinamis');
$routes->get('test-switch-tahun-ajaran/reset', 'TestSwitchTahunAjaran::reset_session');

// Analisis Relasi Database routes
$routes->get('analisis-relasi-database', 'AnalisisRelasiDatabase::index');
$routes->get('analisis-relasi-database/diagnosa', 'AnalisisRelasiDatabase::diagnosa');
$routes->get('analisis-relasi-database/execute-fix', 'AnalisisRelasiDatabase::executeFix');

// Create Relasi Tahun Ajaran routes
$routes->get('create-relasi-tahun-ajaran', 'CreateRelasiTahunAjaran::index');
$routes->get('create-relasi-tahun-ajaran/execute', 'CreateRelasiTahunAjaran::execute');

// Finalize Tahun Ajaran routes
$routes->get('finalize-tahun-ajaran', 'FinalizeTahunAjaran::index');
$routes->get('finalize-tahun-ajaran/validation-report', 'FinalizeTahunAjaran::validation_report');
$routes->get('finalize-tahun-ajaran/cleanup-debug-files', 'FinalizeTahunAjaran::cleanup_debug_files');
$routes->get('peserta_didik/generate-nis-kelas1', 'Peserta_didik::generateNISForClass1Students', ['filter' => 'isLoggedIn']);
$routes->get('peserta_didik/batchGenerateNISForClass1Students', 'Peserta_didik::batchGenerateNISForClass1Students', ['filter' => 'isLoggedIn']);

// System Update route
$routes->get('system-update', 'SystemUpdate::index');
$routes->get('system-update/check-update', 'SystemUpdate::checkUpdate');
$routes->get('system-update/test-connection', 'SystemUpdate::testConnection');
$routes->get('system-update/get-update-log', 'SystemUpdate::getUpdateLog');
$routes->post('system-update/perform-update', 'SystemUpdate::performUpdate');

