<?php

session_start();

include("includes/db.php");
include("includes/redirect.php");

$user_id = $_SESSION['user_id'];

$id = $_GET['id'];

$sql = "SELECT starred FROM tasks
        WHERE id='$id'
        AND user_id='$user_id'";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

$new_value = 1;

if($row['starred'] == 1){
    $new_value = 0;
}

$update = "UPDATE tasks
           SET starred='$new_value'
           WHERE id='$id'
           AND user_id='$user_id'";

mysqli_query($conn, $update);

velora_safe_redirect('index.php');

?>
