<?php
include_once("../dboperation.php");
$obj=new dboperation();
if(isset($_POST["save"]))
{
   $cid=$_POST["ddlcoursename"];
    $sname=$_POST["txtsemestername"];
    $sql="SELECT * FROM tblsemester WHERE semestername='$sname' and courseid=$cid";
    $res=$obj-> executequery($sql);
    $rows= mysqli_num_rows($res);
    if($rows> 0)
    {
        echo "<script>alert('Already Exists.');
        window.location='semesterreg.php'</script>";
    }
    else
    {
       $sql="INSERT INTO tblsemester(semestername,courseid)VALUES('$sname','$cid')";
       echo $sql;
        $res=$obj-> executequery($sql);
        if($res==1)
        {
            echo "<script>alert('Saved successfully.');
           window.location='semesterview.php'</script>";
        }
        else
        {
           echo "<script>alert('Registration failed.');
            window.location='semesterreg.php'</script>";
        }
    }
}
?>
