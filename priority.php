<?php

session_start();

include("includes/db.php");

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM tasks
        WHERE user_id='$user_id'
        AND starred=1
        ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Priority Tasks</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body class="bg-light">

<div class="container py-5">

    <h2 class="mb-4">Priority Tasks</h2>

    <a href="index.php" class="btn btn-dark mb-4">
        ← Back
    </a>

    <?php

    while($row = mysqli_fetch_assoc($result)){

    ?>

    <div class="card shadow-sm p-3 mb-3">

        <h5><?php echo $row['title']; ?></h5>

        <p class="text-muted">
            <?php echo $row['description']; ?>
        </p>

    </div>

    <?php } ?>

</div>

</body>
</html>