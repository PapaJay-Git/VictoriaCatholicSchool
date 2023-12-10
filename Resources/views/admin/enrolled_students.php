<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_complete_requirements_students_route.php";

$title = "Admin - Students with payment and required requirements";

$count = 1;

require_once "../includes/header_layout.php";

function cropText($text, $maxLength = 25, $ellipsis = '...') {
    return mb_strlen($text) > $maxLength ? mb_substr($text, 0, $maxLength) . $ellipsis : $text;
}

?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h4 class="fw-bold">ENROLLED STUDENTS</h4>
            <a href="students.php" class="btn btn-danger fw-bold btn-sm">BACK</a>
        </div>

           <div class="table-responsive">
              <table id="sectionsTable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">School Number</th>
                    <th scope="col">Section</th>
                    <th scope="col">Payment Type</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody id="tbody-sections">
                <?php
                  foreach($students as $student){
                    echo "
                      <tr>
                          <td>".$count++."</td>
                          <td>{$student['first_name']} {$student['last_name']}</td>
                          <td>{$student['username']}</td>
                          <td>{$student['email']}</td>
                          <td>{$student['school_number']}</td>
                          <td>".($student['section_name'] == NULL ? 'None' : $student['section_name']." ".$student['section_grade'])."</td>
                          <td class='text-uppercase fw-bold text-primary'>".$student['payment_type']." PAYMENT</td>
                          <td>".($student['descriptive_balance'] == NULL ? '<b>None</b>' : cropText($student['descriptive_balance']))."</td>
                          <td>
                          <a class='btn btn-sm btn-primary fw-bold' href='update-complete-student.php?id=".$student['id']."'>UPDATE</a>
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