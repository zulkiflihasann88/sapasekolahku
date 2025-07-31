<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Tidak Ditemukan</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; color: #333; }
        .container { max-width: 480px; margin: 80px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 12px #0001; padding: 32px 24px; text-align: center; }
        h1 { color: #d32f2f; font-size: 2em; margin-bottom: 12px; }
        p { margin-bottom: 24px; }
        a.btn { display: inline-block; background: #1976d2; color: #fff; padding: 10px 24px; border-radius: 4px; text-decoration: none; font-weight: bold; transition: background 0.2s; }
        a.btn:hover { background: #1565c0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Data Tidak Ditemukan</h1>
        <p>Data calon siswa dengan ID <b><?= htmlspecialchars($id) ?></b> tidak ditemukan di database.</p>
        <a href="<?= site_url('calon_siswa') ?>" class="btn">Kembali ke Daftar</a>
    </div>
</body>
</html>
