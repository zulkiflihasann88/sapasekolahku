<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Data Surat Masuk &mdash; SDN Krengseng 02</title>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Data Siswa</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?= site_url('home') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data peserta didik</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Filter Kelas pindah ke samping tombol registrasi -->
        <?php if (session()->getFlashdata('success')) : ?>
            <script>
                toastr.success("<?= session()->getFlashdata('success'); ?>", 'Sukses', {
                    "progressBar": true,
                    "timeOut": "3000",
                    "positionClass": "toast-top-right",
                    "extendedTimeOut": "3000",
                });
            </script>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <script>
                toastr.error("<?= session()->getFlashdata('error'); ?>", 'Gagal', {
                    "progressBar": true,
                    "timeOut": "3000",
                    "positionClass": "toast-top-right",
                    "extendedTimeOut": "3000",
                });
            </script>
        <?php endif; ?>
        <?php if (session()->getFlashdata('info')) : ?>
            <script>
                toastr.info("<?= session()->getFlashdata('info'); ?>", 'Info', {
                    "progressBar": true,
                    "timeOut": "3000",
                    "positionClass": "toast-top-right",
                    "extendedTimeOut": "3000",
                });
            </script>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-xs-12 col-md-8 d-flex align-items-center flex-wrap gap-1" style="gap: 6px 8px !important;">
                                <a href="<?= site_url('peserta_didik/new') ?>" class="btn btn-sm btn-success bg-gradient"><i class="fas fa-plus align-middle me-1"></i> Tambah PD</a>
                                <button type="button" id="btn-registrasi" class="btn btn-sm btn-primary bg-gradient disabled" tabindex="-1" aria-disabled="true" data-bs-toggle="modal" data-bs-target="#registrasiModal"><i class="fas fa-book-reader align-middle me-1"></i> Registrasi</button>
                                <form method="get" id="filter-kelas-form" class="mb-0 d-flex align-items-center" style="min-width:160px;">
                                    <select name="filter_kelas" id="filter_kelas" class="form-select form-select-sm" onchange="this.form.submit()" style="min-width:140px;">
                                        <option value="">Semua Kelas</option>
                                        <?php if (isset($daftar_kelas) && is_array($daftar_kelas)): ?>
                                            <?php foreach ($daftar_kelas as $key => $label): ?>
                                                <option value="<?= htmlspecialchars($key) ?>" <?= (isset($_GET['filter_kelas']) && $_GET['filter_kelas'] == $key) ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </form>
                            </div>
                            <div class="col-xs-12 col-md-4 d-flex justify-content-end align-items-center gap-1" style="gap: 6px 8px !important;">
                                <a href="#" class="btn btn-sm btn-warning waves-effect waves-light bg-gradient" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                                    <i class="far fa-file-excel"></i> Import Excel
                                </a>
                                <a href="<?= site_url('peserta_didik/exportPdf') ?>" class="btn btn-sm btn-info waves-effect waves-light bg-gradient">
                                    <i class="fas fa-graduation-cap"></i> Luluskan
                                </a>
                            </div>
                        </div>
                        <table id="scroll-horizontal" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead class="table-light">
                                <tr>
                                    <th><input type="checkbox" id="select-all"></th>
                                    <th class="align-middle">No</th>
                                    <th class="align-middle">Val</th>
                                    <th class="align-middle">Nama</th>
                                    <th class="align-middle">JK</th>
                                    <th class="align-middle">NISN</th>
                                    <th class="align-middle">NIK</th>
                                    <th class="align-middle">Tempat Lahir</th>
                                    <th class="align-middle">Tanggal Lahir</th>
                                    <th class="align-middle">Rombel</th>
                                    <th class="align-middle">NIS</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <!-- Hapus baris ini, karena $value hanya tersedia di dalam foreach -->
                            <?php foreach ($peserta_didik as $key => $value) : ?>
                                <tr>
                                    <td><input type="checkbox" class="row-checkbox" value="<?= $value['id_siswa'] ?>" data-nama="<?= isset($value['nama_siswa']) ? htmlspecialchars($value['nama_siswa']) : '-' ?>" data-nis="<?= isset($value['nis']) ? htmlspecialchars($value['nis']) : '-' ?>" data-jenis_pendaftaran="<?= isset($value['jenis_pendaftaran']) ? htmlspecialchars($value['jenis_pendaftaran']) : '' ?>" data-hobby="<?= isset($value['hobby']) ? htmlspecialchars($value['hobby']) : '' ?>" data-cita_cita="<?= isset($value['cita_cita']) ? htmlspecialchars($value['cita_cita']) : '' ?>" data-tanggal_pendaftaran="<?= isset($value['tanggal_pendaftaran']) && $value['tanggal_pendaftaran'] ? htmlspecialchars($value['tanggal_pendaftaran']) : '' ?>" data-sekolah_asal="<?= isset($value['sekolah_asal']) ? htmlspecialchars($value['sekolah_asal']) : '' ?>" data-paud_formal="<?= isset($value['paud_formal']) ? htmlspecialchars($value['paud_formal']) : '' ?>" data-paud_non_formal="<?= isset($value['paud_non_formal']) ? htmlspecialchars($value['paud_non_formal']) : '' ?>"></td>
                                    <td class="align-middle"><?= $key + 1 ?></td>
                                    <!-- script toggleButton dipindah ke bawah agar tidak duplikat di setiap baris -->
                                    <td class="align-middle">
                                        <?php if (
                                            isset($value['nama_siswa']) && $value['nama_siswa'] !== null && $value['nama_siswa'] !== '' &&
                                            isset($value['jk']) && $value['jk'] !== null && $value['jk'] !== '' &&
                                            isset($value['nisn']) && $value['nisn'] !== null && $value['nisn'] !== '' &&
                                            isset($value['nik']) && $value['nik'] !== null && $value['nik'] !== '' &&
                                            isset($value['no_kk']) && $value['no_kk'] !== null && $value['no_kk'] !== '' &&
                                            isset($value['tempat_lahir']) && $value['tempat_lahir'] !== null && $value['tempat_lahir'] !== '' &&
                                            isset($value['tanggal_lahir']) && $value['tanggal_lahir'] !== null && $value['tanggal_lahir'] !== '' &&
                                            isset($value['kelas_rombel']) && $value['kelas_rombel'] !== null && $value['kelas_rombel'] !== '' &&
                                            isset($value['nis']) && $value['nis'] !== null && $value['nis'] !== '' &&
                                            isset($value['id_agama']) && $value['id_agama'] !== null && $value['id_agama'] !== '' &&
                                            isset($value['id_kebutuhankhusus']) && $value['id_kebutuhankhusus'] !== null && $value['id_kebutuhankhusus'] !== '' &&
                                            isset($value['id_tinggal']) && $value['id_tinggal'] !== null && $value['id_tinggal'] !== '' &&
                                            isset($value['id_rombel']) && $value['id_rombel'] !== null && $value['id_rombel'] !== '' &&
                                            isset($value['id_transportasi']) && $value['id_transportasi'] !== null && $value['id_transportasi'] !== ''
                                        ) : ?>
                                            <i class="mdi mdi-check-bold text-success font-size-24" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Valid"></i>
                                        <?php else : ?>
                                            <i class="mdi mdi-close-thick text-danger font-size-24" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Belum valid"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle"><?= isset($value['nama_siswa']) ? $value['nama_siswa'] : '-' ?></td>
                                    <td class="align-middle"><?= isset($value['jk']) ? $value['jk'] : '-' ?></td>
                                    <td class="align-middle"><?= isset($value['nisn']) ? $value['nisn'] : '-' ?></td>
                                    <td class="align-middle"><?= isset($value['nik']) ? $value['nik'] : '-' ?></td>
                                    <td class="align-middle"><?= isset($value['tempat_lahir']) ? $value['tempat_lahir'] : '-' ?></td>
                                    <td class="align-middle">
                                        <?php if (isset($value['tanggal_lahir']) && $value['tanggal_lahir']) {
                                            echo date('d-m-Y', strtotime($value['tanggal_lahir']));
                                        } else {
                                            echo '-';
                                        } ?>
                                    </td>
                                    <td class="align-middle"><?php
                                                                if (isset($value['kelas_rombel']) && $value['kelas_rombel']) {
                                                                    echo $value['kelas_rombel'];
                                                                } elseif (isset($value['nama_rombel']) && $value['nama_rombel']) {
                                                                    echo $value['nama_rombel'];
                                                                } elseif (isset($value['rombel']) && $value['rombel']) {
                                                                    echo $value['rombel'];
                                                                } else {
                                                                    echo '-';
                                                                }
                                                                ?></td>
                                    <td class="align-middle"><?= isset($value['nis']) ? $value['nis'] : '-' ?></td>
                                    <td class="align-middle">
                                        <?php
                                        $is_valid = (
                                            isset($value['nama_siswa']) && $value['nama_siswa'] !== null && $value['nama_siswa'] !== '' &&
                                            isset($value['jk']) && $value['jk'] !== null && $value['jk'] !== '' &&
                                            isset($value['nisn']) && $value['nisn'] !== null && $value['nisn'] !== '' &&
                                            isset($value['nik']) && $value['nik'] !== null && $value['nik'] !== '' &&
                                            isset($value['no_kk']) && $value['no_kk'] !== null && $value['no_kk'] !== '' &&
                                            isset($value['tempat_lahir']) && $value['tempat_lahir'] !== null && $value['tempat_lahir'] !== '' &&
                                            isset($value['tanggal_lahir']) && $value['tanggal_lahir'] !== null && $value['tanggal_lahir'] !== '' &&
                                            isset($value['kelas_rombel']) && $value['kelas_rombel'] !== null && $value['kelas_rombel'] !== '' &&
                                            isset($value['nis']) && $value['nis'] !== null && $value['nis'] !== '' &&
                                            isset($value['id_agama']) && $value['id_agama'] !== null && $value['id_agama'] !== '' &&
                                            isset($value['id_kebutuhankhusus']) && $value['id_kebutuhankhusus'] !== null && $value['id_kebutuhankhusus'] !== '' &&
                                            isset($value['id_tinggal']) && $value['id_tinggal'] !== null && $value['id_tinggal'] !== '' &&
                                            isset($value['id_rombel']) && $value['id_rombel'] !== null && $value['id_rombel'] !== '' &&
                                            isset($value['id_transportasi']) && $value['id_transportasi'] !== null && $value['id_transportasi'] !== ''
                                        );
                                        ?>
                                        <a href="<?= site_url('peserta_didik/cetak_detail/' . $value['id_siswa']) ?>" class="btn btn-sm btn-primary waves-effect waves-light<?= $is_valid ? '' : ' disabled' ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Detail" <?= $is_valid ? '' : 'tabindex=\"-1\" aria-disabled=\"true\"' ?>>
                                            <i class="fas fa-id-card-alt"></i>
                                        </a>
                                        <a href="<?= site_url('peserta_didik/' . $value['id_siswa'] . '/edit') ?>" class="btn btn-sm btn-success waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit data">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        <form action="<?= site_url('peserta_didik/' . $value['id_siswa']) ?>" method="post" class="d-inline" id="del-<?= $value['id_siswa'] ?>">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-danger btn-sm" data-confirm="Hapus Data?|Apakah Anda yakin?" data-confirm-yes="submitDel(<?= $value['id_siswa'] ?>)">
                                                <i class="mdi mdi-trash-can-outline"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div>
    </div>
    <!-- Add this modal at the end of your file before the closing body tag -->
    <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importExcelModalLabel">Import Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= site_url('peserta_didik/import_excel') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="excelFile" class="form-label">Upload Excel File</label>
                            <input type="file" class="form-control" id="excelFile" name="excelFile" accept=".xls,.xlsx" required>
                        </div>
                        <div class="mb-3">
                            <p>Sebelum import data silahkan downlod format import dibawah ini dengan ekstensi .xls atau .xlsx</p>
                            <a href="<?= base_url('uploads/template_import_peserta_didik.xlsx') ?>" class="btn btn-info">Download Format</a>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Registrasi Peserta Didik -->
    <div class="modal fade" id="registrasiModal" tabindex="-1" aria-labelledby="registrasiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-teal-600">
                    <h5 class="modal-title" id="registrasiModalLabel">Registrasi Peserta Didik : <span id="namaPesertaModal"><?= isset($peserta_didik_row) && isset($peserta_didik_row->nama_siswa) ? htmlspecialchars($peserta_didik_row->nama_siswa) : '[Nama Peserta]' ?></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= site_url('peserta_didik/import_register') ?>" method="post" class="needs-validation" novalidate id="form-registrasi-pd">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <fieldset class="border p-3 mb-3">
                            <legend class="w-auto px-2 small">Pendaftaran Masuk</legend>
                            <div class="row mb-2">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Jenis pendaftaran: <span class="text-danger">*</span></label>
                                    <select class="form-select" name="jenis_pendaftaran">
                                        <option value="">Pilih</option>
                                        <option value="Siswa baru">Siswa baru</option>
                                        <option value="Pindahan">Pindahan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Nomor Induk PD / NIS: <span class="text-danger">*</span></label> <input type="text" class="form-control" name="nis" id="input-nis" value="<?= isset($peserta_didik_row) && isset($peserta_didik_row->nis) ? htmlspecialchars($peserta_didik_row->nis) : '' ?>" required readonly>

                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Tanggal masuk sekolah: <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="tanggal_pendaftaran" value="<?= isset($peserta_didik_row) && isset($peserta_didik_row->tanggal_pendaftaran) ? htmlspecialchars($peserta_didik_row->tanggal_pendaftaran) : '' ?>">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Sekolah asal:</label>
                                    <input type="text" class="form-control" name="sekolah_asal">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Apakah pernah PAUD Formal (TK):</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="paud_formal" id="paud_formal_ya" value="Ya">
                                            <label class="form-check-label" for="paud_formal_ya">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="paud_formal" id="paud_formal_tidak" value="Tidak">
                                            <label class="form-check-label" for="paud_formal_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Apakah pernah PAUD Non Formal (KB/TPA/SPS):</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="paud_non_formal" id="paud_non_formal_ya" value="Ya">
                                            <label class="form-check-label" for="paud_non_formal_ya">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="paud_non_formal" id="paud_non_formal_tidak" value="Tidak">
                                            <label class="form-check-label" for="paud_non_formal_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Hobby: <span class="text-danger">*</span></label>
                                    <select class="form-select" name="hobby" required>
                                        <option value="">Pilih</option>
                                        <option value="Olah Raga">Olah Raga</option>
                                        <option value="Kesenian">Kesenian</option>
                                        <option value="Membaca">Membaca</option>
                                        <option value="Menulis">Menulis</option>
                                        <option value="Traveling">Traveling</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Cita-cita: <span class="text-danger">*</span></label>
                                    <select class="form-select" name="cita_cita" required>
                                        <option value="">Pilih</option>
                                        <option value="PNS">PNS</option>
                                        <option value="TNI/POLRI">TNI/POLRI</option>
                                        <option value="Guru/Dosen">Guru/Dosen</option>
                                        <option value="Dokter">Dokter</option>
                                        <option value="Politikus">Politikus</option>
                                        <option value="Wiraswasta">Wiraswasta</option>
                                        <option value="Seniman/Artis">Seniman/Artis</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="border p-3 mb-3">
                            <legend class="w-auto px-2 small">Di Isi Saat Sudah Keluar</legend>
                            <div class="alert alert-light py-2 small mb-3">
                                <span class="text-danger">*</span> Peserta didik yang bisa diluluskan hanyalah peserta didik yang berada pada rombongan belajar tingkat akhir (TK B, Kelas 6, Kelas 9, Kelas 12/13)
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Keluar karena:</label>
                                    <select class="form-select" name="keluar_karena" id="keluar_karena_select">
                                        <option value="">Pilih</option>
                                        <?php if (isset($keluar_karenas) && is_array($keluar_karenas)): ?>
                                            <?php foreach ($keluar_karenas as $row): ?>
                                                <option value="<?= htmlspecialchars($row->keluar_karena) ?>"><?= htmlspecialchars($row->keluar_karena) ?></option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="Lulus">Lulus</option>
                                            <option value="Mutasi">Mutasi</option>
                                            <option value="Mengundurkan Diri">Mengundurkan Diri</option>
                                            <option value="Putus Sekolah">Putus Sekolah</option>
                                            <option value="Wafat">Wafat</option>
                                            <option value="Lainnya">Lainnya</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Tanggal keluar sekolah:</label>
                                    <input type="date" class="form-control" name="tanggal_keluar" id="tanggal_keluar_input" value="<?= isset($peserta_didik_row) && isset($peserta_didik_row->tanggal_keluar) ? htmlspecialchars($peserta_didik_row->tanggal_keluar) : '' ?>">
                                </div>
                            </div>
                            <!-- Tombol Mutasi Siswa dipindahkan ke modal-footer di bawah -->
                            <script>
                                // Tampilkan tombol Mutasi Siswa jika field keluar_karena dan tanggal_keluar terisi
                                $(function() {
                                    var keluarSelect = document.getElementById('keluar_karena_select');
                                    var tglKeluarInput = document.getElementById('tanggal_keluar_input');
                                    var btnMutasi = document.getElementById('btn-mutasi-siswa');

                                    function toggleMutasiButton() {
                                        if (btnMutasi) {
                                            if (keluarSelect && tglKeluarInput && keluarSelect.value && tglKeluarInput.value) {
                                                btnMutasi.style.display = '';
                                            } else {
                                                btnMutasi.style.display = 'none';
                                            }
                                        }
                                    }
                                    if (keluarSelect) keluarSelect.addEventListener('change', toggleMutasiButton);
                                    if (tglKeluarInput) tglKeluarInput.addEventListener('input', toggleMutasiButton);
                                    toggleMutasiButton();

                                    // Handler klik tombol mutasi
                                    if (btnMutasi) {
                                        btnMutasi.addEventListener('click', function() {
                                            var form = btnMutasi.closest('form');
                                            if (form) {
                                                // Ganti action ke endpoint mutasi
                                                form.action = "<?= site_url('peserta_didik/mutasi') ?>";
                                                // Tambahkan input hidden agar backend tahu ini mutasi
                                                var input = document.createElement('input');
                                                input.type = 'hidden';
                                                input.name = 'trigger_mutasi';
                                                input.value = '1';
                                                form.appendChild(input);
                                                form.submit();
                                            }
                                        });
                                    }
                                });
                            </script>
                            <div class="row mb-2">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Alasan:</label>
                                    <input type="text" class="form-control" name="alasan_keluar" placeholder="Alasan keluar" value="<?= isset($peserta_didik_row) && isset($peserta_didik_row->alasan_keluar) ? htmlspecialchars($peserta_didik_row->alasan_keluar) : '' ?>">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Tujuan Sekolah:</label>
                                    <input type="text" class="form-control" name="tujuan_mutasi" placeholder="Nama sekolah tujuan" value="<?= isset($peserta_didik_row) && isset($peserta_didik_row->tujuan_mutasi) ? htmlspecialchars($peserta_didik_row->tujuan_mutasi) : '' ?>">
                                </div>
                            </div>
                        </fieldset>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-warning" id="btn-mutasi-siswa" style="display:none;">Mutasi Siswa</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Auto set NIS ke modal jika ada data terpilih

        $(function() {


            var btnRegistrasi = document.getElementById('btn-registrasi');
            // Pastikan tombol tidak punya atribut disabled di awal (biar JS yang kontrol)
            if (btnRegistrasi) btnRegistrasi.removeAttribute('disabled');
            var inputNis = document.getElementById('input-nis');
            var namaPesertaModal = document.getElementById('namaPesertaModal');
            var registrasiModal = document.getElementById('registrasiModal');

            // Fungsi untuk enable/disable tombol registrasi
            function toggleButton() {
                var checkboxes = document.querySelectorAll('.row-checkbox');
                var checked = 0;
                var lastChecked = null;
                checkboxes.forEach(function(cb) {
                    // Cek: enabled dan checked (abaikan visibility, DataTables bisa hidden pakai display:none di row)
                    if (!cb.disabled && cb.checked) {
                        checked++;
                        lastChecked = cb;
                    }
                });
                if (checked === 1) {
                    btnRegistrasi.classList.remove('disabled');
                    btnRegistrasi.removeAttribute('tabindex');
                    btnRegistrasi.removeAttribute('aria-disabled');
                    btnRegistrasi.removeAttribute('disabled');
                } else {
                    btnRegistrasi.classList.add('disabled');
                    btnRegistrasi.setAttribute('tabindex', '-1');
                    btnRegistrasi.setAttribute('aria-disabled', 'true');
                    btnRegistrasi.setAttribute('disabled', 'disabled');
                }
            }


            // Event delegation agar tetap jalan walau tabel di-redraw (misal oleh DataTables)
            // Gunakan event pada tbody agar event tetap hidup walau DataTables redraw

            // Event delegation agar tetap jalan walau tabel di-redraw (misal oleh DataTables)
            // Gunakan event pada document agar semua perubahan checkbox terdeteksi
            // Pastikan event juga didaftarkan pada click (untuk kasus DataTables/checkbox custom)
            $(document).on('change', '.row-checkbox', function() {
                setTimeout(toggleButton, 0);
            });
            $(document).on('click', '.row-checkbox', function() {
                setTimeout(toggleButton, 0);
            });
            // Inisialisasi awal
            setTimeout(toggleButton, 0);

            // Jika pakai DataTables, pastikan toggleButton dipanggil setiap redraw
            if (window.jQuery && $('#scroll-horizontal').length && $('#scroll-horizontal').data('DataTable')) {
                $('#scroll-horizontal').on('draw.dt', function() {
                    setTimeout(toggleButton, 0);
                });
            }

            // Saat modal akan tampil, isi nama dan NIS
            if (registrasiModal) {
                registrasiModal.addEventListener('show.bs.modal', function() {
                    var checkboxes = document.querySelectorAll('.row-checkbox');
                    var selected = null;
                    checkboxes.forEach(function(cb) {
                        if (cb.checked) selected = cb;
                    });
                    // Jenis pendaftaran, hobby, cita-cita
                    var selectJenis = registrasiModal.querySelector('select[name="jenis_pendaftaran"]');
                    var selectHobby = registrasiModal.querySelector('select[name="hobby"]');
                    var selectCita = registrasiModal.querySelector('select[name="cita_cita"]');
                    var keluarKarena = registrasiModal.querySelector('select[name="keluar_karena"]');
                    var tanggalKeluar = registrasiModal.querySelector('input[name="tanggal_keluar"]');
                    var alasanKeluar = registrasiModal.querySelector('input[name="alasan_keluar"]');
                    if (selected) {
                        // Sekolah asal
                        var inputSekolahAsal = registrasiModal.querySelector('input[name="sekolah_asal"]');
                        if (inputSekolahAsal) {
                            inputSekolahAsal.value = selected.getAttribute('data-sekolah_asal') || '';
                        }
                        // PAUD Formal
                        var paudFormal = selected.getAttribute('data-paud_formal') || '';
                        var radioPaudFormalYa = registrasiModal.querySelector('input[name="paud_formal"][value="Ya"]');
                        var radioPaudFormalTidak = registrasiModal.querySelector('input[name="paud_formal"][value="Tidak"]');
                        if (radioPaudFormalYa && radioPaudFormalTidak) {
                            if (paudFormal.toLowerCase() === 'ya') {
                                radioPaudFormalYa.checked = true;
                            } else if (paudFormal.toLowerCase() === 'tidak') {
                                radioPaudFormalTidak.checked = true;
                            } else {
                                radioPaudFormalYa.checked = false;
                                radioPaudFormalTidak.checked = false;
                            }
                        }
                        // PAUD Non Formal
                        var paudNonFormal = selected.getAttribute('data-paud_non_formal') || '';
                        var radioPaudNonFormalYa = registrasiModal.querySelector('input[name="paud_non_formal"][value="Ya"]');
                        var radioPaudNonFormalTidak = registrasiModal.querySelector('input[name="paud_non_formal"][value="Tidak"]');
                        if (radioPaudNonFormalYa && radioPaudNonFormalTidak) {
                            if (paudNonFormal.toLowerCase() === 'ya') {
                                radioPaudNonFormalYa.checked = true;
                            } else if (paudNonFormal.toLowerCase() === 'tidak') {
                                radioPaudNonFormalTidak.checked = true;
                            } else {
                                radioPaudNonFormalYa.checked = false;
                                radioPaudNonFormalTidak.checked = false;
                            }
                        }
                        if (namaPesertaModal) namaPesertaModal.innerText = selected.getAttribute('data-nama') || '[Nama Peserta]';
                        if (inputNis) inputNis.value = selected.getAttribute('data-nis') || '';
                        // Jenis pendaftaran
                        if (selectJenis) {
                            var jenis = (selected.getAttribute('data-jenis_pendaftaran') || '').trim().toLowerCase();
                            var found = false;
                            for (var i = 0; i < selectJenis.options.length; i++) {
                                if (selectJenis.options[i].value.trim().toLowerCase() === jenis && jenis !== '') {
                                    selectJenis.selectedIndex = i;
                                    found = true;
                                    break;
                                }
                            }
                            if (!found) selectJenis.selectedIndex = 0;
                        }
                        // Hobby
                        if (selectHobby) {
                            var hobby = (selected.getAttribute('data-hobby') || '').trim().toLowerCase();
                            var foundHobby = false;
                            for (var i = 0; i < selectHobby.options.length; i++) {
                                if (selectHobby.options[i].value.trim().toLowerCase() === hobby && hobby !== '') {
                                    selectHobby.selectedIndex = i;
                                    foundHobby = true;
                                    break;
                                }
                            }
                            if (!foundHobby) selectHobby.selectedIndex = 0;
                        }
                        // Cita-cita
                        if (selectCita) {
                            var cita = (selected.getAttribute('data-cita_cita') || '').trim().toLowerCase();
                            var foundCita = false;
                            for (var i = 0; i < selectCita.options.length; i++) {
                                if (selectCita.options[i].value.trim().toLowerCase() === cita && cita !== '') {
                                    selectCita.selectedIndex = i;
                                    foundCita = true;
                                    break;
                                }
                            }
                            if (!foundCita) selectCita.selectedIndex = 0;
                        }
                        // Tanggal masuk sekolah
                        var inputTanggal = registrasiModal.querySelector('input[name="tanggal_pendaftaran"]');
                        if (inputTanggal) {
                            var tgl = selected.getAttribute('data-tanggal_pendaftaran') || '';
                            inputTanggal.value = tgl;
                        }
                        // --- ISI FIELD MUTASI ---
                        if (keluarKarena) {
                            keluarKarena.value = 'Mutasi';
                        }
                        if (tanggalKeluar) {
                            tanggalKeluar.value = '';
                        }
                        if (alasanKeluar) {
                            alasanKeluar.value = '';
                        }
                    } else {
                        var inputSekolahAsal = registrasiModal.querySelector('input[name="sekolah_asal"]');
                        if (inputSekolahAsal) inputSekolahAsal.value = '';
                        var radioPaudFormalYa = registrasiModal.querySelector('input[name="paud_formal"][value="Ya"]');
                        var radioPaudFormalTidak = registrasiModal.querySelector('input[name="paud_formal"][value="Tidak"]');
                        if (radioPaudFormalYa) radioPaudFormalYa.checked = false;
                        if (radioPaudFormalTidak) radioPaudFormalTidak.checked = false;
                        var radioPaudNonFormalYa = registrasiModal.querySelector('input[name="paud_non_formal"][value="Ya"]');
                        var radioPaudNonFormalTidak = registrasiModal.querySelector('input[name="paud_non_formal"][value="Tidak"]');
                        if (radioPaudNonFormalYa) radioPaudNonFormalYa.checked = false;
                        if (radioPaudNonFormalTidak) radioPaudNonFormalTidak.checked = false;
                        if (namaPesertaModal) namaPesertaModal.innerText = '[Nama Peserta]';
                        if (inputNis) inputNis.value = '';
                        if (selectJenis) selectJenis.selectedIndex = 0;
                        if (selectHobby) selectHobby.selectedIndex = 0;
                        if (selectCita) selectCita.selectedIndex = 0;
                        var inputTanggal = registrasiModal.querySelector('input[name="tanggal_pendaftaran"]');
                        if (inputTanggal) inputTanggal.value = '';
                    }
                });

                registrasiModal.addEventListener('hidden.bs.modal', function() {
                    if (namaPesertaModal) namaPesertaModal.innerText = '[Nama Peserta]';
                    if (inputNis) inputNis.value = '';
                    var selectJenis = registrasiModal.querySelector('select[name="jenis_pendaftaran"]');
                    if (selectJenis) selectJenis.value = '';
                });
            }
        });
    </script>
    <?= $this->endSection() ?>