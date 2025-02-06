<?php 
    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";
    $id = $_POST['delete_id'];

    $delete_sql = "DELETE FROM categories WHERE cat_id = {$id}";
    // $response = mysqli_query($conn, $delete_sql);
    if(mysqli_query($conn, $delete_sql)){
        echo 1;
    }
    else{
        echo 0;
    }

?>