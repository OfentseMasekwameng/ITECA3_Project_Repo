<?php

session_start();

// Get the previous page URL from the HTTP referer header
$previous_page = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'login.php';

// Check if the user is already logged out
if (!isset($_SESSION["user_id"])) {
    echo "<script>alert('You are already logged out.'); window.location.href = '$previous_page';</script>";
    exit();
}

// If the user is logged in, log them out
session_unset();
session_destroy();

// Display a message and redirect to the login page
echo "<script>alert('You have been successfully logged out.'); window.location.href = '$previous_page';</script>";

exit();
?>