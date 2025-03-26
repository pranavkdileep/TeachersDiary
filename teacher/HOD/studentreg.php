<?php
session_start(); // Start the session
include_once("../../dboperation.php");
$obj = new dboperation();
$departmentid = isset($_SESSION["deptid"]) ? $_SESSION["deptid"] : "Not Set";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Student Registration</h5>
                    <div class="card">
                        <div class="card-body">
                            <form action="studentregistractionaction.php" method="post">
                                <div class="mb-3">
                                    <label for="txtdepartmentid" class="form-label">Department Id:</label>
                                    <input type="text" name="txtdepartmentid" placeholder="Enter Department Id" 
                                        class="form-control" value="<?php echo $departmentid;?>" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="txtstudentname" class="form-label">Student Name:</label>
                                    <input type="text" name="txtstudentname" placeholder="Enter Student Name" 
                                        class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="ddlcourse" class="form-label">Course:</label>
                                    <select class="form-select ddlcourse" name="ddlcourse" required>
                                        <option value="0">----select----</option>
                                        <?php
                                        $sql = "SELECT * FROM tblcourse WHERE departmentid=" . $departmentid;
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

                                <div class="mb-3">
                                    <label for="ddlsemester" class="form-label">Semester:</label>
                                    <select class="form-select ddlsemester" name="ddlsemester" required>
                                        <option value="0">----select----</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="txtprentemail" class="form-label">Parent Email:</label>
                                    <input type="email" name="txtprentemail" placeholder="Enter Email" 
                                        class="form-control" title="must enter a valid email address" 
                                        id="email" required>
                                </div>

                                <div class="mb-3">
                                    <label for="txtparentphone" class="form-label">Parent Phone:</label>
                                    <input type="text" name="txtparentphone" placeholder="Enter Phone no" 
                                        class="form-control" required pattern="[0-9]{10}" 
                                        title="Must contain 10 digits">
                                </div>

                                <div class="mb-3">
                                    <label for="txtuniversityid" class="form-label">University Id:</label>
                                    <input type="text" name="txtuniversityid" placeholder="Enter Username" 
                                        required class="form-control">
                                </div>

                                <input type="submit" value="Register" name="save" 
                                    class="btn btn-primary float-end" onclick="return emailvalidation()">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../../jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $(".ddlcourse").change(function () {
        var courseid = $(this).val();
        var ddlsemester = $(".ddlsemester");

        if (courseid != 0) {
            $.ajax({
                type: "POST",
                url: "getsemlist.php",
                data: { courseid: courseid },
                success: function (data) {
                    ddlsemester.html(data);
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        } else {
            ddlsemester.html('<option value="0">----select----</option>');
        }
    });
});

function emailvalidation() {
    var email = document.getElementById('email').value;
    var emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i;

    if (!emailPattern.test(email)) {
        alert('Please enter a valid email address.');
        return false; // Prevent form submission
    }
    return true;
}
</script>
</body>
</html>