<?php
include("../dboperation.php");
$obj = new dboperation();
$did = $_POST['did'];
$s = 1;
$sql = "select * from tblcourse where departmentid='$did'";
$res=$obj->executequery($sql);
?>
<div class="container-fluid">
<div class="row">
<label for="exampleInputEmail1" class="form-label">Course:</label><br>
<select class="form-control" id="course" name="course">
                <option>----Select----</option>
                <?php
                while ($display1 = mysqli_fetch_array($res)) {
                    ?>
                    <option value="<?php echo $display1["courseid"]; ?></option>">
                        <?php echo $display1["coursename"]; ?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </div>
        </div>
        </>
