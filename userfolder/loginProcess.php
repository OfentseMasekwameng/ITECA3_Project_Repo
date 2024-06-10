<?php
require_once '../includes/configSession.inc.php';

// displays errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST["email_address"];
    $pwd = $_POST["password"];

    
    // Include necessary files
    require_once '../includes/connection.php';
    require_once 'loginMVC/loginModel.php';
    require_once 'loginMVC/loginContr.php';
    

    try {
        // Error handlers
        $errors = [];

        if (is_input_empty($email, $pwd)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        $result = get_user($conn, $email);

        if (is_email_wrong($result)){
            $errors["login_incorrect"] = "Incorrect email!";
        }
        if(!is_email_wrong($result) && is_password_wrong($pwd, $result["pwd"])){
            $errors["login_incorrect"] = "Incorrect password!";
        }

        if ($errors){
            $_SESSION["errors_login"] = $errors;

            header("Location: login.php");
            exit(); //Terminate 
        }

        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result["user_id"];
        session_id($sessionId);

        $_SESSION["user_id"] = $result["user_id"];
        $_SESSION["first_name"] = htmlspecialchars($result["first_name"]);
        $_SESSION["last_name"] = htmlspecialchars($result["last_name"]);
        $_SESSION["user_email"] = htmlspecialchars($result["email_address"]);
        $_SESSION["user_ip"] = $result["user_ip"];


        $_SESSION["last_regeneration"] = time();

        header("Location: ../index.php");

        $conn = null;
        $stmt = null;

        exit();

    } catch (Exception $e) {
        die("Query failed: " . $e->getMessage());
    }
} else{
    // Request method is not POST
    echo "There's an error. Find out what it is.";
    header("Location: login.php");
    exit(); // Terminate script execution
}
?>