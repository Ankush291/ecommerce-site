<?php include 'config.php';  //include config
// set dynamic title
$title_sql = "SELECT site_title FROM options";
$result2 = mysqli_query($conn, $title_sql);
if(mysqli_num_rows($result2) > 0){
    $row2 = mysqli_fetch_assoc($result2);
    $title = $row2['site_title'];
}
else{
    $title = "Online Shopping Project";
}
// include header 
include 'header.php'; ?>
<div id="banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-content ">
                    <div class="banner-carousel owl-carousel owl-theme">
                        <div class="item">
                            <img src="images/banner-img-2.jpg" alt=""/>
                        </div>
                        <div class="item">
                            <img src="images/banner-img-1.jpg" alt=""/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="product-section popular-products">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-head">Popular Products</h2>
                <div class="popular-carousel owl-carousel owl-theme">
                <?php 
                    $limit = 10;
    
                    $popular_prod_sql = "SELECT * FROM products WHERE product_views > 0 
                                        ORDER BY product_views DESC LIMIT {$limit}";
                    $result = mysqli_query($conn, $popular_prod_sql);
                    
                    
                    if(mysqli_num_rows($result) > 0){
                        foreach($result as $row){
                            echo '<div class="product-grid latest item">
                                        <div class="product-image popular">
                                            <a class="image" href="single_product.php?pid='. $row['product_id'] .'">
                                                <img class="pic-1" src="product-images/'. $row['featured_image'] .'">
                                            </a>
                                            <div class="product-button-group">
                                                <a href="single_product.php?pid='. $row['product_id'] .'" ><i class="fa fa-eye"></i></a>
                                                <a href="" class="add-to-cart" data-id="'. $row['product_id'] .'"><i class="fa fa-shopping-cart"></i></a>
                                                <a href="" class="add-to-wishlist" data-id="'. $row['product_id'] .'"><i class="fa fa-heart"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <h3 class="title">
                                                <a href="single_product.php?pid='. $row['product_id'] .'">'. substr($row['product_title'],0,25)."..." .'</a>
                                            </h3>
                                            <div class="price">'. "Rs. " .' '. $row['product_price'] .'</div>
                                        </div>
                                    </div>';
                        }
                    }
                ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="product-section latest-products">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-head">Latest Products</h2>
                <div class="latest-carousel owl-carousel owl-theme">
                <?php 
                    $limit = 10;
    
                    $latest_prod_sql = "SELECT * FROM products
                                        ORDER BY product_id DESC LIMIT {$limit}";
                    $result = mysqli_query($conn, $latest_prod_sql);
                    if(mysqli_num_rows($result) > 0){
                        foreach($result as $row){
                            echo '<div class="product-grid latest item">
                                        <div class="product-image popular">
                                            <a class="image" href="single_product.php?pid='. $row['product_id'] .'">
                                                <img class="pic-1" src="product-images/'. $row['featured_image'] .'">
                                            </a>
                                            <div class="product-button-group">
                                                <a href="single_product.php?pid='. $row['product_id'] .'" ><i class="fa fa-eye"></i></a>
                                                <a href="" class="add-to-cart" data-id="'. $row['product_id'] .'"><i class="fa fa-shopping-cart"></i></a>
                                                <a href="" class="add-to-wishlist" data-id="'. $row['product_id'] .'"><i class="fa fa-heart"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <h3 class="title">
                                                <a href="single_product.php?pid='. $row['product_id'] .'">'. substr($row['product_title'],0,25)."..." .'</a>
                                            </h3>
                                            <div class="price">'. "Rs. " .' '. $row['product_price'] .'</div>
                                        </div>
                                    </div>';
                        }
                    }
                ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>