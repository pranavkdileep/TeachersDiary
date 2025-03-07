<?php
include("../dboperation.php");
$obj=new dboperation();
//To check valuepassed in url



$did = $_POST['did'];

$sql = "SELECT * FROM tblcourse WHERE departmentid='$did'";
$res = $obj->executequery($sql);
?>
<select name="ddlcoursename" id="ddlcoursename" required>
<option value="" selected disabled>---select---</option>
<?php
while ($display = mysqli_fetch_array($res)) {
?>  
    <option value="<?php echo $display['courseid']; ?>">
    <?php echo $display['coursename']; ?></option>
   
<?php
}
?>
 </select>
