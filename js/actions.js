$(document).ready(function(){
    loadHeaderInfo();

    // load index
    function loadIndex(){
        console.log("load index");

        $.ajax({
            url: "./php_files/index/load-index.php",
            type: "POST",
            data: {"popular": 1},
            success: function(response){
                console.log(response);
                $('#index_popular').html(response);
            }
        });

        $.ajax({
            url: "./php_files/index/load-index.php",
            type: "POST",
            data: {"latest": 1},
            success: function(response){
                
                $('#index_latest').html(response);
            }
        });
    }
    // loadIndex();

    $('.add-to-wishlist').click(function(e){
        e.preventDefault();
        var p_id = $(this).attr('data-id');
        $.ajax({
            url: 'actions.php',
            method: 'POST',
            data: {addWishlist:p_id},
            success: function(data){
                console.log(data);
                loadHeaderInfo();
            }
        });
    });

    // load header information
    function loadHeaderInfo(){
        console.log("load count");
        $.ajax({
            url: "actions.php",
            type: "POST",
            data: {"total_count": 1},
            success: function(response){
                $("#header .header-info").html(response);
            }
        });
    }
    loadHeaderInfo()

    // load cart
    function loadCart(){
        $.ajax({
            url : "./php_files/cart/load-cart.php",
            type : "POST",
            data : {},
            success : function(response){
                $("#cart_table").html(response);
                net_amount();
                net_qty();
                // console.log("Success");
                $('.item-qty').change(function(){
                    var qty = $(this).val();
                    var price = $(this).siblings('.item-price').val();
                    var new_price = (qty * price);
                    $(this).parent().siblings().children('.sub-total').html(new_price);
                    net_amount();
                    net_qty();
                });
            }
        });
    }
    loadCart();

    $(document).on("click",".add-to-cart",function(e){
        e.preventDefault();
        var p_id = $(this).attr('data-id');
        $.ajax({
            url: "./php_files/cart/add-to-cart.php",
            method: "POST",
            data: {"addCart": p_id},
            success: function(response){
                loadHeaderInfo();
                if(response == "success"){
                    loadHeaderInfo();
                }
                else if(response == "login_first"){
                    $("#userLogin_form").modal("show");
                }
                else{
                    // show message
                }
            }
        });
    });

    $(document).on("click", ".remove-cart-item", function(e){
        
        e.preventDefault();
        var p_id = $(this).attr('data-id');
        $.ajax({
            url: "./php_files/cart/remove-from-cart.php",
            method: "POST",
            data: {"removeCartItem": p_id},
            success: function(response){
                if(response == "success"){
                    loadHeaderInfo();
                    loadCart();
                }
            }
        });
    });


    $('.remove-wishlist-item').click(function(e){
        e.preventDefault();
        var p_id = $(this).attr('data-id');
        $.ajax({
            url: 'actions.php',
            method: 'POST',
            data: {removeWishlistItem:p_id},
            success: function(data){
                location.reload();
            }
        });
    });


    $('.proceed-to-cart').click(function(e){
        e.preventDefault();
        var goToCart = 1;
        $.ajax({
            url: 'actions.php',
            method: 'POST',
            data: {proceedCart:goToCart},
            success: function(data){
                window.location.href = 'cart.php';
            }
        });
    });



    function net_amount(){
        var amount = 0;
        $('.sub-total').each(function(){
            var val = $(this).html();
            var total = parseInt(amount) + parseInt(val);
            amount = total;
        });
        $('.total-amount').html(amount);
        $('.checkout-form').children('.total-price').val(amount);
    }
    net_amount();

    function net_qty(){
        console.log("qty");
        var val = '';
        $('.item-qty').each(function(){
            val = (val + $(this).val()+',');
            console.log(val);
        })
        $('.checkout-form').children('.total-qty').val(val);
    }
    net_qty();


    $(document).on("submit", "#loginUser", function(e){
        console.log("Login form");
        e.preventDefault();
        var email = $('.email').val();
        var password = $('.password').val();
        if(email == '' || password == ''){
            $('#userLogin_form .modal-body #message').html('<div class="alert alert-danger">Please Fill All The Fields.</div>').fadeIn().delay(2000).fadeOut(2000);
        }else{
            $.ajax({
                url: "php_files/user.php",
                type: "POST",
                data: {"login": 1, "email": email, "password": password},
                success: function(response){
                    console.log(response);
                    if(response == 'success'){
                        $('#userLogin_form .modal-body #message').html('<div class="alert alert-success">Login Successfull.</div>');
                        setTimeout(function(){
                            $("#userLogin_form").modal("hide");
                        }, 1000);
                        loadHeaderInfo();
                    }
                    else{
                        $('#userLogin_form .modal-body #message').html('<div class="alert alert-danger">Email and Password not match.</div>').fadeIn().delay(2000).fadeOut(2000);
                    }

                }
            });
        }
    });



  
    $(document).on("click", ".user_logout", function(e){
        console.log("Logout");
        e.preventDefault();
        $.ajax({
            url: 'php_files/user.php',
            method: 'POST',
            data: {"user_logout": 1},
            success: function(response){
                if(response == 'true'){
                    loadHeaderInfo();
                    // location.reload();
                }
            }
        });
    });

    $("#register_sign_up").validate({
        rules:{
            f_name:{
                required: true,
                minlength: 3
            },
            l_name:{
                required: true,
                minlength: 3
            },
            email:{
                required: true,
                email: true
            },
            password:{
                required: true,
                
            },
            mobile:{
                required: true,
                minlength: 10,
                maxlength: 15
            },
            address:{
                required: true,
            },
            city:{
                required: true
            }
        }
    });

    $('#register_sign_up').submit(function(e){
        console.log("register");
        e.preventDefault();
        $('.alert').hide();

        if (!$("#register_sign_up").valid()){
            $("#register_sign_up #message").html('<div class="alert alert-danger">Please Fill All The Fields</div>');
        }else{
            var formdata = new FormData(this);
            formdata.append('create','1');
            $.ajax({
                url:"php_files/user.php",
                type:"POST",
                data: formdata,
                contentType: false,
                processData: false,
                success:function(response){
                    if(response == "success"){
                        $("#register_sign_up #message").html('<div class="alert alert-success">Register Successfull</div>');
                        setTimeout(function(){
                            window.location = "index.php";
                        }, 1000);
                    }
                    else{
                        console.log(response);
                        $("#register_sign_up #message").html('<div class="alert alert-danger">'+response+'</div>');
                    }
                }
            });
        }
    });

    // load user profile
    function loadUserProfile(){
        $.ajax({
            url: "php_files/user.php",
            type: "POST",
            data: {"profile": 1},
            success: function(response){
                $("#user_profile_table").html(response);
            }
        });
    }
    loadUserProfile();

    $('#modify-user').submit(function(e){
        e.preventDefault();
        var f_name = $(".first_name").val();
        var l_name = $(".last_name").val();
        var mobile = $(".mobile").val();
        var address = $(".address").val();
        var city = $(".city").val();

        if (f_name == '' || l_name == '' || mobile == '' || address == '' || city == ''){
            $('#userModify_form #message').html('<div class="alert alert-danger">Please Fill All The Fields</div>').delay(1000).fadeOut();
        }else{
            var formdata = new FormData(this);
            formdata.append('update','1');
            $.ajax({
                url:"php_files/user.php",
                type:"POST",
                data: formdata,
                contentType: false,
                processData: false,
                success:function(response){
                    if(response == "success"){
                        $("#userModify_form #message").html('<div class="alert alert-success">Modify Successfull</div>').delay(1000).fadeOut();
                        setTimeout(function(){
                            loadUserProfile();
                            $("#userModify_form").modal("hide");
                        }, 1000);
                    }
                    else{
                        $("#userModify_form #message").html('<div class="alert alert-danger">'+response+'</div>').delay(1000).fadeOut();
                    }
                }
            });
        }
    });


    $('#modify-password').submit(function(e){
        e.preventDefault();
        $('.alert').hide();
        var old_pass = $(".old_pass").val();
        var new_pass = $(".new_pass").val();

        if (old_pass == '' || new_pass == ''){
            $('#changePassword_form #message').html('<div class="alert alert-danger">Please Fill All The Fields</div>').delay(1000).fadeOut();
        }else{
            var formdata = new FormData(this);
            formdata.append('modifyPass','1');
            $.ajax({
                url:"php_files/user.php",
                type:"POST",
                data: formdata,
                contentType: false,
                processData: false,
                success:function(response){
                    console.log(response);
                    if(response == "success"){
                        $("#changePassword_form #message").html('<div class="alert alert-success">Password Change Successfull</div>').delay(1000).fadeOut();
                        setTimeout(function(){
                            loadUserProfile();
                            $("#changePassword_form").modal("hide");
                        }, 1000);
                    }
                    else{
                        $("#changePassword_form #message").html('<div class="alert alert-danger">'+response+'</div>');
                    }
                }
            });
        }
    });

    // load category
    // function loadCategory(cat_id){
    //     $.ajax({
    //         url : "category.php",
    //         type : "POST",
    //         data : {"cat_id": cat_id},
    //         success : function(response){
    //             // $("#category_list").html(response);
    //             console.log("Success");
    //         }
    //     });
    // }
    // loadCategory();

    // $(document).on("click", ".menu-list li a", function(e){
    //     e.preventDefault();
    //     var cat = $(this).data("id");
    //     console.log(cat);
    //     loadCategory(cat);
    // })

    // pagination category
    // $(document).on("click","#pagination .page-no a", function (e) {
    //     e.preventDefault();
    //     var page = $(this).attr("id");
    //     loadCategory(page = page);
    // });

    // load all products
    function loadAllProduct(page){
        $.ajax({
            url: "./php_files/products/load-all-products.php",
            type: "POST",
            data: {"page": page},
            success: function(response){
                $('#load_products').html(response);
            }
        });
    }
    loadAllProduct();

    // pagination products
    $(document).on("click","#pagination .page-no a", function (e) {
        e.preventDefault();
        var page = $(this).attr("id");
        loadAllProduct(page);
    });

    // load latest products
    function loadLatestProduct(page){
        $.ajax({
            url: "./php_files/products/load-latest-products.php",
            type: "POST",
            data: {"page": page},
            success: function(response){
                $('#load_latest_products').html(response);
            }
        });
    }
    loadLatestProduct();

    // pagination latest products
    $(document).on("click","#pagination .page-no a", function (e) {
        e.preventDefault();
        var page = $(this).attr("id");
        loadLatestProduct(page);
    });

    // load popular products
    function loadPopularProduct(page){
        $.ajax({
            url: "./php_files/products/load-popular-products.php",
            type: "POST",
            data: {"page": page},
            success: function(response){
                $('#load_popular_products').html(response);
            }
        });
    }
    loadPopularProduct();

    // pagination popular products
    $(document).on("click","#pagination .page-no a", function (e) {
        e.preventDefault();
        var page = $(this).attr("id");
        loadPopularProduct(page);
    });
});