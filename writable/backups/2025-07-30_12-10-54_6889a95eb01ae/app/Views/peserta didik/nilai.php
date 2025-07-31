<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Data Surat Masuk &mdash; SDN Krengseng 02</title>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-xs-12 col-md-8 d-flex align-items-center flex-wrap gap-1" style="gap: 6px 8px !important;">
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalMapel"><i class="fas fa-edit"></i> Edit Mapel</button>
                        <!-- Modal Pengaturan Mata Pelajaran (letakkan di paling bawah) -->
                        <div class="modal fade" id="modalMapel" tabindex="-1" aria-labelledby="modalMapelLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalMapelLabel"><i class="fas fa-cog"></i> PENGATURAN MATA PELAJARAN</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered table-striped" id="tabel-mapel">
                                <thead class="table-primary">
                                    <tr>
                                    <th style="width:40px;">#</th>
                                    <th>Mata Pelajaran</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-mapel">
                                    <tr><td>1</td><td>Pendidikan Agama Islam dan Budi Pekerti</td></tr>
                                    <tr><td>2</td><td>Pendidikan Pancasila</td></tr>
                                    <tr><td>3</td><td>Bahasa Indonesia</td></tr>
                                    <tr><td>4</td><td>Matematika</td></tr>
                                    <tr class="mapel-ipa-sosial"><td>5</td><td>Ilmu Pengetahuan Alam dan Sosial</td></tr>
                                    <tr><td>6</td><td>Pendidikan Jasmani, Olahraga, dan Kesehatan</td></tr>
                                    <tr><td>7</td><td>Seni Budaya</td></tr>
                                    <tr><td>8</td><td>Bahasa Jawa</td></tr>
                                    <tr class="mapel-binggris"><td>9</td><td>Bahasa Inggris</td></tr>
                                    <tr class="mapel-kewirausahaan"><td>10</td><td>Pendidikan Kewirausahaan</td></tr>
                                    <tr><td>11</td><td>Pendidikan Budaya dan Lingkungan</td></tr>
                                </tbody>
                                </table>
                                <script>
document.addEventListener('DOMContentLoaded', function() {
    var kelasSelect = document.getElementById('id_rombel');
    var tbody = document.getElementById('tbody-mapel');
    // Simpan semua baris mapel (asli)
    var allRows = Array.from(tbody.querySelectorAll('tr'));
    function updateMapelRows() {
        var val = kelasSelect.value;
        var kelas = (val.match(/\d+/) || [null])[0];
        kelas = kelas ? parseInt(kelas) : null;
        // Reset tbody
        tbody.innerHTML = '';
        var idx = 1;
        allRows.forEach(function(row) {
            var show = true;
            if (row.classList.contains('mapel-ipa-sosial') || row.classList.contains('mapel-binggris') || row.classList.contains('mapel-kewirausahaan')) {
                if (kelas === 1 || kelas === 2) {
                    show = false;
                }
            }
            if (show) {
                // Update nomor urut
                var td = row.querySelector('td');
                if (td) td.textContent = idx++;
                tbody.appendChild(row);
            }
        });
    }
    kelasSelect && kelasSelect.addEventListener('change', updateMapelRows);
    updateMapelRows();
});
                                </script>
                                <div class="text-danger small mt-2">Silahkan tetapkan pengaturan kelas, fase, dan kurikulum</div>
                                <div class="row mt-3">
                                <div class="col-md-4 mb-2">
                                    <select class="form-select form-select-sm" name="id_rombel" id="id_rombel">
                                        <option value="">Pilih Kelas</option>
                                        <?php if (isset($rombels) && is_array($rombels)): ?>
                                            <?php
                                            $kelasSudah = [];
                                            foreach ($rombels as $rombel):
                                                $kelas = trim($rombel->kelas);
                                                if ($kelas && !in_array($kelas, $kelasSudah)):
                                                    $kelasSudah[] = $kelas;
                                            ?>
                                                <option value="<?= htmlspecialchars($kelas) ?>"><?= htmlspecialchars($kelas) ?></option>
                                            <?php endif; endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <select class="form-select form-select-sm">
                                    <option>Fase</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <select class="form-select form-select-sm">
                                    <option>Kurikulum 13</option>
                                    <option>Kurikulum Merdeka</option>
                                    </select>
                                </div>
                                </div>
                                <div class="d-flex justify-content-end gap-2 mt-3">
                                <button class="btn btn-danger btn-sm">Batal</button>
                                <button class="btn btn-primary btn-sm">Simpan</button>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                                                        <button class="btn btn-danger btn-sm"><i class="fas fa-file-excel"></i> Template Nilai</button>
                                <button class="btn btn-info btn-sm"><i class="fas fa-upload"></i> Upload Nilai</button>
                                <form method="get" id="filter-kelas-form" class="mb-0 d-flex align-items-center" style="min-width:160px;">
                                    <select name="filter_kelas" id="filter_kelas" class="form-select form-select-sm" style="min-width:140px;">
                                        <option value="">Kelas/Tingkat</option>
                                        <option value="X-IPA-1">X-IPA-1</option>
                                        <option value="X-IPA-2">X-IPA-2</option>
                                    </select>
                                </form>
                                <form method="get" id="filter-jurusan-form" class="mb-0 d-flex align-items-center" style="min-width:160px;">
                                    <select name="filter_jurusan" id="filter_jurusan" class="form-select form-select-sm" style="min-width:140px;">
                                        <option value="">Fase</option>
                                        <option value="Fase A">Fase A</option>
                                        <option value="Fase B">Fase B</option>
                                        <option value="Fase C">Fase C</option>
                                    </select>
                                </form>
                            </div>
                            <div class="col-xs-12 col-md-4 d-flex justify-content-end align-items-center gap-1" style="gap: 6px 8px !important;">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-outline-secondary btn-sm">Copy</button>
                                    <button class="btn btn-outline-secondary btn-sm">Excel</button>
                                    <button class="btn btn-outline-secondary btn-sm">PDF</button>
                                    <button class="btn btn-outline-secondary btn-sm">Print</button>
                                </div>
                            </div>
                        </div>
                        <table id="scroll-horizontal" class="table table-bordered dt-responsive nowrap w-100">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>NISN</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Kurikulum</th>
                                    <th>Status Nilai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td>2200<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></td>
                                    <td>9996<?= rand(100000,999999) ?></td>
                                    <td><?= ['SAN SAN','VERANIKA','DEVIN ANGELIUS','YANTO','SENNA SAVANNAH','NG HAINY','MELISYA','WILLY SUTANTO','MIKI FRANLIE','RICKY RAVEN'][$i-1] ?></td>
                                    <td><?= $i < 9 ? 'X-IPA-1' : 'X-IPA-2' ?></td>
                                    <td>X-IPA-1</td>
                                    <td><span class="badge bg-warning">Nominal</span></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">nilai</button>
                                        <button class="btn btn-warning btn-sm">cetak</button>
                                    </td>
                                </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>