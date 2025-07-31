<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Update Gawe &mdash; yukNikah</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->

        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                <div class="d-flex align-items-center">
                    <a href="javascript:history.back()" class="btn btn-sm btn-primary waves-effect waves-light bg-gradient me-3"><i class="mdi mdi-arrow-left"></i> Back</a>
                    <h4 class="mb-sm-0 font-size-18">Tambah Peserta Didik Baru</h4>
                </div>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                        <li class="breadcrumb-item active">Form Wizard</li>
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

                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                        <h4 class="card-title mb-0">Formulir Siswa Baru</h4>
                    </div>

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

                    <?php if (!isset($tahun_aktif->id_tahun) || empty($tahun_aktif->id_tahun)): ?>
                        <div class="alert alert-danger mt-4">
                            <strong>Perhatian!</strong> Tahun penerimaan aktif belum diatur atau tidak ditemukan.<br>
                            Silakan hubungi admin/operator untuk mengaktifkan tahun penerimaan sebelum melakukan pendaftaran.<br>
                            <span class="text-danger">Formulir pendaftaran dinonaktifkan.</span>
                        </div>
                    <?php else: ?>
                        <form id="basic-form-spmb" action="<?= site_url('calon_siswa') ?>" method="post">
                            <?= csrf_field() ?>

                            <!-- Jalur Pendaftaran -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                                        <h5 class="mb-3 mb-md-0">Pilih Jalur Pendaftaran</h5>
                                        <div class="ms-0 ms-md-3 mt-3 mt-md-0">
                                            <div class="btn-group" role="group" aria-label="Jalur Pendaftaran">
                                                <input type="radio" class="btn-check" name="jalur" id="jalur-zonasi" value="zonasi" autocomplete="off" required <?= (old('jalur') == 'zonasi' || (isset($calon_siswa) && $calon_siswa->jalur == 'zonasi')) ? 'checked' : '' ?>>
                                                <label class="btn btn-outline-primary" for="jalur-zonasi"><i class="mdi mdi-map-marker-radius-outline me-1"></i> Zonasi</label>

                                                <input type="radio" class="btn-check" name="jalur" id="jalur-afirmasi" value="afirmasi" autocomplete="off" required <?= (old('jalur') == 'afirmasi' || (isset($calon_siswa) && $calon_siswa->jalur == 'afirmasi')) ? 'checked' : '' ?>>
                                                <label class="btn btn-outline-success" for="jalur-afirmasi"><i class="mdi mdi-account-group-outline me-1"></i> Afirmasi</label>

                                                <input type="radio" class="btn-check" name="jalur" id="jalur-prestasi" value="prestasi" autocomplete="off" required <?= (old('jalur') == 'prestasi' || (isset($calon_siswa) && $calon_siswa->jalur == 'prestasi')) ? 'checked' : '' ?>>
                                                <label class="btn btn-outline-warning" for="jalur-prestasi"><i class="mdi mdi-star-outline me-1"></i> Prestasi</label>

                                                <input type="radio" class="btn-check" name="jalur" id="jalur-mutasi" value="mutasi" autocomplete="off" required <?= (old('jalur') == 'mutasi' || (isset($calon_siswa) && $calon_siswa->jalur == 'mutasi')) ? 'checked' : '' ?>>
                                                <label class="btn btn-outline-info" for="jalur-mutasi"><i class="mdi mdi-swap-horizontal me-1"></i> Mutasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback d-block" id="jalur-invalid-feedback" style="display:none;">Pilih salah satu jalur pendaftaran.</div>
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
                                                <div>
                                                    <strong>Tahun Penerimaan :</strong>
                                                    <span class="fw-bold text-success" style="font-size:1.1em; letter-spacing:1px;">
                                                        <?= isset($tahun_aktif->tahun_pelajaran) ? esc($tahun_aktif->tahun_pelajaran) : (isset($calon_siswa->tahun_pelajaran_penerimaan) ? esc($calon_siswa->tahun_pelajaran_penerimaan) : '-') ?>
                                                    </span>
                                                    <input type="hidden" name="id_tahun" value="<?= isset($calon_siswa->id_tahun) ? esc($calon_siswa->id_tahun) : (isset($tahun_aktif->id_tahun) ? esc($tahun_aktif->id_tahun) : '') ?>" required>
                                                </div>
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
                                            <input type="text" name="nama_peserta" id="nama_peserta" class="form-control" placeholder="Nama Lengkap" required value="<?= old('nama_peserta') ?: (esc($calon_siswa->nama_peserta ?? '')) ?>">
                                            <div class="invalid-feedback" id="nama_peserta-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">NISN <span class="text-danger">*</span></label>
                                            <input type="number" name="nisn" class="form-control" placeholder="NISN" value="<?= old('nisn') ?: (esc($calon_siswa->nisn ?? '')) ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select select2" required>
                                                <option value disabled <?= (empty(old('jenis_kelamin')) && empty($calon_siswa->jenis_kelamin ?? '')) ? 'selected' : '' ?>>-- Pilih Jenis Kelamin --</option>
                                                <option value="L" <?= (old('jenis_kelamin') == 'L' || (isset($calon_siswa) && $calon_siswa->jenis_kelamin == 'L')) ? 'selected' : '' ?>>Laki-laki</option>
                                                <option value="P" <?= (old('jenis_kelamin') == 'P' || (isset($calon_siswa) && $calon_siswa->jenis_kelamin == 'P')) ? 'selected' : '' ?>>Perempuan</option>
                                            </select>
                                            <div class="invalid-feedback" id="jenis_kelamin-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">NIK/ No. KITAS (Untuk WNA) <span class="text-danger">*</span></label>
                                            <input type="number" name="nik" id="nik" class="form-control" placeholder="NIK/No KITAS (Untuk WNA)" required value="<?= old('nik') ?: (esc($calon_siswa->nik ?? '')) ?>">
                                            <div class="invalid-feedback" id="nik-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">Nomor KK</label>
                                            <input type="text" name="nomor_kk" class="form-control" placeholder="Nomor KK" value="<?= old('nomor_kk') ?: (esc($calon_siswa->nomor_kk ?? '')) ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" placeholder="Tempat Lahir" required value="<?= old('tempat_lahir') ?: (esc($calon_siswa->tempat_lahir ?? '')) ?>">
                                            <div class="invalid-feedback" id="tempat_lahir-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required value="<?= old('tanggal_lahir') ?: (esc($calon_siswa->tanggal_lahir ?? '')) ?>">
                                            <div class="invalid-feedback" id="tanggal_lahir-error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Agama</label>
                                            <select name="id_agama" class="form-select select2">
                                                <option value="">-- Pilih Agama --</option>
                                                <?php if (isset($agama) && is_array($agama)): ?>
                                                    <?php foreach ($agama as $key => $value): ?>
                                                        <option value="<?= $value->id_agama ?>"
                                                            <?= (old('id_agama') == $value->id_agama || (isset($calon_siswa) && $calon_siswa->id_agama == $value->id_agama)) ? 'selected' : '' ?>>
                                                            <?= $value->agama ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label">Kewarganegaraan</label>
                                            <select name="kewarganegaraan" class="form-select select2">
                                                <option value="">-- Pilih Kewarganegaraan --</option>
                                                <option value="WNI" <?= (old('kewarganegaraan') == 'WNI' || (isset($calon_siswa) && $calon_siswa->kewarganegaraan == 'WNI')) ? 'selected' : '' ?>>WNI</option>
                                                <option value="WNA" <?= (old('kewarganegaraan') == 'WNA' || (isset($calon_siswa) && $calon_siswa->kewarganegaraan == 'WNA')) ? 'selected' : '' ?>>WNA</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label">Anak Ke</label>
                                            <input
                                                type="text"
                                                name="anak_ke"
                                                class="form-control"
                                                placeholder="1"
                                                pattern="[0-9]*"
                                                inputmode="numeric"
                                                maxlength="2"
                                                value="<?= old('anak_ke') ?: (esc($calon_siswa->anak_ke ?? '')) ?>"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0,2); if(parseInt(this.value) > 20) this.value = '20'; if(parseInt(this.value) < 1 && this.value !== '') this.value = '1';">
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
                                                            <?= (old('id_kebutuhan_khusus') == $value->id_disability || (isset($calon_siswa) && $calon_siswa->id_kebutuhan_khusus == $value->id_disability)) ? 'selected' : '' ?>>
                                                            <?= $value->jenis_disability ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nomor Akta Kelahiran</label>
                                            <input
                                                type="text"
                                                name="nomor_akta_kelahiran"
                                                class="form-control"
                                                placeholder="Nomor Akta Kelahiran"
                                                value="<?= old('nomor_akta_kelahiran') ?: (esc($calon_siswa->nomor_akta_kelahiran ?? '')) ?>">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                            <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat Lengkap" required><?= old('alamat') ?: (esc($calon_siswa->alamat ?? '')) ?></textarea>
                                            <div class="invalid-feedback" id="alamat-error"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Alamat Domisili (Provinsi, Kabupaten/Kota, Kecamatan, Kelurahan/Desa dalam satu baris) -->
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="select-provinsi" class="form-label">Provinsi</label>
                                            <select id="select-provinsi" name="provinsi" class="form-select select2" required>
                                                <option value="">-- Pilih Provinsi --</option>
                                            </select>
                                            <div class="invalid-feedback" id="provinsi-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="select-kabupaten" class="form-label">Kabupaten/Kota</label>
                                            <select id="select-kabupaten" name="kabupaten" class="form-select select2" required>
                                                <option value="">-- Pilih Kabupaten/Kota --</option>
                                            </select>
                                            <div class="invalid-feedback" id="kabupaten-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="select-kecamatan" class="form-label">Kecamatan</label>
                                            <select id="select-kecamatan" name="kecamatan" class="form-select select2" required>
                                                <option value="">-- Pilih Kecamatan --</option>
                                            </select>
                                            <div class="invalid-feedback" id="kecamatan-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="select-kelurahan" class="form-label">Kelurahan/Desa</label>
                                            <select id="select-kelurahan" name="kelurahan" class="form-select select2" required>
                                                <option value="">-- Pilih Kelurahan/Desa --</option>
                                            </select>
                                            <div class="invalid-feedback" id="kelurahan-error"></div>
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
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label">RT</label>
                                            <input type="text" name="rt" class="form-control" placeholder="RT" value="<?= esc($calon_siswa->rt ?? '') ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label">RW</label>
                                            <input type="text" name="rw" class="form-control" placeholder="RW" value="<?= esc($calon_siswa->rw ?? '') ?>">
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
                                                        <?= (old('id_tinggal') == $row->id_tempat_tinggal || (isset($calon_siswa) && $calon_siswa->id_tinggal == $row->id_tempat_tinggal)) ? 'selected' : '' ?>>
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
                                                        <?= (old('id_transportasi') == $row->id_transportasi || (isset($calon_siswa) && $calon_siswa->id_transportasi == $row->id_transportasi)) ? 'selected' : '' ?>>
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
                                                <option value="">-- Pilih --</option>
                                                <option value="1" <?= (old('punya_kip') == '1' || (isset($calon_siswa) && $calon_siswa->punya_kip == '1')) ? 'selected' : '' ?>>Ya</option>
                                                <option value="0" <?= (old('punya_kip') == '0' || (isset($calon_siswa) && $calon_siswa->punya_kip == '0')) ? 'selected' : '' ?>>Tidak</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nomor KIP/PKH</label>
                                            <input type="text" name="nomor_kip" id="nomor_kip" class="form-control" placeholder="Nomor KIP/PKH" value="<?= old('nomor_kip') ?: (esc($calon_siswa->nomor_kip ?? '')) ?>">
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
                                            <input type="text" name="nama_ayah" class="form-control" placeholder="Nama Ayah" value="<?= old('nama_ayah') ?: (esc($calon_siswa->nama_ayah ?? '')) ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="basicpill-vatno-input">NIK Ayah</label>
                                            <input type="number" name="nik_ayah" class="form-control" placeholder="NIK Ayah" value="<?= old('nik_ayah') ?: (esc($calon_siswa->nik_ayah ?? '')) ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="basicpill-vatno-input">Tahun Lahir</label>
                                            <input type="number" name="tahun_lahir_ayah" class="form-control" placeholder="Tahun Lahir" value="<?= old('tahun_lahir_ayah') ?: (esc($calon_siswa->tahun_lahir_ayah ?? '')) ?>">
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
                                                    <option value="<?= $value->id_pendidikan ?>"
                                                        <?= (old('id_pendidikan_ayah') == $value->id_pendidikan || (isset($calon_siswa) && $calon_siswa->id_pendidikan_ayah == $value->id_pendidikan)) ? 'selected' : '' ?>>
                                                        <?= $value->pendidikan ?>
                                                    </option>
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
                                                    <option value="<?= $value->id_pekerjaan ?>"
                                                        <?= (old('id_pekerjaan_ayah') == $value->id_pekerjaan || (isset($calon_siswa) && $calon_siswa->id_pekerjaan_ayah == $value->id_pekerjaan)) ? 'selected' : '' ?>>
                                                        <?= $value->nama_pekerjaan ?>
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
                                            <select name="id_penghasilan_ayah" class="form-select select2">
                                                <option value=""> -- Pilih -- </option>
                                                <option value="0" <?= (old('id_penghasilan_ayah') == '0' || (isset($calon_siswa) && $calon_siswa->id_penghasilan_ayah == '0')) ? 'selected' : '' ?>>Tidak Berpenghasilan</option>
                                                <option value="1" <?= (old('id_penghasilan_ayah') == '1' || (isset($calon_siswa) && $calon_siswa->id_penghasilan_ayah == '1')) ? 'selected' : '' ?>>Kurang dari 500.000</option>
                                                <option value="2" <?= (old('id_penghasilan_ayah') == '2' || (isset($calon_siswa) && $calon_siswa->id_penghasilan_ayah == '2')) ? 'selected' : '' ?>>500.000 - 999.999</option>
                                                <option value="3" <?= (old('id_penghasilan_ayah') == '3' || (isset($calon_siswa) && $calon_siswa->id_penghasilan_ayah == '3')) ? 'selected' : '' ?>>1.000.000 - 1.999.999</option>
                                                <option value="4" <?= (old('id_penghasilan_ayah') == '4' || (isset($calon_siswa) && $calon_siswa->id_penghasilan_ayah == '4')) ? 'selected' : '' ?>>2.000.000 - 4.999.999</option>
                                                <option value="5" <?= (old('id_penghasilan_ayah') == '5' || (isset($calon_siswa) && $calon_siswa->id_penghasilan_ayah == '5')) ? 'selected' : '' ?>>5.000.000 - 20.000.000</option>
                                                <option value="6" <?= (old('id_penghasilan_ayah') == '6' || (isset($calon_siswa) && $calon_siswa->id_penghasilan_ayah == '6')) ? 'selected' : '' ?>>Lebih dari 20.000.000</option>
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
                                                        <?= (old('id_kebutuhan_khusus_ayah') == $value->id_disability || (isset($calon_siswa) && $calon_siswa->id_kebutuhan_khusus_ayah == $value->id_disability)) ? 'selected' : '' ?>>
                                                        <?= $value->jenis_disability ?>
                                                    </option>
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
                                            <input type="text" name="nama_ibu" class="form-control" placeholder="Nama Ibu Kandung" value="<?= old('nama_ibu') ?: (esc($calon_siswa->nama_ibu ?? '')) ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="basicpill-vatno-input">NIK Ibu</label>
                                            <input type="number" name="nik_ibu" class="form-control" placeholder="NIK Ibu" value="<?= old('nik_ibu') ?: (esc($calon_siswa->nik_ibu ?? '')) ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="basicpill-vatno-input">Tahun Lahir</label>
                                            <input type="number" name="tahun_lahir_ibu" class="form-control" placeholder="Tahun Lahir" value="<?= old('tahun_lahir_ibu') ?: (esc($calon_siswa->tahun_lahir_ibu ?? '')) ?>">
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
                                                    <option value="<?= $value->id_pendidikan ?>"
                                                        <?= (old('id_pendidikan_ibu') == $value->id_pendidikan || (isset($calon_siswa) && $calon_siswa->id_pendidikan_ibu == $value->id_pendidikan)) ? 'selected' : '' ?>>
                                                        <?= $value->pendidikan ?>
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
                                                    <option value="<?= $value->id_pekerjaan ?>"
                                                        <?= (old('id_pekerjaan_ibu') == $value->id_pekerjaan || (isset($calon_siswa) && $calon_siswa->id_pekerjaan_ibu == $value->id_pekerjaan)) ? 'selected' : '' ?>>
                                                        <?= $value->nama_pekerjaan ?>
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
                                            <select name="id_penghasilan_ibu" class="form-select select2">
                                                <option value=""> -- Pilih -- </option>
                                                <option value="0" <?= (old('id_penghasilan_ibu') == '0' || (isset($calon_siswa) && $calon_siswa->id_penghasilan_ibu == '0')) ? 'selected' : '' ?>>Tidak Berpenghasilan</option>
                                                <option value="1" <?= (old('id_penghasilan_ibu') == '1' || (isset($calon_siswa) && $calon_siswa->id_penghasilan_ibu == '1')) ? 'selected' : '' ?>>Kurang dari 500.000</option>
                                                <option value="2" <?= (old('id_penghasilan_ibu') == '2' || (isset($calon_siswa) && $calon_siswa->id_penghasilan_ibu == '2')) ? 'selected' : '' ?>>500.000 - 999.999</option>
                                                <option value="3" <?= (old('id_penghasilan_ibu') == '3' || (isset($calon_siswa) && $calon_siswa->id_penghasilan_ibu == '3')) ? 'selected' : '' ?>>1.000.000 - 1.999.999</option>
                                                <option value="4" <?= (old('id_penghasilan_ibu') == '4' || (isset($calon_siswa) && $calon_siswa->id_penghasilan_ibu == '4')) ? 'selected' : '' ?>>2.000.000 - 4.999.999</option>
                                                <option value="5" <?= (old('id_penghasilan_ibu') == '5' || (isset($calon_siswa) && $calon_siswa->id_penghasilan_ibu == '5')) ? 'selected' : '' ?>>5.000.000 - 20.000.000</option>
                                                <option value="6" <?= (old('id_penghasilan_ibu') == '6' || (isset($calon_siswa) && $calon_siswa->id_penghasilan_ibu == '6')) ? 'selected' : '' ?>>Lebih dari 20.000.000</option>
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
                                                        <?= (old('id_kebutuhan_khusus_ibu') == $value->id_disability || (isset($calon_siswa) && $calon_siswa->id_kebutuhan_khusus_ibu == $value->id_disability)) ? 'selected' : '' ?>>
                                                        <?= $value->jenis_disability ?>
                                                    </option>
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
                                        <input type="text" class="form-control" name="no_telepon_rumah" id="kontak-telepon" placeholder="Nomor Telepon" value="<?= old('no_telepon_rumah') ?: (esc($calon_siswa->no_telepon_rumah ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="kontak-hp">Nomor HP <span class="text-muted">(untuk notifikasi pendaftaran)</span></label>
                                        <input type="text" class="form-control" name="nomor_hp" placeholder="Contoh: 08123456789" value="<?= old('nomor_hp') ?: (esc($calon_siswa->nomor_hp ?? '')) ?>">
                                        <div class="form-text">
                                            <i class="mdi mdi-information-outline me-1"></i>
                                            Nomor WhatsApp aktif orang tua/wali untuk menerima notifikasi otomatis terkait pendaftaran siswa.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="kontak-email">Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Email" value="<?= old('email') ?: (esc($calon_siswa->email ?? '')) ?>">
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
                                            <option value="baru" <?= (old('status_pendaftaran') == 'baru' || (isset($calon_siswa) && $calon_siswa->status_pendaftaran == 'baru')) ? 'selected' : '' ?>>Siswa Baru</option>
                                            <option value="pindahan" <?= (old('status_pendaftaran') == 'pindahan' || (isset($calon_siswa) && $calon_siswa->status_pendaftaran == 'pindahan')) ? 'selected' : '' ?>>Pindahan</option>
                                            <option value="kembali" <?= (old('status_pendaftaran') == 'kembali' || (isset($calon_siswa) && $calon_siswa->status_pendaftaran == 'kembali')) ? 'selected' : '' ?>>Kembali Bersekolah</option>
                                        </select>
                                        <div class="invalid-feedback" id="status_pendaftaran-error"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="asal-sekolah">Asal Sekolah</label>
                                        <input type="text" class="form-control" name="sekolah_asal" placeholder="Asal Sekolah" value="<?= old('sekolah_asal') ?: (esc($calon_siswa->sekolah_asal ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="asal-npsn">NPSN</label>
                                        <input type="text" class="form-control" name="npsn_asal" placeholder="NPSN" value="<?= old('npsn_asal') ?: (esc($calon_siswa->npsn_asal ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="asal-alamat">Alamat</label>
                                        <input type="text" class="form-control" name="alamat_sekolah_asal" placeholder="Alamat Sekolah" value="<?= old('alamat_sekolah_asal') ?: (esc($calon_siswa->alamat_sekolah_asal ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="text-end"></div>
                                <button type="button" id="btn-modal-konfirmasi" class="btn btn-success mt-3" <?= (!isset($tahun_aktif->id_tahun) || empty($tahun_aktif->id_tahun)) ? ' disabled' : '' ?>>Konfirmasi &amp; Simpan</button>
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
                    <?php endif; ?>

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

    /* Highlight option on hover and selected for all select dropdowns */
    select option:hover,
    select option:focus {
        background: #1976d2 !important;
        color: #fff !important;
    }

    select option:checked {
        background: #1976d2 !important;
        color: #fff !important;
    }

    /* For select2 dropdowns */
    .select2-results__option--highlighted {
        background-color: #1976d2 !important;
        color: #fff !important;
    }

    .select2-results__option[aria-selected=true] {
        background-color: #1976d2 !important;
        color: #fff !important;
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

        // Fungsi validasi form
        function validateForm() {
            let isValid = true;

            // Reset semua error state
            $('.form-control, .form-select').removeClass('is-invalid');
            $('.invalid-feedback').hide();
            $('#jalur-invalid-feedback').hide();

            // Validasi Jalur Pendaftaran
            const jalurSelected = $('input[name="jalur"]:checked').val();
            if (!jalurSelected) {
                $('#jalur-invalid-feedback').text('Jalur pendaftaran wajib dipilih').show();
                isValid = false;
            }

            // Validasi Nama Lengkap
            const nama = $('#nama_peserta').val().trim();
            if (nama === '') {
                $('#nama_peserta').addClass('is-invalid');
                $('#nama_peserta-error').text('Nama lengkap wajib diisi').show();
                isValid = false;
            } else if (nama.length < 3) {
                $('#nama_peserta').addClass('is-invalid');
                $('#nama_peserta-error').text('Nama lengkap minimal 3 karakter').show();
                isValid = false;
            }

            // Validasi Jenis Kelamin
            const jenisKelamin = $('#jenis_kelamin').val();
            if (!jenisKelamin || jenisKelamin === '') {
                $('#jenis_kelamin').addClass('is-invalid');
                $('#jenis_kelamin-error').text('Jenis kelamin wajib dipilih').show();
                isValid = false;
            }

            // Validasi NIK
            const nik = $('#nik').val().trim();
            if (nik === '') {
                $('#nik').addClass('is-invalid');
                $('#nik-error').text('NIK wajib diisi').show();
                isValid = false;
            } else if (nik.length < 16) {
                $('#nik').addClass('is-invalid');
                $('#nik-error').text('NIK harus 16 digit').show();
                isValid = false;
            }

            // Validasi Tempat Lahir
            const tempatLahir = $('#tempat_lahir').val().trim();
            if (tempatLahir === '') {
                $('#tempat_lahir').addClass('is-invalid');
                $('#tempat_lahir-error').text('Tempat lahir wajib diisi').show();
                isValid = false;
            }

            // Validasi Tanggal Lahir
            const tanggalLahir = $('#tanggal_lahir').val();
            if (tanggalLahir === '') {
                $('#tanggal_lahir').addClass('is-invalid');
                $('#tanggal_lahir-error').text('Tanggal lahir wajib diisi').show();
                isValid = false;
            } else {
                // Validasi umur (harus antara 6-18 tahun untuk siswa baru)
                const birthDate = new Date(tanggalLahir);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();

                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                if (age < 6 || age > 18) {
                    $('#tanggal_lahir').addClass('is-invalid');
                    $('#tanggal_lahir-error').text('Umur harus antara 6-18 tahun untuk pendaftaran siswa baru').show();
                    isValid = false;
                }
            }

            // Validasi Alamat
            const alamat = $('#alamat').val().trim();
            if (alamat === '') {
                $('#alamat').addClass('is-invalid');
                $('#alamat-error').text('Alamat lengkap wajib diisi').show();
                isValid = false;
            } else if (alamat.length < 10) {
                $('#alamat').addClass('is-invalid');
                $('#alamat-error').text('Alamat terlalu singkat, minimal 10 karakter').show();
                isValid = false;
            }

            // Validasi Status Pendaftaran
            const statusPendaftaran = $('select[name="status_pendaftaran"]').val();
            if (!statusPendaftaran || statusPendaftaran === '') {
                $('select[name="status_pendaftaran"]').addClass('is-invalid');
                $('#status_pendaftaran-error').text('Status pendaftaran wajib dipilih').show();
                isValid = false;
            }

            // Validasi Provinsi
            const provinsi = $('#select-provinsi').val();
            if (!provinsi || provinsi === '') {
                $('#select-provinsi').addClass('is-invalid');
                $('#provinsi-error').text('Provinsi wajib dipilih').show();
                isValid = false;
            }

            // Validasi Kabupaten
            const kabupaten = $('#select-kabupaten').val();
            if (!kabupaten || kabupaten === '') {
                $('#select-kabupaten').addClass('is-invalid');
                $('#kabupaten-error').text('Kabupaten/Kota wajib dipilih').show();
                isValid = false;
            }

            // Validasi Kecamatan
            const kecamatan = $('#select-kecamatan').val();
            if (!kecamatan || kecamatan === '') {
                $('#select-kecamatan').addClass('is-invalid');
                $('#kecamatan-error').text('Kecamatan wajib dipilih').show();
                isValid = false;
            }

            // Validasi Kelurahan
            const kelurahan = $('#select-kelurahan').val();
            if (!kelurahan || kelurahan === '') {
                $('#select-kelurahan').addClass('is-invalid');
                $('#kelurahan-error').text('Kelurahan/Desa wajib dipilih').show();
                isValid = false;
            }

            // Validasi Nomor HP (opsional tapi jika diisi harus valid)
            const nomorHp = $('input[name="nomor_hp"]').val().trim();
            if (nomorHp !== '' && (nomorHp.length < 10 || nomorHp.length > 15)) {
                $('input[name="nomor_hp"]').addClass('is-invalid');
                if (!$('#nomor_hp-error').length) {
                    $('input[name="nomor_hp"]').after('<div class="invalid-feedback" id="nomor_hp-error"></div>');
                }
                $('#nomor_hp-error').text('Nomor HP harus 10-15 digit').show();
                isValid = false;
            } else {
                $('input[name="nomor_hp"]').removeClass('is-invalid');
                $('#nomor_hp-error').hide();
            }

            return isValid;
        }

        // Event handler untuk validasi real-time
        $('#nama_peserta').on('blur', function() {
            const nama = $(this).val().trim();
            $(this).removeClass('is-invalid');
            $('#nama_peserta-error').hide();

            if (nama === '') {
                $(this).addClass('is-invalid');
                $('#nama_peserta-error').text('Nama lengkap wajib diisi').show();
            } else if (nama.length < 3) {
                $(this).addClass('is-invalid');
                $('#nama_peserta-error').text('Nama lengkap minimal 3 karakter').show();
            }
        });

        $('#nik').on('blur', function() {
            const nik = $(this).val().trim();
            $(this).removeClass('is-invalid');
            $('#nik-error').hide();

            if (nik === '') {
                $(this).addClass('is-invalid');
                $('#nik-error').text('NIK wajib diisi').show();
            } else if (nik.length !== 16) {
                $(this).addClass('is-invalid');
                $('#nik-error').text('NIK harus 16 digit').show();
            }
        });

        $('#tempat_lahir').on('blur', function() {
            const tempatLahir = $(this).val().trim();
            $(this).removeClass('is-invalid');
            $('#tempat_lahir-error').hide();

            if (tempatLahir === '') {
                $(this).addClass('is-invalid');
                $('#tempat_lahir-error').text('Tempat lahir wajib diisi').show();
            }
        });

        $('#alamat').on('blur', function() {
            const alamat = $(this).val().trim();
            $(this).removeClass('is-invalid');
            $('#alamat-error').hide();

            if (alamat === '') {
                $(this).addClass('is-invalid');
                $('#alamat-error').text('Alamat lengkap wajib diisi').show();
            } else if (alamat.length < 10) {
                $(this).addClass('is-invalid');
                $('#alamat-error').text('Alamat terlalu singkat, minimal 10 karakter').show();
            }
        });

        // Validasi real-time untuk jalur pendaftaran
        $('input[name="jalur"]').on('change', function() {
            const jalurSelected = $('input[name="jalur"]:checked').val();
            $('#jalur-invalid-feedback').hide();

            if (jalurSelected) {
                // Jika jalur dipilih, sembunyikan error
                $('#jalur-invalid-feedback').hide();
            }
        });

        // Validasi real-time untuk status pendaftaran
        $('select[name="status_pendaftaran"]').on('change', function() {
            const statusPendaftaran = $(this).val();
            $(this).removeClass('is-invalid');
            $('#status_pendaftaran-error').hide();

            if (!statusPendaftaran || statusPendaftaran === '') {
                $(this).addClass('is-invalid');
                $('#status_pendaftaran-error').text('Status pendaftaran wajib dipilih').show();
            }
        });

        // Validasi real-time untuk nomor HP
        $('input[name="nomor_hp"]').on('blur', function() {
            const nomorHp = $(this).val().trim();
            $(this).removeClass('is-invalid');
            $('#nomor_hp-error').hide();

            if (nomorHp !== '' && (nomorHp.length < 10 || nomorHp.length > 15)) {
                $(this).addClass('is-invalid');
                if (!$('#nomor_hp-error').length) {
                    $(this).after('<div class="invalid-feedback" id="nomor_hp-error"></div>');
                }
                $('#nomor_hp-error').text('Nomor HP harus 10-15 digit').show();
            }
        });

        // Validasi real-time untuk wilayah
        $('#select-provinsi').on('change', function() {
            const provinsi = $(this).val();
            $(this).removeClass('is-invalid');
            $('#provinsi-error').hide();

            if (!provinsi || provinsi === '') {
                $(this).addClass('is-invalid');
                $('#provinsi-error').text('Provinsi wajib dipilih').show();
            }
        });

        $('#select-kabupaten').on('change', function() {
            const kabupaten = $(this).val();
            $(this).removeClass('is-invalid');
            $('#kabupaten-error').hide();

            if (!kabupaten || kabupaten === '') {
                $(this).addClass('is-invalid');
                $('#kabupaten-error').text('Kabupaten/Kota wajib dipilih').show();
            }
        });

        $('#select-kecamatan').on('change', function() {
            const kecamatan = $(this).val();
            $(this).removeClass('is-invalid');
            $('#kecamatan-error').hide();

            if (!kecamatan || kecamatan === '') {
                $(this).addClass('is-invalid');
                $('#kecamatan-error').text('Kecamatan wajib dipilih').show();
            }
        });

        $('#select-kelurahan').on('change', function() {
            const kelurahan = $(this).val();
            $(this).removeClass('is-invalid');
            $('#kelurahan-error').hide();

            if (!kelurahan || kelurahan === '') {
                $(this).addClass('is-invalid');
                $('#kelurahan-error').text('Kelurahan/Desa wajib dipilih').show();
            }
        });

        toggleNomorKip();
        $(document).on('change', '#punya_kip', toggleNomorKip);

        // Inisialisasi Select2 untuk semua select yang pakai class select2
        if ($.fn.select2) {
            $('.select2').select2({
                width: '100%'
            });
        }

        // Event tombol Simpan di lembar konfirmasi (buka modal)
        $(document).on('click', '#btn-modal-konfirmasi', function(e) {
            e.preventDefault();

            // Validasi form menggunakan fungsi validateForm yang sudah ada
            if (!validateForm()) {
                // Scroll ke field pertama yang error
                const firstError = $('.is-invalid').first();
                if (firstError.length > 0) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 500);
                    firstError.focus();
                }

                // Tidak ada alert pop-up, hanya inline feedback
                return false;
            }

            // Jika validasi berhasil, buka modal konfirmasi
            $('#modalKonfirmasiFinal').modal('show');
        });

        // Validasi saat form disubmit
        $(document).on('submit', '#basic-form-spmb', function(e) {
            // Debug: tampilkan nilai jalur yang dipilih
            const jalurSelected = $('input[name="jalur"]:checked').val();
            console.log('Jalur pendaftaran yang dipilih:', jalurSelected);

            if (!validateForm()) {
                e.preventDefault();
                e.stopPropagation();

                // Scroll ke field pertama yang error
                const firstError = $('.is-invalid').first();
                if (firstError.length > 0) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 500);
                    firstError.focus();
                }

                return false;
            }

            // Set nilai dropdown opsional yang kosong menjadi null untuk menghindari foreign key error
            var form = $(this);
            var optionalSelects = [
                'select[name="id_agama"]',
                'select[name="id_kebutuhan_khusus"]',
                'select[name="id_tinggal"]',
                'select[name="id_transportasi"]',
                'select[name="id_pendidikan_ayah"]',
                'select[name="id_pekerjaan_ayah"]',
                'select[name="id_penghasilan_ayah"]',
                'select[name="id_kebutuhan_khusus_ayah"]',
                'select[name="id_pendidikan_ibu"]',
                'select[name="id_pekerjaan_ibu"]',
                'select[name="id_penghasilan_ibu"]',
                'select[name="id_kebutuhan_khusus_ibu"]'
            ];

            optionalSelects.forEach(function(selector) {
                var $select = $(selector);
                if ($select.length && $select.val() === '') {
                    // Buat hidden input dengan nilai kosong untuk menghindari foreign key error
                    $('<input>').attr({
                        type: 'hidden',
                        name: $select.attr('name'),
                        value: ''
                    }).appendTo(form);
                    $select.attr('name', $select.attr('name') + '_disabled');
                }
            });

            $('#btn-submit-final').prop('disabled', true).text('Menyimpan...');
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Menggunakan API wilayah Indonesia dari ibnux (data terbaru 2025, lebih lengkap dan stabil)
        const BASE_API_URL = 'https://ibnux.github.io/data-indonesia';

        // Variabel untuk menyimpan nilai yang sudah dipilih sebelumnya (dari old input atau edit data)
        var selectedProvinsi = '<?= old("provinsi") ?: (isset($calon_siswa) ? $calon_siswa->provinsi ?? "" : "") ?>';
        var selectedKabupaten = '<?= old("kabupaten") ?: (isset($calon_siswa) ? $calon_siswa->kabupaten ?? "" : "") ?>';
        var selectedKecamatan = '<?= old("kecamatan") ?: (isset($calon_siswa) ? $calon_siswa->kecamatan ?? "" : "") ?>';
        var selectedKelurahan = '<?= old("kelurahan") ?: (isset($calon_siswa) ? $calon_siswa->kelurahan ?? "" : "") ?>';

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

                        // Selalu berikan opsi manual input
                        kelurahanSelect.append('<option value="manual">-- Input Manual di Alamat --</option>');

                        // Jika ada kelurahan yang dipilih sebelumnya, tambahkan sebagai opsi manual
                        if (selectedKelurahan && selectedKelurahan !== 'manual') {
                            kelurahanSelect.append('<option value="' + selectedKelurahan + '" selected>' + selectedKelurahan + ' (Manual)</option>');
                        }

                        // Jika Gringsing khususnya, berikan data manual sebagai fallback
                        if (kecName && kecName.toLowerCase().includes('gringsing')) {
                            console.log('Adding manual fallback villages for Gringsing');
                            var gringsingsVillages = [
                                'Surodadi',
                                'Sentul',
                                'Plelen',
                                'Kutosari',
                                'Mentosari',
                                'Gringsing',
                                'Yosorejo',
                                'Karangturi',
                                'Proyonanggan',
                                'Kalisalak',
                                'Kedunguter',
                                'Simbang',
                                'Banyuputih'
                            ];
                            gringsingsVillages.forEach(function(village) {
                                var isSelected = (selectedKelurahan == village) ? 'selected' : '';
                                kelurahanSelect.append('<option value="' + village + '" ' + isSelected + '>' + village + '</option>');
                            });
                            console.log('Added', gringsingsVillages.length, 'manual villages for Gringsing');
                        }
                    });
            }
        });

        // Handler untuk ketika user memilih manual input kelurahan/desa
        $('#select-kelurahan').on('change', function() {
            var selectedValue = $(this).val();
            var alamatField = $('textarea[name="alamat"]');

            if (selectedValue === 'manual') {
                // Beri highlight pada field alamat dan petunjuk
                alamatField.focus();
                if (alamatField.val().trim() === '') {
                    alamatField.attr('placeholder', 'Alamat Lengkap - Sertakan nama kelurahan/desa yang tidak tersedia di dropdown');
                }

                // Tampilkan pesan sementara
                var alertMessage = $('<div class="alert alert-info alert-dismissible fade show mt-2" role="alert">' +
                    '<i class="mdi mdi-information-outline me-1"></i>' +
                    '<strong>Info:</strong> Silakan lengkapi nama kelurahan/desa di kolom "Alamat Lengkap" di atas karena data tidak ditemukan di database.' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                    '</div>');

                $('#select-kelurahan').parent().append(alertMessage);

                // Auto-hide alert setelah 8 detik
                setTimeout(function() {
                    alertMessage.alert('close');
                }, 8000);
            } else {
                // Reset placeholder jika user memilih kelurahan yang valid
                alamatField.attr('placeholder', 'Alamat Lengkap');
            }
        });
    });
</script>
<?= $this->endSection() ?>