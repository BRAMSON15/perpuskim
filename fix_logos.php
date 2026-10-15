<?php

$files = [
    'c:/backup/laragon/www/perpuskim/resources/views/admin/layout.blade.php',
    'c:/backup/laragon/www/perpuskim/resources/views/stafperpus/layout.blade.php'
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);

    // 1. Favicon
    $content = preg_replace(
        '/<link\s*rel="icon"\s*href="\{\{\s*asset\(\'admin_theme\/assets\'\)\s*\}\}\/img\/kaiadmin\/favicon\.ico"\s*type="image\/x-icon"\s*\/>/is',
        '<link rel="icon" href="{{ asset(\'home/img/image.png\') }}" type="image/png" />',
        $content
    );

    // 2. Logo Header
    $newLogo = <<<HTML
              <a href="{{ url('/') }}" class="logo d-flex align-items-center" style="gap: 10px;">
                <img
                  src="{{ asset('home/img/image.png') }}"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="30"
                />
                <span style="color: white; font-weight: bold; font-size: 18px;">PERPUSKIM</span>
              </a>
HTML;

    $content = preg_replace(
        '/<a href="index\.html" class="logo">\s*<img\s*src="\{\{\s*asset\(\'admin_theme\/assets\'\)\s*\}\}\/img\/kaiadmin\/logo_light\.svg"\s*alt="navbar brand"\s*class="navbar-brand"\s*height="20"\s*\/>\s*<\/a>/is',
        $newLogo,
        $content
    );

    // 3. Footer
    $newFooter = <<<HTML
        <footer class="footer">
          <div class="container-fluid d-flex justify-content-between">
            <nav class="pull-left">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    PERPUSKIM
                  </a>
                </li>
              </ul>
            </nav>
            <div class="copyright">
              2024, Sistem Informasi Perpustakaan UKIM
            </div>
          </div>
        </footer>
HTML;

    $content = preg_replace(
        '/<footer class="footer">.*?<\/footer>/is',
        $newFooter,
        $content
    );

    // 4. Remove Demo JS
    $content = preg_replace(
        '/<!-- Kaiadmin DEMO methods.*?<script src="\{\{\s*asset\(\'admin_theme\/assets\'\)\s*\}\}\/js\/setting-demo\.js"><\/script>\s*<script src="\{\{\s*asset\(\'admin_theme\/assets\'\)\s*\}\}\/js\/demo\.js"><\/script>/is',
        '',
        $content
    );

    file_put_contents($file, $content);
}

echo "Layouts updated successfully.\n";
