<?php
include("header.php");
include_once("../dboperation.php");
$obj=new dboperation();
?>
<div class="container-fluid">
    <div class="row">
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <a href="subjectview.php" class="btn btn-primary mb-3">View Subjects <i class="ti ti-eye"></i></a>
            </ul>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Course Registration</h5>
            <div class="card">
                <div class="card-body">
                    <form action="subregaction.php" method="post">
                        <div class="mb-3">
                            <label for="ddldeptname" class="form-label">Department</label>
                            <select name="ddldeptname" id="ddldeptname" class="form-control" required>
                                <option selected disabled>-----select-----</option>
                                <?php
                                $sql = "SELECT * From tbldepartment";
                                $res = $obj->executequery($sql);
                                while ($display = mysqli_fetch_array($res)) {
                                    ?>
                                    <option value="<?php echo $display["departmentid"]; ?>">
                                        <?php echo $display["departmentname"]; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="ddlcoursename" class="form-label">Program</label>
                            <select name="ddlcoursename" id="ddlcoursename" class="form-control" required>
                                <option value="0">----select----</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="ddlsemester" class="form-label">Semester</label>
                            <select name="ddlsemester" id="ddlsemester" class="form-control" required>
                                <option value="0">----Select----</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="txtsubjectname" class="form-label">Course</label>
                            <input type="text" name="txtsubjectname" placeholder="Enter course" required class="form-control">
                        </div>

                        <input type="submit" value="Register" name="save" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>

<!-- Include jQuery -->
<script src="../jquery-3.6.0.min.js"></script>

<!-- JavaScript to handle dynamic dropdowns -->
<script>
    $(document).ready(function() {
        $("#ddldeptname").change(function() {
            var did = $(this).val();
            $.ajax({
                type: "POST",
                url: "getcourse.php",
                data: "did=" + did,
                success: function(data) {
                    $("#ddlcoursename").html(data);
                }
            });
        });

        $("#ddlcoursename").change(function() {
            var did = $(this).val();
            console.log("Selected Course ID:", did); // Debugging
            $.ajax({
                type: "POST",
                url: "getsemlist.php",
                data: { did: did },
                success: function(data) {
                    $("#ddlsemester").html(data);
                }
            });
        });
    });
</script>
