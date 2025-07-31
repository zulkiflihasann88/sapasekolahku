<?= $this->extend('layout/default') ?>
<?= $this->section('title') ?>
<title>Data User</title>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4 class="mb-sm-0 font-size-18">Data User</h4>
          <div class="page-title-right">
            <ol class="breadcrumb m-0">
              <li class="breadcrumb-item"><a href="#">User</a></li>
              <li class="breadcrumb-item active">Data User</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-md-12">
        <div class="alert alert-info mb-2">
          <b>Selamat datang di menu Data User!</b> Anda dapat melihat, menambah, dan mengelola data user aplikasi di sini.
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <!-- Modal Tambah User -->
        <div class="modal fade" id="modalTambahUser" tabindex="-1" aria-labelledby="modalTambahUserLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="<?= site_url('user/tambah') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                  <h5 class="modal-title" id="modalTambahUserLabel">Tambah User</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" name="nama" id="nama" required>
                  </div>
                  <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                  </div>
                  <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-control" name="role" id="role" required>
                      <option value="">Pilih Role</option>
                      <option value="guru_kelas">Guru Kelas</option>
                      <option value="guru_mapel">Guru Mapel</option>
                      <option value="admin">Administrator</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="mb-3 d-flex justify-content-between align-items-center">
          <button class="btn btn-success" id="btn-tambah-user"><i class="mdi mdi-account-plus"></i> Tambah User</button>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var btnTambah = document.getElementById('btn-tambah-user');
  if (btnTambah) {
    btnTambah.addEventListener('click', function() {
      var modal = new bootstrap.Modal(document.getElementById('modalTambahUser'));
      modal.show();
    });
  }
});
</script>
          <button class="btn btn-primary" id="btn-generate-user"><i class="mdi mdi-account-multiple-plus"></i> Generate User</button>
        <!-- SweetAlert2 Center Fix (Stronger) -->
        <style>
        /* Force SweetAlert2 to always be centered in the viewport */
        body > .swal2-container {
          position: fixed !important;
          top: 0 !important;
          left: 0 !important;
          right: 0 !important;
          bottom: 0 !important;
          width: 100vw !important;
          height: 100vh !important;
          z-index: 99999 !important;
          display: flex !important;
          align-items: center !important;
          justify-content: center !important;
          pointer-events: auto !important;
          margin: 0 !important;
          padding: 0 !important;
        }
        body > .swal2-container .swal2-popup {
          margin: auto !important;
          position: static !important;
          left: auto !important;
          top: auto !important;
          right: auto !important;
          bottom: auto !important;
          transform: none !important;
        }
        </style>
        </div>
        <!-- SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
          var btnGenerate = document.getElementById('btn-generate-user');
          if (btnGenerate) {
            btnGenerate.addEventListener('click', function() {
              Swal.fire({
                title: 'Generate User Guru?',
                text: 'Generate user guru berdasarkan NIP. User yang sudah ada tidak akan diduplikasi. Lanjutkan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Generate!',
                cancelButtonText: 'Batal',
                reverseButtons: true
              }).then((result) => {
                if (result.isConfirmed) {
                  btnGenerate.disabled = true;
                  btnGenerate.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';
                  fetch('<?= site_url('user/generateGuru') ?>', {
                    method: 'POST',
                    headers: {
                      'X-Requested-With': 'XMLHttpRequest',
                      'Content-Type': 'application/x-www-form-urlencoded',
                      'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                    },
                    body: '<?= csrf_token() ?>=<?= csrf_hash() ?>'
                  })
                  .then(response => response.json())
                  .then(data => {
                    Swal.fire({
                      title: 'Selesai!',
                      text: 'Generate user guru selesai. User baru: ' + data.created,
                      icon: 'success',
                      confirmButtonText: 'OK'
                    }).then(() => location.reload());
                  })
                  .catch(() => {
                    Swal.fire('Gagal', 'Terjadi kesalahan saat generate user guru.', 'error');
                    btnGenerate.disabled = false;
                    btnGenerate.innerHTML = '<i class="mdi mdi-account-multiple-plus"></i> Generate User';
                  });
                }
              });
            });
          }
        });
        </script>
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead style="background:#395bfa;color:#fff;">
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
      <?php if (isset($users) && (is_array($users) || is_object($users)) && count($users) > 0): ?>
        <?php $i = 1; foreach ($users as $user): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= esc(isset($user->nama) && $user->nama ? $user->nama : (isset($user->name) ? $user->name : '-')) ?></td>
            <td><?= esc(isset($user->username) ? $user->username : '-') ?></td>
            <td><?= esc(isset($user->email) ? $user->email : '-') ?></td>
            <td><?= esc(isset($user->role) ? $user->role : '-') ?></td>
            <td><span class="badge bg-success">Aktif</span></td>
            <td>
              <button 
                class="btn btn-sm btn-primary btn-edit-user" 
                data-id="<?= $user->id_user ?>"
                data-nama="<?= esc(isset($user->nama) && $user->nama ? $user->nama : (isset($user->name) ? $user->name : '')) ?>"
                data-username="<?= esc(isset($user->username) ? $user->username : '') ?>"
                data-email="<?= esc(isset($user->email) ? $user->email : '') ?>"
                data-role="<?= esc(isset($user->role) ? $user->role : '') ?>"
              >Edit</button>
              <button class="btn btn-sm btn-danger">Hapus</button>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="7" class="text-center">Tidak ada data user.</td></tr>
      <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= site_url('user/update') ?>" method="post" id="formEditUser">
        <?= csrf_field() ?>
        <input type="hidden" name="id" id="edit-id">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditUserLabel">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="edit-nama" class="form-label">Nama</label>
            <input type="text" class="form-control" name="nama" id="edit-nama" required>
          </div>
          <div class="mb-3">
            <label for="edit-username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="edit-username" required>
          </div>
          <div class="mb-3">
            <label for="edit-email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="edit-email" required>
          </div>
          <div class="mb-3">
            <label for="edit-role" class="form-label">Role</label>
            <select class="form-control" name="role" id="edit-role" required>
              <option value="">Pilih Role</option>
              <option value="guru_kelas">Guru Kelas</option>
              <option value="guru_mapel">Guru Mapel</option>
              <option value="admin">Administrator</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="edit-password" class="form-label">Password (Kosongkan jika tidak diubah)</label>
            <input type="password" class="form-control" name="password" id="edit-password">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Tambah User
  var btnTambah = document.getElementById('btn-tambah-user');
  if (btnTambah) {
    btnTambah.addEventListener('click', function() {
      var modal = new bootstrap.Modal(document.getElementById('modalTambahUser'));
      modal.show();
    });
  }

  // Edit User
  var editButtons = document.querySelectorAll('.btn-edit-user');
  editButtons.forEach(function(btn) {
    btn.addEventListener('click', function() {
      document.getElementById('edit-id').value = btn.getAttribute('data-id');
      document.getElementById('edit-nama').value = btn.getAttribute('data-nama');
      document.getElementById('edit-username').value = btn.getAttribute('data-username');
      document.getElementById('edit-email').value = btn.getAttribute('data-email');
      document.getElementById('edit-role').value = btn.getAttribute('data-role');
      document.getElementById('edit-password').value = '';
      var modal = new bootstrap.Modal(document.getElementById('modalEditUser'));
      modal.show();
    });
  });
});
</script>

<?= $this->endSection() ?>
