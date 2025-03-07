<?php
session_start();
include("../../dboperation.php");
$obj=new dboperation();
$s=1;
$id = $_POST['semester'];
$cid=$_POST['courseid'];
// $sql = "SELECT * FROM tblsubject WHERE semester='$id'";
// $res = $obj->executequery($sql);
?>
<html>
    <head>
    </head>
    <body>
    <form action="suballocationaction.php" method="post">
    <table class="styled-table" id="styled-table">
                <br>
                <!-- <thead>
                    <tr>
                        <th>Slno</th>
                        <th>Subject</th>
                        <th>Teacher</th>
                    </tr>
                </thead> -->
                <tbody>
                    <?php
                    $sql = "select * from tblsubject ts inner join tblcourse tc on ts.courseid=tc.courseid where ts.semester='$id' and tc.courseid='$cid' and tc.departmentid=" .$_SESSION['deptid'];
                    $res = $obj->executequery($sql);
                    while ($display = mysqli_fetch_array($res)) {
                    ?>
                        <tr>
                            <td><?php echo $s++ ?></td>
                            <td><?php echo $display["subjectname"] ?></td>
                            <td>
                                <select name="ddlteacher[]" class="form-select" required>
                                    <option value="">---Select---</option>
                                    <?php
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
                   <tr>
                            <td colspan="3">
                            <button type="submit" name="save" class="btn btn-primary" style="margin-left: 1019px;">Submit</button>
                            </td>
                        </tr>
                </tbody>
                
            </table>
            <!-- <center>
                <button type="submit" name="save">Submit</button>
            </center> -->
            <!-- <center>
                        <button type="submit" name="save" class="btn btn-primary">Submit</button>
                    </center> -->
        </form>
        </body>
        </html>