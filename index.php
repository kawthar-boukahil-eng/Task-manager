<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("includes/db.php");

/* ADD TASK */
if(isset($_POST['add_task'])){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];

    $sql = "INSERT INTO tasks(title, description, priority)
            VALUES('$title', '$description', '$priority')";

    $result = mysqli_query($conn, $sql);

    if($result){
        header("Location: index.php");
        exit();
    } else {
        die("Insert failed: " . mysqli_error($conn));
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Task Manager</title>
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
                <a href="#" class="sidebar-nav-link active">
                    <span class="sidebar-nav-icon">📋</span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="#" class="sidebar-nav-link">
                    <span class="sidebar-nav-icon">⭐</span>
                    <span>Priority</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="#" class="sidebar-nav-link">
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
            <h2 class="navbar-title">My Tasks</h2>
            <div class="navbar-actions">
                <div class="navbar-user">
                    <div class="navbar-avatar">U</div>
                    <span class="text-sm">User</span>
                </div>
            </div>
        </nav>

        <!-- CONTENT AREA -->
        <div class="content">

            <div class="dashboard-grid">

                <!-- LEFT SECTION: CREATE TASK FORM -->
                <div class="dashboard-section">

                    <div class="card fade-in">
                        <div class="card-header">
                            <div>
                                <h3 class="card-title">Create New Task</h3>
                                <p class="card-subtitle">Add a new task to your list</p>
                            </div>
                        </div>

                        <form method="POST" id="taskForm">

                            <div class="form-group">
                                <label for="title" class="form-label">Task Title</label>
                                <input 
                                    type="text" 
                                    id="title"
                                    name="title" 
                                    class="form-control" 
                                    placeholder="e.g., Design homepage mockup"
                                    required
                                >
                                <span class="form-hint">Give your task a clear, descriptive name</span>
                            </div>

                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea 
                                    id="description"
                                    name="description" 
                                    class="form-textarea" 
                                    placeholder="Add details about this task..."
                                    required
                                ></textarea>
                                <span class="form-hint">Provide context and details for this task</span>
                            </div>

                            <div class="form-group">
                                <label for="priority" class="form-label">Priority Level</label>
                                <select id="priority" name="priority" class="form-select" required>
                                    <option value="">Select Priority</option>
                                    <option value="High">🔴 High</option>
                                    <option value="Medium">🟡 Medium</option>
                                    <option value="Low">🟢 Low</option>
                                </select>
                                <span class="form-hint">Choose the priority level for this task</span>
                            </div>

                            <button type="submit" name="add_task" class="btn btn-primary btn-block">
                                ➕ Create Task
                            </button>

                        </form>

                    </div>

                </div>

                <!-- RIGHT SECTION: TASKS LIST -->
                <div class="dashboard-section">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title mb-0">Tasks</h3>
                        <span class="badge badge-low" id="taskCount">0 tasks</span>
                    </div>

                    <div id="tasksList">
                        <?php

                        $sql = "SELECT * FROM tasks ORDER BY id DESC";
                        $result = mysqli_query($conn, $sql);
                        $taskCount = mysqli_num_rows($result);

                        if($taskCount > 0){

                            while($row = mysqli_fetch_assoc($result)){

                                $priority = $row['priority'];
                                $priorityClass = 'priority-' . strtolower($priority);
                                $badgeClass = 'badge-' . strtolower($priority);

                                ?>

                                <div class="task-card <?php echo $priorityClass; ?> fade-in">

                                    <div class="task-header">
                                        <div class="flex-grow-1">
                                            <h5 class="task-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                                            <p class="task-description"><?php echo htmlspecialchars($row['description']); ?></p>
                                        </div>
                                    </div>

                                    <div class="task-footer">
                                        <div class="task-priority">
                                            <span class="badge <?php echo $badgeClass; ?>">
                                                <?php echo $priority; ?>
                                            </span>
                                        </div>
                                        <div class="task-actions">
                                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="task-btn task-btn-edit">
                                                ✏️ Edit
                                            </a>
                                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="task-btn task-btn-delete" onclick="return confirm('Are you sure you want to delete this task?');">
                                                🗑️ Delete
                                            </a>
                                        </div>
                                    </div>

                                </div>

                                <?php
                            }

                        } else {
                            ?>

                            <div class="card">
                                <div class="empty-state">
                                    <div class="empty-state-icon">📭</div>
                                    <h4 class="empty-state-title">No tasks yet</h4>
                                    <p class="empty-state-text">Create your first task to get started!</p>
                                </div>
                            </div>

                            <?php
                        }

                        ?>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>
