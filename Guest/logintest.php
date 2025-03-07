<?php
session_start();
$username = $_POST["txtusername"];
$password = $_POST["txtpassword"];
require_once ("../dboperation.php");
$obj = new dboperation();

$sqlquery = "select * from tbllogin where username='$username' and password='$password'";
$result = $obj->executequery($sqlquery);


if (mysqli_num_rows($result) == 1) 
{
   header("location:..\Admin\index.php");
} 
else if (mysqli_num_rows($result) == 0)

{
    $sqlquery = "select * from tblstudent where username='$username' and password='$password'";
    $result = $obj->executequery($sqlquery);


    if (mysqli_num_rows($result) == 1) 
     {
        $row=mysqli_fetch_array($result);
        $_SESSION["username"]=$username;
        $_SESSION["studentid"]= $row["studentid"];
        header("location:..\student\studenthome.php");
     }
else
{

    echo "<script>alert('Invalid Username/Password!!'); window.location='login.php'</script>";
    
}
} 
?>