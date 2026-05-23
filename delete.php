<?php

session_start();

include("includes/db.php");

if(isset($_GET['id'])){

    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    $sql = "DELETE FROM tasks
            WHERE id='$id'
            AND user_id='$user_id'";

    mysqli_query($conn, $sql);

}

header("Location: index.php");
exit();

?>