<?php
// include header file
include 'header.php'; ?>
<div class="admin-content-container">
    <h2 class="admin-heading">Add New Sub Category</h2>
    <div class="row">
    <div id="alert" style="display: none;"></div>
    <!-- Form -->
    <form id="createSubCategory" class="add-post-form col-md-6" method="POST">
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="sub_cat_name" class="form-control sub_category" placeholder="Sub Category Name" />
        </div>
        <div class="form-group">
            <label for="">Parent Category</label>
            <?php
            include "config.php";
            $cat_sql = "SELECT * FROM categories";
            $result = mysqli_query($conn, $cat_sql); ?>
            <select class="form-control parent_cat" name="parent_cat">
                <option value="" selected disabled>Select Category</option>
                <?php if (mysqli_num_rows($result) > 0) {  ?>
                <?php foreach($result as $row) { ?>
                    <option value="<?php echo $row['cat_id']; ?>"><?php echo $row['cat_title']; ?></option>
                <?php } ?>
                <?php } ?>
            </select>
        </div>
        <input type="submit" name="save" class="btn add-new" value="Submit" />
    </form>
    <!-- /Form -->
    </div>
</div>
<?php
//    include footer file
    include "footer.php";
?>
