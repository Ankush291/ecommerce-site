<?php 
    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";
    $order_id = mysqli_real_escape_string($conn, $_POST['complete']);
    $sql = "SELECT delivery FROM order_products WHERE order_id = {$order_id}";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        if($row['delivery'] == 0){
            $change_sql = "UPDATE order_products SET delivery = 1 WHERE order_id = {$order_id}";
            if(mysqli_query($conn, $change_sql)){
                echo "Success";
            }
        }
    }
?>