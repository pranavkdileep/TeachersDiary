<?php
include("header.php");
include_once("../dboperation.php");
$obj = new dboperation();
$s = 1;
?>
<div class="container-fluid">
    <div class="row">
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <a href="subreg.php" class="btn btn-primary mb-3">Add Course <i class="ti ti-circle-plus"></i></a>
            </ul>
        </div>
        <form method="post">
            <label for="exampleInputEmail1" class="form-label">Select Department</label>
            <select name="dept" id="dept" class="form-control">
                <option value="">-----select-----</option>
                <?php
                $sql1 = "SELECT * FROM tbldepartment";
                $res1 = $obj->executequery($sql1);
                while ($display1 = mysqli_fetch_array($res1)) {
                ?>
                    <option value="<?php echo $display1["departmentid"]; ?>">
                        <?php echo $display1["departmentname"]; ?>
                    </option>
                <?php
                }
                ?>
            </select>

            <div class="row mt-4">
                <label for="course" class="form-label">Course</label>
                <div class="col-lg-12 d-flex align-items-stretch">
                    <select name="course" id="course" class="form-control">
                        <option value="">-----select-----</option>
                        <!-- AJAX will populate this -->
                    </select>
                </div>
            </div>

            <div class="row mt-4">
                <label for="Semester" class="form-label">Semester</label>
                <div class="col-lg-12 d-flex align-items-stretch">
                    <select name="Semester" id="Semester" class="form-control">
                        <option value="">-----select-----</option>
                        <!-- AJAX will populate this -->
                    </select>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12 d-flex align-items-stretch" id="tablee">
                    <!-- AJAX will populate this -->
                </div>
            </div>
        </form>
    </div>
</div>

<?php
include("footer.php");
?>

<!-- jQuery Script -->
<script src="../jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Event listener for department selection
    $("#dept").change(function() {
        var did = $(this).val();
        if (did !== "") {
            $.ajax({
                type: "POST",
                url: "deptsubject.php",
                data: { did: did },
                success: function(data) {
                    $("#course").html(data); // Update course dropdown
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error in deptsubject.php:", status, error);
                    console.log(xhr.responseText); // Log full error response
                }
            });
        } else {
            $("#course").html('<option value="">Select Course</option>');
            $("#Semester").html('<option value="">Select Semester</option>');
            $("#tablee").html('');
        }
    });

    // Event listener for course selection
    $(document).on('change', '#course', function() {
        var courseId = $(this).val();
        if (courseId !== "") {
            $.ajax({
                type: "POST",
                url: "semlistsub.php",
                data: { did: courseId },
                success: function(data) {
                    $("#Semester").html(data); // Update semester dropdown
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error in semlistsub.php:", status, error);
                    console.log(xhr.responseText); // Log full error response
                }
            });
        } else {
            $("#Semester").html('<option value="">Select Semester</option>');
            $("#tablee").html('');
        }
    });

    // Event listener for semester selection
    $(document).on('change', '#Semester', function() {
        var semesterId = $(this).val();
        var courseId = $("#course").val(); // Get the selected course ID

        if (semesterId !== "" && courseId !== "") {
            $.ajax({
                type: "POST",
                url: "subjectviewaction.php",
                data: { sid: semesterId, cid: courseId }, // Pass both semester and course IDs
                success: function(data) {
                    $("#tablee").html(data); // Update table with subjects
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error in subjectviewaction.php:", status, error);
                    console.log(xhr.responseText); // Log full error response
                }
            });
        } else {
            $("#tablee").html(''); // Clear table if no semester selected
        }
    });
});
</script>
