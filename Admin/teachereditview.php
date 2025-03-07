<?php
include("header.php");
include_once("../dboperation.php");
$obj=new dboperation();
$id=$_GET['id'];
?>


<div class="container-fluid">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4">Teacher Edit</h5>
                            <div class="mb-3">

                                <form action="teachereditaction.php" method="post">
                                <label for="exampleInputEmail1" class="form-label">Department:</label>
        <select name="ddldeptname" class="form-control">
                <option>-----select-----</option>
                    <?php
                     $sql1= "SELECT * FROM tblteacher where teacherid='$id'";
                     $res1=$obj->executequery($sql1);
                     $dis=mysqli_fetch_array($res1);
                    $sql="SELECT * From tbldepartment";
                    $res=$obj->executequery($sql);
                    while($display=mysqli_fetch_array($res))
                    {
                      ?>
                      <option value="<?php echo $display["departmentid"];?>" <?php echo ($display["departmentid"]== $dis["departmentid"])?"selected=selected":"";?>>
                      <?php echo $display["departmentname"];?>
                    </option>
                    <?php
                    }
                 ?>
                   </select><br>


 <input type="hidden" value="<?php echo $id?>"class="form-control" name="id">

            <label for="exampleInputEmail1" class="form-label"> Teacher Name:</label>
            <input type="text" name="txtfacultyname"  class="form-control" placeholder="enter name" value="<?php echo $dis["teachername"]?>"><br>
            <label for="exampleInputEmail1" class="form-label"> Email:</label>
            <input type="text" name="txtemail"  class="form-control" placeholder="enter email" value="<?php echo $dis["teacheremail"]?>"><br>
            <label for="exampleInputEmail1" class="form-label"> Phone:</label>
            <input type="text" name="txtphone" placeholder="enter phno"  class="form-control" value="<?php echo $dis["teacherphone"]?>"><br>
            <!-- Username:<input type="text" name="txtusername" placeholder="enter username" value="<?php echo $dis["teacherusername"]?>">
            password:<input type="text" name="txtpassword" placeholder="enter password" value="<?php echo $dis["teacherpassword"]?>"> -->
            <label for="exampleInputEmail1" class="form-label"> Select Role:</label><br>
            <input type="radio" name="txtrole" value="HOD"<?php echo ($dis["teacherrole"]=="HOD")?"checked":"";?>>HOD <input type="radio" name="txtrole" value="Staff" <?php echo ($dis["teacherrole"]=="Staff")?"checked":"";?>>Staff <br><br>
            <input type="submit" value="Register" name="save" class="btn btn-primary">
        </form>



                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>

<?php
include("footer.php");
?>