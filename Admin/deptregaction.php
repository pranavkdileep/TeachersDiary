<?php
include_once("../dboperation.php");
$obj=new dboperation();
if(isset($_POST["save"]))
{
    $dname=$_POST["DepartmentName"];
    $sql="SELECT * FROM tbldepartment WHERE departmentname='$dname'";
    $res=$obj-> executequery($sql);
    $rows= mysqli_num_rows($res);
    if($rows> 0)
    {
        echo "<script>alert('Already Exists.');
        window.location='deptreg.php'</script>";
    }
    else
    {
        $sql="INSERT INTO tbldepartment(departmentname) VALUES ('$dname')";
        $res=$obj->executequery($sql);
        if($res==1)
        {
            echo "<script>alert('Saved successfully.');
            window.location='deptview.php'</script>";
        }
        else
        {
            echo "<script>alert('Registration failed.');
            window.location='deptreg.php'</script>";
        }
    }
}
?>
