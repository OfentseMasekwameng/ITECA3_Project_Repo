<?php
declare (strict_types=1);

function output_username(){
    global $conn;
    if (isset($_SESSION["user_id"])){
        echo $_SESSION["first_name"]. " " .$_SESSION["last_name"];
    } else{
        echo "User account";
    }
}

function check_login_errors(){
    if (isset($_SESSION["errors_login"])){
        $errors = $_SESSION["errors_login"];

        echo '<br>';

        foreach ($errors as $error){
            echo '<p class="err_msg">' .$error. '</p>';
        }
        unset($_SESSION["errors_login"]);
    } else if(isset($_GET['login']) && $_GET['login'] === 'success'){
        echo '<br>';
        echo '<script>alert("You are now registered! Welcome!"</script>';
    }
}

?>