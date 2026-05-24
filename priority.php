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
        AND starred=1
        ORDER BY completed ASC, id DESC";

$result = mysqli_query($conn, $sql);

$count_sql = "SELECT COUNT(*) as c FROM tasks WHERE user_id='$user_id' AND starred=1 AND completed=0";
$count_res = mysqli_query($conn, $count_sql);
$starredActive = mysqli_fetch_assoc($count_res)['c'];

$pageTitle  = 'Starred Tasks';
$activePage = 'priority';

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php $pageDesc = 'Starred and priority tasks in Velora.'; include('includes/head-app.php'); ?>
</head>
<body class="app-body">

<div class="app-wrapper">

    <?php include("includes/sidebar.php"); ?>

    <div class="main-content">

        <nav class="navbar-top">
            <div class="navbar-left">
                <h1 class="navbar-title">Starred</h1>
            </div>
            <div class="navbar-actions">
                <span class="navbar-badge"><?php echo $starredActive; ?> priority</span>
                <a href="index.php" class="btn btn-ghost btn-sm">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true"><path d="M7.5 2L3 6l4.5 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Dashboard
                </a>
            </div>
        </nav>

        <div class="content page-enter content-narrow">

            <div class="priority-hero">
                <div class="priority-hero-star" aria-hidden="true">
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                        <path d="M14 3l3.09 6.26L24 10.27l-5 4.87 1.18 6.88L14 18.77l-6.18 3.25L9 15.14l-5-4.87 6.91-1.01z" fill="currentColor"/>
                    </svg>
                </div>
                <div class="priority-hero-text">
                    <h2 class="priority-hero-title">Your starred work</h2>
                    <p class="priority-hero-sub">Tasks you've marked as essential. Keep them visible, keep them moving.</p>
                </div>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <div>
                        <div class="panel-title">Starred Tasks</div>
                        <div class="panel-subtitle">High-signal items across your workspace</div>
                    </div>
                </div>
                <div class="panel-body">

                    <div class="tasks-list">

                    <?php if(mysqli_num_rows($result) > 0): ?>

                        <?php while($row = mysqli_fetch_assoc($result)): ?>

                        <?php
                        $priorityClass = 'priority-low';
                        $badgeClass    = 'badge-low';
                        if($row['priority'] == 'High'){
                            $priorityClass = 'priority-high';
                            $badgeClass    = 'badge-high';
                        } elseif($row['priority'] == 'Medium'){
                            $priorityClass = 'priority-medium';
                            $badgeClass    = 'badge-medium';
                        }
                        $completedClass = $row['completed'] ? 'completed' : '';
                        ?>

                        <div class="task-card <?php echo $priorityClass; ?> is-starred <?php echo $completedClass; ?>">
                            <div class="task-card-top">
                                <div class="task-info">
                                    <div class="task-title"><?php echo htmlspecialchars($row['title']); ?></div>
                                    <div class="task-desc"><?php echo htmlspecialchars($row['description']); ?></div>
                                </div>
                                <a href="toggle_star.php?id=<?php echo $row['id']; ?>"
                                   class="btn-star starred"
                                   title="Unstar task"
                                   aria-label="Unstar task">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                        <path d="M7 1.5l1.545 3.13 3.455.502-2.5 2.437.59 3.441L7 9.383l-3.09 1.627.59-3.441L2 5.132l3.455-.503z" fill="currentColor"/>
                                    </svg>
                                </a>
                            </div>
                            <div class="task-card-bottom">
                                <div class="task-meta">
                                    <span class="badge badge-starred">Starred</span>
                                    <span class="badge <?php echo $badgeClass; ?>"><?php echo $row['priority']; ?></span>
                                    <?php if($row['completed']): ?>
                                    <span class="badge badge-done">Done</span>
                                    <?php endif; ?>
                                </div>
                                <div class="task-actions">
                                    <?php if(!$row['completed']): ?>
                                    <a href="complete_task.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true"><path d="M2 6l2.8 2.8 5.2-5.6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Done
                                    </a>
                                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-ghost btn-sm">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true"><path d="M8.5 1.5l2 2-6 6H2.5v-2z" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Edit
                                    </a>
                                    <?php endif; ?>
                                    <a href="delete.php?id=<?php echo $row['id']; ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Delete this task?')">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true"><path d="M2 3h8M5 3V2h2v1M4 3l.5 7h3L8 3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Delete
                                    </a>
                                </div>
                            </div>
                        </div>

                        <?php endwhile; ?>

                    <?php else: ?>

                    <div class="empty-state">
                        <div class="empty-icon">⭐</div>
                        <div class="empty-title">No starred tasks</div>
                        <p class="empty-body">Star important tasks from the dashboard — they'll glow here.</p>
                        <a href="index.php" class="empty-cta">Go to Dashboard</a>
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
