<?php
    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";

    if(isset($_POST['p_cat'])){
        $cat_id = $_POST['p_cat'];

        $sub_cat_sql = "SELECT * FROM sub_categories WHERE cat_parent = {$cat_id}";
        $sub_categories = mysqli_query($conn, $sub_cat_sql);
        $output = "";

        if(mysqli_num_rows($sub_categories) > 0){
            foreach($sub_categories as $sub_cat){
                $output .= '<option value="'.$sub_cat["sub_cat_id"].'">'.$sub_cat["sub_cat_title"].'</option>';
            }
            
        }
        else{
            $output .= '<option value="" selected disabled> No sub category found </option>';
        }
        echo $output;
    }

?>