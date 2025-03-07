<?php
include("../../dboperation.php");
$obj = new dboperation();

if (isset($_POST['update'])) { // Assuming the form button name is 'update'
    // $course = $_POST['ddlcourse'];
    // $sem = $_POST['ddlsemester'];
    // $subject = $_POST['subject_id'];
    $subject_teacher=$_POST['stid'];
    $teacher_id = $_POST['teacher_id'];
    $subject_id = $_POST['subject_id']; // Hidden input field from the form
    
    // Update the subject details
    
    // Update the teacher assignment
    echo $sql_teacher = "UPDATE subject_teacher SET teacherid='$teacher_id', subjectid='$subject_id' WHERE subteacherid='$subject_teacher'";
    $res_teacher = $obj->executequery($sql_teacher);
    
    // Check if both queries were successful
    if ( $res_teacher == 1) {
        echo "<script>alert('Updated successfully');
                window.location='allocationview.php'</script>";
    } else {
        echo "<script>alert('Update failed');
                window.location='subjectlist.php'</script>";
    }
}
?>
