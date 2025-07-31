<?php if (empty($pesan_terkirim)): ?>
    <div class="text-center p-4">
        <div class="mb-3">
            <i class="mdi mdi-message-outline display-4 text-muted"></i>
        </div>
        <h5 class="text-muted">Belum ada log pesan</h5>
        <p class="text-muted">Log pesan yang dikirim akan muncul di sini</p>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-nowrap table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col">Waktu</th>
                    <th scope="col">Nomor Tujuan</th>
                    <th scope="col">Pesan</th>
                    <th scope="col">Status</th>
                    <th scope="col">Response</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pesan_terkirim as $pesan): ?>
                    <tr>
                        <td>
                            <div class="fw-medium"><?= date('d/m/Y', strtotime($pesan['created_at'])) ?></div>
                            <div class="text-muted small"><?= date('H:i:s', strtotime($pesan['created_at'])) ?></div>
                        </td>
                        <td>
                            <span class="badge bg-primary"><?= esc(isset($pesan['nomor_tujuan']) ? $pesan['nomor_tujuan'] : (isset($pesan['tujuan']) ? $pesan['tujuan'] : '-')) ?></span>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 200px;" title="<?= esc($pesan['pesan']) ?>">
                                <?= esc($pesan['pesan']) ?>
                            </div>
                        </td>
                        <td>
                            <?php if ($pesan['status'] == 'success'): ?>
                                <span class="badge bg-success">
                                    <i class="mdi mdi-check me-1"></i>Berhasil
                                </span>
                            <?php elseif ($pesan['status'] == 'pending'): ?>
                                <span class="badge bg-warning">
                                    <i class="mdi mdi-clock me-1"></i>Pending
                                </span>
                            <?php else: ?>
                                <span class="badge bg-danger">
                                    <i class="mdi mdi-close me-1"></i>Gagal
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($pesan['response_api'])): ?>
                                <button type="button" class="btn btn-sm btn-outline-info"
                                    onclick="showResponse('<?= esc($pesan['response_api']) ?>')">
                                    <i class="mdi mdi-eye"></i> Lihat
                                </button>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            onclick="resendMessage('<?= esc(isset($pesan['nomor_tujuan']) ? $pesan['nomor_tujuan'] : (isset($pesan['tujuan']) ? $pesan['tujuan'] : '')) ?>', '<?= esc($pesan['pesan']) ?>')">
                                            <i class="mdi mdi-refresh me-2"></i>Kirim Ulang
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#"
                                            onclick="deleteLog(<?= $pesan['id'] ?>)">
                                            <i class="mdi mdi-delete me-2"></i>Hapus Log
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination jika diperlukan -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="text-center text-muted">
                <small>Menampilkan <?= count($pesan_terkirim) ?> pesan terakhir</small>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    // Setup CSRF token untuk semua AJAX requests (jika belum ada dari parent)
    if (typeof $ !== 'undefined' && !$.ajaxSettings.beforeSend) {
        $.ajaxSetup({
            beforeSend: function(xhr, settings) {
                if (settings.type == 'POST' && !this.crossDomain) {
                    const csrfName = $('meta[name=csrf-token-name]').attr('content') || 'csrf_test_name';
                    const csrfHash = $('meta[name=csrf-token]').attr('content') || '';
                    if (csrfHash && !settings.data) {
                        settings.data = {};
                    }
                    if (csrfHash && typeof settings.data === 'string') {
                        settings.data += '&' + csrfName + '=' + csrfHash;
                    } else if (csrfHash && typeof settings.data === 'object') {
                        settings.data[csrfName] = csrfHash;
                    }
                }
            }
        });
    }

    // Fungsi untuk menampilkan response API
    function showResponse(response) {
        Swal.fire({
            title: 'Response API',
            html: '<pre style="text-align: left; white-space: pre-wrap;">' + response + '</pre>',
            icon: 'info',
            confirmButtonText: 'Tutup'
        });
    }

    // Fungsi untuk mengirim ulang pesan
    function resendMessage(number, message) {
        Swal.fire({
            title: 'Kirim Ulang Pesan?',
            text: 'Pesan akan dikirim ulang ke nomor ' + number,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Kirim!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('<?= site_url('wa_gateway/sendMessage') ?>', {
                    number: number,
                    message: message
                }, function(data) {
                    if (data.success) {
                        Swal.fire('Berhasil', 'Pesan berhasil dikirim ulang', 'success');
                        // Reload log
                        loadLog();
                    } else {
                        Swal.fire('Error', data.message || 'Gagal mengirim pesan', 'error');
                    }
                }).fail(function() {
                    Swal.fire('Error', 'Gagal mengirim pesan', 'error');
                });
            }
        });
    }

    // Fungsi untuk menghapus log
    function deleteLog(id) {
        Swal.fire({
            title: 'Hapus Log?',
            text: 'Log pesan ini akan dihapus secara permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Get CSRF token
                const csrfName = $('meta[name=csrf-token-name]').attr('content') || 'csrf_test_name';
                const csrfHash = $('meta[name=csrf-token]').attr('content') || '';

                const postData = {
                    id: id
                };

                // Add CSRF token if available
                if (csrfHash) {
                    postData[csrfName] = csrfHash;
                }

                $.ajax({
                    url: '<?= site_url('wa_gateway/deleteLog') ?>',
                    type: 'POST',
                    data: postData,
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            Swal.fire('Berhasil', 'Log berhasil dihapus', 'success');
                            // Reload log
                            loadLog();
                        } else {
                            Swal.fire('Error', data.message || 'Gagal menghapus log', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error details:', xhr.responseText);
                        if (xhr.status === 403) {
                            Swal.fire('Error', 'Akses ditolak. Silakan refresh halaman dan coba lagi.', 'error');
                        } else {
                            Swal.fire('Error', 'Gagal menghapus log: ' + error, 'error');
                        }
                    }
                });
            }
        });
    }

    // Fungsi untuk memuat ulang log (jika dipanggil dari halaman utama)
    function loadLog() {
        if (typeof parent.loadLog === 'function') {
            parent.loadLog();
        } else {
            location.reload();
        }
    }
</script>