<?php

include("header.php");
include_once("../../dboperation.php");
$obj = new dboperation();

// Assuming teacher is logged in and their ID is stored in session
$teacherid = isset($_SESSION['teacherid']) ? $_SESSION['teacherid'] : 0;

if($teacherid == 0) {
    echo "<script>alert('Please login as a teacher.'); window.location='login.php';</script>";
    exit();
}

// Get department ID for the teacher
$teacher_dept_sql = "SELECT departmentid FROM tblteacher WHERE teacherid = $teacherid";
$dept_res = $obj->executequery($teacher_dept_sql);
$dept_row = mysqli_fetch_array($dept_res);
$departmentid = $dept_row['departmentid'];

// Initialize variables from POST
$marked_at = isset($_POST['txtdate']) ? $_POST['txtdate'] : date('Y-m-d');
$subjectid = isset($_POST['ddlsubject']) ? $_POST['ddlsubject'] : '';
$hour = isset($_POST['ddlhour']) ? $_POST['ddlhour'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance</title>
    <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Mark Student Attendance</h5>
                    
                    <form method="post" action="attendence.php" id="filterForm">
                        <div class="mb-3">
                            <label for="txtdate" class="form-label">Select Date:</label>
                            <input type="date" name="txtdate" class="form-control" 
                                value="<?php echo $marked_at; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="ddlhour" class="form-label">Select Hour:</label>
                            <select name="ddlhour" class="form-control" required>
                                <option value="">-- Select Hour --</option>
                                <?php
                                for($i = 1; $i <= 6; $i++) {
                                    $selected = $hour == $i ? 'selected' : '';
                                    echo "<option value='$i' $selected>Hour $i</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="ddlsubject" class="form-label">Select Subject:</label>
                            <select name="ddlsubject" class="form-control" required onchange="this.form.submit()">
                                <option value="">-- Select Subject --</option>
                                <?php
                                $sql = "SELECT s.subjectid, s.subjectname 
                                        FROM tblsubject s
                                        JOIN subject_teacher st ON s.subjectid = st.subjectid
                                        WHERE st.teacherid = $teacherid";
                                $res = $obj->executequery($sql);
                                while($row = mysqli_fetch_array($res)) {
                                    $selected = $subjectid == $row['subjectid'] ? 'selected' : '';
                                    echo "<option value='{$row['subjectid']}' $selected>{$row['subjectname']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                    </form>

                    <?php 
                    // Only show save form if all required fields are present
                    if($subjectid && $marked_at && $hour) { 
                    ?>
                    <form method="post" action="studentattendanceaction.php" id="saveForm">
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th>University ID</th>
                                        <th>Student Name</th>
                                        <th>Present</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch semester for the selected subject
                                    $subject_sql = "SELECT semester FROM tblsubject WHERE subjectid = $subjectid";
                                    $subject_res = $obj->executequery($subject_sql);
                                    $subject_row = mysqli_fetch_array($subject_res);
                                    $semester = $subject_row['semester'];

                                    // Fetch students matching department and semester
                                    $sql = "SELECT universityid, studentname 
                                            FROM tblstudent 
                                            WHERE departmentid = $departmentid 
                                            AND semester = '$semester'
                                            ORDER BY universityid";
                                    $res = $obj->executequery($sql);
                                    while($row = mysqli_fetch_array($res)) {
                                        $uid = $row['universityid'];
                                    ?>
                                    <tr>
                                        <td><?php echo $uid; ?></td>
                                        <td><?php echo $row['studentname']; ?></td>
                                        <td>
                                            <input type="hidden" name="students[]" value="<?php echo $uid; ?>">
                                            <input type="checkbox" 
                                                   name="attendance[<?php echo $uid; ?>]" 
                                                   value="1">
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" name="teacherid" value="<?php echo $teacherid; ?>">
                        <input type="hidden" name="txtdate" value="<?php echo $marked_at; ?>" required>
                        <input type="hidden" name="ddlsubject" value="<?php echo $subjectid; ?>" required>
                        <input type="hidden" name="ddlhour" value="<?php echo $hour; ?>" required>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary float-end" name="save">Save Attendance</button>
                        </div>
                    </form>
                    <?php } else if(isset($_POST['ddlsubject']) || isset($_POST['txtdate']) || isset($_POST['ddlhour'])) { ?>
                        <p class="text-danger">Please select all required fields (Date, Subject, and Hour) to mark attendance.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
</body>
</html>