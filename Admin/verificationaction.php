<?php
include("header.php");
include_once("../dboperation.php");
$obj = new dboperation();

if (isset($_POST['submit'])) {
    $tid = $_POST["teacherid"];
    $remark = $_POST["txtremark"];
    $fromdate = $_POST["fromdate"];
    $todate = $_POST["todate"];

    $sql = "UPDATE tblremark SET principalremark='$remark' WHERE teacherid='$tid' and fdate='$fromdate' and tdate='$todate'";
    $res = $obj->executequery($sql);

    if ($res == 1) {
        $sql1 = "UPDATE tblteacherlog SET status='Verified by Principal' where teacherid='$tid'";
        $res1 = $obj->executequery($sql1);

        if ($res1) {
            echo "<script>
                alert('Approved');
                window.location='Adminpreviewmain.php?id=$tid';
            </script>";
        } else {
            echo "<script>
                alert('Approval Failed.');
                window.location='Adminpreviewmain.php?id=$tid';
            </script>";
        }
    } else {
        echo "<script>
            alert('Approval Failed.');
            window.location='Adminpreviewmain.php?id=$tid';
        </script>";
    }
}

if (isset($_POST['reject'])) {
    $tid = $_POST["teacherid"];
    $remark = $_POST["txtremark"];
    $fromdate = $_POST["fromdate"];
    $todate = $_POST["todate"];

    // Insert remark
        // Update status in tblteacherlog
        $sql1 = "UPDATE tblteacherlog 
                 SET status = 'Rejected by Principal' 
                 WHERE submitteddate BETWEEN '$fromdate' AND '$todate' 
                 AND teacherid = '$tid'";
        $res1 = $obj->executequery($sql1);

        if ($res1) {
            echo "<script>
                alert('Rejected.');
                window.location='Adminpreviewmain.php?id=$tid';
            </script>";
        } else {
            echo "<script>
                alert('Rejection Failed.');
                window.location='Adminpreviewmain.php?id=$tid';
            </script>";
        }
    } else {
        echo "<script>
            alert('Rejection Failed.');
            window.location='Adminpreviewmain.php?id=$tid';
        </script>";
    }
?>
