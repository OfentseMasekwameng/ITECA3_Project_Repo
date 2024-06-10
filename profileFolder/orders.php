<?php
include("includes/connection.php");
require_once "includes/configSession.inc.php";
require_once "userfolder/loginMVC/loginView.php";
require_once "functions/common.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_order']) && isset($_POST['order_id'])) {
    if (isset($_SESSION['user_id'])) {
        $order_id = $_POST['order_id'];
        $user_id = $_SESSION['user_id'];
        $message = delete_order($order_id, $user_id);
        echo "<script>alert('$message'); window.location.href = 'profile.php';</script>";
    } else {
        echo '<script>window.location.href = "../userfolder/login.php";</script>';
        exit();
    } 
} elseif (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $pending_orders = get_pending_orders($user_id);
} else {
    echo '<script>window.location.href = "../userfolder/login.php";</script>';
    exit();
}

function get_pending_orders($user_id) {
    global $conn;
    $orders_query = $conn->prepare("SELECT * FROM user_orders WHERE user_id = ? AND order_status = 'pending'");
    $orders_query->bind_param("i", $user_id);
    $orders_query->execute();
    $result = $orders_query->get_result();
    $orders = [];
    while ($order = $result->fetch_assoc()) {
        $orders[] = $order;
    }
    $orders_query->close();
    return $orders;
}

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch order details from user_orders table
    $get_order_details = "SELECT invoice_number, amount_due FROM user_orders WHERE order_id = ?";
    $stmt = mysqli_prepare($conn, $get_order_details);
    mysqli_stmt_bind_param($stmt, "i", $order_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $order_details = mysqli_fetch_assoc($result);

    // Check if order details are found
    if ($order_details) {
        $invoice_number = $order_details['invoice_number'];
        $amount_due = $order_details['amount_due'];
    } else {
        echo "<script>alert('Order not found.'); window.location.href = 'cart.php';</script>";
        exit();
    }

    mysqli_stmt_close($stmt);
}

$order_details = get_order_details();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pending Orders</title>
    <link rel="stylesheet" href="../styles/utils.css">
</head>
<body>
    <h1 class="text-center">Pending Orders</h1>
    <?php if (!empty($pending_orders)): ?>
        <?php foreach ($pending_orders as $order): ?>
            <div class="order">
                <p>Order ID: <?= $order['order_id'] ?></p>
                <p>Invoice Number: <?= $order['invoice_number'] ?></p>
                <p>Amount Due: R<?= $order['amount_due'] ?></p>
                <p>Total Products: <?= $order['total_product'] ?></p>
                <p>Order Date: <?= $order['order_date'] ?></p>
                <p>Order Status: <?= $order['order_status'] ?></p>
                <div class="buttons d-flex">
                    <form method="POST" action="">
                        <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                        <button type="submit" name="delete_order" class="btn">Delete Order</button>
                    </form>
                    <form action="payment.php" method="get">
                        <button type="submit" name="make_payment" class="green_btn">Make Payment</button>
                    </form>
                </div>
                <hr>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center">No pending orders found.</p>
    <?php endif; ?>
</body>
</html>
