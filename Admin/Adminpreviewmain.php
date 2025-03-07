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
$id = $_GET["id"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Department List</title> -->
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

        .viewlog-link:link {
            color: blue;
            /* Color for unvisited links */
        }

        .viewlog-link:visited {
            color: green;
            /* Color for visited links */
        }

        .viewlog-link:hover {
            color: darkblue;
            /* Color for hovered links */
        }

        .viewlog-link:active {
            color: orange;
            /* Color for active links */
        }

        .info {
            color: blue;
        }

        .info-visited {
            color: green;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="content">
            <?php
            // Fetch the teacher's name based on their ID
            $sql1 = "SELECT * FROM tblteacher WHERE teacherid='$id'";
            $res1 = $obj->executequery($sql1);
            while ($display1 = mysqli_fetch_array($res1)) {
                ?>
                <h1><?php echo $display1["teachername"]; ?>'s Logbook Preview</h1>
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
                        ?>
                        <option value="2024"><?php echo $display["academicyear"]; ?></option>
                        <?php
                    }
                    ?>
                </select>
              <label for="exampleInputEmail1" class="form-label">Month</label>
                <select name="month" class="form-select month">
                    <option value="<?php echo date("m"); ?>"><?php echo date("F"); ?></option>
                    <?php
                    for ($m = 1; $m <= 12; $m++) {
                        $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                        echo "<option value='$m'>$month</option>";
                    }
                    ?>
                </select>
                <br>
                <button name="save" type="submit" class="btn btn-primary">Submit</button>
            </form>
            <br>

            <?php
            if (isset($_POST['save'])) {
                $year = $_POST["year"];
                $month = $_POST["month"];
                $first_day = new DateTime("$year-$month-01");
                $last_day = new DateTime("$year-$month-01");
                $last_day->modify('last day of this month');

                $weeks = [];
                $start_date = clone $first_day;
                $end_date = clone $start_date;
                $end_date->modify('Saturday this week');

                if ($start_date == $end_date) {
                    $weeks[] = [
                        'start' => $start_date->format('Y-m-d'),
                        'end' => $end_date->format('Y-m-d')
                    ];
                    $start_date->modify('+1 day');
                } else {
                    $weeks[] = [
                        'start' => $start_date->format('Y-m-d'),
                        'end' => $end_date->format('Y-m-d')
                    ];
                    $start_date = clone $end_date;
                    $start_date->modify('+1 day');
                }

                while ($start_date <= $last_day) {
                    $end_date = clone $start_date;
                    $end_date->modify('+6 days');
                    if ($end_date > $last_day) {
                        $end_date = $last_day;
                    }
                    $weeks[] = [
                        'start' => $start_date->format('Y-m-d'),
                        'end' => $end_date->format('Y-m-d')
                    ];
                    $start_date->modify('+7 days');
                }

                $number_of_weeks = count($weeks);
                ?>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle" id="table">
                        <thead class="text-dark">
                            <tr>
                                <th>Week Number</th>
                                <th>Start Date - End Date</th>
                                <th>Status</th>
                                <th>HOD Remark</th>
                                <th>Principal Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($weeks as $index => $week) {
                                $start = new DateTime($week['start']);
                                $end = new DateTime($week['end']);
                                $days = $end->diff($start)->days + 1;
                                if ($days > 2) {
                                    $sdate = $week['start'];
                                    $edate = $week['end'];
                                    $sql1 = "SELECT * 
                                    FROM tblteacherlog tl
                                    INNER JOIN tblremark tr ON tl.teacherid = tr.teacherid
                                    WHERE tl.teacherid = '$id'
                                    AND (tl.status = 'Forward to Principal' OR tl.status = 'Verified by Principal' OR tl.status='Rejected by Principal')
                                    AND tl.submitteddate BETWEEN '$sdate' AND '$edate'
                                    AND (
                                        (tr.fdate BETWEEN '$sdate' AND '$edate') OR 
                                        (tr.tdate BETWEEN '$sdate' AND '$edate') OR 
                                        ('$sdate' BETWEEN tr.fdate AND tr.tdate) OR
                                        ('$edate' BETWEEN tr.fdate AND tr.tdate)
                                    )";
                                    
                                    $res1 = $obj->executequery($sql1);
                                    if (mysqli_num_rows($res1) > 0) {
                                        $display = mysqli_fetch_array($res1);
                                        $statusColor = ($display['status'] == 'Rejected by Principal') ? 'red' : 'green';?>
                                        <tr>
                                            <td><?php echo $i + 1; ?></td>
                                            <td><a href='datepreview.php?sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>&tid=<?php echo $id; ?>'><?php echo $week['start']; ?> - <?php echo $week['end']; ?></a></td>
                                            <td style="color:<?php echo $statusColor ?> "><?php echo $display['status']; ?></td>
                                            <td><?php echo $display['hodremark']; ?></td>
                                            <td><?php echo $display['principalremark']; ?></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php
            }
            ?>

            <!-- <div class="card">
                <div class="para fixbottom">
                    <h6 style="text-decoration: underline;">NOTE:-</h6>
                    <p class="info" style="text-decoration: underline;">Blue color indicates unvisited log</p>
                    <p class="info-visited" style="text-decoration: underline;">Green color indicates visited log</p>
                </div>
            </div> -->
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
