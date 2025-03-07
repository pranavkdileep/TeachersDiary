<?php
// session_start();
include("header.php");
include("../../dboperation.php");
$obj = new dboperation();
$s = 1;
$id = $_GET["id"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Table</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="styletable.css">
    <style>
        .btn-custom {
            background-color: #007bff;
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .styled-table {
            width: 100%;
            border-collapse: collapse;
        }
        .styled-table th, .styled-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        .styled-table th {
            background-color: #f8f9fa;
        }
        .verified {
            color: green;
        }
        .not-verified {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">
            <?php
            $sql1 = "SELECT teachername FROM tblteacher WHERE teacherid='$id'";
            $res1 = $obj->executequery($sql1);
            while ($display1 = mysqli_fetch_array($res1)) {
                echo htmlspecialchars($display1["teachername"]) . "'s Logbook Preview";
            }
            ?>
        </h1>
        <form method="post">
            <div class="mb-3">
                <label for="year" class="form-label">Select Academic Year:</label>
                <select name="year" id="year" class="form-select">
                <?php
                $sql = "select * from tblacademicyear where status='active'";
                $res = $obj->executequery($sql);
                while ($display = mysqli_fetch_array($res)) {
                    ?>
                    <option value="2024"><?php echo $display["academicyear"]; ?></option>
                    <?php
                }
                ?>
            </select>
            </div>
            <div class="mb-3">
                <label for="month" class="form-label">Select Month:</label>
                <select name="month" id="month" class="form-select">
                    <option value="<?php echo date("m"); ?>"><?php echo date("F"); ?></option>
                    <?php
                    for ($m = 1; $m <= 12; $m++) {
                        $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                        echo "<option value='$m'>$month</option>";
                    }
                    ?>
                </select>
            </div>
            <button name="save" type="submit" class="btn btn-custom">Submit</button>
        </form>

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
            <div class="mt-4">
                <table class="table text-nowrap mb-0 align-middle" >
                    <thead>
                        <tr>
                            <th>Week Number</th>
                            <th>Start Date - End Date</th>
                            <th>Principal Remark</th>
                            <th>Status</th>
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
                                ?>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>
                                    <td><a href='getdate.php?sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>&tid=<?php echo $id; ?>'><?php echo $week['start']; ?> - <?php echo $week['end']; ?></a></td>
                                    <td> <?php
                                // Fetch the principal's remark from tblremark for the given date range
                                $sql_remark = "SELECT*
                                FROM tblremark 
                                WHERE teacherid='$id' 
                                AND ('$sdate' >= fdate AND '$edate' <= tdate)";                                  
                                $res_remark = $obj->executequery($sql_remark);
                                if (mysqli_num_rows($res_remark) > 0) {
                                    while ($remark_row = mysqli_fetch_array($res_remark)) {
                                        echo $remark_row['principalremark'];
                                    }
                                } else {
                                    echo "No Remark";
                                }
                                ?>
                            </td></td>
                            <td>
    <?php
    $sql1 = "SELECT * 
             FROM tblteacherlog 
             WHERE teacherid='$id' 
               AND (status='Forward to Principal' OR status='Verified by Principal') 
               AND submitteddate BETWEEN '$sdate' AND '$edate'";
    $res1 = $obj->executequery($sql1);
    if (mysqli_num_rows($res1) > 0) {
        echo "<span class='verified'>Verified</span>";
    } else {
        echo "<span class='not-verified'>Not Verified</span>";
    }
    ?>
</td>

</td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
        ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
include("footer.php");
?>
