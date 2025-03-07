<?php
include("header.php");
include_once("../dboperation.php");
$obj = new dboperation();
$s = 1;

// Check if a department ID is passed via the URL
$dept_id = isset($_GET['dept']) ? $_GET['dept'] : 0;
?>
<div class="container-fluid">  
        <div class="row">
             <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
            <a href="#" id="addProgramBtn" class="btn btn-primary mb-3">
                    Add Program<i class="ti ti-circle-plus"></i>
                </a>
              <!-- <a href="coursereg.php"  class="btn btn-primary mb-3">Add Program<i class="ti ti-circle-plus"></i></a> -->
              </ul>
              <label for="exampleInputEmail1" class="form-label">Select Department</label>
              <select class="form-control" id="dept">
                <option value="0">----Select----</option>
                <?php
                $sql1 = "select*from tbldepartment";
                $res1 = $obj->executequery($sql1);
                while ($display1 = mysqli_fetch_array($res1)) {
                    ?>
                    <option value="<?php echo $display1["departmentid"]; ?>"
                    <?php if ($display1["departmentid"] == $dept_id) echo 'selected'; ?>>
                        <?php echo $display1["departmentname"]; ?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="row mt-4">
         
          <div class="col-lg-12 d-flex align-items-stretch" name="course" id="course">
           
               
          
          </div>
        </div>




<?php
include("footer.php");
?>



<!-- <script src="../jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        //alert("Successful");
        $("#dept").change(function () {
            //alert("Successful2");
            var did = $(this).val();
            $.ajax({
                type: "POST",
                url: "courseviewaction.php",
                data: "did=" + did,
                success: function (data) {
                    $("#course").html(data);
                }
            });

        });
    });
</script> -->


<script src="../jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () 
{
    // If a department is selected on page load, trigger the Ajax to load courses
    var deptId = $("#dept").val();
    if (deptId != 0) 
    {
        loadCourses(deptId);  // Call the function to load courses based on department ID
    }
});

    // Trigger Ajax when the department dropdown changes
    $("#dept").change(function () {
        //alert("a")
        var did = $(this).val();
        loadCourses(did);
    });

    // Function to load courses based on department ID
    function loadCourses(did) {
       // alert(did);
        $.ajax({
            type: "POST",
            url: "courseviewaction.php",
            data: { did: did },
            success: function (data) {
                $("#course").html(data);
            }
        });
    }
    </script>

<script>
    // When "Add Program" button is clicked
    $("#addProgramBtn").click(function () {
        var selectedDept = $("#dept").val(); // Get selected department ID
        // if (selectedDept === "") {
        //     selectedDept = 0; // If no department selected, pass 0
        // }
        // Redirect to coursereg.php with the department ID as a query parameter
        window.location.href = "coursereg.php?dept=" + selectedDept;
    });

</script>