<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfCashier.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/cashier/includes_get_registered_students_route.php";

$title = "Cashier - Student Balance";

$count = 1;

require_once "../includes/header_layout.php";

function cropText($text, $maxLength = 25, $ellipsis = '...') {
    return mb_strlen($text) > $maxLength ? mb_substr($text, 0, $maxLength) . $ellipsis : $text;
}

$currentYear = date('Y');

$currentMonth = date('n');

if ($currentMonth >= 5) {
    $currentYear += 1;
}else{
    $currentYear -= 1;
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
            <h4 class="fw-bold">ENROLLED STUDENT BALANCE</h4>
        </div>

           <div class="table-responsive">
              <table id="sectionsTable">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">LRN</th>
                    <th scope="col">Student No</th>
                    <th scope="col">Section</th>
                    <th scope="col">Payment Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody id="tbody-sections">
                <?php
                  foreach($students as $student){
                    $paidMonthsCount = 0; 
                    
                    $stmt = $conn->prepare("SELECT date FROM paidMonths WHERE student_id = ?");
                    $stmt->bind_param("i", $student['id']);
                    $stmt->execute(); 
                    $paidMonthsResult = $stmt->get_result();
                    $paidMonths = $paidMonthsResult->fetch_all(MYSQLI_ASSOC);

                    $monthsToCheck = ['7', '8', '9', '10', '11', '12', '1', '2', '3'];

                    foreach ($monthsToCheck as $month) {
                        $targetDate = ($month < 7) ? ($currentYear + 1) . '-' . $month : $currentYear . '-' . $month;
                    
                        if (!empty($paidMonths) && in_array($targetDate, array_column($paidMonths, 'date'))) {
                            $paidMonthsCount++;
                        }
                    }
                    echo "
                      <tr>
                          <td>".convertTxt($student['last_name'].", ".$student['first_name'])."</td>
                          <td>{$student['email']}</td>
                          <td>{$student['lrn']}</td>
                          <td>VCS00{$student['id']}</td>
                          <td>".($student['section_name'] == NULL ? 'None' : $student['section_name']." ".$student['section_grade'])."</td>
                          <td class='text-primary'>".($student['payment_type'] == 'down' ? ($paidMonthsCount == 9 ? 'FULLY PAID' : 'INSTALLMENT') : 'FULL PAYMENT')."</td>
                          <td>
                          <a class='btn btn-sm btn-primary fw-bold' href='update-balance.php?id=".$student['id']."'>UPDATE</a>
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
<script> setActive('student_balance_tab'); </script>