<?php
include("header.php");
include_once("../dboperation.php");
$obj=new dboperation();

// Check if a department ID is passed via the URL
$dept_id = isset($_GET['dept']) ? $_GET['dept'] : 0;
?>
<div class="container-fluid">
    <div class="row">
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

                <a href="courseview.php" class="btn btn-primary mb-3">View Programs <i class="ti ti-eye"></i></a>
            </ul>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Program Registration</h5>
            <div class="card">
                <div class="card-body">
                    <form action="courseregaction.php" method="post">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Department</label>
                            <select name="ddldeptname" class="form-control" required>
                                <option selected disabled>-----select-----</option>
                                <?php
                                $sql = "SELECT * From tbldepartment";
                                $res = $obj->executequery($sql);
                                while ($display = mysqli_fetch_array($res)) {
                                    ?>
                                    <option value="<?php echo $display["departmentid"]; ?>" 
                                    <?php if ($display["departmentid"] == $dept_id && $dept_id != 0) echo 'selected'; ?>>
                                        <?php echo $display["departmentname"]; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>


                        </div>


                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Program</label>



                            <input type="text" name="txtcoursename" placeholder="enter program" class="form-control"  required>

                        </div>

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Semester</label>


                            <select name="ddlsemester" class="form-control" required>
                                <option value="">----Select----</option>
                                <option value="4">4-Semester</option>
                                <option value="6">6-Semester</option>
                                <option value="8">8-Semester</option>
                            </select>
                            </div>

                                <input type="submit" value="Register" name="save" class="btn btn-primary">
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



