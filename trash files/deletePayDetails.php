<?php
// Check if the request method is POST and if the user is trying to delete payment details
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_payment'])) {
        $user_id = $_SESSION['user_id'];

        // Delete payment details associated with the user
        $stmt = $conn->prepare("DELETE FROM payment_details WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Payment details deleted successfully.'); window.location.href = 'checkoutpage.php';</script>";
        } else {
            echo "<script>alert('Failed to delete payment details.'); window.location.href = 'checkoutpage.php';</script>";
        }

        $stmt->close();
    }
?>

<!-- HTML Form to Confirm Payment Details Deletion -->
<form method="post" onsubmit="return confirm('Are you sure you want to delete your payment details?');">
    <input type="hidden" name="delete_payment">
    <input type="submit" value="Delete Payment Details" class="delete_btn">
</form>