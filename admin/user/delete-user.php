<?php 
    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";

    $user_id = $_POST['id'];

    $delete_sql = "DELETE FROM user WHERE user_id = {$user_id}";
    if(mysqli_query($conn, $delete_sql)){
        echo 1;
    } else {
        echo 0;
    }
?>