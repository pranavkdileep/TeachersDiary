<?php
function generateRandomString($length = 10) 
{
   $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $randomString = substr(str_shuffle($characters), 0, $length);

   return $randomString;
}
?>

<?php
include_once("../dboperation.php");
$obj=new dboperation();
$uname=$_POST["txtusername"];

$sql="select * from tblteacher where teacherusername='$uname'";
$result=$obj->executequery($sql);
$display=mysqli_fetch_array($result);
$row=mysqli_num_rows($result);


if($row == 0 && $row1 == 0) 
{
    echo "<script>alert('Entered username is wrong....');window.location='forgotpass.php' </script>"; 
}

else
{
    if ($row > 0) {
        $randomString = generateRandomString();
        $sql2 = "update tblteacher set teacherpassword='$randomString' where teacherusername='$uname'";
        $result = $obj->executequery($sql2);
        echo "<script>alert('Your password has been successfully reset. A new password has been sent to your email. Please check your inbox.');window.location='login.php' </script>";
        $bodyContent = "Dear $uname, Your New Password is: $randomString";
        $mailtoaddress = $display["teacheremail"];
        require('phpmailer.php');
    } 
}
?>