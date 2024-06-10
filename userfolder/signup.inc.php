<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../functions/common.php";
require_once '../includes/configSession.inc.php';


// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email_address"];
    $phone_number = $_POST["phone_number"];
    $pwd = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $user_ip = get_ip_address();

    // Include necessary files
    require_once '../includes/connection.php';
    require_once 'signupMVC/signupModel.php';
    require_once 'signupMVC/signupContr.php';

    try {
        // Error handlers
        $errors = [];

        if (is_input_empty($first_name, $last_name, $email, $phone_number, $pwd, $confirm_password, $user_ip)) {
            $errors["empty_input"] = "Fill in all fields!";
        }
        if (is_email_invalid($email)) {
            $errors["invalid_email"] = "Invalid email address!";
        }
        if (is_email_registered($conn, $email)) {
            $errors["email_used"] = "Email address is already registered!";
        }
        if (empty($phone_number)) {
            $errors["missing_phone"] = "Phone number is required!";
        } elseif (!is_phone_valid($phone_number)) {
            $errors["invalid_phone"] = "Invalid phone number format!";
        } 
        if (!is_password_confirmed($pwd, $confirm_password)) {
            $errors["password_mismatch"] = "Passwords do not match!";
        }

        

        if ($errors){
            $_SESSION["errors_signup"] = $errors;

            $signupData = [
                "first_name" => $first_name,
                "last_name" => $last_name,
                "email_address" => $email,
                "phone_number" => $phone_number
            ];

            $_SESSION["signup_data"] = $signupData;

            header("Location: signup.php");
            exit();
        }

        create_user($conn, $first_name, $last_name, $email, $phone_number, $pwd, $confirm_password, $user_ip);


        header("Location: ../index.php");


        $conn = null;
        $stmt = null;

        die();
        
    } catch (Exception $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    // Request method is not POST
    echo "There's an error. Find out what it is.";
    header("Location: signup.php");
    exit(); // Terminate script execution
}

?>