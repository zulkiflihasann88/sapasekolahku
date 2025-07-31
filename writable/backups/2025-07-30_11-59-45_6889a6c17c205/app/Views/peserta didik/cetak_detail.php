<?php

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, intial-scale=1,0">
    <title> Cetak <?= $siswa->nama_siswa ?>_<?= $siswa->nisn ?> </title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        /* tr td {
            border: 1px solid black;
        } */


        .kop td {
            border-bottom: 3px solid black;
            padding: 8px;
            text-align: center;
        }

        .tengah {
            text-align: center;
        }

        .container {
            width: 100%;
            position: relative;
            padding-top: 10px;
            padding-bottom: 1px;
        }

        .title {
            font-style: italic;
            font-weight: normal;
            font-size: 12px;
            background: white;
            display: inline-block;
            position: absolute;
            top: -5px;
            left: 0;
            padding: 0 5px;
            border-bottom: 1px dashed black;
        }

        .line {
            border-top: 1px dashed black;
            /* Garis putus-putus */
            line-height: 1px;
            margin-top: 5px;
        }

        .left {
            width: 65%;
            float: left;
            margin-bottom: 3px;
        }

        .right {
            width: 35%;
            float: right;
            text-align: left;
            margin-bottom: 3px;
        }

        .verifikator {
            font-weight: bold;
            margin-bottom: 2px;
        }

        .left p,
        ol,
        li {
            margin: 3px 9px;
            padding: 0;
            font-size: 12px;
        }

        .right p,
        ol,
        li {
            margin: 3px 9px;
            padding: 0;
            font-size: 12px;
        }

        .title p,
        ol,
        li {
            margin: 3px 3px;
            padding: 0;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="kopsurat">
        <table class="kop">
            <tr>
                <td> <img src="backend/logo_pemkab.png" width="80px"> </td>
                <td class="tengah">
                    <p style="font-size: 18px;">PEMERINTAH KABUPATEN BATANG</p>
                    <h3 style="font-size: 18px;">SD NEGERI KRENGSENG 02 GRINGSING</h3>
                    <p style="font-size: 12px;">Jalan Dukuh Gendogosari RT05/RW05 Gringsing Batang 51281,</p>
                    <p style="font-size: 12px;">Telepon (0285)392398 Laman https://sdnkrengseng02.sch.id,</p>
                    <p style="font-size: 12px;">sdnkrengseng02@gmail.com</p>
                </td>
                <td> <img src="backend/logo_sekolah.png" width="85px"> </td>
            </tr>
        </table>
        <h1 style=" font-size:14px; text-align:center;">FORMULIR DATA SISWA</h1>
        <table class="identitas">
            <tr>
                <th style="padding-bottom: 10px; font-size:14px; text-align:left;">I. IDENTITAS DIRI</th>
            </tr>
            <tr>
                <td style="width: 25%;">Nama Lengkap</td>
                <td style="width: 2%;">:</td>
                <td style="width: 30%;"><?= $siswa->nama_siswa; ?></td>
            <tr>
                <td>NIS/NISN</td>
                <td>:</td>
                <td><?= $siswa->nis; ?>/<?= $siswa->nisn; ?></td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td>
                <td>:</td>
                <td>
                    <?= $siswa->tempat_lahir; ?>, <?= $siswa->tanggal_lahir; ?>
                    <?php
                    if (!empty($siswa->tanggal_lahir)) {
                        $lahir = new DateTime($siswa->tanggal_lahir);
                        $today = new DateTime();
                        $usia = $today->diff($lahir)->y;
                        echo "<span style='margin-left:8px;'>(Usia: {$usia} tahun)</span>";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td><?= $siswa->jk; ?></td>
                <td style="width: 25%;">NIK Siswa</td>
                <td style="width: 2%;">:</td>
                <td><?= $siswa->nik; ?></td>
            </tr>
            <tr>
                <td>Status Keluarga</td>
                <td>:</td>
                <td></td>
                <td>Anak ke/Saudara</td>
                <td>:</td>
                <td><?= $siswa->anak_ke; ?> dari <?= $siswa->jumlah_saudara; ?> saudara</td>

            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td><?= $siswa->agama; ?></td>
                <td>Telp./WA</td>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td></td>
                <td>Cita/Hobi</td>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <td>Bantuan/Beasiswa</td>
                <td>:</td>
                <td></td>
                <td>Tempat Tinggal</td>
                <td>:</td>
                <td><?= $siswa->tempat_tinggal; ?></td>
            </tr>
            <tr>
                <td>No.Kartu Keluarga</td>
                <td>:</td>
                <td></td>
                <td>Nama Kepala KK</td>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <td>Alamat Tempat Tinggal</td>
                <td>:</td>
                <td colspan="4"><?= $siswa->alamat; ?></td>
            </tr>
        </table>

        <table class="identitas">
            <tr>
                <th style="padding-bottom: 5px; font-size:14px; text-align:left; padding-top:10px;">II. DATA SEKOLAH</th>
            </tr>
            <tr>
                <td style="width: 25%;">Asal Sekolah</td>
                <td style="width: 2%;">:</td>
                <td style="width: 30%;"></td>
            </tr>
            <tr>
                <td>NPSN</td>
                <td>:</td>
                <td></td>
                <td style="width: 25%;">NSS</td>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <td>Tanggal Diterima</td>
                <td>:</td>
                <td></td>
                <td style="width: 25%;">Tahun Pelajaran</td>
                <td style="width: 2%;">:</td>
                <td></td>
            </tr>
            <tr>
                <td>Di Kelas</td>
                <td>:</td>
                <td></td>
                <td>Status</td>
                <td>:</td>
                <td></td>
            </tr>
        </table>
        <table class="identitas">
            <tr>
                <th style="padding-bottom: 5px; font-size:14px; text-align:left; padding-top:10px;">III. DATA ORANG TUA</th>
            </tr>
            <tr>
                <th style="padding-bottom: 10px; font-size:14px; text-align:left; padding-top:5px;">A. DATA AYAH</th>
            </tr>
            <tr>
                <td style="width: 25%;">Nama Lengkap</td>
                <td style="width: 2%;">:</td>
                <td style="width: 30%;"><?= $siswa->nama_ayah; ?></td>
                <td style="width: 25%;">Status</td>
                <td style="width: 2%;">:</td>
                <td style="width: 25%;"></td>
            </tr>
            <tr>
                <td>Tahun Lahir</td>
                <td>:</td>
                <td><?= $siswa->tahun_ayah ?></td>
                <td>NIK Ayah</td>
                <td>:</td>
                <td><?= $siswa->nik_ayah; ?></td>
            </tr>
            <tr>
                <td>Telp/Handphone</td>
                <td>:</td>
                <td></td>
                <td>Pendidikan</td>
                <td>:</td>
                <td><?= $siswa->pendidikan_ayah; ?></td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td><?= $siswa->pekerjaan_ayah; ?></td>
                <td>Penghasilan</td>
                <td>:</td>
                <td><?= $siswa->penghasilan_ayah; ?></td>
            </tr>

        </table>
        <table class="identitas">
            <tr>
                <th style="padding-bottom: 10px; font-size:14px; text-align:left; padding-top:5px;">B. DATA IBU</th>
            </tr>
            <tr>
                <td style="width: 25%;">Nama Lengkap</td>
                <td style="width: 2%;">:</td>
                <td style="width: 30%;"><?= $siswa->nama_ibu; ?></td>
                <td style="width: 25%;">Status</td>
                <td style="width: 2%;">:</td>
                <td style="width: 25%;"></td>
            </tr>
            <tr>
                <td>Tahun Lahir</td>
                <td>:</td>
                <td><?= $siswa->tahun_ibu ?></td>
                <td>NIK Ibu</td>
                <td>:</td>
                <td><?= $siswa->nik_ibu; ?></td>
            </tr>
            <tr>
                <td>Telp/Handphone</td>
                <td>:</td>
                <td></td>
                <td>Pendidikan</td>
                <td>:</td>
                <td><?= $siswa->pendidikan_ibu; ?></td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td><?= $siswa->pekerjaan_ibu; ?></td>
                <td>Penghasilan</td>
                <td>:</td>
                <td><?= $siswa->penghasilan_ibu; ?></td>
            </tr>

        </table>
        <table width="100%">
            <tr>
                <td width="70%"></td> <!-- Kosong di kiri -->
                <td align="center">
                    Krengseng, <?php
                                $date = new DateTime();
                                $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
                                $formatter->setPattern('d MMMM yyyy');
                                echo $formatter->format($date);
                                ?><br>
                    <b>Kepala Sekolah</b><br><br><br><br><br> <!-- Ruang untuk tanda tangan -->
                    <u>Nama Kepala Sekolah</u><br>
                    NIP: 1234567890
                </td>
            </tr>
        </table>
        <div class="container">
            <div class="barcode">
                <?php
                try {
                    // Check if GD extension is loaded
                    if (!extension_loaded('gd')) {
                        throw new Exception('GD extension is not enabled');
                    }

                    // Membuat QR Code
                    $qrCode = QrCode::create('Nama Lengkap: ' . $siswa->nama_siswa . ' NIS/NISN: ' . $siswa->nis . '/' . $siswa->nisn . ' TTL: ' . $siswa->tempat_lahir . ', ' . $siswa->tanggal_lahir . ' Alamat: ' . $siswa->alamat)
                        ->setEncoding(new Encoding('UTF-8'))
                        ->setErrorCorrectionLevel(ErrorCorrectionLevel::High)
                        ->setSize(115)
                        ->setMargin(3);

                    // Check if logo file exists
                    $logoPath = 'backend/logo_sekolah.png';
                    if (file_exists($logoPath)) {
                        $logo = Logo::create($logoPath)
                            ->setResizeToWidth(35);

                        $writer = new PngWriter();
                        $result = $writer->write($qrCode, $logo);
                    } else {
                        // Generate QR code without logo if logo file doesn't exist
                        $writer = new PngWriter();
                        $result = $writer->write($qrCode);
                    }

                    // Output the QR code as a data URI
                    $dataUri = $result->getDataUri();
                    echo '<img src="' . $dataUri . '" alt="QR Code">';
                } catch (Exception $e) {
                    // Fallback when QR code generation fails
                    echo '<div style="width: 115px; height: 115px; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center; font-size: 10px; text-align: center;">';
                    echo 'QR Code<br>Not Available<br><small>(' . htmlspecialchars($e->getMessage()) . ')</small>';
                    echo '</div>';
                }
                ?>
                <p class="title">Lembar Verifikasi Data</p>
                <div class="left">
                    <p><b>BERKAS YANG PERLU DISIAPKAN:</b></p>
                    <ol>
                        <li>Fotocopy Ijazah SD/MI atau SMP/MTs</li>
                        <li>Fotocopy Kartu Keluarga Terakhir</li>
                        <li>Fotocopy Bantuan/Beasiswa</li>
                    </ol>
                </div>
                <div class="right">
                    <p class="verifikator">VERIFIKATOR:</p>
                    <p>a. Wali Kelas</p>
                    <p>b. Orang tua/Wali Peserta Didik</p>
                </div>
            </div>
        </div>
</body>

</html>