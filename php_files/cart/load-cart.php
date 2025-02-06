<?php 
    include "C:/xampp/htdocs/ecommerce-site/config.php";
    session_start();
    if(!isset($_SESSION["user_id"])){
        echo '<div class="empty-result">
                Your cart is currently empty.
            </div>';
        exit;
    }
    $cur_format = 'Rs. ';
    $cart_sql = "SELECT * FROM product_cart pc
                LEFT JOIN products AS p
                ON pc.p_id = p.product_id
                LEFT JOIN user AS u
                ON pc.user_id = u.user_id
                WHERE pc.user_id = {$_SESSION["user_id"]}
                ORDER BY pc.s_no DESC";
    $result = mysqli_query($conn, $cart_sql);
    $output = "";
    if (mysqli_num_rows($result) > 0){
        $output .= '<table class="table table-bordered">
                        <thead>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th width="120px">Product Price</th>
                        <th width="100px">Qty.</th>
                        <th width="100px">Sub Total</th>
                        <th>Action</th>
                        </thead>
                        <tbody>';
                    foreach($result as $row){
                        $output .= '<tr class="item-row">
                                        <td><a href="single_product.php?pid='. $row['product_id'] .'"><img src="product-images/'.$row['featured_image'].'" alt="" width="70px" /></a></td>
                                        <td><a href="single_product.php?pid='. $row['product_id'] .'">'. $row['product_title'].'</td></a>
                                        <td>'. $cur_format.' <span class="product-price">'. $row['product_price'].'</span></td>
                                        <td>
                                            <input class="form-control item-qty" type="number" value="1"/>
                                            <input type="hidden" class="item-id" value="'. $row['product_id'].'"/>
                                            <input type="hidden" class="item-price" value="'. $row['product_price'].'"/>
                                        </td>
                                        <td>'. $cur_format.' <span class="sub-total">'. $row['product_price'].'</span></td>
                                        <td>
                                            <a class="btn btn-sm btn-primary remove-cart-item" href="" data-id="'. $row['product_id'].'"><i class="fa fa-remove"></i></a>
                                        </td>
                                    </tr>';
                    }
        $output .= '<tr>
                        <td colspan="5" align="right"><b>TOTAL AMOUNT ('. $cur_format.')</b></td>
                        <td class="total-amount"></td>
                    </tr>
                    </tbody>
                </table>
                <a class="btn btn-sm btn-primary" href="'.$hostname.'" >Continue Shopping</a>';
                if(isset($_SESSION['user_role'])){
                    $output .= '<form action="instamojo.php" class="checkout-form pull-right" method="POST">';
                    $product_id = '';
                    foreach($result as $row){
                        $product_id .= $row['product_id'].',';
                    }
                    $output .= '<input type="hidden" name="product_id" value="'. $product_id .'">
                                <input type="hidden" name="product_total" class="total-price" value="">
                                <input type="hidden" name="product_qty" class="total-qty" value="1">
                                <input type="submit" class="btn btn-md btn-success" value="Proceed to Checkout">
                            </form>';
                }
                else{
                    $output .= '<a class="btn btn-sm btn-success pull-right" href="#" data-toggle="modal" data-target="#userLogin_form" >Proceed to Checkout</a>';
                }

        
    }
    else{
        $output .= '<div class="empty-result">
                        Your cart is currently empty.
                    </div>';
    }

    echo $output;

?>