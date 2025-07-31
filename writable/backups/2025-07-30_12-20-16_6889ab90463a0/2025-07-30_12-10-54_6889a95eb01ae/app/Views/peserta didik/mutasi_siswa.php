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
                    <h4 class="mb-sm-0 font-size-18">Mutasi Siswa</h4>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-1">
                            <div class="col-xs-6 col-md-6">
                                <h4 class="alert-heading">Data Mutasi Siswa</h4>
                                <div class="d-flex align-items-center">
                                </div>
                            </div>
                            <!-- Right column with 4 buttons -->
                            <!-- <div class="col-xs-6 col-md-6 text-end">
                                <button type="button" class="btn btn-sm btn-warning waves-effect waves-light w-sm bg-gradient">
                                    <i class="bx bx-cloud-drizzle d-block font-size-16"></i> Data Alumni
                                </button>
                                <a href="#" class="btn btn-sm btn-danger waves-effect waves-light bg-gradient">
                                    <i class="fas fa-sync"></i> Pindah Kelas
                                </a>


                            </div> -->
                        </div>
                        <hr class="border-danger-subtle">
                        <div class="d-flex align-items-center mb-3">
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
                                            <th class="align-middle">Tanggal Keluar</th>
                                            <th class="align-middle">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="siswa-table-body">
                                    <?php if (!empty($siswa_mutasi)): ?>
                                        <?php foreach ($siswa_mutasi as $i => $row): ?>
                                            <tr>
                                                <td><input type="checkbox" name="siswa[]" value="<?= $row->id_siswa ?>"></td>
                                                <td><?= htmlspecialchars($row->nama_siswa ?? '-') ?></td>
                                                <td><?= htmlspecialchars($row->nisn ?? '-') ?></td>
                                                <td><?= htmlspecialchars($row->jk ?? '-') ?></td>
                                                <td><?= htmlspecialchars($row->nis ?? '-') ?></td>
                                                <td><?= htmlspecialchars($row->kelas ?? $row->rombel ?? '-') ?></td>
                                                <td><?= htmlspecialchars($row->tanggal_mutasi ?? $row->tanggal_keluar ?? '-') ?></td>
                                                <td>
                                                    <a href="<?= site_url('peserta_didik/cetak_mutasi/' . $row->id_siswa) ?>" target="_blank" class="btn btn-sm btn-info" title="Cetak Surat Mutasi"><i class="fas fa-file-pdf"></i> PDF</a>
                                                    <button type="button" class="btn btn-sm btn-warning btn-batal-mutasi" data-id="<?= $row->id_siswa ?>" title="Batal Mutasi"><i class="fas fa-undo"></i> Batal Mutasi</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="8" class="text-center">Tidak ada data siswa mutasi.</td></tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        <div class="row">
                                <div class="col-xs-6 col-md-6 mt-2">
                                <a href="#" class="btn btn-sm btn-success waves-effect waves-light bg-gradient">
                                    <i class="fas fa-check"></i> Simpan
                                </a>
                                <a href="<?= site_url('peserta_didik/new') ?>" class="btn btn-sm btn-danger waves-effect waves-light bg-gradient">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handler untuk tombol Batal Mutasi
    document.querySelectorAll('.btn-batal-mutasi').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var id = this.getAttribute('data-id');
            Swal.fire({
                title: 'Batalkan Mutasi?',
                text: 'Data mutasi siswa ini akan dibatalkan dan siswa akan dikembalikan ke data aktif.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX request ke endpoint batal_mutasi
                    fetch('<?= site_url('peserta_didik/batal_mutasi/') ?>' + id, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                        },
                        body: JSON.stringify({id: id})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Berhasil!', data.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Gagal', data.message || 'Terjadi kesalahan.', 'error');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Gagal', 'Tidak dapat menghubungi server.', 'error');
                    });
                }
            });
        });
    });
});
</script>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- DataTables default (bawaan template/adminlte/bootstrap) -->
                        <!-- DataTables init (opsional, tanpa AJAX) -->
                        <script>
                        // Hindari error reinitialisasi DataTable
                        $(function() {
                            if (!$.fn.DataTable.isDataTable('#scroll-horizontal')) {
                                $('#scroll-horizontal').DataTable({
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
                                    columnDefs: [
                                        { orderable: false, targets: 0 },
                                        { orderable: false, targets: 7 }
                                    ]
                                });
                            }
                        });
                        </script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var rombelSelect = document.getElementById('id_rombel');
                    var selectAllCheckbox = document.getElementById('select-all');
                    // Add event listener to the "Select All" checkbox only once
                    if (selectAllCheckbox) {
                        selectAllCheckbox.addEventListener('change', function() {
                            var checkboxes = document.querySelectorAll('input[type="checkbox"][name="siswa[]"]');
                            checkboxes.forEach(function(checkbox) {
                                checkbox.checked = selectAllCheckbox.checked;
                            });
                        });
                    }

                    if (rombelSelect) {
                        rombelSelect.addEventListener('change', function() {
                            var id_rombel = this.value;
                            console.log('Selected class ID:', id_rombel); // Debugging log
                            var xhr = new XMLHttpRequest();
                            xhr.open('GET', '<?= site_url('siswa_naik/getSiswaByKelas'); ?>/' + id_rombel, true);
                            xhr.onload = function() {
                                if (xhr.status === 200) {
                                    console.log('Response received:', xhr.responseText); // Debugging log
                                    var siswa = JSON.parse(xhr.responseText);
                                    console.log('Parsed data:', siswa); // Debugging log
                                    var tbody = document.getElementById('siswa-table-body');
                                    tbody.innerHTML = '';
                    // Clear DataTable jika sudah ada, lalu isi ulang
                    if (window.tableLulusan) {
                        window.tableLulusan.clear().draw();
                    }
                    siswa.forEach(function(s) {
                        var rowData = [
                            '<input type="checkbox" name="siswa[]" value="' + (s.id_siswa ?? s.id_peserta ?? '-') + '">',
                            (s.nama_siswa ?? s.nama_peserta ?? '-'),
                            (s.nisn ?? '-'),
                            (s.jk ?? s.jenis_kelamin ?? '-'),
                            (s.nis ?? '-'),
                            (s.kelas ?? '-')
                        ];
                        if (window.tableLulusan) {
                            window.tableLulusan.row.add(rowData);
                        }
                    });
                    if (window.tableLulusan) {
                        window.tableLulusan.draw(false);
                    }
                                } else {
                                    console.error('Error fetching data:', xhr.statusText); // Debugging log
                                }
                            };
                            xhr.onerror = function() {
                                console.error('Request failed'); // Debugging log
                            };
                            xhr.send();
                        });
                    }
                });
            </script>

<?= $this->endSection() ?>