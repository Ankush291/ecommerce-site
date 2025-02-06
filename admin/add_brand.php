<?php
// include header file
include 'header.php'; ?>

    <div class="admin-content-container">
        <h2 class="admin-heading">Add New Brand</h2>
        <div class="row">
        <div id="alert" class="alert" style="display: none;">
        </div>
            <!-- Form -->
            <form id="createBrand" class="add-post-form col-md-6" method="POST"
                  autocomplete="off">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="brand_name" class="form-control brand_name" placeholder="Brand Name"/>
                </div>
                <div class="form-group">
                    <label for="">Brand Category</label>
                    <?php
                    include "config.php";
                    $cat_sql = "SELECT * FROM categories";
                    $result = mysqli_query($conn, $cat_sql); ?>
                    <select class="form-control brand_category" name="brand_cat">
                        <option value="" selected disabled>Select Category</option>
                        <?php if (mysqli_num_rows($result) > 0) { ?>
                            <?php foreach($result as $row) { ?>
                                <option value="<?php echo $row['cat_id']; ?>"><?php echo $row['cat_title']; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <input type="submit" name="save" class="btn add-new" value="Submit"/></button>
            </form>
            <!-- /Form -->
        </div>
    </div>
<?php
//    include footer file
    include "footer.php";
?>
            