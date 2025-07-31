<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Update Gawe &mdash; yukNikah</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .form-select {
        max-height: 150px;
        /* Batasi tinggi dropdown */
        overflow-y: auto;
        /* Tambahkan scrollbar jika opsi terlalu banyak */
    }
</style>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Tambah Siswa</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Data siswa</a></li>
                            <li class="breadcrumb-item active">Form tambah siswa</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h5 class="m-0 font-weight-bold text-primary">Data Pribadi</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= site_url('peserta_didik') ?>" method="post" class="needs-validation" novalidate>
                            <?= csrf_field() ?>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Nama</label>
                                <div class="col-md-10">
                                    <input class="form-control" name="nama_siswa" type="text" required>
                                    <div class="invalid-feedback">Nama belum diisi</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-search-input" class="col-md-2 col-form-label">Jenis Kelamin</label>
                                <div class="col-md-10">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jk" id="formRadios1" checked="" value="L">
                                        <label class="form-check-label" for="formRadios1">
                                            Laki laki
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jk" id="formRadios2" value="P ">
                                        <label class="form-check-label" for="formRadios2">
                                            Perempuan
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-url-input" class="col-md-2 col-form-label">NISN</label>
                                <div class="col-md-4">
                                    <input class="form-control" name="nisn" type="text">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-url-input" class="col-md-2 col-form-label">NIS</label>
                                <div class="col-md-4">
                                    <input class="form-control" name="nis" id="nis" type="text" value="<?= $nis ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-url-input" class="col-md-2 col-form-label">Kewarganegaraan</label>
                                <div class="col-md-10">
                                    <select name="kewarganegaraan" class="form-select">
                                        <option value=""> -- Pilih -- </option>
                                        <option value="WNI">Indonesia</option>
                                        <option value="WNA">Asing</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-email-input" class="col-md-2 col-form-label">Tempat Lahir</label>
                                <div class="col-4">
                                    <input class="form-control" name="tempat_lahir" type="text">
                                </div>
                                <label for="example-email-input" class="col-lg-2 col-form-label">Tanggal Lahir</label>
                                <div class="col-4" id="datepicker2">
                                    <input type="text" class="form-control" name="tanggal_lahir" placeholder="25/05/2015" data-date-format="dd/mm/yyyy" data-date-container="#datepicker2" data-provide="datepicker" data-date-autoclose="true">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-tel-input" class="col-md-2 col-form-label">No. Akta Kelahiran</label>
                                <div class="col-md-10">
                                    <input class="form-control" name="reg_akta" type="text">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-password-input" class="col-md-2 col-form-label">NIK</label>
                                <div class="col-md-10">
                                    <input class="form-control" name="nik" type="number" maxlength="16" id="nik-input" required>
                                    <div class="invalid-feedback" id="nik-feedback">NIK harus terdiri dari 16 angka.</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-number-input" class="col-md-2 col-form-label">Nomor KK</label>
                                <div class="col-md-10">
                                    <input class="form-control" name="no_kk" type="number" maxlength="16">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-md-2 col-form-label">Agama</label>
                                <div class="col-md-10" style="max-height: 150px; overflow-y: auto;">
                                    <select name="id_agama" class="form-select">
                                        <option value=""> -- Pilih -- </option>
                                        <?php foreach ($agama as $key => $value): ?>
                                            <option value="<?= $value->id_agama ?>"> <?= $value->agama ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-number-input" class="col-md-2 col-form-label">Alamat Jalan</label>
                                <div class="col-md-10">
                                    <input class="form-control" name="alamat" type="text">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-email-input" class="col-md-2 col-form-label">RT</label>
                                <div class="col-2">
                                    <input class="form-control" name="rt" type="number">
                                </div>
                                <label for="example-email-input" class="col-md-2 col-form-label">/ RW</label>
                                <div class="col-2">
                                    <input class="form-control" name="rw" type="number">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-time-input" class="col-md-2 col-form-label">Nama Dusun</label>
                                <div class="col-md-10">
                                    <input class="form-control" name="nama_dusun" type="text">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-md-2 col-form-label">Desa/Kelurahan</label>
                                <div class="col-md-10">
                                    <input name="kelurahan" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-md-2 col-form-label">Kecamatan</label>
                                <div class="col-md-10">
                                    <input class="form-control" name="kecamatan" type="text">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-time-input" class="col-sm-2 col-form-label">Kode POS</label>
                                <div class="col-2">
                                    <input class="form-control" name="kodepos" type="text">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-time-input" class="col-sm-2 col-form-label">Lintang</label>
                                <div class="col-5">
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-time-input" class="col-sm-2 col-form-label">Bujur</label>
                                <div class="col-5">
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="exampleDataList" class="col-md-2 col-form-label">Tempat tinggal</label>
                                <div class="col-md-10">
                                    <select name="id_tinggal" class="form-select">
                                        <option value=""> -- Pilih -- </option>
                                        <?php foreach ($tinggal as $key => $value): ?>
                                            <option value="<?= $value->id_tempat_tinggal ?>"> <?= $value->tempat_tinggal ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="exampleDataList" class="col-md-2 col-form-label">Moda Transportasi</label>
                                <div class="col-md-10">
                                    <select name="id_transportasi" class="form-select">
                                        <option value=""> -- Pilih -- </option>
                                        <?php foreach ($transport as $key => $value): ?>
                                            <option value="<?= $value->id_transportasi ?>"> <?= $value->moda_transportasi ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Anak Ke</label>
                                <div class="col-2">
                                    <input
                                        class="form-control"
                                        name="anak_ke"
                                        type="text"
                                        pattern="[0-9]*"
                                        inputmode="numeric"
                                        maxlength="2"
                                        placeholder="1"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0,2); if(parseInt(this.value) > 20) this.value = '20'; if(parseInt(this.value) < 1 && this.value !== '') this.value = '1';">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-time-input" class="col-sm-2 col-form-label">Kebutuhan Khusus</label>
                                <div class="col-10">
                                    <select name="id_kebutuhankhusus" class="form-select">
                                        <option value=""> -- Pilih -- </option>
                                        <?php foreach ($disability as $key => $value): ?>
                                            <option value="<?= $value->id_disability ?>"> <?= $value->jenis_disability ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-time-input" class="col-sm-2 col-form-label">Nomor HP</label>
                                <div class="col-10">
                                    <input class="form-control" name="telephone" type="text">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-time-input" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-10">
                                    <input class="form-control" name="email" type="text">
                                </div>
                            </div>

                            <!-- Tambahkan field kelas masuk dan kelas saat ini -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between mt-4">
                                <h5 class="m-0 font-weight-bold text-primary">Data Sekolah</h5>
                            </div>

                            <div class="mb-3 row mt-4">
                                <label for="id_rombel_masuk" class="col-md-2 col-form-label">Kelas Masuk (Pertama)</label>
                                <div class="col-md-10">
                                    <select name="id_rombel_masuk" id="id_rombel_masuk" class="form-select">
                                        <option value=""> -- Pilih -- </option>
                                        <?php foreach ($rombel as $key => $value): ?>
                                            <option value="<?= $value->id_rombel ?>">
                                                Kelas <?= $value->kelas ?> <?= $value->rombel ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="id_rombel" class="col-md-2 col-form-label">Kelas Saat Ini</label>
                                <div class="col-md-10">
                                    <select name="id_rombel" id="id_rombel" class="form-select">
                                        <option value=""> -- Pilih -- </option>
                                        <?php foreach ($rombel as $key => $value): ?>
                                            <option value="<?= $value->id_rombel ?>">
                                                Kelas <?= $value->kelas ?> <?= $value->rombel ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="sekolah_asal" class="col-md-2 col-form-label">Asal Sekolah</label>
                                <div class="col-md-10">
                                    <input class="form-control" name="sekolah_asal" type="text">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="tanggal_diterima" class="col-md-2 col-form-label">Tanggal Diterima</label>
                                <div class="col-md-4" id="datepicker3">
                                    <input type="text" class="form-control" name="tanggal_diterima" data-date-format="dd/mm/yyyy" data-date-container="#datepicker3" data-provide="datepicker" data-date-autoclose="true" value="<?= date('d/m/Y') ?>">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="id_tahun_ajaran" class="col-md-2 col-form-label">Tahun Ajaran</label>
                                <div class="col-md-4">
                                    <select name="id_tahun_ajaran" class="form-select" required>
                                        <option value="">-- Pilih Tahun Ajaran --</option>
                                        <?php foreach ($tahun_ajaran as $ta): ?>
                                            <option value="<?= $ta->id_tahun_ajaran ?>">
                                                <?= isset($ta->tahunajaran) ? $ta->tahunajaran : (isset($ta->tahun_ajaran) ? $ta->tahun_ajaran : $ta->id_tahun_ajaran) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="status_siswa" class="col-md-2 col-form-label">Status</label>
                                <div class="col-md-4">
                                    <select name="status_siswa" class="form-select">
                                        <option value="Aktif" selected>Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                        <option value="Lulus">Lulus</option>
                                        <option value="Mutasi">Mutasi</option>
                                    </select>
                                </div>
                            </div>

                    </div>
                </div>
            </div> <!-- end col -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h5 class="m-0 font-weight-bold text-primary">Data Ayah Kandung</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Nama Ayah</label>
                            <div class="col-md-10">
                                <input class="form-control" name="nama_ayah" type="text">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-password-input" class="col-md-2 col-form-label">NIK Ayah</label>
                            <div class="col-md-10">
                                <input class="form-control" name="nik_ayah" type="number" maxlength="16">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-number-input" class="col-md-2 col-form-label">Tahun Lahir Ayah</label>
                            <div class="col-md-2">
                                <input class="form-control" type="number">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-number-input" class="col-md-2 col-form-label">Pendidikan Ayah</label>
                            <div class="col-md-10">
                                <select name="id_pendidikan_ayah" class="form-select">
                                    <option value=""> -- Pilih -- </option>
                                    <?php foreach ($pendidikan as $key => $value): ?>
                                        <option value="<?= $value->id_pendidikan ?>"> <?= $value->pendidikan ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="example-time-input" class="col-md-2 col-form-label">Pekerjaan Ayah</label>
                            <div class="col-md-10">
                                <select name="id_pekerjaan_ayah" class="form-select">
                                    <option value=""> -- Pilih -- </option>
                                    <?php foreach ($pekerjaan as $key => $value): ?>
                                        <option value="<?= $value->id_pekerjaan ?>"> <?= $value->nama_pekerjaan ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-time-input" class="col-sm-2 col-form-label">Penghasilan Ayah</label>
                            <div class="col-10">
                                <select name="id_penghasilan_ayah" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option value="500000-999999">Rp. 500.000 - Rp. 999.999</option>
                                    <option value="1000000-1999999">Rp. 1.000.000 - Rp. 1.999.999</option>
                                    <option value="2000000-4999999">Rp. 2.000.000 - Rp. 4.999.999</option>
                                    <option value="5000000-20000000">Rp. 5.000.000 - Rp. 20.000.000</option>
                                    <option value="lebih_20000000"> > Rp. 20.000.000</option>
                                    <option value="tidak_berpenghasilan">Tidak Berpenghasilan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h5 class="m-0 font-weight-bold text-primary">Data Ibu Kandung</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Nama Ibu</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-password-input" class="col-md-2 col-form-label">NIK Ibu</label>
                            <div class="col-md-10">
                                <input class="form-control" type="number" maxlength="16">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-number-input" class="col-md-2 col-form-label">Tahun Lahir Ibu</label>
                            <div class="col-md-2">
                                <input class="form-control" type="text">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-number-input" class="col-md-2 col-form-label">Pendidikan Ibu</label>
                            <div class="col-md-10">
                                <select name="id_pendidikan_ibu" class="form-select">
                                    <option value=""> -- Pilih -- </option>
                                    <?php foreach ($pendidikan as $key => $value): ?>
                                        <option value="<?= $value->id_pendidikan ?>"> <?= $value->pendidikan ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="example-time-input" class="col-md-2 col-form-label">Pekerjaan Ibu</label>
                            <div class="col-md-10">
                                <select name="id_pekerjaan_ibu" class="form-select ">
                                    <option value=""> -- Pilih -- </option>
                                    <?php foreach ($pekerjaan as $key => $value): ?>
                                        <option value="<?= $value->id_pekerjaan ?>"> <?= $value->nama_pekerjaan ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-time-input" class="col-sm-2 col-form-label">Penghasilan Ibu</label>
                            <div class="col-md-10">
                                <select name="id_penghasilan_ibu" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option value="500000-999999">Rp. 500.000 - Rp. 999.999</option>
                                    <option value="1000000-1999999">Rp. 1.000.000 - Rp. 1.999.999</option>
                                    <option value="2000000-4999999">Rp. 2.000.000 - Rp. 4.999.999</option>
                                    <option value="5000000-20000000">Rp. 5.000.000 - Rp. 20.000.000</option>
                                    <option value="lebih_20000000"> > Rp. 20.000.000</option>
                                    <option value="tidak_berpenghasilan">Tidak Berpenghasilan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-5">
                    <button type="submit" class="btn btn-primary w-md">Simpan</button>
                </div>
            </div> <!-- end col -->
            </form>
        </div>
        <script>
            document.getElementById('nik-input').addEventListener('input', function(e) {
                const input = e.target;
                const feedback = document.getElementById('nik-feedback');
                if (input.value.length === 0) {
                    input.classList.remove('is-invalid');
                    feedback.style.display = 'none';
                } else if (input.value.length < 10) {
                    input.classList.add('is-invalid');
                    feedback.style.display = 'block';
                } else if (input.value.length > 16) {
                    input.value = input.value.slice(0, 16);
                    input.classList.remove('is-invalid');
                    feedback.style.display = 'none';
                } else {
                    input.classList.remove('is-invalid');
                    feedback.style.display = 'none';
                }
            });
        </script>
        <style>
            .is-invalid {
                border-color: red;
            }

            /* Hide the spinner controls in number input fields */
            input[type=number]::-webkit-outer-spin-button,
            input[type=number]::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            /* Khusus untuk field Anak Ke */
            .anak-ke-field {
                -moz-appearance: textfield !important;
                -webkit-appearance: none !important;
                appearance: textfield !important;
            }

            /* Pastikan tidak ada dropdown arrow */
            .anak-ke-field::-webkit-calendar-picker-indicator {
                display: none !important;
            }

            .anak-ke-field::-webkit-clear-button {
                display: none !important;
            }

            /* input[type=number] {
                -moz-appearance: textfield;
            } */
        </style>
        <script>
            // Script to synchronize id_rombel with id_rombel_masuk when first selected
            document.addEventListener('DOMContentLoaded', function() {
                const rombelMasukSelect = document.getElementById('id_rombel_masuk');
                const rombelSelect = document.getElementById('id_rombel');

                if (rombelMasukSelect && rombelSelect) {
                    rombelMasukSelect.addEventListener('change', function() {
                        // Only set id_rombel automatically if it hasn't been manually selected yet
                        if (!rombelSelect.dataset.manuallySelected) {
                            rombelSelect.value = rombelMasukSelect.value;
                        }
                    });

                    rombelSelect.addEventListener('change', function() {
                        // Mark as manually selected
                        rombelSelect.dataset.manuallySelected = 'true';
                    });
                }
            });
        </script>
        <?= $this->endSection() ?>