<?php
include("coverFolder/connection.php");
require_once "coverFolder/configSession.inc.php";
require_once "userfolder/loginMVC/loginView.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    // User is not logged in, redirect to login page
    echo "<script>window.location.href = 'userfolder/login.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $street = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = 'South Africa';
    $cardname = $_POST['cardname'];
    $cardnumber = $_POST['cardnumber'];
    $expmonth = $_POST['expmonth'];
    $expyear = $_POST['expyear'];
    $cvv = $_POST['cvv'];

    // Validate input lengths
    if (empty($postal_code) || empty($cardnumber) || empty($expyear) || empty($cvv)) {
        echo "<script>alert('Please make sure all fields are filled in correctly.');</script>";
    } else {
        // Insert billing address
        $stmt = $conn->prepare("INSERT INTO user_address (user_id, street, city, state, country, postal_code) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $user_id, $street, $city, $state, $country, $postal_code);
        $stmt->execute();
        $address_id = $stmt->insert_id;
        $stmt->close();

        // Insert payment details
        $stmt = $conn->prepare("INSERT INTO payment_details (user_id, address, city, state, zip, cardname, cardnumber, expmonth, expyear, cvv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssssss", $user_id, $street, $city, $state, $postal_code, $cardname, $cardnumber, $expmonth, $expyear, $cvv);
        $stmt->execute();
        $payment_id = $stmt->insert_id;
        $stmt->close();

        echo "<script>alert('Payment details processed successfully.'); window.location.href = 'checkoutpage.php';</script>";
    }
}
?>

<div class="pay_columns">
    <div class="col-75">
        <div class="mini_container">
            <form action="#" method="post">
                <div class="billing_container">
                    <div class="col-50">
                        <h3>Billing Address</h3>
                        <label for="adr"><i class="fa-solid fa-address-card"></i> Address</label>
                        <input type="text" id="adr" name="address" placeholder="542 W. 15th Street">
                        <label for="city"><i class="fa-solid fa-building-columns"></i> City</label>
                        <input type="text" id="city" name="city" placeholder="Johannesburg">
                    </div>

                    <div class="min_row">
                        <div class="col-50">
                            <label for="state">Province</label>
                            <input type="text" id="state" name="state" placeholder="Gauteng">
                        </div>
                        <div class="col-50">
                            <label for="zip">Zip</label>
                            <input type="text" id="zip" name="zip" placeholder="10001">
                        </div>
                    </div>

                    <div class="col-50">
                        <h3>Payment</h3>
                        <label for="fname">Accepted Cards</label>
                        <div class="icon-container">
                            <i class="fa-brands fa-cc-visa" style="color:navy;"></i>
                            <i class="fa-brands fa-cc-amex" style="color:blue;"></i>
                            <i class="fa-brands fa-cc-mastercard" style="color:red;"></i>
                            <i class="fa-brands fa-cc-discover" style="color:orange;"></i>
                        </div>
                        <label for="cname">Name on Card</label>
                        <input type="text" id="cname" name="cardname" placeholder="John More Doe">
                        <label for="ccnum">Credit card number</label>
                        <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">
                        <label for="expmonth">Exp Month</label>
                        <input type="text" id="expmonth" name="expmonth" placeholder="September">
                    </div>
                </div>
                <div class="row_wrapper">
                    <div class="col_wrapper">
                        <label for="expyear">Exp Year</label>
                        <input type="text" id="expyear" name="expyear" placeholder="2018">
                    </div>
                    <div class="col_wrapper">
                        <label for="cvv">CVV</label>
                        <input type="text" id="cvv" name="cvv" placeholder="352">
                    </div>
                </div>
        </div>
                <div class="last_sec">
                    <label>
                        <input type="checkbox" checked="checked" name="sameadr"> Shipping address same as billing
                    </label>
                    <input type="submit" value="Make Payment" name="payment" class="green_btn">
                </div>
            </form>
        <?php
            if (isset($_GET["payment"])){
                include("payment.php");
            }
        ?>
    </div>
</div>
</div>