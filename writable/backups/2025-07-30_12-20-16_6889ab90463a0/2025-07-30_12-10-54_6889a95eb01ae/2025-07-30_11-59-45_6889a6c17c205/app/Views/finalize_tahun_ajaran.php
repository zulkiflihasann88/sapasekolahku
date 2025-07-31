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

                <!-- Status Implementation -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5>✅ Status Implementasi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Perbaikan Telah Selesai:</h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">✅ Helper tahun ajaran dinamis</li>
                                    <li class="list-group-item">✅ Controller Home (dashboard statistik)</li>
                                    <li class="list-group-item">✅ Controller Profile (profile statistik)</li>
                                    <li class="list-group-item">✅ Controller Api (API siswa/kelas)</li>
                                    <li class="list-group-item">✅ Controller Siswa (peserta didik)</li>
                                    <li class="list-group-item">✅ Model SiswaModel (filter dinamis)</li>
                                    <li class="list-group-item">✅ Relasi tahun ajaran di database</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>Fitur Dinamis:</h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">✅ Data berubah sesuai tahun ajaran</li>
                                    <li class="list-group-item">✅ Statistik dashboard dinamis</li>
                                    <li class="list-group-item">✅ Daftar peserta didik per tahun ajaran</li>
                                    <li class="list-group-item">✅ API data per tahun ajaran</li>
                                    <li class="list-group-item">✅ Profile statistik dinamis</li>
                                    <li class="list-group-item">✅ Filter kelas per tahun ajaran</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Validation Report -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between">
                        <h5>📊 Laporan Validasi Data</h5>
                        <button class="btn btn-primary btn-sm" onclick="generateValidationReport()">Generate Report</button>
                    </div>
                    <div class="card-body" id="validation-report">
                        <p><em>Klik "Generate Report" untuk melihat hasil validasi data dinamis...</em></p>
                    </div>
                </div>

                <!-- Cleanup Options -->
                <div class="card mb-4">
                    <div class="card-header bg-warning">
                        <h5>🧹 Cleanup File Debug</h5>
                    </div>
                    <div class="card-body">
                        <p>Setelah validasi selesai, Anda dapat membersihkan file-file debug yang tidak diperlukan lagi.</p>
                        <button class="btn btn-warning" onclick="cleanupDebugFiles()">Cleanup Debug Files</button>
                        <div id="cleanup-result" class="mt-3"></div>
                    </div>
                </div>

                <!-- Final Test Links -->
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5>🔗 Test Final Application</h5>
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
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="/sekolahku/test-switch-tahun-ajaran" class="btn btn-outline-success w-100 mb-2" target="_blank">Test Switch Tahun Ajaran</a>
                            </div>
                            <div class="col-md-6">
                                <a href="/sekolahku/semester-management/switch-tahun-ajaran" class="btn btn-outline-success w-100 mb-2" target="_blank">Switch Tahun Ajaran UI</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function generateValidationReport() {
            $('#validation-report').html('<p><em>Generating validation report...</em></p>');

            $.get('/sekolahku/finalize-tahun-ajaran/validation-report')
                .done(function(data) {
                    if (data.success) {
                        var html = '<div class="table-responsive"><table class="table table-striped">';
                        html += '<thead><tr><th>Tahun Ajaran</th><th>Nama</th><th>Jumlah Siswa</th><th>Jumlah Guru</th><th>Status Data</th></tr></thead><tbody>';

                        data.test_results.forEach(function(result) {
                            var statusBadge = result.data_dinamis ?
                                '<span class="badge bg-success">Data Dinamis ✅</span>' :
                                '<span class="badge bg-danger">No Data ❌</span>';

                            html += `<tr>
                        <td>${result.tahun_ajaran_id}</td>
                        <td>${result.tahun_ajaran_nama}</td>
                        <td>${result.jumlah_siswa}</td>
                        <td>${result.jumlah_guru}</td>
                        <td>${statusBadge}</td>
                    </tr>`;
                        });

                        html += '</tbody></table></div>';
                        html += `<div class="alert alert-info mt-3">
                    <strong>Summary:</strong> ${data.summary.dynamic_data_found}/${data.summary.total_tests} tahun ajaran memiliki data dinamis.
                </div>`;

                        $('#validation-report').html(html);
                    } else {
                        $('#validation-report').html('<div class="alert alert-danger">Error generating report</div>');
                    }
                })
                .fail(function() {
                    $('#validation-report').html('<div class="alert alert-danger">Error generating report</div>');
                });
        }

        function cleanupDebugFiles() {
            if (!confirm('Apakah Anda yakin ingin menghapus semua file debug? Tindakan ini tidak dapat dibatalkan.')) {
                return;
            }

            $('#cleanup-result').html('<p><em>Cleaning up debug files...</em></p>');

            $.get('/sekolahku/finalize-tahun-ajaran/cleanup-debug-files')
                .done(function(data) {
                    if (data.success) {
                        var html = '<div class="alert alert-success">' + data.message + '</div>';
                        if (data.cleaned_files.length > 0) {
                            html += '<h6>Files Cleaned:</h6><ul>';
                            data.cleaned_files.forEach(function(file) {
                                html += '<li>' + file + '</li>';
                            });
                            html += '</ul>';
                        }
                        if (data.failed_files.length > 0) {
                            html += '<h6 class="text-danger">Failed to Clean:</h6><ul>';
                            data.failed_files.forEach(function(file) {
                                html += '<li class="text-danger">' + file + '</li>';
                            });
                            html += '</ul>';
                        }
                        $('#cleanup-result').html(html);
                    } else {
                        $('#cleanup-result').html('<div class="alert alert-danger">Error during cleanup</div>');
                    }
                })
                .fail(function() {
                    $('#cleanup-result').html('<div class="alert alert-danger">Error during cleanup</div>');
                });
        }

        // Auto generate validation report saat halaman dimuat
        $(document).ready(function() {
            generateValidationReport();
        });
    </script>
</body>

</html>