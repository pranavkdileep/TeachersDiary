<?php
include_once("../../dboperation.php");
$obj = new dboperation();

if(isset($_POST["save"])) {
    // Get form data
    $universityid = $_POST["universityid"];
    $studentname = $_POST["txtstudentname"];
    $parentemail = $_POST["txtparentemail"];
    $phone = $_POST["txtphone"];
    $departmentid = $_POST["ddldeptname"];
    $semester = $_POST["txtsemester"];

    // Update query
    $sql = "UPDATE tblstudent SET 
            studentname = '$studentname',
            parentemail = '$parentemail',
            phone = '$phone',
            departmentid = '$departmentid',
            semester = '$semester'
            WHERE universityid = '$universityid'";
    
    $res = $obj->executequery($sql);
    
    if($res == 1) {
        // Get department name for success message (optional)
        // $dept_sql = "SELECT departmentname FROM tbldepartment WHERE departmentid = '$departmentid'";
        // $dept_res = $obj->executequery($dept_sql);
        // $dept_row = mysqli_fetch_array($dept_res);
        // $dname = $dept_row['departmentname'] ?? "Unknown Department";

        // // Optional: Send email notification
        // $bodyContent = "Dear $studentname, Your student profile has been successfully updated at University College of Engineering in $dname department....
        // University ID: $universityid
        // Semester: $semester
        // Parent Email: $parentemail
        // Phone: $phone";

        // $mailtoaddress = $parentemail;
        
        // Uncomment the following line if you want to send email
        // require('phpmailer.php');

        echo "<script>alert('Student details updated successfully.');
        window.location='student.php'</script>";
    } else {
        echo "<script>alert('Failed to update student details.');
        window.location='student.php'</script>";
    }
} else {
    // If someone tries to access this page directly without form submission
    echo "<script>alert('Invalid access.');
    window.location='student.php'</script>";
}
?>