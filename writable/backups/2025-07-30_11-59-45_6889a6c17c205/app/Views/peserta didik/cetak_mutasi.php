<?php // Jangan tampilkan output apapun sebelum HTML 
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Pindah/Keluar</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 15px;
        }

        .kop {
            text-align: center;
            margin-bottom: 10px;
        }

        .kop img {
            float: left;
            width: 70px;
            margin-right: 10px;
        }

        .kop h2,
        .kop h3,
        .kop p {
            margin: 0;
        }

        .garis {
            border-bottom: 2px solid #000;
            margin: 10px 0 20px 0;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .isi {
            margin-left: 30px;
        }

        table.data {
            width: 100%;
            margin-bottom: 10px;
            font-size: 15px;
        }

        table.data td {
            padding: 2px 5px;
            vertical-align: top;
            font-size: 15px;
        }

        .ttd {
            width: 300px;
            float: right;
            text-align: left;
            margin-top: 30px;
        }

        .catatan {
            font-size: 12px;
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <div class="kop" style="margin-bottom:0;">
        <table style="width:100%; border-collapse:collapse;">
            <tr>
                <td style="width:110px; text-align:center; vertical-align:top;">
                    <img src="<?= FCPATH . 'backend/logo_pemkab.png' ?>" alt="Logo Batang" style="width:75px; margin-top:2px;">
                </td>
                <td style="text-align:center; vertical-align:top;">
                    <div style="font-size:18px; font-weight:normal; letter-spacing:1px;">PEMERINTAH KABUPATEN BATANG</div>
                    <div style="font-size:20px; font-weight:bold; letter-spacing:1px;">SD NEGERI KRENGSENG 02 GRINGSING</div>
                    <div style="font-size:13px; margin-top:2px;">Jalan Dukuh Gendogosari RT05/RW05 Gringsing Batang 51281,<br>Telepon (0285)392398 Laman https://sdnkrengseng02.sch.id,<br>sdnkrengseng02@gmail.com</div>
                </td>
                <td style="width:110px; text-align:center; vertical-align:top; position:relative;">
                    <img src="<?= FCPATH . 'backend/logo_sekolah.png' ?>" alt="Logo Batang" style="width:93px; margin-top:2px;">
                </td>
            </tr>
        </table>
        <div style="border-bottom:3px solid #000; margin:8px 0 2px 0; position:relative; height:0;"></div>
        <div style="border-bottom:1.5px solid #000; margin-bottom:10px; position:relative; height:0;"></div>
    </div>
    <!-- NSS Box Bawah Garis -->
    <div style="width:100%; margin: 12px 0 8px 0;">
        <table style="border-collapse:collapse; display:inline-table; margin-left:auto;">
            <tr>
                <td style="vertical-align:middle;font-size:13px; padding-right:6px;">NSS :</td>
                <?php
                $nss = isset($nss) ? $nss : '101032507009';
                $nssArr = str_split($nss);
                foreach ($nssArr as $digit) {
                    echo '<td style="border:1px solid #000; width:18px; height:18px; text-align:center; font-size:13px;">' . htmlspecialchars($digit) . '</td>';
                }
                ?>
            </tr>
        </table>
    </div>
    <div class="judul" style="text-align:center; font-size:14px; padding:2px; margin-bottom:8px; width:99%;">
        SURAT KETERANGAN PINDAH/KELUAR<br>
        <?php
        // Format bulan romawi dan tahun sekarang
        $bulanRomawiArr = [
            '01' => 'I',
            '02' => 'II',
            '03' => 'III',
            '04' => 'IV',
            '05' => 'V',
            '06' => 'VI',
            '07' => 'VII',
            '08' => 'VIII',
            '09' => 'IX',
            '10' => 'X',
            '11' => 'XI',
            '12' => 'XII'
        ];
        $bulanRomawi = $bulanRomawiArr[date('m')];
        $tahunSekarang = date('Y');
        ?>
        <span style="font-weight:normal;">Nomor : S /&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ 400.3.12.1 / <?= $bulanRomawi; ?> / <?= $tahunSekarang; ?></span>
    </div>
    <table style="width:100%; margin-bottom:10px;">
    </table>
    <p style="font-size: 13px">Yang bertandatangan dibawah ini, Kepala Sekolah Dasar Negeri Krengseng 02, Kecamatan Gringsing Kabupaten Batang provinsi Jawa Tengah, menerangkan bahwa :</p>
    <div class="isi">
        <table class="data">
            <tr>
                <td style="width:180px;">Nama</td>
                <td style="width:10px; font-weight:bold">:</td>
                <td><b><?= isset($mutasi->nama_siswa) ? htmlspecialchars($mutasi->nama_siswa) : '-' ?></b></td>
            </tr>
            <tr>
                <td>Tempat/Tanggal Lahir</td>
                <td>:</td>
                <td>
                    <?= isset($mutasi->tempat_lahir) ? htmlspecialchars($mutasi->tempat_lahir) : '-' ?>
                    <?php
                    if (isset($mutasi->tanggal_lahir)) {
                        $bulanIndo = [
                            '01' => 'Januari',
                            '02' => 'Februari',
                            '03' => 'Maret',
                            '04' => 'April',
                            '05' => 'Mei',
                            '06' => 'Juni',
                            '07' => 'Juli',
                            '08' => 'Agustus',
                            '09' => 'September',
                            '10' => 'Oktober',
                            '11' => 'November',
                            '12' => 'Desember'
                        ];
                        $tgl = date('d', strtotime($mutasi->tanggal_lahir));
                        $bln = date('m', strtotime($mutasi->tanggal_lahir));
                        $thn = date('Y', strtotime($mutasi->tanggal_lahir));
                        echo ', ' . $tgl . ' ' . $bulanIndo[$bln] . ' ' . $thn;
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>NISN</td>
                <td>:</td>
                <td><?= isset($mutasi->nisn) ? htmlspecialchars($mutasi->nisn) : '-' ?></td>
            </tr>
            <tr>
                <td>Tahun Akademik</td>
                <td>:</td>
                <td>
                    <?php
                    // Tampilkan tahun pelajaran dari tanggal mutasi, misal 2024/2025 jika mutasi di 2025
                    if (isset($mutasi->tanggal_mutasi)) {
                        $tahun = date('Y', strtotime($mutasi->tanggal_mutasi));
                        $bulan = date('m', strtotime($mutasi->tanggal_mutasi));
                        // Tahun ajaran biasanya mulai Juli, jika bulan >= 7 maka tahun ajaran berjalan
                        if ((int)$bulan >= 7) {
                            $tahun_ajaran = $tahun . '/' . ($tahun + 1);
                        } else {
                            $tahun_ajaran = ($tahun - 1) . '/' . $tahun;
                        }
                        echo $tahun_ajaran;
                    } else {
                        echo '-';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Nama Orang Tua</td>
                <td>:</td>
                <td>
                    Ayah : <?= isset($mutasi->nama_ayah) ? htmlspecialchars($mutasi->nama_ayah) : '-' ?><br>
                    Ibu : <?= isset($mutasi->nama_ibu) ? htmlspecialchars($mutasi->nama_ibu) : '-' ?>
                </td>
            </tr>
            <tr>
                <td>Pekerjaan Orang Tua</td>
                <td>:</td>
                <td>
                    Ayah : <?= isset($mutasi->pekerjaan_ayah) ? htmlspecialchars($mutasi->pekerjaan_ayah) : '-' ?><br>
                    Ibu : <?= isset($mutasi->pekerjaan_ibu) ? htmlspecialchars($mutasi->pekerjaan_ibu) : '-' ?>
                </td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= isset($mutasi->alamat) ? htmlspecialchars($mutasi->alamat) : '-' ?></td>
            </tr>
            <tr>
                <td>Nomor Ijazah/STTB</td>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <td>Tanggal Pindah</td>
                <td>:</td>
                <td>
                    <?php
                    if (isset($mutasi->tanggal_mutasi)) {
                        $bulanIndo = [
                            '01' => 'Januari',
                            '02' => 'Februari',
                            '03' => 'Maret',
                            '04' => 'April',
                            '05' => 'Mei',
                            '06' => 'Juni',
                            '07' => 'Juli',
                            '08' => 'Agustus',
                            '09' => 'September',
                            '10' => 'Oktober',
                            '11' => 'November',
                            '12' => 'Desember'
                        ];
                        $tgl = date('d', strtotime($mutasi->tanggal_mutasi));
                        $bln = date('m', strtotime($mutasi->tanggal_mutasi));
                        $thn = date('Y', strtotime($mutasi->tanggal_mutasi));
                        echo $tgl . ' ' . $bulanIndo[$bln] . ' ' . $thn;
                    } else {
                        echo '-';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Alasan Pindah</td>
                <td>:</td>
                <td><?= isset($mutasi->alasan_mutasi) ? htmlspecialchars($mutasi->alasan_mutasi) : '-' ?></td>
            </tr>
            <tr>
                <td>Catatan</td>
                <td>:</td>
                <td>-</td>
            </tr>
        </table>
    </div>
    <p>Telah mengajukan pindah sekolah ke, <?= isset($mutasi->tujuan_mutasi) && $mutasi->tujuan_mutasi ? htmlspecialchars($mutasi->tujuan_mutasi) : '........................................' ?> dengan alasan <?= isset($mutasi->alasan_mutasi) ? htmlspecialchars($mutasi->alasan_mutasi) : '' ?><br>Bersama ini kami sertakan Rapor (asli) yang bersangkutan.</p>
    <br>
    <p>Demikian surat keterangan ini dibuat, untuk diketahui dan dipergunakan sebagaimana mestinya.</p>
    <div class="ttd">
        <?php
        // Tanggal hari ini format Indonesia
        $bulanIndo = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];
        $tgl_hari_ini = date('d');
        $bln_hari_ini = date('m');
        $thn_hari_ini = date('Y');
        $tanggal_cetak = $tgl_hari_ini . ' ' . $bulanIndo[$bln_hari_ini] . ' ' . $thn_hari_ini;
        ?>
        Krengseng, <?= $tanggal_cetak ?><br>
        Kepala Sekolah<br><br><br><br>
        <?php
        // Ambil kepala sekolah aktif
        $db = db_connect();
        $kepala = $db->table('db_kepalasekolah')->where('aktivasi', 'Sedang Aktif')->orderBy('id_kepalasekolah', 'DESC')->get()->getRow();
        $nama_kepala = isset($kepala->nama) ? $kepala->nama : '(.................................)';
        $nip_kepala = isset($kepala->nip) ? $kepala->nip : '............................';
        ?>
        <span style="display:inline-block; min-width:220px; border-bottom:2px solid #000; text-align:center; font-weight:bold;">&nbsp;<?= htmlspecialchars($nama_kepala) ?>&nbsp;</span><br>
        NIP : <?= htmlspecialchars($nip_kepala) ?>
    </div>
    <div style="clear:both;"></div>
    <div class="catatan">
        <!-- Barcode/QR Code Section -->
        <div style="margin:20px 0 10px 0;">
            <?php
            // Pastikan Endroid\QrCode sudah terinstall dan autoloaded
            if (class_exists('Endroid\\QrCode\\QrCode')) {
                $qrText = 'NISN: ' . ($mutasi->nisn ?? '-') . ' | Nama: ' . ($mutasi->nama_siswa ?? '-') . ' | TTL: ' . ($mutasi->tempat_lahir ?? '-') . ', ' . ($mutasi->tanggal_lahir ?? '-');
                $qrCode = \Endroid\QrCode\QrCode::create($qrText)
                    ->setEncoding(new \Endroid\QrCode\Encoding\Encoding('UTF-8'))
                    ->setErrorCorrectionLevel(\Endroid\QrCode\ErrorCorrectionLevel::High)
                    ->setSize(110)
                    ->setMargin(3);
                $writer = new \Endroid\QrCode\Writer\PngWriter();
                $result = $writer->write($qrCode);
                $dataUri = $result->getDataUri();
                echo '<img src="' . $dataUri . '" alt="QR Code">';
            } else {
                echo '<small>QR Code library not installed.</small>';
            }
            ?>
        </div>
        <b>Catatan :</b><br>
        Dengan mencetak surat keterangan pindah/keluar ini maka peserta didik dinyatakan telah pindah/mutasi dari <br>SD Negeri Krengseng 02.
    </div>
</body>

</html>
</body>

</html>