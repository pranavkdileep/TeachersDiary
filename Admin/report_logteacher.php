<?php
session_start();
include("../dboperation.php");
$obj = new dboperation();
$s = 1;

if (isset($_POST["did"])) {
    $did = $_POST["did"];
} else {
    exit("No department ID provided");
}

// Ensure the unique token is set in the session
if (!isset($_SESSION['unique_token'])) {
    header("Location: login.php");
    exit();
}
$unique_token = $_SESSION['unique_token'];

$sql = "SELECT 
            tc.teacherid,
            tc.teachername,
            tc.teacheremail,
            tc.teacherphone,
            tc.teacherusername,
            tc.teacherpassword,
            tc.teacherrole,
            tp.departmentname
        FROM tbldepartment tp 
        INNER JOIN tblteacher tc ON tp.departmentid = tc.departmentid 
        WHERE tp.departmentid = '$did'";
$res = $obj->executequery($sql);

// Output the table rows
while ($display = mysqli_fetch_array($res)) {
    ?>
 
        <table>
            <tbody>
                <tr>
                    <td class="border-bottom-0">
                        <h6 class="fw-semibold mb-0"><?php echo $s++ ?></h6>
                    </td>

                    <td class="border-bottom-0">
                        <h6 class="fw-semibold mb-1"><?php echo $display["teachername"]; ?></h6>
                    </td>

                    <td class="border-bottom-0">
                        <a class="viewlog-link"
                            href="report_logpreview.php?id=<?php echo $display['teacherid']; ?>&token=<?php echo $unique_token; ?>">viewlog</a>

                    </td>
                </tr>
            </tbody>
        </table>
        <?php
}
?>
