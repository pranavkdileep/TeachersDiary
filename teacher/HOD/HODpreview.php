<?php
include("header.php");
include("../../dboperation.php");
$obj=new dboperation();
$s=1;
$id=$_GET["id"];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Table</title>
    <link rel="stylesheet" href="styletable.css">
</head>
<body>
    <form action="getdate.php" method="POST">
    <div class="container">
        <h1>Logbook Preview</h1>
        From:<input type="date" name="fromdate" class="form-control"> -  To:<input type="date" name="todate" class="form-control" id="todate">
        <button type="submit" name="submit">Submit</button>
        <br><br>
 <table class="styled-table">
            <thead>
                <tr>
                    <th>Hour</th>
                    <th>Class/Course</th>
                    <th>Subject</th>
                    <th>Module</th>
                    <th>Topics</th>
                    <!-- <th>Edit</th> -->
                    <!-- <th>Delete</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $sql="select * from tblteacherlog tp inner join tblcourse tc ON tp.courseid=tc.courseid inner join tblsubject ts ON tp.subjectid=ts.subjectid where tp.teacherid='$id'";
                $res=$obj->executequery($sql);
                while($display=mysqli_fetch_array($res)){
                    ?>
                <tr>
                    <td><?php echo $s++ ?></td>
                    <td><?php echo $display["coursename"]?></td>
                    <td><?php echo $display["subjectname"]?></td>
                    <td><?php echo $display["module"]?></td>
                    <td><?php echo $display["topic"]?></td>
                    <!-- <td> <button type="button"><span style="color:black">Edit</span></button></td> -->
                    <!-- <td> <button type="button"><span style="color:black">Delete</span></button></td> -->
                </tr>
                <?php
                }
                ?>
                   </tbody>
        </table>
    </div>
    <input type="hidden" name="teacherid" value="<?php echo $id;?>">
    </form>
</body>
</html>
<?php
include("footer.php");
?>
<!-- <script src="../jquery-3.6.0.min.js"></script>
<script>
        $(document).ready(function()
        {
            // alert("Successful");
            $("#todate").change(function()
            
        {
            var did=$(this).val();
            $.ajax({
                type: "POST",
                url: "getdate.php",
                data: "did="+did,
                success: function(data){
                    $(".styled-table").html(data);
                }
                });
                    
                });
        });
        </script> -->
