<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Bukti Pendaftaran - <?= $calon_siswa->nama_peserta ?? '-' ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #222;
        }

        .header {
            width: 100%;
            margin-bottom: 10px;
        }

        .header td {
            vertical-align: top;
        }

        .logo {
            width: 70px;
        }

        .logo-kanan {
            width: 85px;
        }

        .judul {
            text-align: center;
        }

        .judul h2 {
            margin: 0;
            font-size: 18px;
        }

        .judul h3 {
            margin: 0;
            font-size: 16px;
        }

        .judul p {
            margin: 2px 0;
            font-size: 12px;
        }

        .section-title {
            background: #f2f2f2;
            font-weight: bold;
            padding: 6px 8px;
            border-radius: 4px;
            margin-top: 18px;
            margin-bottom: 6px;
        }

        .biodata,
        .persyaratan,
        .khusus {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .biodata td,
        .persyaratan td,
        .khusus td {
            padding: 4px 6px;
            font-size: 13px;
        }

        .biodata tr td:first-child {
            width: 22%;
            color: #444;
        }

        .biodata tr td:nth-child(2) {
            width: 2%;
        }

        .biodata tr td:nth-child(3) {
            width: 30%;
        }

        .biodata tr td {
            vertical-align: top;
        }

        .qr-col {
            width: 140px;
            text-align: center;
            vertical-align: top;
        }

        .catatan {
            font-size: 11px;
            color: #b00;
            margin-top: 10px;
        }

        .footer {
            font-size: 11px;
            color: #555;
            margin-top: 18px;
        }

        .ttd {
            text-align: right;
            margin-top: 30px;
        }

        .ttd .nama {
            margin-top: 60px;
            text-decoration: underline;
        }

        .ttd .nip {
            margin-top: 2px;
        }

        .persyaratan th,
        .khusus th {
            text-align: left;
            font-size: 13px;
            background: #f9f9f9;
        }

        .persyaratan td,
        .khusus td {
            font-size: 13px;
        }

        .qr-caption {
            font-size: 10px;
            color: #333;
            margin-top: 2px;
        }

        .note {
            color: #b00;
            font-size: 11px;
            margin-top: 10px;
        }

        .url {
            color: rgb(127, 187, 239);
            font-size: 11px;
        }
    </style>
</head>

<body>
    <table class="header" style="margin-bottom:15px;">
        <tr>
            <td class="logo" style="width:70px;vertical-align:middle;text-align:center;">
                <img src="backend/logo_pemkab.png" width="60">
            </td>
            <!-- <td class="logo" style="width:70px;vertical-align:middle;text-align:center;">
                <img src="backend/logo_sekolah.png" width="70">
            </td> -->
            <td style="vertical-align:middle;text-align:right;">
                <div style="display:inline-block;">
                    <h2 style="color:#222;margin-bottom:2px;margin-top:0;font-size:16px;text-align:center;">BUKTI PENDAFTARAN</h2>
                    <h3 style="color:#222;margin:0 0 6px 0;font-size:16px;font-weight:bold;text-align:center;">SPMB SD NEGERI KRENGSENG 02</h3>
                    <p style="color:#222;margin:0 0 6px 0;font-size:13px;text-align:center;">Seleksi Penerimaan Murid Baru Tahun Pelajaran <?= htmlspecialchars($calon_siswa->tahun_pelajaran_penerimaan ?? '-') ?></p>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">Biodata Calon Peserta Didik</div>
    <table class="biodata">
        <tr>
            <td class="label">No Pendaftaran</td>
            <td class="sep">:</td>
            <td class="value" colspan="2"><?= strtoupper($calon_siswa->no_pendaftaran ?? '-') ?></td>
            <td class="label">Jalur Pendaftaran</td>
            <td class="sep">:</td>
            <td class="value"><?= strtoupper($calon_siswa->jalur ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label">NIK</td>
            <td class="sep">:</td>
            <td class="value" colspan="2"><?= strtoupper($calon_siswa->nik ?? '-') ?></td>
            <td class="label">Pilihan 1</td>
            <td class="sep">:</td>
            <td class="value"><?= strtoupper($calon_siswa->pilihan_1 ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label">NISN</td>
            <td class="sep">:</td>
            <td class="value" colspan="2"><?= strtoupper($calon_siswa->nisn ?? '-') ?></td>
            <td class="label">Pilihan 2</td>
            <td class="sep">:</td>
            <td class="value"><?= strtoupper($calon_siswa->pilihan_2 ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="sep">:</td>
            <td class="value" colspan="2"><?= strtoupper($calon_siswa->nama_peserta ?? '-') ?></td>
            <td class="label">Score</td>
            <td class="sep">:</td>
            <td class="value">
                <?php
                // Calculate accumulative score (age + domicile score) same as in journal
                if (!empty($calon_siswa->tanggal_lahir) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $calon_siswa->tanggal_lahir)) {
                    $lahir = new DateTime($calon_siswa->tanggal_lahir);
                    $referensi = new DateTime('2025-07-01'); // 1 Juli 2025
                    $diff = $referensi->diff($lahir);

                    // Get actual years and months for raw age
                    $tahun = $diff->y;
                    $bulan = $diff->m;

                    // Convert to decimal format (same as in journal)
                    $usia_decimal = $tahun + ($bulan / 10);

                    // Calculate domicile score
                    $sekolah_desa = 'krengseng';
                    $sekolah_kecamatan = 'gringsing';
                    $sekolah_kabupaten = 'batang';

                    $skor_domisili = 1; // Default score for different regency
                    $alamat_siswa = strtolower(trim($calon_siswa->alamat ?? ''));
                    $desa_siswa = strtolower(trim($calon_siswa->desa ?? ''));
                    $kelurahan_siswa = strtolower(trim($calon_siswa->kelurahan ?? ''));
                    $kecamatan_siswa = strtolower(trim($calon_siswa->kecamatan ?? ''));
                    $kabupaten_siswa = strtolower(trim($calon_siswa->kabupaten ?? ''));

                    // Check desa or kelurahan for score 4
                    if ((!empty($desa_siswa) && strpos($desa_siswa, $sekolah_desa) !== false) ||
                        (!empty($kelurahan_siswa) && strpos($kelurahan_siswa, $sekolah_desa) !== false)
                    ) {
                        $skor_domisili = 4;
                    } elseif (!empty($kecamatan_siswa) && strpos($kecamatan_siswa, $sekolah_kecamatan) !== false) {
                        $skor_domisili = 3;
                    } elseif (!empty($kabupaten_siswa) && strpos($kabupaten_siswa, $sekolah_kabupaten) !== false) {
                        $skor_domisili = 2;
                    } else {
                        $skor_domisili = 1;
                    }

                    // Fallback: check from full address if specific fields are empty
                    if (empty($desa_siswa) && empty($kelurahan_siswa) && empty($kecamatan_siswa) && empty($kabupaten_siswa) && !empty($alamat_siswa)) {
                        if (strpos($alamat_siswa, $sekolah_desa) !== false) {
                            $skor_domisili = 4;
                        } elseif (strpos($alamat_siswa, $sekolah_kecamatan) !== false) {
                            $skor_domisili = 3;
                        } elseif (strpos($alamat_siswa, $sekolah_kabupaten) !== false) {
                            $skor_domisili = 2;
                        }
                    }

                    // Calculate cumulative score using raw age + domicile score
                    $nilai_akumulatif = $usia_decimal + $skor_domisili;
                    echo number_format($nilai_akumulatif, 1);
                } else {
                    echo '-';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td class="label">Jenis Kelamin</td>
            <td class="sep">:</td>
            <td class="value" colspan="2">
                <?php
                $jk = $calon_siswa->jenis_kelamin ?? '-';
                if ($jk === 'L') {
                    echo 'Laki - laki';
                } elseif ($jk === 'P') {
                    echo 'Perempuan';
                } else {
                    echo $jk;
                }
                ?>
            </td>
            <td class="label">Didaftarkan oleh</td>
            <td class="sep">:</td>
            <td class="value"><?= strtoupper($calon_siswa->nama_ibu ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label">Asal Sekolah</td>
            <td class="sep">:</td>
            <td class="value" colspan="2"><?= strtoupper($calon_siswa->sekolah_asal ?? '-') ?></td>
            <td class="label">Advisor</td>
            <td class="sep">:</td>
            <td class="value"><?= strtoupper($calon_siswa->advisor ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label">TTL</td>
            <td class="sep">:</td>
            <td class="value" colspan="2">
                <?php
                $tempat_lahir = $calon_siswa->tempat_lahir ?? '-';
                $tanggal_lahir = '-';

                // Format tanggal lahir ke format Indonesia (25 Mei 1999)
                if (!empty($calon_siswa->tanggal_lahir)) {
                    $lahir = new DateTime($calon_siswa->tanggal_lahir);
                    $bulan_indonesia = [
                        1 => 'Januari',
                        2 => 'Februari',
                        3 => 'Maret',
                        4 => 'April',
                        5 => 'Mei',
                        6 => 'Juni',
                        7 => 'Juli',
                        8 => 'Agustus',
                        9 => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember'
                    ];
                    $tanggal_lahir = $lahir->format('j') . ' ' . $bulan_indonesia[(int)$lahir->format('n')] . ' ' . $lahir->format('Y');
                }

                $ttl = $tempat_lahir . ', ' . $tanggal_lahir;
                echo strtoupper($ttl);

                if (!empty($calon_siswa->tanggal_lahir)) {
                    $lahir = new DateTime($calon_siswa->tanggal_lahir);
                    $today = new DateTime();
                    $diff = $today->diff($lahir);
                    $usia_tahun = $diff->y;
                    $usia_bulan = $diff->m;
                    echo "<span style='margin-left:8px;'> ({$usia_tahun} Tahun {$usia_bulan} Bulan)</span>";
                }
                ?>
            </td>
            <td class="label">Tanggal<br>Pendaftaran</td>
            <td class="sep">:</td>
            <td class="value" style="white-space:nowrap;"><?= strtoupper($calon_siswa->tanggal_pendaftaran ?? date('d M Y, H:i')) ?></td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="sep">:</td>
            <td class="value" colspan="6"><?= strtoupper($calon_siswa->alamat ?? '-') ?></td>
        </tr>
    </table>

    <div class="section-title">Persyaratan Umum</div>
    <table class="persyaratan">
        <tr>
            <td>Status Kelulusan Sekolah Asal</td>
            <td>:</td>
            <td><?= !empty($calon_siswa->sekolah_asal) ? 'LULUS' : 'TIDAK LULUS' ?></td>
        </tr>
        <tr>
            <td>Nomor KK</td>
            <td>:</td>
            <td><?= $calon_siswa->nomor_kk ?? '-' ?></td>
        </tr>
        <tr>
            <td>Ijazah/Surat Keterangan Lulus/Kartu Peserta Ujian Sekolah</td>
            <td>:</td>
            <td><?= $calon_siswa->ijazah ?? 'Ada' ?></td>
        </tr>
        <tr>
            <td>Akta Kelahiran / KIA</td>
            <td>:</td>
            <td><?= $calon_siswa->akta_kelahiran ?? 'Ada' ?></td>
        </tr>
        <tr>
            <td>Kartu Keluarga</td>
            <td>:</td>
            <td><?= $calon_siswa->kartu_keluarga ?? 'Ada' ?></td>
        </tr>
        <tr>
            <td>KTP Orang Tua</td>
            <td>:</td>
            <td><?= $calon_siswa->ktp_ortu ?? 'Ada' ?></td>
        </tr>
    </table>

    <div class="section-title">Persyaratan Khusus</div>
    <table class="khusus">
        <tr>
            <td>-</td>
        </tr>
    </table>

    <table style="width:100%; margin-top:18px;">
        <tr>
            <td class="qr-col">
                <?php

                use Endroid\QrCode\QrCode;
                use Endroid\QrCode\Writer\PngWriter;
                use Endroid\QrCode\Encoding\Encoding;
                use Endroid\QrCode\ErrorCorrectionLevel;

                $qrCode = QrCode::create('No: ' . ($calon_siswa->no_pendaftaran ?? '-') . ' | Nama: ' . ($calon_siswa->nama_peserta ?? '-') . ' | NISN: ' . ($calon_siswa->nisn ?? '-'))
                    ->setEncoding(new Encoding('UTF-8'))
                    ->setErrorCorrectionLevel(ErrorCorrectionLevel::High)
                    ->setSize(110)
                    ->setMargin(3);
                $writer = new PngWriter();
                $result = $writer->write($qrCode);
                $dataUri = $result->getDataUri();
                echo '<img src="' . $dataUri . '">';
                ?>
            </td>
            <td>
                <div class="footer">
                    <b>* Tanggal Cetak <span style="color:rgb(127, 187, 239);"><?= date('d M Y, H:i') ?></span></b><br>
                    <b>* Untuk mendapatkan informasi lebih lanjut, silahkan follow instagram <span class="url">@sdnkrengseng02</span></b><br>
                    <b>* Atau kunjungi website resmi SPMB SDN Krengseng 02 <span class="url">https://spmb.sdnkrengseng02.sch.id</span></b><br>
                    <span class="note"><b>* Harap untuk tidak menyebarkan bukti pendaftaran serta qr code ini ke pihak selain pendaftar dan sekolah tujuan</b></span>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>