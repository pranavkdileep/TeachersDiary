<?php
// session_start();
include("header.php");
include_once("../../dboperation.php");
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
    <title>Styled Table</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="styletable.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
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
            color: #007bff;
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
            color: green;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-custom {
            margin: 10px;
        }

        textarea {
            width: 100%;
            max-width: 1000px;
        }

        button {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="content">
            <?php
            // Fetch the teacher's name based on their ID
            $sql1 = "SELECT teachername FROM tblteacher WHERE teacherid='$tid'";
            $res1 = $obj->executequery($sql1);
            $teacherName = ""; // Initialize teacherName variable
            while ($display1 = mysqli_fetch_array($res1)) {
                $teacherName = $display1["teachername"]; // Store the teacher's name
            }

            if ($teacherName != "") {
                // Print the combined heading with teacher's name and date range
                echo "<h1>" . htmlspecialchars($teacherName) . "'s Diary Report</h1>";
                echo "<h2>Report Between " . htmlspecialchars($fromdate) . " and " . htmlspecialchars($todate) . "</h2>";
            }
            ?>

            <?php
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
                            // Close the previous table block if it exists
                            echo "</tbody></table><br>";
                        }
                        // Set the new current date and start a new table block
                        $currentDate = $display["submitteddate"];
                        $status = $display["status"];
                        $s = 1;  // Reset hour counter for new date block
                        echo "<h3>Date: $currentDate</h3>";
                        echo "<div class='table-responsive'><table class='table table-bordered table-striped mb-0'><thead>
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

                    if ($display['coursename'] == "No class") {
                        $noClassCount++;
                    } else {
                        $courseCount++;
                    }

                    echo "<tr>
                            <td>" . $s++ . "</td>
                            <td>" . htmlspecialchars($display['coursename']) . "</td>
                            <td>" . htmlspecialchars($display['semester']) . "</td>
                            <td>" . htmlspecialchars($display['subjectname']) . "</td>
                            <td>" . htmlspecialchars($display['module']) . "</td>
                            <td>" . htmlspecialchars($display['topic']) . "</td>
                            <td>" . htmlspecialchars($display['submitteddate']) . "</td>
                          </tr>";
                }
                // Close the last table block
                echo "</tbody></table><br>";

                // Display total counts with aligned design
                echo "<div class='report-summary'><h3>Total Free Classes Hours: " . htmlspecialchars($noClassCount) . "</h3>";
                echo "<h3>Total Class Hours: " . htmlspecialchars($courseCount) . "</h3></div>";
                ?>
                <form action="verificationaction.php" method="post">
                    <input type="hidden" name="teacherid" value="<?php echo $tid; ?>">
                    <input type="hidden" name="fromdate" value="<?php echo $fromdate; ?>">
                    <input type="hidden" name="todate" value="<?php echo $todate; ?>">
                    <?php if ($status != "Verified by Principal" && $status != "Forward to Principal"): ?>
                        <div class="container">
                            <div class="mb-3">
                                <label for="txtremark" class="form-label">Remark</label>
                                <textarea name="txtremark" id="txtremark" rows="4" placeholder="Enter Remarks"
                                    class="form-control"></textarea>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" name="submit" class="btn btn-primary btn-custom">Approve</button>
                                <button type="submit" name="reject" class="btn btn-danger btn-custom">Reject</button>
                            </div>
                        </div>
                    <?php else: ?>
                        <br>
                        <h4 style="text-align:center; color:green; font-weight:bold;">Verified</h4>
                    <?php endif; ?>
                </form>
                <?php
            } 
            ?>
        </div>
    </div>
    <?php include("footer.php"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>