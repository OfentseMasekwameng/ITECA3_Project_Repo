<?php
include('../coverFolder/connection.php');   

function view_categories_table(){
    global $conn;
    $get_products = $conn->prepare("SELECT * FROM categories");
    $get_products->execute();
    $result_query = $get_products->get_result();
    $num = 0;

    while ($row = $result_query->fetch_assoc()){
        $category_id = $row["category_id"];
        $category_title = $row["category_title"];
        $num++;

        echo '
            <tr>
                <td>' . htmlspecialchars($category_id) . '</td>
                <td>' . htmlspecialchars($category_title) . '</td>
                <td><a href="admin.php?edit_category='.htmlspecialchars($category_id).'"><i class="fa-solid fa-pen-to-square"></i></a></td>
                <td><a href="admin.php?delete_category='.htmlspecialchars($category_id).'" type="button" data-toggle="modal" data-target="#exampleModal"><i class="fa-solid fa-trash"></i></a></td>
            </tr>';
    }
    $get_products->close();
}
?>

<section class="container table_section">
    <div class="page_title">
        <p class="title">All Prodcut Categories</p>
    </div>

    <table class="text-center">
        <thead>
            <tr>
                <th>Category Id</th>
                <th>Category Title</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php view_categories_table();?>
        </tbody>
    </table>
</section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <h4>Are sure you want to delete the data of this category?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary"><a href="admin.php?delete_category" class="text-decoration-none">Yes</a></button>
      </div>
    </div>
  </div>
</div>