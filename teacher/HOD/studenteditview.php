<?php
include("header.php");
include_once("../../dboperation.php");
$obj = new dboperation();
$universityid = $_GET['uid']; // Getting universityid from URL parameter
?>

<div class="container-fluid">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4">Student Edit</h5>
                        <div class="mb-3">
                            <form action="studenteditaction.php" method="post">
                                <!-- Department Selection -->
                                <label for="ddldeptname" class="form-label">Department:</label>
                                <select name="ddldeptname" class="form-control">
                                    <option value="">-----select-----</option>
                                    <?php
                                    // Fetch student data
                                    $sql1 = "SELECT * FROM tblstudent WHERE universityid='$universityid'";
                                    $res1 = $obj->executequery($sql1);
                                    $dis = mysqli_fetch_array($res1);
                                    
                                    // Fetch departments
                                    $sql = "SELECT * FROM tbldepartment";
                                    $res = $obj->executequery($sql);
                                    while($display = mysqli_fetch_array($res)) {
                                    ?>
                                        <option value="<?php echo $display["departmentid"]; ?>" 
                                            <?php echo ($display["departmentid"] == $dis["departmentid"]) ? "selected=selected" : ""; ?>>
                                            <?php echo $display["departmentname"]; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select><br>

                                <!-- Hidden universityid -->
                                <input type="hidden" value="<?php echo $universityid ?>" class="form-control" name="universityid">

                                <!-- Student Name -->
                                <label for="txtstudentname" class="form-label">Student Name:</label>
                                <input type="text" name="txtstudentname" class="form-control" 
                                    placeholder="Enter name" value="<?php echo $dis["studentname"] ?>" required><br>

                                <!-- Parent Email -->
                                <label for="txtparentemail" class="form-label">Parent Email:</label>
                                <input type="email" name="txtparentemail" class="form-control" 
                                    placeholder="Enter email" value="<?php echo $dis["parentemail"] ?>" required><br>

                                <!-- Phone -->
                                <label for="txtphone" class="form-label">Phone:</label>
                                <input type="text" name="txtphone" class="form-control" 
                                    placeholder="Enter phone number" value="<?php echo $dis["phone"] ?>" 
                                    pattern="[0-9]{10}" title="Must contain 10 digits" required><br>

                                <!-- Semester -->
                                <label for="txtsemester" class="form-label">Semester:</label>
                                <input type="text" name="txtsemester" class="form-control" 
                                    placeholder="Enter semester" value="<?php echo $dis["semester"] ?>" required><br>

                                <!-- Submit Button -->
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