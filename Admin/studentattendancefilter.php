<?php

include_once("../dboperation.php");
require '../vendor/autoload.php'; // Include PhpSpreadsheet via Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$obj = new dboperation();

// Assuming admin is logged in and their role is stored in session
$adminid = isset($_SESSION['aid']) ? $_SESSION['aid'] : 0;
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';



// Initialize filter variables
$subjectid = isset($_POST['ddlsubject']) ? $_POST['ddlsubject'] : '';
$from_date = isset($_POST['txtfromdate']) ? $_POST['txtfromdate'] : '';
$to_date = isset($_POST['txttodate']) ? $_POST['txttodate'] : '';
$download_excel = isset($_POST['download_excel']) ? true : false;

// Handle Excel download before any output
if($download_excel && $subjectid && $from_date && $to_date) {
    ob_start(); // Start output buffering

    // Fetch semester for the selected subject
    $subject_sql = "SELECT semester FROM tblsubject WHERE subjectid = $subjectid";
    $subject_res = $obj->executequery($subject_sql);
    $subject_row = mysqli_fetch_array($subject_res);
    $semester = $subject_row['semester'];

    // Fetch unique date-hour combinations for the subject
    $date_hour_sql = "SELECT DISTINCT marked_at, hour 
                    FROM tblattendance 
                    WHERE subjectid = $subjectid 
                    AND marked_at BETWEEN '$from_date' AND '$to_date'
                    ORDER BY marked_at, hour";
    $date_hour_res = $obj->executequery($date_hour_sql);
    $date_hours = [];
    while($dh_row = mysqli_fetch_array($date_hour_res)) {
        $date_hours[] = $dh_row['marked_at'] . ' Hour ' . $dh_row['hour'];
    }

    // Fetch attendance data for all students tied to the subject
    $sql = "SELECT s.universityid, s.studentname, a.marked_at, a.hour, a.ispresent
            FROM tblstudent s
            LEFT JOIN tblattendance a ON s.universityid = a.universityid 
            AND a.subjectid = $subjectid 
            AND a.marked_at BETWEEN '$from_date' AND '$to_date'
            WHERE s.semester = '$semester'
            ORDER BY s.universityid, a.marked_at, a.hour";
    $res = $obj->executequery($sql);

    // Organize data into a matrix
    $attendance_matrix = [];
    while($row = mysqli_fetch_array($res)) {
        $uid = $row['universityid'];
        if(!isset($attendance_matrix[$uid])) {
            $attendance_matrix[$uid] = ['name' => $row['studentname']];
        }
        $key = $row['marked_at'] . ' Hour ' . $row['hour'];
        $attendance_matrix[$uid][$key] = $row['ispresent'] == 1 ? 'Present' : 'Absent';
    }

    // Generate Excel file
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set headers
    $headers = array_merge(['Name'], $date_hours);
    $sheet->fromArray($headers, NULL, 'A1');

    // Fill data
    $row_num = 2;
    foreach($attendance_matrix as $uid => $data) {
        $row_data = [$data['name']];
        foreach($date_hours as $dh) {
            $row_data[] = $data[$dh] ?? 'Absent'; // Default to Absent if no record
        }
        $sheet->fromArray($row_data, NULL, 'A' . $row_num);
        $row_num++;
    }

    // Auto-size columns
    foreach(range('A', chr(65 + count($headers) - 1)) as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Clear buffer and send file
    ob_end_clean();
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="admin_attendance_subject_' . $subjectid . '_' . $from_date . '_to_' . $to_date . '.xlsx"');
    header('Cache-Control: max-age=0');
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
}

// Include header only if not downloading
include("header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Filter & Download Attendance</title>
    <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Admin Filter & Download Attendance</h5>
                    
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="ddlsubject" class="form-label">Select Subject:</label>
                            <select name="ddlsubject" class="form-control" required onchange="this.form.submit()">
                                <option value="">-- Select Subject --</option>
                                <?php
                                $sql = "SELECT subjectid, subjectname FROM tblsubject ORDER BY subjectname";
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
                            <button type="submit" class="btn btn-success float-end" name="download_excel">Download Excel</button>
                        <?php } ?>
                    </form>

                    <?php 
                    if(isset($_POST['filter']) && $subjectid && $from_date && $to_date) {
                        // Fetch semester for the selected subject
                        $subject_sql = "SELECT semester FROM tblsubject WHERE subjectid = $subjectid";
                        $subject_res = $obj->executequery($subject_sql);
                        $subject_row = mysqli_fetch_array($subject_res);
                        $semester = $subject_row['semester'];

                        // Fetch unique date-hour combinations
                        $date_hour_sql = "SELECT DISTINCT marked_at, hour 
                                        FROM tblattendance 
                                        WHERE subjectid = $subjectid 
                                        AND marked_at BETWEEN '$from_date' AND '$to_date'
                                        ORDER BY marked_at, hour";
                        $date_hour_res = $obj->executequery($date_hour_sql);
                        $date_hours = [];
                        while($dh_row = mysqli_fetch_array($date_hour_res)) {
                            $date_hours[] = $dh_row['marked_at'] . ' Hour ' . $dh_row['hour'];
                        }

                        // Fetch attendance data for all students tied to the subject
                        $sql = "SELECT s.universityid, s.studentname, a.marked_at, a.hour, a.ispresent
                                FROM tblstudent s
                                LEFT JOIN tblattendance a ON s.universityid = a.universityid 
                                AND a.subjectid = $subjectid 
                                AND a.marked_at BETWEEN '$from_date' AND '$to_date'
                                WHERE s.semester = '$semester'
                                ORDER BY s.universityid, a.marked_at, a.hour";
                        $res = $obj->executequery($sql);

                        // Organize data into a matrix
                        $attendance_matrix = [];
                        while($row = mysqli_fetch_array($res)) {
                            $uid = $row['universityid'];
                            if(!isset($attendance_matrix[$uid])) {
                                $attendance_matrix[$uid] = ['name' => $row['studentname']];
                            }
                            $key = $row['marked_at'] . ' Hour ' . $row['hour'];
                            $attendance_matrix[$uid][$key] = $row['ispresent'] == 1 ? 'Present' : 'Absent';
                        }
                    ?>
                    <div class="table-responsive mt-4">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <?php foreach($date_hours as $dh) { ?>
                                        <th><?php echo $dh; ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($attendance_matrix as $uid => $data) { ?>
                                <tr>
                                    <td><?php echo $data['name']; ?></td>
                                    <?php foreach($date_hours as $dh) { ?>
                                        <td><?php echo $data[$dh] ?? 'Absent'; ?></td>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php 
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