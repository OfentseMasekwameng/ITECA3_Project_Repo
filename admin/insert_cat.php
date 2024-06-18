<?php
include ("../coverFolder/connection.php");

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

if (isset($_POST["insert_cat"])){
    $category_title = $_POST["cat_title"];
    
    // Select data into database
    $select_query = "SELECT * FROM categories WHERE category_title='$category_title'";
    $result_select = mysqli_query($conn, $select_query);
    $number = mysqli_num_rows($result_select);
    if ($number > 0){
        echo "<script>alert('This category is already present inside the database!!')</script>";
    } else {
        // Insert data into database
        $insert_query = "INSERT INTO categories (category_title) VALUES ('$category_title')";        
        $result = mysqli_query($conn, $insert_query);
        if ($result){
            echo "<script>alert('Category has been inserted successfully')</script>";
        }
    }
}
?>

<form action="" method="post" class="">
    <div class="box">
        <span class="icon" id="icon">
            <i class="fa-solid fa-receipt"></i>
        </span>
        <input type="text" class="field" name="cat_title" placeholder="Insert categories" aria-label="Categories">
    </div>

    <div class="">
        <button class="btn" name="insert_cat" style="margin-top: 1rem;" type="submit">Insert Category</button>
    </div>
</form>