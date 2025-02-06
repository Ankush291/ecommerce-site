<?php
include 'header.php'; ?>
<div class="admin-content-container">
    <h2 class="admin-heading">All Categories</h2>
    <a class="add-new pull-right" href="add_category.php">Add New</a>
    <div id="alert" class="alert" style="display: none;">
        
        <button type="button" id="close-button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <div id="cat_table">

    </div>
        <!-- <div class="not-found">!!! No Category Available !!!</div> -->
    
</div>
<?php
//    include footer file
    include "footer.php";
?>
