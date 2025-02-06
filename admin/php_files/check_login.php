<?php

if(isset($_POST['login'])){
   
    if(!isset($_POST['name']) || empty($_POST['name'])){
        echo json_encode(array('error'=>'name_empty')); exit;
    }elseif(!isset($_POST['pass']) || empty($_POST['pass'])){
        echo json_encode(array('error'=>'pass_empty')); exit;
    }else{
        
        include "C:/xampp/htdocs/ecommerce-site/admin/config.php";
        $username = mysqli_real_escape_string($conn, $_POST["name"]);
        $password = mysqli_real_escape_string($conn, md5($_POST["pass"]));

        $admin_sql = "SELECT * FROM admin WHERE username = '{$username}' AND password = '{$password}'";
        $result = mysqli_query($conn, $admin_sql);

        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            /* Start the session */
            session_start();
            /* Set session variables */
            $_SESSION["admin_id"] = $row['admin_id'];
            $_SESSION["admin_name"] = $row['admin_name'];
            $_SESSION["admin_role"] = 'admin'; /* for admin */
            echo 1;
        }else{
            echo 0;
        }
    }
}


if(isset($_POST['changePass'])){
    session_start();
    include "C:/xampp/htdocs/ecommerce-site/admin/config.php";
    $old_pass = mysqli_real_escape_string($conn, md5($_POST['old_pass']));
    $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
    $id = $_SESSION['admin_id'];

    $sql = "SELECT * FROM admin WHERE admin_id = {$id}";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if($row['password'] == $old_pass){
        $change_pass_sql = "UPDATE admin SET password = '{$new_pass}' WHERE admin_id = {$id}";
        if(mysqli_query($conn, $change_pass_sql)){
            echo "success";
        }
        else{
            echo "<div class='alert alert-danger'>Query Error</div>";
        }
    }
    else{
        echo "<div class='alert alert-danger'>Password did not match</div>";
    }
}



?>
