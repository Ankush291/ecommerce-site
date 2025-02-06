<?php 
    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";

    $brand_id = $_POST['brand_id'];
    $brand_title = $_POST['brand'];
    $cat_parent = $_POST['category'];

    $update_sql = "UPDATE brands SET brand_title = '{$brand_title}', brand_cat = {$cat_parent} WHERE brand_id = {$brand_id}";
    if(mysqli_query($conn, $update_sql)){
        echo 1;
    }
    else{
        echo 0;
    }

?>