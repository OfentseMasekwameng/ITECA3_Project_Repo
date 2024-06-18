<?php
include_once("coverFolder/connection.php");
require_once "coverFolder/configSession.inc.php";

function delete_user_account() {
    global $conn;

    if (!isset($_SESSION['user_id'])) {
        // Redirect to login if user_id is not set
        header("Location: userfolder/login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Delete from user_orders
        $stmt = $conn->prepare("DELETE FROM user_orders WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        // Delete from orders_pending
        $stmt = $conn->prepare("DELETE FROM orders_pending WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        // Delete from user_location
        $stmt = $conn->prepare("DELETE FROM user_location WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        // Delete from user_address
        $stmt = $conn->prepare("DELETE FROM user_address WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        // Delete from payment_info (assuming you have this table)
        $stmt = $conn->prepare("DELETE FROM payment_info WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        // Delete from site_user
        $stmt = $conn->prepare("DELETE FROM site_user WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        // Commit transaction
        $conn->commit();

        // Destroy session and redirect to homepage
        session_destroy();
        header("Location: index.php");
        exit();
    } catch (Exception $e) {
        // Rollback transaction if any error occurs
        $conn->rollback();
        echo "Error deleting account: " . $e->getMessage();
    }
}

// Check if the delete account action is triggered
if (isset($_GET['action']) && $_GET['action'] == 'delete_account') {
    delete_user_account();
}
?>
