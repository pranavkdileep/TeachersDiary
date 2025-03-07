<?php
session_start();
include("header.php");
include_once("../dboperation.php");
$obj = new dboperation();
$s = 1;
$sql1 = "select * from tblcourse where departmentid=" . $_SESSION['deptid'];
$res1 = $obj->executequery($sql1);
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department List</title>
    <link rel="stylesheet" href="styletable.css">

    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }

        .edit-btn {
            background-color: #4CAF50;
        }

        .view-btn {
            background-color: #008CBA;
            color: white;
        }

        .delete-btn {
            background-color: #f44336;
        }

        .fa {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="container" >
        <h1>Subject Allocation</h1><br>
       Class <select class="form-control" id="ddlcourse" name="ddlcourse">
            <option value="">----Select----</option>
            <?php
            while ($display1 = mysqli_fetch_array($res1)) {
            ?>
                <option value="<?php echo $display1["courseid"]; ?>"><?php echo $display1["coursename"]; ?>
                </option>
            <?php
            }
            ?>
        </select>
        <form method="POST" action="suballocationaction.php">
            <table class="styled-table">
                <br>
                <thead>
                    <tr>
                        <th>Slno</th>
                        <th>Subject</th>
                        <th>Teacher</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "select * from tblsubject where courseid=".$_SESSION['deptid'];
                    $res = $obj->executequery($sql);
                    while ($display = mysqli_fetch_array($res)) {
                    ?>
                        <tr>
                            <td><?php echo $s++ ?></td>
                            <td><?php echo $display["subjectname"] ?></td>
                            <td>
                                <select name="ddlteacher[]">
                                    <?php
                                    // Fetch teachers for the current department dynamically
                                    $sqlte = "select * from tblteacher where departmentid=" . $_SESSION['deptid'];
                                    $reste = $obj->executequery($sqlte);
                                    while ($displayte = mysqli_fetch_array($reste)) {
                                    ?>
                                        <option value="<?php echo $displayte["teacherid"]; ?>"><?php echo $displayte["teachername"]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="subjectid[]" value="<?php echo $display['subjectid']; ?>">
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>

</html>
<?php
include("footer.php");
?>
<script src="../jquery-3.6.0.min.js"></script>
<script>
        $(document).ready(function()
        {
            // alert("Successful");
            $("#ddlcourse").change(function()
        {
            var cid=$(this).val();
            $.ajax({
                type: "POST",
                url: "getsub.php",
                data: "cid="+cid,
                success: function(data){
                    $(".styled-table").html(data);
                }
                });
                    
                });
        });
        </script>