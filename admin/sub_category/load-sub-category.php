<?php 
    include "C:/xampp/htdocs/ecommerce-site/admin/php_files/config.php";

    $limit = 10;
    $page = "";
    if(isset($_POST['page'])){
        $page = $_POST['page'];
    }
    else{
        $page = 1;
    }
    $offset = ($page - 1) * $limit;
    $sub_category_sql = "SELECT * FROM sub_categories AS sub
                        LEFT JOIN categories AS cat ON sub.cat_parent = cat.cat_id
                        ORDER BY sub.sub_cat_id DESC LIMIT {$offset}, {$limit}";
    $result = mysqli_query($conn, $sub_category_sql);
    $output = "";
    if (mysqli_num_rows($result) > 0){
        $output .= '<table class="table table-striped table-hover table-bordered">
                        <thead>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Show in Header</th>
                        <th>Show in Footer</th>
                        <th>Action</th>
                        </thead>
                        <tbody>';
                    foreach($result as $row){
                        $output .= '<tr>
                                        <td>'.$row["sub_cat_title"].'</td>
                                        <td>'.$row["cat_title"].'</td>
                                        <td>';
                                        if($row['show_in_header'] == '1'){
                                            $output .= '<input type="checkbox" class="toggle-checkbox showCat_Header" data-id="'.$row["sub_cat_id"].'" checked />';
                                        }
                                        else{
                                            $output .= '<input type="checkbox" class="toggle-checkbox showCat_Header" data-id="'.$row["sub_cat_id"].'" />';
                                        }
                                            
                            $output .= '</td>
                                        <td>';
                                        if($row['show_in_footer'] == '1'){
                                            $output .= '<input type="checkbox" class="toggle-checkbox showCat_Footer" data-id="'.$row["sub_cat_id"].'" checked />';
                                        }
                                        else{
                                            $output .= '<input type="checkbox" class="toggle-checkbox showCat_Footer" data-id="'.$row["sub_cat_id"].'" />';
                                        }
                                            
                            $output .= '</td>
                                        <td>
                                            <a href="edit_sub_category.php?id='.$row["sub_cat_id"].'"><i class="fa fa-edit"></i></a>
                                            <a class="delete_sub_category" href="" data-id="'.$row["sub_cat_id"].'"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>';
                    }
        $output .= '</tbody>
        </table>';

        $sql_total = "SELECT * FROM sub_categories";
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