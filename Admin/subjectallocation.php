<?php
include("header.php");
include_once("../dboperation.php");
$obj=new dboperation();
$s=1;
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department List</title>
    <link rel="stylesheet" href="styletable.css">

    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>   <> .btn {
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
        }</style>
</head>
<body>
    <div class="container">
        <h1>Subject Allocation</h1><br>
        <select class="form-control" required>
            <option value="">----Select----</option>
            <?php
            $sql="select*from tblcourse where departmentid=1";
            $res=$obj->executequery($sql);
            while($display=mysqli_fetch_array($res)){
                ?>
                <option value="<?php echo $display["courseid"]; ?>"><?php echo $display["coursename"]; ?>
            </option>
            <?php
            }
            ?>
        </select>
 <table class="styled-table">
            <br>
            <thead>
                <tr>
                    <th>Slno</th>
                    <th>Department</th>
                    <th style="color:green">Edit</th>
                    <th style="color:Red">Delete</th>
                    <!-- <th>Delete</th> -->
                </tr>
            </thead>
            <tbod>
                    <?php    
            $sql ="select * from tbldepartment ";
                      $res=$obj->executequery ($sql);
                      while($display=mysqli_fetch_array($res)){
                       ?> 
                          <td><?php echo $s++?></td>
                          <td><?php echo $display["departmentname"]?></td>
                <td>
                <a href="depteditview.php?id=<?php echo $display['departmentid']?>"> 
                <button class="btn edit-btn"><i class="fas fa-edit"></i></button></a></td>
                <td>
                <a href="deptdelete.php?id=<?php echo $display['departmentid']?>">    
                <button class="btn delete-btn" name="delete"><i class="fas fa-trash-alt"></i></button></td></a>
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
include("footer.php");
?>
<!-- HTML !-->
<!-- <button class="button-3" role="button">Button 3</button> -->

