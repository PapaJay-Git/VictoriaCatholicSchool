<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_all_students_count_route.php";

$title = "Admin - Students";

$count = 1;


require_once "../includes/header_layout.php";

?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h5 class="fw-bold">STUDENTS</h5>
        </div>

           <div class="table-responsive">
              <table id="studentsTable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Identifier</th>
                    <th scope="col">Number of Students</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody id="tbody-student">
                  
                <tr>
                    <td>
                        <small class="text-dark">
                          <?php echo $count++ ?>
                        </small>
                    </td>
                    <td>
                        <small class="text-dark">ENROLLED STUDENTS</small>
                    </td>
                    <td>
                        <small class="text-dark"><?php echo $enrolled_count ?></small>
                    </td>
                    <td>
                        <a href="enrolled_students.php" class="btn btn-sm btn-primary fw-bold">OPEN</a>
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <small class="text-dark">
                          <?php echo $count++ ?>
                        </small>
                    </td>
                    <td>
                        <small class="text-dark">REGISTERED</small>
                    </td>
                    <td>
                        <small class="text-dark"><?php echo $registered_count ?></small>
                    </td>
                    <td>
                        <a href="view_registered_students.php" class="btn btn-sm btn-primary fw-bold">OPEN</a>
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <small class="text-dark">
                          <?php echo $count++ ?>
                        </small>
                    </td>
                    <td>
                        <small class="text-dark">PENDING REGISTRATION</small>
                    </td>
                    <td>
                        <small class="text-dark"><?php echo $unregistered_count ?></small>
                    </td>
                    <td>
                        <a href="view_pending_students.php" class="btn btn-sm btn-primary fw-bold">OPEN</a>
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <small class="text-dark">
                          <?php echo $count++ ?>
                        </small>
                    </td>
                    <td>
                        <small class="text-dark">INACTIVE STUDENTS</small>
                    </td>
                    <td>
                        <small class="text-dark"><?php echo $inactive_count ?></small>
                    </td>
                    <td>
                        <a href="view_inactive_students.php" class="btn btn-sm btn-primary fw-bold">OPEN</a>
                    </td>
                  </tr>
                </tbody>
              </table>
           </div>
     </div>
</body>


<?php
	require_once "../includes/includes_scripts.php";
?>
<script src="../../js/admin/students.js"></script>
<script> setActive('students_tab'); </script>