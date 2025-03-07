<?php
include("header.php");
include_once("../dboperation.php");
$obj = new dboperation();
$id = $_GET['id'];
?>
<div class="container-fluid">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4">Course Edit</h5>
                        <form action="courseeditaction.php" method="post">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Program Edit</label>
                                <?php

                                $sql = "select*from tblcourse where courseid=$id";
                                $res = $obj->executequery($sql);
                                $dis = mysqli_fetch_array($res);

                                $sql1 = "SELECT * From tbldepartment";
                                $res1 = $obj->executequery($sql1);
                                ?>
                                Program:<input type="text" name="txtcoursename" value="<?php echo $dis["coursename"] ?>"
                                    placeholder="enter course" class="form-control" required><br>
                                <input type="hidden" value="<?php echo $id ?>" class="form-control" name="id">
                                Semester:<input type="text" name="txtsemester" value="<?php echo $dis["semesterno"] ?>"
                                    placeholder="enter course" class="form-control" required><br>

                                Department:<select name="ddldeptname" class="form-control" disabled="disabled" required>
                                    <option>-----select-----</option>
                                    <?php
                                    while ($display = mysqli_fetch_array($res1)) {
                                        ?>
                                        <option value="<?php echo $display["departmentid"]; ?>" <?php echo ($display["departmentid"] == $dis["departmentid"]) ? "selected=selected" : ""; ?>>
                                            <?php echo $display["departmentname"]; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <br>
                                <input type="submit" value="Update" name="save" class="btn btn-primary">
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
