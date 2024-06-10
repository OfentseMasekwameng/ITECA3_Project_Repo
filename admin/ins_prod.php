<?php
include('../includes/connection.php');



if (isset($_POST["insert_product"])){
    $product_title = $_POST["product_title"];
    $product_description = $_POST["product_description"];
    $product_keyword = $_POST["product_keyword"];
    $product_category = $_POST["product_category"];
    $product_brand = $_POST["product_brand"];
    $product_price = $_POST["product_price"];
    $product_status = "true";
    
    // ACCESS IMAGES
    $product_image1 = $_FILES["product_image1"]["name"];
    $product_image2 = $_FILES["product_image2"]["name"];
    $product_image3 = $_FILES["product_image3"]["name"];
    
    // ACCESSIING IMAGE TEMPORARY NAME
    $temp_image1 = $_FILES["product_image1"]["tmp_name"];
    $temp_image2 = $_FILES["product_image2"]["tmp_name"];
    $temp_image3 = $_FILES["product_image3"]["tmp_name"];
    
    // CHECKING EMPTY CONDITION

    if ($product_title=="" or $product_description=="" or $product_keyword=="" or $product_category=="" or $product_brand=="" or $product_price=="" or $product_image1=="" or $product_image2=="" or $product_image3==""){
        echo "<script>alert('Please fill all the available inputs')</script>";
        exit();
    } else {
        move_uploaded_file($temp_image1, "../imgs/Feat_products/$product_image1");
        move_uploaded_file($temp_image2, "../imgs/Feat_products/$product_image2");
        move_uploaded_file($temp_image3, "../imgs/Feat_products/$product_image3");

        // INSERT QUERY
        $insert_products = "INSERT INTO products (product_title, product_description, product_keyword, category_id, brand_id, product_image1, product_image2, product_image3, product_price, date, status)
        VALUES ('$product_title', '$product_description', '$product_keyword', '$product_category', '$product_brand', '$product_image1', '$product_image2', '$product_image3', '$product_price', NOW(), '$product_status')";

        $result_query = mysqli_query($conn, $insert_products);
        if ($result_query){
            echo "<script>alert('Products have been succesfully inserted')</script>";
        }
    }

}

?>

<h1 class="title">Insert Products</h1>

<form action="" method="post" enctype="multipart/form-data">
    <div class="insert_form">
        <!-- PRD TITLE -->
        <label for="prod_title" class="prod_label">Product Title: </label>
        <input type="text" class="prod_input" id="prod_input" name="product_title" placeholder="Enter product title" autocomplete="off">

        <!-- PRD DESCRITPTION -->
        <label for="prod_description" class="prod_label">Product Description: </label>
        <input type="text" class="prod_input" id="prod_input" name="product_description" placeholder="Enter the product descritption" autocomplete="off">

        <!-- PRD KEYWORD -->
        <label for="prod_keyword" class="prod_label">Product Keyword: </label>
        <input type="text" class="prod_input" id="prod_input" name="product_keyword" placeholder="Enter a keyword for the product" autocomplete="off">
    </div>

    <!-- SELEECT SECTION -->
    <div class="slt_section">
        <select name="product_category" id="slt_category" class="slt_opt">
            <option value="">Select A Category</option>

            <?php
            $select_query = "SELECT * FROM categories";
            $result_query = mysqli_query($conn, $select_query);
            while ($row = mysqli_fetch_assoc($result_query)){
                $category_title = $row['category_title'];
                $category_id = $row['category_id'];
                echo '<option value="'.$category_id.'">'.$category_title.'</option>';
            }
            ?>

        </select>
        <select name="product_brand" id="slt_brand" class="slt_opt">\
            <option value="">Select A Brand</option>

            <?php
                $select_query = "SELECT * FROM brands";
                $result_query = mysqli_query($conn, $select_query);
                while ($row = mysqli_fetch_assoc($result_query)){
                    $brand_title = $row['brand_title'];
                    $brand_id = $row['brand_id'];
                    echo '<option value="'.$brand_id.'">'.$brand_title.'</option>';
                }
            ?>
            </select>
    </div>

    <div class="img_selection">
        <!-- IMAGE 1 -->
        <label for="pro_img1" class="prod_img_title">Product image 1</label>
        <input type="file" name="product_image1" id="product_image" class="product_img_input">
        <!-- IMAGE 2 -->
        <label for="pro_img2" class="prod_img_title">Product image 2</label>
        <input type="file" name="product_image2" id="product_image" class="product_img_input">
        <!-- IMAGE 3 -->
        <label for="pro_img3" class="prod_img_title">Product image 3</label>
        <input type="file" name="product_image3" id="product_image" class="product_img_input">
    </div>

    <!-- PRICE -->
    <label for="pro_price" class="prod_price">Product price</label>
    <input type="text" name="product_price" id="product_price" class="product_price" placeholder="Enter price for the product">

    <button class="btn" name="insert_product" style="margin-top: 1rem;">Submit</button>
</form>