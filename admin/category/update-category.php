<?php
    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";

    $cat_id = $_POST['cat_id'];
    $cat_title = $_POST['cat'];

    $update_sql = "UPDATE categories SET cat_title = '{$cat_title}' WHERE cat_id = {$cat_id}";
    if(mysqli_query($conn, $update_sql)){
        echo 1;
    }
    else{
        echo 0;
    }
?>