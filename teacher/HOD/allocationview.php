<?php
// session_start();
include("header.php");
include_once("../../dboperation.php");
$obj = new dboperation();
$s = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject List</title>
    <!-- <link rel="stylesheet" href="bootstrap.css"> -->
    <!-- <link rel="stylesheet" href="styletable.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
                <h1 class="my-4">Subject Allocated List</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="ddlcourse">Course</label>
                        <select name="ddlcourse" class="form-control" id="ddlcourse">
                            <option value="">-----select-----</option>
                            <?php
                            $sql = "SELECT * FROM tblcourse WHERE departmentid=" . $_SESSION["deptid"];
                            $res = $obj->executequery($sql);
                            while ($display = mysqli_fetch_array($res)) {
                                ?>
                                <option value="<?php echo $display["courseid"]; ?>">
                                    <?php echo $display["coursename"]; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="ddlsemester">Semester</label>
                        <select name="ddlsemester" class="form-control" id="ddlsemester">
                            <option value="">-----select-----</option>
                        </select>
                    </div>

                    <div class="form-group mt-4">
                        <table class="table table-striped" id="styled-table">
                            <thead>
                                <tr>
                                    <th>Slno</th>
                                    <th>Subject</th>
                                    <th>Teacher</th>
                                    <th>Edit</th>

                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded here via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                var courseid = $("#ddlcourse").val();
                $.ajax({
                    type: "POST",
                    url: "getsublist.php",
                    data: { semester: semester,courseid: courseid },
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
</body>
</html>
