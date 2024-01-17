<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_complete_requirements_students_route.php";

$title = "Enrolled Students List";

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
            <h4 class="fw-bold">ENROLLED STUDENTS</h4>
            <a href="students.php" class="btn btn-danger fw-bold btn-sm">BACK</a>
        </div>

           <div class="table-responsive">
              <table class="table table-bordered table-striped"  id="sectionsTable">
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
                    $lockQuestion = $student['is_locked'] == 1 ? 'Are you sure you want to unlock this account?' : 'Are you sure you want to lock this account?';
                    echo "
                      <tr>
                          <td>".convertTxt($student['last_name'].', '.$student['first_name'])." </td>
                          <td>{$student['email']}</td>
                          <td>{$student['lrn']}</td>
                          <td>VCS00{$student['id']}</td>
                          <td>".($student['section_name'] == NULL ? 'None' : $student['section_name']." ".$student['section_grade'])."</td>
                          <td class='text-primary'>".($student['payment_type'] == 'down' ? ($paidMonthsCount == 9 ? 'FULLY PAID' : 'INSTALLMENT') : 'FULL PAYMENT')."</td>
                          <td>
                          <a href='/student_full_info'>PRINT</a>
                          <a class='btn btn-sm btn-primary fw-bold' href='update-complete-student.php?id=".$student['id']."'>UPDATE</a>
                          ";
                          ?>
                           <form class="d-inline" method="GET" action="../../../Backend-routes/admin/lock_user.php" onsubmit="submitRequest('lockUser<?php echo $student['id'] ?>', event, '<?php echo $lockQuestion; ?>')" id="lockUser<?php echo $student['id'] ?>">

                          <input type="hidden" name="id" value="<?php echo $student['id'] ?>">
                          <input type="hidden" name="url" value="enrolled_students.php">
                          <?php
                            if($student['is_locked'] == 1){
                              echo '<button class="btn btn-sm fw-bold btn-dark" type="submit">LOCKED</button>';
                            }else{
                              echo '<button class="btn btn-sm fw-bold btn-success" type="submit">LOCK</button>';
                            }

                          ?>  
                          </form>
                          <?php
                      echo "
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