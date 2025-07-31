<?php

/**
 * Tahun Ajaran Indicator Component
 * 
 * This component displays the current viewing tahun ajaran and semester
 * It can be used anywhere in the application to provide consistent information to users
 */

// Get the data from session
$tahunAjaranView = session()->get('ket_tahun_view');
$semesterView = session()->get('semester_view');
$tahunAjaranAktif = session()->get('ket_tahun');
$semesterAktif = session()->get('semester_aktif');

// Check if we're viewing a different tahun ajaran than the active one
$isViewingDifferent = ($tahunAjaranView && $tahunAjaranAktif &&
    ($tahunAjaranView != $tahunAjaranAktif || $semesterView != $semesterAktif));

// Only display if we're viewing a specific tahun ajaran
if ($tahunAjaranView && $semesterView):
?>

    <div class="tahun-ajaran-indicator mb-4">
        <div class="card border-0">
            <div class="card-body p-0">
                <?php if ($isViewingDifferent): ?>
                    <!-- Different tahun ajaran indicator -->
                    <div class="viewing-alert-container">
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <div class="d-flex align-items-center mb-2 mb-md-0">
                                <i class="mdi mdi-calendar-eye me-2" style="font-size: 1.3rem;"></i>
                                <div>
                                    <h6 class="mb-1">Anda sedang melihat data:</h6>
                                    <div>
                                        <span class="highlight-text me-2">Tahun Ajaran <?= $tahunAjaranView ?></span>
                                        <span class="highlight-text">Semester <?= $semesterView ?></span>
                                    </div>
                                </div>
                            </div>
                            <a href="<?= site_url('semester-management/reset-tahun-ajaran') ?>" class="btn btn-sm btn-dark">
                                <i class="mdi mdi-refresh me-1"></i>Kembali ke Tahun Ajaran Aktif
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Current active tahun ajaran indicator -->
                    <div class="active-tahun-container">
                        <div class="d-flex flex-wrap align-items-center">
                            <i class="mdi mdi-calendar-check me-2" style="font-size: 1.3rem; color: #1cc88a;"></i>
                            <div>
                                <h6 class="mb-1">Tahun Ajaran Aktif:</h6>
                                <div class="d-flex flex-wrap align-items-center">
                                    <span class="badge bg-success me-2 px-3 py-2 mb-1 mb-sm-0">Tahun Ajaran <?= $tahunAjaranView ?></span>
                                    <span class="badge bg-primary px-3 py-2">Semester <?= $semesterView ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php endif; ?>