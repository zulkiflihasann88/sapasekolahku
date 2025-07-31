<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Verifikasi dan Validasi Nilai Siswa &mdash; SDN Krengseng 02</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Verifikasi dan Validasi Nilai Siswa</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= site_url('akademik') ?>">Akademik</a></li>
                            <li class="breadcrumb-item active">Verval Nilai Siswa</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body"> <!-- Filter Section -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="filter_tahun_pelajaran" class="form-label">Tahun Pelajaran <span class="text-danger">*</span></label>
                                <select class="form-select" id="filter_tahun_pelajaran" name="filter_tahun_pelajaran" required>
                                    <option value="">-- Pilih Tahun Pelajaran --</option>
                                    <?php if (isset($tahun_pelajaran) && is_array($tahun_pelajaran)): ?>
                                        <?php foreach ($tahun_pelajaran as $tahun): ?>
                                            <option value="<?= isset($tahun->id_tahunajaran) ? $tahun->id_tahunajaran : '' ?>" <?= (isset($selected_tahun) && isset($tahun->id_tahunajaran) && $selected_tahun == $tahun->id_tahunajaran) ? 'selected' : '' ?>>
                                                <?= isset($tahun->tahun) ? $tahun->tahun : (isset($tahun->ket_tahun) ? $tahun->ket_tahun : 'Unknown') ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="1">2024/2025</option>
                                        <option value="2">2023/2024</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filter_kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                <select class="form-select" id="filter_kelas" name="filter_kelas" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <?php if (isset($kelas) && is_array($kelas)): ?>
                                        <?php foreach ($kelas as $k): ?>
                                            <option value="<?= isset($k->id_rombel) ? $k->id_rombel : '' ?>" <?= (isset($selected_kelas) && isset($k->id_rombel) && $selected_kelas == $k->id_rombel) ? 'selected' : '' ?>>
                                                <?= isset($k->kelas) ? $k->kelas : (isset($k->rombel) ? $k->rombel : 'Unknown') ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="1">Kelas I</option>
                                        <option value="2">Kelas II</option>
                                        <option value="3">Kelas III</option>
                                        <option value="4">Kelas IV</option>
                                        <option value="5">Kelas V</option>
                                        <option value="6">Kelas VI</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filter_mata_pelajaran" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                                <select class="form-select" id="filter_mata_pelajaran" name="filter_mata_pelajaran" required>
                                    <option value="">-- Pilih Mata Pelajaran --</option>
                                    <?php if (isset($mata_pelajaran) && is_array($mata_pelajaran)): ?>
                                        <?php foreach ($mata_pelajaran as $mapel): ?>
                                            <option value="<?= isset($mapel->id_pelajaran) ? $mapel->id_pelajaran : '' ?>" <?= (isset($selected_mapel) && isset($mapel->id_pelajaran) && $selected_mapel == $mapel->id_pelajaran) ? 'selected' : '' ?>>
                                                <?= isset($mapel->nama_mapel) ? $mapel->nama_mapel : (isset($mapel->kode_mapel) ? $mapel->kode_mapel : 'Unknown') ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="1">Matematika</option>
                                        <option value="2">Bahasa Indonesia</option>
                                        <option value="3">IPA</option>
                                        <option value="4">IPS</option>
                                        <option value="5">PKn</option>
                                        <option value="6">Bahasa Inggris</option>
                                        <option value="7">Seni Budaya</option>
                                        <option value="8">PJOK</option>
                                        <option value="9">Agama</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filter_semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                <select class="form-select" id="filter_semester" name="filter_semester" required>
                                    <option value="">-- Pilih Semester --</option>
                                    <option value="1" <?= (isset($selected_semester) && $selected_semester == '1') ? 'selected' : '' ?>>Semester 1 (Ganjil)</option>
                                    <option value="2" <?= (isset($selected_semester) && $selected_semester == '2') ? 'selected' : '' ?>>Semester 2 (Genap)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" onclick="filterData()">
                                    <i class="fas fa-search"></i> Filter Data
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light" onclick="resetFilter()">
                                    <i class="fas fa-refresh"></i> Reset
                                </button>
                                <button type="button" class="btn btn-warning btn-sm waves-effect waves-light" onclick="testAjax()">
                                    <i class="fas fa-bug"></i> Test AJAX
                                </button>
                            </div>
                            <div class="col-sm-6 text-end">
                                <button type="button" class="btn btn-success btn-sm waves-effect waves-light" onclick="exportToExcel()" id="btn-export" style="display: none;">
                                    <i class="fas fa-download"></i> Unduh Excel
                                </button>
                                <button type="button" class="btn btn-info btn-sm waves-effect waves-light" onclick="validasiSemua()" id="btn-validasi-semua" style="display: none;">
                                    <i class="fas fa-check-double"></i> Validasi Semua
                                </button>
                            </div>
                        </div>

                        <!-- Alert Information -->
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Informasi:</strong>
                            Verifikasi dan validasi nilai siswa digunakan untuk memastikan keakuratan data nilai sebelum finalisasi rapor.
                            Status <span class="badge bg-warning">Belum Diverifikasi</span> memerlukan validasi manual,
                            sedangkan status <span class="badge bg-success">Terverifikasi</span> menandakan data sudah valid.
                        </div>

                        <!-- Statistics Cards -->
                        <div class="row mb-4" id="statistics-section" style="display: none;">
                            <div class="col-xl-3 col-md-6">
                                <div class="card card-h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Siswa</span>
                                                <h4 class="mb-3" id="total-siswa">0</h4>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="text-end">
                                                    <div class="avatar-sm bg-light rounded-circle">
                                                        <span class="avatar-title bg-primary bg-gradient rounded-circle font-size-22">
                                                            <i class="fas fa-users"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card card-h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Sudah Terverifikasi</span>
                                                <h4 class="mb-3 text-success" id="terverifikasi">0</h4>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="text-end">
                                                    <div class="avatar-sm bg-light rounded-circle">
                                                        <span class="avatar-title bg-success bg-gradient rounded-circle font-size-22">
                                                            <i class="fas fa-check"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card card-h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Belum Diverifikasi</span>
                                                <h4 class="mb-3 text-warning" id="belum-verifikasi">0</h4>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="text-end">
                                                    <div class="avatar-sm bg-light rounded-circle">
                                                        <span class="avatar-title bg-warning bg-gradient rounded-circle font-size-22">
                                                            <i class="fas fa-clock"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card card-h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Persentase Verifikasi</span>
                                                <h4 class="mb-3 text-info" id="persentase-verifikasi">0%</h4>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="text-end">
                                                    <div class="avatar-sm bg-light rounded-circle">
                                                        <span class="avatar-title bg-info bg-gradient rounded-circle font-size-22">
                                                            <i class="fas fa-chart-pie"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive" id="table-section" style="display: none;">
                            <table id="verval-nilai-table" class="table table-bordered dt-responsive nowrap w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th class="align-middle text-center">
                                            <input type="checkbox" id="select-all" class="form-check-input">
                                        </th>
                                        <th class="align-middle text-center">No.</th>
                                        <th class="align-middle text-center">NISN</th>
                                        <th class="align-middle text-center">Nama Siswa</th>
                                        <th class="align-middle text-center">Kelas</th>
                                        <th class="align-middle text-center">Mata Pelajaran</th>
                                        <th class="align-middle text-center">Tugas<br><small class="text-muted">(Rata-rata)</small></th>
                                        <th class="align-middle text-center">UH<br><small class="text-muted">(Rata-rata)</small></th>
                                        <th class="align-middle text-center">UTS</th>
                                        <th class="align-middle text-center">UAS</th>
                                        <th class="align-middle text-center">Nilai Akhir</th>
                                        <th class="align-middle text-center">Predikat</th>
                                        <th class="align-middle text-center">Status</th>
                                        <th class="align-middle text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    <!-- Data will be loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Empty State -->
                        <div id="empty-state" class="text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Silakan pilih filter untuk menampilkan data</h5>
                            <p class="text-muted">Pilih tahun pelajaran, kelas, mata pelajaran, dan semester untuk melihat data nilai siswa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Edit Nilai -->
<div class="modal fade" id="modalEditNilai" tabindex="-1" aria-labelledby="modalEditNilaiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditNilaiLabel">Edit Nilai Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditNilai">
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">NISN</label>
                            <input type="text" class="form-control" id="edit_nisn" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Siswa</label>
                            <input type="text" class="form-control" id="edit_nama_siswa" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Kelas</label>
                            <input type="text" class="form-control" id="edit_kelas" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mata Pelajaran</label>
                            <input type="text" class="form-control" id="edit_mata_pelajaran" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Nilai Tugas <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_nilai_tugas" name="nilai_tugas" min="0" max="100" step="0.01" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Nilai UH <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_nilai_uh" name="nilai_uh" min="0" max="100" step="0.01" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Nilai UTS <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_nilai_uts" name="nilai_uts" min="0" max="100" step="0.01" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Nilai UAS <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_nilai_uas" name="nilai_uas" min="0" max="100" step="0.01" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nilai Akhir</label>
                            <input type="number" class="form-control" id="edit_nilai_akhir" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Predikat</label>
                            <input type="text" class="form-control" id="edit_predikat" readonly>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Formula Nilai Akhir:</strong> (Tugas × 20%) + (UH × 30%) + (UTS × 20%) + (UAS × 30%)
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize DataTable (hidden initially)
        var table = $('#verval-nilai-table').DataTable({
            "scrollX": true,
            "pageLength": 25,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "Semua"]
            ],
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data yang tersedia",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            },
            "columnDefs": [{
                "orderable": false,
                "targets": [0, 13]
            }]
        });

        // Handle select all checkbox
        $('#select-all').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('.row-checkbox').prop('checked', isChecked);
        });

        // Handle individual checkbox
        $(document).on('change', '.row-checkbox', function() {
            var totalCheckboxes = $('.row-checkbox').length;
            var checkedCheckboxes = $('.row-checkbox:checked').length;
            $('#select-all').prop('checked', totalCheckboxes === checkedCheckboxes);
        });

        // Auto calculate nilai akhir in modal
        $('#edit_nilai_tugas, #edit_nilai_uh, #edit_nilai_uts, #edit_nilai_uas').on('input', function() {
            calculateNilaiAkhir();
        });

        // Handle form submission
        $('#formEditNilai').on('submit', function(e) {
            e.preventDefault();
            saveEditNilai();
        });
    });

    function filterData() {
        var tahunPelajaran = $('#filter_tahun_pelajaran').val();
        var kelas = $('#filter_kelas').val();
        var mataPelajaran = $('#filter_mata_pelajaran').val();
        var semester = $('#filter_semester').val();

        if (!tahunPelajaran || !kelas || !mataPelajaran || !semester) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Silakan pilih semua filter terlebih dahulu!'
            });
            return;
        }

        // Show loading
        Swal.fire({
            title: 'Memuat data...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        $.ajax({
            url: '<?= site_url("akademik/get_verval_nilai_data") ?>',
            type: 'POST',
            data: {
                tahun_pelajaran: tahunPelajaran,
                kelas: kelas,
                mata_pelajaran: mataPelajaran,
                semester: semester,
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            },
            dataType: 'json',
            success: function(response) {
                Swal.close();

                if (response.success) {
                    // Update statistics
                    $('#total-siswa').text(response.statistics.total);
                    $('#terverifikasi').text(response.statistics.terverifikasi);
                    $('#belum-verifikasi').text(response.statistics.belum_verifikasi);
                    $('#persentase-verifikasi').text(response.statistics.persentase + '%');

                    // Clear and populate table
                    var table = $('#verval-nilai-table').DataTable();
                    table.clear();

                    if (response.data.length > 0) {
                        $.each(response.data, function(index, item) {
                            var predikat = getPredikat(item.nilai_akhir);
                            var statusBadge = item.status_verifikasi == 1 ?
                                '<span class="badge bg-success">Terverifikasi</span>' :
                                '<span class="badge bg-warning">Belum Diverifikasi</span>';

                            table.row.add([
                                '<input type="checkbox" class="form-check-input row-checkbox" value="' + item.id + '">',
                                index + 1,
                                item.nisn || '-',
                                item.nama_siswa || '-',
                                item.nama_kelas || '-',
                                item.nama_mata_pelajaran || '-',
                                parseFloat(item.nilai_tugas || 0).toFixed(1),
                                parseFloat(item.nilai_uh || 0).toFixed(1),
                                parseFloat(item.nilai_uts || 0).toFixed(1),
                                parseFloat(item.nilai_uas || 0).toFixed(1),
                                parseFloat(item.nilai_akhir || 0).toFixed(1),
                                predikat,
                                statusBadge,
                                '<div class="btn-group" role="group">' +
                                '<button type="button" class="btn btn-sm btn-outline-primary" onclick="editNilai(' + item.id + ')" title="Edit Nilai">' +
                                '<i class="fas fa-edit"></i>' +
                                '</button>' +
                                '<button type="button" class="btn btn-sm btn-outline-success" onclick="verifikasiNilai(' + item.id + ')" title="Verifikasi">' +
                                '<i class="fas fa-check"></i>' +
                                '</button>' +
                                '</div>'
                            ]);
                        });
                    }

                    table.draw();

                    // Show table and statistics, hide empty state
                    $('#table-section').show();
                    $('#statistics-section').show();
                    $('#empty-state').hide();
                    $('#btn-export').show();
                    $('#btn-validasi-semua').show();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Terjadi kesalahan saat memuat data'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.close();
                console.log('AJAX Error:', {
                    xhr: xhr,
                    status: status,
                    error: error,
                    responseText: xhr.responseText
                });
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memuat data: ' + error,
                    footer: 'Status: ' + status + ' | ' + xhr.statusText
                });
            }
        });
    }

    function resetFilter() {
        $('#filter_tahun_pelajaran').val('');
        $('#filter_kelas').val('');
        $('#filter_mata_pelajaran').val('');
        $('#filter_semester').val('');

        // Hide table and statistics, show empty state
        $('#table-section').hide();
        $('#statistics-section').hide();
        $('#empty-state').show();
        $('#btn-export').hide();
        $('#btn-validasi-semua').hide();

        // Clear table
        $('#verval-nilai-table').DataTable().clear().draw();
    }

    function editNilai(id) {
        $.ajax({
            url: '<?= site_url("akademik/get_nilai_detail") ?>/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var data = response.data;
                    $('#edit_id').val(data.id);
                    $('#edit_nisn').val(data.nisn);
                    $('#edit_nama_siswa').val(data.nama_siswa);
                    $('#edit_kelas').val(data.nama_kelas);
                    $('#edit_mata_pelajaran').val(data.nama_mata_pelajaran);
                    $('#edit_nilai_tugas').val(data.nilai_tugas);
                    $('#edit_nilai_uh').val(data.nilai_uh);
                    $('#edit_nilai_uts').val(data.nilai_uts);
                    $('#edit_nilai_uas').val(data.nilai_uas);

                    calculateNilaiAkhir();
                    $('#modalEditNilai').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Data tidak ditemukan'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memuat data'
                });
            }
        });
    }

    function calculateNilaiAkhir() {
        var tugas = parseFloat($('#edit_nilai_tugas').val()) || 0;
        var uh = parseFloat($('#edit_nilai_uh').val()) || 0;
        var uts = parseFloat($('#edit_nilai_uts').val()) || 0;
        var uas = parseFloat($('#edit_nilai_uas').val()) || 0;

        var nilaiAkhir = (tugas * 0.2) + (uh * 0.3) + (uts * 0.2) + (uas * 0.3);
        $('#edit_nilai_akhir').val(nilaiAkhir.toFixed(1));
        $('#edit_predikat').val(getPredikat(nilaiAkhir));
    }

    function getPredikat(nilai) {
        if (nilai >= 90) return 'A (Sangat Baik)';
        if (nilai >= 80) return 'B (Baik)';
        if (nilai >= 70) return 'C (Cukup)';
        if (nilai >= 60) return 'D (Kurang)';
        return 'E (Sangat Kurang)';
    }

    function saveEditNilai() {
        var formData = $('#formEditNilai').serialize();

        $.ajax({
            url: '<?= site_url("akademik/update_nilai") ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#modalEditNilai').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Nilai berhasil diperbarui!'
                    }).then(() => {
                        filterData(); // Refresh data
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Gagal memperbarui nilai'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memperbarui data'
                });
            }
        });
    }

    function verifikasiNilai(id) {
        Swal.fire({
            title: 'Konfirmasi Verifikasi',
            text: 'Apakah Anda yakin ingin memverifikasi nilai ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Verifikasi',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= site_url("akademik/verifikasi_nilai") ?>',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Nilai berhasil diverifikasi!'
                            }).then(() => {
                                filterData(); // Refresh data
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Gagal memverifikasi nilai'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat memverifikasi data'
                        });
                    }
                });
            }
        });
    }

    function validasiSemua() {
        var checkedIds = [];
        $('.row-checkbox:checked').each(function() {
            checkedIds.push($(this).val());
        });

        if (checkedIds.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Pilih setidaknya satu data untuk diverifikasi!'
            });
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Verifikasi Massal',
            text: 'Apakah Anda yakin ingin memverifikasi ' + checkedIds.length + ' data yang dipilih?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Verifikasi Semua',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= site_url("akademik/verifikasi_nilai_massal") ?>',
                    type: 'POST',
                    data: {
                        ids: checkedIds
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message || 'Semua data berhasil diverifikasi!'
                            }).then(() => {
                                filterData(); // Refresh data
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Gagal memverifikasi data'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat memverifikasi data'
                        });
                    }
                });
            }
        });
    }

    function exportToExcel() {
        var tahunPelajaran = $('#filter_tahun_pelajaran').val();
        var kelas = $('#filter_kelas').val();
        var mataPelajaran = $('#filter_mata_pelajaran').val();
        var semester = $('#filter_semester').val();

        if (!tahunPelajaran || !kelas || !mataPelajaran || !semester) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Silakan filter data terlebih dahulu!'
            });
            return;
        }

        window.location.href = '<?= site_url("akademik/export_verval_nilai") ?>?' +
            'tahun_pelajaran=' + tahunPelajaran +
            '&kelas=' + kelas +
            '&mata_pelajaran=' + mataPelajaran +
            '&semester=' + semester;
    }

    function testAjax() {
        $.ajax({
            url: '<?= site_url("test-ajax-akademik") ?>',
            type: 'POST',
            data: {
                test: 'data',
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            },
            dataType: 'json',
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'AJAX Test Success!',
                    html: '<pre>' + JSON.stringify(response, null, 2) + '</pre>'
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'AJAX Test Failed',
                    html: 'Status: ' + status + '<br>Error: ' + error + '<br>Response: ' + xhr.responseText
                });
            }
        });
    }
</script>

<?= $this->endSection() ?>