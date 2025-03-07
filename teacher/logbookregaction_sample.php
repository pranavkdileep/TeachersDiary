<?php
session_start();
// Include database connection file
include("../dboperation.php");
$obj = new dboperation();

// Check if form data is submitted
if (isset($_POST["save"])) {
    // Retrieve form data
    $courses = $_POST['ddlcourse'];
    $subjects = $_POST['ddlsubject'];
    $semester = $_POST['ddlsemester'];
    $modules = $_POST['module'];
    $topics = $_POST['topics'];
    $subdate = $_POST["txtdate"];
    $tid = $_SESSION["teacherid"];

    $k = 0; // Counter for subjects array

    // Initialize a flag to check if all inserts are successful
    $all_successful = true;

    // Loop through each row of form data and insert into the database
    for ($i = 0; $i < 6; $i++) {
        // Retrieve data for the current row
        $hour = $i + 1;
        $course = $courses[$i];

        // Check if no course was selected
        if ($course == 0) {
            $course = 19; // Set "No class" course value
            $subject = 12; // Corresponding "No class" subject value

        } else if ($course == 19) {
            // If course is already "No class", set the subject accordingly
            $subject = 12;
            $sem = "Null";

        } else if ($course == 22) {
            // If course is "Open Course", set the corresponding subject
            $subject = 13;
            $sem = "Null";
        } else {
            // For other courses, use the subject from the array
            $subject = $subjects[$k];
            $sem=$semester[$k];
            $k++; // Increment the counter for subjects
        }

        // Retrieve module and topic, and set default values if empty
        $module = !empty($modules[$i]) ? $modules[$i] : 'free';
        $topic = !empty($topics[$i]) ? $topics[$i] : 'free';
        // $sem= !empty($semester[$i]) ? $semester[$i] : 'free';
        // Insert data into the database
        echo $sql = "INSERT INTO tblteacherlog (hour, courseid,semester, subjectid, module, topic, teacherid, submitteddate, status) 
                VALUES ('$hour', '$course','$sem', '$subject', '$module', '$topic', '$tid', '$subdate', 'Submitted')";
        $result = $obj->executequery($sql); // Assuming executequery() method handles database execution

        // If any insert fails, set the flag to false
        if (!$result) {
            $all_successful = false;
        }
    }

    // Check if all queries were successful
    if ($all_successful) {
        echo "<script>alert('Saved successfully.');
        window.location='logbookview.php'</script>";
    } else {
        // echo "<script>alert('Submission failed');
        // window.location='logbookreg.php'</script>";
    }
}
?>