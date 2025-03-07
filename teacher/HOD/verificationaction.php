<?php
session_start();
// include("header.php");
include_once("../../dboperation.php");
$obj = new dboperation();

if (isset($_POST['submit'])) {
    $tid = $_POST["teacherid"];
    $remark = $_POST["txtremark"];
    $fromdate = $_POST["fromdate"];
    $todate = $_POST["todate"];

    // Insert remark
    echo $sql = "INSERT INTO tblremark (fdate, tdate, hodremark, principalremark, teacherid) 
            VALUES ('$fromdate', '$todate', '$remark', 'NULL', '$tid')";
    $res = $obj->executequery($sql);

    if ($res == 1) {
        // Update status in tblteacherlog
        $sql1 = "UPDATE tblteacherlog 
                 SET status = 'Forward to Principal' 
                 WHERE submitteddate BETWEEN '$fromdate' AND '$todate' 
                 AND teacherid = '$tid'";
        $res1 = $obj->executequery($sql1);

        if ($res1) {
            echo "<script>alert('Approved & Forwarded to principal.');
            window.location='HODverify.php'</script>";
        } else {
            echo "<script>alert('Approval Failed.');
            window.location='HODverify.php'</script>";
        }
    } else {
        echo "<script>alert('Approval Failed.');
        window.location='HODverify.php'</script>";
    }
}

if (isset($_POST['reject'])) {
    $tid = $_POST["teacherid"];
    $remark = $_POST["txtremark"];
    $fromdate = $_POST["fromdate"];
    $todate = $_POST["todate"];
    // Insert remark
    // $sql = "INSERT INTO tblremark (fdate, tdate, hodremark, principalremark, teacherid) 
    //         VALUES ('$fromdate', '$todate', '$remark', 'NULL', '$tid')";
    // $res = $obj->executequery($sql);
        // Update status in tblteacherlog
        $sql1 = "UPDATE tblteacherlog 
                 SET status = 'Rejected by HOD' 
                 WHERE submitteddate BETWEEN '$fromdate' AND '$todate' 
                 AND teacherid = '$tid'";
        $res1 = $obj->executequery($sql1);

        if ($res1) {
            echo "<script>alert('Rejected.');
            window.location='HODverify.php'</script>";
        } else {
            echo "<script>alert('Rejection Failed.');
            window.location='HODverify.php'</script>";
        }
    } else {
        echo "<script>alert('Rejection Failed.');
        window.location='HODverify.php'</script>";
    }
?>
