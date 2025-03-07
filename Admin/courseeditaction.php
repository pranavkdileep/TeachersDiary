<?php
include("../dboperation.php");
include("header.php");
$obj=new dboperation();
//$id= $_GET['id'];
if(isset($_POST['save'])){
    $cname=$_POST["txtcoursename"];
    $cid=$_POST["id"];
    $csem=$_POST["txtsemester"];
    $sql="UPDATE tblcourse SET coursename='$cname',semesterno='$csem' where courseid='$cid'";
    $res=$obj->executequery($sql);
        if($res==1)
        {
            echo "<script>alert('Saved successfully.');
            window.location='courseview.php'</script>";
        }
        else
        {
            echo "<script>alert('Registration failed.');
            window.location='courseview.php'</script>";
        }
    }
?>
