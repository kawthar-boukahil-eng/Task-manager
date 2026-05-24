<?php
$pageTitle  = $pageTitle  ?? 'Dashboard';
$activePage = $activePage ?? 'dashboard';
$username   = $_SESSION['username'] ?? 'User';
$userInitial = strtoupper(substr($username, 0, 1));
?>
<button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle navigation" aria-expanded="false" aria-controls="sidebar">
  <svg width="18" height="18" viewBox="0 0 18 18" fill="none" aria-hidden="true">
    <rect x="2" y="4" width="14" height="1.5" rx="0.75" fill="currentColor"/>
    <rect x="2" y="8.25" width="14" height="1.5" rx="0.75" fill="currentColor"/>
    <rect x="2" y="12.5" width="10" height="1.5" rx="0.75" fill="currentColor"/>
  </svg>
</button>

<div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>

<aside class="sidebar surface-textured" id="sidebar" aria-label="Main navigation">
  <div class="sidebar-header">
    <a href="index.php" class="logo-mark logo-mark--sm" aria-label="Velora home">
      <svg viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path d="M18 4.5L9 13.5 4.5 9" stroke="#0A0A0B" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
        <path d="M9 18h9" stroke="#0A0A0B" stroke-width="2" stroke-linecap="round" opacity="0.45"/>
        <path d="M4.5 18h2" stroke="#0A0A0B" stroke-width="2" stroke-linecap="round" opacity="0.45"/>
      </svg>
    </a>
    <span class="brand-name brand-name--sidebar">Vel<span>ora</span></span>
  </div>

  <ul class="sidebar-nav">
    <li class="sidebar-section-label">Workspace</li>
    <li>
      <a href="index.php" class="sidebar-nav-link <?php echo $activePage === 'dashboard' ? 'active' : ''; ?>">
        <span class="sidebar-nav-icon" aria-hidden="true">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><rect x="1.5" y="1.5" width="5.5" height="5.5" rx="1.5" stroke="currentColor" stroke-width="1.4"/><rect x="9" y="1.5" width="5.5" height="5.5" rx="1.5" stroke="currentColor" stroke-width="1.4"/><rect x="1.5" y="9" width="5.5" height="5.5" rx="1.5" stroke="currentColor" stroke-width="1.4"/><rect x="9" y="9" width="5.5" height="5.5" rx="1.5" stroke="currentColor" stroke-width="1.4"/></svg>
        </span>
        Dashboard
      </a>
    </li>
    <li>
      <a href="priority.php" class="sidebar-nav-link <?php echo $activePage === 'priority' ? 'active' : ''; ?>">
        <span class="sidebar-nav-icon" aria-hidden="true">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 1.5L9.854 5.253l4.146.603-3 2.924.708 4.133L8 10.752l-3.708 1.96.708-4.133-3-2.924 4.146-.603z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/></svg>
        </span>
        Starred
      </a>
    </li>
    <li>
      <a href="completed.php" class="sidebar-nav-link <?php echo $activePage === 'completed' ? 'active' : ''; ?>">
        <span class="sidebar-nav-icon" aria-hidden="true">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="6" stroke="currentColor" stroke-width="1.4"/><path d="M5.5 8l1.8 1.8 3-3.6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </span>
        Completed
      </a>
    </li>
    <li>
      <a href="settings.php" class="sidebar-nav-link <?php echo $activePage === 'settings' ? 'active' : ''; ?>">
        <span class="sidebar-nav-icon" aria-hidden="true">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="2.5" stroke="currentColor" stroke-width="1.4"/><path d="M8 1v2M8 13v2M1 8h2M13 8h2M2.93 2.93l1.41 1.41M11.66 11.66l1.41 1.41M2.93 13.07l1.41-1.41M11.66 4.34l1.41-1.41" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
        </span>
        Settings
      </a>
    </li>
  </ul>

  <div class="sidebar-footer">
    <div class="sidebar-user">
      <div class="sidebar-avatar" aria-hidden="true"><?php echo htmlspecialchars($userInitial); ?></div>
      <div>
        <div class="sidebar-username"><?php echo htmlspecialchars($username); ?></div>
        <div class="sidebar-role">Pro workspace</div>
      </div>
    </div>
    <a href="logout.php" class="sidebar-signout">
      <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M5 7h6M9 5l2 2-2 2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 2H3a1 1 0 00-1 1v8a1 1 0 001 1h6" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
      Sign out
    </a>
  </div>
</aside>
