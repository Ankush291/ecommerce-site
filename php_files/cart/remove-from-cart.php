<?php 
    include "C:/xampp/htdocs/ecommerce-site/config.php";

    session_start();
    if(isset($_SESSION["user_id"])){
        $user_id = $_SESSION["user_id"];
        $p_id = $_POST['removeCartItem'];
    
        $delete_sql = "DELETE FROM product_cart WHERE p_id = {$p_id} AND user_id = {$user_id}";
        if(mysqli_query($conn, $delete_sql)){
            echo "success";
        }
    }

?>