<?php
include("coverFolder/connection.php");
include("functions/common.php");
require_once "coverFolder/configSession.inc.php";
require_once "userfolder/loginMVC/loginView.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function make_payment_pending_orders() {
    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        // Redirect to login if user_id is not set
        header("Location: userfolder/login.php");
        exit();
    }
    
    global $conn;
    $order_details = get_order_details();

    // Display order details to the user
    foreach ($order_details as $order) {
        if ($order['order_status'] !== 'paid') {
            echo "Order ID: " . $order['order_id'] . "<br>";
            echo "Invoice Number: " . $order['invoice_number'] . "<br>";
            echo "Amount Due: " . $order['amount_due'] . "<br>";
            // Display other order details as needed...
        
            // Provide option to make payment
            echo '<form action="" method="post">';
            echo '<input type="hidden" name="order_id" value="' . $order['order_id'] . '">';
            echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
            echo '<button type="submit" name="make_payment" class="green_btn">Make Payment</button>';
            echo '</form>';
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['make_payment'])) {
        // Start a transaction
        $conn->begin_transaction();
        try {
            $order_id = $_POST['order_id'];
            $user_id = $_POST['user_id'];
            $date_of_payment = date('Y-m-d H:i:s');
            $status = 'paid';

            // Fetch order details
            $order_query = $conn->prepare("SELECT * FROM user_orders WHERE order_id = ? AND user_id = ? AND order_status != 'paid'");
            $order_query->bind_param("ii", $order_id, $user_id);
            $order_query->execute();
            $order_result = $order_query->get_result();

            if ($order_result->num_rows > 0) {
                $order_row = $order_result->fetch_assoc();
                $invoice_number = $order_row['invoice_number'];
                $amount_due = $order_row['amount_due'];
                
                // Insert into payments table
                $insert_payment = $conn->prepare("INSERT INTO payments (user_id, amount, status, order_id, invoice, date_of_payment) VALUES (?, ?, ?, ?, ?, ?)");
                $insert_payment->bind_param("iiisss", $user_id, $amount_due, $status, $order_id, $invoice_number, $date_of_payment);
                if (!$insert_payment->execute()) {
                    throw new Exception("Payment insertion failed: " . $conn->error);
                }

                // Update order status to 'paid' in user_orders table
                $update_order_query = $conn->prepare("UPDATE user_orders SET order_status = 'paid' WHERE order_id = ? AND user_id = ?");
                $update_order_query->bind_param("ii", $order_id, $user_id);
                if (!$update_order_query->execute()) {
                    throw new Exception("Order update failed: " . $conn->error);
                }
                
                // Delete corresponding pending order from orders_pending table
                $delete_pending_query = $conn->prepare("DELETE FROM orders_pending WHERE order_id = ?");
                $delete_pending_query->bind_param("i", $order_id);
                if (!$delete_pending_query->execute()) {
                    throw new Exception("Pending order deletion failed: " . $conn->error);
                }

                // Commit transaction
                $conn->commit();

                echo '<div class="receipt">
                        <h2>Payment Receipt</h2>
                        <p>Invoice Number: ' . $invoice_number . '</p>
                        <p>Date of Payment: ' . $date_of_payment . '</p>
                        <p>Amount: R' . $amount_due . '</p>
                        <p>Status: ' . $status . '</p>
                    </div>';
            } else {
                echo "Invalid order or order already paid.";
            }

            // $order_query->close();
            // $insert_payment->close();
            // $update_order_query->close();
            // $delete_pending_query->close();
        } catch (Exception $e) {
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Font and CSS Links -->
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@500,600,400,700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/components/checkout.css">
    <link rel="stylesheet" href="styles/components/account.css">
    <link rel="stylesheet" href="styles/components/footer.css">
    <link rel="stylesheet" href="styles/utils.css">
</head>

<body>
    <!--======= Header =======-->
    <header class="header container" id="header">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Kick Kingdom</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="products.php">Products</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php
                                    output_username();
                                ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="userfolder/login.php">Login</a></li>
                                <li><a class="dropdown-item" href="userfolder/signup.php">Register</a></li>
                                <form action="userfolder/logoutProcess.php"><li><button class="dropdown-item" name="logout">Logout</button></li></form>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="cart.php">Cart(<?php cart_items();?>)</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    
    <section class="section container">
        <?php
            make_payment_pending_orders();
        ?>
    </section>
</body>
</html>
