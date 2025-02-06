<?php 
    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";

    if(!empty($_POST['old_logo']) && empty($_FILES['new_logo']['name'])){
        $final_logo = $_POST['old_logo'];
    }
    elseif(!empty($_POST['old_logo']) && !empty($_FILES['new_logo']['name'])){

        $errors = array();
        
        $file_name = $_FILES['new_logo']['name'];
        $file_tmp_name = $_FILES['new_logo']['tmp_name'];
        $file_type = $_FILES['new_logo']['type'];
        $file_size = $_FILES['new_logo']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $upload_path = "../images/";
        $file_name = str_replace(array(' ', ','), '', $file_name);
        $valid_ext = array("jpg", "jpeg", "png");

        $final_logo = time().strtolower($file_name);

        if(in_array($file_ext, $valid_ext)){
            if($file_size > 2097152){
                $errors[] = '<div class="alert alert-danger">File Size is too Big. It should be less than 2 MB.</div>';
            }else{
                $upload_path = $upload_path.$final_logo;
            }
        }
        else{
            $errors[] = '<div class="alert alert-danger">Invalid Extension. (Valid Extensions: .jpg, .jpeg, .png)</div>';
        }
    
        if(!empty($errors)){
            echo $errors[0];
            die();
        }
        // else{
        //     if(file_exists("./images/".$_POST['old_image'])){
        //         unlink("./images/".$_POST['old_image']);
        //     }
        // }
    }

    $s_no = mysqli_real_escape_string($conn, $_POST['s_no']);
    $site_name = mysqli_real_escape_string($conn, $_POST['site_name']);
    $site_title = mysqli_real_escape_string($conn, $_POST['site_title']);
    $site_desc = mysqli_real_escape_string($conn, $_POST['site_desc']);
    $contact_email = mysqli_real_escape_string($conn, $_POST['contact_email']);
    $contact_phone = mysqli_real_escape_string($conn, $_POST['contact_phone']);
    $logo = mysqli_real_escape_string($conn, $final_logo);
    $footer_text = mysqli_real_escape_string($conn, $_POST['footer_text']);
    $currency_format = mysqli_real_escape_string($conn, $_POST['currency_format']);
    $contact_address = mysqli_real_escape_string($conn, $_POST['contact_address']);

    $update_sql = "UPDATE options SET site_name = '{$site_name}', site_title = '{$site_title}', site_logo = '{$logo}', site_desc ='     {$site_desc}', footer_text = '{$footer_text}', currency_format = '{$currency_format}', contact_phone = '{$contact_phone}', contact_email = '{$contact_email}', contact_address = '{$contact_address}' WHERE s_no = {$s_no}";

    if(mysqli_query($conn, $update_sql)){
        if(!empty($_FILES['new_logo']['name'])){
            move_uploaded_file($file_tmp_name, $upload_path);
        }
        echo "success";
    }

?>