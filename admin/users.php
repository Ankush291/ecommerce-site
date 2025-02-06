<?php
// include header file
    include 'header.php'; ?>
    <div class="admin-content-container">
        <h2 class="admin-heading">All Users</h2>
        <div id="alert" class="alert" style="display: none;">
        </div>
        <div id="user_table">

        </div>
            <!-- <div class="not-found clearfix">!!! No Users Found !!!</div> -->
    </div>
<!-- Modal -->
<div class="modal fade" id="user-detail" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<!-- /Modal -->
<?php
//    include footer file
include "footer.php";
?>
