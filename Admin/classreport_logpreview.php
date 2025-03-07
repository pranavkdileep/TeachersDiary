<?php
// session_start();
include("header.php");
include_once("../dboperation.php");
$obj = new dboperation();

// Generate a unique token for the session if it doesn't exist
if (!isset($_SESSION['unique_token'])) {
    $_SESSION['unique_token'] = uniqid();
}
$unique_token = $_SESSION['unique_token'];

// Get the teacher ID from the URL
$tid = $_GET["id"];
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
        }

        .para {
            text-align: center;
            margin: 100px;
        }

        .log-block {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .log-block h2 {
            text-align: center;
            color: #333;
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
            while ($display1 = mysqli_fetch_array($res1)) {
                ?>
                <h1><?php echo $display1["teachername"]; ?>'s Diary Class/No Class Report</h1>
                <?php
            }
            ?>

            <form method="post">
                <label for="exampleInputEmail1" class="form-label">Current Year</label>
                <select name="year" id="year" class="form-select year">
                    <?php
                    $sql = "SELECT * FROM tblacademicyear WHERE status='active'";
                    $res = $obj->executequery($sql);
                    while ($display = mysqli_fetch_array($res)) {
                        $selected_year = isset($_POST['year']) ? $_POST['year'] : '';
                        $selected = ($selected_year == $display["academicyear"]) ? 'selected' : '';
                        echo "<option value='2024' $selected>{$display["academicyear"]}</option>";
                    }
                    ?>
                </select>
                <label for="exampleInputEmail1" class="form-label">Month</label>
                <select name="month" class="form-select month">
                    <?php
                    $selected_month = isset($_POST['month']) ? $_POST['month'] : date("m");
                    for ($m = 1; $m <= 12; $m++) {
                        $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                        $selected = ($selected_month == $m) ? 'selected' : '';
                        echo "<option value='$m' $selected>$month</option>";
                    }
                    ?>
                </select>
                <!-- <label for="exampleInputEmail1" class="form-label">Semester</label>
                <select name="semester" class="form-select ">
                    <option value="">---Select---</option>
                    <?php
                    $sql1="";
                    ?>
                    </select> -->
                <br>
                <button name="save" type="submit" class="btn btn-primary">Submit</button>
            </form>
            <br>

            <?php
            if (isset($_POST['save'])) {
                $year ="2024";
                $month = str_pad($_POST["month"], 2, "0", STR_PAD_LEFT);
                $first_day = "$year-$month-01";
                $last_day = "$year-$month-31"; // Get the last day of the selected month

                // Fetch logs where the status is verified and within the selected month
               $sql_logs = "SELECT * FROM tblteacherlog tp 
                             INNER JOIN tblcourse tc ON tp.courseid=tc.courseid 
                             INNER JOIN tblsubject ts ON tp.subjectid=ts.subjectid 
                             WHERE tp.teacherid='$tid' 
                             AND tp.status='Verified by Principal'
                             AND tp.submitteddate BETWEEN '$first_day' AND '$last_day'";
                $res_logs = $obj->executequery($sql_logs);
                $row_count = mysqli_num_rows($res_logs);

                if ($row_count > 0) {
                    $noClassCount = 0;
                    $courseCount = 0;

                    while ($display = mysqli_fetch_array($res_logs)) {
                        // Count hours based on whether it's a class or a "No class" entry
                        if (strtolower($display['coursename']) == "no class") {
                            $noClassCount++;
                        } else {
                            $courseCount++;
                        }
                    }
                    // Display the counts
                    echo "<div class='log-block'>
                            <h2>Total Hours in " . date('F', mktime(0, 0, 0, $month, 1)) . " $year</h2>
                            <p><strong>Class Hours:</strong> $courseCount</p>
                            <p><strong>Free-Class Hours:</strong> $noClassCount</p>
                          </div>";
                } else {
                    echo "<div class='para'><strong>No records found for the selected month.</strong></div>";
                }
            }
            ?>
        </div>
    </div>

    <?php include("footer.php"); ?>

    <script src="../jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#ddldepartment").change(function () {
                var did = $(this).val();
                var unique_token = '<?php echo $unique_token; ?>'; // Get the unique token from PHP
                $.ajax({
                    type: "POST",
                    url: "getteacher.php",
                    data: { did: did, unique_token: unique_token },
                    success: function (data) {
                        $("#table tbody").html(data); // Update only the tbody
                    }
                });
            });
        });
    </script>
</body>
</html>
