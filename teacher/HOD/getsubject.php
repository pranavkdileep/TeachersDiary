<?php
session_start();
include("../../dboperation.php");
$obj=new dboperation();
$cid=$_POST['courseid'];
$id = $_POST['semno'];
$sql = "SELECT * FROM subject_teacher st inner join tblsubject ts ON st.subjectid=ts.subjectid WHERE st.semester='$id' and ts.courseid='$cid' and st.teacherid=".$_SESSION['teacherid'];
$res = $obj->executequery($sql);
?>
<select id="ddlsubject" name="ddlsubject" required>
<option value="" selected>---select---</option>
<?php
while ($display = mysqli_fetch_array($res)) {
?>  
    <option value="<?php echo $display['subjectid']; ?>">
    <?php echo $display['subjectname']; ?></option>  
<?php
}
?>
 </select>
