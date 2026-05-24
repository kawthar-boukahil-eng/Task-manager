<?php

include("includes/db.php");
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

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

$pageTitle  = 'Edit Task';
$activePage = 'dashboard';

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php $pageDesc = 'Edit a task in your Velora workspace.'; include('includes/head-app.php'); ?>
</head>
<body class="app-body">

<div class="app-wrapper">

    <?php include("includes/sidebar.php"); ?>

    <div class="main-content">

        <nav class="navbar-top">
            <div class="navbar-left">
                <h1 class="navbar-title">Edit Task</h1>
            </div>
            <div class="navbar-actions">
                <a href="index.php" class="btn btn-ghost btn-sm">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true"><path d="M7.5 2L3 6l4.5 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Back
                </a>
            </div>
        </nav>

        <div class="content page-enter">
            <div style="max-width: 560px; margin: 0 auto;">

                <div class="panel fade-up">
                    <div class="panel-header">
                        <div>
                            <div class="panel-title">Update Task</div>
                            <div class="panel-subtitle">Refine details and save your changes</div>
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
                                       value="<?php echo htmlspecialchars($row['title']); ?>"
                                       required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="description">Description</label>
                                <textarea id="description"
                                          name="description"
                                          class="form-control"
                                          rows="5"
                                          required><?php echo htmlspecialchars($row['description']); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="priority">Priority</label>
                                <div class="select-wrapper">
                                    <select id="priority" name="priority" class="form-select" required>
                                        <option value="High"   <?php if($row['priority']=="High")   echo "selected"; ?>>High</option>
                                        <option value="Medium" <?php if($row['priority']=="Medium") echo "selected"; ?>>Medium</option>
                                        <option value="Low"    <?php if($row['priority']=="Low")    echo "selected"; ?>>Low</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" name="update_task" class="btn btn-primary">
                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" aria-hidden="true"><path d="M10.5 1.5L8.5 1H3a1 1 0 00-1 1v9a1 1 0 001 1h7a1 1 0 001-1V4.5L10.5 1.5z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/><path d="M4.5 1v3h4V1M4.5 9h4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
                                    Save Changes
                                </button>
                                <a href="index.php" class="btn btn-ghost">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="js/script.js"></script>
</body>
</html>
