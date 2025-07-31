<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Preview Kartu Siswa</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?= site_url('cetak_kartu_siswa') ?>">Cetak Kartu</a></li>
                            <li class="breadcrumb-item active">Preview</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-show me-2"></i>Preview Kartu - <?= $siswa->nama_lengkap ?>
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <a href="<?= site_url('cetak_kartu_siswa/cetak/' . $siswa->id_siswa) ?>"
                                class="btn btn-primary me-2"
                                target="_blank">
                                <i class="bx bx-printer me-1"></i>Cetak Kartu
                            </a>
                            <a href="<?= site_url('cetak_kartu_siswa') ?>" class="btn btn-secondary">
                                <i class="bx bx-arrow-back me-1"></i>Kembali
                            </a>
                        </div> <!-- Preview Kartu -->
                        <div style="transform: scale(1.5); margin: 50px auto; display: inline-block;">
                            <div style="width: 85.6mm; height: 54mm; background: linear-gradient(135deg, #2E8B57 0%, #228B22 100%); border-radius: 12px; box-shadow: 0 12px 30px rgba(0,0,0,0.2), inset 0 1px 0 rgba(255,255,255,0.2); overflow: hidden; position: relative; font-family: 'Segoe UI', Arial, sans-serif; border: 1px solid rgba(255,255,255,0.3);">
                                <!-- Header dengan Kop Surat Lengkap -->
                                <div style="background: rgba(255,255,255,0.95); padding: 6px; text-align: center; border-bottom: 2px solid #2E8B57; display: flex; align-items: center; justify-content: space-between;">
                                    <!-- Logo Pemda -->
                                    <div style="width: 20px; height: 20px; flex-shrink: 0;">
                                        <?php if (file_exists(FCPATH . 'uploads/logo_pemda.png')): ?>
                                            <img src="<?= base_url('uploads/logo_pemda.png') ?>" alt="Logo Pemda" style="width: 100%; height: 100%; object-fit: contain;">
                                        <?php else: ?>
                                            <div style="width: 100%; height: 100%; background: #2E8B57; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 8px; font-weight: bold;">P</div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Info Sekolah -->
                                    <div style="flex: 1; margin: 0 6px; line-height: 1.1;">
                                        <div style="font-size: 6px; font-weight: bold; color: #333; margin: 0;">
                                            PEMERINTAH KABUPATEN BATANG
                                        </div>
                                        <div style="font-size: 7px; font-weight: bold; color: #333; margin: 1px 0;">
                                            <?php
                                            $namaSekolah = 'SD NEGERI KRENGSENG 02';
                                            if (isset($sekolah->nama_sekolah) && !empty($sekolah->nama_sekolah)) {
                                                $namaSekolah = strtoupper($sekolah->nama_sekolah);
                                            } elseif (isset($lembaga->nama_lembaga) && !empty($lembaga->nama_lembaga)) {
                                                $namaSekolah = strtoupper($lembaga->nama_lembaga);
                                            }
                                            echo $namaSekolah;
                                            ?> GRINGSING
                                        </div>
                                        <div style="font-size: 5px; color: #666; margin: 1px 0 0 0; line-height: 1.2;">
                                            <?php
                                            $alamatSekolah = 'Jalan Dukuh Gendogosari RT05/RW05 Gringsing Batang 51281';
                                            $telpSekolah = '085713827297';
                                            $websiteSekolah = 'sdnkrengseng02.sch.id';
                                            $emailSekolah = 'sdnkrengseng02@gmail.com';

                                            if (isset($sekolah)) {
                                                $alamatSekolah = $sekolah->alamat ?? $alamatSekolah;
                                                $telpSekolah = $sekolah->telp ?? $telpSekolah;
                                                $websiteSekolah = $sekolah->website ?? $websiteSekolah;
                                                $emailSekolah = $sekolah->email ?? $emailSekolah;
                                            }
                                            ?>
                                            <?= $alamatSekolah ?>,<br>
                                            Tel. <?= $telpSekolah ?> Web <?= $websiteSekolah ?><br>
                                            <?= $emailSekolah ?>
                                        </div>
                                    </div>

                                    <!-- Logo Sekolah -->
                                    <div style="width: 20px; height: 20px; flex-shrink: 0;">
                                        <?php if (file_exists(FCPATH . 'uploads/logo_sekolah.png')): ?>
                                            <img src="<?= base_url('uploads/logo_sekolah.png') ?>" alt="Logo Sekolah" style="width: 100%; height: 100%; object-fit: contain;">
                                        <?php else: ?>
                                            <div style="width: 100%; height: 100%; background: #228B22; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 8px; font-weight: bold;">S</div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Body -->
                                <div style="padding: 8px; display: flex; flex-direction: column; height: calc(54mm - 40px); color: white; position: relative;">
                                    <!-- Card Title -->
                                    <div style="position: absolute; top: -2px; right: 8px; font-size: 6px; opacity: 0.7; font-weight: bold;">
                                        KARTU PELAJAR
                                    </div>

                                    <!-- Bagian atas: Foto + Data Siswa -->
                                    <div style="display: flex; gap: 8px; flex: 1; margin-bottom: 8px;">
                                        <!-- Foto -->
                                        <div style="width: 45px; height: 55px; background: #fff; border: 2px solid #fff; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 6px; color: #999; flex-shrink: 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow: hidden;">
                                            <?php if (!empty($siswa->foto) && file_exists(FCPATH . 'uploads/siswa/' . $siswa->foto)): ?>
                                                <img src="<?= base_url('uploads/siswa/' . $siswa->foto) ?>" alt="Foto Siswa" style="width: 100%; height: 100%; object-fit: cover;">
                                            <?php else: ?>
                                                <div style="width: 100%; height: 100%; background: linear-gradient(45deg, #f0f0f0, #e0e0e0); display: flex; align-items: center; justify-content: center; color: #999; font-size: 8px; font-weight: bold;">
                                                    FOTO
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Info Siswa -->
                                        <div style="flex: 1; color: white; display: flex; flex-direction: column;">
                                            <div style="margin-bottom: 3px; font-size: 7px; line-height: 1.3; display: flex; align-items: flex-start;">
                                                <span style="font-weight: bold; opacity: 0.9; min-width: 50px; flex-shrink: 0;">Nama</span>
                                                <span style="flex: 1; margin-left: 4px;">: <?= $siswa->nama_lengkap ?></span>
                                            </div>

                                            <div style="margin-bottom: 3px; font-size: 7px; line-height: 1.3; display: flex; align-items: flex-start;">
                                                <span style="font-weight: bold; opacity: 0.9; min-width: 50px; flex-shrink: 0;">NISN</span>
                                                <span style="flex: 1; margin-left: 4px;">: <?= $siswa->nisn ?></span>
                                            </div>

                                            <div style="margin-bottom: 3px; font-size: 7px; line-height: 1.3; display: flex; align-items: flex-start;">
                                                <span style="font-weight: bold; opacity: 0.9; min-width: 50px; flex-shrink: 0;">Kelas</span>
                                                <span style="flex: 1; margin-left: 4px;">: <?= $siswa->nama_rombel ?? 'Belum Ada Kelas' ?></span>
                                            </div>

                                            <div style="margin-bottom: 3px; font-size: 7px; line-height: 1.3; display: flex; align-items: flex-start;">
                                                <span style="font-weight: bold; opacity: 0.9; min-width: 50px; flex-shrink: 0;">TTL</span>
                                                <span style="flex: 1; margin-left: 4px;">: <?= $siswa->tempat_lahir ?>, <?php
                                                                                                                        if (!empty($siswa->tanggal_lahir)) {
                                                                                                                            $date = new DateTime($siswa->tanggal_lahir);
                                                                                                                            echo $date->format('d M Y');
                                                                                                                        } else {
                                                                                                                            echo '-';
                                                                                                                        }
                                                                                                                        ?></span>
                                            </div>

                                            <div style="margin-bottom: 3px; font-size: 7px; line-height: 1.3; display: flex; align-items: flex-start;">
                                                <span style="font-weight: bold; opacity: 0.9; min-width: 50px; flex-shrink: 0;">Jenis Kelamin</span>
                                                <span style="flex: 1; margin-left: 4px;">: <?= $siswa->jenis_kelamin ?? 'Laki-Laki' ?></span>
                                            </div>

                                            <div style="margin-bottom: 3px; font-size: 7px; line-height: 1.3; display: flex; align-items: flex-start;">
                                                <span style="font-weight: bold; opacity: 0.9; min-width: 50px; flex-shrink: 0;">Tahun Ajaran</span>
                                                <span style="flex: 1; margin-left: 4px;">: <?= $siswa->tahun_pelajaran ?? date('Y') . '/' . (date('Y') + 1) ?></span>
                                            </div>

                                            <div style="margin-bottom: 3px; font-size: 7px; line-height: 1.3; display: flex; align-items: flex-start;">
                                                <span style="font-weight: bold; opacity: 0.9; min-width: 50px; flex-shrink: 0;">Alamat</span>
                                                <span style="flex: 1; margin-left: 4px;">: <?php
                                                                                            $alamatSiswa = $siswa->alamat ?? '';
                                                                                            if (strlen($alamatSiswa) > 40) {
                                                                                                echo substr($alamatSiswa, 0, 40) . '...';
                                                                                            } else {
                                                                                                echo $alamatSiswa ?: '-';
                                                                                            }
                                                                                            ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bagian bawah: QR Code + Tanda Tangan -->
                                    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: auto; padding-top: 8px; border-top: 1px solid rgba(255,255,255,0.2); min-height: 40px;">
                                        <!-- QR Code -->
                                        <div style="display: flex; flex-direction: column; align-items: center; color: white;">
                                            <div style="width: 35px; height: 35px; border: 1px solid rgba(255,255,255,0.5); background: rgba(255,255,255,0.9); display: flex; align-items: center; justify-content: center; font-size: 8px; font-weight: bold; margin-bottom: 2px; overflow: hidden;">
                                                <?php
                                                // Generate QR code URL or placeholder
                                                $qrData = json_encode([
                                                    'nisn' => $siswa->nisn,
                                                    'nama' => $siswa->nama_lengkap,
                                                    'sekolah' => $sekolah->nama_sekolah ?? $lembaga->nama_lembaga ?? 'SD Negeri Krengseng 02',
                                                    'tahun' => date('Y')
                                                ]);
                                                $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=35x35&data=' . urlencode($qrData);
                                                ?>
                                                <img src="<?= $qrUrl ?>" alt="QR Code" style="width: 100%; height: 100%; object-fit: contain;" onerror="this.style.display='none'; this.parentNode.innerHTML='<div style=\'color:#333;font-size:6px;text-align:center;line-height:1.2;\'>QR<br>CODE</div>';">
                                            </div>
                                            <div style="font-size: 5px; opacity: 0.8;"><?= $siswa->nisn ?></div>
                                        </div>

                                        <!-- Tanda Tangan -->
                                        <div style="text-align: center; color: white; min-width: 80px;">
                                            <div style="font-size: 6px; margin-bottom: 2px; font-weight: 500;">
                                                Gringsing, <?php
                                                            $bulanIndo = [
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
                                                            $tanggal = date('j');
                                                            $bulan = $bulanIndo[date('n')];
                                                            $tahun = date('Y');
                                                            echo $tanggal . ' ' . $bulan . ' ' . $tahun;
                                                            ?>
                                            </div>
                                            <div style="font-size: 6px; margin-bottom: 15px; font-weight: bold;">Kepala Sekolah</div>
                                            <div style="border-bottom: 1px solid rgba(255,255,255,0.6); height: 8px; margin-bottom: 2px;"></div>
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
                                            <div style="font-size: 5px; opacity: 0.8;">NIP. <?= $nipKepsek ?></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Decoration -->
                                <div style="position: absolute; bottom: 0; right: 0; width: 30px; height: 30px; background: rgba(255,255,255,0.1); border-radius: 50%; transform: translate(15px, 15px);"></div>
                                <div style="position: absolute; top: 10px; right: 10px; width: 20px; height: 20px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
                                <div style="position: absolute; bottom: 20px; left: 10px; width: 15px; height: 15px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>

                                <!-- Footer -->
                                <div style="position: absolute; bottom: 3px; right: 8px; font-size: 6px; color: rgba(255,255,255,0.7);">
                                    <?= date('Y') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>