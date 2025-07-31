<!DOCTYPE html>
<html>

<head>
    <title>Laporan Surat Masuk</title>
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
    <h1>Laporan Surat Masuk</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Agenda</th>
                <th>Nomor Surat</th>
                <th>Tanggal Surat</th>
                <th>Pengirim</th>
                <th>Perihal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($masukData as $index => $data): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $data->no_agenda ?></td>
                    <td><?= $data->nomor_surat ?></td>
                    <td><?= $data->tgl_surat ?></td>
                    <td><?= $data->pengirim ?></td>
                    <td><?= $data->perihal ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>