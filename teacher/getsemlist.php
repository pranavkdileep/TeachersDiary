<?php
include("../dboperation.php");
$obj = new dboperation();

$did = $_POST["courseid"];
$sql = "SELECT semesterno FROM tblcourse WHERE courseid='$did'";
$res = $obj->executequery($sql);
// echo $res;
// Initialize an array to hold all semesters
// $semesters = [];
while($row = mysqli_fetch_array($res)) {
    $semesters = $row["semesterno"];
}
?>
<select id="ddlsemester" required>
    <option value="" selected disabled>---select---</option>
    <?php
    for($i = 1; $i <= $semesters; $i++) {
        // Append 'S' to the value of $i and display the semester
        $semesterValue = 'S' . $i;
    ?>  
        <option value="<?php echo $semesterValue; ?>">
            <?php echo  $semesterValue; ?>
        </option>
    <?php
    }
    ?>
</select>
