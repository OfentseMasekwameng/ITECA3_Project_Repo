<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Area</title>
</head>

    <!-- font Link -->
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@500,600,400,700&display=swap" rel="stylesheet"/>

    <!-- Font awesome & Bootstrap link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">

    <!-- CSS links -->
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/components/header.css">
    <link rel="stylesheet" href="styles/ad_styles.css">
    <link rel="stylesheet" href="styles/tablestyles.css">
    <link rel="stylesheet" href="styles/insprodstyle.css">
    <link rel="stylesheet" href="../styles/components/footer.css">
    <link rel="stylesheet" href="../styles/utils.css">

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
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                User account
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Login</a></li>
                                <li><a class="dropdown-item" href="#">Register</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <!--====================== BODY =====================-->
    <main>
        <section class="container admin_section">
            <div class="ad-col-1">
                <div class="ad-row-1">
                    <p class="page_title">Manager Details</p>
                </div>
                <div class="ad-row-2">
                    <div class="ad-details">
                        <img src="" alt="" class="admin_image">
                        <p class="admin_name" id="admin_name">Admin Name</p>
                    </div>
                    <div class="ad_btn">
                        <a href="admin.php?insert_product" class="contr_link"><button class="btn admin_btn">Insert Products</button></a>
                        <a href="admin.php?view_products" class="contr_link"><button class="btn admin_btn">View Products</button></a>
                        <a href="admin.php?insert_category" class="contr_link"><button class="admin_btn btn">Insert Categories</button></a>
                        <a href="admin.php?view_cat.php" class="contr_link"><button class="btn admin_btn">View Categories</button></a>
                        <a href="admin.php?insert_brands" class="contr_link"><button class="btn admin_btn">Insert Brands</button></a>
                        <a href="admin.php?view_brands.php" class="contr_link"><button class="btn admin_btn">View Brands</button></a>
                        <a href="admin.php?orders.php" class="contr_link"><button class="btn admin_btn">All orders</button></a>
                        <a href="admin.php?all_payments.php" class="contr_link"><button class="btn admin_btn">All payments</button></a>
                        <a href="admin.php?LOU.php" class="contr_link"><button class="btn admin_btn">List of Users</button></a>
                        <a href="#" class="contr_link"><button class="btn admin_btn">Log Out</button></a>
                    </div>
                </div>
            </div>
            <div class="ad-col-2">
                <?php
                    if (isset($_GET["insert_product"])){
                        include("ins_prod.php");
                    }
                    if (isset($_GET["insert_category"])){
                        include("insert_cat.php");
                    }
                    if (isset($_GET["insert_brands"])){
                        include("insert_brand.php");
                    }
                    if (isset($_GET["view_products"])){
                        include("view_prod.php");
                    }
                ?>
            </div>
        </section>
    </main>

    <!--====================== FOOTER =====================-->
    <footer class="footer container section">
        <div class="row">
            <div class="footer-col-1">
                <h3>Download Our App</h3>
                <p>Download App For Android and iOS mobile phone</p>
                <div class="app-logo">
                    <img src="../imgs/play-store.png" alt="">
                    <img src="../imgs/app-store.png" alt="">
                </div>
            </div>
            <div class="footer-col-2">
                <div class="web-logo">
                    <img src="../imgs/logo.png">
                </div>
                <p>Our Purpose Is To Sustainability Make the Pleasure
                    and Benefits of Sports Accesible to the Many.</p>
            </div>
            <div class="footer-col-3">
                <h3>Useful Links</h3>
                <ul>
                    <li>Coupons</li>
                    <li>Blog Post</li>
                    <li>Return Policy</li>
                    <li>Join Affiliate</li>
                </ul>
            </div>
            <div class="footer-col-4">
                <h3>Follow us</h3>
                <ul>
                    <li>Facebook</li>
                    <li>Twitter</li>
                    <li>Instagram</li>
                    <li>You Tube</li>
                </ul>
            </div>
        </div>
        <hr>
        <p class="copyright">Copyright 2023 - Offy doffy, Credit: Easy Tutorials </p>
    </footer>
    
</body>
</html>