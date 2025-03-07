<?php
include("header.php");
?> 

<div class="container-fluid">
    <div class="row">
    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
      <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

        <a href="academicyearview.php" class="btn btn-primary mb-3">Academic Year View <i class="ti ti-circle-plus"></i></a>
      </ul>
    </div>
    <div class="card">
    <div class="card-body">
    <h2>Academic Year Registration</h2>
        <form action="academicyearaction.php" method="post">
           Academic Year: <input type="text" name="txtayear" placeholder="Enter year" required class="form-control" required><br>
            <input type="submit" value="Register" name="save" class="btn btn-primary">
            </form>
            </div>
            </div>
            </div>
            </div>
<?php
include("footer.php");
?> 