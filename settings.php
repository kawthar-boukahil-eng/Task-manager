<?php

session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

include("includes/db.php");

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? 'User';
$userInitial = strtoupper(substr($username, 0, 1));

$email_sql = "SELECT email FROM users WHERE id='$user_id' LIMIT 1";
$email_res = mysqli_query($conn, $email_sql);
$email_row = mysqli_fetch_assoc($email_res);
$email = $email_row['email'] ?? '—';

$active_sql = "SELECT COUNT(*) as c FROM tasks WHERE user_id='$user_id' AND completed=0";
$active_res = mysqli_query($conn, $active_sql);
$activeCount = mysqli_fetch_assoc($active_res)['c'];

$done_sql = "SELECT COUNT(*) as c FROM tasks WHERE user_id='$user_id' AND completed=1";
$done_res = mysqli_query($conn, $done_sql);
$doneCount = mysqli_fetch_assoc($done_res)['c'];

$pageTitle  = 'Settings';
$activePage = 'settings';

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php $pageDesc = 'Velora workspace settings and profile.'; include('includes/head-app.php'); ?>
</head>
<body class="app-body">

<div class="app-wrapper">

    <?php include("includes/sidebar.php"); ?>

    <div class="main-content">

        <nav class="navbar-top">
            <div class="navbar-left">
                <h1 class="navbar-title">Settings</h1>
            </div>
        </nav>

        <div class="content page-enter">

            <div class="settings-grid">

                <div class="settings-card">
                    <div class="settings-avatar-lg" aria-hidden="true"><?php echo htmlspecialchars($userInitial); ?></div>
                    <h2 class="settings-card-title">Profile</h2>
                    <p class="settings-card-desc">Your Velora workspace identity</p>

                    <div class="settings-row">
                        <span class="settings-label">Username</span>
                        <span class="settings-value"><?php echo htmlspecialchars($username); ?></span>
                    </div>
                    <div class="settings-row">
                        <span class="settings-label">Email</span>
                        <span class="settings-value"><?php echo htmlspecialchars($email); ?></span>
                    </div>
                    <div class="settings-row">
                        <span class="settings-label">Plan</span>
                        <span class="settings-value">Pro workspace</span>
                    </div>
                </div>

                <div class="settings-card">
                    <h2 class="settings-card-title">Workspace stats</h2>
                    <p class="settings-card-desc">Overview of your task activity</p>

                    <div class="settings-row">
                        <span class="settings-label">Active tasks</span>
                        <span class="settings-value"><?php echo $activeCount; ?></span>
                    </div>
                    <div class="settings-row">
                        <span class="settings-label">Completed tasks</span>
                        <span class="settings-value"><?php echo $doneCount; ?></span>
                    </div>
                    <div class="settings-row">
                        <span class="settings-label">User ID</span>
                        <span class="settings-value">#<?php echo (int)$user_id; ?></span>
                    </div>
                </div>

                <div class="settings-card">
                    <h2 class="settings-card-title">Appearance</h2>
                    <p class="settings-card-desc">Visual preferences for your workspace</p>

                    <div class="settings-row">
                        <span class="settings-label">Theme</span>
                        <span class="settings-value">Dark <span class="coming-soon-tag">Default</span></span>
                    </div>
                    <div class="settings-row">
                        <span class="settings-label">Light mode</span>
                        <span class="coming-soon-tag">Coming soon</span>
                    </div>
                </div>

                <div class="settings-card">
                    <h2 class="settings-card-title">Account</h2>
                    <p class="settings-card-desc">Session and security</p>

                    <div class="settings-row">
                        <span class="settings-label">Authentication</span>
                        <span class="settings-value">PHP Sessions</span>
                    </div>
                    <div class="settings-row">
                        <span class="settings-label">Sign out</span>
                        <a href="logout.php" class="btn btn-ghost btn-sm">Sign out</a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<script src="js/script.js"></script>
</body>
</html>
