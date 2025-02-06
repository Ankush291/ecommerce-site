<?php
    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";

    if(isset($_POST['showInHeader'])){
        $status = $_POST['showInHeader'];
        $sub_cat_id = $_POST['sub_cat_id'];

        $sql = "UPDATE sub_categories SET show_in_header = {$status} WHERE sub_cat_id = {$sub_cat_id}";

        if(mysqli_query($conn, $sql)){
            echo 'true'; exit;
        }
    }

    if(isset($_POST['showInFooter'])){
        $status = $_POST['showInFooter'];
        $sub_cat_id = $_POST['sub_cat_id'];

        $sql = "UPDATE sub_categories SET show_in_footer = {$status} WHERE sub_cat_id = {$sub_cat_id}";

        if(mysqli_query($conn, $sql)){
            echo 'true'; exit;
        }
    }
?>