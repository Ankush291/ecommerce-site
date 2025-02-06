<?php 

    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";

    if(!empty($_POST['old_image']) && empty($_FILES['new_image']['name'])){
        $final_image = $_POST['old_image'];
    }
    elseif(!empty($_POST['old_image']) && !empty($_FILES['new_image']['name'])){

        $errors = array();
        
        $file_name = $_FILES['new_image']['name'];
        $file_tmp_name = $_FILES['new_image']['tmp_name'];
        $file_type = $_FILES['new_image']['type'];
        $file_size = $_FILES['new_image']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $upload_path = "../../product-images/";
        $file_name = str_replace(array(' ', ','), '', $file_name);
        $valid_ext = array("jpg", "jpeg", "png");

        $final_image = time().strtolower($file_name);

        if(in_array($file_ext, $valid_ext)){
            if($file_size > 2097152){
                $errors[] = '<div class="alert alert-danger">File Size is too Big. It should be less than 2 MB.</div>';
            }else{
                $upload_path = $upload_path.$final_image;
            }
        }
        else{
            $errors[] = '<div class="alert alert-danger">Invalid Extension. (Valid Extensions: .jpg, .jpeg, .png)</div>';
        }
    
        if(!empty($errors)){
            echo $errors[0];
            die();
        }
        else{
            if(file_exists("../../product-images/".$_POST['old_image'])){
                unlink("../../product-images/".$_POST['old_image']);
            }
        }
    }

    if(isset($_POST['product_brand']) && !empty($_POST['product_brand'])){
        $product_brand = $_POST['brand'];
    }else{
        $product_brand = '0';
    }
    $id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $title = mysqli_real_escape_string($conn, $_POST['product_title']);
    $category = mysqli_real_escape_string($conn, $_POST['product_cat']);
    $brand = mysqli_real_escape_string($conn, $product_brand);
    $sub_cat = mysqli_real_escape_string($conn, $_POST['product_sub_cat']);
    $description = mysqli_real_escape_string($conn, $_POST['product_desc']);
    $price = mysqli_real_escape_string($conn, $_POST['product_price']);
    $qty = mysqli_real_escape_string($conn, $_POST['product_qty']);
    $status = mysqli_real_escape_string($conn, $_POST['product_status']);
    $image = mysqli_real_escape_string($conn, $final_image);

    
    $prod_update_sql = "UPDATE products SET product_cat = {$category}, product_sub_cat = {$sub_cat}, product_brand = {$brand}, product_title = '{$title}', product_price = '{$price}', product_desc = '{$description}', featured_image = '{$image}', qty = {$qty}, product_status = {$status}
                        WHERE product_id = {$id};";
    $sub_update_sql = "UPDATE sub_categories SET cat_products = (SELECT COUNT(*) FROM products WHERE product_sub_cat = {$sub_cat}) WHERE sub_cat_id = {$sub_cat};";
    if(mysqli_multi_query($conn, $prod_update_sql.$sub_update_sql)){
        if(!empty($_FILES['new_image']['name'])){
            move_uploaded_file($file_tmp_name, $upload_path);
        }
        echo 'success';
    }

?>