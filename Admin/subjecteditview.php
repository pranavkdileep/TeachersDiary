<?php
include("header.php");
include("../dboperation.php");
$obj=new dboperation();
$id= $_GET['id'];
?>
<div class="container-fluid">
<div class="row">
<div class="card">
            <div class="card-body">
              <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Subject Edit:</label>

        <form action="subjecteditaction.php" method="post">
            <?php
             $sql="select*from tblsubject where subjectid='$id'";
             $res=$obj->executequery($sql);
             $display=mysqli_fetch_array($res);
             ?>
            <input type="text"  class="form-control" value="<?php echo $display["subjectname"]?>" id="exampleInputName1" placeholder="Name" name="txtsubjectname" required>
            </div>
            <input type="submit" value="Update"  name="save" class="btn btn-primary">
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
 