<?php
// session_start();
include("header.php");
include_once("../dboperation.php");
$obj = new dboperation();
// Generate a unique token for the session if it doesn't exist
if (!isset($_SESSION['unique_token'])) {
    $_SESSION['unique_token'] = uniqid();
}
$unique_token = $_SESSION['unique_token'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department List</title>
    <link rel="stylesheet" href="styletable.css">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content {
            flex: 1;
        }

        .para {
            text-align: center;
            margin: 100px;
        }

        .viewlog-link:link {
            color: blue;
            /* Color for unvisited links */
        }

        .viewlog-link:visited {
            color: green;
            /* Color for visited links */
        }

        .viewlog-link:hover {
            color: darkblue;
            /* Color for hovered links */
        }

        .viewlog-link:active {
            color: orange;
            /* Color for active links */
        }

        .info {
            color: blue;
        }

        .info-visited {
            color: green;
        }
    </style>
</head>

<body>
    <div class="container-fluid">

        <div class="content">
            <h2>Department:</h2>
            <select name="ddldeptname" class="form-control" id="ddldepartment">
                <option>-----select-----</option>
                <?php
                $sql = "SELECT * FROM tbldepartment";
                $res = $obj->executequery($sql);
                while ($display = mysqli_fetch_array($res)) {
                    ?>
                    <option value="<?php echo $display['departmentid']; ?>">
                        <?php echo $display['departmentname']; ?>
                    </option>
                    <?php
                }
                ?>
            </select>
            <br>
  <div class="row">

            <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4 al">Department List</h5>
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle" id="table">
                                <thead class="text-dark ">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Sl no</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Name</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">View</h6>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </div>




            </div>
            <div class="card">
            <div class="para fixbottom">
                <h6 style="text-decoration: underline;">NOTE:-</h6>
                <p class="info" style="text-decoration: underline;">Blue color indicates unvisited log</p>
                <p class="info-visited" style="text-decoration: underline;">Green color indicates visited log</p>
            </div>
            </div>
            


        </div>
    </div>










    <?php include("footer.php"); ?>
    <script src="../jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#ddldepartment").change(function () {
                var did = $(this).val();
                var unique_token = '<?php echo $unique_token; ?>'; // Get the unique token from PHP
                $.ajax({
                    type: "POST",
                    url: "report_logteacher.php",
                    data: { did: did, unique_token: unique_token },
                    success: function (data) {
                        $("#table tbody").html(data); // Update only the tbody
                    }
                });
            });
        });
    </script>

    <style>
    .table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e600;}</style>
</body>

</html>