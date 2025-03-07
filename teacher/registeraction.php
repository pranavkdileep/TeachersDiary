<?php
    include("header.php");
    include("../dboperation.php");
    $obj= new dboperation();
    // $s=1;
    if(isset($_POST['save']))
{
    $sub=$_POST['subject'];
    $module=$_POST['module'];
    $topic=$_POST['topic'];
    // $sql="SELECT * FROM tbl_product WHERE product_name='$name'";
    // $res=$obj->executequery($sql);
    // $rows= mysqli_num_rows($res);
    // if($rows> 0)
    // {
    //     echo "<script>alert('Already Exists.');
    //     window.location='proreg.php'</script>";
    // }
    // else
    // {
        $sql="INSERT INTO tbl_sub(subject,module,topic) VALUES ('$sub','$module','$topic')";
        $res=$obj->executequery($sql);
        if($res==1)
        {
            echo "<script>alert('Saved successfully.');
            window.location='registerview.php'</script>";
        }
        else
        {
            echo "<script>alert('Registration failed.');
            window.location='register.php'</script>";
        }
    }
// }
// else
// {
//     echo "not post";
// }
?>
