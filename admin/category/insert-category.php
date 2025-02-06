<?php
    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";
    $category = mysqli_real_escape_string($conn, $_POST['cat']);
    $sql = "SELECT cat_title FROM categories WHERE cat_title = '{$category}'";
    $exist = mysqli_query($conn, $sql);
    if(mysqli_num_rows($exist) > 0){
        echo '<div class="alert alert-danger">Category Already exists.</div>';
    }else{
        $insert_sql = "INSERT INTO categories (cat_title) VALUES ('{$category}')";
        $response = mysqli_query($conn, $insert_sql);

        if($response){
            echo '<div class="alert alert-success">Category Added Successfully.</div>';
        }
        else{
            echo '<div class="alert alert-danger"><strong>Error </strong> Cannot Insert Data</div>';
        }
    }

?>