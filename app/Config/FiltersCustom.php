<?php
// File: app/Config/FiltersCustom.php
// Tempatkan pengecualian custom filter di sini agar tidak hilang saat update

return [
    'csrf_except' => [
        'system-update/perform-update',
        // Tambahkan pengecualian lain di bawah ini jika diperlukan
    ],
];
