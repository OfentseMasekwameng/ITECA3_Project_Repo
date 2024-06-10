<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['make_payment'])) {
    $user_id = $_SESSION['user_id'];
    $order_id = $_POST['order_id'];
    $amount = $_POST['amount'];
    $status = 'completed';
    $invoice = 'INV' . time();
    $date_of_payment = date('Y-m-d H:i:s');

    // Insert into payments table
    $insert_payment = $conn->prepare("INSERT INTO payments (user_id, order_id, payment_date, amount, status, invoice, date_of_payment) VALUES (?, ?, NOW(), ?, ?, ?, ?)");
    $insert_payment->bind_param("iiisss", $user_id, $order_id, $amount, $status, $invoice, $date_of_payment);

    if ($insert_payment->execute()) {
        // Update user_orders status to 'paid'
        $update_order = $conn->prepare("UPDATE user_orders SET order_status = 'paid' WHERE order_id = ?");
        $update_order->bind_param("i", $order_id);
        $update_order->execute();
        $update_order->close();

        // Delete the order from orders_pending
        $delete_pending_order = $conn->prepare("DELETE FROM orders_pending WHERE order_id = ?");
        $delete_pending_order->bind_param("i", $order_id);
        $delete_pending_order->execute();
        $delete_pending_order->close();

        // Fetch delivery address
        $address_query = $conn->prepare("SELECT * FROM user_address WHERE user_id = ?");
        $address_query->bind_param("i", $user_id);
        $address_query->execute();
        $address_result = $address_query->get_result();
        $address = $address_result->fetch_assoc();
        $address_query->close();

        echo '<div class="receipt">
                <h2>Payment Receipt</h2>
                <p>Invoice Number: ' . $invoice . '</p>
                <p>Date of Payment: ' . $date_of_payment . '</p>
                <p>Amount: R' . $amount . '</p>
                <p>Status: ' . $status . '</p>
                <h3>Delivery Address</h3>
                <p>' . $address['street'] . '</p>
                <p>' . $address['city'] . '</p>
                <p>' . $address['state'] . '</p>
                <p>' . $address['country'] . '</p>
                <p>' . $address['postal_code'] . '</p>
              </div>';
    } else {
        echo "Error: " . $conn->error;
    }

    $insert_payment->close();
    $conn->close();
}
?>