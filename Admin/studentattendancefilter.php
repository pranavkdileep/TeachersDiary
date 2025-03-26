<?php
include("header.php");
include_once("../dboperation.php");
$obj = new dboperation();



// Initialize filter variables
$subjectid = isset($_POST['ddlsubject']) ? $_POST['ddlsubject'] : '';
$from_date = isset($_POST['txtfromdate']) ? $_POST['txtfromdate'] : '';
$to_date = isset($_POST['txttodate']) ? $_POST['txttodate'] : '';
$download_csv = isset($_POST['download_csv']) ? true : false;

// Get department ID for the teacher
$teacher_dept_sql = "SELECT departmentid FROM tblteacher";
$dept_res = $obj->executequery($teacher_dept_sql);
$dept_row = mysqli_fetch_array($dept_res);
$departmentid = $dept_row['departmentid'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter & Download Attendance</title>
    <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Filter & Download Attendance</h5>
                    
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="ddlsubject" class="form-label">Select Subject:</label>
                            <select name="ddlsubject" class="form-control" required onchange="this.form.submit()">
                                <option value="">-- Select Subject --</option>
                                <?php
                                $sql = "SELECT s.subjectid, s.subjectname 
                                        FROM tblsubject s";
                                $res = $obj->executequery($sql);
                                while($row = mysqli_fetch_array($res)) {
                                    $selected = $subjectid == $row['subjectid'] ? 'selected' : '';
                                    echo "<option value='{$row['subjectid']}' $selected>{$row['subjectname']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="txtfromdate" class="form-label">From Date:</label>
                            <input type="date" name="txtfromdate" class="form-control" 
                                value="<?php echo $from_date; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="txttodate" class="form-label">To Date:</label>
                            <input type="date" name="txttodate" class="form-control" 
                                value="<?php echo $to_date; ?>" required>
                        </div>

                        <button type="submit" class="btn btn-primary" name="filter">Filter Attendance</button>
                        <?php if($subjectid && $from_date && $to_date) { ?>
                            <button type="submit" class="btn btn-success float-end" name="download_csv">Download CSV</button>
                        <?php } ?>
                    </form>

                    <?php 
                    if(isset($_POST['filter']) && $subjectid && $from_date && $to_date) {
                        // Fetch semester for the selected subject
                        $subject_sql = "SELECT semester FROM tblsubject WHERE subjectid = $subjectid";
                        $subject_res = $obj->executequery($subject_sql);
                        $subject_row = mysqli_fetch_array($subject_res);
                        $semester = $subject_row['semester'];

                        // Fetch attendance data
                        $sql = "SELECT s.universityid, s.studentname, a.hour, a.ispresent, a.marked_at
                                FROM tblstudent s
                                LEFT JOIN tblattendance a ON s.universityid = a.universityid 
                                AND a.subjectid = $subjectid 
                                AND a.marked_at BETWEEN '$from_date' AND '$to_date'
                                WHERE s.departmentid = $departmentid 
                                AND s.semester = '$semester'
                                ORDER BY s.universityid, a.marked_at, a.hour";
                        $res = $obj->executequery($sql);

                        // Store data for CSV if downloading
                        if($download_csv) {
                            header('Content-Type: text/csv');
                            header('Content-Disposition: attachment; filename="attendance_' . $subjectid . '_' . $from_date . '_to_' . $to_date . '.csv"');
                            $output = fopen('php://output', 'w');
                            fputcsv($output, ['University ID', 'Student Name', 'Date', 'Hour', 'Present']);
                        }
                    ?>
                    <div class="table-responsive mt-4">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>University ID</th>
                                    <th>Student Name</th>
                                    <th>Date</th>
                                    <th>Hour</th>
                                    <th>Present</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while($row = mysqli_fetch_array($res)) {
                                    $present = $row['ispresent'] == 1 ? 'Yes' : 'No';
                                    if($download_csv) {
                                        fputcsv($output, [
                                            $row['universityid'],
                                            $row['studentname'],
                                            $row['marked_at'],
                                            $row['hour'],
                                            $present
                                        ]);
                                    }
                                ?>
                                <tr>
                                    <td><?php echo $row['universityid']; ?></td>
                                    <td><?php echo $row['studentname']; ?></td>
                                    <td><?php echo $row['marked_at'] ?: 'N/A'; ?></td>
                                    <td><?php echo $row['hour'] ?: 'N/A'; ?></td>
                                    <td><?php echo $present; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php 
                        if($download_csv) {
                            fclose($output);
                            exit();
                        }
                    } else if(isset($_POST['filter'])) {
                        echo "<p class='text-danger mt-3'>Please select all required fields (Subject, From Date, To Date).</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
</body>
</html>