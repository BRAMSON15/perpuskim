<?php

$indexFile = 'c:/backup/laragon/www/perpuskim/public/admin/index.html';
$layoutFile = 'c:/backup/laragon/www/perpuskim/resources/views/stafperpus/layout.blade.php';

$indexContent = file_get_contents($indexFile);
$layoutContent = file_get_contents($layoutFile);

// Extract the navbar from index.html
$navStart = strpos($indexContent, '<nav');
$navEnd = strpos($indexContent, '<!-- End Navbar -->') + 19;
$navbarContent = substr($indexContent, $navStart, $navEnd - $navStart);

// Remove the messages, notifications, and quick actions LIs from navbarContent
// They are li items with specific ids or classes.
$navbarContent = preg_replace('/<li class="nav-item topbar-icon dropdown hidden-caret">\s*<a[^>]*id="messageDropdown".*?<\/ul>\s*<\/li>/is', '', $navbarContent);
$navbarContent = preg_replace('/<li class="nav-item topbar-icon dropdown hidden-caret">\s*<a[^>]*id="notifDropdown".*?<\/ul>\s*<\/li>/is', '', $navbarContent);
$navbarContent = preg_replace('/<li class="nav-item topbar-icon dropdown hidden-caret">\s*<a[^>]*data-bs-toggle="dropdown".*?<i class="fas fa-layer-group"><\/i>.*?<\/div>\s*<\/li>/is', '', $navbarContent);

// Fix the user profile dropdown
$userProfileReplacement = <<<HTML
<li class="nav-item topbar-user dropdown hidden-caret">
  <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
    <div class="avatar-sm">
      <!-- <img src="{{ asset('admin/assets') }}/img/profile.jpg" alt="..." class="avatar-img rounded-circle" /> -->
    </div>
    <span class="profile-username">
      <span class="op-7">Hi,</span>
      <span class="fw-bold">{{ Auth::guard('staf')->user()->nama ?? 'Staf' }}</span>
    </span>
  </a>
  <ul class="dropdown-menu dropdown-user animated fadeIn">
    <div class="dropdown-user-scroll scrollbar-outer">
      <li>
        <div class="user-box">
          <div class="avatar-lg">
            <img src="{{ asset('admin/assets') }}/img/profile.jpg" alt="image profile" class="avatar-img rounded" />
          </div>
          <div class="u-text">
            <h4>{{ Auth::guard('staf')->user()->nama ?? 'Staf' }}</h4>
            <p class="text-muted">{{ Auth::guard('staf')->user()->username ?? '' }}</p>
          </div>
        </div>
      </li>
      <li>
        <div class="dropdown-divider"></div>
        <form action="{{ route('staf.logout') }}" method="POST">
            @csrf
            <button type="submit" class="dropdown-item" style="border: none; background: none; width: 100%; text-align: left; padding-left: 20px;">Logout</button>
        </form>
      </li>
    </div>
  </ul>
</li>
HTML;

$navbarContent = preg_replace('/<li class="nav-item topbar-user dropdown hidden-caret">.*?<\/ul>\s*<\/li>/is', $userProfileReplacement, $navbarContent);

// In layout.blade.php, replace everything between <nav ...> and <!-- End Navbar --> with the new navbarContent
$layoutNavStart = strpos($layoutContent, '<nav');
$layoutNavEnd = strpos($layoutContent, '<!-- End Navbar -->') + 19;

if ($layoutNavStart !== false && $layoutNavEnd !== false) {
    $newLayoutContent = substr($layoutContent, 0, $layoutNavStart) . $navbarContent . substr($layoutContent, $layoutNavEnd);
    file_put_contents($layoutFile, $newLayoutContent);
    echo "Navbar replaced successfully!\n";
} else {
    echo "Failed to find navbar boundaries in layout.blade.php\n";
}
