<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfCashier.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/cashier/includes_get_student_payment_route.php";

$title = "Cashier - Student Payment";

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

$currentYear = date('Y');

$currentMonth = date('n');

if ($currentMonth >= 5) {
    $currentYear += 1;
}else{
    $currentYear -= 1;
}

$payment_type = getSession('payment_type');

?>
<body>
<?php 
    include "includes/navbar.php";
?>
<div class="container my-5">
    <h3 class="mb-2" id="exampleModalLabel">STUDENT PAYMENT</h3>

    <div class="pb-2 px-2 mt-5" id="info-tab" >
                    
     <form method="POST" action="../../../Backend-routes/cashier/update_student_payment_route.php" onsubmit="submitRequest('updateStudentForm', event)" id="updateStudentForm">
        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
        <h5 class="text-uppercase"> <?php echo "{$row['first_name']} {$row['last_name']}"; ?></h5>
        <h5 class="text-uppercase d-block ms-1"> FROM <?php echo ($row['section_name'] == NULL ? 'None' : $row['section_name']."-".$row['section_grade']); ?></h5>
        <small class=" d-block ms-1"><?php echo $row['payment_type'] == 'down'  ? 'CURRENT PAYMENT: INSTALLMENT' : ($row['payment_type'] == 'full'  ? 'CURRENT PAYMENT: FULL PAYMENT' : '') ?> </small>
        <div class="mb-3 ms-1 d-flex flex-column mt-5">
            <label for="payment_type" >PAYMENT TYPE</label>
            <select name="payment_type" id="payment_type" class="form-control" required onchange="checkPaymentType()">
                <option value="down" <?php echo $payment_type == 'down'  ? 'selected' : '' ?>>INSTALLMENT</option>
                <option value="full" <?php echo $payment_type == 'full'  ? 'selected' : '' ?>>FULL PAYMENT</option>
            </select>
        </div>
        <div class="ms-2 pt-3" id="installmentInfo" style="display: none;">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h4>TYPE: INSTALLMENT</h4>
                    <small class="d-block ms-1">MISCELLANEOUS FEE: ₱ 1,460.10</small>
                    <small class="d-block ms-1">TUITION FEE-MONTHLY: ₱ 881.10</small>
                    <small class="d-block ms-1">COMPUTER FEE-MONTHLY: ₱ 200.10</small>
                    <small class="d-block ms-1">SECURITY GUARD FEE-MONTHLY: ₱ 50.10</small>
                    <small class="d-block ms-1">OTHER FEES: ₱ 3,665.10</small>
                    <small class="d-block ms-1">TOTAL ASSESSMENT FEE: ₱ 6,256.10</small>
                    <small class="d-block ms-1">READING MATERIALS: ₱ 5,406.5</small>
                    <small class="d-block pb-1 ms-1 pt-2"><b>TOTAL DOWN PAYMENT</b>: ₱ 11,663</small>
                </div>
                <div class="col-12 col-md-6">
                    <h4>MONTHS TO BE PAID</h4>
                    <small class="d-block fw-bold text-secondary mb-2">Checked checkboxes are paid months.</small>
                    <span class="d-block mb-2 ms-1 ">
                        <small class="fw-bold text-dark">EACH MONTH</small> 
                        <small class="fw-bold text-primary ">₱1,131.3</small>
                    </span>
                    <small class="d-block ms-1  text-secondary mb-2">June is included on Down Payment.</small>
                    <div class="ms-1">
                        <input type="checkbox" id="june" checked disabled>
                        <label for="june">June <?php echo $currentYear ?></label>
                    </div>

                    <div class="ms-1">
                        <input type="checkbox" name="month[]" value="<?php echo $currentYear ?>-7" id="july" 
                        <?php echo !empty($paidMonths) && in_array($currentYear.'-7', array_column($paidMonths, 'date')) ? 'checked' : ''?> >
                        <label for="july">July <?php echo $currentYear ?></label>
                    </div>

                    <div class="ms-1">
                        <input type="checkbox" name="month[]" value="<?php echo $currentYear ?>-8" id="august"
                        <?php echo !empty($paidMonths) && in_array($currentYear.'-8', array_column($paidMonths, 'date')) ? 'checked' : ''?> >
                        <label for="august">August <?php echo $currentYear ?></label>
                    </div>

                    <div class="ms-1">
                        <input type="checkbox" name="month[]" value="<?php echo $currentYear ?>-9" id="september"
                        <?php echo !empty($paidMonths) && in_array($currentYear.'-9', array_column($paidMonths, 'date')) ? 'checked' : ''?>>
                        <label for="september">September <?php echo $currentYear ?></label>
                    </div>

                    <div class="ms-1">
                        <input type="checkbox" name="month[]" value="<?php echo $currentYear ?>-10" id="october"
                        <?php echo !empty($paidMonths) && in_array($currentYear.'-10', array_column($paidMonths, 'date')) ? 'checked' : ''?>>
                        <label for="october">October <?php echo $currentYear ?></label>
                    </div>

                    <div class="ms-1">
                        <input type="checkbox" name="month[]" value="<?php echo $currentYear ?>-11" id="november"
                        <?php echo !empty($paidMonths) && in_array($currentYear.'-11', array_column($paidMonths, 'date')) ? 'checked' : ''?>>
                        <label for="november">November <?php echo $currentYear ?></label>
                    </div>

                    <div class="ms-1">
                        <input type="checkbox" name="month[]" value="<?php echo $currentYear ?>-12" id="december"
                        <?php echo !empty($paidMonths) && in_array($currentYear.'-12', array_column($paidMonths, 'date')) ? 'checked' : ''?>>
                        <label for="december">December <?php echo $currentYear ?></label>
                    </div>

                    <div class="ms-1">
                        <input type="checkbox" name="month[]" value="<?php echo $currentYear+1 ?>-1" id="january"
                        <?php echo !empty($paidMonths) && in_array(($currentYear+1).'-1', array_column($paidMonths, 'date')) ? 'checked' : ''?>>
                        <label for="january">January <?php echo $currentYear+1 ?></label>
                    </div>

                    <div class="ms-1">
                        <input type="checkbox" name="month[]" value="<?php echo $currentYear+1 ?>-2" id="february" 
                        <?php echo !empty($paidMonths) && in_array(($currentYear+1).'-2', array_column($paidMonths, 'date')) ? 'checked' : ''?> >
                        <label for="february">February <?php echo $currentYear+1 ?></label>
                    </div>

                    <div class="ms-1">
                        <input type="checkbox" name="month[]" value="<?php echo $currentYear+1 ?>-3" id="march"
                        <?php echo !empty($paidMonths) && in_array(($currentYear+1).'-3', array_column($paidMonths, 'date')) ? 'checked' : ''?>>
                        <label for="march">March <?php echo $currentYear+1 ?></label>
                    </div>
                    <div class="ms-1 mt-3"> 
                        <h5 class="d-block"><b>REMAINING BALANCE:</b> <h5 class="fw-bold text-primary" id="remainingBalance"></h5></h5>
                        <small class="d-block fw-bold text-dark" id="nextPayment"></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="ms-2" id="fullPaymentInfo" style="display: none;">
            <h5>TYPE: FULL PAYMENT</h5>
            <small><b>TOTAL</b>: ₱ 21,884.7</small>
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

<script>
    let inputCheckboxes = document.querySelectorAll('input[type=checkbox]');
    
    let currentDate = new Date();
    let currentYear = currentDate.getFullYear();
    let currentMonth = currentDate.getMonth() + 1;

    if (currentMonth >= 5) {
        currentYear += 1;
    } else {
        currentYear -= 1;
    }

    let acceptableMonths = [
        `${currentYear}-7`,
        `${currentYear}-8`,
        `${currentYear}-9`,
        `${currentYear}-10`,
        `${currentYear}-11`,
        `${currentYear}-12`,
        `${currentYear + 1}-1`,
        `${currentYear + 1}-2`,
        `${currentYear + 1}-3`
    ];

    function computeRemainingBalance(){

        let countMatches = 0;
        var remainingBalance = document.getElementById('remainingBalance');
        var nextPayment = document.getElementById('nextPayment');

        inputCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                let paidDate = checkbox.value; 
                if (acceptableMonths.includes(paidDate)) {
                    countMatches++;
                }
            }
        });

        var balance = (9 - countMatches) * 1131.3;
        remainingBalance.innerHTML = '₱'+parseFloat(balance.toFixed(2));
        nextPayment.innerHTML = ((9 - countMatches) > 0 ? 'Next Payment should be on 15th of the Month.' : '');
    }

    window.addEventListener('load', computeRemainingBalance);

    inputCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', computeRemainingBalance);
    });

    function checkPaymentType(){
        var paymentType = document.getElementById('payment_type');
        var selectedPaymentType = paymentType.value;
        var installmentInfo = document.getElementById('installmentInfo');
        var fullPaymentInfo = document.getElementById('fullPaymentInfo');

        if(selectedPaymentType && installmentInfo){
            if(selectedPaymentType == 'down'){
                installmentInfo.style.display = 'block';
                fullPaymentInfo.style.display = 'none';
            }else{
                console.log(1);
                installmentInfo.style.display = 'none';
                fullPaymentInfo.style.display = 'block';
            }
        }
    }

    $(function(){
        checkPaymentType();
    });
</script>