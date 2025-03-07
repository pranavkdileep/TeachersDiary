<?php
include("../dboperation.php");
include("header.php");
$obj=new dboperation();
// $id= $_GET['id'];
if(isset($_POST['save'])){
    $sname=$_POST["txtsemestername"];
    $sid=$_POST["id"];
    $sql="UPDATE tblsemester SET semestername='$sname' where semesterid='$sid'";
    $res=$obj->executequery($sql);
        if($res==1)
        {
            echo "<script>alert('Saved successfully.');
            window.location='semesterview.php'</script>";
        }
        else
        {
            echo "<script>alert('Registration failed.');
            window.location='semesterview.php'</script>";
        }
    }
?>
