<?php
include('../coverFolder/connection.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
global $conn;

if (isset($_GET["edit_products"])) {
    $edit_id = $_GET["edit_products"];

    $get_data = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $get_data->bind_param("i", $edit_id);
    $get_data->execute();
    $result_query = $get_data->get_result();
    $row = $result_query->fetch_assoc();
    
    $product_title = $row["product_title"];
    $product_description = $row["product_description"];
    $product_keyword = $row["product_keyword"];
    $product_category = $row["category_id"];
    $product_brand = $row["brand_id"];
    $product_price = $row["product_price"];
    $product_status = "true";
    
    // Access images
    $product_image1 = $row["product_image1"];
    $product_image2 = $row["product_image2"];
    $product_image3 = $row["product_image3"];
    
    $get_data->close();
}

if (isset($_POST["edit_product"])) {
    // Use the current values from the database if form fields are not set
    $product_title = isset($_POST["product_title"]) ? $_POST["product_title"] : $product_title;
    $product_description = isset($_POST["product_description"]) ? $_POST["product_description"] : $product_description;
    $product_keyword = isset($_POST["product_keyword"]) ? $_POST["product_keyword"] : $product_keyword;
    $product_category = isset($_POST["product_category"]) ? $_POST["product_category"] : $product_category;
    $product_brand = isset($_POST["product_brand"]) ? $_POST["product_brand"] : $product_brand;
    $product_price = isset($_POST["product_price"]) ? $_POST["product_price"] : $product_price;
    
    // Accessing image files
    $product_image1 = isset($_FILES["product_image1"]["name"]) && $_FILES["product_image1"]["name"] != '' ? $_FILES["product_image1"]["name"] : $product_image1;
    $product_image2 = isset($_FILES["product_image2"]["name"]) && $_FILES["product_image2"]["name"] != '' ? $_FILES["product_image2"]["name"] : $product_image2;
    $product_image3 = isset($_FILES["product_image3"]["name"]) && $_FILES["product_image3"]["name"] != '' ? $_FILES["product_image3"]["name"] : $product_image3;
    
    // Accessing image temporary names
    $temp_image1 = $_FILES["product_image1"]["tmp_name"];
    $temp_image2 = $_FILES["product_image2"]["tmp_name"];
    $temp_image3 = $_FILES["product_image3"]["tmp_name"];
    
    // Moving uploaded files
    if ($temp_image1) {
        move_uploaded_file($temp_image1, "../imgs/Feat_products/$product_image1");
    }
    if ($temp_image2) {
        move_uploaded_file($temp_image2, "../imgs/Feat_products/$product_image2");
    }
    if ($temp_image3) {
        move_uploaded_file($temp_image3, "../imgs/Feat_products/$product_image3");
    }

    $update_query = $conn->prepare("UPDATE products SET product_title=?, product_description=?, product_keyword=?, category_id=?, brand_id=?, product_price=?, product_image1=?, product_image2=?, product_image3=?, status=? WHERE product_id=?");
    $update_query->bind_param("sssiiissssi", $product_title, $product_description, $product_keyword, $product_category, $product_brand, $product_price, $product_image1, $product_image2, $product_image3, $product_status, $edit_id);

    if ($update_query->execute()) {
        echo '<script>("Product updated successfully!")</script>';
    } else {
        echo "<script>alert('Error updating product: " . $conn->error . "');</script>";
    }

    $update_query->close();
}
?>

<div>
    <h1 class="text-center">Edit products</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="insert_form">
            <!-- PRD TITLE -->
            <label for="prod_title" class="prod_label">Product Title: </label>
            <input type="text" class="prod_input" id="prod_input" name="product_title" placeholder="Enter product title" autocomplete="off" value="<?php echo htmlspecialchars($product_title); ?>">

            <!-- PRD DESCRIPTION -->
            <label for="prod_description" class="prod_label">Product Description: </label>
            <input type="text" class="prod_input" id="prod_input" name="product_description" placeholder="Enter the product description" autocomplete="off" value="<?php echo htmlspecialchars($product_description); ?>">

            <!-- PRD KEYWORD -->
            <label for="prod_keyword" class="prod_label">Product Keyword: </label>
            <input type="text" class="prod_input" id="prod_input" name="product_keyword" placeholder="Enter a keyword for the product" autocomplete="off" value="<?php echo htmlspecialchars($product_keyword); ?>">
        </div>

        <!-- SELECT SECTION -->
        <div class="slt_section">
            <select name="product_category" id="slt_category" class="slt_opt">
                <option value="">Select A Category</option>
                <?php
                    // Fetch categories
                    $select_query = "SELECT * FROM categories";
                    $result_query = mysqli_query($conn, $select_query);
                    while ($row = mysqli_fetch_assoc($result_query)){
                        $category_title = $row['category_title'];
                        $category_id = $row['category_id'];
                        echo '<option value="'.$category_id.'">'.$category_title.'</option>';
                    }
                ?>
            </select>

            <select name="product_brand" id="slt_brand" class="slt_opt">
                <option value="">Select A Brand</option>
                <?php
                    // Fetch brands 
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
        <input type="text" name="product_price" id="product_price" class="product_price" placeholder="Enter price for the product" value="<?php echo htmlspecialchars($product_price); ?>">

        <button class="btn" name="edit_product" style="margin-top: 1rem;">Submit</button>
    </form>
</div>
