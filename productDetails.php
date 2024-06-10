<?php
    include_once("includes/connection.php");
    require_once "includes/configSession.inc.php";
    require_once "userfolder/loginMVC/loginView.php";
    include_once("functions/common.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kick kingdom Product Details Page</title>

    <!-- font Link -->
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@500,600,400,700&display=swap" rel="stylesheet"/>

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
    <link rel="stylesheet" href="styles/components/proDetail.css">
    <link rel="stylesheet" href="styles/components/prod.css">
    <link rel="stylesheet" href="styles/components/footer.css">
    <link rel="stylesheet" href="styles/utils.css">

</head>
<body>
    <!--==================== HEADER ====================-->
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
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
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
                                <li>
                                    <a class="dropdown-item d-flex" href="profile.php">
                                        <img src="profile-menu-img/images/profile.png" alt="" class="acc_pic">    
                                        User profile
                                    </a>
                                </li>
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
                            <a class="nav-link" aria-current="page" href="cart.php">Cart(<?php cart_items();?>)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="cart.php">Total Price:R <?php cart_total_price();?></a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search" action="searchproduct.php" method="get">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
                        <button class="btn" type="submit" value="Search" name="search_data_product">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    
    <!--====================== BODY =====================-->
    <main>
        <?php
            view_details();

            include("productReview.php");
        ?>
        <?php
            include("relatedproducts.php");
        ?>
    </main>

    <!--====================== FOOTER =====================-->
    <?php
        include("footer.php");
    ?>
    <!--=============== MAIN JS ===============-->
    <script src="src/components/header.js"></script>
</body>
</html>