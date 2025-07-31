<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<!-- THEME SWITCHER (EXAMPLE) -->
<!-- Untuk menerapkan tema, tambahkan tombol/opsi di sini jika ingin user bisa memilih tema. -->
<!-- Contoh: -->
<!-- <div class="mb-3">
    <button class="btn btn-dark" onclick="setTheme('dark')">Dark Mode</button>
    <button class="btn btn-light" onclick="setTheme('light')">Light Mode</button>
</div> -->
<script>
    // Contoh fungsi theme switcher sederhana (mengganti class body)
    function setTheme(theme) {
        if (theme === 'dark') {
            document.body.classList.add('bg-dark', 'text-white');
        } else {
            document.body.classList.remove('bg-dark', 'text-white');
        }
    }
</script>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->

        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                <div class="d-flex align-items-center">
                    <a href="<?= site_url('calon_peserta') ?>" class="btn btn-sm btn-primary waves-effect waves-light bg-gradient me-3"><i class="mdi mdi-arrow-left"></i> Back</a>
                    <h4 class="mb-sm-0 font-size-18">Update Peserta Didik Baru</h4>
                </div>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Calon Peserta</a></li>
                        <li class="breadcrumb-item active">Formulir</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                        <h4 class="card-title mb-0">Update Data Pendaftaran Siswa Baru</h4>

                        <form id="basic-form-spmb" action="<?= site_url('calon_siswa/update/' . ($calon_siswa->id_peserta ?? '')) ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="ms-0 ms-md-3 mt-3 mt-md-0">
                                <div class="btn-group" role="group" aria-label="Jalur Pendaftaran">
                                    <?php
                                    // Normalisasi value jalur agar tidak ada spasi/typo/case sensitive
                                    $jalur_val = isset($calon_siswa->jalur) ? strtolower(trim($calon_siswa->jalur)) : '';
                                    ?>
                                    <input type="radio" class="btn-check" name="jalur" id="jalur-zonasi" value="zonasi" autocomplete="off" required
                                        <?= ($jalur_val === 'zonasi') ? 'checked' : '' ?>>
                                    <label class="btn btn-outline-primary" for="jalur-zonasi"><i class="mdi mdi-map-marker-radius-outline me-1"></i> Zonasi</label>

                                    <input type="radio" class="btn-check" name="jalur" id="jalur-afirmasi" value="afirmasi" autocomplete="off" required
                                        <?= ($jalur_val === 'afirmasi') ? 'checked' : '' ?>>
                                    <label class="btn btn-outline-success" for="jalur-afirmasi"><i class="mdi mdi-account-group-outline me-1"></i> Afirmasi</label>

                                    <input type="radio" class="btn-check" name="jalur" id="jalur-prestasi" value="prestasi" autocomplete="off" required
                                        <?= ($jalur_val === 'prestasi') ? 'checked' : '' ?>>
                                    <label class="btn btn-outline-warning" for="jalur-prestasi"><i class="mdi mdi-star-outline me-1"></i> Prestasi</label>

                                    <input type="radio" class="btn-check" name="jalur" id="jalur-mutasi" value="mutasi" autocomplete="off" required
                                        <?= ($jalur_val === 'mutasi') ? 'checked' : '' ?>>
                                    <label class="btn btn-outline-info" for="jalur-mutasi"><i class="mdi mdi-swap-horizontal me-1"></i> Mutasi</label>
                                </div>
                                <!-- <div class="invalid-feedback d-block" id="jalur-invalid-feedback" style="display:none;">Pilih salah satu jalur pendaftaran.</div> -->
                            </div>
                    </div>

                    <!-- Seller Details -->
                    <section>
                        <div class="row mb-3">
                            <!-- Tambahan kolom identitas sesuai permintaan user -->

                            <div class="col-md-12">
                                <div class="alert alert-success d-flex align-items-center mb-2" role="alert">
                                    <i class="mdi mdi-numeric fs-3 me-2"></i>
                                    <div class="d-flex align-items-center justify-content-between" style="width:100%">
                                        <div>
                                            <strong>Nomor Pendaftaran :</strong>
                                            <span class="fw-bold text-primary" style="font-size:1.3em; letter-spacing:1px;">
                                                <?= isset($calon_siswa->no_pendaftaran) ? esc($calon_siswa->no_pendaftaran) : (isset($registration_number) ? esc($registration_number) : '') ?>
                                            </span>
                                            <input type="hidden" name="no_pendaftaran" value="<?= isset($calon_siswa->no_pendaftaran) ? esc($calon_siswa->no_pendaftaran) : (isset($registration_number) ? esc($registration_number) : '') ?>">
                                            <input type="hidden" name="tanggal_pendaftaran" value="<?= isset($calon_siswa->tanggal_pendaftaran) ? esc($calon_siswa->tanggal_pendaftaran) : date('Y-m-d H:i:s') ?>">
                                        </div>
                                        <!-- <div>
                                                        <strong>Tahun Penerimaan :</strong>
                                                        <span class="fw-bold text-success" style="font-size:1.1em; letter-spacing:1px;">
                                                            <?php
                                                            if (isset($calon_siswa->tahun_penerimaan) && $calon_siswa->tahun_penerimaan) {
                                                                echo esc($calon_siswa->tahun_penerimaan);
                                                            } elseif (isset($tahun_aktif->tahun_penerimaan) && $tahun_aktif->tahun_penerimaan) {
                                                                echo esc($tahun_aktif->tahun_penerimaan);
                                                            } else {
                                                                echo '-';
                                                            }
                                                            ?>
                                                        </span>
                                                        <input type="hidden" name="id_tahun" value="<?= isset($calon_siswa->id_tahun) ? esc($calon_siswa->id_tahun) : (isset($tahun_aktif->id_tahun) ? esc($tahun_aktif->id_tahun) : '') ?>" required>
                                                    </div> -->
                                    </div>
                                </div>
                                <div style="background: linear-gradient(90deg, #388e3c 0%, #81c784 100%); border-radius: 0px; padding: 18px 28px; margin-bottom: 22px; display: flex; align-items: center; box-shadow: 0 2px 8px rgba(56, 142, 60, 0.09);">
                                    <i class="mdi mdi-account-details-outline me-3" style="font-size: 1.8em; color: #fff;"></i>
                                    <div>
                                        <h3 class="mb-1" style="font-size: 1.15rem; font-weight: 700; color: #fff; letter-spacing: 0.5px;">
                                            Identitas Diri
                                        </h3>
                                        <div style="font-size: 0.85rem; color: #e8f5e9; font-weight: 400;">
                                            Isi data pribadi calon peserta didik dengan lengkap dan benar.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_peserta" class="form-control" placeholder="Nama Lengkap" required value="<?= esc($calon_siswa->nama_peserta ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">NISN <span class="text-danger">*</span></label>
                                    <input type="number" name="nisn" class="form-control" placeholder="NISN" value="<?= esc($calon_siswa->nisn ?? '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" class="form-select select2" required>
                                        <option value disabled <?= empty($calon_siswa->jenis_kelamin) ? 'selected' : '' ?>>-- Pilih Jenis Kelamin --</option>
                                        <option value="L" <?= (isset($calon_siswa) && $calon_siswa->jenis_kelamin == 'L') ? 'selected' : '' ?>>Laki-laki</option>
                                        <option value="P" <?= (isset($calon_siswa) && $calon_siswa->jenis_kelamin == 'P') ? 'selected' : '' ?>>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">NIK/ No. KITAS (Untuk WNA) <span class="text-danger">*</span></label>
                                    <input type="number" name="nik" class="form-control" placeholder="NIK/No KITAS (Untuk WNA)" required value="<?= esc($calon_siswa->nik ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Nomor KK</label>
                                    <input type="text" name="nomor_kk" class="form-control" placeholder="Nomor KK" value="<?= esc($calon_siswa->nomor_kk ?? '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" required value="<?= esc($calon_siswa->tempat_lahir ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_lahir" class="form-control" required value="<?= esc($calon_siswa->tanggal_lahir ?? '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Agama</label>
                                    <select name="id_agama" class="form-select select2">
                                        <option value="">-- Pilih Agama --</option>
                                        <?php foreach ($agama as $key => $value): ?>
                                            <option value="<?= isset($value->id_agama) ? $value->id_agama : (isset($value->id) ? $value->id : '') ?>" <?= (isset($calon_siswa) && $calon_siswa->id_agama == (isset($value->id_agama) ? $value->id_agama : (isset($value->id) ? $value->id : ''))) ? 'selected' : '' ?>><?= isset($value->nama_agama) ? $value->nama_agama : (isset($value->agama) ? $value->agama : '') ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label class="form-label">Kewarganegaraan</label>
                                    <select name="kewarganegaraan" class="form-select select2">
                                        <option value="WNI" <?= (isset($calon_siswa) && $calon_siswa->kewarganegaraan == 'WNI') ? 'selected' : '' ?>>WNI</option>
                                        <option value="WNA" <?= (isset($calon_siswa) && $calon_siswa->kewarganegaraan == 'WNA') ? 'selected' : '' ?>>WNA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label class="form-label">Anak Ke (Jumlah Saudara)</label>
                                    <input type="number" name="anak_ke" class="form-control" placeholder="Contoh: 2" min="1" value="<?= esc($calon_siswa->anak_ke ?? '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Berkebutuhan Khusus</label>
                                    <select name="id_kebutuhan_khusus" class="form-select select2">
                                        <option value="">-- Pilih Berkebutuhan Khusus --</option>
                                        <?php if (isset($disability) && is_array($disability)): ?>
                                            <?php foreach ($disability as $key => $value): ?>
                                                <option value="<?= $value->id_disability ?>"
                                                    <?php
                                                    $selected = false;
                                                    if (isset($calon_siswa)) {
                                                        if (isset($calon_siswa->id_kebutuhan_khusus) && $calon_siswa->id_kebutuhan_khusus == $value->id_disability) {
                                                            $selected = true;
                                                        } elseif (isset($calon_siswa->id_disability) && $calon_siswa->id_disability == $value->id_disability) {
                                                            $selected = true;
                                                        }
                                                    }
                                                    echo $selected ? 'selected' : '';
                                                    ?>><?= $value->jenis_disability ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor Akta Kelahiran</label>
                                    <input type="text" name="nomor_akta_kelahiran" class="form-control" placeholder="Nomor Akta Kelahiran" value="<?= esc($calon_siswa->nomor_akta_kelahiran ?? '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                    <textarea name="alamat" class="form-control" placeholder="Alamat Lengkap" required><?= esc($calon_siswa->alamat ?? '') ?></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- Alamat Domisili (Provinsi, Kabupaten/Kota, Kecamatan, Kelurahan/Desa dalam satu baris) -->
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="select-provinsi" class="form-label">Provinsi</label>
                                    <select id="select-provinsi" name="provinsi" class="form-select select2">
                                        <option value="">-- Pilih Provinsi --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="select-kabupaten" class="form-label">Kabupaten/Kota</label>
                                    <select id="select-kabupaten" name="kabupaten" class="form-select select2">
                                        <option value="">-- Pilih Kabupaten/Kota --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="select-kecamatan" class="form-label">Kecamatan</label>
                                    <select id="select-kecamatan" name="kecamatan" class="form-select select2">
                                        <option value="">-- Pilih Kecamatan --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="select-kelurahan" class="form-label">Kelurahan/Desa</label>
                                    <select id="select-kelurahan" name="kelurahan" class="form-select select2">
                                        <option value="">-- Pilih Kelurahan/Desa --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Kode Pos</label>
                                    <input type="text" name="kode_pos" class="form-control" placeholder="Kode Pos" value="<?= esc($calon_siswa->kode_pos ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">RT/RW</label>
                                    <div class="input-group">
                                        <input type="text" name="rt" class="form-control" placeholder="RT" value="<?= esc($calon_siswa->rt ?? '') ?>">
                                        <span class="input-group-text">/</span>
                                        <input type="text" name="rw" class="form-control" placeholder="RW" value="<?= esc($calon_siswa->rw ?? '') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Tempat Tinggal Anak</label>
                                    <select name="id_tinggal" class="form-select select2">
                                        <option value="">-- Pilih Tempat Tinggal --</option>
                                        <?php foreach ($tinggal as $row): ?>
                                            <option value="<?= $row->id_tempat_tinggal ?>"
                                                <?= (
                                                    isset($calon_siswa) &&
                                                    (
                                                        (isset($calon_siswa->id_tinggal) && $calon_siswa->id_tinggal == $row->id_tempat_tinggal) ||
                                                        (isset($calon_siswa->id_tempat_tinggal) && $calon_siswa->id_tempat_tinggal == $row->id_tempat_tinggal)
                                                    )
                                                ) ? 'selected' : '' ?>>
                                                <?= $row->tempat_tinggal ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Moda Transportasi</label>
                                    <select name="id_transportasi" class="form-select select2">
                                        <option value="">-- Pilih Moda Transportasi --</option>
                                        <?php foreach ($transport as $row): ?>
                                            <option value="<?= $row->id_transportasi ?>"
                                                <?php
                                                $selected = false;
                                                if (isset($calon_siswa)) {
                                                    if (isset($calon_siswa->id_transportasi) && $calon_siswa->id_transportasi == $row->id_transportasi) {
                                                        $selected = true;
                                                    } elseif (isset($calon_siswa->id_moda_transportasi) && $calon_siswa->id_moda_transportasi == $row->id_transportasi) {
                                                        $selected = true;
                                                    }
                                                }
                                                echo $selected ? 'selected' : '';
                                                ?>>
                                                <?= $row->moda_transportasi ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Apakah Punya KIP?</label>
                                    <select name="punya_kip" id="punya_kip" class="form-select select2">
                                        <?php
                                        $punya_kip_val = '';
                                        if (isset($calon_siswa)) {
                                            if (is_array($calon_siswa) && array_key_exists('punya_kip', $calon_siswa)) {
                                                $punya_kip_val = $calon_siswa['punya_kip'];
                                            } elseif (is_object($calon_siswa) && property_exists($calon_siswa, 'punya_kip')) {
                                                $punya_kip_val = $calon_siswa->punya_kip;
                                            }
                                        }
                                        ?>
                                        <option value="" <?= ($punya_kip_val === '' || $punya_kip_val === null) ? 'selected' : '' ?>>-- Pilih --</option>
                                        <option value="1" <?= ((string)$punya_kip_val === '1') ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= ((string)$punya_kip_val === '0') ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor KIP/PKH</label>
                                    <input type="text" name="nomor_kip" id="nomor_kip" class="form-control" placeholder="Nomor KIP/PKH" value="<?= esc($calon_siswa->nomor_kip ?? '') ?>">
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Company Document -->
                    <div style="background: linear-gradient(90deg, #1976d2 0%, #42a5f5 100%); border-radius: 0px; padding: 18px 28px; margin-bottom: 22px; display: flex; align-items: center; box-shadow: 0 2px 8px rgba(25, 118, 210, 0.09);">
                        <i class="mdi mdi-account-group-outline me-3" style="font-size: 1.8em; color: #fff;"></i>
                        <div>
                            <h3 class="mb-1" style="font-size: 1.15rem; font-weight: 700; color: #fff; letter-spacing: 0.5px;">Data Orang Tua</h3>
                            <div style="font-size: 0.85rem; color: #e3f2fd; font-weight: 400;">Lengkapi data ayah dan ibu kandung secara lengkap dan benar.</div>
                        </div>
                    </div>
                    <section>
                        <h5 style="background-color: #f0f8ff; padding: 10px; border-radius: 5px;">A. Ayah Kandung</h5>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="basicpill-pancard-input">Nama Ayah Kandung</label>
                                    <input type="text" name="nama_ayah" class="form-control" placeholder="Nama Ayah" value="<?= esc($calon_siswa->nama_ayah ?? '') ?>">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="basicpill-vatno-input">NIK Ayah</label>
                                    <input type="number" name="nik_ayah" class="form-control" placeholder="NIK Ayah" value="<?= esc($calon_siswa->nik_ayah ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="basicpill-vatno-input">Tahun Lahir</label>
                                    <input type="number" name="tahun_lahir_ayah" class="form-control" placeholder="Tahun Lahir" value="<?= esc($calon_siswa->tahun_lahir_ayah ?? '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="basicpill-cstno-input">Pendidikan</label>
                                    <select name="id_pendidikan_ayah" class="form-select select2" style="max-width:100%; white-space:normal;">
                                        <option value=""> -- Pilih -- </option>
                                        <?php foreach ($pendidikan as $key => $value): ?>
                                            <option value="<?= $value->id_pendidikan ?>" <?= (isset($calon_siswa->id_pendidikan_ayah) && $calon_siswa->id_pendidikan_ayah == $value->id_pendidikan) ? 'selected' : '' ?>> <?= $value->pendidikan ?> </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="basicpill-servicetax-input">Pekerjaan</label>
                                    <select name="id_pekerjaan_ayah" class="form-select select2">
                                        <option value=""> -- Pilih -- </option>
                                        <?php foreach ($pekerjaan as $key => $value): ?>
                                            <option value="<?= $value->id_pekerjaan ?>" <?= (isset($calon_siswa->id_pekerjaan_ayah) && $calon_siswa->id_pekerjaan_ayah == $value->id_pekerjaan) ? 'selected' : '' ?>> <?= $value->nama_pekerjaan ?> </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="basicpill-companyuin-input">Penghasilan Bulanan</label>
                                    <select name="id_penghasilan_bulanan_ayah" class="form-select select2">
                                        <option value=""> -- Pilih -- </option>
                                        <option value="0" <?= (isset($calon_siswa->id_penghasilan_bulanan_ayah) && (string)trim($calon_siswa->id_penghasilan_bulanan_ayah) === '0') ? 'selected' : '' ?>>Tidak Berpenghasilan</option>
                                        <option value="1" <?= (isset($calon_siswa->id_penghasilan_bulanan_ayah) && (string)trim($calon_siswa->id_penghasilan_bulanan_ayah) === '1') ? 'selected' : '' ?>>Kurang dari 500.000</option>
                                        <option value="2" <?= (isset($calon_siswa->id_penghasilan_bulanan_ayah) && (string)trim($calon_siswa->id_penghasilan_bulanan_ayah) === '2') ? 'selected' : '' ?>>500.000 - 999.999</option>
                                        <option value="3" <?= (isset($calon_siswa->id_penghasilan_bulanan_ayah) && (string)trim($calon_siswa->id_penghasilan_bulanan_ayah) === '3') ? 'selected' : '' ?>>1.000.000 - 1.999.999</option>
                                        <option value="4" <?= (isset($calon_siswa->id_penghasilan_bulanan_ayah) && (string)trim($calon_siswa->id_penghasilan_bulanan_ayah) === '4') ? 'selected' : '' ?>>2.000.000 - 4.999.999</option>
                                        <option value="5" <?= (isset($calon_siswa->id_penghasilan_bulanan_ayah) && (string)trim($calon_siswa->id_penghasilan_bulanan_ayah) === '5') ? 'selected' : '' ?>>5.000.000 - 20.000.000</option>
                                        <option value="6" <?= (isset($calon_siswa->id_penghasilan_bulanan_ayah) && (string)trim($calon_siswa->id_penghasilan_bulanan_ayah) === '6') ? 'selected' : '' ?>>Lebih dari 20.000.000</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="basicpill-declaration-input">Berkebutuhan Khusus</label>
                                    <select name="id_kebutuhan_khusus_ayah" class="form-select select2">
                                        <option value=""> -- Pilih -- </option>
                                        <?php foreach ($disability as $key => $value): ?>
                                            <option value="<?= $value->id_disability ?>"
                                                <?php
                                                $selected = false;
                                                if (isset($calon_siswa)) {
                                                    if (isset($calon_siswa->id_kebutuhan_khusus_ayah) && $calon_siswa->id_kebutuhan_khusus_ayah == $value->id_disability) {
                                                        $selected = true;
                                                    } elseif (isset($calon_siswa->id_disability_ayah) && $calon_siswa->id_disability_ayah == $value->id_disability) {
                                                        $selected = true;
                                                    }
                                                }
                                                echo $selected ? 'selected' : '';
                                                ?>> <?= $value->jenis_disability ?> </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <h5 style="background-color: #f0f8ff; padding: 10px; border-radius: 5px;">B. Ibu Kandung</h5>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="basicpill-pancard-input">Nama Ibu Kandung</label>
                                    <input type="text" name="nama_ibu" class="form-control" placeholder="Nama Ibu Kandung" value="<?= esc($calon_siswa->nama_ibu ?? '') ?>">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="basicpill-vatno-input">NIK Ibu</label>
                                    <input type="number" name="nik_ibu" class="form-control" placeholder="NIK Ibu" value="<?= esc($calon_siswa->nik_ibu ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="basicpill-vatno-input">Tahun Lahir</label>
                                    <input type="number" name="tahun_lahir_ibu" class="form-control" placeholder="Tahun Lahir" value="<?= esc($calon_siswa->tahun_lahir_ibu ?? '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="basicpill-cstno-input">Pendidikan</label>
                                    <select name="id_pendidikan_ibu" class="form-select select2">
                                        <option value=""> -- Pilih -- </option>
                                        <?php foreach ($pendidikan as $key => $value): ?>
                                            <option value="<?= $value->id_pendidikan ?>" <?= (isset($calon_siswa->id_pendidikan_ibu) && $calon_siswa->id_pendidikan_ibu == $value->id_pendidikan) ? 'selected' : '' ?>> <?= $value->pendidikan ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="basicpill-servicetax-input">Pekerjaan</label>
                                    <select name="id_pekerjaan_ibu" class="form-select select2">
                                        <option value=""> -- Pilih -- </option>
                                        <?php foreach ($pekerjaan as $key => $value): ?>
                                            <option value="<?= $value->id_pekerjaan ?>" <?= (isset($calon_siswa->id_pekerjaan_ibu) && $calon_siswa->id_pekerjaan_ibu == $value->id_pekerjaan) ? 'selected' : '' ?>> <?= $value->nama_pekerjaan ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="basicpill-companyuin-input">Penghasilan Bulanan</label>
                                    <select name="id_penghasilan_bulanan_ibu" class="form-select select2">
                                        <option value=""> -- Pilih -- </option>
                                        <option value="0" <?= (isset($calon_siswa->id_penghasilan_bulanan_ibu) && (string)trim($calon_siswa->id_penghasilan_bulanan_ibu) === '0') ? 'selected' : '' ?>>Tidak Berpenghasilan</option>
                                        <option value="1" <?= (isset($calon_siswa->id_penghasilan_bulanan_ibu) && (string)trim($calon_siswa->id_penghasilan_bulanan_ibu) === '1') ? 'selected' : '' ?>>Kurang dari 500.000</option>
                                        <option value="2" <?= (isset($calon_siswa->id_penghasilan_bulanan_ibu) && (string)trim($calon_siswa->id_penghasilan_bulanan_ibu) === '2') ? 'selected' : '' ?>>500.000 - 999.999</option>
                                        <option value="3" <?= (isset($calon_siswa->id_penghasilan_bulanan_ibu) && (string)trim($calon_siswa->id_penghasilan_bulanan_ibu) === '3') ? 'selected' : '' ?>>1.000.000 - 1.999.999</option>
                                        <option value="4" <?= (isset($calon_siswa->id_penghasilan_bulanan_ibu) && (string)trim($calon_siswa->id_penghasilan_bulanan_ibu) === '4') ? 'selected' : '' ?>>2.000.000 - 4.999.999</option>
                                        <option value="5" <?= (isset($calon_siswa->id_penghasilan_bulanan_ibu) && (string)trim($calon_siswa->id_penghasilan_bulanan_ibu) === '5') ? 'selected' : '' ?>>5.000.000 - 20.000.000</option>
                                        <option value="6" <?= (isset($calon_siswa->id_penghasilan_bulanan_ibu) && (string)trim($calon_siswa->id_penghasilan_bulanan_ibu) === '6') ? 'selected' : '' ?>>Lebih dari 20.000.000</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="basicpill-declaration-input">Berkebutuhan Khusus</label>
                                    <select name="id_kebutuhan_khusus_ibu" class="form-select select2">
                                        <option value=""> -- Pilih -- </option>
                                        <?php foreach ($disability as $key => $value): ?>
                                            <option value="<?= $value->id_disability ?>"
                                                <?php
                                                $selected = false;
                                                if (isset($calon_siswa)) {
                                                    if (isset($calon_siswa->id_kebutuhan_khusus_ibu) && $calon_siswa->id_kebutuhan_khusus_ibu == $value->id_disability) {
                                                        $selected = true;
                                                    } elseif (isset($calon_siswa->id_disability_ibu) && $calon_siswa->id_disability_ibu == $value->id_disability) {
                                                        $selected = true;
                                                    }
                                                }
                                                echo $selected ? 'selected' : '';
                                                ?>> <?= $value->jenis_disability ?> </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Bank Details -->
                    <div style="background: linear-gradient(90deg, #f9a825 0%, #ffd54f 100%); border-radius: 0px; padding: 18px 28px; margin-bottom: 22px; display: flex; align-items: center; box-shadow: 0 2px 8px rgba(249, 168, 37, 0.09);">
                        <i class="mdi mdi-phone-outline me-3" style="font-size: 1.8em; color: #fff;"></i>
                        <div>
                            <h3 class="mb-1" style="font-size: 1.15rem; font-weight: 700; color: #fff; letter-spacing: 0.5px;">Kontak</h3>
                            <div style="font-size: 0.85rem; color: #fffde7; font-weight: 400;">Masukkan nomor telepon, HP, dan email aktif yang bisa dihubungi.</div>
                        </div>
                    </div>
                    <h3 class="d-none">Kontak</h3>
                    <section>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="kontak-telepon">Nomor Telephone</label>
                                <input type="text" class="form-control" name="no_telepon_rumah" id="kontak-telepon" placeholder="Nomor Telepon" value="<?= esc($calon_siswa->no_telepon_rumah ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="kontak-hp">Nomor HP</label>
                                <input type="text" class="form-control" name="nomor_hp" placeholder="Nomor HP" value="<?= esc($calon_siswa->nomor_hp ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="kontak-email">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" value="<?= esc($calon_siswa->email ?? '') ?>">
                            </div>
                        </div>
                        <div class="text-end"></div>
                    </section>
                    <!-- Bank Details -->
                    <div style="background: linear-gradient(90deg, #6a1b9a 0%, #ba68c8 100%); border-radius: 0px; padding: 18px 28px; margin-bottom: 22px; display: flex; align-items: center; box-shadow: 0 2px 8px rgba(106, 27, 154, 0.09);">
                        <i class="mdi mdi-school-outline me-3" style="font-size: 1.8em; color: #fff;"></i>
                        <div>
                            <h3 class="mb-1" style="font-size: 1.15rem; font-weight: 700; color: #fff; letter-spacing: 0.5px;">Asal Sekolah</h3>
                            <div style="font-size: 0.85rem; color: #f3e5f5; font-weight: 400;">Isi data sekolah asal peserta didik.</div>
                        </div>
                    </div>
                    <h3 class="d-none">Asal Sekolah</h3>
                    <section>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="status-pendaftaran">Status Pendaftaran</label>
                                <select name="status_pendaftaran" class="form-select select2" required>
                                    <option value="">-- Pilih Status Pendaftaran --</option>
                                    <option value="baru" <?= (isset($calon_siswa) && isset($calon_siswa->status_pendaftaran) && trim(strtolower($calon_siswa->status_pendaftaran)) == 'baru') ? 'selected' : '' ?>>Siswa Baru</option>
                                    <option value="pindahan" <?= (isset($calon_siswa) && isset($calon_siswa->status_pendaftaran) && trim(strtolower($calon_siswa->status_pendaftaran)) == 'pindahan') ? 'selected' : '' ?>>Pindahan</option>
                                    <option value="kembali" <?= (isset($calon_siswa) && isset($calon_siswa->status_pendaftaran) && trim(strtolower($calon_siswa->status_pendaftaran)) == 'kembali') ? 'selected' : '' ?>>Kembali Bersekolah</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="asal-sekolah">Asal Sekolah</label>
                                <input type="text" class="form-control" name="sekolah_asal" placeholder="Asal Sekolah" value="<?= esc($calon_siswa->sekolah_asal ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="asal-npsn">NPSN</label>
                                <input type="text" class="form-control" name="npsn_asal" placeholder="NPSN" value="<?= esc($calon_siswa->npsn_asal ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="asal-alamat">Alamat</label>
                                <input type="text" class="form-control" name="alamat_sekolah_asal" placeholder="Alamat Sekolah" value="<?= esc($calon_siswa->alamat_sekolah_asal ?? '') ?>">
                            </div>
                        </div>
                        <div class="text-end"></div>
                        <button type="button" id="btn-modal-konfirmasi" class="btn btn-success mt-3">Konfirmasi &amp; Simpan</button>
                    </section>
                    <!-- Modal Konfirmasi -->
                    <div class="modal fade" id="modalKonfirmasiFinal" tabindex="-1" aria-labelledby="modalKonfirmasiFinalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalKonfirmasiFinalLabel">Konfirmasi Penyimpanan Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center mb-3">
                                        <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                                    </div>
                                    <h5 class="mb-2">Pernyataan</h5>
                                    <p class="text-muted">Saya menyatakan bahwa data yang dimasukkan sudah sesuai dan benar, kesalahan pada penginputan tidak dapat diubah kembali.</p>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Pastikan seluruh data sudah benar sebelum disimpan!
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" id="btn-submit-final" class="btn btn-success">Simpan &amp; Kirim</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>

                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
</div> <!-- container-fluid -->
</div>
<!-- jQuery (CDN) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 CSS & JS (CDN) -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Samakan tinggi, font, style, dan lebar Select2 dengan .form-control Bootstrap 5 dan pastikan width mengikuti parent (col-lg-6) */
    .select2-container {
        width: 100% !important;
        min-width: 0 !important;
        max-width: 100% !important;
        display: block;
    }

    .select2-container .select2-selection--single {
        height: 36px !important;
        min-height: 36px !important;
        padding: 0.390rem 0.75rem;
        border-radius: 0.369rem;
        border: 1px solid #ced4da;
        font-size: 1rem !important;
        /* Bootstrap 5 .form-control */
        line-height: 1.5 !important;
        font-family: var(--bs-body-font-family, 'Public Sans', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', 'Liberation Sans', sans-serif) !important;
        background-color: #fff !important;
        box-shadow: none !important;
        width: 100% !important;
        min-width: 0 !important;
        max-width: 100% !important;
        display: flex;
        align-items: center;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 2.0 !important;
        padding-left: 0;
        font-size: 13px !important;
        font-family: var(--bs-body-font-family, 'Public Sans', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', 'Liberation Sans', sans-serif) !important;
        color: rgb(60, 60, 60) !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
        right: 10px;
    }

    .select2-container .select2-dropdown,
    .select2-container .select2-results__option {
        font-size: 13px !important;
        font-family: var(--bs-body-font-family, 'Public Sans', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', 'Liberation Sans', sans-serif) !important;
        color: #212529 !important;
    }

    .select2-container--default .select2-selection--single {
        background-color: #fff !important;
        border-color: #ced4da !important;
        box-shadow: none !important;
    }

    .select2-container--default .select2-selection--single:focus {
        border-color: rgb(255, 255, 255) !important;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(111, 169, 255, 0.25) !important;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- jQuery Validate (CDN) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<!-- HAPUS INISIALISASI STEPS DAN FILE FORM-WIZARD.INIT.JS -->
<!-- Pastikan TIDAK ada script form-wizard.init.js di-include di halaman ini! -->
<script>
    $(document).ready(function() {
        function toggleNomorKip() {
            var val = $("#punya_kip").val();
            if (val === "1") {
                $("#nomor_kip").prop("disabled", false);
            } else {
                $("#nomor_kip").prop("disabled", true).val("");
            }
        }
        toggleNomorKip();
        $(document).on('change', '#punya_kip', toggleNomorKip);
    });
</script>
<script>
    $(document).ready(function() {
        // Inisialisasi Select2 untuk semua select yang pakai class select2
        if ($.fn.select2) {
            $('.select2').select2({
                width: '100%'
            });
        }

        // Event tombol Simpan di lembar konfirmasi (buka modal)
        $(document).on('click', '#btn-modal-konfirmasi', function() {
            // Validasi seluruh field required sebelum buka modal konfirmasi
            var form = $('#basic-form-spmb');
            var valid = true;
            // Cek semua input/select/textarea required yang terlihat di step aktif
            var $currentSection = form.find('section:visible');
            if ($currentSection.length === 0) {
                // Jika tidak pakai steps, validasi semua
                $currentSection = form;
            }
            $currentSection.find('input[required], select[required], textarea[required]').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    valid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            if (!valid) {
                // Scroll ke field pertama yang error
                var $firstInvalid = $currentSection.find('.is-invalid').first();
                if ($firstInvalid.length) {
                    $('html, body').animate({
                        scrollTop: $firstInvalid.offset().top - 100
                    }, 400);
                }
                return;
            }
            $('#modalKonfirmasiFinal').modal('show');
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Validasi sebelum submit (hanya validasi, tidak submit manual)
        $(document).on('submit', '#basic-form-spmb', function(e) {
            var form = $(this);
            var valid = true;
            form.find('input[required], select[required], textarea[required]').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    valid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            if (!valid) {
                var $firstInvalid = form.find('.is-invalid').first();
                if ($firstInvalid.length) {
                    $('html, body').animate({
                        scrollTop: $firstInvalid.offset().top - 100
                    }, 400);
                }
                $('#modalKonfirmasiFinal').modal('hide');
                e.preventDefault();
                return false;
            }
            $('#btn-submit-final').prop('disabled', true).text('Menyimpan...');
            // Tidak ada submit manual di sini!
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Menggunakan API wilayah Indonesia dari ibnux (data terbaru 2025, lebih lengkap dan stabil)
        const BASE_API_URL = 'https://ibnux.github.io/data-indonesia';

        // Variabel untuk menyimpan nilai yang sudah dipilih sebelumnya (dari edit data)
        var selectedProvinsi = '<?= isset($calon_siswa) ? ($calon_siswa->provinsi ?? "") : "" ?>';
        var selectedKabupaten = '<?= isset($calon_siswa) ? ($calon_siswa->kabupaten ?? "") : "" ?>';
        var selectedKecamatan = '<?= isset($calon_siswa) ? ($calon_siswa->kecamatan ?? "") : "" ?>';
        var selectedKelurahan = '<?= isset($calon_siswa) ? ($calon_siswa->kelurahan ?? "") : "" ?>';

        // Load provinsi
        console.log('Loading provinces from ibnux API...');
        fetch(`${BASE_API_URL}/provinsi.json`)
            .then(res => {
                console.log('Provinces API response status:', res.status);
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                return res.json();
            })
            .then(function(data) {
                console.log('Provinces data received:', data);
                var provinsiSelect = $('#select-provinsi');
                provinsiSelect.html('<option value="">-- Pilih Provinsi --</option>');
                data.forEach(function(item) {
                    var isSelected = (selectedProvinsi == item.id || selectedProvinsi == item.nama) ? 'selected' : '';
                    provinsiSelect.append('<option value="' + item.nama + '" data-id="' + item.id + '" ' + isSelected + '>' + item.nama + '</option>');
                });
                console.log('Successfully loaded', data.length, 'provinces');

                // Jika ada provinsi yang terpilih, load kabupaten
                if (selectedProvinsi) {
                    provinsiSelect.trigger('change');
                }
            })
            .catch(error => {
                console.error('Error loading provinces:', error);
                $('#select-provinsi').append('<option value="">Error loading data - Refresh halaman</option>');
            });

        // Load kabupaten/kota saat provinsi dipilih
        $('#select-provinsi').on('change', function() {
            var provCode = $(this).find('option:selected').data('id');
            var provName = $(this).find('option:selected').text();
            var kabupatenSelect = $('#select-kabupaten');
            kabupatenSelect.html('<option value="">-- Memuat kabupaten/kota... --</option>');
            $('#select-kecamatan').html('<option value="">-- Pilih Kecamatan --</option>');
            $('#select-kelurahan').html('<option value="">-- Pilih Kelurahan/Desa --</option>');

            if (provCode) {
                console.log('Loading regencies for province:', provName, '(Code:', provCode + ')');
                fetch(`${BASE_API_URL}/kabupaten/${provCode}.json`)
                    .then(res => {
                        console.log('Regencies API response status:', res.status, 'for province:', provName);
                        if (!res.ok) {
                            throw new Error(`HTTP error! status: ${res.status}`);
                        }
                        return res.json();
                    })
                    .then(function(data) {
                        console.log('Regencies data received for', provName + ':', data);
                        kabupatenSelect.html('<option value="">-- Pilih Kabupaten/Kota --</option>');
                        data.forEach(function(item) {
                            var isSelected = (selectedKabupaten == item.id || selectedKabupaten == item.nama) ? 'selected' : '';
                            kabupatenSelect.append('<option value="' + item.nama + '" data-id="' + item.id + '" ' + isSelected + '>' + item.nama + '</option>');
                        });
                        console.log('Successfully loaded', data.length, 'regencies for', provName);

                        // Jika ada kabupaten yang terpilih, load kecamatan
                        if (selectedKabupaten) {
                            kabupatenSelect.trigger('change');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading regencies for', provName + ':', error);
                        kabupatenSelect.html('<option value="">-- Pilih Kabupaten/Kota --</option>');
                        kabupatenSelect.append('<option value="">Error loading data - Coba lagi</option>');
                    });
            }
        });

        // Load kecamatan saat kabupaten dipilih
        $('#select-kabupaten').on('change', function() {
            var kabCode = $(this).find('option:selected').data('id');
            var kabName = $(this).find('option:selected').text();
            var kecamatanSelect = $('#select-kecamatan');
            kecamatanSelect.html('<option value="">-- Memuat kecamatan... --</option>');
            $('#select-kelurahan').html('<option value="">-- Pilih Kelurahan/Desa --</option>');

            if (kabCode) {
                console.log('Loading districts for regency:', kabName, '(Code:', kabCode + ')');
                fetch(`${BASE_API_URL}/kecamatan/${kabCode}.json`)
                    .then(res => {
                        console.log('Districts API response status:', res.status, 'for regency:', kabName);
                        if (!res.ok) {
                            throw new Error(`HTTP error! status: ${res.status}`);
                        }
                        return res.json();
                    })
                    .then(function(data) {
                        console.log('Districts data received for', kabName + ':', data);
                        kecamatanSelect.html('<option value="">-- Pilih Kecamatan --</option>');
                        data.forEach(function(item) {
                            var isSelected = (selectedKecamatan == item.id || selectedKecamatan == item.nama) ? 'selected' : '';
                            kecamatanSelect.append('<option value="' + item.nama + '" data-id="' + item.id + '" ' + isSelected + '>' + item.nama + '</option>');
                        });
                        console.log('Successfully loaded', data.length, 'districts for', kabName);

                        // Jika ada kecamatan yang terpilih, load kelurahan
                        if (selectedKecamatan) {
                            kecamatanSelect.trigger('change');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading districts for', kabName + ':', error);
                        kecamatanSelect.html('<option value="">-- Pilih Kecamatan --</option>');
                        kecamatanSelect.append('<option value="">Error loading data - Coba lagi</option>');
                    });
            }
        });

        // Load kelurahan/desa saat kecamatan dipilih
        $('#select-kecamatan').on('change', function() {
            var kecCode = $(this).find('option:selected').data('id');
            var kecName = $(this).find('option:selected').text();
            var kelurahanSelect = $('#select-kelurahan');
            kelurahanSelect.html('<option value="">-- Memuat kelurahan/desa... --</option>');

            if (kecCode) {
                console.log('Loading villages for district:', kecName, '(Code:', kecCode + ')');

                // Tambahkan timeout untuk mencegah request terlalu lama
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 15000); // 15 detik timeout

                fetch(`${BASE_API_URL}/kelurahan/${kecCode}.json`, {
                        signal: controller.signal
                    })
                    .then(res => {
                        clearTimeout(timeoutId);
                        console.log('Villages API response status:', res.status, 'for district:', kecName);
                        if (!res.ok) {
                            throw new Error(`HTTP error! status: ${res.status}`);
                        }
                        return res.json();
                    })
                    .then(function(data) {
                        console.log('Villages data received for', kecName + ':', data);
                        kelurahanSelect.html('<option value="">-- Pilih Kelurahan/Desa --</option>');

                        if (data && Array.isArray(data) && data.length > 0) {
                            data.forEach(function(item) {
                                var isSelected = (selectedKelurahan == item.nama) ? 'selected' : '';
                                kelurahanSelect.append('<option value="' + item.nama + '" ' + isSelected + '>' + item.nama + '</option>');
                            });
                            console.log('Successfully loaded', data.length, 'villages for', kecName);

                            // Tambahkan opsi manual input di akhir
                            kelurahanSelect.append('<option value="manual">-- Input Manual (Jika tidak ditemukan) --</option>');

                            // Jika ada kelurahan yang dipilih sebelumnya tapi tidak ada di data API, tambahkan sebagai opsi
                            if (selectedKelurahan && selectedKelurahan !== 'manual' && !kelurahanSelect.find('option[value="' + selectedKelurahan + '"]').length) {
                                kelurahanSelect.append('<option value="' + selectedKelurahan + '" selected>' + selectedKelurahan + ' (Manual)</option>');
                            }
                        } else {
                            console.warn('No villages found for district:', kecName, '(Code:', kecCode + ')');
                            kelurahanSelect.html('<option value="">-- Pilih Kelurahan/Desa --</option>');
                            kelurahanSelect.append('<option value="">Tidak ada data kelurahan/desa tersedia</option>');
                            kelurahanSelect.append('<option value="manual">-- Input Manual di Alamat --</option>');

                            // Jika ada kelurahan yang dipilih sebelumnya, tambahkan sebagai opsi manual
                            if (selectedKelurahan && selectedKelurahan !== 'manual') {
                                kelurahanSelect.append('<option value="' + selectedKelurahan + '" selected>' + selectedKelurahan + ' (Manual)</option>');
                            }
                        }
                    })
                    .catch(error => {
                        clearTimeout(timeoutId);
                        console.error('Error loading villages for', kecName + ':', error);
                        kelurahanSelect.html('<option value="">-- Pilih Kelurahan/Desa --</option>');

                        if (error.name === 'AbortError') {
                            console.warn('Request timeout for villages in', kecName);
                            kelurahanSelect.append('<option value="">Timeout - Jaringan lambat</option>');
                        } else {
                            kelurahanSelect.append('<option value="">Error loading data</option>');
                        }

                        kelurahanSelect.append('<option value="manual">-- Input Manual di Alamat --</option>');

                        // Jika ada kelurahan yang dipilih sebelumnya, tambahkan sebagai opsi manual
                        if (selectedKelurahan && selectedKelurahan !== 'manual') {
                            kelurahanSelect.append('<option value="' + selectedKelurahan + '" selected>' + selectedKelurahan + ' (Manual)</option>');
                        }
                    });
            }
        });
    });
</script>
<?= $this->endSection() ?>