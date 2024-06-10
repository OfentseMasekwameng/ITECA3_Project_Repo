<?php
$servername = "localhost";
$username = "root";
$db_name = "mystore";
$password = "";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db_name);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>