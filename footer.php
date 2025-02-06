<div id ="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php
                    include "config.php";
                    $sql = "SELECT * FROM options";
                    $result1 = mysqli_query($conn, $sql) or die("Error");
                    $footer = mysqli_fetch_assoc($result1);  ?>
                <h3><?php echo $footer['site_name']; ?></h3>
                <p><?php echo $footer['site_desc']; ?></p>
            </div>
            <div class="col-md-3">
                <h3>Categories</h3>
                <ul class="menu-list">
                    <?php
                    $sub_sql = "SELECT * FROM sub_categories WHERE cat_products > 0 AND show_in_footer = 1";
                    $result2 = mysqli_query($conn, $sub_sql);
                    if(mysqli_num_rows($result2) > 0){
                        foreach($result2 as $res){ ?>
                            <li><a href="category.php?cat=<?php echo $res['sub_cat_id']; ?>"><?php echo $res['sub_cat_title']; ?></a></li>
                        <?php    }
                    } ?>
                </ul>
            </div>
            <div class="col-md-3">
                <h3>Useful Links</h3>
                <ul class="menu-list">
                    <li><a href="<?php echo $hostname; ?>">Home</a></li>
                    <li><a href="all_products.php">All Products</a></li>
                    <li><a href="latest_products.php">Latest Products</a></li>
                    <li><a href="popular_products.php">Popular Products</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h3>Contact Us</h3>
                <ul class="menu-list">
                    <?php if(!empty($footer['contact_address'])){ ?>
                        <li><i class="fa fa-home" ></i><span>: <?php echo $footer['contact_address']; ?></span></li>
                    <?php } ?>
                    <?php if(!empty($footer['contact_phone'])){ ?>
                        <li><i class="fa fa-phone" ></i><span>: <?php echo $footer['contact_phone']; ?></span></li>
                    <?php } ?>
                    <?php if(!empty($footer['contact_email'])){ ?>
                        <li><i class="fa fa-envelope" ></i><span>: <?php echo $footer['contact_email']; ?></span></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-md-12">
                <span><?php echo $footer['footer_text'] ?> | Created by <a href="#" target="_blank">OnlineShopping</a></span>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery-3.7.1.min.js" type="text/javascript"></script>
<script src="js/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/actions.js"></script>
<!--okzoom Plugin-->
<script src="js/okzoom.min.js" type="text/javascript"></script>
<!--owl carousel plugin-->
<script type="text/javascript" src="js/owl.carousel.js"></script>

<script>
    $(document).ready(function(){

        $('#product-img').okzoom({
            width: 200,
            height: 200,
            scaleWidth: 800
        });

        $('.banner-carousel').owlCarousel({
            loop: true,
            margin: 0,
            responsiveClass: true,
            navText : ["",""],
            responsive: {
                0: {
                    items: 1,
                    nav: true

                },
                600: {
                    items: 1,
                    nav: true
                },
                1000: {
                    items: 1,
                    nav: true,
                    loop: false,
                    margin: 10
                }
            }
        });

        $('.popular-carousel').owlCarousel({
            loop: true,
            margin: 0,
            responsiveClass: true,
            navText : ["",""],
            responsive: {
                0: {
                    items: 1,
                    nav: true

                },
                600: {
                    items: 2,
                    nav: true
                },
                800: {
                    items: 4,
                    nav: true
                },
                1000: {
                    items: 5,
                    nav: true,
                    loop: false,
                    margin: 10
                }
            }
        });

        $('.latest-carousel').owlCarousel({
            loop: true,
            margin: 0,
            responsiveClass: true,
            navText : ["",""],
            responsive: {
                0: {
                    items: 1,
                    nav: true

                },
                600: {
                    items: 2,
                    nav: true
                },
                800: {
                    items: 3,
                    nav: true
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                    margin: 5
                }
            }
        });
    });

</script>

</body>
</html>