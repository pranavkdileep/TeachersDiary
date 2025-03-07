<?php
session_start();
include("header.php");
include("../../dboperation.php");
$obj=new dboperation();
$s=1;
$tid=$_SESSION['teacherid'];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Table</title>
    <link rel="stylesheet" href="styletable.css">
</head>
<body>
    <div class="container">
        <h1>Logbook Preview</h1>
 <table class="styled-table">
            <thead>
                <tr>
                    <th>Hour</th>
                    <th>Class/Course</th>
                    <th>Subject</th>
                    <th>Module</th>
                    <th>Topics</th>
                    <th>Edit</th>
                    <!-- <th>Delete</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $sql="select * from tblteacherlog tp inner join tblcourse tc ON tp.courseid=tc.courseid inner join tblsubject ts ON tp.subjectid=ts.subjectid where tp.teacherid='$tid'";
                $res=$obj->executequery($sql);
                while($display=mysqli_fetch_array($res)){
                    ?>
                <tr>
                    <td><?php echo $s++ ?></td>
                    <td><?php echo $display["coursename"]?></td>
                    <td><?php echo $display["subjectname"]?></td>
                    <td><?php echo $display["module"]?></td>
                    <td><?php echo $display["topic"]?></td>
                    <td> <button type="button"><span style="color:black">Edit</span></button></td>
                    <!-- <td> <button type="button"><span style="color:black">Delete</span></button></td> -->
                </tr>
                <?php
                }
                ?>
                   </tbody>
        </table>
    </div>
</body>
</html>
<?php
include("footer.php");
?>
