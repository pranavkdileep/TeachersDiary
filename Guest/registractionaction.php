<?php
include_once("../dboperation.php");
$obj=new dboperation();
if(isset($_POST["save"]))
{
    // $dname=$_POST["dname"];
    $tname=$_POST["txtfacultyname"];
    $did=$_POST["ddldeptname"];
    $email=$_POST["txtemail"];
    $phone=$_POST["txtphone"];
    $username=$_POST["txtusername"];
    $password=$_POST["txtpassword"];
    $role=$_POST["txtrole"];
    echo $sql="SELECT * FROM tblteacher WHERE teacherusername='$username'";
    $res=$obj-> executequery($sql);
    $rows= mysqli_num_rows($res);
    $sql2="select departmentname from tbldepartment where departmentid='$did'";
    $res1=$obj-> executequery($sql2);
    $rows1= mysqli_fetch_array($res1);
    $dname=$rows1['departmentname'];
    // echo $dname;
    // echo $rows;
    if($rows> 0)
    {
        echo "<script>alert('Already Exists.');
        window.location='login.php'</script>";
    }
    else
    {
      echo  $sql="INSERT INTO tblteacher(teachername,teacheremail,teacherphone,teacherusername,teacherpassword,teacherrole,departmentid,isverified) VALUES ('$tname','$email','$phone','$username','$password','$role','$did',false)";
        $res=$obj->executequery($sql);
        if($res==1)
        {
          $bodyContent="Dear $tname, You are successfully registred as a $role at university College of engineering in $dname department....
          Username : $username 
          Password : $password";

          $mailtoaddress=$email;
          
          // $bodyContent="Dear $name, Your account has been successfully created, Please login using the username $opno";
          // $mailtoaddress=$email;
          require('phpmailer.php');

        echo "<script>alert('Saved successfully.');
          window.location='login.php'</script>";
        }
        else
        {
        echo "<script>alert('Registration failed.');
           window.location='login.php'</script>";
        }
     }
}
?>
