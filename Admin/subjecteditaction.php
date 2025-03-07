<?php
    include("../dboperation.php");
    include("header.php");
    $obj=new dboperation();
if(isset($_POST['save']))
//$sid=$_POST['subjectid']
    $sname=$_POST["txtsubjectname"];
    $sid=$_POST["id"];
    $sql="update tblsubject set subjectname='$sname' where subjectid='$sid'";
    $res=$obj->executequery($sql);
if($res==1)
{
    echo "<script>alert('inserted successfully');
            window.location='subjectview.php'</script>";
}
else
{
    echo "<script>alert('insertion failed');
            window.location='subjectview.php'</script>";
}
?>