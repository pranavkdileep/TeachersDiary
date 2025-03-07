<?php
session_start();
include("../../dboperation.php");
$obj=new dboperation();
$s=1;
$cid = $_POST['cid'];
$sql = "SELECT * FROM tblsubject WHERE courseid='$cid'";
$res = $obj->executequery($sql);
?>

            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Slno</th>
                        <th>Subject</th>
                        <th>Teacher</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($display = mysqli_fetch_array($res)) {
                    ?>
                        <tr>
                            <td><?php echo $s++ ?></td>
                            <td><?php echo $display["subjectname"] ?></td>
                            <td>
                                <select name="ddlteacher[]" class="form-select">
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
        </form>
    </div>  