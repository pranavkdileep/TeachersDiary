
<?php
include("header.php");
include_once("../../dboperation.php");
$obj=new dboperation();
$s=1;
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Table</title>
    <link rel="stylesheet" href="styletable.css">
</head>
<div>
<table class="styled-table">
<thead>
                <tr>
                    <th>Hour</th>
                    <th>Class/Course</th>
                    <th>Subject</th>
                    <th>Module</th>
                    <th>Topics</th>
                    <th>Submitted Date</th>
                    <!-- <th>Edit</th> -->
                    <!-- <th>Delete</th> -->
                </tr>
            </thead>
<?php
if(isset($_POST['submit']))
{
    $tid=$_POST["teacherid"];
    $todate=$_POST['sdate'];
    $fromdate=$_POST['edate'];
    echo "<html> hi- $todate";
    $sql="select * from tblteacherlog tp inner join tblcourse tc ON tp.courseid=tc.courseid inner join tblsubject ts ON tp.subjectid=ts.subjectid where tp.teacherid='$tid' and  tp.submitteddate between '$fromdate' and '$todate'";
    $res=$obj->executequery($sql);
    $row=mysqli_num_rows($res);
    if($row>=1)
    {
            echo "<html><h1>Report Between $fromdate / $todate";
                // $sql="select * from tblteacherlog tp inner join tblcourse tc ON tp.courseid=tc.courseid inner join tblsubject ts ON tp.subjectid=ts.subjectid where tp.teacherid='$id'";
                // $res=$obj->executequery($sql);
                while($display=mysqli_fetch_array($res)){
                    ?>
                  
            <tbody>
                <tr>
                    <td><?php echo $s++ ?></td>
                    <td><?php echo $display["coursename"]?></td>
                    <td><?php echo $display["subjectname"]?></td>
                    <td><?php echo $display["module"]?></td>
                    <td><?php echo $display["topic"]?></td>
                    <td><?php echo $display["submitteddate"]?></td>

                    <!-- <td> <button type="button"><span style="color:black">Edit</span></button></td> -->
                    <!-- <td> <button type="button"><span style="color:black">Delete</span></button></td> -->
                </tr>
                <?php
                }
                ?>
                   </tbody>
        </table><br>
        <form action="verificationaction.php" method="post">
        <div class="row" style="margin-left:100px;">
    <label style="width: 100px;">Remark</label>
    <div class="col-sm-12">
        <textarea name="txtremark" rows="4" placeholder="Remarks" style="width: 1000px;"></textarea>
    </div>
</div><br>
        <center>
        <button type="submit" name="submit" >Approved</button>  
        <button type="submit" name="reject" >Rejected</button>  
        </center>  
    <input type="hidden" name="teacherid" value="<?php echo $tid;?>">
    <input type="hidden" name="fromdate" value="<?php echo $fromdate;?>">
    <input type="hidden" name="todate" value="<?php echo $todate;?>">


        </form> 
        </body>     
        <?php
    }

    else
    {
        echo "<html><h2>No Data Found</h2></html>";
    }
}
?>
<?php
include("footer.php");
?>