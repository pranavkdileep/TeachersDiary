<?php
include("../dboperation.php");
$obj = new dboperation();

if (isset($_POST['save'])) {
    // Extract form data properly
    $course = $_POST['ddlcourse']; // No need for array index
    // $sem = $_POST['ddlsemester'];
    // $sub = $_POST['ddlsubject'];
    $mod = $_POST['module'];
    $topic = $_POST['topics'];
    $tid = $_POST['tid'];

    if($course == 19)
    {
            $sub=12;
    }
    elseif($course == 22)
    {
        $sub=13;
    }
    else
    {
        $sub = $_POST['ddlsubject']; 
    }
    // Debugging to ensure data is being received
    echo "Course: $course, Subject: $sub, Module: $mod, Topic: $topic, Teacher Log ID: $tid";

    // Check if values are properly set
    if ($course && $sub) {
        // Update query
        $sql = "UPDATE tblteacherlog SET courseid='$course', subjectid='$sub', module='$mod', topic='$topic' WHERE teacherlogid='$tid'";
        $res = $obj->executequery($sql);

        if ($res == 1) {
            echo "<script>alert('Updated successfully'); window.location='logbookview.php';</script>";
        } else {
            echo "<script>alert('Update failed'); window.location='logbookview.php';</script>";
        }
    } else {
         echo "<script>alert('Invalid input data'); window.location='logbookview.php';</script>";
    }
}
?>
