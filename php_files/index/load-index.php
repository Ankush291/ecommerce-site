<?php 
    include "C:/xampp/htdocs/ecommerce-site/config.php";

    if(isset($_POST['popular'])){
        $popular = '<div class="col-md-12">
                        <h2 class="section-head">Popular Products</h2>
                        <div class="popular-carousel owl-carousel owl-theme">';
        $limit = 10;
    
        $popular_prod_sql = "SELECT * FROM products WHERE product_views > 0 
                            ORDER BY product_views DESC LIMIT {$limit}";
        $result = mysqli_query($conn, $popular_prod_sql);
        
        if(mysqli_num_rows($result) > 0){
            foreach($result as $row){
                $popular .= '<div class="product-grid latest item">
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
            $popular .= '</div>
                    </div>';

        echo $popular;
    }
    elseif(isset($_POST['latest'])){
        $latest = '<div class="col-md-12">
                        <h2 class="section-head">Latest Products</h2>
                        <div class="latest-carousel owl-carousel owl-theme">';
        $limit = 5;
    
        $latest_prod_sql = "SELECT * FROM products
                            ORDER BY product_id DESC LIMIT {$limit}";
        $result = mysqli_query($conn, $latest_prod_sql);
        
        if(mysqli_num_rows($result) > 0){
            foreach($result as $row){
                $latest .= '<div class="product-grid latest item">
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
            $latest .= '</div>
                    </div>';
        
        echo $latest;
    }

?>