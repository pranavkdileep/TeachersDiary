<?php
session_start();
include("../../dboperation.php");
$obj = new dboperation();
$s = 1;

$sid = $_POST["semester"];
$cid = $_POST["courseid"];
?>

<table id="styled-table">
    <tbody>
        <?php
        // Query to fetch subject-teacher allocation details
        $sql = "SELECT st.subteacherid, ts.subjectname, tt.teachername, ts.subjectid, tt.teacherid, ts.courseid 
                FROM subject_teacher st
                INNER JOIN tblsubject ts ON st.subjectid = ts.subjectid
                INNER JOIN tblteacher tt ON st.teacherid = tt.teacherid
                WHERE st.semester = '$sid' AND ts.courseid = '$cid'";
        $res = $obj->executequery($sql);

        // Display each subject-teacher allocation
        while ($display = mysqli_fetch_array($res)) {
            ?>
            <tr>
                <td><?php echo $s++; ?></td>
                <td><?php echo $display["subjectname"]; ?></td>
                <td><?php echo $display["teachername"]; ?></td>
                <td>
                    <a href="allocationeditview.php?id=<?php echo $display['teacherid']; ?>&cid=<?php echo $display['courseid']; ?>&sid=<?php echo $display['subjectid']; ?>&stid=<?php echo $display['subteacherid']; ?>">
                        <button type="button" class="btn btn-success">Edit</button>
                    </a>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
