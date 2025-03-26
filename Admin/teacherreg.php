<?php
include("header.php");
include_once("../dboperation.php");
$obj = new dboperation();
?>
<div class="container-fluid">
  <div class="row">
    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
      <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

        <a href="teacherview.php" class="btn btn-primary mb-3">View Teachers<i class="ti ti-eye"></i></a>
      </ul>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4">Teacher Registration</h5>
      <div class="card">
        <div class="card-body">
          <form action="teacherregaction.php" method="post">
            <div class="mb-3">
              Department:<select name="ddldeptname" class="form-control" required>
                <option value="">-----select-----</option>
                <?php
                $sql = "SELECT * From tbldepartment";
                $res = $obj->executequery($sql);
                while ($display = mysqli_fetch_array($res)) {
                  ?>
                  <option value="<?php echo $display["departmentid"]; ?>">
                    <?php echo $display["departmentname"]; ?>
                  </option>
                  <?php
                }
                ?>
              </select><br>
              <label for="exampleInputEmail1" class="form-label">Teacher Name:</label>
              <input type="text" name="txtfacultyname" placeholder="Enter teacher name" class="form-control" required>







            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Email:</label>
              <input type="email" name="txtemail" placeholder="Enter Email" class="form-control"
                title="must enter a valid email address" id="email" required>



            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Phone:</label>
              <input type="text" name="txtphone" placeholder="Enter Phone no" class="form-control" required
                pattern="[0-9]{10}" required title="Must contain 10 digits">
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Username:</label>
              <input type="text" name="txtusername" placeholder="Enter Username" required class="form-control" required>

            </div>
            <!-- <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label"> password:</label>
              <input type="password"  name="txtpassword" placeholder="Enter your password"
                 pattern="(?=.\d)(?=.[a-z])(?=.*[A-Z]).{8,}"
                title="Password Must Contain: Uppercase, Lowercase, Number (8+ chars)" required class="form-control">
            </div> -->
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label"> password:</label>
              <input type="password" name="txtpassword" placeholder="Enter Password" required class="form-control"
                required>
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Select Role:</label><br>
              <label for="exampleInputEmail1" class="form-label">
                <input type="radio" name="txtrole" value="HOD" required>HOD
              </label>
              <label for="exampleInputEmail1" class="form-label" style="margin-left: 15px;">
                <input type="radio" name="txtrole" value="staff" required>Teacher
              </label><br>
            </div>
            <input type="submit" value="Register" name="save" class="btn btn-primary" onclick="emailvalidation()">
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
</div>

<?php
include("footer.php");
?>
<script src="../jquery-3.6.0.min.js"></script>
<script>
  function emailvalidation() {
  
    var email = document.getElementById('email').value;
    var emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i;

    if (!emailPattern.test(email)) {
      alert('Please enter a valid email address.');
      event.preventDefault(); // Prevent form submission
    }
    else {
      return true;
    }

  };
</script>