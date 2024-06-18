<?php
include('../coverFolder/connection.php'); // Assuming this file includes your database connection

// Set error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if delete_products parameter is set in the URL
if (isset($_GET["delete_products"])) {
    $delete_id = $_GET["delete_products"];

    // Prepare DELETE statement
    $delete_data = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    if (!$delete_data) {
        // Handle prepare error
        die('Prepare failed: (' . $conn->errno . ') ' . $conn->error);
    }

    // Bind parameters
    $delete_data->bind_param("i", $delete_id);

    // Execute statement
    $delete_success = $delete_data->execute();
    if (!$delete_success) {
        // Handle execute error
        die('Execute failed: (' . $delete_data->errno . ') ' . $delete_data->error);
    }

    // Check if rows were affected
    if ($delete_data->affected_rows > 0) {
        echo '<script>alert("Product has been deleted successfully");</script>';
    } else {
        echo '<script>alert("No product found with that ID");</script>';
    }

    // Close statement
    $delete_data->close();
}

// Close connection
$conn->close();
?>
