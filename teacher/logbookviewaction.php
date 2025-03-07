<?php
session_start();
include("../dboperation.php");
$obj = new dboperation();
$s = 1;
$startdate = $_POST['startdate'];
$enddate = $_POST['enddate'];

// Check if session is set
if (!isset($_SESSION['teacherid'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='login.php';</script>";
    exit();
}

echo "Selected Dates: " . $startdate . " to " . $enddate; // For debugging purposes

// Check if startdate is properly passed
if (empty($startdate) || empty($enddate)) {
    echo "No date selected.";
    exit();
}
?>

<div class="date-blocks">
    <?php 
    // SQL query to fetch records within the date range
    $sql = "SELECT tp.submitteddate, tp.hour, tc.coursename, tc.courseid,ts.subjectid,tp.teacherlogid, ts.semester, ts.subjectname, tp.module, tp.topic, tp.status 
            FROM tblteacherlog tp 
            INNER JOIN tblcourse tc ON tp.courseid = tc.courseid 
            INNER JOIN tblsubject ts ON tp.subjectid = ts.subjectid  
            WHERE tp.submitteddate BETWEEN '$startdate' AND '$enddate' 
            AND tp.teacherid = " . $_SESSION['teacherid'] . "
            ORDER BY tp.submitteddate ASC";

    $res = $obj->executequery($sql);

    // Check if any rows are returned
    if (mysqli_num_rows($res) == 0) {
        echo "<p>No records found for the selected date range.</p>";
    } else {
        $currentDate = '';
        while ($display = mysqli_fetch_array($res)) {
            // Group records by submitted date
            if ($currentDate != $display["submitteddate"]) {
                // If it's a new date, close the previous block if there was one
                if ($currentDate != '') {
                    echo '</tbody></table></div>';
                }

                // Set the current date
                $currentDate = $display["submitteddate"];
                echo "<div class='date-block'>";
                echo "<h4>Date: " . $currentDate . "</h4>";
                echo "<table class='styled-table'>";
                echo "<thead><tr>
                        <th>Hour</th>
                        <th>Class/Course</th>
                        <th>Semester</th>
                        <th>Subject</th>
                        <th>Module</th>
                        <th>Topics</th>
                        <th>Status</th>
                        <th>Edit</th>
                    </tr></thead><tbody>";
            }

            // Disable edit button if status is "Forward to Principal" or "Verified by Principal"
            $editdisabled = ($display["status"] == "Forward to Principal" || $display["status"] == "Verified by Principal") ? "disabled" : "";
            ?>
            <tr>
            <tr>
    <td><?php echo $display["hour"]; ?></td>
    <td><?php echo $display["coursename"]; ?></td>
    <td><?php echo $display["semester"]; ?></td>
    <td><?php echo $display["subjectname"]; ?></td>
    <td><?php echo $display["module"]; ?></td>
    <td><?php echo $display["topic"]; ?></td>
    <td><?php echo $display["status"]; ?></td>

    <?php if ($display["status"] != "Forward to Principal" && $display["status"] != "Verified by Principal"): ?>
        <td>
            <a style="color:white;" href="logbookviewedit.php?id=<?php echo $display['teacherlogid']; ?>&cid=<?php echo $display['courseid']; ?>&sid=<?php echo $display['subjectid']; ?>">
                <button type="button" class="btn btn-success">Edit</button>
            </a>
        </td>
    <?php else: ?>
        <td>NA</td> <!-- Keep an empty <td> to maintain table structure -->
    <?php endif; ?>
</tr>

                </td>
            </tr>
        <?php
        }
        // Close the last table block
        echo '</tbody></table></div>';
    }
    ?>
</div>
