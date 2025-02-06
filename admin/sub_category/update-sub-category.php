<?php
    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";

    $sub_cat_id = $_POST['sub_cat_id'];
    $sub_cat_title = $_POST['title'];
    $cat_parent = $_POST['category'];

    $update_sql = "UPDATE sub_categories SET sub_cat_title = '{$sub_cat_title}', cat_parent = {$cat_parent} WHERE sub_cat_id = {$sub_cat_id}";
    if(mysqli_query($conn, $update_sql)){
        echo 1;
    }
    else{
        echo 0;
    }
?>