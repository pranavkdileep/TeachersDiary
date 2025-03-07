<?php
// Include database connection file
include("../../dboperation.php");
$obj = new dboperation();
session_start();
$k=0;
// Check if form data is submitted
if(isset($_POST["save"]))
 {
    // Retrieve form data
    $courses = $_POST['ddlcourse'];
    $subjects = $_POST['ddlsubject'];
    $modules = $_POST['module'];
    $semester=$_POST['ddlsemester'];
    $topics = $_POST['topics'];
    $subdate = $_POST["txtdate"];
    $tid = $_SESSION["teacherid"];
print_r($subjects);
    // Initialize a flag to check if all inserts are successful
    $all_successful = true;
   // $j=0;
    // Loop through each row of form data and insert into the database
    for ($i = 0; $i <6; $i++) 
    {
        // Retrieve data for the current row
        $hour = $i + 1;
        $course = $courses[$i];
         // If course ID is 19, set subject to 0
         if ($course == 19) {
            $subject = 12;
             $sem="Null";
        }
        else if($course == 22)
        {
              $subject = 13;
              $sem="Null";
        }
        else
        {
        $subject = $subjects[$k];
       $k=$k+1;
        }
       // print_r($subject);
        $sem=$semester[$i];
        $module = $modules[$i];
        $topic = $topics[$i];

        // Insert data into the database
       $sql = "INSERT INTO tblteacherlog (hour, courseid,semester, subjectid, module, topic, teacherid, submitteddate, status) 
                VALUES ('$hour', '$course','$sem', '$subject', '$module', '$topic', '$tid', '$subdate', 'Submitted')";
//$j=$j+1;
        $result = $obj->executequery($sql); // Assuming executequery() method handles database execution

        // If any insert fails, set the flag to false
    }

    // Check if all queries were successful
    if ($result) {
        echo "<script>alert('Saved successfully.');
        window.location='logbookview.php'</script>";
    } else {
        // echo "<script>alert('Submission failed');
        // window.location='logbookreg.php'</script>";
    }
}
?>
