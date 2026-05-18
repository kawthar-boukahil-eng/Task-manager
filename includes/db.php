<?php

$host = "localhost";
$user = "taskuser";
$password = "1234";
$database = "task_manager";

$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $database
);

if(!$conn){
    die(mysqli_connect_error());
}

?>