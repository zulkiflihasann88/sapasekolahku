<?php
// File: app/Config/RoutesCustom.php
// Tempatkan semua custom route di sini agar tidak hilang saat update

$routes->post('system-update/perform-update', 'SystemUpdate::performUpdate');
// Tambahkan custom route lain di bawah ini jika diperlukan
