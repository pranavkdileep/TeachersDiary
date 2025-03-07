<?php
include("../../dboperation.php");
$obj = new dboperation();

if(isset($_POST['save']))
{
    $course=$_POST['ddlcourse'];
    // $sem=$_POST['ddlsemester'];
    // $sub=$_POST['ddlsubject'];
    $mod=$_POST['module'];
    $topic=$_POST['topics'];
    $tid=$_POST['tid'];
    if($course == 19)
    {
            $sub=12;
    }
    elseif($course == 22)
    {
        $sub=13;
    }
    else
    {
        $sub = $_POST['ddlsubject']; 
    }
    $sql="update tblteacherlog set courseid='$course',subjectid='$sub',module='$mod',topic='$topic' where teacherlogid='$tid'";
    $res=$obj->executequery($sql);
    if($res==1)
{
    echo "<script>alert('updated successfully');
            window.location='logbookview.php'</script>";
}
else
{
    echo "<script>alert('insertion failed');
            window.location='logbookview.php'</script>";
}
}
?>