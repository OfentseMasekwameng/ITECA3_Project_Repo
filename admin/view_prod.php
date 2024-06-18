<?php
include('../coverFolder/connection.php');
?>

<?php
function view_product_table(){
    global $conn;
    $get_products = $conn->prepare("SELECT * FROM products");
    $get_products->execute();
    $result_query = $get_products->get_result();
    $num = 0;

    while ($row = $result_query->fetch_assoc()){
        $product_id = $row["product_id"];
        $product_title = $row["product_title"];
        $product_image1 = $row["product_image1"];
        $product_price = $row["product_price"];
        $product_status = $row["status"];
        $products_sold = get_product_sold($product_id); // Get the number of products sold
        $num++;

        echo '
            <tr>
                <td></td>
                <td>' . htmlspecialchars($product_id) . '</td>
                <td>' . htmlspecialchars($product_title) . '</td>
                <td><img src="../imgs/Feat_products/'.$product_image1.'" alt="' . htmlspecialchars($product_title) . '" class="product-image"></td>
                <td>' . htmlspecialchars($product_price) . '</td>
                <td>' . htmlspecialchars($products_sold). '</td>
                <td>' . htmlspecialchars($product_status) . '</td>                
                <td><a href="admin.php?edit_products='.htmlspecialchars($product_id).'"><i class="fa-solid fa-pen-to-square"></i></a></td>
                <td><a href="admin.php?delete_products='.htmlspecialchars($product_id).'" type="button" data-toggle="modal" data-target="#exampleModal"><i class="fa-solid fa-trash"></i></a></td>
            </tr>';
    }
    $get_products->close();
}

function get_product_sold($product_id){
    global $conn;
    $get_count = $conn->prepare("SELECT SUM(quantity) as total_sold FROM orders_pending WHERE product_id = ?");
    $get_count->bind_param("i", $product_id);
    $get_count->execute();
    $result_query = $get_count->get_result();
    $row = $result_query->fetch_assoc();
    $total_sold = $row['total_sold'] ? $row['total_sold'] : 0; // Default to 0 if no sales
    
    $get_count->close();
    return $total_sold;
}    
?>

<section class="container table_section">
    <div class="page_title">
        <p class="title">All Products</p>
    </div>

    <table class="text-center">
        <thead>
            <tr>
                <th></th>
                <th>Product ID</th>
                <th>Product Title</th>
                <th>Product Image</th>
                <th>Product Price</th>
                <th>Total Sold</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
                view_product_table();
            ?>
        </tbody>
    </table>
</section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <h4>Are sure you want to delete the data of this product?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal">No</button>
        <button type="button" class="btn"><a href="admin.php?delete_products" class="text-decoration-none">Yes</a></button>
      </div>
    </div>
  </div>
</div>