<?php

$stafLayout = file_get_contents('c:/backup/laragon/www/perpuskim/resources/views/stafperpus/layout.blade.php');

$adminMenu = <<<HTML
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a href="{{ url('/admin/dashboard') }}">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Manajemen Admin</h4>
              </li>
              <li class="nav-item">
                <a href="{{ url('/admin/kelolastaf') }}">
                  <i class="fas fa-user-cog"></i>
                  <p>Kelola Staf</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/admin/aktivitaspeminjaman') }}">
                  <i class="fas fa-history"></i>
                  <p>Aktivitas Peminjaman</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/admin/laporan') }}">
                  <i class="fas fa-file-alt"></i>
                  <p>Laporan</p>
                </a>
              </li>
            </ul>
HTML;

// Replace the nav ul
$adminLayout = preg_replace('/<ul class="nav nav-secondary">.*?<\/ul>/is', $adminMenu, $stafLayout, 1);

file_put_contents('c:/backup/laragon/www/perpuskim/resources/views/admin/layout.blade.php', $adminLayout);
echo "Admin layout sidebar replaced.";
