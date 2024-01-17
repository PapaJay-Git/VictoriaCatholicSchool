<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_all_subjects_route.php";

$title = "Subjects List";

$count = 1;

require_once "../includes/header_layout.php";

?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h5 >SUBJECTS</h5>
        </div>

           <div class="table-responsive">
              <table class="table table-bordered table-striped"  id="sectionsTable">
                <thead>
                  <tr>
                    <th scope="col">Grade</th>
                    <th scope="col">Number of Subjects</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody id="tbody-sections">
                  <?php
                  foreach($result as $row){
                    ?>
                    <tr>
                      <td >
                        <small class="text-dark">
                          <?php echo $row['grade'] ?>
                        </small>
                      </td>
                      <td>
                        <small class="text-dark">
                          <?php echo $row['subject_count'] ?>
                        </small>
                      </td>
                      <td>
                          <a class="btn btn-sm btn-primary fw-bold" href="view_subjects.php?id=<?php echo $row['grade'] ?>">OPEN</a>
                      </td>
                    </tr>
                  <?php 
                   }
                  ?>
                </tbody>
              </table>
           </div>
     </div>

</body>
<?php
	require_once "../includes/includes_scripts.php";
?>
<script src="../../js/admin/sections.js"></script>
<script> setActive('subjects_tab'); </script>