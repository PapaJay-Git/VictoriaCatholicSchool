<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_specific_sections_route.php";

$title = "Admin - Grade $accountID Sections";

$count = 1;

require_once "../includes/header_layout.php";

function getSession($data) {
    if (isset($_SESSION[$data])) {
      $session_value = $_SESSION[$data];
      unset($_SESSION[$data]);
      return $session_value;
    }
  
    return null; 
}

?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h5 class="fw-bold">GRADE <?php echo $accountID ?> SECTIONS</h5>
            <div class="btn-group">
                <a href="teacher-add.php" class="btn btn-sm fw-bold btn-dark" data-bs-toggle="modal" data-bs-target="#addModal">ADD SECTION</a>
                <a href="sections.php" class="btn btn-sm btn-danger fw-bold">BACK</a>
            </div>
        </div>

           <div class="table-responsive">
              <table id="sectionsTable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Section Name</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody id="tbody-sections">
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
                          <?php echo strtoupper($row['name']) ?>
                        </small>
                      </td>
                      <td>
                          <a class="btn btn-sm btn-primary fw-bold" href="manage_section.php?id=<?php echo $row['id'].'&grade='.$accountID ?>">MANAGE</a>
                          <a class="btn btn-sm btn-primary fw-bold" href="update_section.php?id=<?php echo $row['id'].'&grade='.$accountID ?>">UPDATE</a>
                          <button class="btn btn-sm btn-danger fw-bold" onclick="confirmDelete('../../../Backend-routes/admin/delete_section_route.php?id=<?php echo $row['id'].'&grade='.$accountID ?>', 'Section')">DELETE</button>
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


    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <form method="POST" action="../../../Backend-routes/admin/add_new_section_route.php" onsubmit="submitRequest('addSectionForm', event)" id="addSectionForm">
            <div class="modal-header">
              <h5 class="modal-title fw-bold" id="exampleModalLabel">SECTION FOR <?php echo $accountID?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" value="<?php echo $accountID ?>">
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">Section Name</label>
                  <input type="text" class="form-control form-control-sm" name="section_name" required placeholder="Section name" 
                  <?php echo "value='".htmlspecialchars(getSession('section_name'))."'"  ?> >
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm fw-bold btn-primary" type="submit">SUBMIT</button>
                <button type="button" class="btn btn-sm fw-bold btn-secondary" data-bs-dismiss="modal">CLOSE</button>
            </div>
            </form>
          </div>
        </div>
    </div>
<?php
	require_once "../includes/includes_scripts.php";
?>
<script src="../../js/admin/sections.js"></script>
<script> setActive('sections_tab'); </script>