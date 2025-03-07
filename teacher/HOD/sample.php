<?php
session_start();
include("header.php");
include("../../dboperation.php");
$obj = new dboperation();
$s = 1;
$id =3;
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
        $start_date->modify('Sunday last week'); // Start from the previous Sunday or the first day of the month
        $end_date = clone $start_date;
        $end_date->modify('Saturday this week');

        while ($start_date <= $last_day) {
            // Adjust the last week to not exceed the end of the month
            if ($end_date > $last_day) {
                $end_date = $last_day;
            }

            $weeks[] = [
                'start' => $start_date->format('Y-m-d'),
                'end' => $end_date->format('Y-m-d')
            ];

            $start_date->modify('+1 day'); // Move to the next Sunday
            $end_date = clone $start_date;
            $end_date->modify('Saturday this week');
        }

        $number_of_weeks = count($weeks);
        ?>
        <div class="container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Week Number</th>
                        <th>Start Date - End Date</th>
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
