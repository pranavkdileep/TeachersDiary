<?php
include_once("../../dboperation.php");
$obj = new dboperation();

if(isset($_POST["save"])) {
    $studentname = $_POST["txtstudentname"];
    $parentemail = $_POST["txtprentemail"];
    $parentphone = $_POST["txtparentphone"];
    $departmentid = $_POST["txtdepartmentid"];
    $universityid = $_POST["txtuniversityid"];
    $semester = $_POST["ddlsemester"]; // Added semester from form
    
    // Check if student already exists
    $sql = "SELECT * FROM tblstudent WHERE universityid='$universityid'";
    $res = $obj->executequery($sql);
    $rows = mysqli_num_rows($res);
    
    if($rows > 0) {
        echo "<script>alert('Student with this University ID already exists.');
        window.location='studentreg.php'</script>";
    } else {
        // Insert into tblstudent table with the provided schema
        $sql = "INSERT INTO tblstudent(universityid, studentname, parentemail, phone, departmentid, semester) 
                VALUES ('$universityid', '$studentname', '$parentemail', '$parentphone', '$departmentid', '$semester')";
        
        $res = $obj->executequery($sql);
        
        if($res == 1) {
            // Get department name for email (assuming there's a department table)
            $dept_sql = "SELECT departmentname FROM tbldepartment WHERE departmentid = '$departmentid'";
            $dept_res = $obj->executequery($dept_sql);
            $dept_row = mysqli_fetch_array($dept_res);
            $dname = $dept_row['departmentname'] ?? "Unknown Department";

            // $bodyContent = "Dear $studentname, You are successfully registered as a student at University College of Engineering in $dname department....
            // University ID: $universityid
            // Semester: $semester";

            // $mailtoaddress = $parentemail;
            
            // require('phpmailer.php');

            echo "<script>alert('Student registered successfully.');
            window.location='studentreg.php'</script>";
        } else {
            echo "<script>alert('Registration failed.');
            window.location='studentreg.php'</script>";
        }
    }
}
?>