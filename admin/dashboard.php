<?php
// include header file
include 'header.php'; ?>
    <div class="admin-content-container">
        <h2 class="admin-heading">Dashboard</h2>
        <div class="row">
            <div class="col-md-12">
                <?php
                    include "config.php";
                    $sql = "SELECT product_id FROM products WHERE qty < 1";
                    $qty = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($qty)){  ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="active"><td colspan="2">OUT OF Stock</td></tr>
                            </thead>
                            <tbody>
                                <?php foreach($qty as $q){ ?>
                                    <tr>
                                    <td>Product Code</td>
                                    <td><?php echo 'PDR00'.$q['product_id']; ?></td>
                                </tr>
                        <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
            </div>
            <div class="col-md-4">
                <?php
                    $prod_count_sql = "SELECT COUNT(product_id) AS p_count FROM products";
                    $products = mysqli_query($conn, $prod_count_sql);
                    $prod = mysqli_fetch_assoc($products);
                ?>
                <div class="detail-box">
                    <span class="count"><?php echo $prod['p_count']; ?></span>
                    <span class="count-tag">Products</span>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $cat_count_sql = "SELECT COUNT(cat_id) AS c_count FROM categories";
                    $category = mysqli_query($conn, $cat_count_sql);
                    $cat = mysqli_fetch_assoc($category);
                ?>
                <div class="detail-box">
                    <span class="count"><?php echo $cat['c_count']; ?></span>
                    <span class="count-tag">Categories</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="detail-box">
                    <?php
                        $sub_cat_count_sql = "SELECT COUNT(sub_cat_id) AS sub_count FROM sub_categories";
                        $sub_category = mysqli_query($conn, $sub_cat_count_sql);
                        $sub_cat = mysqli_fetch_assoc($sub_category);
                    ?>
                    <span class="count"><?php echo $sub_cat['sub_count']; ?></span>
                    <span class="count-tag">Sub Categories</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="detail-box">
                    <?php
                        $brand_count_sql = "SELECT COUNT(brand_id) AS b_count FROM brands";
                        $brands = mysqli_query($conn, $brand_count_sql);
                        $brand = mysqli_fetch_assoc($brands);
                    ?>
                    <span class="count"><?php echo $brand['b_count']; ?></span>
                    <span class="count-tag">Brands</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="detail-box">
                    <?php
                        $order_count_sql = "SELECT COUNT(order_id) AS o_count FROM order_products";
                        $orders = mysqli_query($conn, $order_count_sql);
                        $order = mysqli_fetch_assoc($orders);
                    ?>
                    <span class="count"><?php echo $order['o_count']; ?></span>
                    <span class="count-tag">Orders</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="detail-box">
                    <?php
                        $user_count_sql = "SELECT COUNT(user_id) AS u_count FROM user";
                        $users = mysqli_query($conn, $user_count_sql);
                        $user = mysqli_fetch_assoc($users);
                    ?>
                    <span class="count"><?php echo $user['u_count']; ?></span>
                    <span class="count-tag">Users</span>
                </div>
            </div>
        </div>
    </div>
<?php
//    include footer file
    include "footer.php";

?>
