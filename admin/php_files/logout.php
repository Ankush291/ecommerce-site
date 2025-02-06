<?php
    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";
    /* Start the session */
    session_start();
    /* remove all session variables */
    session_unset(); 
    /* destroy the session */
    session_destroy();

mysqli_close($conn);
header("location:{$base_url}/admin/index.php");
?>