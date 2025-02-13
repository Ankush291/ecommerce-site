<?php
    include 'config.php';


    // COOKIE  CODE

    if(isset($_POST["total_count"])){
        $output = "";
        $output .= '<li class="dropdown">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">';
                            
                            if (session_status() == PHP_SESSION_NONE) {
                                session_start();
                            }
                            if(isset($_SESSION["user_role"])){
                                $output .= 'Hello  '.$_SESSION["username"].' <i class="caret"></i>';
                            }else{
                                $output .= '<i class="fa fa-user"></i>';
                            }

                        $output .= '</a>
                        <ul class="dropdown-menu">
                            <!-- Trigger the modal with a button -->';
                            
                            if(isset($_SESSION["user_role"])){
                                $output .= '<li><a href="user_profile.php" class="" >My Profile</a></li>
                                <li><a href="user_orders.php" class="" >My Orders</a></li>
                                <li><a href="" class="user_logout" >Logout</a></li>';
                            }else{
                                $output .= '<li><a data-toggle="modal" data-target="#userLogin_form" href="#">login</a></li>
                                <li><a href="register.php">Register</a></li>';
                            }

                        $output .= '</ul>
                    </li>
                    <li>
                        <a href="wishlist.php"><i class="fa fa-heart"></i>';
                           if(isset($_COOKIE['wishlist_count'])){
                            $output .= '<span>'.$_COOKIE["wishlist_count"].'</span>';
                            }
                        $output .= '</a>
                    </li>
                    <li>
                        <a id="add-item" href="cart.php"><i class="fa fa-shopping-cart"></i>';
                            
                            if(isset($_SESSION["user_id"])){
                                $user_id = $_SESSION["user_id"];
                                $count_sql = "SELECT COUNT(*) AS cart_count FROM product_cart WHERE user_id = {$user_id}";
                                $result1 = mysqli_query($conn, $count_sql);
                                if(mysqli_num_rows($result1) > 0){
                                    foreach($result1 as $row1){
                                        $output .= '<span>'.$row1["cart_count"].'</span>';
                                    }
                                }
                            }
                            
                        $output .= '</a>
                    </li>';

        echo $output;
    }

    // add products in wishlist
    if(isset($_POST['addWishlist'])){
        $p_id = $_POST['addWishlist'];
        if(isset($_COOKIE['user_wishlist'])){
            $user_wishlist = json_decode($_COOKIE['user_wishlist']);
        }else{
            $user_wishlist = [];
        }
        if(!in_array($p_id,$user_wishlist)){
            array_push($user_wishlist,$p_id);
        }

        $wishlist_count = count($user_wishlist);
        $u_wishlist = json_encode($user_wishlist);

        if(setcookie('user_wishlist',$u_wishlist,time() + (180),'/','','',TRUE)){
            setcookie('wishlist_count',$wishlist_count,time() + (180),'/','','',TRUE);
            echo 'cookie set successfully';

            // echo "<pre>";
            // print_r($_COOKIE);
            // echo "</pre>";
            // exit;
        }else{
            echo 'false';
        }
    }

    // remove products from wishlist
    if(isset($_POST['removeWishlistItem'])){
        $p_id = $_POST['removeWishlistItem'];
        if($_COOKIE['wishlist_count'] == '1'){
            setcookie('wishlist_count','',time() - (180),'/','','',TRUE);
            setcookie('user_wishlist','',time() - (180),'/','','',TRUE);
        }else{
            if(isset($_COOKIE['user_wishlist'])){
                $user_wishlist = json_decode($_COOKIE['user_wishlist']);
                if(is_object($user_wishlist)){
                    $user_wishlist = get_object_vars($user_wishlist);
                }
                if (($key = array_search($p_id, $user_wishlist)) !== false) {
                    unset($user_wishlist[$key]);
                }
            }
            $wishlist_count = count($user_wishlist);
            $u_wishlist = json_encode($user_wishlist);

            if(setcookie('user_wishlist',$u_wishlist,time() + (180),'/','','',TRUE)){
                setcookie('wishlist_count',$wishlist_count,time() + (180),'/','','',TRUE);
                echo 'cookie set successfully';
            }else{
                echo 'false';
            }
        }
    }
?>