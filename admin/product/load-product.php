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
    $product_sql = "SELECT * FROM products AS pro
                        LEFT JOIN sub_categories AS sub ON pro.product_sub_cat = sub.sub_cat_id
                        LEFT JOIN brands AS br ON pro.product_brand = br.brand_id
                        ORDER BY pro.product_id DESC LIMIT {$offset}, {$limit}";
    $result = mysqli_query($conn, $product_sql);
    $output = "";
    if (mysqli_num_rows($result) > 0){
        $output .= '<table class="table table-striped table-hover table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th width="100px">Action</th>
                        <tbody>';
                    foreach($result as $row){
                        $output .= '<tr>
                                        <td>'.'PDR00'.$row['product_id'].'</td>
                                        <td>'.$row['product_title'].'</td>
                                        <td>'.$row['sub_cat_title'].'</td>
                                        <td>'.$row['brand_title'].'</td>
                                        <td>'."Rs.".$row['product_price'].'</td>
                                        <td>'.$row['qty'].'</td>
                                        <td>';
                                        if($row['featured_image'] != ''){
                                            $output .= '<img src="../product-images/'. $row["featured_image"] .'" alt="'. $row["featured_image"] .'" width="50px"/>';
                                        }
                                        else{
                                            $output .= '<img src="images/index.png" alt="" width="50px"/>';
                                        }
                                            
                            $output .= '</td>
                                        <td>';
                                        if($row['product_status'] == '1'){
                                            $output .= '<span class="label label-success">Active</span>';
                                        }
                                        else{
                                            $output .= '<span class="label label-danger">Inactive</span>';
                                        }
                                            
                            $output .= '</td>
                                        <td>
                                            <a href="edit_product.php?id='.$row["product_id"].'"><i class="fa fa-edit"></i></a>
                                            <a class="delete_product" href="" data-id="'.$row["product_id"].'" data-subcat="'. $row['product_sub_cat'] .'"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>';
                    }
        $output .= '</tbody>
        </table>';

        $sql_total = "SELECT * FROM products";
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