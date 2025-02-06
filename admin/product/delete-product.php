<?php 
    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";
    $id = $_POST['delete_id'];
    $p_subcat = $_POST['p_subcat'];

    $delete_sql = "DELETE FROM products WHERE product_id = {$id};";
    $sub_update_sql = "UPDATE sub_categories SET cat_products = (SELECT COUNT(*) FROM products WHERE product_sub_cat = {$p_subcat})
                        WHERE sub_cat_id = {$p_subcat};";
    if(mysqli_multi_query($conn, $delete_sql.$sub_update_sql)){
        echo 1;
    }
    else{
        echo 0;
    }

?>