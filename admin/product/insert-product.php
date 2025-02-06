<?php 
    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";

    if(!isset($_FILES['featured_img']['name']) || empty($_FILES['featured_img']['name'])){
        echo "Image Field is Empty";
    }
    else{

        $errors = array();
        
        $file_name = $_FILES['featured_img']['name'];
        $file_tmp_name = $_FILES['featured_img']['tmp_name'];
        $file_type = $_FILES['featured_img']['type'];
        $file_size = $_FILES['featured_img']['size'];
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
        }
        else{
            if(isset($_POST['product_brand']) && !empty($_POST['product_brand'])){
                $product_brand = $_POST['brand'];
            }else{
                $product_brand = '0';
            }
            $title = mysqli_real_escape_string($conn, $_POST['product_title']);
            $category = mysqli_real_escape_string($conn, $_POST['product_cat']);
            $code = mysqli_real_escape_string($conn, uniqid());
            $brand = mysqli_real_escape_string($conn, $product_brand);
            $sub_cat = mysqli_real_escape_string($conn, $_POST['product_sub_cat']);
            $description = mysqli_real_escape_string($conn, $_POST['product_desc']);
            $price = mysqli_real_escape_string($conn, $_POST['product_price']);
            $qty = mysqli_real_escape_string($conn, $_POST['product_qty']);
            $status = mysqli_real_escape_string($conn, $_POST['product_status']);
            $image = mysqli_real_escape_string($conn, $final_image);

            $sql = "SELECT product_title FROM products WHERE product_title = '{$title}'";
            $exist = mysqli_query($conn, $sql);
            if(mysqli_num_rows($exist) > 0){
                echo '<div class="alert alert-danger">Product Already Exist</div>';
            }
            else{
                $insert_sql = "INSERT INTO products(product_code, product_cat, product_sub_cat, product_brand, product_title, product_price, product_desc, featured_image, qty, product_status)
                                VALUES ('{$code}', {$category}, {$sub_cat}, {$brand}, '{$title}', '{$price}', '{$description}', '{$image}', {$qty}, {$status});";
                $update_sql = "UPDATE sub_categories SET cat_products = (SELECT COUNT(*) FROM products WHERE product_sub_cat = {$sub_cat}) WHERE sub_cat_id = {$sub_cat};";
                if(mysqli_multi_query($conn, $insert_sql.$update_sql)){
                    move_uploaded_file($file_tmp_name, $upload_path);
                    echo 'success';
                }
            }
        }
    }

?>