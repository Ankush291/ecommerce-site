<?php 
    include "C:/xampp/htdocs/ecommerce-site/config.php";

    session_start();
    if(isset($_SESSION["user_id"])){
        $user_id = $_SESSION["user_id"];
        $p_id = $_POST["addCart"];

        $sql = "SELECT * FROM product_cart WHERE user_id = {$user_id} AND p_id = {$p_id}";
        $exist = mysqli_query($conn, $sql);
        if(mysqli_num_rows($exist) > 0){
            echo "Already added";
        }
        else{
            $insert_sql = "INSERT INTO product_cart(p_id, user_id) VALUES ($p_id, $user_id)";
            if(mysqli_query($conn, $insert_sql)){
                echo "success";
            }
        }
    }
    else{
        echo "login_first";
    }


?>