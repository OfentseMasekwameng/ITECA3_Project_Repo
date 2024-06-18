<?php
require_once '../coverFolder/config_session.inc.php';
require_once '../coverFolder/login_mvc/login_view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login-page</title>

    <!-- CSS links -->
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/utils.css">
    <link rel="stylesheet" href="registration_styles/login_styles.css">
</head>
<body>
<div class="container login">
    <div class="title">
        <h1>Login</h1>
    </div>
    <form action="../coverFolder/login.inc.php" method="post">
        <div class="field">
            <input type="text" placeholder="Enter Email" name="email" id="email">
        </div>
        <div class="field">
            <input type="password" placeholder="Enter password" name="pwd" id="pwd">
        </div>
        <div class="content">
            <div class="checkbox">
                <input type="checkbox" id="remember-me" value="is_remember_me">
                <label for="remember-me">Remember me</label>
            </div>
            <div class="password_link">
                <a href="#">Forgot password?</a>
            </div>
        </div>
        <div class="field">
            <button type="submit" class="sign-btn">Login</button>
        </div>
        <div class="signup_link">
            <p>If you don't have an account sign up <a href="register.php">here.</a></p>
        </div>

    <?php
    check_login_errors();
    ?>
    </form>
    </div>
</body>
</html>