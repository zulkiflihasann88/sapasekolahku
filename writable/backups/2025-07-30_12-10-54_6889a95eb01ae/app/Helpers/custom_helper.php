<?php
function userLogin()
{
    $db = \Config\Database::connect();
    return $db->table('users')->where('id_user', session('id_user'))->get()->getRow();
}

function countData($table)
{
    $db = \Config\Database::connect();
    if ($table === 'db_siswa') {
        // Hanya hitung siswa yang tidak ada di tabel db_mutasi (belum mutasi)
        return $db->table($table)
            ->where('id_siswa NOT IN (SELECT id_siswa FROM db_mutasi)')
            ->countAllResults();
    }
    return $db->table($table)->countAllResults();
}
