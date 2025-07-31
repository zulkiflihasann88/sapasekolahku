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
                    <h4 class="mb-sm-0 font-size-18">Kelulusan</h4>
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
                                <h4 class="alert-heading">Data Siswa</h4>
                                <div class="d-flex align-items-center">
                                    <p class="alert-heading mb-1 me-2">Tahun Pelajaran</p>
                                    <span class="badge bg-primary">2024/2025</span>
                                </div>
                            </div>
                            <!-- Right column with 4 buttons -->
                            <div class="col-xs-6 col-md-6 text-end">
                                <button type="button" class="btn btn-sm btn-warning waves-effect waves-light w-sm bg-gradient">
                                    <i class="bx bx-cloud-drizzle d-block font-size-16"></i> Data Alumni
                                </button>
                                <!-- <a href="#" class="btn btn-sm btn-danger waves-effect waves-light bg-gradient">
                                    <i class="fas fa-sync"></i> Pindah Kelas
                                </a> -->


                            </div>
                        </div>
                        <hr class="border-danger-subtle">
                        <form action="<?= site_url('peserta_didik/luluskan') ?>" method="post" id="form-luluskan">
                            <?= csrf_field() ?>
                            <div class="d-flex align-items-center mb-3">
                                <p class="alert-heading mb-1 me-2 text-success">Daftar siswa kelas 6 untuk proses kelulusan</p>
                                <?php
                                $kelas6 = array_filter($rombels, function ($r) {
                                    return stripos($r->kelas, '6') !== false;
                                });
                                $rombel6 = reset($kelas6);
                                ?>
                                <input type="hidden" name="id_rombel" id="id_rombel" value="<?= $rombel6 ? $rombel6->id_rombel : '' ?>">
                                <span class="badge bg-info">Kelas: <?= $rombel6 ? $rombel6->kelas : 'Tidak ditemukan' ?></span>
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
                            <div class="row">
                                <div class="col-lg-4">
                                    <p class="alert-heading mb-2 text-primary">Status Kelulusan</p>
                                    <div class="mt-2">
                                        <select name="status_kelulusan" id="status_kelulusan" class="form-select ms-auto w-5" required>
                                            <option value="">Pilih Kelulusan</option>
                                            <option value="lulus">Lulus</option>
                                            <option value="tidak_lulus">Tidak Lulus</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <p class="alert-heading mb-2 text-primary">Tanggal Kelulusan</p>
                                    <div class="mt-2">
                                        <input type="date" name="tanggal_kelulusan" id="tanggal_kelulusan" class="form-control" placeholder="Tanggal Kelulusan" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <p class="alert-heading mb-2 text-primary">Tahun Pelajaran</p>
                                    <div class="mt-2">
                                        <select name="id_tahun_lulus" id="id_tahun_lulus" class="form-select ms-auto w-5" required>
                                            <option value="">Pilih Tahun Pelajaran</option>
                                            <?php
                                            // Tampilkan tahun pelajaran berjalan dan 5 tahun ke belakang
                                            $currentYear = (int)date('Y');
                                            $tahunList = [];
                                            for ($i = 0; $i < 6; $i++) {
                                                $awal = $currentYear - $i;
                                                $akhir = $awal + 1;
                                                $tahunList[] = $awal . '/' . $akhir;
                                            }
                                            // Cek jika $tapel dari database punya id, tampilkan juga (untuk keperluan id value)
                                            $tapelMap = [];
                                            if (isset($tapel) && is_array($tapel)) {
                                                foreach ($tapel as $tp) {
                                                    $tapelMap[$tp->ket_tahun] = $tp->id_tahun_ajaran;
                                                }
                                            }
                                            foreach ($tahunList as $tahun) {
                                                $selected = '';
                                                $idVal = isset($tapelMap[$tahun]) ? $tapelMap[$tahun] : $tahun;
                                                // Pilih tahun aktif dari tapel jika ada
                                                if (isset($tapel)) {
                                                    foreach ($tapel as $tp) {
                                                        if ($tp->ket_tahun == $tahun && $tp->status) $selected = 'selected';
                                                    }
                                                }
                                                echo "<option value=\"$idVal\" $selected>$tahun</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-6 mt-2">
                                    <button type="submit" id="btn-luluskan" class="btn btn-sm btn-success waves-effect waves-light bg-gradient">
                                        <i class="fas fa-check"></i> Simpan
                                    </button>
                        </form>
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
<!-- DataTables sudah ada di layout, tidak perlu dipanggil ulang di sini. -->
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
        // Ambil data kelas 6 langsung saat halaman dimuat
        var id_rombel = document.getElementById('id_rombel').value;
        if (id_rombel) {
            $.ajax({
                url: '<?= site_url('siswa_naik/getSiswaByKelas'); ?>/' + id_rombel,
                method: 'GET',
                dataType: 'json',
                success: function(siswa) {
                    table.clear();
                    siswa.forEach(function(s) {
                        table.row.add([
                            '<input type="checkbox" name="siswa[]" value="' + s.id_siswa + '">',
                            s.nama_siswa,
                            s.nisn,
                            s.jk,
                            s.nis,
                            (s.kelas ?? '-')
                        ]);
                    });
                    table.draw(false);
                },
                error: function(xhr) {
                    table.clear().draw();
                }
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var rombelSelect = document.getElementById('id_rombel');
        var selectAllCheckbox = document.getElementById('select-all');

        // Fungsi untuk centang semua checkbox siswa di seluruh halaman DataTable
        function toggleAllCheckboxes(checked) {
            var allCheckboxes = document.querySelectorAll('#scroll-horizontal tbody input[type="checkbox"][name="siswa[]"]');
            allCheckboxes.forEach(function(checkbox) {
                checkbox.checked = checked;
            });
        }

        // Event listener untuk "centang semua"
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                toggleAllCheckboxes(this.checked);
            });
        }

        // Sinkronisasi status centang semua saat DataTable di-draw (misal: paging, reload)
        if (window.table) {
            window.table.on('draw', function() {
                toggleAllCheckboxes(selectAllCheckbox.checked);
            });
        } else {
            $('#scroll-horizontal').on('draw.dt', function() {
                toggleAllCheckboxes(selectAllCheckbox.checked);
            });
        }

        // Jika ada perubahan pada salah satu checkbox siswa, update status "centang semua"
        $('#scroll-horizontal').on('change', 'input[type="checkbox"][name="siswa[]"]', function() {
            var all = document.querySelectorAll('#scroll-horizontal tbody input[type="checkbox"][name="siswa[]"]');
            var checked = document.querySelectorAll('#scroll-horizontal tbody input[type="checkbox"][name="siswa[]"]:checked');
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = (all.length > 0 && checked.length === all.length);
            }
        });

        // Event untuk ganti rombel (kelas)
        if (rombelSelect) {
            rombelSelect.addEventListener('change', function() {
                var id_rombel = this.value;
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '<?= site_url('siswa_naik/getSiswaByKelas'); ?>/' + id_rombel, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var siswa = JSON.parse(xhr.responseText);
                        if (window.table) {
                            window.table.clear();
                            siswa.forEach(function(s) {
                                window.table.row.add([
                                    '<input type="checkbox" name="siswa[]" value="' + s.id_siswa + '">',
                                    s.nama_siswa,
                                    s.nisn,
                                    s.jk,
                                    s.nis,
                                    (s.kelas ?? '-')
                                ]);
                            });
                            window.table.draw(false);
                        }
                        // Reset "centang semua" setelah reload data
                        if (selectAllCheckbox) selectAllCheckbox.checked = false;
                    }
                };
                xhr.send();
            });
        }
    });
</script>
<!-- DEBUG: Cek apakah SweetAlert2 ter-load dan style center aktif -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Swal:', typeof Swal, Swal);
        // Test manual popup
        // Swal.fire({title: 'Test Center', text: 'SweetAlert2 Center?', icon: 'info'});
    });
</script>
<script>
    // Gunakan template SweetAlert2 dari layout (default.php) agar posisi selalu center
    // Swal.fire akan otomatis center karena layout sudah mengatur style swal2-popup
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('form-luluskan');
        var btn = document.getElementById('btn-luluskan');
        if (form && btn) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                // Validasi minimal 1 siswa dipilih
                var checked = form.querySelectorAll('input[name="siswa[]"]:checked');
                if (checked.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Siswa',
                        text: 'Silakan pilih minimal satu siswa yang akan diluluskan.'
                    });
                    return;
                }
                // Tampilkan modal konfirmasi custom
                var modalHtml = `
            <div class="modal fade" id="modalKonfirmasiLulus" tabindex="-1" aria-labelledby="modalKonfirmasiLulusLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalKonfirmasiLulusLabel">Konfirmasi Kelulusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Data kelulusan siswa yang dipilih akan diproses.<br>Apakah Anda yakin ingin meluluskan siswa terpilih?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" id="btn-modal-luluskan">Ya, Proses!</button>
                  </div>
                </div>
              </div>
            </div>`;
                // Hapus modal lama jika ada
                var oldModal = document.getElementById('modalKonfirmasiLulus');
                if (oldModal) oldModal.remove();
                document.body.insertAdjacentHTML('beforeend', modalHtml);
                var modalEl = document.getElementById('modalKonfirmasiLulus');
                var bsModal = new bootstrap.Modal(modalEl);
                bsModal.show();
                // Handler tombol proses
                modalEl.querySelector('#btn-modal-luluskan').onclick = function() {
                    bsModal.hide();
                    form.submit();
                };
                // Handler tombol batal (opsional, modal otomatis close)
            });
        }
    });
</script>
<?= $this->endSection() ?>