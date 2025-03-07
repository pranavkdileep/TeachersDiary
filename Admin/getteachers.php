<?php
include("../dboperation.php");
$obj=new dboperation();
$s=1;
$did = $_POST['did'];
$sql = "SELECT 
tc.teacherid,
tc.teachername,
tc.teacheremail,
tc.teacherphone,
tc.teacherusername,
tc.teacherpassword,
tc.teacherrole,
tp.departmentname
FROM tbldepartment tp 
INNER JOIN tblteacher tc ON tp.departmentid = tc.departmentid 
WHERE tp.departmentid = '$did'";
$res = $obj->executequery($sql);
?>

<div class="row">

    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <h5 class="card-title fw-semibold mb-4 al">Teacher List</h5>
          <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
              <thead class="text-dark fs-4">
                <tr>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Sl no</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Name</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Email</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Phno</h6>
                  </th>
                  <!-- <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Username</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Password</h6>
                  </th> -->
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Role</h6>
                    </th>
                    <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Department</h6>
                    </th>
                <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Edit</h6>
                    </th>
                 <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Delete</h6>
</th>
              </thead>
              <tr>

              <?php
while ($display = mysqli_fetch_array($res)) 
{
 ?>  
  <td><?php echo $s++?></td>
                        <td><?php echo $display["teachername"]?></td>
                        <td><?php echo $display["teacheremail"]?></td>
                        <td><?php echo $display["teacherphone"]?></td>
                        <!-- <td><?php echo $display["teacherusername"]?></td>
                        <td><?php echo $display["teacherpassword"]?></td> -->
                        <td><?php echo $display["teacherrole"]?></td>
                        <td><?php echo $display["departmentname"]?></td>
                        


<td class="border-bottom-0">


                      <div class="d-flex align-items-center gap-2">
                        <a href="teachereditview.php?id=<?php echo $display['teacherid']?>" class="btn btn-success mb-3">
                          <i class="ti ti-edit"></i>
                        </a>


                      </div>
                    </td>







<td class="border-bottom-0">


                      <div class="d-flex align-items-center gap-2">
                        <a href="teacherdelete.php?id=<?php echo $display['teacherid']?>" class="btn btn-danger mb-3">
                          <i class="ti ti-trash"></i>
                        </a>
                      </div>
                    </td>
                    </tr>
 <?php
}
?>

















<!-- <table class="styled-table">
            <thead>
                <tr>
                    <th>Slno</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phno</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th>Department</th>
                    <th style="color:green">Edit</th>
                    <th style="color:Red">Delete</th>
                <th>Delete</th> 
                </tr>
            </thead>
            <tbod>
<?php
while ($display = mysqli_fetch_array($res)) 
{
 ?>  
  <td><?php echo $s++?></td>
                        <td><?php echo $display["teachername"]?></td>
                        <td><?php echo $display["teacheremail"]?></td>
                        <td><?php echo $display["teacherphone"]?></td>
                        <td><?php echo $display["teacherusername"]?></td>
                        <td><?php echo $display["teacherpassword"]?></td>
                        <td><?php echo $display["teacherrole"]?></td>
                        <td><?php echo $display["departmentname"]?></td>
                        
                 <td > 
                <a href="teachereditview.php?id=<?php echo $display['teacherid']?>">
                <button class="btn edit-btn"><i class="fas fa-edit"></i></button></a> 
                </td>
                <td>
                 <a href="teacherdelete.php?id=<?php echo $display['teacherid']?>">    
                <button class="btn delete-btn" name="delete"><i class="fas fa-trash-alt"></i></button>
                </td></a>
                </tr>

                </tr>

 <?php
}
?> -->
