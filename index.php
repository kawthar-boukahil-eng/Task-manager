<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Task Manager</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-dark px-4">

        <a class="navbar-brand fw-bold" href="#">
            Smart Task Manager
        </a>

        <button class="btn btn-outline-light">
            Login
        </button>

    </nav>

    <!-- MAIN CONTAINER -->
    <div class="container mt-5">

        <div class="row">

            <!-- LEFT SIDE -->
            <div class="col-md-4">

                <div class="card shadow p-4">

                    <h3 class="mb-4">
                        Create Task
                    </h3>

                    <form id="taskForm">

    <input 
        type="text"
        class="form-control mb-3"
        placeholder="Task title"
        id="taskTitle"
    >

    <textarea 
        class="form-control mb-3"
        rows="5"
        placeholder="Task description"
        id="taskDescription"
    ></textarea>

    <select 
        class="form-select mb-3"
        id="taskPriority"
    >

        <option value="">
            Select Priority
        </option>

        <option value="High">
            High
        </option>

        <option value="Medium">
            Medium
        </option>

        <option value="Low">
            Low
        </option>

    </select>

    <button class="btn btn-primary w-100">
        Add Task
    </button>

</form>

                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="col-md-8">

                <h3 class="mb-4">
                    My Tasks
                </h3>

                <!-- TASK CARD -->
                <div class="card shadow p-3 mb-3">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h5>
                                Finish UI Design
                            </h5>

                            <p class="text-muted">
                                Create homepage layout for dashboard
                            </p>

                        </div>

                        <span class="badge bg-danger h-25">
                            High
                        </span>

                    </div>

                </div>

                <!-- TASK CARD -->
               <div class="col-md-8">

    <h3 class="mb-4">
        My Tasks
    </h3>

    <!-- TASK LIST -->
    <div id="taskList"></div>

</div>

            </div>

        </div>

    </div>
<script src="assets/js/script.js"></script>
</body>
</html>