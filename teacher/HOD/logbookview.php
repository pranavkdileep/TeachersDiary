<?php
// session_start();
include("header.php");
include("../../dboperation.php");
$obj = new dboperation();
$s = 1;
?>

<div class="container-fluid">
  <div class="row">
    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
      <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
        <!-- Optional Button for Additional Actions -->
      </ul>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">  
      <div class="card w-100">
        <div class="card-body p-4">
          <h5 class="card-title fw-semibold mb-4">Logbook Preview</h5>

          <div class="mb-3">
            <label for="startdate" class="form-label">Select Start Date:</label>
            <input type="date" name="startdate" id="startdate" class="form-control" <?php echo 'max="' . date('Y-m-d').'"';?> onchange="updateToDate()">
          </div>
    
          <div class="mb-3">
            <label for="enddate" class="form-label">Select End Date:</label>
            <input type="date" name="enddate" id="enddate" class="form-control" <?php echo 'min ="' . date('Y-m-d').'"';?> >
          </div>

          <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle styled-table">
              <thead class="text-dark fs-4">
                <!-- <tr>
                  <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Hour</h6></th>
                  <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Class/Course</h6></th>
                  <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Semester</h6></th>
                  <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Subject</h6></th>
                  <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Module</h6></th>
                  <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Topics</h6></th>
                  <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Status</h6></th>
                  <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Edit</h6></th>
                </tr> -->
              </thead>
              <tbody id="table-body">
                <!-- Data will be populated here by AJAX -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("footer.php"); ?>
<script src="../../jquery-3.6.0.min.js"></script>
    <script>
        function updateToDate() {
            var fromDateInput = document.getElementById('startdate');
            var fromDateValue = fromDateInput.value;
            if (fromDateValue) {
                var toDateInput = document.getElementById('enddate');
                toDateInput.setAttribute('min', fromDateValue);
                // Clear the To date if it is before the new minimum
                if (toDateInput.value < fromDateValue) {
                    toDateInput.value = '';
                }
            }
        }
    </script>

<script src="../../jquery-3.6.0.min.js"></script>
<script>
 $(document).ready(function() {
    // Ensure jQuery is loaded correctly
    if (typeof jQuery === "undefined") {
        console.error("jQuery is not loaded");
        return;
    }

    // Event handler for both date inputs
    $("#startdate, #enddate").change(function() {
        var startDate = $("#startdate").val();
        var endDate = $("#enddate").val();
        
        // Check if both dates are selected
        if (startDate && endDate) {
            $.ajax({
                type: "POST",
                url: "logbookviewaction.php",  // Ensure the path to the PHP file is correct
                data: { startdate: startDate, enddate: endDate }, // Send both dates
                success: function(data) {
                    console.log("Success:", data); // Debugging success
                    $("#table-body").html(data); // Populate the table with the returned data
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error, xhr.responseText); // Debugging error
                }
            });
        } else {
            $("#table-body").empty(); // Clear the table if dates are not selected
        }
    });
});
</script>
