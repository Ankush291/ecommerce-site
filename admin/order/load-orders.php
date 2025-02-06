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
    $product_sql = "SELECT order_products.product_id,order_products.order_id,order_products.total_amount,order_products.product_qty,order_products.delivery,order_products.product_user,order_products.order_date,products.featured_image,user.f_name,user.address,user.city,payments.payment_status FROM order_products 
                    LEFT JOIN products ON FIND_IN_SET(products.product_id,order_products.product_id) > 0
                    LEFT JOIN user ON order_products.product_user=user.user_id 
                    LEFT JOIN payments ON payments.txn_id = order_products.pay_req_id 
                    GROUP BY order_products.order_id 
                    ORDER BY order_products.order_id DESC LIMIT {$offset}, {$limit}";
    $result = mysqli_query($conn, $product_sql);
    $output = "";
    if(mysqli_num_rows($result) > 0){
        $output .= '<table class="table table-striped table-hover table-bordered">
                            <thead>
                            <th>ORDER No.</th>
                            <th width="300px">Product Details</th>
                            <th>QTY.</th>
                            <th>Total Amount</th>
                            <th>Customer Details</th>
                            <th>Order Date</th>
                            <th>Payment Status</th>
                            <th>Delivery Status</th>
                            </thead>
                            <tbody>';
                        foreach($result as $row){
                            
                            $output .= "<tr>
                                <td> ODR00{$row['order_id']} </td>
                                <td>";
                                $product_code = array_filter(explode(',',$row['product_id']));
                                $product_qty = array_filter(explode(',',$row['product_qty']));
                                
                                    for($p=0;$p<count($product_code);$p++){
                                        $output .= "<b>Product Code: </b> PDR00{$product_code[$p]}
                                        <b>Quantity: </b>{$product_qty[$p]}
                                        <br>";
                                    }
                                
                                $prod_sum = array_sum($product_qty);
                                $output .= "</td>
                                <td>{$prod_sum}</td>
                                <td>Rs. {$row['total_amount']}</td>
                                <td>
                                    <b>Name : </b>{$row['f_name']}<br>
                                    <b>Address : </b>{$row['address']}<br>
                                    <b>City : </b>{$row['city']}<br>
                                </td>";
                                $date = date('d M, Y',strtotime($row['order_date']));
                                $output .= "<td>{$date}</td>
                                <td>";
                                    
                                if($row['payment_status'] == 'credit'){
                                    $output .= "<span class='label label-success'>Paid</span>";
                                }
                                $output .= "</td>
                                <td>";
                                    
                                if($row['delivery'] == '1'){ 
                                    $output .= "<span>Delivered</span>";
                                }else{ 
                                    $output .= "<a class='btn btn-sm btn-primary order_complete' href='' data-id='{$row['order_id']}'>complete</a>";
                                } 
                                $output .= "</td>
                            </tr>";
                            
                        }
            $output .= "</tbody>
                    </table>";

        $sql_total = "SELECT * FROM order_products";
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