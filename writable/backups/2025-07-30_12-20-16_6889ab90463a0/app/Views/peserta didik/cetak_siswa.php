<!DOCTYPE html>
<html>

<head>
    <title>Data Peserta Didik</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Data Peserta Didik</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>NIS</th>
                <th>Jenis Kelamin</th>
                <th>NISN</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>NIK</th>
                <th>Agama</th>
                <th>Alamat</th>
                <th>RT</th>
                <th>RW</th>
                <!-- Add other fields as necessary -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($peserta_didik as $index => $siswa): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $siswa->nama_siswa ?></td>
                    <td><?= $siswa->nis ?></td>
                    <td><?= $siswa->jk ?></td>
                    <td><?= $siswa->nisn ?></td>
                    <td><?= $siswa->tempat_lahir ?></td>
                    <td><?= $siswa->tanggal_lahir ?></td>
                    <td><?= $siswa->nik ?></td>
                    <td><?= $siswa->id_agama ?></td>
                    <td><?= $siswa->alamat ?></td>
                    <td><?= $siswa->rt ?></td>
                    <td><?= $siswa->rw ?></td>
                    <!-- Add other fields as necessary -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>