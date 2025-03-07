<?php
include("header.php");
?> 
<div class="container-fluid">
<div class="row">
             <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
        
              <a href="deptview.php"  class="btn btn-primary mb-3">View Department     <i class="ti ti-eye"></i></a>
              </ul>
              </div>


        </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Department Registration</h5>
              <div class="card">
                <div class="card-body">
                  <form action="deptregaction.php" method="post">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Department Name:</label>
                      <input type="text" name="DepartmentName" placeholder="Enter dept name" required class="form-control" required>
                      
                    </div>
                    
                     <input type="submit" value="Add" name="save" class="btn btn-primary">
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

























