<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<style>
  .small-font {
    font-size: 10.2px;
    /* Adjust the font size as needed */
  }

  .nav-link {
    background-color: #f8f9fa;
    /* Light gray background */
  }

  .nav-link.active {
    background-color: #007bff;
    /* Blue background for active tab */
    color: white;
    /* White text for active tab */
  }

  input[readonly],
  select[disabled] {
    background-color: #e9ecef;
  }
</style>
<div class="page-content">
  <div class="container-fluid">

    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="d-flex flex-column flex-lg-row bg-white rounded-2 shadow-sm py-3 px-4 mb-3">
          <!-- judul halaman -->
          <div class="flex-grow-1 d-flex align-items-end">
            <h5 class="page-title">
              <i class="ti ti-inbox fs-4 align-text-top me-1"></i> <?= $peserta_didik->nama_siswa ?>
              <a href="<?= site_url('calon_siswa') ?>" class="btn btn-primary btn-sm"><i class="mdi mdi-arrow-left-thin"></i>
                Back
              </a>
            </h5>
          </div>
          <!-- button action -->
          <div class="ms-4 ms-lg-0 p-2 p-lg-0">
            <div class="page-title-right">
              <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="">Data peserta didik</a></li>
                <li class="breadcrumb-item active">Edit data</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end page title -->
    <div class="row">
      <!-- Main Content -->
      <div class="col-xl-9">
        <div class="card">
          <div class="card-body">
            <!-- Nav tabs -->
            <div class="d-flex justify-content-center">
              <ul class="nav nav-pills nav-justified " role="tablist" style="width: 635px;">
                <li class="nav-item waves-effect waves-light me-3" role="presentation">
                  <a class="nav-link active" data-bs-toggle="tab" href="#identitas" role="tab" aria-selected="true">
                    <span class="d-block d-sm-none"><i class="fas fa-id-card fs-1"></i></span>
                    <span class="d-none d-sm-block"><i class="fas fa-id-card mt-2 mb-2 fs-3"></i><span class="small-font">IDENTITAS</span></span>
                  </a>
                </li>
                <li class="nav-item waves-effect waves-light me-3" role="presentation">
                  <a class="nav-link" data-bs-toggle="tab" href="#sekolah" role="tab" aria-selected="false" tabindex="-1">
                    <span class="d-block d-sm-none"><i class="fas fa-building fs-1"></i></span>
                    <span class="d-none d-sm-block"><i class="fas fa-building mt-2 mb-2 fs-3"></i><span class="small-font">SEKOLAH</span></span>
                  </a>
                </li>
                <li class="nav-item waves-effect waves-light me-3" role="presentation">
                  <a class="nav-link" data-bs-toggle="tab" href="#orangtua" role="tab" aria-selected="false" tabindex="-1">
                    <span class="d-block d-sm-none"><i class="fas fa-users fs-1"></i></span>
                    <span class="d-none d-sm-block"><i class="fas fa-users mt-2 mb-2 fs-3"></i><span class="small-font">ORANG TUA</span></span>
                  </a>
                </li>
                <li class="nav-item waves-effect waves-light me-3" role="presentation">
                  <a class="nav-link" data-bs-toggle="tab" href="#walisiswa" role="tab" aria-selected="false" tabindex="-1">
                    <span class="d-block d-sm-none"><i class="fas fa-user-tag fs-1"></i></span>
                    <span class="d-none d-sm-block"><i class="fas fa-user-tag mt-2 mb-2 fs-3"></i><span class="small-font"><br>WALI SISWA</span></span>
                  </a>
                </li>
                <li class="nav-item waves-effect waves-light me-3" role="presentation">
                  <a class="nav-link" data-bs-toggle="tab" href="#prestasi" role="tab" aria-selected="false" tabindex="-1">
                    <span class="d-block d-sm-none"><i class="fas fa-medal fs-1"></i></span>
                    <span class="d-none d-sm-block"><i class="fas fa-medal mt-2 mb-2 fs-3"></i><span class="small-font">PRESTASI</span></span>
                  </a>
                </li>
                <li class="nav-item waves-effect waves-light" role="presentation">
                  <a class="nav-link" data-bs-toggle="tab" href="#lampiran" role="tab" aria-selected="false" tabindex="-1">
                    <span class="d-block d-sm-none"><i class="fas fa-file-invoice fs-1"></i></span>
                    <span class="d-none d-sm-block"><i class="fas fa-file-invoice mt-2 mb-2 fs-3"></i><span class="small-font">LAMPIRAN</span></span>
                  </a>
                </li>
              </ul>
            </div>
            <!-- Tab panes -->
            <div class="tab-content p-3 text-muted">
              <div class="tab-pane active show" id="identitas" role="tabpanel">
                <div>
                  <form action="<?= site_url('peserta_didik/update/' . $peserta_didik->id_siswa) ?>" method="post" autocomplete="off">
                    <?= csrf_field() ?>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <input type="text" name="nama_siswa" value="<?= ($peserta_didik->nama_siswa) ?>" class="form-control" readonly>
                          <label for="floatingnameInput">NAMA LENGKAP</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <input type="text" name="nis" value="<?= ($peserta_didik->nis) ?>" class="form-control">
                          <label for="floatingnameInput">NIS</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <input type="number" name="nisn" value="<?= ($peserta_didik->nisn) ?>" class="form-control">
                          <label for="floatingnameInput">NISN</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <input type="text" name="nik" value="<?= ($peserta_didik->nik) ?>" class="form-control">
                          <label for="floatingnameInput">NIK</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <label class="d-block mb-3">JENIS KELAMIN</label>
                        <div class="form-floating mb-3">
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jk" id="inlineRadio1" value="L" <?= $peserta_didik->jk == 'L' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="inlineRadio1">Laki - laki</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jk" id="inlineRadio1" value="P" <?= $peserta_didik->jk == 'P' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="inlineRadio1">Perempuan</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-floating mb-3">
                          <input type="text" name="tempat_lahir" value="<?= ($peserta_didik->tempat_lahir) ?>" class="form-control" placeholder="Enter Name">
                          <label for="floatingnameInput">TEMPAT LAHIR</label>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-floating mb-3">
                          <input type="date" name="tanggal_lahir" value="<?= ($peserta_didik->tanggal_lahir) ?>" class="form-control">
                          <label for="floatingnameInput">TANGGAL LAHIR</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-floating mb-3">
                          <select class="form-select" name="kewarganegaraan" id="floatingSelectKewarganegaraan" aria-label="Floating label select example">
                            <option value="WNI" <?= $peserta_didik->kewarganegaraan == 'WNI' ? 'selected' : '' ?>>Indonesia (WNI)</option>
                            <option value="WNA" <?= $peserta_didik->kewarganegaraan == 'WNA' ? 'selected' : '' ?>>Asing (WNA)</option>
                          </select>
                          <label for="floatingnameInput">KWARGANEGARAAN</label>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-floating mb-3">
                          <input type="text" name="anak_ke" value="<?= ($peserta_didik->anak_ke) ?>" class="form-control">
                          <label for="floatingnameInput">ANAK KE</label>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-floating mb-3">
                          <input type="text" name="jumlah_saudara" value="<?= ($peserta_didik->jumlah_saudara) ?>" class="form-control">
                          <label for="floatingnameInput">JUMLAH SAUDARA</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <select class="form-select" name="id_agama" id="floatingSelectGrid" aria-label="Floating label select example">
                            <?php foreach ($agama as $key => $value): ?>
                              <option value="<?= $value->id_agama ?>" <?= $peserta_didik->id_agama == $value->id_agama ? 'selected' : null ?>>
                                <?= $value->agama ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <label for="floatingSelectGrid">AGAMA & KEPERCAYAAN</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <input type="text" name="telephone" value="<?= ($peserta_didik->telephone) ?>" class="form-control">
                          <label for="floatingnameInput">TELEPHONE</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" name="alamat" id="floatingnameInput" value="<?= ($peserta_didik->alamat) ?>">
                          <label for=" floatingnameInput">ALAMAT TEMPAT TINGGAL</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="form-floating mb-3">
                          <input type="text" name="rt" value="<?= ($peserta_didik->rt) ?>" class="form-control">
                          <label for="floatingnameInput">RT</label>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-floating mb-3">
                          <input type="text" name="rw" value="<?= ($peserta_didik->rw) ?>" class="form-control">
                          <label for="floatingnameInput">RW</label>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-floating mb-3">
                          <input type="text" name="nama_dusun" value="<?= ($peserta_didik->nama_dusun) ?>" class="form-control">
                          <label for="floatingnameInput">NAMA DUSUN</label>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-floating mb-3">
                          <input type="text" name="kelurahan" value="<?= ($peserta_didik->kelurahan) ?>" class="form-control">
                          <label for="floatingnameInput">NAMA KELURAHAN/DESA</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-9">
                        <div class="form-floating mb-3">
                          <input type="text" name="kecamatan" value="<?= ($peserta_didik->kecamatan) ?>" class="form-control">
                          <label for="floatingnameInput">KECAMATAN</label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-floating mb-3">
                          <input type="text" name="kodepos" value="<?= ($peserta_didik->kodepos) ?>" class="form-control">
                          <label for="floatingnameInput">KODE POS</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <input type="text" name="lintang" value="<?= ($peserta_didik->lintang) ?>" class="form-control">
                          <label for="floatingnameInput">LINTANG</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <input type="text" name="bujur" value="<?= ($peserta_didik->bujur) ?>" class="form-control">
                          <label for="floatingnameInput">BUJUR</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <select class="form-select" name="id_kebutuhankhusus" id="floatingSelectGrid" aria-label="Floating label select example">
                            <?php foreach ($disability as $key => $value): ?>
                              <option value="<?= $value->id_disability ?>" <?= $peserta_didik->id_kebutuhankhusus == $value->id_disability ? 'selected' : null ?>>
                                <?= $value->jenis_disability ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <label for=" floatingnameInput">BERKEBUTUHAN KHUSUS</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <select class="form-select" name="id_transportasi" id="floatingSelectGrid" aria-label="Floating label select example">
                            <?php foreach ($transport as $key => $value): ?>
                              <option value="<?= $value->id_transportasi ?>" <?= $peserta_didik->id_transportasi == $value->id_transportasi ? 'selected' : null ?>>
                                <?= $value->moda_transportasi ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <label for=" floatingnameInput">MODA TRANSPORTASI</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="formrow-inputState" class="form-label text-black">BEASISWA & BANTUAN</label>
                        <div class="form-floating mb-3">
                          <input type="text" name="beasiswa" value="<?= ($peserta_didik->beasiswa) ?>" class="form-control">
                          <label for="floatingnameInput">JENIS BANTUAN & BEASISWA</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label for="formrow-inputState" class="form-label text-black">TEMPAT TINGGAL</label>
                        <div class="form-floating mb-3">
                          <select class="form-select" name="id_tinggal" id="floatingSelectGrid" aria-label="Floating label select example">
                            <?php foreach ($tinggal as $key => $value): ?>
                              <option value="<?= $value->id_tempat_tinggal ?>" <?= $peserta_didik->id_tinggal == $value->id_tempat_tinggal ? 'selected' : null ?>>
                                <?= $value->tempat_tinggal ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <label for="floatingnameInput">STATUS TEMPAT TINGGAL</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-floating mb-">
                          <input type="text" name="no_kk" value="<?= ($peserta_didik->no_kk) ?>" class="form-control">
                          <label for="floatingnameInput">NO. KK</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <input type="text" name="reg_akta" value="<?= ($peserta_didik->reg_akta) ?>" class="form-control">
                          <label for="floatingnameInput">NO.AKTA</label>
                        </div>
                      </div>
                    </div>
                    <div class="d-grid">
                      <button type="button" class="btn btn-warning waves-effect waves-light" id="editButtonIdentitas">EDIT DATA</button>
                      <button type="submit" class="btn btn-success waves-effect waves-light" id="saveButtonIdentitas" style="display: none;">SIMPAN DATA</button>
                      <input type="hidden" name="isEditingIdentitas" id="isEditingIdentitas" value="0">
                    </div>
                </div>
                </form>
              </div>
              <div class="tab-pane" id="sekolah" role="tabpanel">
                <div>
                  <form action="<?= site_url('peserta_didik/update/' . $peserta_didik->id_siswa) ?>" method="post" autocomplete="off">
                    <?= csrf_field() ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-floating mb-3">
                          <input type="text" name="asal_sekolah" value="<?= isset($peserta_didik->asal_sekolah) ? $peserta_didik->asal_sekolah : '' ?>" class="form-control">
                          <label for="floatingnameInput">Asal Sekolah</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-floating mb-3">
                          <input type="text" name="npsn" value="<?= ($peserta_didik->npsn ?? '') ?>" class="form-control" readonly>
                          <label for="floatingnameInput">NPSN</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-floating mb-3">
                          <input type="date" name="tanggal_diterima" value="<?= isset($peserta_didik->tanggal_diterima) ? $peserta_didik->tanggal_diterima : '' ?>" class="form-control">
                          <label for="floatingnameInput">Tanggal diterima</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <select class="form-select" name="id_rombel_masuk" id="floatingSelectGrid1" aria-label="Floating label select example">
                            <?php foreach ($rombel as $key => $value): ?>
                              <option value="<?= $value->id_rombel ?>" <?= isset($peserta_didik->id_rombel_masuk) && $peserta_didik->id_rombel_masuk == $value->id_rombel ? 'selected' : null ?>>
                                <?= $value->kelas ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <label for="floatingSelectGrid1">Kelas Masuk (Pertama)</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <select class="form-select" name="id_rombel" id="floatingSelectGrid2" aria-label="Floating label select example">
                            <?php foreach ($rombel as $key => $value): ?>
                              <option value="<?= $value->id_rombel ?>" <?= $peserta_didik->id_rombel == $value->id_rombel ? 'selected' : null ?>>
                                <?= $value->kelas ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <label for="floatingSelectGrid2">Kelas Saat Ini</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-floating mb-3">
                          <select name="id_tahun_ajaran" class="form-select" required>
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            <?php if (isset($tahun_ajaran) && is_array($tahun_ajaran)): ?>
                              <?php foreach ($tahun_ajaran as $ta): ?>
                                <option value="<?= $ta->id_tahun_ajaran ?>" <?= (isset($peserta_didik->id_tahun_ajaran) && $peserta_didik->id_tahun_ajaran == $ta->id_tahun_ajaran) ? 'selected' : '' ?>>
                                  <?= isset($ta->ket_tahun) && $ta->ket_tahun ? htmlspecialchars($ta->ket_tahun) : (isset($ta->tahun) ? htmlspecialchars($ta->tahun) : $ta->id_tahun_ajaran) ?>
                                </option>
                              <?php endforeach; ?>
                            <?php endif; ?>
                          </select>
                          <label for="floatingnameInput">Tahun Pelajaran</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-floating mb-3">
                          <select class="form-select" name="status_siswa" id="floatingSelectGrid" aria-label="Floating label select example">
                            <option value="Aktif" <?= (isset($peserta_didik->status_siswa) && $peserta_didik->status_siswa == 'Aktif') ? 'selected' : '' ?>>Aktif</option>
                            <option value="Tidak Aktif" <?= (isset($peserta_didik->status_siswa) && $peserta_didik->status_siswa == 'Tidak Aktif') ? 'selected' : '' ?>>Tidak Aktif</option>
                            <option value="Lulus" <?= (isset($peserta_didik->status_siswa) && $peserta_didik->status_siswa == 'Lulus') ? 'selected' : '' ?>>Lulus</option>
                            <option value="Mutasi" <?= (isset($peserta_didik->status_siswa) && $peserta_didik->status_siswa == 'Mutasi') ? 'selected' : '' ?>>Mutasi</option>
                          </select>
                          <label for="floatingnameInput">Status</label>
                        </div>
                      </div>
                    </div>
                    <div class="d-grid">
                      <button type="button" class="btn btn-warning waves-effect waves-light" id="editButtonSekolah">EDIT DATA</button>
                      <button type="submit" class="btn btn-success waves-effect waves-light" id="saveButtonSekolah" style="display: none;">SIMPAN DATA</button>
                      <input type="hidden" name="isEditingSekolah" id="isEditingSekolah" value="0">
                    </div>
                  </form>
                </div>
              </div>
              <div class="tab-pane" id="orangtua" role="tabpanel">
                <h5 class="card-title">DATA AYAH KANDUNG</h5>
                <div>
                  <form action="<?= site_url('peserta_didik/update/' . $peserta_didik->id_siswa) ?>" method="post" autocomplete="off">
                    <?= csrf_field() ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-floating mb-3">
                          <input type="text" name="nama_ayah" value="<?= ($peserta_didik->nama_ayah) ?>" class="form-control" readonly>
                          <label for="floatingnameInput">Nama Ayah Kandung</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-9">
                        <div class="form-floating mb-3">
                          <input type="text" name="nik_ayah" value="<?= ($peserta_didik->nik_ayah) ?>" class="form-control" readonly>
                          <label for="floatingnameInput">NIK Ayah</label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-floating mb-3">
                          <input type="text" name="tahun_ayah" value="<?= ($peserta_didik->tahun_ayah) ?>" class="form-control" readonly>
                          <label for="floatingnameInput">Tahun Lahir</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <select class="form-select" name="id_pendidikan_ayah" id="floatingSelectGrid" aria-label="Floating label select example" disabled>
                            <?php foreach ($pendidikan as $key => $value): ?>
                              <option value="<?= $value->id_pendidikan ?>" <?= $peserta_didik->id_pendidikan_ayah == $value->id_pendidikan ? 'selected' : null ?>>
                                <?= $value->pendidikan ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <label for="floatingnameInput">Pendidikan</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <select class="form-select" name="id_pekerjaan_ayah" id="floatingSelectGrid" aria-label="Floating label select example" disabled>
                            <?php foreach ($pekerjaan as $key => $value): ?>
                              <option value="<?= $value->id_pekerjaan ?>" <?= $peserta_didik->id_pekerjaan_ayah == $value->id_pekerjaan ? 'selected' : null ?>>
                                <?= $value->nama_pekerjaan ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <label for="floatingnameInput">Pekerjaan</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <select class="form-select" name="id_penghasilan_ayah" id="floatingSelectGrid" aria-label="Floating label select example" disabled>
                            <?php foreach ($penghasilan as $row): ?>
                              <option value="<?= $row->id_penghasilan ?>" <?= isset($peserta_didik->id_penghasilan_ayah) && $peserta_didik->id_penghasilan_ayah == $row->id_penghasilan ? 'selected' : null ?>>
                                <?= isset($row->nominal_penghasilan) ? htmlspecialchars($row->nominal_penghasilan, ENT_QUOTES, 'UTF-8') : (isset($row->penghasilan) ? htmlspecialchars($row->penghasilan, ENT_QUOTES, 'UTF-8') : $row->id_penghasilan) ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <label for="floatingnameInput">Penghasilan bulanan</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <select class="form-select" name="id_kebutuhankhusus_ayah" id="floatingSelectGrid" aria-label="Floating label select example" disabled>
                            <option value="">Tidak Ada Kebutuhan Khusus</option>
                            <?php foreach ($disability as $key => $value): ?>
                              <option value="<?= $value->id_disability ?>" <?= $peserta_didik->id_kebutuhankhusus_ayah == $value->id_disability ? 'selected' : null ?>>
                                <?= $value->jenis_disability ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <label for="floatingnameInput">Berkebutuhan khusus</label>
                        </div>
                      </div>
                    </div>
                    <h5 class="card-title">DATA IBU KANDUNG</h5>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-floating mb-3">
                          <input type="text" name="nama_ibu" value="<?= ($peserta_didik->nama_ibu) ?>" class="form-control" readonly>
                          <label for="floatingnameInput">Nama Ibu Kandung</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-9">
                        <div class="form-floating mb-3">
                          <input type="text" name="nik_ibu" value="<?= ($peserta_didik->nik_ibu) ?>" class="form-control" readonly>
                          <label for="floatingnameInput">NIK Ibu</label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-floating mb-3">
                          <input type="text" name="tahun_ibu" value="<?= ($peserta_didik->tahun_ibu) ?>" class="form-control" readonly>
                          <label for="floatingnameInput">Tahun Lahir</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <select class="form-select" name="id_pendidikan_ibu" id="floatingSelectGrid" aria-label="Floating label select example" disabled>
                            <?php foreach ($pendidikan as $key => $value): ?>
                              <option value="<?= $value->id_pendidikan ?>" <?= $peserta_didik->id_pendidikan_ibu == $value->id_pendidikan ? 'selected' : null ?>>
                                <?= $value->pendidikan ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <label for="floatingnameInput">Pendidikan</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <select class="form-select" name="id_pekerjaan_ibu" id="floatingSelectGrid" aria-label="Floating label select example" disabled>
                            <?php foreach ($pekerjaan as $key => $value): ?>
                              <option value="<?= $value->id_pekerjaan ?>" <?= $peserta_didik->id_pekerjaan_ibu == $value->id_pekerjaan ? 'selected' : null ?>>
                                <?= $value->nama_pekerjaan ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <label for="floatingnameInput">Pekerjaan</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <select class="form-select" name="id_penghasilan_ibu" id="floatingSelectGrid" aria-label="Floating label select example" disabled>
                            <?php foreach ($penghasilan as $row): ?>
                              <option value="<?= $row->id_penghasilan ?>" <?= isset($peserta_didik->id_penghasilan_ibu) && $peserta_didik->id_penghasilan_ibu == $row->id_penghasilan ? 'selected' : null ?>>
                                <?= isset($row->nominal_penghasilan) ? htmlspecialchars($row->nominal_penghasilan, ENT_QUOTES, 'UTF-8') : (isset($row->penghasilan) ? htmlspecialchars($row->penghasilan, ENT_QUOTES, 'UTF-8') : $row->id_penghasilan) ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <label for="floatingnameInput">Penghasilan bulanan</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <select class="form-select" name="id_kebutuhankhusus_ibu" id="floatingSelectGrid" aria-label="Floating label select example" disabled>
                            <option value="">Tidak Ada Kebutuhan Khusus</option>
                            <?php foreach ($disability as $key => $value): ?>
                              <option value="<?= $value->id_disability ?>" <?= $peserta_didik->id_kebutuhankhusus_ibu == $value->id_disability ? 'selected' : null ?>>
                                <?= $value->jenis_disability ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <label for="floatingnameInput">Berkebutuhan khusus</label>
                        </div>
                      </div>
                    </div>
                    <div class="d-grid">
                      <button type="button" class="btn btn-warning waves-effect waves-light" id="editButtonOrangtua">EDIT DATA</button>
                      <button type="submit" class="btn btn-success waves-effect waves-light" id="saveButtonOrangtua" style="display: none;">SIMPAN DATA</button>
                      <input type="hidden" name="isEditingOrangtua" id="isEditingOrangtua" value="0">
                    </div>
                  </form>
                </div>
              </div>
              <div class="tab-pane" id="walisiswa" role="tabpanel">
                <div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-floating mb-3">
                        <input type="text" name="nama Lengkap" value="<?= ($peserta_didik->nama_siswa) ?>" class="form-control">
                        <label for="floatingnameInput">Nama Wali</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-9">
                      <div class="form-floating mb-3">
                        <input type="text" name="nik_wali" value="<?= ($peserta_didik->nik_wali ?? '') ?>" class="form-control">
                        <label for="floatingnameInput">NIK Wali</label>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-floating mb-3">
                        <input type="text" name="nik" value="<?= ($peserta_didik->nik) ?>" class="form-control">
                        <label for="floatingnameInput">Tahun Lahir</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-floating mb-3">
                        <input type="text" name="nama Lengkap" value="<?= ($peserta_didik->nama_siswa) ?>" class="form-control">
                        <label for="floatingnameInput">Pendidikan</label>
                      </div>
                    </div>
                  </div>
                  <div class="d-grid">
                    <button type="button" class="btn btn-warning waves-effect waves-light" id="editButtonWali">EDIT DATA</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light" id="saveButtonWali" style="display: none;">SIMPAN DATA</button>
                    <input type="hidden" name="isEditing" id="isEditingWali" value="0">
                  </div>
                  </form>
                </div>
              </div>

              <!-- Prestasi Tab -->
              <div class="tab-pane" id="prestasi" role="tabpanel">
                <div>
                  <form action="<?= site_url('peserta_didik/update/' . $peserta_didik->id_siswa) ?>" method="post" autocomplete="off">
                    <?= csrf_field() ?>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                      <h5 class="card-title mb-0">Data Prestasi Siswa</h5>
                      <button type="button" class="btn btn-primary btn-sm" id="addPrestasiBtn">
                        <i class="mdi mdi-plus"></i> Tambah Prestasi
                      </button>
                    </div>

                    <div id="prestasiContainer">
                      <?php if (isset($prestasi) && count($prestasi) > 0): ?>
                        <?php foreach ($prestasi as $index => $item): ?>
                          <div class="card border-primary mb-3 prestasi-item">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                              <h6 class="mb-0">Prestasi #<?= $index + 1 ?></h6>
                              <button type="button" class="btn btn-sm btn-outline-light" onclick="removePrestasiItem(this)">
                                <i class="mdi mdi-delete"></i>
                              </button>
                            </div>
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-floating mb-3">
                                    <input type="text" name="prestasi_nama[]" value="<?= $item->nama_prestasi ?? '' ?>" class="form-control" placeholder="Nama Prestasi" readonly>
                                    <label>Nama Prestasi</label>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-floating mb-3">
                                    <select class="form-select" name="prestasi_tingkat[]" disabled>
                                      <option value="">Pilih Tingkat</option>
                                      <option value="Sekolah" <?= ($item->tingkat == 'Sekolah') ? 'selected' : '' ?>>Sekolah</option>
                                      <option value="Kecamatan" <?= ($item->tingkat == 'Kecamatan') ? 'selected' : '' ?>>Kecamatan</option>
                                      <option value="Kabupaten" <?= ($item->tingkat == 'Kabupaten') ? 'selected' : '' ?>>Kabupaten</option>
                                      <option value="Provinsi" <?= ($item->tingkat == 'Provinsi') ? 'selected' : '' ?>>Provinsi</option>
                                      <option value="Nasional" <?= ($item->tingkat == 'Nasional') ? 'selected' : '' ?>>Nasional</option>
                                      <option value="Internasional" <?= ($item->tingkat == 'Internasional') ? 'selected' : '' ?>>Internasional</option>
                                    </select>
                                    <label>Tingkat Prestasi</label>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-4">
                                  <div class="form-floating mb-3">
                                    <select class="form-select" name="prestasi_juara[]" disabled>
                                      <option value="">Pilih Juara</option>
                                      <option value="Juara 1">Juara 1</option>
                                      <option value="Juara 2">Juara 2</option>
                                      <option value="Juara 3">Juara 3</option>
                                      <option value="Harapan 1">Harapan 1</option>
                                      <option value="Harapan 2">Harapan 2</option>
                                      <option value="Harapan 3">Harapan 3</option>
                                      <option value="Peserta">Peserta</option>
                                    </select>
                                    <label>Juara</label>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-floating mb-3">
                                    <input type="date" name="prestasi_tanggal[]" class="form-control" readonly>
                                    <label>Tanggal Prestasi</label>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-floating mb-3">
                                    <input type="text" name="prestasi_penyelenggara[]" class="form-control" placeholder="Penyelenggara" readonly>
                                    <label>Penyelenggara</label>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="form-floating mb-3">
                                    <textarea name="prestasi_keterangan[]" class="form-control" style="height: 80px" placeholder="Keterangan tambahan" readonly></textarea>
                                    <label>Keterangan</label>
                                  </div>
                                </div>
                              </div>
                            <?php endforeach; ?>
                          <?php else: ?>
                            <div class="text-center py-4 text-muted">
                              <i class="mdi mdi-trophy fs-2"></i>
                              <p class="mt-2">Belum ada data prestasi. Klik tombol "Tambah Prestasi" untuk menambahkan.</p>
                            </div>
                          <?php endif; ?>

                          <!-- Prestasi akan ditambahkan di sini secara dinamis -->
                            </div>

                            <div class="d-grid">
                              <button type="button" class="btn btn-warning waves-effect waves-light" id="editButtonPrestasi">EDIT DATA</button>
                              <button type="submit" class="btn btn-success waves-effect waves-light" id="saveButtonPrestasi" style="display: none;">SIMPAN DATA</button>
                              <input type="hidden" name="isEditing" id="isEditingPrestasi" value="0">
                            </div>
                  </form>
                </div>
              </div>

              <!-- Lampiran Tab -->
              <div class="tab-pane" id="lampiran" role="tabpanel">
                <div>
                  <form action="<?= site_url('peserta_didik/update/' . $peserta_didik->id_siswa) ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?= csrf_field() ?>

                    <h5 class="card-title mb-4">Dokumen Lampiran</h5>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="card border-info mb-3">
                          <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="mdi mdi-file-document"></i> Ijazah</h6>
                          </div>
                          <div class="card-body">
                            <div class="mb-3">
                              <label class="form-label">File Ijazah (PDF/JPG/PNG)</label>
                              <input type="file" name="ijazah" class="form-control" accept=".pdf,.jpg,.jpeg,.png" disabled>
                              <small class="text-muted">Maksimal 5MB</small>
                            </div>
                            <div class="current-file">
                              <small class="text-success">
                                <i class="mdi mdi-check-circle"></i> File sudah diupload
                              </small>
                              <br>
                              <a href="#" class="btn btn-sm btn-outline-info mt-2">
                                <i class="mdi mdi-eye"></i> Lihat File
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="card border-success mb-3">
                          <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="mdi mdi-account-multiple"></i> Kartu Keluarga</h6>
                          </div>
                          <div class="card-body">
                            <div class="mb-3">
                              <label class="form-label">File KK (PDF/JPG/PNG)</label>
                              <input type="file" name="kartu_keluarga" class="form-control" accept=".pdf,.jpg,.jpeg,.png" disabled>
                              <small class="text-muted">Maksimal 5MB</small>
                            </div>
                            <div class="current-file">
                              <small class="text-success">
                                <i class="mdi mdi-check-circle"></i> File sudah diupload
                              </small>
                              <br>
                              <a href="#" class="btn btn-sm btn-outline-success mt-2">
                                <i class="mdi mdi-eye"></i> Lihat File
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="card border-warning mb-3">
                          <div class="card-header bg-warning text-white">
                            <h6 class="mb-0"><i class="mdi mdi-card-account-details"></i> Akta Kelahiran</h6>
                          </div>
                          <div class="card-body">
                            <div class="mb-3">
                              <label class="form-label">File Akta (PDF/JPG/PNG)</label>
                              <input type="file" name="akta_kelahiran" class="form-control" accept=".pdf,.jpg,.jpeg,.png" disabled>
                              <small class="text-muted">Maksimal 5MB</small>
                            </div>
                            <div class="current-file">
                              <small class="text-warning">
                                <i class="mdi mdi-alert-circle"></i> File belum diupload
                              </small>
                              <br>
                              <button type="button" class="btn btn-sm btn-outline-warning mt-2" disabled>
                                <i class="mdi mdi-upload"></i> Upload File
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="card border-primary mb-3">
                          <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="mdi mdi-camera"></i> Foto Siswa</h6>
                          </div>
                          <div class="card-body">
                            <div class="mb-3">
                              <label class="form-label">Foto 3x4 (JPG/PNG)</label>
                              <input type="file" name="foto_siswa" class="form-control" accept=".jpg,.jpeg,.png" disabled>
                              <small class="text-muted">Maksimal 2MB</small>
                            </div>
                            <div class="current-file text-center">
                              <img src="<?= base_url('backend/assets/images/profile-img.svg') ?>" alt="Foto Siswa" class="img-thumbnail mb-2" width="80" height="100">
                              <br>
                              <small class="text-success">
                                <i class="mdi mdi-check-circle"></i> Foto sudah diupload
                              </small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="card border-secondary mb-3">
                          <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0"><i class="mdi mdi-file-multiple"></i> Dokumen Tambahan</h6>
                          </div>
                          <div class="card-body">
                            <div class="mb-3">
                              <label class="form-label">Dokumen Lainnya (Opsional)</label>
                              <input type="file" name="dokumen_tambahan[]" class="form-control" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" disabled>
                              <small class="text-muted">Bisa pilih multiple file. Maksimal 5MB per file</small>
                            </div>
                            <div class="current-files">
                              <small class="text-muted">
                                <i class="mdi mdi-information"></i> Belum ada dokumen tambahan
                              </small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="d-grid">
                      <button type="button" class="btn btn-warning waves-effect waves-light" id="editButtonLampiran">EDIT DATA</button>
                      <button type="submit" class="btn btn-success waves-effect waves-light" id="saveButtonLampiran" style="display: none;">SIMPAN DATA</button>
                      <input type="hidden" name="isEditing" id="isEditingLampiran" value="0">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Profile Card -->
      <div class="col-xl-3">
        <div class="card">
          <div class="card-body text-center">
            <div class="profile-pic mb-3 position-relative d-inline-block">
              <img src="<?= base_url('backend/assets/images/profile-img.svg') ?>" alt="Profile" class="rounded-circle img-thumbnail" style="width: 120px; height: 120px; object-fit: cover; aspect-ratio: 1/1;">
              <div class="online-indicator bg-success rounded-circle position-absolute" style="width: 15px; height: 15px; bottom: 5px; right: 5px; border: 2px solid white;"></div>
            </div>
            <h5 class="card-title mb-1"><?= $peserta_didik->nama_siswa ?></h5>
            <p class="text-muted mb-2">
              <?php
              // Get class name from rombel
              $rombel_name = 'Belum ada kelas';
              if (isset($rombel) && is_array($rombel)) {
                foreach ($rombel as $r) {
                  if ($r->id_rombel == $peserta_didik->id_rombel) {
                    $rombel_name = $r->kelas;
                    break;
                  }
                }
              }
              ?>
              <?= $rombel_name ?>
            </p>
            <span class="badge bg-success mb-3">Aktif</span>
            <p class="text-muted fs-12 mb-3"><?= $peserta_didik->nisn ?></p>

            <!-- Contact Buttons -->
            <div class="contact-buttons mb-2">
              <div class="row">
                <div class="col-4">
                  <button class="btn btn-warning btn-sm w-100" title="Proses Dapodik">
                    <i class="mdi mdi-database"></i>
                    <br><small>DAPODIK</small>
                  </button>
                </div>
                <div class="col-4">
                  <button class="btn btn-danger btn-sm w-100" title="Proses Mutasi">
                    <i class="mdi mdi-account-switch"></i>
                    <br><small>MUTASI</small>
                  </button>
                </div>
                <div class="col-4">
                  <button class="btn btn-primary btn-sm w-100" title="Lihat Foto">
                    <i class="mdi mdi-camera"></i>
                    <br><small>FOTO</small>
                  </button>
                </div>
              </div>
            </div>

            <!-- Document Status -->
            <div class="document-status">
              <div class="row g-2">
                <div class="col-4">
                  <div class="text-center">
                    <p class="fw-bold mb-1 small">Ijazah</p>
                    <button class="btn btn-warning btn-sm rounded-pill w-100">
                      <i class="mdi mdi-clock-outline"></i> belum
                    </button>
                  </div>
                </div>
                <div class="col-4">
                  <div class="text-center">
                    <p class="fw-bold mb-1 small">Bantuan</p>
                    <button class="btn btn-warning btn-sm rounded-pill w-100">
                      <i class="mdi mdi-clock-outline"></i> belum
                    </button>
                  </div>
                </div>
                <div class="col-4">
                  <div class="text-center">
                    <p class="fw-bold mb-1 small">KK</p>
                    <button class="btn btn-warning btn-sm rounded-pill w-100">
                      <i class="mdi mdi-clock-outline"></i> belum
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Riwayat Kelas Card -->
        <div class="card mt-3">
          <div class="card-header">
            <h5 class="card-title mb-0">Riwayat Kelas</h5>
          </div>
          <div class="card-body">
            <div class="timeline-steps">
              <?php
              $db = db_connect();
              $riwayat_kelas = [];
              if (isset($peserta_didik->id_siswa)) {
                $query = $db->query("
                  SELECT rk.*, r.kelas, r.rombel, g.nama
                  FROM db_rombel_semester_history rk
                  JOIN db_rombel r ON rk.id_rombel = r.id_rombel
                  LEFT JOIN db_pendidik g ON r.wali_kelas = g.id_pendidik
                  WHERE rk.id_siswa = ?
                  ORDER BY rk.id_tahun_ajaran DESC, rk.tanggal_mulai DESC
                ", [$peserta_didik->id_siswa]);
                $riwayat_kelas = $query->getResult();
              }
              $db->close();
              ?>

              <?php if (!empty($riwayat_kelas)): ?>
                <?php foreach ($riwayat_kelas as $index => $row): ?>
                  <div class="timeline-step<?= $row->status == 'Aktif' ? ' active' : '' ?> mt-3">
                    <div class="timeline-content">
                      <div class="d-flex align-items-center">
                        <div class="step-icon <?= $row->status == 'Aktif' ? 'bg-primary' : 'bg-info' ?> text-white rounded-circle me-2" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                          <i class="mdi <?= $row->status == 'Aktif' ? 'mdi-school' : 'mdi-history' ?>"></i>
                        </div>
                        <div>
                          <h6 class="mb-0">Kelas <?= htmlspecialchars($row->kelas) ?><?= $row->rombel ? ' - ' . htmlspecialchars($row->rombel) : '' ?></h6>
                          <p class="text-muted small mb-0">Tahun <?= htmlspecialchars($row->tahun_ajaran) ?></p>
                          <small class="fw-bold" style="color:<?= $row->status == 'Aktif' ? '#28a745' : '#17a2b8' ?>;">
                            <?= $row->nama_guru ? htmlspecialchars($row->nama_guru) : 'Belum ada wali kelas' ?>
                          </small>
                          <?php if ($row->status && $row->status != 'Aktif'): ?>
                            <br><span class="badge bg-secondary mt-1">Status: <?= htmlspecialchars($row->status) ?></span>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <div class="timeline-step mt-3">
                  <div class="timeline-content">
                    <div class="d-flex align-items-center">
                      <div class="step-icon bg-secondary text-white rounded-circle me-2" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                        <i class="mdi mdi-clock-outline"></i>
                      </div>
                      <div>
                        <h6 class="mb-0 text-muted">Belum ada riwayat kelas</h6>
                        <small class="text-muted">Siswa baru atau data historis belum tersedia</small>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endif; ?>

              <!-- Future placeholder -->
              <div class="timeline-step mt-3">
                <div class="timeline-content">
                  <div class="d-flex align-items-center">
                    <div class="step-icon bg-light text-muted rounded-circle me-2" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                      <i class="mdi mdi-dots-horizontal"></i>
                    </div>
                    <div>
                      <h6 class="mb-0 text-muted">Riwayat kelas lainnya</h6>
                      <small class="text-muted">Akan muncul setelah naik kelas</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Disable all input fields and hide the save button initially
    window.onload = function() {
      var inputs = document.querySelectorAll('input');
      inputs.forEach(function(input) {
        input.setAttribute('readonly', true);
      });

      var selects = document.querySelectorAll('select');
      selects.forEach(function(select) {
        select.setAttribute('disabled', true);
      });

      document.getElementById('saveButtonIdentitas').style.display = 'none';
      document.getElementById('saveButtonSekolah').style.display = 'none';
      document.getElementById('saveButtonOrangtua').style.display = 'none';
    };

    document.getElementById('editButtonIdentitas').addEventListener('click', function() {
      document.getElementById('isEditingIdentitas').value = '1';
      document.getElementById('saveButtonIdentitas').style.display = 'block';
      this.style.display = 'none';

      // Enable all input fields in the identitas tab
      var inputs = document.querySelectorAll('#identitas input');
      inputs.forEach(function(input) {
        input.removeAttribute('readonly');
      });

      // Enable all select fields in the identitas tab
      var selects = document.querySelectorAll('#identitas select');
      selects.forEach(function(select) {
        select.removeAttribute('disabled');
      });
    });

    document.getElementById('editButtonSekolah').addEventListener('click', function() {
      document.getElementById('isEditingSekolah').value = '1';
      document.getElementById('saveButtonSekolah').style.display = 'block';
      this.style.display = 'none';

      // Enable all input fields in the sekolah tab
      var inputs = document.querySelectorAll('#sekolah input');
      inputs.forEach(function(input) {
        input.removeAttribute('readonly');
      });

      // Enable all select fields in the sekolah tab
      var selects = document.querySelectorAll('#sekolah select');
      selects.forEach(function(select) {
        select.removeAttribute('disabled');
      });
    });

    document.getElementById('editButtonOrangtua').addEventListener('click', function() {
      document.getElementById('isEditingOrangtua').value = '1';
      document.getElementById('saveButtonOrangtua').style.display = 'block';
      this.style.display = 'none';

      // Enable all input fields in the orangtua tab
      var inputs = document.querySelectorAll('#orangtua input');
      inputs.forEach(function(input) {
        input.removeAttribute('readonly');
      });

      // Enable all select fields in the orangtua tab
      var selects = document.querySelectorAll('#orangtua select');
      selects.forEach(function(select) {
        select.removeAttribute('disabled');
      });
    });

    // Wali Siswa edit functionality
    document.getElementById('editButtonWali').addEventListener('click', function() {
      document.getElementById('isEditingWali').value = '1';
      document.getElementById('saveButtonWali').style.display = 'block';
      this.style.display = 'none';

      // Enable all input fields in the wali tab
      var inputs = document.querySelectorAll('#walisiswa input');
      inputs.forEach(function(input) {
        input.removeAttribute('readonly');
      });

      // Enable all select fields in the wali tab
      var selects = document.querySelectorAll('#walisiswa select');
      selects.forEach(function(select) {
        select.removeAttribute('disabled');
      });
    });

    // Prestasi edit functionality
    document.getElementById('editButtonPrestasi').addEventListener('click', function() {
      document.getElementById('isEditingPrestasi').value = '1';
      document.getElementById('saveButtonPrestasi').style.display = 'block';
      this.style.display = 'none';

      // Enable all input fields in the prestasi tab
      var inputs = document.querySelectorAll('#prestasi input');
      inputs.forEach(function(input) {
        input.removeAttribute('readonly');
      });

      // Enable all select fields in the prestasi tab
      var selects = document.querySelectorAll('#prestasi select');
      selects.forEach(function(select) {
        select.removeAttribute('disabled');
      });

      // Enable all textarea fields in the prestasi tab
      var textareas = document.querySelectorAll('#prestasi textarea');
      textareas.forEach(function(textarea) {
        textarea.removeAttribute('readonly');
      });
    });

    // Lampiran edit functionality
    document.getElementById('editButtonLampiran').addEventListener('click', function() {
      document.getElementById('isEditingLampiran').value = '1';
      document.getElementById('saveButtonLampiran').style.display = 'block';
      this.style.display = 'none';

      // Enable all file input fields in the lampiran tab
      var inputs = document.querySelectorAll('#lampiran input[type="file"]');
      inputs.forEach(function(input) {
        input.removeAttribute('disabled');
      });
    });

    // Add new prestasi item
    let prestasiCounter = 1;
    document.getElementById('addPrestasiBtn').addEventListener('click', function() {
      prestasiCounter++;
      const container = document.getElementById('prestasiContainer');
      const newItem = document.createElement('div');
      newItem.className = 'card border-primary mb-3 prestasi-item';
      newItem.innerHTML = `
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h6 class="mb-0">Prestasi #${prestasiCounter}</h6>
      <button type="button" class="btn btn-sm btn-outline-light" onclick="removePrestasiItem(this)">
        <i class="mdi mdi-delete"></i>
      </button>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-floating mb-3">
            <input type="text" name="prestasi_nama[]" class="form-control" placeholder="Nama Prestasi">
            <label>Nama Prestasi</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating mb-3">
            <select class="form-select" name="prestasi_tingkat[]">
              <option value="">Pilih Tingkat</option>
              <option value="Sekolah">Sekolah</option>
              <option value="Kecamatan">Kecamatan</option>
              <option value="Kabupaten">Kabupaten</option>
              <option value="Provinsi">Provinsi</option>
              <option value="Nasional">Nasional</option>
              <option value="Internasional">Internasional</option>
            </select>
            <label>Tingkat Prestasi</label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="form-floating mb-3">
            <select class="form-select" name="prestasi_juara[]">
              <option value="">Pilih Juara</option>
              <option value="Juara 1">Juara 1</option>
              <option value="Juara 2">Juara 2</option>
              <option value="Juara 3">Juara 3</option>
              <option value="Harapan 1">Harapan 1</option>
              <option value="Harapan 2">Harapan 2</option>
              <option value="Harapan 3">Harapan 3</option>
              <option value="Peserta">Peserta</option>
            </select>
            <label>Juara</label>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-floating mb-3">
            <input type="date" name="prestasi_tanggal[]" class="form-control">
            <label>Tanggal Prestasi</label>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-floating mb-3">
            <input type="text" name="prestasi_penyelenggara[]" class="form-control" placeholder="Penyelenggara">
            <label>Penyelenggara</label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-floating mb-3">
            <textarea name="prestasi_keterangan[]" class="form-control" style="height: 80px" placeholder="Keterangan tambahan"></textarea>
            <label>Keterangan</label>
          </div>
        </div>
      </div>
    </div>
    `;
      container.appendChild(newItem);
    });

    // Remove prestasi item function
    function removePrestasiItem(button) {
      const item = button.closest('.prestasi-item');
      item.remove();
    }

    // Make removePrestasiItem function globally accessible
    window.removePrestasiItem = removePrestasiItem;
  </script>

  <?= $this->endSection() ?>