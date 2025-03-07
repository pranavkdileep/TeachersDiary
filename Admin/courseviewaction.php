<?php
include("../dboperation.php");
$obj = new dboperation();

$did = $_POST['did'];
$s = 1;
$sql = "select * from tbldepartment tp inner join tblcourse tc ON tp.departmentid=tc.departmentid where tp.departmentid = '$did'";
$res = $obj->executequery($sql);
?>
<div class="card w-100">
    <div class="card-body p-4">
    <h5 class="card-title fw-semibold mb-4">Course List</h5>
    <div class="table-responsive">
        <table class="table text-nowrap mb-0 align-middle">
            <thead class="text-dark fs-4">
                <tr>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">Sl no</h6>
                    </th>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">Department</h6>
                    </th>

                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">Program</h6>
                    </th>

                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">Semester</h6>
                    </th>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">Edit</h6>
                    </th>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">Delete</h6>
                    </th>

            </thead>
            <tbody>
                <?php
                while ($display = mysqli_fetch_array($res)) {
                    ?>

                    <tr>
                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0"><?php echo $s++ ?></h6>
                        </td>

                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-1"><?php echo $display["departmentname"] ?></h6>
                        </td>

                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-1"><?php echo $display["coursename"] ?></h6>
                        </td>

                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-1"><?php echo $display["semesterno"] ?></h6>
                        </td>





                        <td class="border-bottom-0">
                            <a href="courseeditview.php?id=<?php echo $display['courseid'] ?>" class="btn btn-success mb-3">
                                <i class="ti ti-edit"></i>
                            </a>

                        </td>

                        <td class="border-bottom-0">


                            <div class="d-flex align-items-center gap-2">
                                <a href="coursedelete.php?id=<?php echo $display['courseid'] ?>"
                                    class="btn btn-danger mb-3">
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