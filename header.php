<?php 
    include "config.php";
    $sql = "SELECT site_name, site_title, site_logo, currency_format FROM options";
    $header = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($header);

    $cur_format = 'Rs. ';
    if($row['currency_format'] != ""){
        $cur_format = $row['currency_format'];
    }

    if(empty($title)){

        $title = $row['site_title'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title id="header_title"><?php echo $title; ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900|Montserrat:400,500,700,900" rel="stylesheet">
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="css/owl.theme.default.min.css"/>
</head>
<body>
<!-- HEADER -->
<div id="header">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- LOGO -->
            <div class="col-md-2">
                <?php
                    if(!empty($row['site_logo'])){ ?>
                        <a href="<?php echo $hostname; ?>" class="logo-img"><img src="images/<?php echo $row['site_logo']; ?>" alt=""></a>
                    <?php }else{ ?>
                        <a href="<?php echo $hostname; ?>" class="logo"><?php echo $row['site_name']; ?></a>
                    <?php } ?>
            </div>
            <!-- /LOGO -->
            <div class="col-md-7">
                <form action="search.php" method="GET">
                <div class="input-group search">
                    <input type="text" class="form-control" name="search" placeholder="Search for...">
                    <span class="input-group-btn">
                        <input class="btn btn-default"  type="submit" value="Search" />
                    </span>
                </div>
                </form>
            </div>
            <div class="col-md-3">
                <ul class="header-info">
                    <!-- action.php -->
                </ul>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="userLogin_form" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="modal-body">
                            <div id="message"></div>
                            <!-- Form -->
                            <form  id="loginUser" method ="POST">
                                <div class="customer_login"> 
                                    <h2>login here</h2>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control email" placeholder="Email" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control password" placeholder="password" autocomplete="off">
                                    </div>
                                    <input type="submit" name="login" class="btn" value="login"/>
                                    <span>Don't Have an Account <a href="register.php">Register</a></span>
                                </div>
                            </form>
                            <!-- /Form -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Modal -->
        </div>
    </div>
</div>
<div id="header-menu">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <ul class="menu-list">
                    <?php
                    $menu_sql = "SELECT * FROM sub_categories WHERE cat_products > 0 AND show_in_header = 1";
                    $result = mysqli_query($conn, $menu_sql);
                    if(mysqli_num_rows($result) > 0){
                        foreach($result as $res){ ?>
                            <li><a href="category.php?cat=<?php echo $res['sub_cat_id']; ?>"><?php echo $res['sub_cat_title']; ?></a></li>
                        <?php  }
                    } ?>
                </ul>
            </div>
        </div>
    </div>
</div>