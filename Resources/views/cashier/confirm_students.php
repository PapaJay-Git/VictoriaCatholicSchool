<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfCashier.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/cashier/includes_get_pending_students_route.php";

$title = "Admin - Confirm Students";

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

function convertTxt($string = null){

  return $string == null ? '' : ucwords(strtolower($string));
}

?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h4 class="fw-bold">CONFIRM PENDING STUDENTS</h4>
        </div>

           <div class="table-responsive">
              <table id="sectionsTable">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">LRN</th>
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
                          <td>".convertTxt($student['last_name'].", ".$student['first_name'])."</td>
                          <td>{$student['email']}</td>
                          <td>{$student['lrn']}</td>
                          <td>{$student['requested_grade']}</td>
                          <td>".strtoupper($student['student_type'])."</td>
                          <td>".$dateTime->format('F j, Y, g:i a')."</td>
                          <td>
                          <a class='btn btn-sm btn-primary fw-bold' href='update-pending-student.php?id=".$student['id']."'>CONFIRM</a>
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
<script> setActive('pending_students_tab'); </script>