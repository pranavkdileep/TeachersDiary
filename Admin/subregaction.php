<?php
include_once("../dboperation.php");
$obj=new dboperation();
if(isset($_POST["save"]))
{
    $sname=$_POST["txtsubjectname"];
    $cid=$_POST["ddlcoursename"];
    $sem=$_POST["ddlsemester"];
    $sql="SELECT * FROM tblsubject WHERE subjectname='$sname'";
    $res=$obj-> executequery($sql);
    $rows= mysqli_num_rows($res);
    if($rows> 0)
    {
        echo "<script>alert('Already Exists.');
        window.location='subreg.php'</script>";
    }
    else
    {
        $sql="INSERT INTO tblsubject(subjectname,courseid,semester) VALUES ('$sname','$cid','$sem')";
        $res=$obj->executequery($sql);
        if($res==1)
        {
            echo "<script>alert('Saved successfully.');
            window.location='subreg.php'</script>";
        }
        else
        {
            echo "<script>alert('Registration failed.');
            window.location='subreg.php'</script>";
        }
    }
}
?>
