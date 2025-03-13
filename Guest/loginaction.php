<?php
session_start();
$username = $_POST["username"];
$password = $_POST["password"];
require_once ("../dboperation.php");
$obj = new dboperation();

$sqlquery = "select * from login_tbl where username='$username' and pass='$password'";
$result = $obj->executequery($sqlquery);


if (mysqli_num_rows($result) == 1) 
{   
    $row=mysqli_fetch_array($result);
    $_SESSION['aid']=$row['id'];
    $_SESSION['unique_token'] = uniqid();
   header("location:..\Admin\home.php");
} 
else if (mysqli_num_rows($result) == 0)

{
    $sqlquery = "select * from tblteacher where teacherusername='$username' and teacherpassword='$password' and isverified='1'";
    $result = $obj->executequery($sqlquery);


    if (mysqli_num_rows($result) == 1) 
     {
        $row=mysqli_fetch_array($result);
        $_SESSION["username"]=$username;
        $_SESSION["teacherid"]= $row["teacherid"];
        $_SESSION["deptid"]=$row["departmentid"];
        $_SESSION['unique_token'] = uniqid();
        if($row["teacherrole"]=="HOD")
        {
            echo "<script>alert('Login Successfull'); window.location='../teacher/HOD/HODhome.php'</script>";// header("location:..\teacher\HODhome.php");
        }
        else
        {
            echo "<script>alert('Login Successfull'); window.location='../teacher/index.php'</script>"; // header("location:..\teacher\index.php");
        }
        
     }
else
{

    $sqlquery = "select * from tblteacher where teacherusername='$username' and teacherpassword='$password' and isverified='0'";
    $result = $obj->executequery($sqlquery);
    if (mysqli_num_rows($result) == 1){
        echo "<script>alert('Your Account is not verified'); window.location='../Guest/login.php'</script>";
    }
    else{
        echo "<script>alert('Invalid Username or Password'); window.location='../Guest/login.php'</script>";
    }
}
} 
?>