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

                <!-- <a href="teacherreg.php" class="btn btn-primary mb-3">teacher Registration<i -->
                <!-- class="ti ti-circle-plus"></i></a> -->
            </ul>
            <h2><b>Department:</b></h2>
            <select name="ddldeptname" id="ddldeptname" class="form-control">
                <option>----select----</option>
                <?php
                $sql1 = "select * from tbldepartment";
                $result = $obj->executequery($sql1);
                while ($display = mysqli_fetch_array($result)) {
                    ?>
                    <option value="<?php echo $display["departmentid"]; ?>">
                        <?php echo $display["departmentname"]; ?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </div>
        <br>

        <div class="row mt-4">

            <div class="card-body" name="ddlteacher" id="ddlteacher">

            </div>
        </div>
    </div>

    <script src="../jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            //alert("Successful");
            $("#ddldeptname").change(function () {
                var did = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "report_getteachers.php",
                    data: "did=" + did,
                    success: function (data) {
                        $("#ddlteacher").html(data);
                    }
                });

            });
        });
    </script>
    <?php
    include("footer.php");
    ?>