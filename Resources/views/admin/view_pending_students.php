<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_pending_students_route.php";

$title = "Admin - Pending Students";

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
            <h5 >PENDING STUDENTS</h5>
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
                    <th scope="col">Enrolled Grade</th>
                    <th scope="col">Student Type</th>
                    <th scope="col">Registration Date</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody id="tbody-sections">
                <?php
                  foreach($students as $student){
                    $dateTime = new DateTime($student['created_at']);
                    echo "
                      <tr>
                          <td>".$count++."</td>
                          <td>{$student['first_name']}</td>
                          <td>{$student['last_name']}</td>
                          <td>{$student['email']}</td>
                          <td>{$student['requested_grade']}</td>
                          <td>".strtoupper($student['student_type'])."</td>
                          <td>".$dateTime->format('F j, Y, g:i a')."</td>
                          <td>
                          <a class='btn btn-sm btn-primary fw-bold' href='update-pending-student.php?id=".$student['id']."'>CONFIRM</a>
                          <button class='btn btn-sm btn-danger fw-bold' onclick=".'"'."confirmDelete('../../../Backend-routes/admin/delete_student_pending_route.php?id=".$student['id']."')".'"'.">DELETE</button>
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