<?php
include_once("../dboperation.php");
$obj=new dboperation();
if(isset($_POST["save"]))
{
   $did=$_POST["ddldeptname"];
    $cname=$_POST["txtcoursename"];
    $csem=$_POST["ddlsemester"];
    $sql="SELECT * FROM tblcourse WHERE coursename='$cname'";
    $res=$obj-> executequery($sql);
    $rows= mysqli_num_rows($res);
    if($rows> 0)
    {
        echo "<script>alert('Already Exists.');
        window.location='coursereg.php'</script>";
    }
    else
    {
      echo $sql="INSERT INTO tblcourse(coursename,departmentid,semesterno)VALUES('$cname','$did','$csem')";
       echo $sql;
        $res=$obj-> executequery($sql);
        if($res==1)
        {
            echo "<script>alert('Saved successfully.');
            window.location='courseview.php?dept=$did'</script>";

            
        }
        else
        {
           echo "<script>alert('Registration failed.');
            window.location='courseview.php'</script>";


        }
    }
}
?>
