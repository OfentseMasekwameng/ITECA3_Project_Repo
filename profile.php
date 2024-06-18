<?php
    include_once("coverFolder/connection.php");
    require_once "coverFolder/configSession.inc.php";
    require_once "userfolder/loginMVC/loginView.php";
    include_once("functions/common.php");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    // Check if the user is logged in
    if (!isset($_SESSION["user_id"])) {
        // User is not logged in, redirect to login page
        header("Location: userfolder/login.php");
        exit();
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Get the user's IP address
    $user_ip = get_ip_address();
    

    // // Check if the user has items in the cart
    // if (!has_items_in_cart($conn, $user_ip)) {
    //     // No items in the cart, redirect to home page or display a message
    //     echo "<script>alert('No items in cart. Redirecting to home page.'); window.location.href = 'index.php';</script>";
    //     exit();
    // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Page</title>

    <!-- Font awesome & Bootstrap link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href= "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- CSS links -->
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/components/header.css">
    <link rel="stylesheet" href="styles/components/profile.css">
    <link rel="stylesheet" href="styles/components/footer.css">
    <link rel="stylesheet" href="styles/utils.css">
</head>
<body>
    <header class="header container" id="header">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Kick kingdom</a>
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
                            <a class="nav-link dropdown-toggle acc_section" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="profile-menu-img/images/profile.png" alt="" class="acc_pic">
                                <?php
                                    output_username();
                                ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="userfolder/login.php">Login</a></li>
                                <li><a class="dropdown-item" href="userfolder/signup.php">Register</a></li>
                                <form action="userfolder/logoutProcess.php">
                                    <li class="sub-items">
                                        <button class="dropdown-item sub_btn" name="logout">
                                            <img src="profile-menu-img/images/logout.png" alt="logout" class="logout_img">
                                            Logout
                                        </button>
                                    </li>
                                </form>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="cart.php">Cart(<?php cart_items();?>)</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!--====================== BODY =====================-->
    <section class="container section profile_section">
        <div class="column_1">
            <div class="pro-row-1">
                <p class="page_title">User Profile</p>
            </div>
            <div class="ad-row-2">
                <div class="ad-details">
                    <img src="profile-menu-img/images/user.png" alt="" class="user_image">
                    <p class="user_name" id="user_name"> 
                        <?php
                            output_username();
                        ?>
                    </p>
                </div>
                <form action="" method="get">
                    <div class="contrl_links">
                        <a href="profile.php?edit_account">Edit account</a>
                        <a href="profile.php?my_orders">Order Details</a>
                        <a href="profile.php?location">Location</a>
                        <a href="profile.php?review">Leave Review</a>
                        <a href="profile.php?action=delete_account" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">Delete Account</a>
                        <button class="btn" name="logout">Logout</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="column_2">
            <?php
                if (isset($_GET['my_orders'])){
                    include ("profileFolder/orders.php");
                }
                if (isset($_GET['edit_account'])){
                    include ("profileFolder/editAccount.php");
                }
                if (isset($_GET["location"])){
                    include ("profileFolder/userLocation.php");
                } 
                if (isset($_GET["review"])) {
                    include ("profileFolder/userReview.php");
                }else{
                    display_options();
                }
            ?>

        </div>
    </section>

    <!--====================== FOOTER =====================-->
    <?php
        include("footer.php");
    ?>
</body>
</html>


<?php
function display_options(){
    global $conn;

    if (isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];

        // Fetch user details
        $get_details = $conn->prepare("SELECT * FROM site_user WHERE user_id = ?");
        $get_details->bind_param("i", $user_id);
        $get_details->execute();
        $result = $get_details->get_result();

        if ($result->num_rows > 0){
            // Check for orders if not editing account, viewing orders, or deleting account
            if (!isset($_GET['edit_account']) && !isset($_GET['my_orders']) && !isset($_GET['delete_account'])) {
                $order_status = "pending";
                $get_orders = $conn->prepare("SELECT * FROM user_orders WHERE user_id = ? AND order_status = ?");
                $get_orders->bind_param("is", $user_id, $order_status);
                $get_orders->execute();
                $get_order_results = $get_orders->get_result();
                $row_count = $get_order_results->num_rows;

                if ($row_count > 0){
                    echo '<h3 class="text-center">You have <span class="green_msg">' . $row_count . '</span> pending orders.</h3>';
                    echo '<p class="text-center"><a href="profile.php?my_orders" class="order_details_link">Order Details.</a></p>';
                } else {
                    echo '<h3 class="text-center">You have no pending orders.</h3>';
                    echo '<p class="text-center"><a href="products.php">Explore Products Page.</a></p>';
                }
            }
        } else{
            echo '<h3 class="text-center">User details not found.</h3>';
        }
    } else{
        echo '<h3 class="text-center">Please log in to view your profile.</h3>';
    }
}

?>