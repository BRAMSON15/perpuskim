<?php

$file = 'c:/backup/laragon/www/perpuskim/app/Models/Mahasiswa.php';
$content = file_get_contents($file);

$content = str_replace(
    "'no_telp',",
    "'no_telp',\n        'fakultas',\n        'alamat',\n        'foto_kartu',\n        'status',",
    $content
);

file_put_contents($file, $content);
echo "Model updated.";
