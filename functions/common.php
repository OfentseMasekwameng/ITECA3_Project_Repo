<?php
include ("../includes/connection.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// GETTING PRODUCTS
function get_products(){
    global $conn;
    $select_query =  "SELECT * FROM products ORDER BY rand() LIMIT 0,5";
    $result_query = mysqli_query($conn, $select_query);
    // $row = mysqli_fetch_assoc($result_query);

    while($row = mysqli_fetch_assoc($result_query)){
        $product_id = $row['product_id'];
        $product_title = $row['product_title'];
        $product_description = $row['product_description'];
        $product_image1 = $row['product_image1'];
        $product_price = $row['product_price'];
        $category_id = $row['category_id'];
        $brand_id = $row['brand_id'];

        echo '
        <div class="card">
            <div class="product_image">
                <img src="imgs/Feat_products/'.$product_image1.'" alt="'.$product_title.'">
            </div>
            <p class="product_name">'.$product_title.'</p>
            <p class="price">R'.$product_price.'</p>
            <div class="buttons">
                <a href="index.php?add_to_cart='.$product_id.'" value="<?php echo '.$product_id.'; ?>"><button class="btn btn1">Add to cart</button></a>
                <a href="productDetails.php?product_id='.$product_id.'&category_id='.$category_id.'"><button class="btn btn2">View More</button></a>
            </div>
        </div>
        ';
    }
}

function get_all_products(){
    global $conn;

    $select_query =  "SELECT * FROM products ORDER BY rand()";
    $result_query = mysqli_query($conn, $select_query);

    while($row = mysqli_fetch_assoc($result_query)){
        $product_id = $row['product_id'];
        $product_title = $row['product_title'];
        $product_description = $row['product_description'];
        $product_image1 = $row['product_image1'];
        $product_price = $row['product_price'];
        $category_id = $row['category_id'];
        $brand_id = $row['brand_id'];


        echo '
        <div class="card">
            <div class="product_image">
                <img src="imgs/Feat_products/'.$product_image1.'" alt="'.$product_title.'">
            </div>
            <p class="product_name">'.$product_title.'</p>
            <p class="price">R'.$product_price.'</p>
            <div class="buttons">
                <a href="products.php?add_to_cart='.$product_id.'"><button class="btn btn1">Add to cart</button></a>
                <a href="productDetails.php?product_id='.$product_id.'&category_id='.$category_id.'"><button class="btn btn2">View More</button></a>
            </div>
        </div>
        ';
    }
}

function search_product() {
    global $conn;

    if (isset($_GET['search_data_product']) && isset($_GET['search_data'])) {
        $search_data_value = $_GET['search_data'];

        // Use LOWER to perform a case-insensitive search
        $search_query = "SELECT * FROM products WHERE LOWER(product_keyword) LIKE LOWER('%" . mysqli_real_escape_string($conn, $search_data_value) . "%')";
        $result_query = mysqli_query($conn, $search_query);

        if (!$result_query) {
            // Debug: Output SQL error
            echo "SQL Error: " . mysqli_error($conn) . "<br>";
            return;
        }

        $num_of_rows = mysqli_num_rows($result_query);
        if ($num_of_rows == 0) {
            echo '<h2 class="err_msg">Results do not match. No products found in this category</h2>';
        } else {
            while ($row = mysqli_fetch_assoc($result_query)) {
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_description = $row['product_description'];
                $product_image1 = $row['product_image1'];
                $product_price = $row['product_price'];
                $category_id = $row['category_id'];
                $brand_id = $row['brand_id'];

                echo '
                <div class="card">
                    <div class="product_image">
                        <img src="imgs/Feat_products/' . htmlspecialchars($product_image1) . '" alt="' . htmlspecialchars($product_title) . '">
                    </div>
                    <p class="product_name">' . htmlspecialchars($product_title) . '</p>
                    <p class="price">R' . htmlspecialchars($product_price) . '</p>
                    <div class="buttons">
                        <a href="index.php?add_to_cart=' . htmlspecialchars($product_id) . '"><button class="btn btn1">Add to cart</button></a>
                        <a href="productDetails.php?product_id=' . htmlspecialchars($product_id) . '&category_id=' . htmlspecialchars($category_id) . '"><button class="btn btn2">View More</button></a>
                    </div>
                </div>
                ';
            }
        }
    } else {
        // Debug: Output if search_data_product is not set
        echo "search_data_product or search_data not set.<br>";
    }
}

function view_details(){
    global $conn;

    if (isset($_GET['product_id'])){
        $product_id = $_GET['product_id'];
        $select_query =  "SELECT * FROM products WHERE  product_id=$product_id";
        $result_query = mysqli_query($conn, $select_query);
        $row = mysqli_fetch_assoc($result_query);
        
        if ($row){
            $product_id = $row['product_id'];
            $product_title = $row['product_title'];
            $product_description = $row['product_description'];
            $product_image1 = $row['product_image1'];
            $product_image2 = $row['product_image2'];
            $product_image3 = $row['product_image3'];
            $product_price = $row['product_price'];
            $category_id = $row['category_id'];
            $brand_id = $row['brand_id'];
            
            echo '
            <section class="container product_details_wrapper section">
                <div class="img_wrapper">
                    <img src="imgs/Feat_products/'.$product_image1.'" alt="'.$product_image1.'" class="main_img">
                    <div class="small_img_grp">
                        <div class="small_img_wrapper">
                            <img src="imgs/Feat_products/'.$product_image2.'" alt="'.$product_image2.'" class="secondary_img">
                        </div>
                        <div class="small_img_wrapper">
                            <img src="imgs/Feat_products/'.$product_image3.'" alt="'.$product_image3.'" class="secondary_img">   
                        </div>
                    </div>
                </div>
                <div class="product_content">
                    <p class="product_title">'.$product_title.'</p>
                    <p class="product_price">R'.$product_price.'</p>
                    <input type="number" placeholder="Enter size number" class="product_size">
                    <input type="number" class="qnty_select" placeholder="Enter number of shoes">
                    <a href="index.php?add_to_cart='.$product_id.'" class="btn">Add to Cart</a>
                    <p class="product_description">'.$product_description.'</p>
                </div>
            </section>
                    ';
        }
    } else {
        // Handle the case where no product is found with the ID
        echo '<h2 class="err_msg">Product not found!</h2>';
    }
}

// Display related products inside the product details page
function related_products(){
    global $conn;

    if(isset($_GET['category'])){
        $category_id = $_GET['category_id'];
        $select_query = "SELECT * FROM  products WHERE category_id=$category_id";
        $result_query = mysqli_query($conn, $select_query);
        $row = mysqli_fetch_assoc($result_query);

        while($row = mysqli_fetch_assoc($result_query)){
            $product_id = $row['product_id'];
            $product_title = $row['product_title'];
            $product_description = $row['product_description'];
            $product_image1 = $row['product_image1'];
            $product_price = $row['product_price'];
            $category_id = $row['category_id'];
            $brand_id = $row['brand_id'];
    
            echo '
            <div class="card">
                <div class="product_image">
                    <img src="imgs/Feat_products/'.$product_image1.'" alt="'.$product_title.'">
                </div>
                <p class="product_name">'.$product_title.'</p>
                <p class="price">R'.$product_price.'</p>
                <div class="buttons">
                    <a href="index.php?add_to_cart='.$product_id.'"><button class="btn btn1">Add to cart</button></a>
                    <a href="productDetails.php?product_id='.$product_id.'&category_id='.$category_id.'"><button class="btn btn2">View More</button></a>
                </div>
            </div>
            ';
        }
    }
}

// Get ip address function
function get_ip_address(){
    // WHETHER IP IS FROM THE SHARE INTERNET
    if (!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        // CHECKS IF THE IP ADDRESS IS FROM THE PROXY
        $ip = $_SERVER['HTTP_X_FORWAREDED_FOR'];
    } else {
        // WHETHER IP IS FROM THE REMOTE ADDRESS
        $ip = $_SERVER['REMOTE_ADDR']; 
    }

    return $ip;
}

function cart(){
    if (isset($_GET['add_to_cart'])){
        global $conn;
        $get_ip_address = get_ip_address();
        $get_product_id = $_GET['add_to_cart'];

        // Using prepared statements for the SELECT query
        $select_query = $conn->prepare("SELECT * FROM cart_details WHERE ip_address = ? AND product_id = ?");
        $select_query->bind_param("si", $get_ip_address, $get_product_id);
        $select_query->execute();
        $result_query = $select_query->get_result();
        $num_of_rows = $result_query->num_rows;

        if ($num_of_rows > 0){
            echo '<script>alert("This item is already present inside the cart")</script>';
            echo '<script>window.open("index.php", "_self")</script>';
        } else {
            // Using prepared statements for the INSERT query
            $insert_query = $conn->prepare("INSERT INTO cart_details (product_id, ip_address, cart_quantity) VALUES 
            (?, ?, 1)");
            $insert_query->bind_param("is", $get_product_id, $get_ip_address);
            $insert_query->execute();
            echo '<script>alert("This item is added to the shopping cart")</script>';
            // echo '<script>window.open("index.php", "_self")</script>';
        }
    }
}

// DISPLAYS THE NUMBER OF ITEMS IN THE NAVBAR
function cart_items() {
    global $conn;
    $get_ip_address = get_ip_address();

    // Using prepared statements for the SELECT query
    $select_query = $conn->prepare("SELECT * FROM cart_details WHERE ip_address = ?");
    $select_query->bind_param("s", $get_ip_address);
    $select_query->execute();
    $result_query = $select_query->get_result();
    $num_of_items = $result_query->num_rows;

    echo $num_of_items;
}

// CALCULATES THE TOTAL PRICE OF ITEMS IN  THE SHOPPING CART PAGE
function cart_total_price() {
    global $conn;
    $total = 0;

    $get_ip_address = get_ip_address();

    // Prepare the cart query
    $cart_query = $conn->prepare("SELECT * FROM cart_details WHERE ip_address=?");
    $cart_query->bind_param("s", $get_ip_address);
    $cart_query->execute();
    $result = $cart_query->get_result();

    // Loop through the cart items
    while ($row = $result->fetch_assoc()) {
        $product_id = $row['product_id'];

        // Prepare the product query
        $select_products = $conn->prepare("SELECT product_price FROM products WHERE product_id = ?");
        $select_products->bind_param("i", $product_id);
        $select_products->execute();
        $result_query = $select_products->get_result();

        // Get the product price and add to total
        while ($row_product_price = $result_query->fetch_assoc()) {
            $total += $row_product_price['product_price'];
        }
    }
    echo $total;
}

function calculate_subtotal($product_price, $quantity) {
    return $product_price * $quantity;
}

function value_added_tax($subtotal){
    return $subtotal * 0.02;
}

// UPDATES THE NUMBER OF ITEMS IN THE DATABASE
function set_quantity() {
    global $conn;
    $get_ip_address = get_ip_address();

    if (isset($_POST['update_cart']) && isset($_POST['qty']) && is_array($_POST['qty'])) {
        $quantities = $_POST['qty'];
        foreach ($quantities as $product_id => $quantity) {
            $update_cart = $conn->prepare("UPDATE cart_details SET cart_quantity = ? WHERE ip_address = ? AND product_id = ?");
            if (!$update_cart) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $update_cart->bind_param("isi", $quantity, $get_ip_address, $product_id);
            if (!$update_cart->execute()) {
                die("Execute failed: (" . $update_cart->errno . ") " . $update_cart->error);
            }
        }
    }
}

// DELETE ITEMS FROM THE CART
function remove_cart_item() {
    global $conn;
    $get_ip_address = get_ip_address();

    if (isset($_POST['remove_cart'])) {
        $product_id = $_POST['remove_cart'];
        $remove_query = $conn->prepare("DELETE FROM cart_details WHERE ip_address = ? AND product_id = ?");
        if (!$remove_query) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $remove_query->bind_param("si", $get_ip_address, $product_id);
        if (!$remove_query->execute()) {
            die("Execute failed: (" . $remove_query->errno . ") " . $remove_query->error);
        }

        echo '<script>window.open("cart.php", "_self")</script>';
        exit();
    }
}

// Works the same as cart item functions but this will be called on other files.
function check_cart_items(){
    global $conn;
    $get_ip_address = get_ip_address();

    // Using prepared statements for the SELECT query
    $select_query = $conn->prepare("SELECT * FROM cart_details WHERE ip_address = ?");
    $select_query->bind_param("s", $get_ip_address);
    $select_query->execute();
    $result_query = $select_query->get_result();
    $num_of_items = $result_query->num_rows;

   return $num_of_items;
}

function display_cart() {
    global $conn;

    // Call set_quantity to handle any updates if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        set_quantity();
        remove_cart_item();
    }
    
    $get_ip_address = get_ip_address();
    $num_of_items = check_cart_items();

    if ($num_of_items > 0){
        // Prepare the cart query
        $cart_query = $conn->prepare("SELECT * FROM cart_details WHERE ip_address=?");
        $cart_query->bind_param("s", $get_ip_address);
        $cart_query->execute();
        $result = $cart_query->get_result();
    
        echo '
        <form method="post" action="">
        <table>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>';
    
        $subtotal_final_value = 0; // Initialize subtotal
        // Loop through the cart items
        while ($row = $result->fetch_assoc()) {
            $product_id = $row['product_id'];
            $quantity = $row['cart_quantity'];
    
            // Prepare the product query
            $select_products = $conn->prepare("SELECT product_title, product_image1, product_price FROM products WHERE product_id = ?");
            $select_products->bind_param("i", $product_id);
            $select_products->execute();
            $result_query = $select_products->get_result();
            
            if ($row_product = $result_query->fetch_assoc()) {
                $product_title = $row_product['product_title'];
                $product_image1 = $row_product['product_image1'];
                $product_price = $row_product['product_price'];
                $subtotal = calculate_subtotal($product_price, $quantity);
                $subtotal_final_value += $subtotal; // Accumulate subtotal here
    
                // Display cart item
                echo '
                <tr>
                    <td>
                        <div class="cart_info">
                            <img src="imgs/Feat_products/'.$product_image1.'" alt="main_image" class="cart_img">
                            <div class="product_details">
                                <p class="product_name">'.$product_title.'</p>
                                <small class="product_price">R'.$product_price.'</small><br>
                                <div class="edit_wrapper">
                                    <button type="submit" id="msg_btn" value="'.$product_id.'" name="remove_cart" class="remove_link">Remove</button>
                                    <input type="submit" name="update_cart" value="Update Cart" class="update_link">
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <input type="number" name="qty['.$product_id.']" value="'.$quantity.'" min="1" class="qty_input"><br>
                    </td>
                    <td class="product_price">R'.$subtotal.'</td>
                </tr>';
            }
        }
    
        // Calculate tax based on subtotal
        $tax = value_added_tax($subtotal_final_value);
        $total = $subtotal_final_value + $tax;
    
        echo '
        </table>
        <div class="total_price">
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td class="product_price">R'.$subtotal_final_value.'</td>
                </tr>
                <tr>
                    <td>Tax</td>
                    <td class="product_price">R'.$tax.'</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td class="product_price">R'.$total.'</td>
                </tr>
            </table>
        </div>
        
        </form>';
    } else{
        echo '<p class="message_large">Cart is empty</p>';
    }

}

// CHECKS IF THE LOGGED IN USER HAS ITEMS IN THE CART.
function has_items_in_cart($conn, $user_ip) {
    $query = "SELECT * FROM cart_details WHERE ip_address='$user_ip'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query Failed: " . mysqli_error($conn));
    }

    return mysqli_num_rows($result) > 0;
}

function insert_order() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        } else {
            // Redirect to login if user_id is not set
            echo '<script>window.location.href = "payment.php"</script>';
            exit();
        }

        global $conn;
        $ip_address = get_ip_address();
        $total_price = 0; 
        $count_products = 0; 
        $subtotal_final_value = 0;

        // Prepare the cart query
        $cart_query = $conn->prepare("SELECT * FROM cart_details WHERE ip_address = ?");
        $cart_query->bind_param("s", $ip_address);
        $cart_query->execute();
        $result = $cart_query->get_result();

        // Fetch and calculate total price and count of products
        while ($row = $result->fetch_assoc()) {
            $product_id = $row['product_id'];
            $quantity = $row['cart_quantity'];

            // Prepare the product query
            $select_products = $conn->prepare("SELECT product_price FROM products WHERE product_id = ?");
            $select_products->bind_param("i", $product_id);
            $select_products->execute();
            $result_query = $select_products->get_result();

            if ($row_product = $result_query->fetch_assoc()) {
                $product_price = $row_product['product_price'];
                $product_total_price = $product_price * $quantity;
                $total_price += $product_total_price;
                $count_products += $quantity;
            }
            $select_products->close();
        }
        $cart_query->close();

        $subtotal_final_value = $total_price; 
        $tax = value_added_tax($subtotal_final_value); 
        $total = $subtotal_final_value + $tax; 

        $invoice_number = mt_rand();
        $status = "pending";

        // Insert into user_orders table
        $insert_orders_stmt = $conn->prepare("INSERT INTO user_orders (user_id, amount_due, invoice_number, total_product, order_date, order_status) VALUES (?, ?, ?, ?, NOW(), ?)");
        $insert_orders_stmt->bind_param("idiss", $user_id, $total, $invoice_number, $count_products, $status);

        // Execute order insertion and handle result
        if ($insert_orders_stmt->execute()) {
            // Insert each product in orders_pending table
            $cart_query = $conn->prepare("SELECT * FROM cart_details WHERE ip_address = ?");
            $cart_query->bind_param("s", $ip_address);
            $cart_query->execute();
            $result = $cart_query->get_result();

            // Insert each product in orders_pending table
            while ($row = $result->fetch_assoc()) {
                $product_id = $row['product_id'];
                $quantity = $row['cart_quantity'];
            
                // Check if invoice number is greater than 0
                if ($invoice_number > 0) {
                    $insert_pending_order = $conn->prepare("INSERT INTO orders_pending (user_id, invoice_number, product_id, quantity, order_status) VALUES (?, ?, ?, ?, ?)");
                    $insert_pending_order->bind_param("iiiis", $user_id, $invoice_number, $product_id, $quantity, $status);
                    $insert_pending_order->execute();
                }
            }
            // Close the prepared statements
            $insert_orders_stmt->close();
            $insert_pending_order->close();
            $cart_query->close();

            // Delete items from cart
            $delete_cart_query = $conn->prepare("DELETE FROM cart_details WHERE ip_address = ?");
            $delete_cart_query->bind_param("s", $ip_address);
            $delete_cart_query->execute();
            $delete_cart_query->close();

            echo '<script>alert("Order submitted successfully")</script>';
            $conn->close();
            echo '<script>window.location.href = "payment.php"</script>';
            exit();
        } else {
            echo '<script>alert("Order submission failed")</script>';
            $insert_orders_stmt->close();
            $conn->close();
        }
    } else {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

function get_order_details() {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        // Redirect to login if user_id is not set
        header("Location: userfolder/login.php");
        exit();
    }

    global $conn;

    // Fetch only active user orders
    $orders_query = $conn->prepare("SELECT * FROM user_orders WHERE user_id = ? AND order_status != 'deleted'");
    $orders_query->bind_param("i", $user_id);
    $orders_query->execute();
    $orders_result = $orders_query->get_result();

    $order_details = [];

    while ($order_row = $orders_result->fetch_assoc()) {
        $order_id = $order_row['order_id'];
        $invoice_number = $order_row['invoice_number'];
        $amount_due = $order_row['amount_due'];
        $total_product = $order_row['total_product'];
        $order_date = $order_row['order_date'];
        $order_status = $order_row['order_status'];

        // Fetch products for each order
        $products_query = $conn->prepare("SELECT p.product_title, p.product_price, op.quantity FROM orders_pending op JOIN products p ON op.product_id = p.product_id WHERE op.invoice_number = ? AND op.order_status != 'deleted'");
        $products_query->bind_param("i", $invoice_number);
        $products_query->execute();
        $products_result = $products_query->get_result();

        $products = [];
        $total_product_count = 0;

        while ($product_row = $products_result->fetch_assoc()) {
            $products[] = [
                'product_title' => $product_row['product_title'],
                'product_price' => $product_row['product_price'],
                'quantity' => $product_row['quantity']
            ];
            $total_product_count += $product_row['quantity'];
        }
        $products_query->close();

        // Skip orders with zero products or zero amount
        if ($total_product_count > 0 && $amount_due > 0) {
            $order_details[] = [
                'order_id' => $order_id,
                'invoice_number' => $invoice_number,
                'amount_due' => $amount_due,
                'total_product' => $total_product_count,
                'order_date' => $order_date,
                'order_status' => $order_status,
                'products' => $products
            ];
        }
    }
    $orders_query->close();

    return $order_details;
}

function delete_order($order_id, $user_id) {
    global $conn;

    // Verify the order belongs to the logged-in user
    $verify_order_query = $conn->prepare("SELECT * FROM user_orders WHERE order_id = ? AND user_id = ?");
    $verify_order_query->bind_param("ii", $order_id, $user_id);
    $verify_order_query->execute();
    $verify_order_result = $verify_order_query->get_result();

    if ($verify_order_result->num_rows > 0) {
        // Get the invoice number associated with the order
        $order_row = $verify_order_result->fetch_assoc();
        $invoice_number = $order_row['invoice_number'];

        // Delete from orders_pending
        $delete_pending_query = $conn->prepare("DELETE FROM orders_pending WHERE invoice_number = ?");
        $delete_pending_query->bind_param("i", $invoice_number);
        if (!$delete_pending_query->execute()) {
            return "Failed to delete pending orders: " . $conn->error;
        }
        $delete_pending_query->close();

        // Delete from user_orders
        $delete_order_query = $conn->prepare("DELETE FROM user_orders WHERE order_id = ?");
        $delete_order_query->bind_param("i", $order_id);
        if ($delete_order_query->execute()) {
            $delete_order_query->close();
            return "Order deleted successfully.";
        } else {
            $delete_order_query->close();
            return "Failed to delete order: " . $conn->error;
        }
    } else {
        return "Order not found or you do not have permission to delete this order.";
    }
}


function get_pending_orders_details() {
    global $conn;

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        header("Location: userfolder/login.php");
        exit();
    }

    // Fetch active orders from orders_pending table
    $orders_query = $conn->prepare("SELECT op.order_id, uo.amount_due, uo.invoice_number
                                    FROM orders_pending op
                                    JOIN user_orders uo ON op.order_id = uo.order_id
                                    WHERE op.user_id = ? AND op.order_status != 'deleted'");
    $orders_query->bind_param("i", $user_id);
    $orders_query->execute();
    $orders_result = $orders_query->get_result();

    $order_details = [];

    while ($order_row = $orders_result->fetch_assoc()) {
        $order_details[] = [
            'order_id' => $order_row['order_id'],
            'amount_due' => $order_row['amount_due'],
            'invoice_number' => $order_row['invoice_number'],
        ];
    }

    $orders_query->close();

    return $order_details;
}

?>