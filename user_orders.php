<?php
include 'config.php';
session_start();
if(isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'user') {

    include 'header.php'; ?>
    <div class="product-cart-container">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-head">My Orders</h2>
                    <?php
                        $user = $_SESSION['user_id'];
                        $sql = "SELECT o.*,
                                    p.product_id,
                                    GROUP_CONCAT(DISTINCT p.product_title ORDER BY p.product_id SEPARATOR '$$') AS product_titles,
                                    GROUP_CONCAT(DISTINCT p.featured_image ORDER BY p.product_id) AS product_images,
                                    GROUP_CONCAT(DISTINCT p.product_price ORDER BY p.product_id) AS product_prices,
                                    u.*
                                FROM order_products AS o
                                LEFT JOIN products AS p ON FIND_IN_SET(p.product_id, o.product_id) > 0
                                LEFT JOIN user AS u ON o.product_user = u.user_id
                                WHERE o.product_user = {$user} GROUP BY o.order_id ORDER BY o.order_id DESC";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0){ ?>
                            <?php foreach($result as $row){  
                                    
                                    
                                    ?>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="active">
                                        <th colspan="3"><h4><b>ORDER No. : <?php echo 'ODR00'.$row['order_id']; ?></b></h4></th>
                                        <th width="200px"><b>Order Placed : </b><?php echo date('d M, Y',strtotime($row['order_date'])); ?></th>
                                    </tr>
                                    <?php
                                    
                                    $product_titles = array_filter(explode('$$',$row['product_titles']));
                                    $product_prices = array_filter(explode(',',$row['product_prices']));
                                    $product_qty = array_filter(explode(',',$row['product_qty']));
                                    $product_images = array_filter(explode(',',$row['product_images']));
                                        for($p=0;$p<count($product_qty);$p++){
                                    ?>
                                    <tr>
                                        <td>
                                            <img class="img-thumbnail" src="product-images/<?php echo $product_images[$p]; ?>" alt="" width="100px" />
                                        </td>
                                        <td>
                                            <span><b>Product Name :</b> <?php echo $product_titles[$p]; ?></span><br/>
                                            <span><b>Product Price :</b> <?php echo $cur_format.' '.$product_prices[$p]; ?></span><br/>
                                            <span><b>Quantity :</b> <?php echo $product_qty[$p]; ?></span><br/>
                                        </td>
                                        <td>
                                        <?php if($row['delivery'] == '1'){
                                                $status = '<label class="label label-success">Delivered</label>';
                                            }
                                            else{
                                                $status = '<label class="label label-primary">In - Process</label>';
                                            } ?>
                                            <b>Status : </b><?php  echo $status; ?>
                                        </td>
                                        <td>
                                            <span><b>Delivery Expected By :</b> <?php echo date('d',strtotime($row['order_date']. ' +4 day')); ?> - <?php echo date('d F, Y',strtotime($row['order_date']. ' +7 day')); ?></span>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="3" align="right"><b>Total Amount</b></td>
                                        <td><b><?php echo $cur_format.' '.$row['total_amount']; ?></b></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php 
                                }?>
                        <?php    }else{ ?>
                                <div class="empty-result">
                        No Orders Found.
                    </div>
                        <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php include 'footer.php';

}else{
    header("Location: " . $hostname);
}
?>