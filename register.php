<?php

include("includes/db.php");

if(isset($_POST['register'])){

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if($password != $confirm){
        die("Passwords do not match");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(username, email, password)
            VALUES('$username', '$email', '$hashed_password')";

    $result = mysqli_query($conn, $sql);

    if($result){
        header("Location: login.php");
        exit();
    } else {
        die(mysqli_error($conn));
    }

}

// If no POST, redirect to login
header("Location: login.php#signup");
exit();
?>
