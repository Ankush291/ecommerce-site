<?php 
    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";
    $user_id = $_POST["user_id"];
    $user_role = $_POST["user_role"];

    if($user_role == 1){
        $role_sql = "UPDATE user SET user_role = 0 WHERE user_id = {$user_id}";
        if(mysqli_query($conn, $role_sql)){
            echo 1;
        }
        else{
            echo 0;
        }
    }
    else{
        $role_sql = "UPDATE user SET user_role = 1 WHERE user_id = {$user_id}";
        if(mysqli_query($conn, $role_sql)){
            echo 1;
        }
        else{
            echo 0;
        }
    }
?>