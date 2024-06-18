<?php
require_once ("../coverFolder/configSession.inc.php");
include_once ("signupMVC/signupView.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- font Link -->
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@500,600,400,700&display=swap" rel="stylesheet"/>

    <!-- Font awesome & Bootstrap link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href= "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- CSS links -->
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/components/account.css">
    <link rel="stylesheet" href="../styles/utils.css">

</head>
<body>
    <section class="signup_wrapper container section">
        <div class="signup_form">
            <a href="#" class="btn_clr nav_button" onclick="goBack()"><i class="fa-solid fa-arrow-left"></i></a>
            <p class="form_title">Sign Up Form</h2>
            <form action="signup.inc.php" method="post" enctype="multipart/form-data">
                <div class="input_section">
                    <?php 
                        signup_inputs();
                    ?>
                </div>
                
                <p>By creating an account you agree to our <a href="#" class="term_link">Terms & Privacy</a>.</p>

                <button type="submit" class="btn">Sign Up</button>
            </form>
            <div class="login_wrapper">
                <p>Already have an account? <a href="login.php" class="log_link">Sign in</a></p>
            </div>
            <?php
                check_signup_errors();
            ?>
        </div>
    </section>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>