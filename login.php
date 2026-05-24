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
            $auth_error = "Incorrect password. Please try again.";
        }

    } else {
        $auth_error = "No account found with that username.";
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Velora — A premium task management platform for focused, productive work.">
    <title>Sign In — Velora</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>

<div class="auth-wrapper">

    <div class="auth-visual surface-textured">
        <div class="auth-visual-brand">
            <div class="auth-logo-mark logo-mark">
                <svg viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M18 4.5L9 13.5 4.5 9" stroke="#0A0A0B" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    <path d="M9 18h9" stroke="#0A0A0B" stroke-width="2" stroke-linecap="round" opacity="0.45"/>
                    <path d="M4.5 18h2" stroke="#0A0A0B" stroke-width="2" stroke-linecap="round" opacity="0.45"/>
                </svg>
            </div>
            <span class="auth-brand-name">Vel<span>ora</span></span>
        </div>

        <div class="auth-visual-content">
            <h2 class="auth-visual-headline">
                Focus on what<br>
                <em>matters most.</em>
            </h2>
            <p class="auth-visual-sub">
                Velora is a premium task workspace built for clarity — star priorities, track progress, and ship work with confidence.
            </p>
        </div>

        <div class="auth-features">
            <div class="auth-feature"><div class="auth-feature-dot"></div> Priority levels for every task</div>
            <div class="auth-feature"><div class="auth-feature-dot"></div> Animated starred favourites</div>
            <div class="auth-feature"><div class="auth-feature-dot"></div> Satisfying completion tracking</div>
            <div class="auth-feature"><div class="auth-feature-dot"></div> Private multi-user workspaces</div>
        </div>
    </div>

    <div class="auth-form-panel">

        <div class="auth-panel-header">
            <h1 class="auth-panel-title">Welcome back</h1>
            <p class="auth-panel-sub">Sign in to continue to Velora.</p>
        </div>

        <div class="auth-tabs" role="tablist">
            <button type="button" class="auth-tab active" data-tab="signin" role="tab" aria-selected="true">Sign In</button>
            <button type="button" class="auth-tab" data-tab="signup" role="tab" aria-selected="false">Create Account</button>
        </div>

        <form class="auth-form active" id="signin-form" method="POST" role="tabpanel">

            <?php if(isset($auth_error)): ?>
            <div class="auth-error visible" role="alert"><?php echo htmlspecialchars($auth_error); ?></div>
            <?php endif; ?>

            <div class="input-group">
                <label for="si-username">Username</label>
                <input type="text" id="si-username" name="username" placeholder="your_username" required autocomplete="username">
            </div>

            <div class="input-group">
                <label for="si-password">Password</label>
                <input type="password" id="si-password" name="password" placeholder="••••••••" required autocomplete="current-password">
            </div>

            <button type="submit" name="login" class="auth-submit">Sign In</button>

            <p class="auth-switch">
                Don't have an account?
                <b onclick="toggle()" tabindex="0" role="button">Sign up here</b>
            </p>

        </form>

        <form class="auth-form" id="signup-form" method="POST" action="register.php" role="tabpanel">

            <div class="input-group">
                <label for="su-username">Username</label>
                <input type="text" id="su-username" name="username" placeholder="your_username" required autocomplete="username">
            </div>

            <div class="input-group">
                <label for="su-email">Email</label>
                <input type="email" id="su-email" name="email" placeholder="you@example.com" required autocomplete="email">
            </div>

            <div class="input-group">
                <label for="su-password">Password</label>
                <input type="password" id="su-password" name="password" placeholder="At least 8 characters" required autocomplete="new-password">
            </div>

            <div class="input-group">
                <label for="su-confirm">Confirm Password</label>
                <input type="password" id="su-confirm" name="confirm_password" placeholder="••••••••" required autocomplete="new-password">
            </div>

            <button type="submit" name="register" class="auth-submit">Create Account</button>

            <p class="auth-switch">
                Already have an account?
                <b onclick="toggle()" tabindex="0" role="button">Sign in here</b>
            </p>

        </form>

    </div>

</div>

<script src="js/auth.js"></script>
</body>
</html>
