<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/mvc/signup_view.inc.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register-page</title>

    <!-- CSS links -->
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/utils.css">
    <link rel="stylesheet" href="registration_styles/register_styles.css">
</head>
<body>
    <div class="container register">
        <div class="title">
            Signup
        </div>
        <form action="../includes/signup.inc.php" method="POST">
            <!-- <div class="field">
                <input type="text" placeholder="Enter your first name" name="first_name">                
             </div>
            <div class="field">
                <input type="text" placeholder="Enter you surname" name="last_name"><br>
            </div> -->
            <!-- <div class="field">
                <input type="text" placeholder="Enter Email" name="email"><br>
            </div>
            <div class="field">
                <input type="text" placeholder="123 456 7890" name="phone_number"><br>
            </div>
            <div class="field">
                <input type="password" placeholder="Enter Password" name="pwd"><br>
            </div> -->
            <!-- <div class="field">
                <input type="password" placeholder="Repeat Password" name="pwd-repeat" id="pwd-repeat">
            </div> -->

            <?php
            signup_inputs();
            ?>
            <div class="pass_link">
                <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
            </div>
            <div class="field">
                <button type="submit" class="sign-btn">Sign Up</button>
            </div>
            <div class="login_link">
                <p>Already have an account? <a href="login.php">Sign in</a></p>
            </div>
        </div>

        <?php
        check_signup_errors();
        ?>

    </form>

</body>
</html>