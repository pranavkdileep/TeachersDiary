<?php
include("../dboperation.php");
include("header.php");  
$obj=new dboperation();
//$id= $_GET['id'];
if(isset($_POST['save'])){
    $tname=$_POST["txtfacultyname"];
    $temail=$_POST["txtemail"];
    $tphno=$_POST["txtphone"];
    $trole=$_POST["txtrole"];
    $tid=$_POST["id"];
    $sql="UPDATE tblteacher SET teachername='$tname',teacheremail='$temail',teacherphone='$tphno',teacherrole='$trole' where teacherid='$tid'";
    $res=$obj->executequery($sql);
        if($res==1)
        {
            echo "<script>alert('Saved successfully.');
            window.location='teacherview.php'</script>";
        }
        else
        {
            echo "<script>alert('Registration failed.');
            window.location='courseview.php'</script>";
        }
    }
?>
