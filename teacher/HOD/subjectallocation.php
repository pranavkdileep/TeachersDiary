<?php
// session_start();
include("header.php");
include_once("../../dboperation.php");
$obj = new dboperation();
$s = 1;

// Fetch course data
$sql1 = "SELECT * FROM tblcourse WHERE departmentid=" . $_SESSION['deptid'];
$res1 = $obj->executequery($sql1);

// Fetch academic years
$sql2 = "SELECT * FROM tblacademicyear";
$res2 = $obj->executequery($sql2);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Allocation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="bootstrap.css">
    <style>
        .btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }

        .view-btn {
            background-color: #008CBA;
            color: white;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }

        .fa {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="my-4">Subject Allocation</h1>
                <form method="POST" action="suballocationaction.php">
                    <div class="form-group">
                        <label for="ddlcourse" class="form-label">Course</label>
                        <select class="form-control" name="ddlcourse" id="ddlcourse">
                            <option value="">----Select----</option>
                            <?php
                            while ($display1 = mysqli_fetch_array($res1)) {
                                ?>
                                <option value="<?php echo $display1["courseid"]; ?>">
                                    <?php echo $display1["coursename"]; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="ddlsemester" class="form-label">Semester</label>
                        <select id="ddlsemester" name="ddlsemester" class="form-control" required>
                            <option value="">----Select----</option>
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="ddlayear" class="form-label">Academic Year</label>
                        <select name="ddlayear" class="form-control" required>
                            <option value="">----Select----</option>
                            <?php
                            while ($dis = mysqli_fetch_array($res2)) {
                                ?>
                                <option value="<?php echo $dis["academicid"]; ?>">
                                    <?php echo $dis["academicyear"]; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group mt-4">
                        <table class="table table-striped" id="styled-table">
                            <thead>
                                <tr>
                                    <th>Slno</th>
                                    <th>Subject</th>
                                    <th>Teacher</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded here via AJAX -->
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <center>
                    </center>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php include("footer.php"); ?>

<script src="../../jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Handle course change
        $("#ddlcourse").change(function () {
            var courseId = $(this).val();
            $.ajax({
                type: "POST",
                url: "getsemlist.php",
                data: { courseid: courseId },
                success: function (data) {
                    $("#ddlsemester").html(data);
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        });

        // Handle semester change
        $("#ddlsemester").change(function () {
            var semester = $(this).val();
            var courseId = $("#ddlcourse").val(); // Get selected course ID
            $.ajax({
                type: "POST",
                url: "getsuballocation.php",
                data: { semester: semester, courseid: courseId },
                success: function (data) {
                    $("#styled-table tbody").html(data);
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        });
    });
</script>