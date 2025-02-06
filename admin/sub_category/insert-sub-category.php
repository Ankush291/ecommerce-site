<?php 
    // include "./admin/php_files/config.php";
    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $sql = "SELECT sub_cat_title, cat_parent FROM sub_categories WHERE sub_cat_title = '{$title}' AND cat_parent = {$category}";
    $exist = mysqli_query($conn, $sql);
    if(mysqli_num_rows($exist) > 0){
        echo '<div class="alert alert-danger">Sub Category and Category Already exists.</div>';
    }else{
        $insert_sql = "INSERT INTO sub_categories (sub_cat_title, cat_parent) VALUES ('{$title}', {$category})";
        $response = mysqli_query($conn, $insert_sql);

        if($response){
            echo '<div class="alert alert-success">Sub Category Added Successfully.</div>';
        }
        else{
            echo '<div class="alert alert-danger"><strong>Error </strong> Cannot Insert Data</div>';
        }
    }
?>