<?php
// session_start();
include("header.php");
include_once("../../dboperation.php");
$obj = new dboperation();
$subject_id = $_GET['sid'];
$course_id=$_GET['cid'];
$subteacherid=$_GET['stid'];
// Assuming you're passing the subject ID via GET

// Fetch the subject and teacher data for the selected subject
$sql = "SELECT ts.subjectname, st.teacherid, ts.semester, tc.courseid
        FROM tblsubject ts
        INNER JOIN subject_teacher st ON ts.subjectid = st.subjectid
        INNER JOIN tblcourse tc ON ts.courseid = tc.courseid
        WHERE st.subteacherid = '$subteacherid'";
$res = $obj->executequery($sql);
$data = mysqli_fetch_array($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subject Allocation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="my-4">Edit Subject Allocation</h1>
                <form method="post" action="allocatedsubeditaction.php">
                    <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">

                    <div class="form-group">
                        <label for="ddlcourse">Course</label>
                        <select name="ddlcourse" class="form-control" id="ddlcourse">
                            <option value="">-----select-----</option>
                            <?php
                            $sql_course = "SELECT * FROM tblcourse WHERE departmentid=" . $_SESSION["deptid"];
                            $res_course = $obj->executequery($sql_course);
                            while ($course = mysqli_fetch_array($res_course)) {
                                $selected = ($course["courseid"] == $data["courseid"]) ? "selected" : "";
                                ?>
                                <option value="<?php echo $course["courseid"]; ?>" <?php echo $selected; ?>>
                                    <?php echo $course["coursename"]; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="ddlsemester">Semester</label>
                        <select name="ddlsemester" class="form-control" id="ddlsemester">
                            <option value="<?php echo $data['semester']; ?>"><?php echo $data['semester']; ?></option>
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="subject_name">Subject</label>
                        <select name="subject_id" class="form-control" id="subject_id">
                            <!-- <option value="">-----select-----</option> -->
                            <?php
                           $sql_subject = "SELECT * FROM tblsubject WHERE courseid='$course_id'";
                            $res_subject = $obj->executequery($sql_subject);
                            while ($subject = mysqli_fetch_array($res_subject)) {
                                $selected = ($subject_id == $subject["subjectid"]) ? "selected" : "";
                                ?>
                                <option value="<?php echo $subject["subjectid"]; ?>" <?php echo $selected; ?>>
                                    <?php echo $subject["subjectname"]; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <!-- <input type="text" name="subject_name" class="form-control" id="subject_name" value="<?php echo $data['subjectname']; ?>" > -->
                    </div>

                    <div class="form-group mt-3">
                        <label for="teacher_id">Teacher</label>
                        <select name="teacher_id" class="form-control" id="teacher_id">
                            <option value="">-----select-----</option>
                            <?php
                            $sql_teacher = "SELECT * FROM tblteacher where departmentid=" .$_SESSION["deptid"];
                            $res_teacher = $obj->executequery($sql_teacher);
                            while ($teacher = mysqli_fetch_array($res_teacher)) {
                                $selected = ($teacher["teacherid"] == $data["teacherid"]) ? "selected" : "";
                                ?>
                                <option value="<?php echo $teacher["teacherid"]; ?>" <?php echo $selected; ?>>
                                    <?php echo $teacher["teachername"]; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                        <input type="hidden" name="stid" value="<?php echo $subteacherid ?>">
                    <input type="submit" name="update" value="Update" class="btn btn-primary mt-4">
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
        });
    </script>
</body>
</html>
