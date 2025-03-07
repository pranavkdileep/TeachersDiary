<?php
session_start();
include_once("../dboperation.php");
$obj = new dboperation();


    // Retrieve the arrays of subject IDs and teacher IDs
    $subjectIds = $_POST['subjectid'];
    $teacherIds = $_POST['ddlteacher'];

    // Loop through each pair of subject ID and teacher ID to insert into the database
    for ($i = 0; $i < count($subjectIds); $i++)
     {
        $subjectId = $subjectIds[$i];
        $teacherId = $teacherIds[$i];

        // Insert into the database
        $sql = "INSERT INTO subject_teacher (subjectid, teacherid,status) VALUES ('$subjectId', '$teacherId',0)";
        $result = $obj->executequery($sql);

        // Check if insertion was successful
        if ($result) {
            echo "Data inserted successfully for Subject ID: $subjectId and Teacher ID: $teacherId<br>";
        } else {
            echo "Error inserting data for Subject ID: $subjectId and Teacher ID: $teacherId<br>";
        }
    }

?>
