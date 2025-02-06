<?php 
    include "C:/xampp/htdocs/ecommerce-site/config.php";

    $output = '<div class="col-md-12">
                    <h2 class="section-head">Latest Products</h2>';
    $limit = 8;
    $page = "";
    if(isset($_POST['page'])){
        $page = $_POST['page'];
    }
    else{
        $page = 1;
    }
    $offset = ($page - 1) * $limit;
    $product_sql = "SELECT * FROM products WHERE product_status = 1 AND qty > 0 ORDER BY product_views DESC LIMIT {$offset}, {$limit}";
    $result = mysqli_query($conn, $product_sql);
    if(mysqli_num_rows($result) > 0){
        foreach($result as $row){
            $output .= '<div class="col-md-3 col-sm-6">
                            <div class="product-grid">
                                <div class="product-image latest">
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
                                        <a href="single_product.php?pid='. $row['product_id'] .'">'. $row['product_title'] .'</a>
                                    </h3>
                                    <div class="price">Rs. '. $row['product_price'] .'</div>
                                </div>
                            </div>
                        </div>';
        }
        $output .= '</div>';

        $sql_total = "SELECT * FROM products WHERE product_status = 1 AND qty > 0";
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
        $output .= '<div class="alert alert-danger">No product found.</div>';
    }

    echo $output;

?>