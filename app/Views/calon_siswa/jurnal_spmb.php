<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Jurnal SPMB &mdash; SDN Krengseng 02</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Jurnal SPMB</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?= site_url('calon_siswa') ?>">Calon Siswa</a></li>
                            <li class="breadcrumb-item active">Jurnal SPMB</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Statistics Cards -->
                        <div class="row mb-4">
                            <div class="col-xl-3 col-md-6">
                                <div class="card card-h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Pendaftar</span>
                                                <h4 class="mb-3"><?= $statistics['total_pendaftar'] ?></h4>
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
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Lulus</span>
                                                <h4 class="mb-3 text-success"><?= $statistics['lulus'] ?></h4>
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
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Tidak Lulus</span>
                                                <h4 class="mb-3 text-danger"><?= $statistics['tidak_lulus'] ?></h4>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="text-end">
                                                    <div class="avatar-sm bg-light rounded-circle">
                                                        <span class="avatar-title bg-danger bg-gradient rounded-circle font-size-22">
                                                            <i class="fas fa-times"></i>
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
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Belum Verifikasi</span>
                                                <h4 class="mb-3 text-warning"><?= $statistics['belum_verifikasi'] ?></h4>
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
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <a href="<?= site_url('calon_siswa') ?>" class="btn btn-secondary btn-sm waves-effect waves-light">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                            <div class="col-sm-6 text-end">
                                <button type="button" class="btn btn-success btn-sm waves-effect waves-light" onclick="exportToExcel()">
                                    <i class="fas fa-download"></i> Unduh Excel
                                </button>
                                <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" onclick="printJurnal()">
                                    <i class="fas fa-print"></i> Print
                                </button>
                            </div>
                        </div> <!-- Table -->
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Informasi:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Data telah diurutkan berdasarkan peringkat dari nilai akumulatif tertinggi ke terendah.</li>
                                <li>Peringkat 1 = nilai akumulatif tertinggi.</li>
                                <li><strong>Perhitungan Usia:</strong> Usia dihitung per 1 Juli 2025 dalam format tahun.bulan (contoh: 6 tahun 9 bulan = 6.9).</li>
                                <li><strong>Skor Domisili (Berdasarkan alamat SDN Krengseng 02: Desa Krengseng, Kecamatan Gringsing, Kabupaten Batang):</strong> Desa/Kelurahan Krengseng (4), Kec. Gringsing (3), Kab. Batang (2), Luar Kabupaten Batang (1).</li>
                                <li><strong>Nilai Akumulatif:</strong> Usia (tahun.bulan) + Skor Domisili (1-4) = Total Nilai Akumulatif. Contoh: 6.9 + 4 = 10.9.</li>
                            </ul>
                        </div>
                        <div class="table-responsive">
                            <table id="jurnal-spmb-table" class="table table-bordered dt-responsive nowrap w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th class="align-middle text-center">No.</th>
                                        <th class="align-middle text-center">Nama Peserta Didik</th>
                                        <th class="align-middle text-center">Nomor Pendaftaran</th>
                                        <th class="align-middle text-center">L/P</th>
                                        <th class="align-middle text-center">Tempat Lahir</th>
                                        <th class="align-middle text-center">Tanggal Lahir</th>
                                        <th class="align-middle text-center">Usia per 1 Juli 2025<br><small class="text-muted">(Tahun, Bulan, Hari untuk skor)</small></th>
                                        <th class="align-middle text-center">Alamat Domisili</th>
                                        <th class="align-middle text-center">Lulusan</th>
                                        <th class="align-middle text-center">Jalur Pendaftaran</th>
                                        <th class="align-middle text-center">Usia<br><small class="text-muted">(Tahun.Bulan)</small></th>
                                        <th class="align-middle text-center">Skor domisili</th>
                                        <th class="align-middle text-center">Nilai Akumulatif</th>
                                        <th class="align-middle text-center">Peringkat<br><small class="text-muted">(Berdasarkan Nilai Akumulatif)</small></th>
                                        <th class="align-middle text-center">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($calon_siswa as $key => $value) : ?>
                                        <tr>
                                            <td class="align-middle text-center"><?= $key + 1 ?></td>
                                            <td class="align-middle"><?= isset($value->nama_peserta) ? ucwords(strtolower($value->nama_peserta)) : '-' ?></td>
                                            <td class="align-middle text-center"><?= $value->no_pendaftaran ?? '-' ?></td>
                                            <td class="align-middle text-center">
                                                <?php
                                                $jk = strtolower(trim($value->jenis_kelamin ?? ''));
                                                echo ($jk === 'laki-laki' || $jk === 'l') ? 'L' : (($jk === 'perempuan' || $jk === 'p') ? 'P' : '-');
                                                ?>
                                            </td>
                                            <td class="align-middle"><?= $value->tempat_lahir ?? '-' ?></td>
                                            <td class="align-middle text-center">
                                                <?php
                                                if (!empty($value->tanggal_lahir)) {
                                                    $date = DateTime::createFromFormat('Y-m-d', $value->tanggal_lahir);
                                                    echo $date ? $date->format('d/m/Y') : $value->tanggal_lahir;
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php
                                                if (!empty($value->tanggal_lahir) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value->tanggal_lahir)) {
                                                    $lahir = new DateTime($value->tanggal_lahir);
                                                    $referensi = new DateTime('2025-07-01'); // 1 Juli 2025
                                                    $diff = $referensi->diff($lahir);
                                                    // Display actual age with days included
                                                    echo $diff->y . ' Tahun ' . $diff->m . ' Bulan ' . $diff->d . ' Hari';
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </td>
                                            <td class="align-middle"><?= $value->alamat ?? '-' ?></td>
                                            <td class="align-middle"><?= $value->sekolah_asal ?? '-' ?></td>
                                            <td class="align-middle text-center">
                                                <?php
                                                $jalur = strtolower(trim($value->jalur ?? ''));
                                                if ($jalur === 'zonasi') {
                                                    echo 'Domisili (domisili1)';
                                                } elseif ($jalur === 'afirmasi') {
                                                    echo 'Afirmasi';
                                                } elseif ($jalur === 'prestasi') {
                                                    echo 'Prestasi';
                                                } elseif ($jalur === 'mutasi') {
                                                    echo 'Mutasi';
                                                } else {
                                                    echo '-';
                                                }
                                                ?> </td>
                                            <td class="align-middle text-center">
                                                <?php
                                                // Display actual age (years and months) without calculation
                                                if (!empty($value->tanggal_lahir) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value->tanggal_lahir)) {
                                                    $lahir = new DateTime($value->tanggal_lahir);
                                                    $referensi = new DateTime('2025-07-01'); // 1 Juli 2025
                                                    $diff = $referensi->diff($lahir);

                                                    // Get actual years and months
                                                    $tahun = $diff->y;
                                                    $bulan = $diff->m;

                                                    // Display as tahun.bulan format (e.g., 6.9, 7.2, 5.11)
                                                    echo $tahun . '.' . $bulan;
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php                                                // Use the calculated domicile score from controller
                                                echo $value->skor_domisili_calculated;
                                                ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php
                                                // Use the calculated cumulative score from controller
                                                echo number_format($value->nilai_akumulatif_calculated ?? 0, 1);
                                                ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?= $value->peringkat_calculated ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php
                                                $status = strtolower(trim($value->status_hasil ?? ''));
                                                echo ($status === 'lulus') ? 'Diterima' : 'Tidak Diterima';
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {

        /* Hide all elements first */
        body * {
            visibility: hidden !important;
        }

        /* Show only the page content */
        .page-content,
        .page-content * {
            visibility: visible !important;
        }

        /* Reset page positioning */
        .page-content {
            position: absolute;
            left: 0;
            top: 0;
            width: 100% !important;
            background: #fff !important;
            color: #000 !important;
            margin: 0 !important;
            padding: 10px !important;
            overflow: hidden !important;
        }

        .container-fluid {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            overflow: hidden !important;
        }

        .table-responsive {
            overflow: visible !important;
        }

        /* Hide unnecessary elements */
        .btn,
        .alert,
        .dataTables_length,
        .dataTables_filter,
        .dataTables_info,
        .dataTables_paginate,
        .dt-buttons,
        .breadcrumb,
        .page-title-box,
        .row.mb-3,
        .row.mb-4 {
            display: none !important;
        }

        /* Table styling for print on F4 */
        #jurnal-spmb-table {
            width: 100% !important;
            font-size: 9px !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
        }

        #jurnal-spmb-table th,
        #jurnal-spmb-table td {
            border: 1px solid #333 !important;
            padding: 3px 4px !important;
            color: #000 !important;
            background: #fff !important;
            font-size: 9px !important;
            word-wrap: break-word !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        #jurnal-spmb-table th {
            background: #f8f9fa !important;
            font-weight: bold !important;
            font-size: 8px !important;
        }

        /* Specific column widths optimized for F4 */
        #jurnal-spmb-table th:nth-child(1),
        #jurnal-spmb-table td:nth-child(1) {
            width: 3% !important;
        }

        /* No */
        #jurnal-spmb-table th:nth-child(2),
        #jurnal-spmb-table td:nth-child(2) {
            width: 15% !important;
        }

        /* Nama */
        #jurnal-spmb-table th:nth-child(3),
        #jurnal-spmb-table td:nth-child(3) {
            width: 8% !important;
        }

        /* No Pendaftaran */
        #jurnal-spmb-table th:nth-child(4),
        #jurnal-spmb-table td:nth-child(4) {
            width: 3% !important;
        }

        /* L/P */
        #jurnal-spmb-table th:nth-child(5),
        #jurnal-spmb-table td:nth-child(5) {
            width: 10% !important;
        }

        /* Tempat Lahir */
        #jurnal-spmb-table th:nth-child(6),
        #jurnal-spmb-table td:nth-child(6) {
            width: 7% !important;
        }

        /* Tanggal Lahir */
        #jurnal-spmb-table th:nth-child(7),
        #jurnal-spmb-table td:nth-child(7) {
            width: 12% !important;
        }

        /* Usia Lengkap */
        #jurnal-spmb-table th:nth-child(8),
        #jurnal-spmb-table td:nth-child(8) {
            width: 14% !important;
        }

        /* Alamat */
        #jurnal-spmb-table th:nth-child(9),
        #jurnal-spmb-table td:nth-child(9) {
            width: 10% !important;
        }

        /* Lulusan */
        #jurnal-spmb-table th:nth-child(10),
        #jurnal-spmb-table td:nth-child(10) {
            width: 8% !important;
        }

        /* Jalur */
        #jurnal-spmb-table th:nth-child(11),
        #jurnal-spmb-table td:nth-child(11) {
            width: 5% !important;
        }

        /* Usia (Tahun.Bulan) */
        #jurnal-spmb-table th:nth-child(12),
        #jurnal-spmb-table td:nth-child(12) {
            width: 5% !important;
        }

        /* Skor Domisili */
        #jurnal-spmb-table th:nth-child(13),
        #jurnal-spmb-table td:nth-child(13) {
            width: 5% !important;
        }

        /* Nilai Akumulatif */
        #jurnal-spmb-table th:nth-child(14),
        #jurnal-spmb-table td:nth-child(14) {
            width: 5% !important;
        }

        /* Peringkat */
        #jurnal-spmb-table th:nth-child(15),
        #jurnal-spmb-table td:nth-child(15) {
            width: 5% !important;
        }

        /* Keterangan */

        /* Remove card styling */
        .card,
        .card-body {
            box-shadow: none !important;
            border: none !important;
            background: #fff !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Add print title */
        .page-content::before {
            content: "JURNAL SPMB - SDN KRENGSENG 02 TAHUN AJARAN 2025/2026";
            display: block;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #000 !important;
        }

        /* Page break settings */
        @page {
            size: 330mm 210mm;
            /* F4 landscape: width x height in mm */
            margin: 8mm;
        }
    }
</style>

<script>
    $(document).ready(function() {
        $('#jurnal-spmb-table').DataTable({
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
            "dom": 'Bfrtip',
            "buttons": [{
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    className: 'btn btn-success btn-sm',
                    title: 'Jurnal SPMB',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    className: 'btn btn-danger btn-sm',
                    title: 'Jurnal SPMB',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Print',
                    className: 'btn btn-primary btn-sm',
                    title: 'Jurnal SPMB',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ]
        });
    });

    function exportToExcel() {
        $('#jurnal-spmb-table').DataTable().button('.buttons-excel').trigger();
    }

    function printJurnal() {
        // Hide elements that shouldn't be printed
        $('.btn, .alert, .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate, .dt-buttons, .breadcrumb, .page-title-box, .row.mb-3, .row.mb-4').hide();

        // Add print instruction
        if (confirm('Pastikan printer Anda diatur ke:\n- Kertas: F4 (Legal)\n- Orientasi: Landscape (Mendatar)\n- Margin: Minimal\n\nLanjutkan print?')) {
            // Print the page
            window.print();
        }

        // Show elements back after printing
        setTimeout(function() {
            $('.btn, .alert, .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate, .dt-buttons, .breadcrumb, .page-title-box, .row.mb-3, .row.mb-4').show();
        }, 1000);
    }
</script>

<?= $this->endSection() ?>