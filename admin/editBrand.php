<?php
include ("../coverFolder/connection.php");

// Set error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET["edit_brand"])) {
    $edit_id = $_GET["edit_brand"];

    $get_data = $conn->prepare("SELECT * FROM brands WHERE brand_id = ?");
    $get_data->bind_param("i", $edit_id);
    $get_data->execute();
    $result_query = $get_data->get_result();
    $row = $result_query->fetch_assoc();
    $brands_id = $row["brand_id"];
    $brands_title = $row["brand_title"];

    $get_data->close();
}

if (isset($_POST["update_brands"])){
    global $conn;
    $brands_title = $row["brand_title"];

    // Use the current values from the database if form fields are not set
    $brands_title = isset($_POST["brand_title"]) ? $_POST["brand_title"] : $brands_title;
    
    $update_query = $conn->prepare("UPDATE brands SET brand_title = ? WHERE brand_id = $brands_id"); // Change 'brands_id = 1' to match your condition
    $update_query->bind_param("s", $brands_title);

    if ($update_query->execute()) {
        echo '<script>alert("Brand updated successfully!")</script>';
    } else {
        echo "<script>alert('Error updating brands: " . $conn->error . "');</script>";
    }

    // Closing prepared statement
    $update_query->close();
}
?>


<form action="" method="post" class="">
    <div class="box">
        <span class="icon" id="icon">
            <i class="fa-solid fa-receipt"></i>
        </span>
        <input type="text" class="field" name="brand_title" placeholder="Insert categories" aria-label="Username" value="<?php echo htmlspecialchars($brands_title); ?>">
    </div>

    <div class="">
        <button class="btn" name="update_brands" style="margin-top: 1rem;">Submit</button>
    </div>
</form>
