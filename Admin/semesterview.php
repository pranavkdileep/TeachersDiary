<?php
include ("header.php");
include_once ("../dboperation.php");
$obj = new dboperation();
$s = 1;
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
        <>.btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }

        .edit-btn {
            background-color: #4CAF50;
            /* color: white; */
        }

        .view-btn {
            background-color: #008CBA;
            color: white;
        }

        .delete-btn {
            background-color: #f44336;
            /* color: white; */
        }

        .fa {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="container">

        <table class="styled-table">
        
                
            
            <h1>Semester List</h1><br>
            <a href="semesterreg.php"><button type="button" class="btn btn-info"
                        style="margin-left: 90%">+ADD</button></a>
            Department <select class="form-control" id="ddldeptname" name="ddldeptname">
                <option>----Select----</option>
                <?php
                $sql1 = "select*from tbldepartment";
                $res1 = $obj->executequery($sql1);
                while ($display1 = mysqli_fetch_array($res1)) {
                    ?>
                    <option value="<?php echo $display1["departmentid"]; ?></option>">
                        <?php echo $display1["departmentname"]; ?>
                    </option>
                    <?php
                }
                ?>
                </select>
                <thead><br>
                    <tr>
                        <th>Slno</th>
                        <!-- <th>Department</th> -->
                        <th>Program</th>
                        <th>Semester</th>
                        <th style="color:green">Edit</th>
                        <th style="color:Red">Delete</th>
                        <!-- <th>Delete</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "select * from tblcourse tp inner join tblsemester tc ON tp.courseid=tc.courseid inner join tbldepartment td ON tp.departmentid=td.departmentid ";
                    $res = $obj->executequery($sql);
                    while ($display = mysqli_fetch_array($res)) {
                        ?>
                        <tr>
                            <td><?php echo $s++ ?></td>
                            <!-- <td><?php echo $display["departmentname"] ?></td> -->
                            <td><?php echo $display["coursename"] ?></td>
                            <td><?php echo $display["semestername"] ?></td>
                            <td>
                                <a href="semestereditview.php?id=<?php echo $display['semesterid'] ?>">
                                    <button class="btn edit-btn"><i class="fas fa-edit"></i></button></a>
                            </td>
                            <td>
                                <a href="semesterdelete.php?id=<?php echo $display['semesterid'] ?>">
                                    <button class="btn delete-btn" name="delete"><i class="fas fa-trash-alt"></i></button>
                            </td></a>
                        </tr>
                        <?php
                    }
                    ?>
                    </tr>
                </tbody>
        </table>
    </div>
</body>

</html>
<?php
include ("footer.php");
?>
<!-- HTML !-->
<!-- <button class="button-3" role="button">Button 3</button> -->
