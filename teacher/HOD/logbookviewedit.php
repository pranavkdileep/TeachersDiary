<?php
// session_start();
include('header.php');
include("../../dboperation.php");
$obj = new dboperation();
$tid = $_GET['id'];
$cid = $_GET['cid'];
$sid = $_GET['sid'];
$s = 1;
?>
<div class="container-fluid">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="subjectEdit" class="form-label">LOG Edit:</label>
                            <form action="logbookvieweditaction.php" method="POST">
                                <?php
                                $sql1 = "SELECT * FROM tblteacherlog WHERE teacherlogid='$tid'";
                                $res1 = $obj->executequery($sql1);
                                $display1 = mysqli_fetch_array($res1);

                                $sql = "SELECT * FROM tblcourse WHERE departmentid=" . $_SESSION['deptid'];
                                $res = $obj->executequery($sql);
                                ?>

                                <div class="mb-3">
                                    <label for="ddlcourse" class="form-label">Course</label>
                                    <select class="form-select" name="ddlcourse" id="ddlcourse">
                                        <option value="0">----select----</option>
                                        <option value="19">No class</option>
                                        <option value="22">Open Course</option>
                                        <?php
                                        while ($display = mysqli_fetch_array($res)) {
                                            ?>
                                            <option value="<?php echo $display["courseid"]; ?>" <?php echo ($display["courseid"] == $display1["courseid"]) ? "selected=selected" : ""; ?>>
                                                <?php echo $display["coursename"]; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <?php
                                $query1 = "SELECT * FROM tblsubject WHERE subjectid='$sid'";
                                $result1 = $obj->executequery($query1);
                                $dis1 = mysqli_fetch_array($result1);

                                $query = "SELECT * FROM tblcourse WHERE courseid='$cid'";
                                $result = $obj->executequery($query);
                                while ($dis = mysqli_fetch_array($result)) {
                                    $semester = $dis['semesterno'];
                                }
                                ?>

                                <div class="mb-3">
                                    <label for="ddlsemester" class="form-label">Semester</label>
                                    <select class="form-select" name="ddlsemester" id="ddlsemester">
                                        <option value="">----select----</option>
                                        <?php
                                        for ($i = 1; $i <= $semester; $i++) {
                                            $semesterValue = 'S' . $i;
                                            ?>
                                            <option value="<?php echo $semesterValue; ?>">
                                                <?php echo $semesterValue; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="ddlsubject" class="form-label">Subject</label>
                                    <select class="form-select" name="ddlsubject" id="ddlsubject">
                                        <option value="<?php echo $dis1['subjectid'] ?>"> <?php echo $dis1['subjectname'] ?> </option>
                                        <?php
                                        $sql2 = "SELECT * FROM tblsubject WHERE subjectid='$sid'";
                                        $result2 = $obj->executequery($sql2);
                                        $dis2 = mysqli_fetch_array($result2);

                                        $sql3 = "SELECT * 
                                                 FROM tblsubject ts 
                                                 INNER JOIN subject_teacher st ON ts.subjectid = st.subjectid 
                                                 WHERE st.teacherid = " . $_SESSION['teacherid'] . " 
                                                 AND ts.semester ='" . $dis1['semester'] . "'";
                                        $result3 = $obj->executequery($sql3);

                                        while ($dis3 = mysqli_fetch_array($result3)) {
                                            ?>
                                            <option value="<?php echo $dis3["subjectid"]; ?>">
                                                <?php echo $dis3["subjectname"]; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="module" class="form-label">Module</label>
                                    <input type="text" class="form-control" name="module" placeholder="Enter module" value="<?php echo $display1["module"]; ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="topics" class="form-label">Topics</label>
                                    <input type="text" class="form-control" name="topics" placeholder="Enter topics" value="<?php echo $display1["topic"]; ?>">
                                </div>

                                <input type="hidden" value="<?php echo $tid; ?>" name="tid">
                                <input type="submit" value="Save" name="save" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        // Handle Course selection change
        $("#ddlcourse").change(function () {
            var courseid = $(this).val();
            if (courseid == 19) {
                $("#ddlsemester").prop('disabled', true);
                $("#ddlsubject").prop('disabled', true);
                $("#ddlsemester").html('<option value="0">No Class</option>');
                $("#ddlsubject").html('<option value="12">No Class</option>');
            }
            else if(courseid == 22) 
                {
                    $("#ddlsemester").prop('disabled', true);
                    $("#ddlsubject").prop('disabled', true);
                    $("#ddlsemester").html('<option value="22">Open Course</option>');
                    $("#ddlsubject").html('<option value="13">Open Course</option>');
                }  
            else {
                $("#ddlsemester").prop('disabled', false);
                $("#ddlsubject").prop('disabled', false);

                // Fetch semester options based on courseid
                $.ajax({
                    type: "POST",
                    url: "getsemlist.php",
                    data: { courseid: courseid },
                    success: function (data) {
                        $("#ddlsemester").html(data);
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            }
        });

        // Handle Semester selection change
        $("#ddlsemester").change(function () {
            var semno = $(this).val();
            var courseid = $("#ddlcourse").val();

            // Fetch subjects based on semester and course
            $.ajax({
                type: "POST",
                url: "getsub.php",
                data: { semno: semno, courseid: courseid },
                success: function (data) {
                    $("#ddlsubject").html(data);
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        });
    });
</script>
<?php
include("footer.php");
?>
