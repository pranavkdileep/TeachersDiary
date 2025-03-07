<?php
include_once("../dboperation.php");
$obj=new dboperation();
if(isset($_POST["save"]))
{
    $yname=$_POST["txtayear"];
    $sql="SELECT * FROM tblacademicyear WHERE academicyear='$yname'";
    $res=$obj-> executequery($sql);
    $rows= mysqli_num_rows($res);
    if($rows> 0)
    {
        echo "<script>alert('Already Exists.');
        window.location='academicyearview.php'</script>";
    }
    else
    {
      $sql="INSERT INTO tblacademicyear(academicyear,status) VALUES ('$yname','inactive')";
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
}
?>
