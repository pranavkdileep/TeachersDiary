<?php
// session_start();
include("header.php");
include("../dboperation.php");
$obj = new dboperation();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logbook Registration</title>
    <!-- <link rel="stylesheet" href="styletable.css"> -->
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">  
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4">Logbook Entry</h5>

                        <form name="f1" method="post" action="logbookregaction.php">
                            <div class="mb-3">
                                <label for="txtdate" class="form-label">Select Today's Date:</label>
                                <input type="date" name="txtdate" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>

                            </div>

                            <div class="table-responsive">
                                <table class="table text-nowrap mb-0 align-middle styled-table">
                                    <thead class="text-dark fs-4">
                                        <tr>
                                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Hour</h6></th>
                                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Class/Course</h6></th>
                                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Semester</h6></th>
                                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Subject</h6></th>
                                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Module/Cell</h6></th>
                                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Topics/Workdone</h6></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for ($i = 1; $i <= 6; $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <select class="form-select ddlcourse" name="ddlcourse[]">
                                                        <option value="0">----select----</option>
                                                        <option value="19">No class</option>
                                                        <option value="22">Open Course</option>
                                                        <?php
                                                        $sql = "SELECT * FROM tblcourse WHERE departmentid=" . $_SESSION['deptid'];
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
                                                </td>
                                                <td>
                                                    <select class="form-select ddlsemester" name="ddlsemester[]">
                                                        <option value="0">----select----</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-select ddlsubject" name="ddlsubject[]">
                                                        <option value="0">----select----</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="module[]" placeholder="Enter module">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="topics[]" placeholder="Enter topics">
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary float-end" name="save">SUBMIT</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include("footer.php");
    ?>

    <script src="../jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".ddlcourse").change(function () {
                var courseid = $(this).val();
                var ddlsemester = $(this).closest("tr").find(".ddlsemester");
                var ddlsubject = $(this).closest("tr").find(".ddlsubject");

                if (courseid == 19) {
                    ddlsemester.prop('disabled', true);
                    ddlsubject.prop('disabled', true);
                    ddlsemester.html('<option value="0">No Class</option>');
                    ddlsubject.html('<option value="12">No Class</option>');
                }
                else if(courseid == 22) 
                {
                    ddlsemester.prop('disabled', true);
                    ddlsubject.prop('disabled', true);
                    ddlsemester.html('<option value="22">Open Course</option>');
                    ddlsubject.html('<option value="13">Open Course</option>');
                } 
                else {
                    ddlsemester.prop('disabled', false);
                    ddlsubject.prop('disabled', false);

                    $.ajax({
                        type: "POST",
                        url: "getsemlist.php",
                        data: { courseid: courseid },
                        success: function (data)
                         {
                            ddlsemester.html(data);
                        },
                        error: function (xhr, status, error) {
                            console.error("AJAX Error:", status, error);
                        }
                    });
                }
            });

            $(".ddlsemester").change(function () {
                var semno = $(this).val();
                var ddlsubject = $(this).closest("tr").find(".ddlsubject");
                var courseid = $(this).closest("tr").find(".ddlcourse").val();
                $.ajax({
                    type: "POST",
                    url: "getsubject.php",
                    data: { semno: semno, courseid: courseid }, 
                    success: function (data) {
                        ddlsubject.html(data);
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
