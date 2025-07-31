<?php

if (!function_exists('getCurrentTahunAjaran')) {
    /**
     * Mendapatkan ID tahun ajaran yang sedang aktif atau sedang dilihat
     * Prioritas: id_tahun_ajaran_view (sedang dilihat) > id_tahun_ajaran_aktif (aktif)
     * 
     * @return int|null
     */
    function getCurrentTahunAjaran()
    {
        // Gunakan tahun ajaran yang sedang dilihat jika ada
        $viewingTahunAjaran = session('id_tahun_ajaran_view');
        if ($viewingTahunAjaran) {
            return (int)$viewingTahunAjaran;
        }

        // Jika tidak ada, gunakan tahun ajaran aktif
        $activeTahunAjaran = session('id_tahun_ajaran_aktif');
        if ($activeTahunAjaran) {
            return (int)$activeTahunAjaran;
        }

        return null;
    }
}

if (!function_exists('getViewingTahunAjaranInfo')) {
    /**
     * Mendapatkan informasi lengkap tahun ajaran yang sedang dilihat
     * 
     * @return object|null
     */
    function getViewingTahunAjaranInfo()
    {
        $db = \Config\Database::connect();
        $id_tahun_ajaran = getCurrentTahunAjaran();

        if (!$id_tahun_ajaran) {
            return null;
        }

        // Cek struktur tabel dan gunakan field yang tepat
        $fields = $db->getFieldData('db_tahunajaran');
        $primaryKey = 'id_tahun_ajaran'; // default

        foreach ($fields as $field) {
            if ($field->name === 'id_tahun_ajaran') {
                $primaryKey = 'id_tahun_ajaran';
                break;
            } elseif ($field->name === 'id_tahun') {
                $primaryKey = 'id_tahun';
                break;
            } elseif ($field->name === 'id') {
                $primaryKey = 'id';
                break;
            }
        }

        return $db->table('db_tahunajaran')
            ->where($primaryKey, $id_tahun_ajaran)
            ->get()->getRow();
    }
}

if (!function_exists('getTahunAjaranFieldName')) {
    /**
     * Mendapatkan nama field tahun ajaran yang tepat untuk tabel tertentu
     * 
     * @param string $tableName
     * @return string
     */
    function getTahunAjaranFieldName($tableName)
    {
        $db = \Config\Database::connect();
        $fields = $db->getFieldData($tableName);

        // Prioritas field names
        $possibleFields = ['id_tahun_ajaran', 'id_tahun', 'id_tapel', 'id'];

        foreach ($possibleFields as $fieldName) {
            foreach ($fields as $field) {
                if ($field->name === $fieldName) {
                    return $fieldName;
                }
            }
        }

        return 'id_tahun_ajaran'; // default fallback
    }
}
