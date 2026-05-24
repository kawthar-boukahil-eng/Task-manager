<?php

session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

include("includes/db.php");

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM tasks
        WHERE user_id='$user_id'
        AND completed=1
        ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

$count = mysqli_num_rows($result);

$pageTitle  = 'Completed Tasks';
$activePage = 'completed';

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php $pageDesc = 'View completed tasks in Velora.'; include('includes/head-app.php'); ?>
</head>
<body class="app-body">

<div class="app-wrapper">

    <?php include("includes/sidebar.php"); ?>

    <div class="main-content">

        <nav class="navbar-top">
            <div class="navbar-left">
                <h1 class="navbar-title">Completed</h1>
            </div>
            <div class="navbar-actions">
                <span class="navbar-badge"><?php echo $count; ?> done</span>
                <a href="index.php" class="btn btn-ghost btn-sm">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true"><path d="M7.5 2L3 6l4.5 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Dashboard
                </a>
            </div>
        </nav>

        <div class="content page-enter content-narrow">

            <div class="panel">
                <div class="panel-header">
                    <div>
                        <div class="panel-title">Completed Tasks</div>
                        <div class="panel-subtitle">Everything you've shipped — well done.</div>
                    </div>
                </div>
                <div class="panel-body">

                    <div class="tasks-list">

                    <?php if($count > 0): ?>

                        <?php while($row = mysqli_fetch_assoc($result)): ?>

                        <?php
                        $badgeClass = 'badge-low';
                        if($row['priority'] == 'High') $badgeClass = 'badge-high';
                        elseif($row['priority'] == 'Medium') $badgeClass = 'badge-medium';
                        ?>

                        <div class="task-card completed">
                            <div class="task-card-top">
                                <div class="task-info">
                                    <div class="task-title"><?php echo htmlspecialchars($row['title']); ?></div>
                                    <div class="task-desc"><?php echo htmlspecialchars($row['description']); ?></div>
                                </div>
                                <div class="task-complete-icon" aria-hidden="true">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3 7l2.5 2.5 5.5-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                            </div>
                            <div class="task-card-bottom">
                                <div class="task-meta">
                                    <span class="badge badge-done">Completed</span>
                                    <span class="badge <?php echo $badgeClass; ?>"><?php echo $row['priority']; ?></span>
                                    <?php if($row['starred']): ?>
                                    <span class="badge badge-starred">Was starred</span>
                                    <?php endif; ?>
                                </div>
                                <div class="task-actions">
                                    <a href="delete.php?id=<?php echo $row['id']; ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Remove this task permanently?')">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true"><path d="M2 3h8M5 3V2h2v1M4 3l.5 7h3L8 3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Remove
                                    </a>
                                </div>
                            </div>
                        </div>

                        <?php endwhile; ?>

                    <?php else: ?>

                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/></svg>
                        </div>
                        <div class="empty-title">Nothing completed yet</div>
                        <p class="empty-body">Finish tasks from your dashboard and they'll appear here.</p>
                        <a href="index.php" class="empty-cta">View active tasks</a>
                    </div>

                    <?php endif; ?>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="js/script.js"></script>
</body>
</html>
