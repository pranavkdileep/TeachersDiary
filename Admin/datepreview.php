<?php
// session_start();
include("header.php");
include_once("../dboperation.php");
$obj = new dboperation();

$tid = $_GET["tid"];
$todate = $_GET["edate"];
$fromdate = $_GET["sdate"];

// Generate a unique token for the session if it doesn't exist
if (!isset($_SESSION['unique_token'])) {
    $_SESSION['unique_token'] = uniqid();
}
$unique_token = $_SESSION['unique_token'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styletable.css">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content {
            flex: 1;
            padding: 20px;
        }

        .table-responsive {
            margin: 20px 0;
        }

        h1,
        h2 {
            text-align: center;
            margin-top: 20px;
            color: blue;
            font-family: Arial, sans-serif;
        }

        h1 {
            font-size: 32px;
            font-weight: bold;
        }

        h2 {
            font-size: 28px;
            font-weight: bold;
        }

        h3 {
            font-size: 24px;
            font-weight: normal;
        }

        .report-summary {
            text-align: center;
            margin-top: 30px;
            font-size: 20px;
            font-weight: bold;
            color: black;
            font-weight: bold;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            margin: 10px;
        }

        textarea {
            width: 100%;
            max-width: 1000px;
        }

        button {
            margin-top: 10px;
        }

        .row {
            margin-left: 100px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="content">
            <?php
            // Fetch the teacher's name based on their ID
            $sql1 = "SELECT * FROM tblteacher WHERE teacherid='$tid'";
            $res1 = $obj->executequery($sql1);
            $teacherName = ""; 
            while ($display1 = mysqli_fetch_array($res1)) {
                $teacherName = $display1["teachername"];
            }

            if ($teacherName != "") {
                // Display the heading with the teacher's name and date range
                echo "<h1>" . $teacherName . "'s Diary Report</h1>";
                echo "<h2>Report Between $fromdate and $todate</h2>";
            }

            // Fetch the teacher log entries
            $sql = "SELECT * FROM tblteacherlog tp 
                    INNER JOIN tblcourse tc ON tp.courseid=tc.courseid 
                    INNER JOIN tblsubject ts ON tp.subjectid=ts.subjectid 
                    WHERE tp.teacherid='$tid' AND tp.submitteddate BETWEEN '$fromdate' AND '$todate' 
                    ORDER BY tp.submitteddate";
            $res = $obj->executequery($sql);
            $row = mysqli_num_rows($res);
            if ($row >= 1) {
                $currentDate = "";
                $noClassCount = 0;
                $courseCount = 0;

                while ($display = mysqli_fetch_array($res)) {
                    if ($currentDate != $display["submitteddate"]) {
                        if ($currentDate != "") {
                            // Close previous table block
                            echo "</tbody></table><br>";
                        }
                        // Start new table block for the current date
                        $currentDate = $display["submitteddate"];
                        $status = $display["status"];
                        $s = 1;
                        echo "<h3>Date: $currentDate</h3>";
                        echo "<div class='table-responsive'>
                              <table class='table text-nowrap mb-0 align-middle styled-table'>
                              <thead>
                                <tr>
                                    <th>Hour</th>
                                    <th>Class/Course</th>
                                    <th>Semester</th>
                                    <th>Subject</th>
                                    <th>Module</th>
                                    <th>Topics</th>
                                    <th>Submitted Date</th>
                                </tr>
                              </thead><tbody>";
                    }

                    // Count "No class" and course hours
                    if ($display['coursename'] == "No class") {
                        $noClassCount++;
                    } else {
                        $courseCount++;
                    }

                    echo "<tr>
                            <td>" . $s++ . "</td>
                            <td>{$display['coursename']}</td>
                            <td>{$display['semester']}</td>
                            <td>{$display['subjectname']}</td>
                            <td>{$display['module']}</td>
                            <td>{$display['topic']}</td>
                            <td>{$display['submitteddate']}</td>
                          </tr>";
                }

                // Close the last table block
                echo "</tbody></table><br>";

                // Display the summary of total hours
                echo "<div class='report-summary'>
                        <h3>Total 'No Classes' Hours: $noClassCount</h3>
                        <h3>Total Course Hours: $courseCount</h3>
                      </div>";

            }

            // Check if status is verified by principal
            ?>
            <form action="verificationaction.php" method="post">
                <input type="hidden" name="teacherid" value="<?php echo $tid; ?>">
                <input type="hidden" name="fromdate" value="<?php echo $fromdate; ?>">
                <input type="hidden" name="todate" value="<?php echo $todate; ?>">
                
                <?php if ($status != "Verified by Principal"): ?>
                    <div class="col-sm-12">
                        <label for="txtremark" class="form-label">Remark</label>
                        <input type="text" name="txtremark" id="txtremark" placeholder="Enter Remarks" class="form-control">
                        <button type="submit" name="submit" class="btn btn-primary">Approve</button>
                        <button type="submit" name="reject" class="btn btn-danger">Reject</button>
                    </div>
                <?php else: ?>
                    <h4 style="text-align:center;     color:green; font-weight:bold;"> Verified</h4>
                <?php endif; ?>
            </form>
        </div>
    </div>
    <?php include("footer.php"); ?>
    <script src="../jquery-3.6.0.min.js"></script>
</body>

</html>
