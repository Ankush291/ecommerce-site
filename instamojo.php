<?php 
include 'config.php';

session_start();
$user = $_SESSION['username'];


$product_id = $_POST['product_id'];
$product_total = $_POST['product_total'];
$product_qty = $_POST['product_qty'];
$product_user = $_SESSION['user_id'];
$order_date = date('Y-m-d');
$order_insert_sql = "INSERT INTO order_products (product_id, product_qty, total_amount, product_user, order_date)
                    VALUES('{$product_id}', '{$product_qty}', '{$product_total}', '{$product_user}', '{$order_date}')";

if(mysqli_query($conn, $order_insert_sql)){
    header("location:user_orders.php");
}


?>