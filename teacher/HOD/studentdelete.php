<?php
include_once("../../dboperation.php");
$obj = new dboperation();

// Check if uid parameter is provided
if(isset($_GET['uid'])) {
    $universityid = $_GET['uid'];
    
    // Optional: Check if the student exists before deletion
    $check_sql = "SELECT * FROM tblstudent WHERE universityid = '$universityid'";
    $check_res = $obj->executequery($check_sql);
    $row_count = mysqli_num_rows($check_res);
    
    if($row_count > 0) {
        // Delete query
        $sql = "DELETE FROM tblstudent WHERE universityid = '$universityid'";
        $res = $obj->executequery($sql);
        
        if($res == 1) {
            echo "<script>alert('Student record deleted successfully.');
            window.location='student.php'</script>";
        } else {
            echo "<script>alert('Failed to delete student record.');
            window.location='student.php'</script>";
        }
    } else {
        echo "<script>alert('Student with University ID $universityid not found.');
        window.location='student.php'</script>";
    }
} else {
    // If no uid is provided in the URL
    echo "<script>alert('Invalid request: No student ID provided.');
    window.location='student.php'</script>";
}
?>