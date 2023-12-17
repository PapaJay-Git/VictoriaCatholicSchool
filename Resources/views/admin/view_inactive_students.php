<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_inactive_students_route.php";

$title = "Admin - Inactive Students";

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
            <h2 class="fw-bold">INACTIVE STUDENTS</h2>
            <div class="btn-group">
                <a href="students.php" class="btn btn-sm btn-danger fw-bold">BACK</a>
            </div>
        </div>

           <div class="table-responsive">
              <table id="sectionsTable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">School ID</th>
                    <th scope="col">Section</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody id="tbody-sections">
                <?php
                  foreach($students as $student){
                    echo "
                      <tr>
                          <td>".$count++."</td>
                          <td>{$student['first_name']}</td>
                          <td>{$student['last_name']}</td>
                          <td>{$student['email']}</td>
                          <td>{$student['school_number']}</td>
                          <td>".($student['section_name'] == NULL ? 'None' : $student['section_name']." - ".$student['section_grade'])."</td>
                          <td>
                          <a class='btn btn-sm btn-primary fw-bold' href='update-inactive-student.php?id=".$student['id']."'>UPDATE</a>
                          </td>
                      </tr>
                  ";
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
<script> setActive('students_tab'); </script>