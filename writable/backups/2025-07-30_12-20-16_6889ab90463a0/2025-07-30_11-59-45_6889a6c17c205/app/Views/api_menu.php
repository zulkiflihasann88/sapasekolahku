<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Integrasi Data eRapor &mdash; SDN Krengseng 02</title>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Integrasi Data</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?= site_url('home') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">API Key</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card mt-4">
                    <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between flex-wrap">
                        <h4 class="mb-0">Integrasi eRapor - API Documentation</h4>
                        <div class="btn-group mt-2 mt-md-0">
                            <a href="<?= site_url('api/info') ?>" target="_blank" class="btn btn-light btn-sm shadow rounded-pill px-4">
                                <i class="mdi mdi-information"></i> <b>Test API Info</b>
                            </a>
                            <a href="<?= site_url('api/keys') ?>" target="_blank" class="btn btn-info btn-sm shadow rounded-pill px-4">
                                <i class="mdi mdi-key"></i> <b>Kelola API Key</b>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <strong>Gunakan endpoint berikut untuk integrasi dengan aplikasi lain.</strong><br>
                            <strong>API Key:</strong> <code><?= esc($apiKey) ?></code><br>
                            <small class="text-muted">API ini mendukung format JSON dan dapat digunakan untuk integrasi dengan sistem eRapor atau aplikasi lainnya.</small>
                        </div>

                        <h5 class="text-primary"><i class="mdi mdi-api"></i> Daftar Endpoint API</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="20%">Endpoint</th>
                                        <th width="35%">URL</th>
                                        <th width="30%">Deskripsi</th>
                                        <th width="15%">Test</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Info API</strong></td>
                                        <td><code><?= site_url('api/info') ?></code></td>
                                        <td>Informasi API (tidak perlu token)</td>
                                        <td><a href="<?= site_url('api/info') ?>" target="_blank" class="btn btn-sm btn-outline-success"><i class="mdi mdi-play"></i></a></td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td><strong>Semua Data</strong></td>
                                        <td><code><?= site_url('api/all?token=') . esc($apiKey) ?></code></td>
                                        <td>Ambil semua data dalam 1 request (rekomendasi)</td>
                                        <td><a href="<?= site_url('api/all?token=') . esc($apiKey) ?>" target="_blank" class="btn btn-sm btn-outline-primary"><i class="mdi mdi-play"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Data Siswa</strong></td>
                                        <td><code><?= site_url('api/siswa?token=') . esc($apiKey) ?></code></td>
                                        <td>Data seluruh siswa</td>
                                        <td><a href="<?= site_url('api/siswa?token=') . esc($apiKey) ?>" target="_blank" class="btn btn-sm btn-outline-primary"><i class="mdi mdi-play"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Data Guru</strong></td>
                                        <td><code><?= site_url('api/guru?token=') . esc($apiKey) ?></code></td>
                                        <td>Data seluruh guru/pendidik</td>
                                        <td><a href="<?= site_url('api/guru?token=') . esc($apiKey) ?>" target="_blank" class="btn btn-sm btn-outline-primary"><i class="mdi mdi-play"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Data Mata Pelajaran</strong></td>
                                        <td><code><?= site_url('api/mapel?token=') . esc($apiKey) ?></code></td>
                                        <td>Data mata pelajaran</td>
                                        <td><a href="<?= site_url('api/mapel?token=') . esc($apiKey) ?>" target="_blank" class="btn btn-sm btn-outline-primary"><i class="mdi mdi-play"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Data Kelas</strong></td>
                                        <td><code><?= site_url('api/kelas?token=') . esc($apiKey) ?></code></td>
                                        <td>Data kelas/rombongan belajar</td>
                                        <td><a href="<?= site_url('api/kelas?token=') . esc($apiKey) ?>" target="_blank" class="btn btn-sm btn-outline-primary"><i class="mdi mdi-play"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Data Sekolah</strong></td>
                                        <td><code><?= site_url('api/sekolah?token=') . esc($apiKey) ?></code></td>
                                        <td>Data profil sekolah/lembaga</td>
                                        <td><a href="<?= site_url('api/sekolah?token=') . esc($apiKey) ?>" target="_blank" class="btn btn-sm btn-outline-primary"><i class="mdi mdi-play"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Data Tahun Ajaran</strong></td>
                                        <td><code><?= site_url('api/tahun_ajaran?token=') . esc($apiKey) ?></code></td>
                                        <td>Data tahun pelajaran</td>
                                        <td><a href="<?= site_url('api/tahun_ajaran?token=') . esc($apiKey) ?>" target="_blank" class="btn btn-sm btn-outline-primary"><i class="mdi mdi-play"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="text-primary mt-4"><i class="mdi mdi-code-tags"></i> Contoh Penggunaan (PHP)</h5>
                        <div class="row">
                            <div class="col-lg-6">
                                <h6>Ambil Semua Data Sekaligus:</h6>
                                <pre class="bg-light p-3 rounded"><code class="language-php">// Mengambil semua data dalam 1 request
$apiUrl = '<?= site_url('api/all?token=') . esc($apiKey) ?>';
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);

if ($data['status'] === 'success') {
    $siswa = $data['data']['siswa'];
    $guru = $data['data']['guru'];
    $mapel = $data['data']['mapel'];
    $kelas = $data['data']['kelas'];
    // dst...
}</code></pre>
                            </div>
                            <div class="col-lg-6">
                                <h6>Ambil Data Spesifik:</h6>
                                <pre class="bg-light p-3 rounded"><code class="language-php">// Mengambil data siswa saja
$apiUrl = '<?= site_url('api/siswa?token=') . esc($apiKey) ?>';
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);

if ($data['status'] === 'success') {
    $siswa = $data['data'];
    echo "Total siswa: " . $data['total'];
}</code></pre>
                            </div>
                        </div>

                        <h5 class="text-primary mt-4"><i class="mdi mdi-code-json"></i> Contoh Penggunaan (JavaScript/AJAX)</h5>
                        <pre class="bg-light p-3 rounded"><code class="language-javascript">// Menggunakan Fetch API
const apiUrl = '<?= site_url('api/all?token=') . esc($apiKey) ?>';

fetch(apiUrl)
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            console.log('Data siswa:', data.data.siswa);
            console.log('Data guru:', data.data.guru);
            // Proses data lainnya...
        }
    })
    .catch(error => console.error('Error:', error));

// Atau menggunakan header untuk token
fetch('<?= site_url('api/all') ?>', {
    headers: {
        'X-API-KEY': '<?= esc($apiKey) ?>'
    }
})</code></pre>

                        <h5 class="text-primary mt-4"><i class="mdi mdi-information"></i> Informasi Penting</h5>
                        <div class="alert alert-warning">
                            <ul class="mb-0">
                                <li><strong>Autentikasi:</strong> Token wajib dikirim via parameter <code>?token=...</code> atau header <code>X-API-KEY</code></li>
                                <li><strong>Format Response:</strong> Semua endpoint mengembalikan data dalam format JSON</li>
                                <li><strong>CORS:</strong> Sudah dikonfigurasi untuk mengizinkan akses dari domain lain</li>
                                <li><strong>Rate Limiting:</strong> Gunakan endpoint <code>/api/all</code> untuk efisiensi jika membutuhkan banyak data</li>
                                <li><strong>Keamanan:</strong> Jangan bagikan API Key ini sembarangan dan ganti di produksi</li>
                            </ul>
                        </div>

                        <h5 class="text-primary mt-4"><i class="mdi mdi-code-braces"></i> Contoh Response JSON</h5>
                        <div class="row">
                            <div class="col-lg-6">
                                <h6>Response Sukses:</h6>
                                <pre class="bg-light p-3 rounded"><code class="language-json">{
    "status": "success",
    "message": "Data berhasil diambil",
    "total": 150,
    "data": [
        {
            "id": 1,
            "nama": "John Doe",
            "nisn": "1234567890",
            // ... data lainnya
        }
    ]
}</code></pre>
                            </div>
                            <div class="col-lg-6">
                                <h6>Response Error:</h6>
                                <pre class="bg-light p-3 rounded"><code class="language-json">{
    "status": 401,
    "error": 401,
    "message": "Token/API Key tidak valid."
}</code></pre>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <h6><i class="mdi mdi-lightbulb-outline"></i> Tips Penggunaan:</h6>
                                    <ul class="mb-0">
                                        <li>Untuk testing API, gunakan tools seperti Postman atau browser langsung</li>
                                        <li>Simpan response ke cache lokal jika data tidak sering berubah</li>
                                        <li>Implementasikan error handling yang baik di aplikasi Anda</li>
                                        <li>Endpoint <code>/api/info</code> tidak memerlukan token dan bisa digunakan untuk health check</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->endSection() ?>