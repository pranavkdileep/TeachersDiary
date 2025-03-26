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

// Initialize variables from GET or POST for pre-filling
$marked_at = isset($_POST['txtdate']) ? $_POST['txtdate'] : date('Y-m-d');
$subjectid = isset($_POST['ddlsubject']) ? $_POST['ddlsubject'] : '';
$hour = isset($_POST['ddlhour']) ? $_POST['ddlhour'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student Attendance</title>
    <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Update Student Attendance</h5>
                    
                    <form method="post" action="" id="updateForm">
                        <div class="mb-3">
                            <label for="txtdate" class="form-label">Select Date:</label>
                            <input type="date" name="txtdate" class="form-control" 
                                value="<?php echo $marked_at; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="ddlsubject" class="form-label">Select Subject:</label>
                            <select name="ddlsubject" class="form-control" required >
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

                        <div class="mb-3">
                            <label for="ddlhour" class="form-label">Select Hour:</label>
                            <select name="ddlhour" class="form-control" required onchange="this.form.submit()">
                                <option value="">-- Select Hour --</option>
                                <?php
                                for($i = 1; $i <= 6; $i++) {
                                    $selected = $hour == $i ? 'selected' : '';
                                    echo "<option value='$i' $selected>Hour $i</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <?php if($marked_at && $subjectid && $hour) { ?>
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
                                    $teacher_dept_sql = "SELECT departmentid FROM tblteacher WHERE teacherid = $teacherid";
                                    $dept_res = $obj->executequery($teacher_dept_sql);
                                    $dept_row = mysqli_fetch_array($dept_res);
                                    $departmentid = $dept_row['departmentid'];

                                    $sql = "SELECT universityid, studentname 
                                            FROM tblstudent 
                                            WHERE departmentid = $departmentid 
                                            ORDER BY universityid";
                                    $res = $obj->executequery($sql);

                                    // Fetch existing attendance
                                    $attendance_sql = "SELECT universityid, ispresent 
                                                      FROM tblattendance 
                                                      WHERE marked_at = '$marked_at' 
                                                      AND subjectid = $subjectid 
                                                      AND hour = $hour";
                                    $attendance_res = $obj->executequery($attendance_sql);
                                    $attendance_data = [];
                                    while($att_row = mysqli_fetch_array($attendance_res)) {
                                        $attendance_data[$att_row['universityid']] = $att_row['ispresent'];
                                    }

                                    while($row = mysqli_fetch_array($res)) {
                                        $uid = $row['universityid'];
                                        $is_present = isset($attendance_data[$uid]) ? $attendance_data[$uid] : 0;
                                    ?>
                                    <tr>
                                        <td><?php echo $uid; ?></td>
                                        <td><?php echo $row['studentname']; ?></td>
                                        <td>
                                            <input type="hidden" name="students[]" value="<?php echo $uid; ?>">
                                            <input type="checkbox" 
                                                   name="attendance[<?php echo $uid; ?>]" 
                                                   value="1" 
                                                   <?php echo $is_present ? 'checked' : ''; ?>>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" name="teacherid" value="<?php echo $teacherid; ?>">
                        <div class="mt-3">
                            <button class="btn btn-primary float-end" name="update" id="submitbutton">Update Attendance</button>
                        </div>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../../jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
   // manualy action form data to studentattendanceupdateaction.php when submitbutton is clicked
    $("#submitbutton").click(function() {
         $("#updateForm").attr("action", "studentattendanceupdateaction.php");
    }); 
})
</script>

<?php include("footer.php"); ?>
</body>
</html>