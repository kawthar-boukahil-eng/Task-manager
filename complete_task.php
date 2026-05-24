<?php

session_start();

include("includes/db.php");
include("includes/redirect.php");

$user_id = $_SESSION['user_id'];

$id = $_GET['id'];

$sql = "UPDATE tasks
        SET completed = 1
        WHERE id='$id'
        AND user_id='$user_id'";

mysqli_query($conn, $sql);

velora_safe_redirect('index.php');

?>
