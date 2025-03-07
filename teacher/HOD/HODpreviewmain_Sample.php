<?php
session_start();
include("header.php");
include("../../dboperation.php");
$obj = new dboperation();
$s = 1;
$id = 3;
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Table</title>
    <link rel="stylesheet" href="styletable.css">
</head>
<body>
    <form method="post">
        <div class="container">
            <?php
            $sql1 = "select teachername from tblteacher where teacherid='$id'";
            $res1 = $obj->executequery($sql1);
            while ($display1 = mysqli_fetch_array($res1)) {
                ?>
                <h1><?php echo $display1["teachername"]; ?>'s Logbook Preview</h1>
                <?php
            }
            ?>
            <select name="year" id="year">
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
            <select name="month">
                <option value="<?php echo date("m"); ?>"><?php echo date("F"); ?></option>
                <?php
                for ($m = 1; $m <= 12; $m++) {
                    $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                    echo "<option value='$m'>$month</option>";
                }
                ?>
            </select>
            <button name="save" type="submit">Submit</button>
        </div>
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

        // Adjust start_date to the first Monday of the month or stay on the 1st if it is Monday
        if ($start_date->format('N') != 1) {
            $start_date->modify('last Monday');
        }

        while ($start_date <= $last_day) {
            $end_date = clone $start_date;
            $end_date->modify('Sunday this week');

            if ($end_date > $last_day) {
                $end_date = clone $last_day;
            }

            $weeks[] = [
                'start' => $start_date->format('d-m-Y'),
                'end' => $end_date->format('d-m-Y')
            ];

            // Move start_date to the next Monday
            $start_date->modify('+1 week');
        }

        $number_of_weeks = count($weeks);
        ?>
        <div class="container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Week Number</th>
                        <th>Start Date - End Date</th>
                        <th>Remark</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($weeks as $index => $week) {
                        $sdate = DateTime::createFromFormat('d-m-Y', $week['start'])->format('Y-m-d');
                        $edate = DateTime::createFromFormat('d-m-Y', $week['end'])->format('Y-m-d');
                        ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><a href='getdate.php?sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>&tid=<?php echo $id; ?>'><?php echo $week['start']; ?> - <?php echo $week['end']; ?></a></td>
                            <td>
                                <?php
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
                            </td>
                            <td><?php
                            $sql1 = "select * from tblteacherlog where teacherid='$id' and status='Forward to Principal' and submitteddate between '$sdate' and '$edate'";
                            $res1 = $obj->executequery($sql1);
                            if (mysqli_num_rows($res1) > 0) {
                                echo "<span style='color: green;'>Verified</span>";
                            } else {
                                echo "<span style='color: red;'>Not Verified</span>";
                            }
                            ?></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    }
    ?>
</body>
</html>
<?php
include("footer.php");
?>
