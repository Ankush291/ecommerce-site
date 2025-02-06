<?php
include 'config.php';
session_start();
if(!isset($_SESSION['user_id']) && $_SESSION['user_role'] != 'user') {
    header("Location: " . $hostname);
}
include 'header.php'; ?>
    <div id="user_profile-content">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <h2 class="section-head">My Profile</h2>
                    <div id="user_profile_table">
                        <!-- user profile user php -->
                    </div>
                    <a class="modify-btn btn" data-toggle="modal" data-target="#userModify_form" href="#">Modify Details</a>
                    <a class="modify-btn btn" data-toggle="modal" data-target="#changePassword_form" href="#">Change Password</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="userModify_form" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body">
                    <div id="message"></div>
                    <?php
                    $user = $_SESSION["user_id"];
                    $sql = "SELECT * FROM user WHERE user_id = {$user}";
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0) { ?>
                    <!-- Form -->
                    <form id="modify-user" method="POST">
                        <div class="signup_form">
                            <h2>Modify Profile</h2>
                            <?php foreach($result as $row){ ?>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" placeholder="Email"
                                        value="<?php echo $row['email']; ?>" disabled requried>
                            </div>
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="f_name" class="form-control first_name"
                                    placeholder="First Name" value="<?php echo $row['f_name']; ?>" requried>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="l_name" class="form-control last_name" placeholder="Last Name"
                                    value="<?php echo $row['l_name']; ?>" requried>
                            </div>
                            
                            <div class="form-group">
                                <label>Mobile</label>
                                <input type="phone" name="mobile" class="form-control mobile" placeholder="Mobile"
                                    value="<?php echo $row['mobile']; ?>" requried>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control address" placeholder="Address"
                                    value="<?php echo $row['address']; ?>" requried>
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="city" class="form-control city" placeholder="City" value="<?php echo $row['city']; ?>" requried>
                            </div>
                            <input type="submit" name="signup" class="btn" value="Modify"/>
                        <?php  } ?>
                        </div>
                    </form>
                    <!-- /Form -->
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal -->

    <!-- Modal -->
    <div class="modal fade" id="changePassword_form" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body">
                    <div id="message"></div>
                    <?php
                        $user = $_SESSION["user_id"];
                        $sql = "SELECT * FROM user WHERE user_id = {$user}";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) { 
                    ?>
                    <!-- Form -->
                    <form id="modify-password" method="POST">
                        <?php foreach($result as $row) { ?>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" disabled
                                        value="<?php echo $row['email']; ?>" requried/>
                            </div>
                            <div class="form-group">
                                <label>Old Password</label>
                                <input type="password" name="old_pass" class="form-control old_pass"
                                        placeholder="Enter Old Password" requried/>
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="new_pass" class="form-control new_pass"
                                        placeholder="Enter New Password" requried/>
                            </div>
                            <input type="submit" name="submit" class="btn" value="Submit"/>
                        <?php } ?>
                    </form>
                    <!-- /Form -->
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal -->
    
<?php 
include 'footer.php';


?>
  