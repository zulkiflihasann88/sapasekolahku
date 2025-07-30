<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4"><?= $title ?></h1>

                <?php if (session()->getFlashdata('message')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
                <?php endif; ?>

                <!-- Info Tahun Ajaran Saat Ini -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Info Tahun Ajaran Saat Ini</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Current Tahun Ajaran:</strong> <?= $current_tahun_ajaran['nama_ta'] ?? 'Tidak ada' ?> (ID: <?= $current_tahun_ajaran['id'] ?? 'N/A' ?>)</p>
                        <p><strong>Viewing Tahun Ajaran:</strong> <?= $viewing_info['nama_ta'] ?> (ID: <?= $viewing_info['id'] ?>)</p>
                        <p><strong>Status:</strong>
                            <?php if ($current_tahun_ajaran['id'] == $viewing_info['id']): ?>
                                <span class="badge bg-success">Viewing Current</span>
                            <?php else: ?>
                                <span class="badge bg-warning">Viewing Different</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

                <!-- Switch Tahun Ajaran -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Switch Tahun Ajaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="/sekolahku/test-switch-tahun-ajaran/switch/1" class="btn btn-primary w-100 mb-2">Set TA ID 1</a>
                            </div>
                            <div class="col-md-3">
                                <a href="/sekolahku/test-switch-tahun-ajaran/switch/2" class="btn btn-primary w-100 mb-2">Set TA ID 2</a>
                            </div>
                            <div class="col-md-3">
                                <a href="/sekolahku/test-switch-tahun-ajaran/switch/3" class="btn btn-primary w-100 mb-2">Set TA ID 3</a>
                            </div>
                            <div class="col-md-3">
                                <a href="/sekolahku/test-switch-tahun-ajaran/reset" class="btn btn-warning w-100 mb-2">Reset Session</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Dinamis -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Data Dinamis (Real-time)</h5>
                        <button class="btn btn-success btn-sm" onclick="loadDataDinamis()">Refresh Data</button>
                    </div>
                    <div class="card-body" id="data-dinamis">
                        <p><em>Klik "Refresh Data" untuk melihat data terkini...</em></p>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="card">
                    <div class="card-header">
                        <h5>Quick Test Links</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="/sekolahku/beranda" class="btn btn-outline-primary w-100 mb-2" target="_blank">Dashboard</a>
                            </div>
                            <div class="col-md-3">
                                <a href="/sekolahku/peserta-didik" class="btn btn-outline-primary w-100 mb-2" target="_blank">Peserta Didik</a>
                            </div>
                            <div class="col-md-3">
                                <a href="/sekolahku/api/siswa" class="btn btn-outline-primary w-100 mb-2" target="_blank">API Siswa</a>
                            </div>
                            <div class="col-md-3">
                                <a href="/sekolahku/profile" class="btn btn-outline-primary w-100 mb-2" target="_blank">Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function loadDataDinamis() {
            $('#data-dinamis').html('<p><em>Loading...</em></p>');

            $.get('/sekolahku/test-switch-tahun-ajaran/data-dinamis')
                .done(function(data) {
                    var html = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Info Tahun Ajaran:</h6>
                        <p><strong>Current:</strong> ${data.current_tahun_ajaran.nama_ta} (ID: ${data.current_tahun_ajaran.id})</p>
                        <p><strong>Viewing:</strong> ${data.viewing_info.nama_ta} (ID: ${data.viewing_info.id})</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Field Names:</h6>
                        <p><strong>Siswa:</strong> ${data.siswa_field}</p>
                        <p><strong>Guru:</strong> ${data.guru_field}</p>
                        <p><strong>Mapel:</strong> ${data.mapel_field}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">${data.jumlah_siswa}</h5>
                                <p class="card-text">Jumlah Siswa</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">${data.jumlah_guru}</h5>
                                <p class="card-text">Jumlah Guru</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">${data.jumlah_mapel}</h5>
                                <p class="card-text">Jumlah Mapel</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
                    $('#data-dinamis').html(html);
                })
                .fail(function() {
                    $('#data-dinamis').html('<div class="alert alert-danger">Error loading data</div>');
                });
        }

        // Auto load data saat halaman dimuat
        $(document).ready(function() {
            loadDataDinamis();
        });
    </script>
</body>

</html>