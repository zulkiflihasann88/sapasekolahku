<?php
// Partial view untuk select tahun ajaran dan semester
use App\Models\TapelModel;

$tapelModel = new TapelModel();
$tapelList = $tapelModel->orderBy('tahun', 'DESC')->findAll();
?>
<div class="mb-3">
    <label for="tapel" class="form-label">Tahun Ajaran</label>
    <select name="tapel" id="tapel" class="form-control" required>
        <option value="">-- Pilih Tahun Ajaran --</option>
        <?php foreach ($tapelList as $t): ?>
            <option value="<?= $t->id_tahun_ajaran ?>">
                <?= $t->ket_tahun ?><?= $t->semester ? ' (' . ucfirst(strtolower($t->semester)) . ')' : '' ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>