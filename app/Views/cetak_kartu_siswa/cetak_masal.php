<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Siswa Masal</title>
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 10mm;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 210mm !important;
                height: 297mm !important;
            }

            .print-actions {
                display: none !important;
            }

            .kartu-grid {
                display: flex !important;
                flex-direction: column !important;
                gap: 15mm !important;
                margin: 15mm auto !important;
                width: 190mm !important;
                max-width: 190mm !important;
                align-items: center !important;
            }

            .kartu-pair {
                display: flex !important;
                gap: 20mm !important;
                justify-content: center !important;
                page-break-inside: avoid !important;
                width: 190mm !important;
                margin: 0 !important;
            }

            .kartu-container {
                page-break-inside: avoid !important;
                margin: 0 !important;
                width: 85.6mm !important;
                height: 54mm !important;
                flex-shrink: 0 !important;
            }

            .ttd-area {
                color: #000 !important;
                text-shadow: none !important;
                background: transparent !important;
                border: none !important;
                padding: 0 !important;
            }

            .ttd-nama {
                border-bottom: 2px solid #000 !important;
                color: #000 !important;
                background: transparent !important;
                font-weight: bold !important;
                padding: 2px 0 !important;
                margin-bottom: 2px !important;
                border-radius: 0 !important;
            }

            .ttd-signature {
                margin-top: 2px !important;
            }

            .ttd-nip {
                color: #000 !important;
                font-weight: bold !important;
            }

            .ttd-tempat,
            .ttd-jabatan {
                color: #000 !important;
            }
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }

        .kartu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(85.6mm, 1fr));
            gap: 20px;
            justify-items: center;
            margin: 20px 0;
        }

        .kartu-pair {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            justify-content: center;
            flex-wrap: wrap;
        }

        .kartu-container {
            width: 85.6mm;
            height: 54mm;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            position: relative;
            page-break-inside: avoid;
            flex-shrink: 0;
        }

        .kartu-container.back-side {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        .sekolah-info {
            margin: 0;
            line-height: 1.2;
        }

        .nama-sekolah {
            font-size: 9px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }

        .alamat-sekolah {
            font-size: 7px;
            color: #666;
            margin: 2px 0 0 0;
        }

        .kartu-body {
            padding: 8px;
            display: flex;
            align-items: center;
            height: calc(54mm - 40px);
        }

        .foto-siswa {
            width: 25mm;
            height: 30mm;
            background: #fff;
            border: 2px solid #fff;
            border-radius: 5px;
            margin-right: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: #999;
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23ccc"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>');
            background-repeat: no-repeat;
            background-position: center;
            background-size: 50%;
        }

        .info-siswa {
            flex: 1;
            color: white;
            min-width: 0;
            /* Allow flexbox to shrink */
            overflow: hidden;
        }

        .info-row {
            margin-bottom: 2px;
            font-size: 6px;
            line-height: 1.3;
            word-wrap: break-word;
            overflow-wrap: break-word;
            display: flex;
            align-items: flex-start;
        }

        .label {
            font-weight: bold;
            opacity: 0.9;
            min-width: 32px;
            display: inline-block;
            flex-shrink: 0;
        }

        .value {
            font-weight: normal;
            margin-left: 2px;
            flex: 1;
        }

        .info-bottom {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 2px;
        }

        .info-left {
            flex: 1;
            padding-right: 4px;
        }

        .nama-siswa {
            font-size: 9px;
            font-weight: bold;
            margin-bottom: 4px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
            line-height: 1.2;
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
            max-width: 100%;
            white-space: normal;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
        }

        .decoration {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 30px;
            height: 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(15px, 15px);
        }

        .decoration::before {
            content: '';
            position: absolute;
            top: -20px;
            left: -20px;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .kartu-footer {
            position: absolute;
            bottom: 3px;
            right: 8px;
            font-size: 6px;
            color: rgba(255, 255, 255, 0.7);
        }

        .kartu-header {
            background: rgba(255, 255, 255, 0.95);
            padding: 8px;
            text-align: center;
            border-bottom: 2px solid #667eea;
        }

        .ttd-area {
            text-align: right;
            font-size: 5px;
            color: white;
            padding-top: 0;
            padding-right: 2px;
            line-height: 1.3;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.9), -1px -1px 2px rgba(0, 0, 0, 0.7);
            font-weight: bold;
            flex-shrink: 0;
            min-width: 70px;
            align-self: flex-start;
        }

        .ttd-tempat {
            margin-bottom: 2px;
            margin-top: 10px;
            font-weight: 500;
        }

        .ttd-jabatan {
            margin-bottom: 12px;
            font-weight: bold;
            font-size: 5.5px;
        }

        .ttd-nama {
            border-bottom: 1px solid rgba(255, 255, 255, 0.8);
            padding: 2px 0;
            font-weight: bold;
            font-size: 6px;
            line-height: 1.2;
            margin-top: 2px;
            margin-bottom: 2px;
            background: transparent;
            color: white;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.9);
        }

        .ttd-nip {
            font-size: 5px;
            font-weight: bold;
            margin-top: 1px;
            color: white;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.9);
        }

        .kartu-body-with-ttd {
            padding: 8px;
            display: flex;
            align-items: flex-start;
            height: calc(54mm - 40px);
            flex-direction: column;
        }

        .content-area {
            display: flex;
            align-items: flex-start;
            flex: 1;
            width: 100%;
        }

        .ttd-signature {
            margin-top: 2px;
        }
    </style>
</head>

<body>
    <div class="print-actions">
        <h3>Cetak Kartu Siswa Masal</h3>
        <p>Total: <?= count($siswa_list) ?> kartu siswa</p>
        <button class="btn" onclick="window.print()">
            <i class="bx bx-printer"></i> Cetak Semua Kartu
        </button>
        <a href="<?= site_url('cetak_kartu_siswa') ?>" class="btn" style="background: #6c757d;">
            <i class="bx bx-arrow-back"></i> Kembali
        </a>
    </div>
    <div class="kartu-grid">
        <?php foreach ($siswa_list as $siswa): ?>
            <div class="kartu-pair">
                <!-- Sisi Depan -->
                <div class="kartu-container">
                    <div class="kartu-header">
                        <div class="header-top">
                            PEMERINTAH KABUPATEN BATANG<br>
                            SD NEGERI KRENGSENG 02 GRINGSING
                        </div>

                        <div class="logo-area">
                            <div class="logo">
                                LOGO
                            </div>
                            <div class="sekolah-info">
                                <div class="nama-sekolah">SD NEGERI KRENGSENG 02</div>
                                <div class="alamat-sekolah">Dukuh Gendogosari, Desa Krengseng</div>
                                <div class="alamat-sekolah">Kec. Gringsing, Kab. Batang</div>
                            </div>
                        </div>

                        <div class="kartu-title">KARTU PELAJAR</div>
                    </div>
                    <div class="kartu-body-with-ttd">
                        <div class="content-area">
                            <div class="foto-siswa">
                                FOTO<br>3x4
                            </div>

                            <div class="info-siswa">
                                <div class="nama-siswa"><?= strtoupper($siswa->nama_lengkap) ?></div>

                                <div class="info-row">
                                    <span class="label">NISN</span>
                                    <span class="value">: <?= $siswa->nisn ?></span>
                                </div>

                                <div class="info-row">
                                    <span class="label">NIS</span>
                                    <span class="value">: <?= $siswa->nis ?? '-' ?></span>
                                </div>

                                <div class="info-row">
                                    <span class="label">Kelas</span>
                                    <span class="value">: <?= $siswa->nama_rombel ?? '-' ?></span>
                                </div>
                                <div class="info-row">
                                    <span class="label">T.Lahir</span>
                                    <span class="value">: <?= $siswa->tempat_lahir ?></span>
                                </div>

                                <div class="info-bottom">
                                    <div class="info-left">
                                        <div class="info-row">
                                            <span class="label">Tgl.Lahir</span>
                                            <span class="value">: <?= date('d/m/Y', strtotime($siswa->tanggal_lahir)) ?></span>
                                        </div>

                                        <div class="info-row">
                                            <span class="label">Alamat</span>
                                            <span class="value">: <?= substr($siswa->alamat, 0, 25) ?><?= strlen($siswa->alamat) > 25 ? '...' : '' ?></span>
                                        </div>
                                    </div>

                                    <div class="ttd-area">
                                        <div class="ttd-tempat">Krengseng, <?= date('d') ?> <?=
                                                                                            array(
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
                                                                                            )[date('n')]
                                                                                            ?> <?= date('Y') ?></div>
                                        <div class="ttd-jabatan">Kepala Sekolah</div>
                                        <div style="height: 8px;"></div>
                                        <div style="height: 8px;"></div>
                                        <div style="height: 8px;"></div>
                                        <div class="ttd-signature">
                                            <div class="ttd-nama">
                                                <?php
                                                if (isset($kepala_sekolah) && $kepala_sekolah && !empty($kepala_sekolah->nama)) {
                                                    echo $kepala_sekolah->nama;
                                                } else {
                                                    echo 'Drs. Suwardi, M.Pd';
                                                }
                                                ?>
                                            </div>
                                            <div class="ttd-nip">NIP. <?php
                                                                        if (isset($kepala_sekolah) && $kepala_sekolah && !empty($kepala_sekolah->nip)) {
                                                                            echo $kepala_sekolah->nip;
                                                                        } else {
                                                                            echo '196512151990031008';
                                                                        }
                                                                        ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kartu-footer">
                            Berlaku sampai dengan: <?= date('Y') + 1 ?>
                        </div>
                    </div>

                    <!-- Sisi Belakang -->
                    <div class="kartu-container back-side">
                        <div class="kartu-header" style="background: rgba(255,255,255,0.9);">
                            <div class="header-top">
                                PEMERINTAH KABUPATEN BATANG<br>
                                SD NEGERI KRENGSENG 02 GRINGSING
                            </div>
                            <div class="kartu-title">VISI & MISI</div>
                        </div>

                        <div class="kartu-body" style="color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                            <div style="width: 100%; font-size: 7px; line-height: 1.3; padding: 5px;">
                                <div style="margin-bottom: 6px;">
                                    <strong style="font-size: 8px; color: #ffeb3b;">VISI:</strong><br>
                                    <span style="font-size: 6px;">Terwujudnya generasi yang beriman, bertaqwa, berakhlak mulia, cerdas, dan berprestasi.</span>
                                </div>

                                <div style="margin-bottom: 6px;">
                                    <strong style="font-size: 8px; color: #ffeb3b;">MISI:</strong><br>
                                    <ul style="margin: 2px 0; padding-left: 12px; font-size: 5px; line-height: 1.2;">
                                        <li>Menyelenggarakan pendidikan berkualitas</li>
                                        <li>Membentuk karakter siswa yang islami</li>
                                        <li>Mengembangkan potensi siswa optimal</li>
                                        <li>Menciptakan lingkungan belajar kondusif</li>
                                    </ul>
                                </div>

                                <div style="margin-top: 8px; padding-top: 6px; border-top: 1px solid rgba(255,255,255,0.3);">
                                    <div style="font-size: 6px; text-align: center;">
                                        <strong>📍 Alamat:</strong><br>
                                        Dukuh Gendogosari, Desa Krengseng<br>
                                        Kec. Gringsing, Kab. Batang<br>
                                        📞 (0285) 123456 | 📧 info@sekolah.sch.id
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kartu-footer">
                            www.sdnkrengseng02.sch.id
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>

            <script>
                window.onload = function() {
                    window.print();
                }
            </script>
</body>

</html>