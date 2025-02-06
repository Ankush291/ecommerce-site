<?php 
    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";

    $limit = 5;
    $page = "";
    if(isset($_POST['page'])){
        $page = $_POST['page'];
    }
    else{
        $page = 1;
    }
    $offset = ($page - 1) * $limit;
    $sub_category_sql = "SELECT * FROM user 
                        ORDER BY user_id DESC LIMIT {$offset}, {$limit}";
    $result = mysqli_query($conn, $sub_category_sql);
    $output = "";
    if (mysqli_num_rows($result) > 0){
        $output .= '<table class="table table-striped table-hover table-bordered">
                        <thead>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>City</th>
                            <th>Action</th>
                        </thead>
                        <tbody>';
                    foreach($result as $row){
                        $output .= '<tr>
                                        <td>'.$row['f_name'].' '.$row['l_name'].'</td>
                                        <td>'.$row["email"].'</td>
                                        <td>'.$row['mobile'].'</td>
                                        <td>'.$row['city'].'</td>
                                        <td>
                                            <a href="" class="btn btn-xs btn-primary user-view" data-id="'.$row['user_id'].'" data-toggle="modal" data-target="#user-detail"><i class="fa fa-eye"></i></a>';
                                            if($row['user_role'] == '1'){
                                                $output .= '<a href="" class="btn btn-xs btn-primary user-status" data-id="'.$row['user_id'].'" data-status="'.$row['user_role'] .'">Block</a>';
                                            }
                                            else{
                                                $output .= '<a href="" class="btn btn-xs btn-primary user-status" data-id="'.$row['user_id'].'" data-status="'.$row['user_role'] .'">Unblock</a>';
                                            }
                                            
                            $output .= '    <a class="btn btn-xs btn-danger delete_user" href="" data-id="'.$row["user_id"].'"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>';
                    }
            $output .= '</tbody>
            </table>';

        $sql_total = "SELECT * FROM user";
        $records = mysqli_query($conn, $sql_total) or die("Query Failed");
        $total_record = mysqli_num_rows($records);
        $total_page = ceil($total_record / $limit);
        
        $output .= '<div class="pagination-outer">
                    <ul id="pagination" class="pagination justify-content-center">';
                        if($page != 1){
                            $output .= '<li class="page-item page-no"><a id="'. $page - 1 .'" class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
                        }
                        for($i=1; $i <= $total_page; $i++){
                            if($i == $page){
                                $active = "active";
                            }
                            else{
                                $active = "";
                            }
                            $output .= '<li class="page-item page-no '.$active.'"><a id="'.$i.'" class="page-link" href="#">'.$i.'</a></li>';
                        }
                        if($page != $total_page){
                            $output .= '<li class="page-item page-no"><a id="'. $page + 1 .'" class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
                        }
                    $output .= '</ul>
                    </div>';
    }
    else{
        $output .= '<div class="alert alert-danger">No data found.</div>';
    }

    echo $output;
?>