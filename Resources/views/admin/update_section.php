<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_one_section_route.php";

$title = "Admin - Update Grade $gradeID Section";

require_once "../includes/header_layout.php";

function getSession($data) {
  global $row;

  if (isset($_SESSION[$data])) {
    $session_value = $_SESSION[$data];
    unset($_SESSION[$data]);
    return $session_value;
  }

    return $row[$data];
}
?>
<body>
<?php 
    include "includes/navbar.php";
?>
<div class="container my-5">
    <div class="pb-2 px-2">
        <h5 class="mb-5 fw-bold">UPDATE GRADE <?php echo $gradeID ?> SECTION NAME</h5>
        <form method="POST" action="../../../Backend-routes/admin/update_section_name_route.php?" onsubmit="submitRequest('updateSectionName', event)" id="updateSectionName">
            <input type="hidden" name="grade" value="<?php echo $gradeID ?>">
            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
            <div class="mb-3 m-w-300px">
                <label class="form-label fw-bold">SECTION NAME</label>
                <input type="text" class="form-control" name="name" required placeholder="Section Name"? <?php echo "value='".htmlspecialchars(getSession('name'))."'"  ?> >
            </div>
            <div class="d-flex justify-content-end my-5">
                <button class="btn btn-sm fw-bold btn-primary me-1" type="submit">UPDATE</button>
                <a href="view_sections.php?id=<?php echo $gradeID ?>" class="btn btn-danger btn-sm fw-bold">BACK</a>
            </div>

        </form>
    </div>
</div>
</body>
<?php
	require_once "../includes/includes_scripts.php";
?>
<script> setActive('sections_tab'); </script>