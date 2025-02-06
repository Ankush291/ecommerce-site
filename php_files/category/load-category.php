<?php 
    include "C:/xampp/htdocs/ecommerce-site/config.php";

    $cat = mysqli_real_escape_string($conn, $_POST['cat_id']);

    $sql = "SELECT sub_cat_title FROM sub_categories WHERE sub_cat_id = {$cat}";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $title = $row['sub_cat_title'].' : Buy '.$row['sub_cat_title'].' at Best Price'; 
    }else{ 
        $title = "Result Not Found";
    }
    
    $page_head = $row['sub_cat_title'];
    $output = "";

    $output .= '<div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="section-head"><?php echo $page_head; ?></h2>
                    </div>
                </div>';
                if(mysqli_num_rows($result) > 0){
    $output .= '<div class="row">
                    <div></div>
                    <div class="col-md-3 left-sidebar">
                        <h3>Related Brands</h3>';
                        $cat_p_sql = "SELECT cat_parent FROM sub_categories WHERE sub_cat_id = {$cat}";
                        $cat_name = mysqli_query($conn, $cat_p_sql);
                        $row1 = mysqli_fetch_assoc($cat_name);

                        $brand_sql = "SELECT * FROM brands WHERE brand_cat = {$row1['cat_parent']}";
                        $result2 = mysqli_query($conn, $brand_sql);
                        if(mysqli_num_rows($result2) > 0){
                            $output .= '<ul>';
                                foreach($result2 as $row2){
                                    $output .= '<li><a href="brands.php?brand='. $row2['brand_id'] .'">'. $row2['brand_title'] .'</a></li>';
                                }
                            $output .= '</ul>';
                        }
        $output .= '</div>
                    <div class="col-md-9">';
                        $limit = 8;
                        $prod_sql = "SELECT * FROM products WHERE product_sub_cat = {$cat} AND product_status = 1 AND qty > 0";
                        $result3 = mysqli_query($conn, $prod_sql);
                        if(mysqli_num_rows($result3) > 0){
                            foreach($result3 as $row3){
                                '<div class="col-md-4 col-sm-6">
                                    <div class="product-grid">
                                        <div class="product-image">
                                            <a class="image" href="single_product.php?pid='. $row3['product_id'] .'">
                                                <img class="pic-1" src="product-images/'. $row3['featured_image'] .'">
                                            </a>
                                            <div class="product-button-group">
                                                <a href="single_product.php?pid='. $row3['product_id'] .'" ><i class="fa fa-eye"></i></a>
                                                <a href="" class="add-to-cart" data-id="'. $row3['product_id'] .'"><i class="fa fa-shopping-cart"></i></a>
                                                <a href="" class="add-to-wishlist" data-id="'. $row3['product_id'] .'"><i class="fa fa-heart"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <h3 class="title">
                                                <a href="single_product.php?pid='. $row3['product_id'] .'">'. substr($row3['product_title'],0,30).'...' .'</a>
                                            </h3>
                                            <div class="price">Rs. '. $row3['product_price'] .'</div>
                                        </div>
                                    </div>
                                </div>';
                            }
                        }else{
                $output .= '<div class="empty-result">Result Empty</div>';
                    }
                    
            $output .= '</div>';
            }
            $output .= '</div>';
    
    echo $output;
?>