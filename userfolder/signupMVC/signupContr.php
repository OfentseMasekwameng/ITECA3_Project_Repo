<?php

declare(strict_types=1);


function is_input_empty($first_name, $last_name, $email, $phone_number, $pwd, $confirm_password) {
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone_number) || empty($pwd) || empty($confirm_password)){
        return true;
    } else{
        return false;
    }
}

function is_email_invalid($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    } else{
        return false;
    }
}

function create_user($conn, $first_name, $last_name, $email, $phone_number, $pwd, $confirmed_password, $user_ip){
    set_user($conn, $first_name, $last_name, $email, $phone_number, $pwd, $confirmed_password, $user_ip);
}

function is_phone_valid(string $phone_number) {
    // Remove any non-digit characters from the phone number
    $cleaned_phone = preg_replace('/[^0-9]/', '', $phone_number);

    // Check if the cleaned phone number has exactly 10 digits
    if (strlen($cleaned_phone) === 10) {
        // Check if the cleaned phone number matches the original input
        if ($cleaned_phone === $phone_number) {
            return true; // Valid phone number
        }
    }
    return false; // Invalid phone number
}

function is_phone_too_long(string $phone_number) {
    // Remove any non-digit characters from the phone number
    $cleaned_phone = preg_replace('/[^0-9]/', '', $phone_number);

    // Check if the cleaned phone number has more than 10 digits
    if (strlen($cleaned_phone) > 10) {
        return true; // Phone number is too long
    }
    return false; // Phone number is not too long
}

function is_phone_too_short(string $phone_number) {
    // Remove any non-digit characters from the phone number
    $cleaned_phone = preg_replace('/[^0-9]/', '', $phone_number);

    // Check if the cleaned phone number has less than 10 digits
    if (strlen($cleaned_phone) < 10) {
        return true; // Phone number is too short
    }
    return false; // Phone number is not too short
}

function is_password_confirmed($password, $confirm_password) {
    return $password === $confirm_password;
}
?>