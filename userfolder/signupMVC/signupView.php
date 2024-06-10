<?php
declare (strict_types=1);

function signup_inputs(){
    if (isset($_SESSION["signup_data"]["first_name"]) && isset($_SESSION["signup_data"]["last_name"]) &&  !isset($_SESSION["errors_signup"]["empty_input"])){
        echo '
        <input type="text" name="first_name" placeholder="First Name" class="user_input" value="'.$_SESSION["signup_data"]["first_name"].'">
        <input type="text" name="last_name" placeholder="Last Name" class="user_input" value="'.$_SESSION["signup_data"]["last_name"].'">
        ';
    } else{
        echo '
        <input type="text" name="first_name" placeholder="First Name" class="user_input">
        <input type="text" name="last_name" placeholder="Last Name" class="user_input">';
    }


    if (isset($_SESSION["signup_data"]["email_address"]) && !isset($_SESSION["errors_signup"]["email_used"]) && !isset($_SESSION["errors_signup"]["invalid_email"])){
        echo'<input type="text" name="email_address" placeholder="Email" class="user_input" value="'.$_SESSION["signup_data"]["email_address"].'">';
    } else{
        echo '<input type="text" name="email_address" placeholder="Email" class="user_input">';
    }
    
    if (isset($_SESSION["signup_data"]["phone_number"]) && !isset($_SESSION["errors_signup"]["missing_phone"]) && !isset($_SESSION["errors_signup"]["invalid_phone"])){
        echo '<input type="text" name="phone_number" placeholder="Phone Number" class="user_input" value="'.$_SESSION["signup_data"]["phone_number"].'">';
    } else{
        echo '<input type="text" name="phone_number" placeholder="Phone Number" class="user_input">';
    }

    echo '
    <input type="password" name="password" placeholder="Password" class="user_input">
    <input type="password" name="confirm_password" placeholder="Confirm Password" class="user_input">';
}

function check_signup_errors(){
    if (isset($_SESSION['errors_signup'])){
        $errors = $_SESSION['errors_signup'];

        echo '<br>';

        foreach ($errors as $error){
            echo '<p class="err_msg">'.$error.'</p>';
        }

        unset ($_SESSION['errors_signup']);
    } else if (isset($_GET["signup"]) && $_GET["signup"] === "succsss"){
        echo '<script>alert("You are now registered! Welcome!"</script>';
    }
}


?>