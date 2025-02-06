<?php
    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";

    if(isset($_POST['p_cat'])){
        $cat_id = $_POST['p_cat'];

        $brand_sql = "SELECT * FROM brands WHERE brand_cat = {$cat_id}";
        $brands = mysqli_query($conn, $brand_sql);
        $output = "";

        if(mysqli_num_rows($brands) > 0){
            foreach($brands as $brand){
                $output .= '<option value="'.$brand["brand_id"].'">'.$brand["brand_title"].'</option>';
            }
            
        }
        else{
            $output .= '<option value="" selected disabled> No brand found </option>';
        }
        echo $output;
    }

?>