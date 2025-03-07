<?php
include("../dboperation.php");
include("header.php");
$obj=new dboperation();
$id= $_GET['id'];
?>
<div class="container-fluid">
<div class="row">
<div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Academic Year Edit </h5>
              <div class="card">
                <div class="card-body">
                  <form action="academiceditaction.php" method="post">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Academic Year</label>
                      <?php
             $sql="select*from tblacademicyear where academicid='$id'";
             $res=$obj->executequery($sql);
             $display=mysqli_fetch_array($res);
             ?>
                      <input type="text" name="txtacademicyear" placeholder="Enter academic year" required class="form-control" value="<?php echo $display["academicyear"]?>" id="exampleInputName1" required><br>
                      <div class="mb-3">
                     <label for="exampleInputEmail1" class="form-label">Select Status:</label><br>
                     <label for="exampleInputEmail1" class="form-label">
                     <input type="radio" name="txtstatus" value="active" <?php echo ($display["status"]=="active")?"checked":"";?> required>Active
                    </label>
                     <label for="exampleInputEmail1" class="form-label" style="margin-left: 15px;">
                    <input type="radio" name="txtstatus" value="inactive" <?php echo ($display["status"]=="inactive")?"checked":"";?> required>Inactive
                    </label><br>
                        </div>
                    </div>
                     <input type="submit" value="update" name="save" class="btn btn-primary">
                     <input type="hidden" value="<?php echo $id?>"class="form-control" name="id">
                  </form>
                </div>
              </div>
             
            </div>
          </div>
        </div>
      </div>

<?php
include("footer.php");
?>
 