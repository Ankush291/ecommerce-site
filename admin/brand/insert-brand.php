<?php
    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";
    $title = mysqli_real_escape_string($conn, $_POST['brand']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $sql = "SELECT brand_title, brand_cat FROM brands WHERE brand_title = '{$title}' AND brand_cat = {$category}";
    $exist = mysqli_query($conn, $sql);
    if(mysqli_num_rows($exist) > 0){
        echo '<div class="alert alert-danger">Sub Category and Category Already exists.</div>';
    }else{
        $insert_sql = "INSERT INTO brands (brand_title, brand_cat) VALUES ('{$title}', {$category})";
        $response = mysqli_query($conn, $insert_sql);

        if($response){
            echo '<div class="alert alert-success">Brand Added Successfully.</div>';
        }
        else{
            echo '<div class="alert alert-danger"><strong>Error </strong> Cannot Insert Data</div>';
        }
    }

?>