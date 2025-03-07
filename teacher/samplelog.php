<?php
session_start();
include_once("header.php");
include_once("../dboperation.php");
$obj = new dboperation();
//$id = $_SESSION['loginid'];
$sql = "SELECT * FROM tblcourse";
$res = $obj->executequery($sql);
$s = 1;
?>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $(".course").change(function() {
        var courseid = $(this).val();
        alert(courseid)
        var ddlsubject = $(this).closest("tr").find(".ddlsubject");
        $.ajax({
            type: "POST",
            url: "getsubject.php",
            data: { courseid: courseid },
            success: function(data) {
                ddlsubject.val(data); // Update the value of the text box
            }
        });
    });
});
</script>

</head>
<body>
    <form method="POST" action="viewaction.php">
    <table>
        <thead>
            <tr>
                <th>Sl No.</th>
                <th>Remark</th>
                <th>Course</th>
                <th>Subject</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $s = 1;
            while($s <= 6) {
                ?>
                <tr>
                    <td><?php echo $s++;?></td>
                    <td><input type="text" name="remark[]" class="remark"></td>
                    <td>
                        <select class="form-control course" name="ddlcourse[]" class="course">
                            <option value="0">---Select Course---</option>
                            <?php
                            mysqli_data_seek($res, 0); // Reset result pointer to start
                            while($display = mysqli_fetch_array($res)) {
                                ?>             
                                <option value="<?php echo $display['courseid'];?>">
                                    <?php echo $display['coursename'];?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                    <select class="form-control course" name="ddlsubject[]">
                            <option value="0">---Select Subject---</option>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <button type="submit" name="submit">Save</button>
        </form>
</body>
</html>
<?php
include_once("footer.php");
?>