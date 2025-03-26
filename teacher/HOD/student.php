<?php
include("header.php");
include_once("../../dboperation.php");
$obj = new dboperation();
$s = 1;
$departmentid = $_SESSION["deptid"]
?>

<div class="container-fluid">
    <div class="row">
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

                <a href="studentreg.php" class="btn btn-primary mb-3">Student Registration<i
                        class="ti ti-circle-plus"></i></a>
            </ul>
            Department id: <?php echo $departmentid;?><br/><p></p>
            Semester<select name="semname" id="semname" class="form-control">
                <option>----select----</option>
                <?php
                $sql1 = "select distinct semester from tblstudent";
                $result = $obj->executequery($sql1);
                while ($display = mysqli_fetch_array($result)) {
                    ?>
                    <option value="<?php echo $display["semester"]; ?>">
                        <?php echo $display["semester"]; ?>
                    </option>
                    <?php
                }
                ?>
            </select>
    </div>
    <br>

    <div class="row mt-4">

        <div class="card-body" name="ddlstudents" id="ddlstudents">

        </div>
    </div>
</div>

    <script src="../../jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#semname").change(function () {
                var sem = $("#semname").val();
                $.ajax({
                    url: "getstudents.php",
                    type: "POST",
                    data: {
                        sem: sem
                    },
                    success: function (data) {
                        $("#ddlstudents").html(data);
                    }
                }) 
            })
        });
    </script>
    <?php
    include("footer.php");
    ?>