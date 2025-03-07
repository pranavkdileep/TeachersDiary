<?php
include("../dboperation.php");
include("header.php");
$obj=new dboperation();
// $id= $_GET['id'];
if(isset($_POST["save"])){
    $dname=$_POST["txtacademicyear"];
    $did=$_POST["id"];
    $status=$_POST["txtstatus"];
    $sql="UPDATE tblacademicyear SET academicyear='$dname',status='$status' where academicid='$did'";
    $res=$obj->executequery($sql);
        if($res==1)
        {
            echo "<script>alert('Saved successfully.');
            window.location='academicyearview.php'</script>";
        }
        else
        {
            echo "<script>alert('Registration failed.');
            window.location='academicyearview.php'</script>";
        }
    }
?>