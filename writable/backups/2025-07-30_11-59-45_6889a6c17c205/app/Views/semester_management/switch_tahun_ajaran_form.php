<?= $this->extend('layout/default'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Beralih Ke Tahun Ajaran</h4>
            </div>
            <div class="card-body">
                <?php if (session()->has('error')) : ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('errors')) : ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="alert alert-info">
                    <strong>Catatan Penting:</strong>
                    <p>
                        Fitur ini memungkinkan Anda untuk beralih ke tahun ajaran tertentu untuk melihat atau mengupdate data
                        tanpa mengubah data tahun ajaran lainnya. Data akan disimpan sesuai dengan tahun ajaran yang dipilih.
                    </p>
                    <p>
                        Tahun ajaran yang Anda lihat saat ini:
                        <strong class="text-primary">
                            <?= isset($current_tahun_ajaran) ? esc($current_tahun_ajaran->ket_tahun) . ' (Semester ' . session()->get('semester_view', '1') . ')' : 'Tahun ajaran aktif'; ?>
                        </strong>
                    </p>
                    <?php if (session()->get('id_tahun_ajaran_view')): ?>
                        <div class="alert alert-warning mt-2 mb-0">
                            <i class="mdi mdi-alert me-2"></i>
                            <strong>Anda sedang melihat data tahun ajaran yang berbeda dari tahun ajaran aktif!</strong>
                            Semua data yang ditampilkan dan perubahan yang dilakukan akan terkait dengan tahun ajaran yang sedang dilihat.
                        </div>
                    <?php endif; ?>
                </div>

                <form id="switchTahunAjaranForm" action="<?= base_url('semester-management/switch-tahun-ajaran-process'); ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <div class="form-group">
                        <label for="id_tahun_ajaran">Pilih Tahun Ajaran</label>
                        <select name="id_tahun_ajaran" id="id_tahun_ajaran" class="form-control" required>
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            <?php foreach ($tahun_ajaran_list as $ta): ?>
                                <option value="<?= $ta->id_tahun_ajaran ?>" <?= (isset($current_tahun_ajaran) && $current_tahun_ajaran->id_tahun_ajaran == $ta->id_tahun_ajaran) ? 'selected' : '' ?>>
                                    <?= $ta->ket_tahun ?> <?= ($ta->status == 'Aktif') ? '(Aktif)' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="button" id="submitBtn" class="btn btn-primary">Beralih Ke Tahun Ajaran</button>
                        <a href="<?= base_url('semester-management/reset-tahun-ajaran'); ?>" class="btn btn-warning">
                            Kembali Ke Tahun Ajaran Aktif
                        </a>
                    </div>
                </form>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.getElementById('submitBtn').addEventListener('click', function() {
                            // Display loading indicator
                            Swal.fire({
                                title: 'Memproses...',
                                text: 'Sedang beralih ke tahun ajaran yang dipilih',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                willOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            const form = document.getElementById('switchTahunAjaranForm');
                            const formData = new FormData(form);

                            fetch(form.action, {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest'
                                    },
                                    credentials: 'same-origin'
                                })
                                .then(response => {
                                    if (response.status === 403) {
                                        throw new Error('Tidak diizinkan: Sesi mungkin telah berakhir atau Anda tidak memiliki akses');
                                    }
                                    if (!response.ok) {
                                        throw new Error('Gagal: ' + response.status);
                                    }
                                    return response.text();
                                })
                                .then(data => {
                                    try {
                                        // Try to parse as JSON
                                        const jsonData = JSON.parse(data);
                                        if (jsonData.success) {
                                            Swal.fire('Berhasil!', jsonData.message, 'success')
                                                .then(() => {
                                                    window.location.href = '<?= base_url('/') ?>';
                                                });
                                        } else {
                                            Swal.fire('Gagal!', jsonData.message || 'Terjadi kesalahan', 'error');
                                        }
                                    } catch (e) {
                                        // If not JSON, probably a redirect happened
                                        window.location.href = '<?= base_url('/') ?>';
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire('Error!', error.message || 'Terjadi kesalahan sistem', 'error');
                                });
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>