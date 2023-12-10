<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfCashier.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/cashier/includes_get_student_payment_route.php";

$title = "Cashier - Update Balance";

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
    <h5 class="mb-2 fw-bold" id="exampleModalLabel">ADD STUDENT PAYMENT</h5>

    <div class="pb-2 px-2 mt-5" id="info-tab" >
                    
     <form method="POST" action="../../../Backend-routes/cashier/update_student_payment_route.php" onsubmit="submitRequest('updateStudentForm', event)" id="updateStudentForm">
        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
        <label class="text-uppercase fw-bold d-block"> <?php echo "{$row['first_name']} {$row['last_name']}"; ?> BALANCE</label>
        <label class="text-uppercase fw-bold d-block ms-1"> FROM <?php echo ($row['section_name'] == NULL ? 'None' : $row['section_name']." ".$row['section_grade']); ?></label>
        <div class="mb-3 ms-1 d-flex flex-column mt-3">
            <label for="payment_type" class="fw-bold">Payment Type</label>
            <?php $payment_type = getSession('payment_type'); ?>
            <select name="payment_type" id="payment_type" class="form-control" required>
                <option value="" default selected>Select Payment Type...</option>
                <option value="down" <?php echo $payment_type == 'down'  ? 'selected' : '' ?>>Initial Down</option>
                <option value="full" <?php echo $payment_type == 'full'  ? 'selected' : '' ?>>Full Payment</option>
            </select>
        </div>
        <div class="mb-3 ms-1 d-flex flex-column mt-3">
            <label for="value" class="fw-bold">Value</label>
            <input id="value" name="value" type="double" class="form-control form-control" value="<?php echo htmlspecialchars(getSession('value'))  ?>" placeholder="Value..." required>
        </div>
        <div class="d-flex justify-content-end my-5">
            <button class="btn btn-sm fw-bold btn-primary me-1" type="submit">UPDATE</button>
            <a href="registered_students.php" class="btn btn-danger btn-sm fw-bold">BACK</a>
        </div>
                    
        </form>
    </div>
</div>
</body>
<?php
	require_once "../includes/includes_scripts.php";
?>
<script> setActive('registered_students_tab'); </script>