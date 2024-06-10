<?php
include_once("includes/connection.php");

function store_address($user_id, $street, $city, $state, $country, $postal_code) {
    global $conn;

    // Prepare the SQL statement for inserting the address
    $insert_address_stmt = $conn->prepare("INSERT INTO user_address (user_id, street, city, state, country, postal_code) VALUES (?, ?, ?, ?, ?, ?)");
    $insert_address_stmt->bind_param("isssss", $user_id, $street, $city, $state, $country, $postal_code);

    // Execute the insertion and handle the result
    if ($insert_address_stmt->execute()) {
        // Address stored successfully
        echo '<script>alert("Address stored successfully")</script>';
    } else {
        // Failed to store address
        echo '<script>alert("Failed to store address")</script>';
    }

    // Close the prepared statement
    $insert_address_stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enter Delivery Address</title>
</head>

<body>
    <h1>Enter Your Delivery Address</h1>
    <form id="addressForm" action="" method="post">
        <div class="row">
            <div class="col-50">
                <h3>Billing Address</h3>
                <label for="street">Street</label>
                <input type="text" id="street" name="street" placeholder="542 W. 15th Street" class="update_form">
                <label for="city">City</label>
                <input type="text" id="city" name="city" placeholder="Johannesburg" class="update_form">

                <div class="col-50">
                    <label for="state">Province</label>
                    <input type="text" id="state" name="state" placeholder="Gauteng" class="update_form">
                </div>
                <div class="col-50">
                    <label for="country">Country</label>
                    <input type="text" id="country" name="country" value="South Africa" class="update_form" readonly>
                </div>
                <div class="col-50">
                    <label for="postal_code">Postal Code</label>
                    <input type="text" id="postal_code" name="postal_code" placeholder="10001" class="update_form">
                </div>
            </div>
        </div>
        <br>
        <button type="submit" class="btn">Submit Address</button>
    </form>

    <?php
    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $street = $_POST['address'] ?? '';
        $city = $_POST['city'] ?? '';
        $state = $_POST['state'] ?? '';
        $country = 'South Africa'; // Assuming the country is South Africa
        $postal_code = $_POST['zip'] ?? '';
        
        // Assuming user_id is already stored in session
        $user_id = $_SESSION['user_id'] ?? null;

        // Check if user_id is available
        if ($user_id) {
            // Call the function to store address
            store_address($user_id, $street, $city, $state, $country, $postal_code);
        } else {
            // Handle the case where user_id is not available (redirect to login page or display a message)
            echo '<script>alert("User ID not found. Please log in to store the address.")</script>';
        }
    }
    ?>
</body>
</html>
