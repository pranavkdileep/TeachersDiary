<?php
include("../dboperation.php");
$obj = new dboperation();
$sid = $_POST['sid'];
$cid = $_POST['cid'];
$s = 1;
 $sql = "select * from tblsubject tp inner join tblcourse tc ON tp.courseid=tc.courseid where tp.semester='$sid' AND tp.courseid='$cid'";
$res = $obj->executequery($sql);
?>
<div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4 al">Department List</h5>
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Sl no</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Class</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Semexter</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Subject</h6>
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
                                    // $sql = "select * from tblsubject tp inner join tblcourse tc ON tp.courseid=tc.courseid ";
                                    // $res = $obj->executequery($sql);
                                    while ($display = mysqli_fetch_array($res)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $s++ ?></td>
                                            <td><?php echo $display["coursename"] ?></td>
                                            <td><?php echo $display["semester"] ?></td>
                                            <td><?php echo $display["subjectname"] ?></td>

                                            <td class="border-bottom-0">
                                                <a href="subjecteditview.php?id=<?php echo $display["subjectid"] ?>"
                                                    class="btn btn-success mb-3">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                            </td>

                                            <td class="border-bottom-0">
                                                <a href="subjectdelete.php?id=<?php echo $display["subjectid"] ?>"
                                                    class="btn btn-danger mb-3">
                                                    <i class="ti ti-trash"></i>
                                                </a>
                                            </td>
                                            <?php
                                    }
                                    ?>
                                    </tr>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </body>