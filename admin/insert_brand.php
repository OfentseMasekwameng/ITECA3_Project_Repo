<?php
include ("../includes/connection.php");

if (isset($_POST["insert_brand"])){
    $brand_title = $_POST["brand_title"];
    
    // Select data into database
    $select_query = "SELECT * FROM brands WHERE brand_title='$brand_title'";
    $result_select = mysqli_query($conn, $select_query);
    $number = mysqli_num_rows($result_select);
    if ($number > 0){
        echo "<script>alert('This brand is already present inside the database!!')</script>";
    } else {
        // Insert data into database
        $insert_query = "INSERT INTO brands (brand_title) VALUES ('$brand_title')";
        $result = mysqli_query($conn, $insert_query);
        if ($result){
            echo "<script>alert('Brand has been inserted successfully')</script>";
        }
    }
}
?>


<form action="" method="post" class="">
    <div class="box">
        <span class="icon" id="icon">
            <i class="fa-solid fa-receipt"></i>
        </span>
        <input type="text" class="field" name="brand_title" placeholder="Insert Brands" aria-label="Username">
    </div>

    <div class="">
        <button class="btn" name="insert_brand" style="margin-top: 1rem;">Insert Brand</button>
    </div>
</form>
