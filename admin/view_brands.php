<?php
include('../coverFolder/connection.php');   

function view_brands_table(){
    global $conn;
    $get_products = $conn->prepare("SELECT * FROM brands");
    $get_products->execute();
    $result_query = $get_products->get_result();
    $num = 0;

    while ($row = $result_query->fetch_assoc()){
        $brand_id = $row["brand_id"];
        $brand_title = $row["brand_title"];
        $num++;

        echo '
            <tr>
                <td>' . htmlspecialchars($brand_id) . '</td>
                <td>' . htmlspecialchars($brand_title) . '</td>
                <td><a href="admin.php?edit_brand='.htmlspecialchars($brand_id).'"><i class="fa-solid fa-pen-to-square"></i></a></td>
                <td><a href="admin.php?delete_brand=-'.htmlspecialchars($brand_id).'" type="button" data-toggle="modal" data-target="#exampleModal"><i class="fa-solid fa-trash"></i></a></td>
            </tr>';
    }
    $get_products->close();
}
?>

<section class="container table_section">
    <div class="page_title">
        <p class="title">All Product Brands</p>
    </div>

    <table class="text-center">
        <thead>
            <tr>
                <th>brand Id</th>
                <th>brand Title</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php view_brands_table();?>
        </tbody>
    </table>
</section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <h4>Are sure you want to delete the data of this brand?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary"><a href="admin.php?delete_brand" class="text-decoration-none">Yes</a></button>
      </div>
    </div>
  </div>
</div>