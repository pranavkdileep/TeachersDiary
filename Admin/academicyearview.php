<?php
include("header.php");
include_once("../dboperation.php");
$obj = new dboperation();
$s = 1;
?>
<div class="container-fluid">
  <div class="row">
    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
      <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

        <a href="academicyear.php" class="btn btn-primary mb-3">Academic Year Registration <i class="ti ti-circle-plus"></i></a>
      </ul>
    </div>


  </div>
  <!-- #region -->
  <div class="row">

    <div class="col-lg-12 d-flex align-items-stretch">  
      <div class="card w-100">
        <div class="card-body p-4">
          <h5 class="card-title fw-semibold mb-4 al">Academic Year List</h5>
          <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
              <thead class="text-dark fs-4">
                <tr>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Sl no</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Academic Year</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Status</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Edit</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Delete</h6>
                  </th>

                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "select * from tblacademicyear ";
                $res = $obj->executequery($sql);
                while ($display = mysqli_fetch_array($res)) {
                  ?> 
                  <tr>
                    <td class="border-bottom-0">
                      <h6 class="fw-semibold mb-0"><?php echo $s++ ?></h6>
                    </td>

                    <td class="border-bottom-0">
                      <h6 class="fw-semibold mb-1"><?php echo $display["academicyear"] ?></h6>
                    </td>

                    <td class="border-bottom-0">
                      <h6 class="fw-semibold mb-1"><?php echo $display["status"] ?></h6>
                    </td>

                    <td class="border-bottom-0">
                      <a href="academiceditview.php?id=<?php echo $display['academicid'] ?>" class="btn btn-success mb-3">
                        <i class="ti ti-edit"></i>
                      </a>

                    </td>

                    <td class="border-bottom-0">
                      <div class="d-flex align-items-center gap-2">
                        <a href="academicdelete.php?id=<?php echo $display['academicid'] ?>" class="btn btn-danger mb-3">
                          <i class="ti ti-trash"></i>
                        </a>


                      </div>
                    </td>


                  </tr>
                  <?php
                }
                ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  include("footer.php");
  ?>