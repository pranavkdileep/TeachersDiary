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
              <h5 class="card-title fw-semibold mb-4">Department Registration</h5>
              <div class="card">
                <div class="card-body">
                  <form action="depteditaction.php" method="post">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Department Name:</label>
                      <?php
             $sql="select*from tbldepartment where departmentid='$id'";
             $res=$obj->executequery($sql);
             $display=mysqli_fetch_array($res);
             ?>
                      <input type="text" name="txtdeptname" placeholder="Enter dept name" required class="form-control" value="<?php echo $display["departmentname"]?>" id="exampleInputName1" required>
                      
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
 