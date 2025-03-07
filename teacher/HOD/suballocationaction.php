<?php
session_start();
include_once("../../dboperation.php");
$obj = new dboperation();

    // Retrieve the arrays of subject IDs and teacher IDs
    $subjectIds = $_POST['subjectid'];
    $teacherIds = $_POST['ddlteacher'];
    $ayear=$_POST['ddlayear'];
    $semester=$_POST['ddlsemester'];
    // Loop through each pair of subject ID and teacher ID to insert into the database
    for ($i = 0; $i < count($subjectIds); $i++)
     {
        $subjectId = $subjectIds[$i];
        $teacherId = $teacherIds[$i];

        // Insert into the database
        $sql = "INSERT INTO subject_teacher (subjectid, teacherid,status,academicid,semester) VALUES ('$subjectId', '$teacherId',0,'$ayear','$semester')";
        $result = $obj->executequery($sql);

        // Check if insertion was successful
        if ($result) {
            echo "<script>alert('Subject Allocated Successfully');
            window.location='subjectallocation.php'</script>";
        } else {
            echo "<script>alert(Subject Allocation Failed');
             window.location='subjectallocation.php'</script>";
        }
    }

?>
