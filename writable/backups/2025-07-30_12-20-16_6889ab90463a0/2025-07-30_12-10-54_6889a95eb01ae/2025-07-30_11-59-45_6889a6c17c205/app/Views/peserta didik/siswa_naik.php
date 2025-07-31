<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Validasi Siswa &mdash; SDN Krengseng 02</title>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Validasi Siswa</h4>
                </div>
            </div>
        </div>

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
        <div class="row">
            <div class="col-xl-12">
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Fitur Naik Kelas</h4>
                    <p>Fitur ini akan menaikkan siswa pada tahun pelajaran berikutnya, Silhkan pilih siswa terlebih dahulu, lalu tentukan kelas yang akan dituju</p>
                </div>
            </div>
            <!-- end col -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-1">
                            <div class="col-xs-6 col-md-6">
                                <h4 class="alert-heading">Naik Kelas</h4>
                                <p class="alert-heading mb-1">Tahun Pelajaran</p><span class="badge bg-primary">2024/2025</span>
                            </div>
                            <!-- Right column with 4 buttons -->
                            <div class="col-xs-6 col-md-6 text-end">
                                <a href="#" class="btn btn-sm btn-danger waves-effect waves-light bg-gradient">
                                    <i class="fas fa-sync"></i> Pindah Kelas
                                </a>
                                <a href="#" class="btn btn-sm btn-success waves-effect waves-light bg-gradient">
                                    <i class="fas fa-exchange-alt"></i> Verval Kelas
                                </a>

                            </div>
                        </div>
                        <hr class="border-danger-subtle">
                        <div class="mb-3">
                            <select name="id_rombel" id="id_rombel" class="form-control">
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($rombels as $rombel): ?>
                                    <option value="<?= $rombel->id_rombel; ?>"><?= $rombel->kelas; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="table-responsive">
                            <table id="scroll-horizontal" class="table table-bordered dt-responsive nowrap w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;"><input type="checkbox" id="select-all"></th>
                                        <th class="align-middle">Nama</th>
                                        <th class="align-middle">NISN</th>
                                        <th class="align-middle">JK</th>
                                        <th class="align-middle">NIS</th>
                                        <th class="align-middle">Kelas</th>
                                    </tr>
                                </thead>
                                <tbody id="siswa-table-body">
                                    <!-- Data will be populated here by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                        <form id="form-naik-kelas" action="<?= site_url('siswa/naikKelas') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="row">
                                <div class="col-lg-6">
                                    <p class="alert-heading mb-2">Naik Kelas</p>
                                    <div class="mt-2">
                                        <select name="kelas_baru" id="kelas_baru" class="form-control" required>
                                            <option value="">Pilih Kelas</option>
                                            <?php foreach ($rombels as $rombel): ?>
                                                <option value="<?= $rombel->id_rombel; ?>"><?= $rombel->kelas; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <p class="alert-heading mb-2">Tahun Pelajaran</p>
                                    <div class="mt-2">
                                        <select name="tahun_ajaran_baru" id="tahun_ajaran_baru" class="form-control" required>
                                            <option value="">Pilih Tahun Pelajaran</option>
                                            <?php foreach ($tapel as $tapel): ?>
                                                <option value="<?= $tapel->id_tahun_ajaran; ?>"><?= $tapel->ket_tahun; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-6 mt-2">
                                    <button type="submit" class="btn btn-sm btn-success waves-effect waves-light bg-gradient">
                                        <i class="fas fa-check"></i> Simpan
                                    </button>
                                    <a href="<?= site_url('peserta_didik/new') ?>" class="btn btn-sm btn-danger waves-effect waves-light bg-gradient">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- DataTables default (bawaan template/adminlte/bootstrap) -->
<script src="/public/backend/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/public/backend/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="/public/backend/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" />
<script>
    var table;
    $(document).ready(function() {
        // Inisialisasi DataTable hanya jika belum ada
        if (!$.fn.DataTable.isDataTable('#scroll-horizontal')) {
            table = $('#scroll-horizontal').DataTable({
                paging: true,
                searching: false,
                info: true,
                ordering: false,
                lengthChange: false,
                pageLength: 10,
                language: {
                    emptyTable: 'Tidak ada data siswa',
                    zeroRecords: 'Tidak ditemukan',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ siswa',
                    infoEmpty: 'Menampilkan 0 sampai 0 dari 0 siswa',
                    paginate: {
                        previous: 'Sebelumnya',
                        next: 'Berikutnya'
                    }
                },
                columns: [{
                        orderable: false
                    }, // checkbox
                    null, // Nama
                    null, // NISN
                    null, // JK
                    null, // NIS
                    null // Kelas
                ]
            });
        } else {
            table = $('#scroll-horizontal').DataTable();
        }

        // Setiap kali data siswa di-load, update DataTable tanpa re-inisialisasi
        var rombelSelect = document.getElementById('id_rombel');
        if (rombelSelect) {
            rombelSelect.addEventListener('change', function() {
                setTimeout(function() {
                    table.clear();
                    var rows = document.querySelectorAll('#siswa-table-body tr');
                    rows.forEach(function(row) {
                        table.row.add($(row)).draw(false);
                    });
                }, 500);
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var rombelSelect = document.getElementById('id_rombel');
        var selectAllCheckbox = document.getElementById('select-all');

        // Add event listener to the "Select All" checkbox only once
        selectAllCheckbox.addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('#siswa-table-body input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        if (rombelSelect) {
            rombelSelect.addEventListener('change', function() {
                var id_rombel = this.value;
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '<?= site_url('siswa_naik/getSiswaByKelas'); ?>/' + id_rombel, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var siswa = JSON.parse(xhr.responseText);
                        var tbody = document.getElementById('siswa-table-body');
                        tbody.innerHTML = '';
                        siswa.forEach(function(s) {
                            var tr = document.createElement('tr');
                            var kelas = '-';
                            if (s.kelas && s.kelas !== 'null' && s.kelas !== null && s.kelas !== undefined && s.kelas !== '') {
                                kelas = s.kelas;
                            } else if (s.nama_rombel && s.nama_rombel !== 'null' && s.nama_rombel !== null && s.nama_rombel !== undefined && s.nama_rombel !== '') {
                                kelas = s.nama_rombel;
                            } else if (s.rombel && s.rombel !== 'null' && s.rombel !== null && s.rombel !== undefined && s.rombel !== '') {
                                kelas = s.rombel;
                            }
                            tr.innerHTML = '<td class="align-middle" style="width: 50px;"><input type="checkbox" name="siswa[]" value="' + (s.id_siswa ?? '') + '"></td>' +
                                '<td class="align-middle">' + (s.nama_siswa ?? '-') + '</td>' +
                                '<td class="align-middle">' + (s.nisn ?? '-') + '</td>' +
                                '<td class="align-middle">' + (s.jk ?? '-') + '</td>' +
                                '<td class="align-middle">' + (s.nis ?? '-') + '</td>' +
                                '<td class="align-middle">' + kelas + '</td>';
                            tbody.appendChild(tr);
                        });
                    }
                };
                xhr.onerror = function() {
                    console.error('Request failed');
                };
                xhr.send();
            });
        }

        // Proses submit naik kelas
        var formNaikKelas = document.getElementById('form-naik-kelas');
        if (formNaikKelas) {
            formNaikKelas.addEventListener('submit', function(e) {
                var checked = document.querySelectorAll('#siswa-table-body input[type="checkbox"]:checked');
                if (checked.length === 0) {
                    alert('Pilih minimal satu siswa yang akan dinaikkan kelas!');
                    e.preventDefault();
                    return false;
                }
                // Tambahkan input hidden untuk setiap siswa yang dipilih
                checked.forEach(function(cb) {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'siswa[]';
                    input.value = cb.value;
                    formNaikKelas.appendChild(input);
                });
            });
        }
    });
</script>

<?= $this->endSection() ?>