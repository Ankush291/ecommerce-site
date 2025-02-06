<?php
// include header file
    include 'header.php'; ?>
        <div class="admin-content-container">
            <h3 class="admin-heading">Update Brand</h3>
            <div id="alert" class="alert" style="display: none;">
            </div>
            <?php  
                include "config.php";
                $brand_id = $_GET['id'];
                $sql = "SELECT * FROM brands WHERE brand_id = {$brand_id}";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    foreach($result as $row) {?>
                    <div class="row">
                        <!-- Form -->
                        <form id="updateBrand" class="add-post-form col-md-6" method ="POST">
                                <input type="hidden" id="brand_id" value="<?php echo $row['brand_id']; ?>" />
                            <div class="form-group">
                                <label>Brand Title</label>
                                <input type="text" name="brand_name" class="form-control brand_name" value="<?php echo $row['brand_title']; ?>"  placeholder="Brand Name" required />
                            </div>
                            <div class="form-group">
                                <label>Brand Category</label>
                                <?php
                                $sql2 = "SELECT *FROM categories";
                                $result2 = mysqli_query($conn, $sql2); ?>
                                <select name="brand_cat" class="form-control brand_category">
                                    <option value="" selected disabled>Select Category</option>
                                    <?php if (mysqli_num_rows($result2) > 0) {  ?>
                                        <?php foreach($result2 as $row2) { ?>
                                            <option <?php if($row2['cat_id'] == $row['brand_cat']) echo 'selected="selected"';  ?> value="<?php echo $row2['cat_id']; ?>"><?php echo $row2['cat_title']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <input type="submit" name="submit" class="btn add-new" value="Update" />
                        </form>
                        <!-- /Form -->
                    </div>
                    <?php
                    }
                } else { ?>
                    <div class="not-found">!!! Result Not Found !!!</div>
                <?php } ?>
            </div>
<?php
//    include footer file
include "footer.php";
?>
          
   

