<?php
include("header.php");
include_once("../dboperation.php");
$obj = new dboperation();
?>

<div class="container-fluid">
    <div class="row">
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <!-- <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <a href="profile.php" class="btn btn-primary mb-3">Back to Profile <i class="ti ti-user"></i></a>
            </ul> -->
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Change Password</h5>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="changepasswordaction.php" class="forms-sample" enctype="multipart/form-data">
                        <div class="mb-3 row">
                            <label for="currentPassword" class="col-sm-3 col-form-label">Current Password</label>
                            <div class="col-sm-9">
                                <input type="password" name="txtpassword" class="form-control" id="currentPassword" placeholder="Enter Your Current Password" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="newPassword" class="col-sm-3 col-form-label">New Password</label>
                            <div class="col-sm-9">
                                <input type="password" name="txtnewpassword" class="form-control" id="newPassword" placeholder="Enter New Password" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="confirmPassword" class="col-sm-3 col-form-label">Confirm Password</label>
                            <div class="col-sm-9">
                                <input type="password" name="txtconfirmpwd" class="form-control" id="confirmPassword" placeholder="Confirm Password" required>
                            </div>
                        </div>
                        <button type="submit" name="btnsub" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>
