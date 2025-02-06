<?php
include 'config.php';

$brand = mysqli_real_escape_string($conn, $_GET['brand']);

$title_sql = "SELECT brand_title FROM brands WHERE brand_id = {$brand}";
$result = mysqli_query($conn, $title_sql);
if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $title = $row['brand_title'].' : Buy '.$row['brand_title'].' Products at Best Price'; 
    $page_head = $row['brand_title'];

}else{ 
    $title = "Result Not Found";
    $page_head = "No Brand Found";
}
?>
<?php include 'header.php'; ?>
    <div class="product-section content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-head"><?php echo $page_head; ?> </h2>
                </div>
            </div>
            <?php if(mysqli_num_rows($result) > 0){ ?>
            <div class="row">
                <div class="col-md-3 left-sidebar">
                    
                    <h3>Related Categories</h3>
                    <ul>
                        <?php
                            
                            $sql = "SELECT * FROM brands AS b LEFT JOIN sub_categories AS sub ON b.brand_cat = sub.cat_parent WHERE b.brand_id = {$brand}";
                            $sub_categories = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($sub_categories) > 0){
                                foreach($sub_categories as $row2){ ?>
                                    <li><a href="category.php?cat=<?php echo $row2['sub_cat_id']; ?>"><?php echo $row2['sub_cat_title']; ?></a></li>
                            <?php }
                            }
                        ?>
                    </ul>
                </div>
                <div class="col-md-9">
                    <?php
                    $limit = 8;
                    $product_sql = "SELECT * FROM products WHERE product_brand = {$brand} AND product_status = 1 AND qty > 0 LIMIT {$limit}";
                    $result3 = mysqli_query($conn, $product_sql);
                    if(mysqli_num_rows($result3) > 0){
                        foreach($result3 as $row3){ ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="product-grid">
                                    <div class="product-image">
                                        <a class="image" href="single_product.php?pid=<?php echo $row3['product_id']; ?>">
                                            <img class="pic-1" src="product-images/<?php echo $row3['featured_image']; ?>">
                                        </a>
                                        <div class="product-button-group">
                                            <a href="single_product.php?pid=<?php echo $row3['product_id']; ?>" ><i class="fa fa-eye"></i></a>
                                            <a href="" class="add-to-cart" data-id="<?php echo $row3['product_id']; ?>"><i class="fa fa-shopping-cart"></i></a>
                                            <a href="" class="add-to-wishlist" data-id="<?php echo $row3['product_id']; ?>"><i class="fa fa-heart"></i></a>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3 class="title">
                                            <a href="single_product.php?pid=<?php echo $row3['product_id']; ?>"><?php echo substr($row3['product_title'],0,30).'...'; ?></a>
                                        </h3>
                                        <div class="price"><?php echo $cur_format; ?> <?php echo $row3['product_price']; ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php    }
                    } ?>
                    
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

<?php include 'footer.php'; ?>