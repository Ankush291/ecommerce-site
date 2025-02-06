$(document).ready(function(){

    var origin = window.location.origin;
    console.log("origin:",origin);
    var path = window.location.pathname.split( '/' );
    console.log(path);
    var URL = origin+'/'+path[1]+'/';
    console.log(URL);
    
    // check user login
    // =======================
    $('#adminLogin').submit(function(e){
        e.preventDefault();
        var username = $('.username').val();
        var password = $('.password').val();
        if(username == '' || password == ''){
            $('#adminLogin').append('<div class="alert alert-danger">Please Fill All The Fields.</div>');
        }else{
            $.ajax({
                url    : "./php_files/check_login.php",
                type   : "POST",
                data   : {login:'1',name:username, pass:password},
                success: function(response){
                    $('.alert').hide();
                    if(response == 1){
                        $('#adminLogin').append('<div class="alert alert-success">Logged In Successfully.</div>');
                        setTimeout(function(){ window.location = 'dashboard.php'; }, 1000);
                    }else if(response == 0){
                        $('#adminLogin').append('<div class="alert alert-danger">Username and Password not Matched.</div>');
                    }
                }
            });
        }
    });

    // change admin password
    $('#changePassword').submit(function(e){
        e.preventDefault();
        $('.alert').hide();
        var oldPass = $('.old_pass').val();
        var newPass = $('.new_pass').val();
        if(oldPass == '' || newPass == ''){
            $('#changePassword').prepend('<div class="alert alert-danger">Please Fill All The Fields.</div>');
        }else{
            var formdata = new FormData(this);
            formdata.append('changePass','1')
            $.ajax({
                url: "./php_files/check_login.php",
                type: "POST",
                data: formdata,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response == "success"){
                        $('#changePassword').prepend('<div class="alert alert-success">Password changed successfully.</div>');
                    }
                    else{
                        $('#changePassword').prepend(response);
                    }
                }
            });
        }
    });

    // load product
    function loadProduct(page){
        $.ajax({
            url : "./product/load-product.php",
            type : "POST",
            data : {"page" : page},
            success : function(response){
                $("#product_table").html(response);
                console.log("Success");
            }
        });
    }
    loadProduct();

    // pagination product
    $(document).on("click","#pagination .page-no a", function (e) {
        e.preventDefault();
        var page = $(this).attr("id");
        loadProduct(page);
    });


    // show sub categories
    $(document).on("change", ".product_category", function(){
        var id = $('.product_category option:selected').val();
        $.ajax({
            url: "./product/show-sub-categories.php",
            type: "POST",
            data: {p_cat:id},
            success: function(response){
                $('.product_sub_category').html(response);
            }
        });

        $.ajax({
            url: "./product/show-brands.php",
            type: "POST",
            data: {p_cat:id},
            success: function(response){
                $('.product_brands').html(response);
                // console.log(response);
            }
        });
    });

    // load product image with jquery
    $('.product_image').change(function(){
        readURL(this);
    })

    // add product
    $('#createProduct').submit(function(e){
        e.preventDefault();
        $('.alert').hide();
        var title = $('.product_title').val();
        var cat = $('.product_category option:selected').val();
        var sub_cat = $('.product_sub_category option:selected').val();
        var des = $('.product_description').val();
        var price = $('.product_price').val();
        var qty = $('.product_qty').val();
        var image = $('.product_image').val();
        if(title == ''){
            $('#createProduct').prepend('<div class="alert alert-danger">Title Field is Empty.</div>');
        }else if(cat == ''){
            $('#createProduct').prepend('<div class="alert alert-danger">Category Field is Empty.</div>');
        }else if(sub_cat == ''){
            $('#createProduct').prepend('<div class="alert alert-danger">Sub Category Field is Empty.</div>');
        }else if(des == ''){
            $('#createProduct').prepend('<div class="alert alert-danger">Description Field is Empty.</div>');
        }else if(price == ''){
            $('#createProduct').prepend('<div class="alert alert-danger">Price Field is Empty.</div>');
        }else if(qty == ''){
            $('#createProduct').prepend('<div class="alert alert-danger">Quantity Field is Empty.</div>');
        }else if(image == ''){
            $('#createProduct').prepend('<div class="alert alert-danger">Image Field is Empty.</div>');
        }else{
            var formdata = new FormData(this);
            $.ajax({
                url: "./product/insert-product.php",
                type: "POST",
                data: formdata,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response == 'success'){
                        $('#createProduct').prepend('<div class="alert alert-success">Product Inserted Successfully</div>');
                        setTimeout(function(){window.location = 'products.php'}, 1000);
                    }
                    else{
                        $('#createProduct').prepend(response);
                    }
                }
            });
        }

    });

    // update product
    $(document).on("submit","#updateProduct", function(e){
        e.preventDefault();
        console.log("Edit product");
        $('.alert').hide();
        var title = $('.product_title').val();
        var cat = $('.product_category option:selected').val();
        var sub_cat = $('.product_sub_category option:selected').val();
        var des = $('.product_description').val();
        var price = $('.product_price').val();
        var qty = $('.product_qty').val();
        var status = $('.product_status').val();
        var image = $('.product_image').val();
        var old_image = $('.old_image').val();
        if(title == ''){
            $('#updateProduct').prepend('<div class="alert alert-danger">Title Field is Empty.</div>');
        }else if(cat == ''){
            $('#updateProduct').prepend('<div class="alert alert-danger">Category Field is Empty.</div>');
        }else if(sub_cat == ''){
            $('#updateProduct').prepend('<div class="alert alert-danger">Sub Category Field is Empty.</div>');
        }else if(des == ''){
            $('#updateProduct').prepend('<div class="alert alert-danger">Description Field is Empty.</div>');
        }else if(price == ''){
            $('#updateProduct').prepend('<div class="alert alert-danger">Price Field is Empty.</div>');
        }else if(qty == ''){
            $('#updateProduct').prepend('<div class="alert alert-danger">Quantity Field is Empty.</div>');
        }else if(image == '' && old_image == ''){
            $('#updateProduct').prepend('<div class="alert alert-danger">Image Field is Empty.</div>');
        }else{
            var formdata = new FormData(this);
            $.ajax({
                url: "./product/update-product.php",
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false,
                success: function(response){
                    if(response == 'success'){
                        $('#updateProduct').prepend('<div class="alert alert-success">Product Update Successfully</div>');
                        setTimeout(function(){window.location = "products.php"}, 1000);
                    }
                    else{
                        $('#updateProduct').prepend(response);
                    }
                }
            });
        }

    });


    // delete product
    $(document).on("click", ".delete_product", function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var sub_cat = $(this).attr('data-subcat');
        if(confirm('Are you Sure want to delete this')){
            $.ajax({
                url: './product/delete-product.php',
                type: 'POST',
                data: {"delete_id": id, "p_subcat": sub_cat},
                success: function(response){
                    if(response == 1){
                        loadProduct();
                        $('#alert').show();
                        $('#alert').addClass('alert-success').prepend("<strong> Product Deleted Successfully </strong>");
                        $('body').click(function(){
                            $('#alert').fadeOut();
                        })
                        // console.log("Category Deleted Successfully");
                    }
                    else{
                        $('#alert').show();
                        $('#alert').addClass('alert-danger').prepend("<div class='alert alert-danger'> Product Cannot be Deleted </div>");
                        $('body').click(function(){
                            $('#alert').fadeOut();
                        })
                    }
                }
            });
        }
    });

    // load category
    function loadCategory(page){
        $.ajax({
            url : "./category/load-category.php",
            type : "POST",
            data : {"page" : page},
            success : function(response){
                $("#cat_table").html(response);
                console.log("Success");
            }
        });
    }
    loadCategory();

    // add category
    $('#createCategory').submit(function(e){
        e.preventDefault();
        var cat = $('.category').val();
        if(cat == ''){
            $('#createCategory').prepend('<div class="alert alert-danger">Category Field is Empty.</div>');
        }else{
            $.ajax({
                url : "./category/insert-category.php",
                type : "POST",
                data : {'cat': cat},
                success : function(response){
                    $('#alert').show();
                    $('#alert').html(response);
                    setTimeout(function(){ window.location = 'category.php'; }, 1000);
                }
            });
        }
    });

    // update category
    $('#updateCategory').submit(function(e){
        e.preventDefault();
        var cat_id = $('#cat_id').val();
        var cat = $('#cat_name').val();
        if(cat == ''){
            $('#updateCategory').prepend('<div class="alert alert-danger">Category Field is Empty.</div>');
        }
        else{
            $.ajax({
                url: './category/update-category.php',
                type: 'POST',
                data: {cat_id : cat_id, cat : cat},
                success: function(response){
                    if(response == 1){
                        loadCategory();
                        $('#alert').show();
                        $('#alert').addClass('alert-success').prepend("<strong> Category Updated Successfully </strong>");
                        setTimeout(function(){ window.location = 'category.php'; }, 1000);
                    }
                    else{
                        $('#alert').show();
                        $('#alert').addClass('alert-danger').prepend("<strong> Category Cannot be Updated </strong>");
                    }
                }
            })
        }
    });

    // delete category
    $(document).on('click', '.delete_category', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        if(confirm('Are you Sure want to delete this')){
            $.ajax({
                url: './category/delete-category.php',
                type: 'POST',
                data: {delete_id:id},
                success: function(response){
                    if(response == 1){
                        loadCategory();
                        $('#alert').show();
                        $('#alert').addClass('alert-success').prepend("<strong> Category Deleted Successfully </strong>");
                        $('#close-button').click(function(){
                            $('#alert').fadeOut();
                        })
                        // console.log("Category Deleted Successfully");
                    }
                    else{
                        $('#alert').show();
                        $('#alert').addClass('alert-danger').prepend("<div class='alert alert-danger'> Category Cannot be Deleted </div>");
                        $('#close-button').click(function(){
                            $('#alert').fadeOut();
                        })
                    }
                }
            });
        }
    });

    // pagination category
    $(document).on("click","#pagination .page-no a", function (e) {
        e.preventDefault();
        var page = $(this).attr("id");
        loadCategory(page);
    });

    // load sub-category
    function loadSubCategory(page){
        $.ajax({
            url : "./sub_category/load-sub-category.php",
            type : "POST",
            data : {"page" : page},
            success : function(response){
                $("#sub_cat_table").html(response);
                console.log("Success");
            }
        });
    }
    loadSubCategory();

    // pagination sub_category
    $(document).on("click","#pagination .page-no a", function (e) {
        e.preventDefault();
        var page = $(this).attr("id");
        loadSubCategory(page);
    });

    // add sub category
    $('#createSubCategory').submit(function(e){
        e.preventDefault();
        $('.alert').hide();
        var title = $('.sub_category').val();
        var parent = $('.parent_cat option:selected').val();
        if(title == ''){
            $('#createSubCategory').prepend('<div class="alert alert-danger">Title Field is Empty.</div>');
        }else if(parent == ''){
            $('#createSubCategory').prepend('<div class="alert alert-danger">Parent Category Field is Empty.</div>');
        }else{
            $.ajax({
                url: "./sub_category/insert-sub-category.php",
                type: "POST",
                data: {"title": title, "category": parent},
                success: function(response){
                    // console.log(response);
                    $('#alert').show();
                    $('#alert').html(response);
                    setTimeout(function(){ window.location = 'sub_category.php'; }, 1000);
                }
            })
        }
    });

    // update sub category
    $('#updateSubCategory').submit(function(e){
        e.preventDefault();
        var id = $('#sub_cat_id').val();
        var title = $('.sub_category').val();
        var parent = $('.parent_cat option:selected').val();
        if(title == ''){
            $('#updateSubCategory').prepend('<div class="alert alert-danger">Title Field is Empty.</div>');
        }else if(parent == ''){
            $('#updateSubCategory').prepend('<div class="alert alert-danger">Parent Category Field is Empty.</div>');
        }else{
            $.ajax({
                url: "./sub_category/update-sub-category.php",
                type: "POST",
                data: {"sub_cat_id": id, "title": title, "category": parent},
                success: function(response){
                    if(response == 1){
                        loadCategory();
                        $('#alert').show();
                        $('#alert').addClass('alert-success').html("<strong> Sub Category Updated Successfully </strong>");
                        setTimeout(function(){ window.location = 'sub_category.php'; }, 1000);
                    }
                    else{
                        $('#alert').show();
                        $('#alert').addClass('alert-danger').html("<strong> Sub Category Cannot be Updated </strong>");
                    }
                }
            })
        }
    });

    // delete sub category
    $(document).on("click", ".delete_sub_category", function(e){
        e.preventDefault();
        var id = $(this).data('id');
        if(confirm('Are you Sure want to delete this')){
            $.ajax({
                url: "./sub_category/delete-sub-caegory.php",
                type: "POST",
                data: {delete_id:id},
                success: function(response){
                    // console.log(response);
                    if(response == 1){
                        loadSubCategory();
                        $('#alert').show();
                        $('#alert').addClass('alert-success').html("<strong> Sub Category Deleted Successfully </strong>");
                        $('body').click(function(){
                            $('#alert').fadeOut();
                        })
                    }
                    else{
                        $('#alert').show();
                        $('#alert').addClass('alert-danger').html("<div class='alert alert-danger'> Category Cannot be Deleted </div>");
                        $('body').click(function(){
                            $('#alert').fadeOut();
                        })
                    }
                }
            });
        }
    });

    // script for show categories in header

    $(document).on("click", ".showCat_Header", function(){
        var id = $(this).data('id');
        var status = '';
        if($(this).prop("checked") == true){
            status = '1';
        }else if($(this).prop("checked") == false){
            status = '0';
        }
        $.ajax({
            url: "./sub_category/show-sub-category.php",
            type: "POST",
            data: {"sub_cat_id": id, "showInHeader": status},
            success: function(response){
                console.log("Header "+response);
            }
        })
    });

    // script for show categories in footer

    $(document).on("click", ".showCat_Footer", function(){
        var id = $(this).data('id');
        var status = '';
        if($(this).prop("checked") == true){
            status = '1';
        }else if($(this).prop("checked") == false){
            status = '0';
        }
        $.ajax({
            url: "./sub_category/show-sub-category.php",
            type: "POST",
            data: {"sub_cat_id": id, "showInFooter": status},
            success: function(response){
                console.log("Footer "+response);
            }
        })
    });

    // load brand
    function loadBrand(page){
        $.ajax({
            url : "./brand/load-brand.php",
            type : "POST",
            data : {"page" : page},
            success : function(response){
                $("#brand_table").html(response);
            }
        });
    }
    loadBrand();

    // pagination brand
    $(document).on("click","#pagination .page-no a", function (e) {
        e.preventDefault();
        var page = $(this).attr("id");
        loadBrand(page);
    });

    // add brand
    $('#createBrand').submit(function(e){
        e.preventDefault();
        $('.alert').hide();
        var title = $('.brand_name').val();
        var parent = $('.brand_category option:selected').val();
        if(title == ''){
            $('#createBrand').prepend('<div class="alert alert-danger">Title Field is Empty.</div>');
        }else if(parent == ''){
            $('#createBrand').prepend('<div class="alert alert-danger">Parent Category Field is Empty.</div>');
        }else{
            $.ajax({
                url: './brand/insert-brand.php',
                type: 'post',
                data: {"brand": title, "category": parent},
                success: function(response){
                    $('#alert').show();
                    $('#alert').html(response);
                    setTimeout(function(){ window.location = 'brands.php'; }, 1000);
                }
            })
        }
    });

    // update brand
    $('#updateBrand').submit(function(e){
        e.preventDefault();
        $('.alert').hide();
        var id = $('#brand_id').val();
        var title = $('.brand_name').val();
        var parent = $('.brand_category option:selected').val();
        if(title == ''){
            $('#updateBrand').prepend('<div class="alert alert-danger">Title Field is Empty.</div>');
        }else if(parent == ''){
            $('#updateBrand').prepend('<div class="alert alert-danger">Parent Category Field is Empty.</div>');
        }else{
            $.ajax({
                url: "./brand/update-brand.php",
                type: "POST",
                data: {"brand_id": id, "brand": title, "category": parent},
                success: function(response){
                    if(response == 1){
                        loadCategory();
                        $('#alert').show();
                        $('#alert').addClass('alert-success').html("<strong> Brand Updated Successfully </strong>");
                        setTimeout(function(){ window.location = 'brands.php'; }, 1000);
                    }
                    else{
                        $('#alert').show();
                        $('#alert').addClass('alert-danger').html("<strong> Brand Cannot be Updated </strong>");
                    }
                }
            })
        }
    });

    // delete brand
    $(document).on("click", ".delete_brand", function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        if(confirm('Are you Sure want to delete this')){
            $.ajax({
                url: "./brand/delete-brand.php",
                type: "POST",
                data: {"delete_id": id},
                success: function(response){
                    if(response == 1){
                        loadBrand();
                        $('#alert').show();
                        $('#alert').addClass('alert-success').html("<strong> Brand Deleted Successfully </strong>");
                        $('body').click(function(){
                            $('#alert').fadeOut();
                        })
                    }
                    else{
                        $('#alert').show();
                        $('#alert').addClass('alert-danger').html("<div class='alert alert-danger'> Brand Cannot be Deleted </div>");
                        $('body').click(function(){
                            $('#alert').fadeOut();
                        })
                    }
                }
            });
        }
    });

    // load order
    function loadOrder(page){
        $.ajax({
            url : "./order/load-orders.php",
            type : "POST",
            data : {"page" : page},
            success : function(response){
                $("#order_table").html(response);
            }
        });
    }
    loadOrder();

    // pagination order
    $(document).on("click","#pagination .page-no a", function(e) {
        e.preventDefault();
        var page = $(this).attr("id");
        loadOrder(page);
    });

    // change order delivery status
    $(document).on("click", ".order_complete", function(e) {
        e.preventDefault();
        var order_id = $(this).attr('data-id');
        $.ajax({
            url: './order/change-order-status.php',
            method: 'POST',
            data: { "complete": order_id },
            success: function (response) {
                loadOrder();
            }
        });
   });

    // load user
    function loadUser(page){
        $.ajax({
            url : "./user/load-user.php",
            type : "POST",
            data : {"page" : page},
            success : function(response){
                $("#user_table").html(response);
            }
        });
    }
    loadUser();

    // pagination user
    $(document).on("click","#pagination .page-no a", function (e) {
        e.preventDefault();
        var page = $(this).attr("id");
        loadUser(page);
    });

    // view user details
    $(document).on("click", ".user-view", function(e){
        e.preventDefault();
        var id = $(this).data('id');
        console.log(id);
        $.ajax({
            url: "./user/view-user.php",
            method: "POST",
            data: {"user_view": id },
            success: function (response) {
                console.log(response);
                $('#user-detail .modal-body').html(response);
                $('#user-detail').modal('show');
            }
        });
    });

    // change user status
    $(document).on("click", ".user-status", function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var status = $(this).attr('data-status');
        $.ajax({
            url: "./user/change-user-status.php",
            method: "POST",
            data: {"user_id": id, "user_role": status},
            success: function (response) {
                loadUser();
                console.log(response);
            }
        });
    });

    // delete user
    $(document).on("click",".delete_user", function (e) {
        e.preventDefault();
        var user_id = $(this).data("id");

        if(confirm("Are you want to delete this record ?")){
            $.ajax({
                url : "./user/delete-user.php",
                type : "POST",
                data : {"id" : user_id},
                success : function(response){
                    if(response == 1){
                        loadUser();
                        $('#alert').show();
                        $('#alert').addClass('alert-success').html("<strong> User Deleted Successfully </strong>");
                        $('body').click(function(){
                            $('#alert').fadeOut();
                        })
                    } else{
                        $('#alert').show();
                        $('#alert').addClass('alert-danger').html("<div class='alert alert-danger'> User Cannot be Deleted </div>");
                        $('body').click(function(){
                            $('#alert').fadeOut();
                        })
                    }
                }
            });
        }
    });

    // update site options
    $(document).on("submit", "#updateOptions", function(e){
        e.preventDefault();
        $('.alert').hide();
        var site_name = $('.site_name').val();
        var site_title = $('.site_title').val();
        var old_logo = $('.old_logo').val();
        var new_logo = $('.new_logo').val();
        var footer_text = $('.footer_text').val();
        var currency = $('.currency').val();
        var desc = $('.site_desc').val();
        var phone = $('.phone').val();
        var email = $('.email').val();
        var address = $('.address').val();
        
        if(site_name == ''){
            $('#updateOptions').prepend('<div class="alert alert-danger">Site Name Field is Empty.</div>');
        }if(site_title == ''){
            $('#updateOptions').prepend('<div class="alert alert-danger">Site Title Field is Empty.</div>');
        }else if(footer_text == ''){
            $('#updateOptions').prepend('<div class="alert alert-danger">Footer Text Field is Empty.</div>');
        }else if(currency == ''){
            $('#updateOptions').prepend('<div class="alert alert-danger">Currency Format Field is Empty.</div>');
        }else if(desc == ''){
            $('#updateOptions').prepend('<div class="alert alert-danger">Site Description is empty Field is Empty.</div>');
        }else if(phone == ''){
            $('#updateOptions').prepend('<div class="alert alert-danger">Phone Field is Empty.</div>');
        }else if(email == ''){
            $('#updateOptions').prepend('<div class="alert alert-danger">Email Field is Empty.</div>');
        }else if(address == ''){
            $('#updateOptions').prepend('<div class="alert alert-danger">Address Field is Empty.</div>');
        }else{
            var formdata = new FormData(this);
            $.ajax({
                url: "./admin_option/update-option.php",
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false,
                success: function(response){
                    console.log(response);
                    if(response == "success"){
                        $('#updateOptions').prepend('<div class="alert alert-success">Update Successful</div>');
                    }
                    else{
                        $('#updateOptions').prepend('<div class="alert alert-danger">'+response+'</div>');
                    }
                }
            });
        }

    });

    // load image with jquery
    $('.new_logo').change(function(){
        readURL(this);
    })


    // preview image before upload
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

});

