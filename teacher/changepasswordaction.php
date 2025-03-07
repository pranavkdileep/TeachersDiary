<?php
session_start();
include_once ("../dboperation.php");
$obj = new dboperation();
 $sql="select * from tblteacher where teacherid=".$_SESSION['teacherid'];
$result=$obj->executequery($sql);
$display=mysqli_fetch_array($result);


$pass=$_POST["txtpassword"];
$newpwd=$_POST["txtnewpassword"];

if($pass==$display["teacherpassword"])
{
     $sql1="update tblteacher set teacherpassword='$newpwd' where teacherid=".$_SESSION['teacherid'];
    $result1=$obj->executequery($sql1);

    if($result1==1)
    {
        echo "<script>alert('Password Changed Successfully....');window.location='index.php' </script>"; 
    }
}

else
{
     echo "<script>alert('Entered current password is wrong....');window.location='index.php' </script>"; 
}
?>