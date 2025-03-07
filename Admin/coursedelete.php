<?php
include("../dboperation.php");
$obj=new dboperation();
$id=$_GET['id'];
$sql="DELETE FROM tblcourse WHERE courseid='$id'";
$res=$obj->executequery($sql);
echo $sql;
if($res==1){
    echo "<script>alert('Deleted successfully.');
    window.location='courseview.php'</script>";
}
else{
    echo "<script>alert('Deletion failed.');
            window.location='courseview.php'</script>";
}
?>
