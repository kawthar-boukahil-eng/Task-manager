<?php

include("includes/db.php");
session_start();

$user_id = $_SESSION['user_id'];
$id = $_GET['id'];

if(isset($_POST['update_task'])){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];

    $sql = "UPDATE tasks 
        SET title='$title',
            description='$description',
            priority='$priority'
        WHERE id='$id'
        AND user_id='$user_id'";

    mysqli_query($conn, $sql);

    header("Location: index.php");
    exit();
}
$sql = "SELECT * FROM tasks
        WHERE id='$id'
        AND user_id='$user_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(!$row){
    die("Task not found or access denied.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="assets/favicon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<div class="app-wrapper">

    <!-- SIDEBAR NAVIGATION -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">✓</div>
            <h1 class="sidebar-title">TaskHub</h1>
        </div>

        <nav class="sidebar-nav">
            <li class="sidebar-nav-item">
                <a href="index.php" class="sidebar-nav-link">
                    <span class="sidebar-nav-icon">📋</span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="priority.php" class="sidebar-nav-link">
                    <span class="sidebar-nav-icon">⭐</span>
                    <span>Priority</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="completed.php" class="sidebar-nav-link">
                    <span class="sidebar-nav-icon">✅</span>
                    <span>Completed</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="#" class="sidebar-nav-link">
                    <span class="sidebar-nav-icon">⚙️</span>
                    <span>Settings</span>
                </a>
            </li>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOP NAVBAR -->
        <nav class="navbar-top">
            <h2 class="navbar-title">Edit Task</h2>
            <div class="navbar-actions">
                <a href="index.php" class="btn btn-secondary btn-sm">← Back to Tasks</a>
            </div>
        </nav>

        <!-- CONTENT AREA -->
        <div class="content">

            <div style="max-width: 600px; margin: 0 auto;">

                <div class="card fade-in">

                    <div class="card-header">
                        <div>
                            <h3 class="card-title">Update Task</h3>
                            <p class="card-subtitle">Modify task details and save changes</p>
                        </div>
                    </div>

                    <form method="POST">

                        <div class="form-group">
                            <label for="title" class="form-label">Task Title</label>
                            <input 
                                type="text" 
                                id="title"
                                name="title" 
                                class="form-control" 
                                value="<?php echo htmlspecialchars($row['title']); ?>"
                                required
                            >
                            <span class="form-hint">Update the task title</span>
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">Description</label>
                            <textarea 
                                id="description"
                                name="description" 
                                class="form-textarea"
                                required
                            ><?php echo htmlspecialchars($row['description']); ?></textarea>
                            <span class="form-hint">Update task details and context</span>
                        </div>

                        <div class="form-group">
                            <label for="priority" class="form-label">Priority Level</label>
                            <select id="priority" name="priority" class="form-select" required>
                                <option value="High" <?php if($row['priority']=="High") echo "selected"; ?>>🔴 High</option>
                                <option value="Medium" <?php if($row['priority']=="Medium") echo "selected"; ?>>🟡 Medium</option>
                                <option value="Low" <?php if($row['priority']=="Low") echo "selected"; ?>>🟢 Low</option>
                            </select>
                            <span class="form-hint">Change the priority level</span>
                        </div>

                        <div style="display: flex; gap: 12px;">
                            <button type="submit" name="update_task" class="btn btn-primary" style="flex: 1;">
                                💾 Save Changes
                            </button>
                            <a href="index.php" class="btn btn-secondary" style="flex: 1; text-align: center;">
                                ✕ Cancel
                            </a>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
