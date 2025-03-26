<?php
session_start();
include_once("../dboperation.php");
$obj = new dboperation();

if(isset($_POST['save'])) {
    $marked_at = $_POST['txtdate'];
    $subjectid = $_POST['ddlsubject'];
    $teacherid = $_POST['teacherid'];
    $hour = $_POST['ddlhour'];
    $attendance_data = isset($_POST['attendance']) ? $_POST['attendance'] : [];
    $all_students = $_POST['students']; // Array of all student IDs

    // Validate inputs
    if(empty($marked_at) || empty($subjectid) || empty($teacherid) || empty($hour) || empty($all_students)) {
        echo "<script>alert('Missing required fields.'); window.location='attendence.php';</script>";
        exit();
    }

    // Begin transaction
    $obj->executequery("START TRANSACTION");

    $success = true;
    foreach($all_students as $universityid) {
        // Check if record exists
        $check_sql = "SELECT attendanceid FROM tblattendance 
                     WHERE universityid = '$universityid' 
                     AND hour = $hour 
                     AND marked_at = '$marked_at' 
                     AND subjectid = $subjectid";
        $check_res = $obj->executequery($check_sql);
        $exists = mysqli_num_rows($check_res) > 0;

        // If checkbox is checked, ispresent = 1; otherwise, ispresent = 0
        $ispresent = isset($attendance_data[$universityid]) && $attendance_data[$universityid] == 1 ? 1 : 0;

        if($exists) {
            // Update existing record
            $sql = "UPDATE tblattendance SET 
                    ispresent = $ispresent,
                    teacherid = $teacherid
                    WHERE universityid = '$universityid' 
                    AND hour = $hour 
                    AND marked_at = '$marked_at' 
                    AND subjectid = $subjectid";
        } else {
            // Insert new record
            $sql = "INSERT INTO tblattendance (universityid, hour, ispresent, marked_at, subjectid, teacherid)
                    VALUES ('$universityid', $hour, $ispresent, '$marked_at', $subjectid, $teacherid)";
        }
        
        $res = $obj->executequery($sql);
        if($res != 1) { // Assuming executequery returns 1 on success
            $success = false;
            break;
        }
    }

    if($success) {
        $obj->executequery("COMMIT");
        echo "<script>alert('Attendance marked successfully for Hour $hour.');
        window.location='attendence.php'</script>";
    } else {
        $obj->executequery("ROLLBACK");
        echo "<script>alert('Failed to mark attendance for Hour $hour.');
        window.location='attendence.php'</script>";
    }
} else {
    echo "<script>alert('Invalid request.');
    window.location='attendence.php'</script>";
}
?>