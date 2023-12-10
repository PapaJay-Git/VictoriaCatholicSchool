<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_all_sections_route.php";

$title = "Admin - Sections";

$count = 1;

require_once "../includes/header_layout.php";

?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold">SECTIONS</h2>
        </div>

           <div class="table-responsive">
              <table id="sectionsTable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Number of Sections</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody id="tbody-sections">
                <tr>
                      <td>
                        <small class="text-dark">
                          <?php echo $count++ ?>
                        </small>
                      </td>
                      <td>
                        <small class="text-dark">
                          Manage Advisory
                        </small>
                      </td>
                      <td>
                        <?php echo $sectionCount ?>
                      </td>
                      <td>
                          <a class="btn btn-sm btn-primary fw-bold" href="view_advisory.php">OPEN</a>
                      </td>
                    </tr>
                  <?php
                  foreach($result as $row){
                    ?>
                    <tr>
                      <td>
                        <small class="text-dark">
                          <?php echo $count++ ?>
                        </small>
                      </td>
                      <td>
                        <small class="text-dark">
                          Grade <?php echo $row['grade'] ?>
                        </small>
                      </td>
                      <td>
                        <?php echo $row['section_count'] ?>
                      </td>
                      <td>
                          <a class="btn btn-sm btn-primary fw-bold" href="view_sections.php?id=<?php echo $row['grade'] ?>">OPEN</a>
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
<script> setActive('sections_tab'); </script>