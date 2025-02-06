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
    $brand_sql = "SELECT * FROM brands AS bn
                LEFT JOIN categories AS cat ON bn.brand_cat = cat.cat_id
                ORDER BY bn.brand_id DESC LIMIT {$offset}, {$limit}";
    $result = mysqli_query($conn, $brand_sql);
    $output = "";
    if (mysqli_num_rows($result) > 0){
        $output .= '<table class="table table-striped table-hover table-bordered">
                        <thead>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Action</th>
                        </thead>
                        <tbody>';
                    foreach($result as $row){
                        $output .= '<tr>
                                        <td>'.$row["brand_title"].'</td>
                                        <td>'.$row["cat_title"].'</td>
                                        <td>
                                            <a href="edit_brand.php?id='.$row["brand_id"].'"><i class="fa fa-edit"></i></a>
                                            <a class="delete_brand" href="" data-id="'.$row["brand_id"].'"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>';
                    }
            $output .= '</tbody>
            </table>';

        $sql_total = "SELECT * FROM brands";
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