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
$did = $_GET["did"];
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
                <h1><?php echo $display1["teachername"]; ?>'s Diary Semester Hour Report</h1>
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
                <label for="exampleInputEmail1" class="form-label" id="course">Course</label>
                <select name="course" id="course" class="form-select month" required>
                    <option value="0">----Select----</option>
                    <?php
                    $sql1 = "SELECT * FROM tblcourse WHERE departmentid='$did'";
                    $res1 = $obj->executequery($sql1);
                    while ($display1 = mysqli_fetch_array($res1)) {
                        ?>
                        <option value="<?php echo $display1['courseid']; ?>">
                            <?php echo $display1['coursename']; ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
                <label for="exampleInputEmail1" class="form-label">Semester</label>
                <select name="Semester" id="Semester" class="form-select month" required>
                    <option value="">-----select-----</option>
                    <!-- AJAX will populate this -->
                </select>
                <br>
                <button name="save" type="submit" class="btn btn-primary">Submit</button>
            </form>
            <br>

            <?php
            if (isset($_POST['save'])) {
               $course=$_POST['course'];
               $semester=$_POST['Semester'];
                // Fetch logs where the status is verified and within the selected month
                 $sql_logs = "SELECT * FROM tblteacherlog tp 
                             INNER JOIN tblcourse tc ON tp.courseid=tc.courseid 
                             INNER JOIN tblsubject ts ON tp.subjectid=ts.subjectid 
                             WHERE tp.teacherid='$tid' 
                             AND tp.courseid='$course'
                             AND tp.semester='$semester'";
                $res_logs = $obj->executequery($sql_logs);
                $row_count = mysqli_num_rows($res_logs);

                if ($row_count > 0) {
                    $noClassCount = 0;
                    $courseCount = 0;

                    while ($display2 = mysqli_fetch_array($res_logs)) {
                        // Count hours based on whether it's a class or a "No class" entry
                        $coursename=$display2['coursename'];
                        if (strtolower($display2['coursename']) == "No class") {
                            $noClassCount++;
                        } else {
                            $courseCount++;
                        }
                    }
                    // Display the counts
                    echo "<div class='log-block'>
                            <u><h2>Total Class Hours in $semester - " . $coursename . "<br></u>". $courseCount."-hrs</h2>
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
        $(document).on('change', '#course', function () {
            var courseId = $(this).val();
            if (courseId !== "") {
                $.ajax({
                    type: "POST",
                    url: "semlistsub.php",
                    data: { did: courseId },
                    success: function (data) {
                        $("#Semester").html(data); // Update semester dropdown
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error in semlistsub.php:", status, error);
                        console.log(xhr.responseText); // Log full error response
                    }
                });
            } else {
                $("#Semester").html('<option value="">Select Semester</option>');
                $("#tablee").html('');
            }
        });

    </script>
</body>

</html>