<?php
include 'excel_controller.php';
$logbook = new DBController();
$did = $_POST['dname'];
$productResult = $logbook->runQuery("SELECT 
tc.teacherid,
tc.teachername,
tc.teacheremail,
tc.teacherphone,
tc.teacherusername,
tc.teacherpassword,
tc.teacherrole,
tp.departmentname
FROM tbldepartment tp 
INNER JOIN tblteacher tc ON tp.departmentid = tc.departmentid WHERE tp.departmentid = '$did'");

  
    $filename = "Export_doctorexcel.xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $isPrintHeader = false;
    if (! empty($productResult)) {
        foreach ($productResult as $row) {
            if (! $isPrintHeader) {
                echo implode("\t", array_keys($row)) . "\n";
                $isPrintHeader = true;
            }
            echo implode("\t", array_values($row)) . "\n";
        }
    }
    exit();

?>