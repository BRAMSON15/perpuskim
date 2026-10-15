<?php
$files = [
    'c:/backup/laragon/www/perpuskim/resources/views/admin/layout.blade.php',
    'c:/backup/laragon/www/perpuskim/resources/views/stafperpus/layout.blade.php'
];

foreach ($files as $file) {
    $content = file_get_contents($file);
    $content = str_replace("asset('admin/assets')", "asset('admin_theme/assets')", $content);
    $content = str_replace('asset("admin/assets")', 'asset("admin_theme/assets")', $content);
    file_put_contents($file, $content);
    echo "Updated $file\n";
}
