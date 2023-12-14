<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfCashier.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/cashier/includes_get_complete_requirements_students_route.php";

$title = "Cashier - Registered Students";

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
            <h4 class="fw-bold">REGISTERED STUDENTS WITH COMPLETE REQUIREMENS</h4>
        </div>

           <div class="table-responsive">
              <table id="sectionsTable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">School Number</th>
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
                          <td>{$student['first_name']} {$student['last_name']}</td>
                          <td>{$student['email']}</td>
                          <td>{$student['school_number']}</td>
                          <td>".($student['section_name'] == NULL ? 'None' : $student['section_name']." ".$student['section_grade'])."</td>
                          <td>
                          <a class='btn btn-sm btn-primary fw-bold' href='update-payment.php?id=".$student['id']."'>ADD PAYMENT</a>
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
<script> setActive('registered_students_tab'); </script>