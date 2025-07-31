<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Siswa - <?= $siswa->nama_lengkap ?></title>
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

            .kartu-wrapper {
                display: flex !important;
                flex-direction: row !important;
                justify-content: center !important;
                align-items: flex-start !important;
                gap: 20mm !important;
                margin: 20mm auto !important;
                width: 190mm !important;
                max-width: 190mm !important;
                padding: 0 !important;
            }

            .kartu-container {
                page-break-inside: avoid !important;
                margin: 0 !important;
                width: 85.6mm !important;
                height: 54mm !important;
                flex-shrink: 0 !important;
                position: relative !important;
            }

            .kartu-label {
                display: none !important;
            }

            .kartu-item {
                margin: 0 !important;
                padding: 0 !important;
                flex: 0 0 85.6mm !important;
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

        @media screen and (max-width: 768px) {
            .kartu-wrapper {
                flex-direction: column;
                align-items: center;
            }

            .kartu-container {
                margin-bottom: 20px;
            }
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }

        .kartu-wrapper {
            display: flex;
            gap: 20px;
            justify-content: center;
            align-items: flex-start;
            flex-wrap: nowrap;
            margin: 20px auto;
            max-width: 800px;
            padding: 20px;
        }

        .kartu-container {
            width: 85.6mm;
            height: 54mm;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            position: relative;
            flex-shrink: 0;
        }

        .kartu-container.has-template {
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .kartu-container.back-side {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        .kartu-container.back-side.has-template {
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .kartu-header {
            background: rgba(255, 255, 255, 0.95);
            padding: 6px;
            text-align: center;
            border-bottom: 2px solid #667eea;
            position: relative;
        }

        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-bottom: 2px;
        }

        .logo {
            width: 20px;
            height: 20px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            flex-shrink: 0;
            border-radius: 2px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .logo-sekolah {
            background-image: url('<?= base_url('uploads/logo_sekolah.png') ?>');
        }

        .logo-pemda {
            background-image: url('<?= base_url('uploads/logo_pemda.png') ?>');
        }

        .logo-fallback {
            width: 20px;
            height: 20px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: white;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .sekolah-info {
            margin: 0;
            line-height: 1.0;
            flex: 1;
        }

        .nama-sekolah {
            font-size: 7px;
            font-weight: bold;
            color: #333;
            margin: 0;
            text-transform: uppercase;
            line-height: 1.1;
            text-align: center;
        }

        .alamat-sekolah {
            font-size: 5px;
            color: #666;
            margin: 1px 0 0 0;
            line-height: 1.1;
            text-align: center;
        }

        .kartu-body {
            padding: 8px;
            display: flex;
            flex-direction: column;
            height: calc(54mm - 32px);
            color: white;
            position: relative;
        }

        /* Bagian atas: Foto + Data Siswa */
        .content-area {
            display: flex;
            gap: 10px;
            flex: 1;
            margin-bottom: 8px;
        }

        .foto-siswa {
            width: 45px;
            height: 55px;
            background: #f0f0f0;
            border: 2px solid #fff;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .info-siswa {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .info-row {
            display: flex;
            margin-bottom: 3px;
            font-size: 7px;
            line-height: 1.3;
            align-items: flex-start;
        }

        .label {
            font-weight: bold;
            min-width: 50px;
            opacity: 0.9;
            flex-shrink: 0;
        }

        .value {
            flex: 1;
            margin-left: 4px;
        }

        /* Bagian bawah: QR Code + Tanda Tangan */
        .bottom-area {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding-top: 8px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: auto;
            min-height: 40px;
        }

        .qr-area {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .qr-code {
            width: 35px;
            height: 35px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .qr-number {
            font-size: 5px;
            opacity: 0.8;
        }

        .ttd-area {
            text-align: center;
            min-width: 80px;
        }

        .ttd-tempat {
            font-size: 6px;
            margin-bottom: 2px;
            font-weight: 500;
        }

        .ttd-jabatan {
            font-size: 6px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .ttd-signature {
            border-bottom: 1px solid rgba(255, 255, 255, 0.6);
            margin-bottom: 2px;
            height: 8px;
        }

        .ttd-nama {
            font-size: 6px;
            font-weight: bold;
            margin-bottom: 1px;
        }

        .ttd-nip {
            font-size: 5px;
            opacity: 0.8;
        }

        .foto-siswa img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 2px;
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

        .kartu-label {
            text-align: center;
            margin-bottom: 10px;
            font-weight: bold;
            color: #495057;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .kartu-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 0 0 auto;
            margin: 0;
        }

        .kartu-footer {
            position: absolute;
            bottom: 3px;
            right: 8px;
            font-size: 6px;
            color: rgba(255, 255, 255, 0.7);
        }

        .ttd-signature {
            margin-top: 2px;
        }
    </style>
</head>

<body>
    <div class="kartu-wrapper"> <!-- Sisi Depan Kartu -->
        <div class="kartu-item">
            <div class="kartu-label">🎯 Sisi Depan Kartu</div>
            <div class="kartu-container <?= file_exists(FCPATH . 'uploads/template_kartu_depan.jpg') ? 'has-template' : '' ?>"
                <?= file_exists(FCPATH . 'uploads/template_kartu_depan.jpg') ? 'style="background-image: url(\'' . base_url('uploads/template_kartu_depan.jpg') . '\')"' : '' ?>>
                <div class="kartu-header">
                    <div class="kop-surat">
                        <!-- Logo Pemda -->
                        <?php if (file_exists(FCPATH . 'uploads/logo_pemda.png')): ?>
                            <div class="logo logo-pemda"></div>
                        <?php else: ?>
                            <div class="logo-fallback">P</div>
                        <?php endif; ?>

                        <!-- Info Sekolah -->
                        <div class="sekolah-info">
                            <div class="nama-sekolah">
                                PEMERINTAH KABUPATEN BATANG<br>
                                <?= strtoupper($sekolah->nama_sekolah ?? $lembaga->nama_lembaga ?? 'SD NEGERI KRENGSENG 02') ?> GRINGSING
                            </div>
                            <div class="alamat-sekolah">
                                <?= $sekolah->alamat ?? 'Jalan Dukuh Gendogosari RT05/RW05 Gringsing Batang 51281' ?>,<br>
                                Telepon <?= $sekolah->telp ?? '085713827297' ?> Laman <?= $sekolah->website ?? 'https://sdnkrengseng02.sch.id' ?>,<br>
                                <?= $sekolah->email ?? 'sdnkrengseng02@gmail.com' ?>
                            </div>
                        </div>

                        <!-- Logo Sekolah -->
                        <?php if (file_exists(FCPATH . 'uploads/logo_sekolah.png')): ?>
                            <div class="logo logo-sekolah"></div>
                        <?php else: ?>
                            <div class="logo-fallback">S</div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="kartu-body" style="padding: 8px; display: flex; flex-direction: column; height: calc(54mm - 32px); color: white;">
                    <!-- Area konten utama: Foto + Data Siswa -->
                    <div style="display: flex; gap: 8px; flex: 1; margin-bottom: 8px;">
                        <!-- Foto siswa -->
                        <div style="width: 45px; height: 55px; background: #fff; border: 2px solid #fff; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 6px; color: #999; flex-shrink: 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            📷
                        </div>

                        <!-- Data siswa -->
                        <div style="flex: 1; color: white;">
                            <div style="margin-bottom: 3px; font-size: 7px; line-height: 1.3; display: flex; align-items: flex-start;">
                                <span style="font-weight: bold; min-width: 50px; opacity: 0.9; flex-shrink: 0;">Nama</span>
                                <span style="flex: 1; margin-left: 4px;">: <?= $siswa->nama_lengkap ?></span>
                            </div>
                            <div style="margin-bottom: 3px; font-size: 7px; line-height: 1.3; display: flex; align-items: flex-start;">
                                <span style="font-weight: bold; min-width: 50px; opacity: 0.9; flex-shrink: 0;">NISN</span>
                                <span style="flex: 1; margin-left: 4px;">: <?= $siswa->nisn ?></span>
                            </div>
                            <div style="margin-bottom: 3px; font-size: 7px; line-height: 1.3; display: flex; align-items: flex-start;">
                                <span style="font-weight: bold; min-width: 50px; opacity: 0.9; flex-shrink: 0;">TTL</span>
                                <span style="flex: 1; margin-left: 4px;">: <?= $siswa->tempat_lahir ?>, <?= date('d M Y', strtotime($siswa->tanggal_lahir)) ?></span>
                            </div>
                            <div style="margin-bottom: 3px; font-size: 7px; line-height: 1.3; display: flex; align-items: flex-start;">
                                <span style="font-weight: bold; min-width: 50px; opacity: 0.9; flex-shrink: 0;">Jenis Kelamin</span>
                                <span style="flex: 1; margin-left: 4px;">: <?= $siswa->jenis_kelamin ?? 'Laki-Laki' ?></span>
                            </div>
                            <div style="margin-bottom: 3px; font-size: 7px; line-height: 1.3; display: flex; align-items: flex-start;">
                                <span style="font-weight: bold; min-width: 50px; opacity: 0.9; flex-shrink: 0;">Alamat</span>
                                <span style="flex: 1; margin-left: 4px;">: <?= strlen($siswa->alamat) > 40 ? substr($siswa->alamat, 0, 40) . '...' : $siswa->alamat ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Area bawah: QR Code + Tanda Tangan -->
                    <div style="display: flex; justify-content: space-between; align-items: flex-end; padding-top: 8px; border-top: 1px solid rgba(255,255,255,0.2); margin-top: auto; min-height: 40px;">
                        <!-- QR Code -->
                        <div style="display: flex; flex-direction: column; align-items: center;">
                            <div style="width: 35px; height: 35px; border: 1px solid rgba(255,255,255,0.5); background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; font-size: 8px; font-weight: bold; margin-bottom: 2px;">
                                QR
                            </div>
                            <div style="font-size: 5px; opacity: 0.8;"><?= $siswa->nisn ?></div>
                        </div>

                        <!-- Tanda tangan -->
                        <div style="text-align: center; min-width: 80px;">
                            <div style="font-size: 6px; margin-bottom: 2px; font-weight: 500;">
                                Gringsing, <?= date('d F Y') ?>
                            </div>
                            <div style="font-size: 6px; margin-bottom: 15px; font-weight: bold;">
                                Kepala Sekolah
                            </div>
                            <div style="border-bottom: 1px solid rgba(255,255,255,0.6); margin-bottom: 2px; height: 8px;"></div>
                            <div style="font-size: 6px; font-weight: bold; margin-bottom: 1px;">
                                <?php
                                $namaKepsek = 'Drs. Suwardi, M.Pd';
                                $nipKepsek = '196512151990031008';

                                if (isset($kepala_sekolah) && is_object($kepala_sekolah)) {
                                    if (!empty($kepala_sekolah->nama)) {
                                        $namaKepsek = $kepala_sekolah->nama;
                                    }
                                    if (!empty($kepala_sekolah->nip)) {
                                        $nipKepsek = $kepala_sekolah->nip;
                                    }
                                }
                                echo $namaKepsek;
                                ?>
                            </div>
                            <div style="font-size: 5px; opacity: 0.8;">
                                NIP. <?= $nipKepsek ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sisi Belakang Kartu -->
        <div class="kartu-item">
            <div class="kartu-label">🔄 Sisi Belakang Kartu</div>
            <div class="kartu-container back-side <?= file_exists(FCPATH . 'uploads/template_kartu_belakang.jpg') ? 'has-template' : '' ?>"
                <?= file_exists(FCPATH . 'uploads/template_kartu_belakang.jpg') ? 'style="background-image: url(\'' . base_url('uploads/template_kartu_belakang.jpg') . '\')"' : '' ?>>
                <div class="kartu-header" style="background: rgba(255,255,255,0.9);">
                    <div class="kop-surat">
                        <!-- Logo Pemda -->
                        <?php if (file_exists(FCPATH . 'uploads/logo_pemda.png')): ?>
                            <div class="logo logo-pemda"></div>
                        <?php else: ?>
                            <div class="logo-fallback">P</div>
                        <?php endif; ?>

                        <!-- Info Sekolah -->
                        <div class="sekolah-info">
                            <div class="nama-sekolah">
                                PEMERINTAH KABUPATEN BATANG<br>
                                <?= strtoupper($sekolah->nama_sekolah ?? $lembaga->nama_lembaga ?? 'SD NEGERI KRENGSENG 02') ?> GRINGSING
                            </div>
                            <div class="alamat-sekolah">
                                <?= $sekolah->alamat ?? 'Jalan Dukuh Gendogosari RT05/RW05 Gringsing Batang 51281' ?>,<br>
                                Telepon <?= $sekolah->telp ?? '085713827297' ?> Laman <?= $sekolah->website ?? 'https://sdnkrengseng02.sch.id' ?>,<br>
                                <?= $sekolah->email ?? 'sdnkrengseng02@gmail.com' ?>
                            </div>
                        </div>

                        <!-- Logo Sekolah -->
                        <?php if (file_exists(FCPATH . 'uploads/logo_sekolah.png')): ?>
                            <div class="logo logo-sekolah"></div>
                        <?php else: ?>
                            <div class="logo-fallback">S</div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="kartu-body" style="color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                    <div style="width: 100%; font-size: 7px; line-height: 1.3;">
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
                                <strong>📍 Alamat Lengkap:</strong><br>
                                Dukuh Gendogosari, Desa Krengseng<br>
                                Kec. Gringsing, Kab. Batang, Jawa Tengah<br>
                                <strong>📞 Telp:</strong> (0285) 123456 | <strong>📧 Email:</strong> info@sekolah.sch.id
                            </div>
                        </div>
                    </div>
                </div>
                <div style="position: absolute; bottom: 8px; right: 8px; font-size: 7px; color: rgba(255,255,255,0.8);">
                    <?= $sekolah->website ?? 'www.' . strtolower(str_replace(' ', '', $sekolah->nama_sekolah ?? $lembaga->nama_lembaga ?? 'sdnkrengseng02')) . '.sch.id' ?> </div>
            </div>
        </div>

        <script>
            window.onload = function() {
                window.print();
            }
        </script>
</body>

</html>