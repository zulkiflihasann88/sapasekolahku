<style>
    .absen-table {
        border-collapse: collapse;
        width: 100%;
        font-size: 13px;
    }

    .absen-table th,
    .absen-table td {
        border: 1px solid #333;
        padding: 5px 4px;
        text-align: center;
    }

    .absen-table th {
        background: #f2f2f2;
        font-weight: bold;
    }

    .absen-table tr:nth-child(even) {
        background: #fafafa;
    }

    .absen-table td {
        height: 28px;
    }

    .absen-table .nama-siswa {
        text-align: left;
        padding-left: 8px;
        white-space: nowrap;
        min-width: 90px;
        max-width: 180px;
    }
</style>
<div style="text-align:center; margin-bottom:20px;">
    <h3 style="margin:0;">DAFTAR SISWA</h3>
    <div style="font-size:16px;">
        Kelas: <b><?= htmlspecialchars($nama_rombel) ?></b><br>
        Tahun Ajaran: <b><?= isset($tahun_ajaran) ? htmlspecialchars($tahun_ajaran) : '-' ?></b><br>
        Wali Kelas: <b><?= isset($nama_wali) ? htmlspecialchars($nama_wali) : '-' ?></b>
    </div>
</div>
<table class="absen-table">
    <thead>
        <tr>
            <th width="20">No</th>
            <th width="80">NISN/NIS</th>
            <th width="180">Nama Siswa</th>
            <th width="40">L/P</th>
            <th width="80">Kelas</th>
            <th width="30">Ket.</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($anggota)) : $no = 1;
            foreach ($anggota as $siswa) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td>
                        <?php
                        $nisn = isset($siswa->nisn) ? $siswa->nisn : '';
                        $nis = isset($siswa->nis) ? $siswa->nis : '';
                        echo htmlspecialchars(trim($nisn . ($nisn && $nis ? ' / ' : '') . $nis));
                        ?>
                    </td>
                    <td class="nama-siswa" style="font-weight:normal; max-width:180px; overflow:hidden; text-overflow:ellipsis;"><?= htmlspecialchars($siswa->nama_siswa) ?></td>
                    <td><?= htmlspecialchars($siswa->jk) ?></td>
                    <td><?= htmlspecialchars($siswa->kelas) ?></td>
                    <td style="height:20px;"></td>
                </tr>
            <?php endforeach;
        else: ?>
            <tr>
                <td colspan="15" style="color:#888;">Tidak ada anggota rombel.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php
$laki = 0;
$perempuan = 0;
if (!empty($anggota)) {
    foreach ($anggota as $siswa) {
        if (strtolower($siswa->jk) === 'l' || strtolower($siswa->jk) === 'laki-laki') {
            $laki++;
        } elseif (strtolower($siswa->jk) === 'p' || strtolower($siswa->jk) === 'perempuan') {
            $perempuan++;
        }
    }
}
$jumlah = $laki + $perempuan;
?>
<table style="margin-top:18px; margin-left:0; font-size:14px; width:auto;">
    <tr>
        <td style="font-weight:bold;">Laki-Laki</td>
        <td style="padding:0 8px; color:red; font-weight:bold;">: <?= $laki ?> Orang</td>
    </tr>
    <tr>
        <td style="font-weight:bold;">Perempuan</td>
        <td style="padding:0 8px; color:red; font-weight:bold;">: <?= $perempuan ?> Orang</td>
    </tr>
    <tr>
        <td style="font-weight:bold;">Jumlah</td>
        <td style="padding:0 8px; color:red; font-weight:bold;">: <?= $jumlah ?> Orang</td>
    </tr>
</table>