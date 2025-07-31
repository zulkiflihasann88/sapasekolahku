<?php
// Partial view untuk kolom aksi DataTables server-side
$item = (object) $item;
?>
<div class="btn-group" role="group">
    <button class="btn btn-outline-primary btn-sm edit-btn" onclick="editData(<?= $item->id_wali_kelas ?>)" title="Edit">
        <i class="bx bx-edit-alt"></i>
    </button>
    <a class="btn btn-outline-info btn-sm" href="<?= site_url('wali_kelas/anggotaRombel/' . urlencode($item->nama_rombel) . (isset($item->tahun_ajaran) ? '/' . urlencode($item->tahun_ajaran) : '')) ?>" title="Lihat Anggota Rombel">
        <i class="bx bx-group"></i>
    </a>
    <button class="btn btn-outline-danger btn-sm" onclick="deleteData(<?= $item->id_wali_kelas ?>)" title="Hapus">
        <i class="bx bx-trash"></i>
    </button>
</div>