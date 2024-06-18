<?php
include ("../coverFolder/connection.php");

// Set error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET["edit_category"])) {
    $edit_id = $_GET["edit_category"];

    $get_data = $conn->prepare("SELECT * FROM categories WHERE category_id = ?");
    $get_data->bind_param("i", $edit_id);
    $get_data->execute();
    $result_query = $get_data->get_result();
    $row = $result_query->fetch_assoc();
    $category_id = $row["category_id"];
    $category_title = $row["category_title"];

    $get_data->close();
}

if (isset($_POST["update_category"])){
    global $conn;
    $get_category = $conn->prepare("SELECT * FROM categories");
    $get_category->execute();
    $result_query = $get_category->get_result();
    $row = $result_query->fetch_assoc();
    $category_id = $row["category_id"];
    $category_title = $row["category_title"];

    // Use the current values from the database if form fields are not set
    $category_title = isset($_POST["category_title"]) ? $_POST["category_title"] : $category_title;
    
    $update_query = $conn->prepare("UPDATE categories SET category_title = ? WHERE category_id = $category_id"); // Change 'category_id = 1' to match your condition
    $update_query->bind_param("s", $category_title);

    if ($update_query->execute()) {
        echo '<script>alert("Category updated successfully!")</script>';
    } else {
        echo "<script>alert('Error updating category: " . $conn->error . "');</script>";
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
        <input type="text" class="field" name="category_title" placeholder="Insert categories" aria-label="Username" value="<?php echo htmlspecialchars($category_title); ?>">
    </div>

    <div class="">
        <button class="btn" name="update_category" style="margin-top: 1rem;">Submit</button>
    </div>
</form>
