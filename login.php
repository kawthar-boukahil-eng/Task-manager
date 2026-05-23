<?php

session_start();

include("includes/db.php");

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){

        $user = mysqli_fetch_assoc($result);

        if(password_verify($password, $user['password'])){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: index.php");
            exit();

        } else {
            echo "Wrong password";
        }

    } else {
        echo "User not found";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="assets/favicon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Authentication</title>

    <link rel="stylesheet" href="assets/css/auth.css">

</head>

<body>

<div id="container" class="container">

    <div class="row">

        <!-- REGISTER -->
        <div class="col align-items-center flex-col sign-up">

            <div class="form-wrapper align-items-center">

                <form method="POST" action="register.php" class="form sign-up">

                    <div class="input-group">
                        <input type="text" name="username" placeholder="Username" required>
                    </div>

                    <div class="input-group">
                        <input type="email" name="email" placeholder="Email" required>
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>

                    <div class="input-group">
                        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    </div>

                    <button type="submit" name="register">
                        Sign Up
                    </button>

                    <p>
                        <span>Already have an account?</span>

                        <b onclick="toggle()" class="pointer">
                            Sign in here
                        </b>
                    </p>

                </form>

            </div>

        </div>

        <!-- LOGIN -->
        <div class="col align-items-center flex-col sign-in">

            <div class="form-wrapper align-items-center">

                <form method="POST" class="form sign-in">

                    <div class="input-group">
                        <input type="text" name="username" placeholder="Username" required>
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>

                    <button type="submit" name="login">
                        Sign In
                    </button>

                    <p>
                        <span>Don't have an account?</span>

                        <b onclick="toggle()" class="pointer">
                            Sign up here
                        </b>
                    </p>

                </form>

            </div>

        </div>

    </div>

    <!-- CONTENT -->
    <div class="row content-row">

        <div class="col align-items-center flex-col">
            <div class="text sign-in">
                <h2>Welcome</h2>
            </div>
        </div>

        <div class="col align-items-center flex-col">
            <div class="text sign-up">
                <h2>Join with us</h2>
            </div>
        </div>

    </div>

</div>

<script src="js/auth.js"></script>

</body>
</html>