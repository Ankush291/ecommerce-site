<?php
    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";

    $user_id = $_POST['user_view'];
    $view_sql = "SELECT * FROM user WHERE user_id = {$user_id}";
    $result = mysqli_query($conn, $view_sql);
    $output = "";

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $output .= '<table class="table table-bordered">
                        <h3>User Details</h3>
                        <tr>
                            <td>First Name</td>
                            <td>'.$row["f_name"].'</td>
                        </tr>
                        <tr>
                            <td>Last Name</td>
                            <td>'.$row["l_name"].'</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>'.$row["email"].'</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>'.$row["mobile"].'</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>'.$row["address"].'</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>'.$row["city"].'</td>
                        </tr>
                        <tr>
                            <td>User Status</td>
                            <td>';
                            if($row["user_role"] == '1'){
                                $output .= 'Activated';
                            }else{
                                $output .= 'Blocked';
                            }
                $output .= '</td>
                        </tr>
                    </table>';
    }
    else{
        $output .= '<div class="alert alert-danger">No data found.</div>';
    }

    echo $output;

?>