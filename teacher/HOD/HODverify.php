<?php
// session_start();
include("header.php");
include_once("../../dboperation.php");
$obj = new dboperation();
$s = 1;

// Check if the unique token is set in the session
if (!isset($_SESSION['unique_token'])) {
    // Redirect to login if the token is not set
    header("Location: login.php");
    exit();
}

$unique_token = $_SESSION['unique_token'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="styletable.css">
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
        .viewlog-link {
            color: blue;
            text-decoration: none;
        }
        .viewlog-link:visited {
            color: green;
        }
        .viewlog-link:hover {
            color: darkblue;
        }
        .viewlog-link:active {
            color: orange;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">YourSite</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="deptreg.php">Add Department</a>
                </li>
                <!-- Add more nav links as needed -->
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">Department List</h1>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Slno</th>
                    <th>Teacher Name</th>
                    <th>View Log</th>
                </tr>
            </thead>
            <tbody>
                <?php   
                $sql = "SELECT * FROM tblteacher WHERE departmentid=" . $_SESSION['deptid'];
                $res = $obj->executequery($sql);
                while ($display = mysqli_fetch_array($res)) {
                ?> 
                <tr>
                    <td><?php echo $s++ ?></td>
                    <td><?php echo htmlspecialchars($display["teachername"]) ?></td>
                    <td>
                        <a class="viewlog-link" href="HODpreviewmain.php?id=<?php echo $display['teacherid']?>&token=<?php echo $unique_token; ?>">View Log</a>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
include("footer.php");
?>
