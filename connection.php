<?php
$servername = "sql107.infinityfree.com";
$username = "if0_36708527";
$password = "39ZvbSELwzGXF9";
$db_name = "if0_36708527_kickstore_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db_name);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>