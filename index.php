<?php

session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

include("includes/db.php");

$user_id = $_SESSION['user_id'];

if(isset($_POST['add_task'])){

    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];

    $sql = "INSERT INTO tasks(title, description, priority, user_id)
            VALUES('$title', '$description', '$priority', '$user_id')";

    mysqli_query($conn, $sql);

    header("Location: index.php");
    exit();
}

$total_sql = "SELECT COUNT(*) as total FROM tasks WHERE user_id='$user_id' AND completed=0";
$total_res = mysqli_query($conn, $total_sql);
$total_row = mysqli_fetch_assoc($total_res);
$totalActive = $total_row['total'];

$starred_sql = "SELECT COUNT(*) as total FROM tasks WHERE user_id='$user_id' AND starred=1 AND completed=0";
$starred_res = mysqli_query($conn, $starred_sql);
$starred_row = mysqli_fetch_assoc($starred_res);
$totalStarred = $starred_row['total'];

$done_sql = "SELECT COUNT(*) as total FROM tasks WHERE user_id='$user_id' AND completed=1";
$done_res = mysqli_query($conn, $done_sql);
$done_row = mysqli_fetch_assoc($done_res);
$totalDone = $done_row['total'];

$pageTitle  = 'Dashboard';
$activePage = 'dashboard';

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php $pageDesc = 'Velora dashboard — manage your active tasks with clarity.'; include('includes/head-app.php'); ?>
</head>
<body class="app-body">

<div class="app-wrapper">

    <?php include("includes/sidebar.php"); ?>

    <div class="main-content">

        <nav class="navbar-top">
            <div class="navbar-left">
                <h1 class="navbar-title">Dashboard</h1>
            </div>
            <div class="navbar-actions">
                <span class="navbar-badge" id="taskCount"><?php echo $totalActive; ?> active</span>
            </div>
        </nav>

        <div class="content page-enter">

            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-value stat-accent"><?php echo $totalActive; ?></div>
                    <div class="stat-label">Active Tasks</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $totalStarred; ?></div>
                    <div class="stat-label">Starred</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $totalDone; ?></div>
                    <div class="stat-label">Completed</div>
                </div>
            </div>

            <div class="dashboard-grid">

                <div class="panel panel-form" style="align-self: start;">
                    <div class="panel-header">
                        <div>
                            <div class="panel-title">New Task</div>
                            <div class="panel-subtitle">Capture work in seconds</div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="POST" id="taskForm">

                            <div class="form-group">
                                <label class="form-label" for="title">Title</label>
                                <input type="text"
                                       id="title"
                                       name="title"
                                       class="form-control"
                                       placeholder="What needs to be done?"
                                       required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="description">Description</label>
                                <textarea id="description"
                                          name="description"
                                          class="form-control"
                                          placeholder="Add context, links, or notes…"
                                          rows="4"
                                          required></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="priority">Priority</label>
                                <div class="select-wrapper">
                                    <select id="priority"
                                            name="priority"
                                            class="form-select"
                                            required>
                                        <option value="">Select priority</option>
                                        <option value="High">High</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Low">Low</option>
                                    </select>
                                </div>
                            </div>

                            <button name="add_task" class="btn btn-primary btn-block">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M7 2v10M2 7h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                Add Task
                            </button>

                        </form>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-header">
                        <div>
                            <div class="panel-title">Active Tasks</div>
                            <div class="panel-subtitle">Your current workload</div>
                        </div>
                    </div>
                    <div class="panel-body">

                        <div class="filter-bar" id="taskFilter" role="group" aria-label="Filter tasks by priority">
                            <button type="button" class="filter-chip active" data-filter="all">All</button>
                            <button type="button" class="filter-chip" data-filter="High">High</button>
                            <button type="button" class="filter-chip" data-filter="Medium">Medium</button>
                            <button type="button" class="filter-chip" data-filter="Low">Low</button>
                            <button type="button" class="filter-chip" data-filter="starred">Starred</button>
                        </div>

                        <div class="tasks-list" id="tasksList">

                        <?php

                        $sql = "SELECT * FROM tasks
                                WHERE user_id = '$user_id'
                                AND completed = 0
                                ORDER BY starred DESC, id DESC";

                        $result = mysqli_query($conn, $sql);

                        if(mysqli_num_rows($result) > 0){

                            while($row = mysqli_fetch_assoc($result)){

                                $priorityClass = 'priority-low';
                                $badgeClass    = 'badge-low';
                                if($row['priority'] == 'High'){
                                    $priorityClass = 'priority-high';
                                    $badgeClass    = 'badge-high';
                                } elseif($row['priority'] == 'Medium'){
                                    $priorityClass = 'priority-medium';
                                    $badgeClass    = 'badge-medium';
                                }

                                $starClass = $row['starred'] ? 'starred' : '';
                                $starredCardClass = $row['starred'] ? 'is-starred' : '';

                        ?>

                        <div class="task-card <?php echo $priorityClass; ?> <?php echo $starredCardClass; ?>"
                             data-priority="<?php echo htmlspecialchars($row['priority']); ?>"
                             data-starred="<?php echo $row['starred'] ? '1' : '0'; ?>">
                            <div class="task-card-top">
                                <div class="task-info">
                                    <div class="task-title"><?php echo htmlspecialchars($row['title']); ?></div>
                                    <div class="task-desc"><?php echo htmlspecialchars($row['description']); ?></div>
                                </div>
                                <a href="toggle_star.php?id=<?php echo $row['id']; ?>"
                                   class="btn-star <?php echo $starClass; ?>"
                                   title="<?php echo $row['starred'] ? 'Unstar' : 'Star'; ?> task"
                                   aria-label="<?php echo $row['starred'] ? 'Unstar' : 'Star'; ?> task">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <?php if($row['starred']): ?>
                                        <path d="M7 1.5l1.545 3.13 3.455.502-2.5 2.437.59 3.441L7 9.383l-3.09 1.627.59-3.441L2 5.132l3.455-.503z" fill="currentColor"/>
                                        <?php else: ?>
                                        <path d="M7 1.5l1.545 3.13 3.455.502-2.5 2.437.59 3.441L7 9.383l-3.09 1.627.59-3.441L2 5.132l3.455-.503z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/>
                                        <?php endif; ?>
                                    </svg>
                                </a>
                            </div>
                            <div class="task-card-bottom">
                                <div class="task-meta">
                                    <span class="badge <?php echo $badgeClass; ?>"><?php echo $row['priority']; ?></span>
                                    <?php if($row['starred']): ?>
                                    <span class="badge badge-starred">Starred</span>
                                    <?php endif; ?>
                                </div>
                                <div class="task-actions">
                                    <a href="complete_task.php?id=<?php echo $row['id']; ?>"
                                       class="btn btn-success btn-sm"
                                       title="Mark complete">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true"><path d="M2 6l2.8 2.8 5.2-5.6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Done
                                    </a>
                                    <a href="edit.php?id=<?php echo $row['id']; ?>"
                                       class="btn btn-ghost btn-sm"
                                       title="Edit task">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true"><path d="M8.5 1.5l2 2-6 6H2.5v-2z" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Edit
                                    </a>
                                    <a href="delete.php?id=<?php echo $row['id']; ?>"
                                       class="btn btn-danger btn-sm"
                                       title="Delete task"
                                       onclick="return confirm('Delete this task?')">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true"><path d="M2 3h8M5 3V2h2v1M4 3l.5 7h3L8 3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Delete
                                    </a>
                                </div>
                            </div>
                        </div>

                        <?php
                            }
                        } else {
                        ?>

                        <div class="empty-state" id="emptyStateDefault">
                            <div class="empty-icon">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/></svg>
                            </div>
                            <div class="empty-title">All clear</div>
                            <p class="empty-body">No active tasks right now. Create one to get momentum.</p>
                        </div>

                        <?php } ?>

                        <div class="empty-state is-hidden" id="emptyStateFilter" style="display:none;">
                            <div class="empty-icon">🔍</div>
                            <div class="empty-title">No matches</div>
                            <p class="empty-body">Try a different filter or add a new task.</p>
                        </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<script src="js/script.js"></script>
</body>
</html>
