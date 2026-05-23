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

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body class="bg-light">

<div class="d-flex">

    <!-- SIDEBAR -->
    <div class="bg-dark text-white p-4 vh-100" style="width:250px;">

        <h3 class="fw-bold mb-4">Task Manager</h3>

        <p>
            Welcome,
            <strong><?php echo $_SESSION['username']; ?></strong>
        </p>

        <a href="logout.php" class="btn btn-danger mt-3">
            Logout
        </a>

    </div>

    <!-- MAIN -->
    <div class="flex-grow-1 p-4">

        <h2 class="mb-4">My Tasks</h2>

        <div class="row">

            <!-- FORM -->
            <div class="col-md-4">

                <div class="card shadow-sm p-4">

                    <h5 class="mb-3">Create Task</h5>

                    <form method="POST">

                        <input type="text"
                               name="title"
                               class="form-control mb-3"
                               placeholder="Task title"
                               required>

                        <textarea name="description"
                                  class="form-control mb-3"
                                  placeholder="Task description"
                                  rows="4"
                                  required></textarea>

                        <select name="priority"
                                class="form-select mb-3"
                                required>

                            <option value="">Select Priority</option>
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>

                        </select>

                        <button name="add_task"
                                class="btn btn-primary w-100">

                            Add Task

                        </button>

                    </form>

                </div>

            </div>

            <!-- TASKS -->
            <div class="col-md-8">

                <?php

                $sql = "SELECT * FROM tasks
                        WHERE user_id = '$user_id'
                        ORDER BY id DESC";

                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0){

                    while($row = mysqli_fetch_assoc($result)){

                        $badge = "success";

                        if($row['priority'] == "High"){
                            $badge = "danger";
                        }
                        elseif($row['priority'] == "Medium"){
                            $badge = "warning text-dark";
                        }

                ?>

                <div class="card shadow-sm p-3 mb-3">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <h5 class="mb-1">
                                <?php echo $row['title']; ?>
                            </h5>

                            <p class="text-muted mb-0">
                                <?php echo $row['description']; ?>
                            </p>

                        </div>

                        <div>

                            <span class="badge bg-<?php echo $badge; ?>">
                                <?php echo $row['priority']; ?>
                            </span>

                            <a href="edit.php?id=<?php echo $row['id']; ?>"
                               class="btn btn-warning btn-sm ms-2">

                                Edit

                            </a>

                            <a href="delete.php?id=<?php echo $row['id']; ?>"
                               class="btn btn-danger btn-sm">

                                Delete

                            </a>

                        </div>

                    </div>

                </div>

                <?php

                    }

                } else {

                    echo "<div class='alert alert-info'>No tasks found.</div>";

                }

                ?>

            </div>

        </div>

    </div>

</div>

</body>
</html>