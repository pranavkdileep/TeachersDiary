<?php
include("../dboperation.php");
include("header.php");
$obj=new dboperation();
// $id= $_GET['id'];
if(isset($_POST["save"])){
    $dname=$_POST["txtdeptname"];
    $did=$_POST["id"];
    $sql="UPDATE tbldepartment SET departmentname='$dname' where departmentid='$did'";
    $res=$obj->executequery($sql);
        if($res==1)
        {
            echo "<script>alert('Saved successfully.');
            window.location='deptview.php'</script>";
        }
        else
        {
            echo "<script>alert('Registration failed.');
            window.location='deptview.php'</script>";
        }
    }
?>