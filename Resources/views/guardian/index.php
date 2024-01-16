<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfGuardian.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_events_home.php";

$title = "Home";

require_once "../includes/header_layout.php";

$currentYear = date('Y');

$currentMonth = date('n');

if ($currentMonth >= 5) {
    $currentYear += 1;
}else{
    $currentYear -= 1;
}

$stmt = $conn->prepare("SELECT date FROM paidMonths WHERE student_id = ?");
$stmt->bind_param("i", $student['id']);
$stmt->execute(); 
$paidMonthsResult = $stmt->get_result();
$paidMonths = $paidMonthsResult->fetch_all(MYSQLI_ASSOC);


$acceptableMonths = [
    $currentYear."-7",
    $currentYear."-8",
    $currentYear."-9",
    $currentYear."-10",
    $currentYear."-11",
    $currentYear."-12",
    ($currentYear+1)."-1",
    ($currentYear+1)."-2",
    ($currentYear+1)."-3"
];

$countMatches = 0;

foreach ($paidMonths as $paidMonth) {
    $paidDate = $paidMonth['date'];
    if (in_array($paidDate, $acceptableMonths)) {
        $countMatches++;
    }
}

$balance = (9 - $countMatches) * 1131.3;

?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
       <div class="row">
            <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 mt-3">
                <div class="card">
                    <div class="card-header fw-bold">
                        EVENTS
                    </div>
                    <div class="card-body py-5"> 
                        <?php
                            $count = 0;
                            foreach($events as $event){
                                $count++;
                                echo "
                                <div class='mb-3'>
                                    <strong class='d-block'>{$count}. {$event['title']}</strong>
                                    <span class='d-block ms-3'>{$event['description']}</span>
                                </div>";
                            }

                            if($count == 0){
                                echo "<div class='text-center'>NO EVENTS</div>";
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mt-3">
                <div class="card">
                    <div class="card-header fw-bold">
                        PAYMENT/BALANCE
                    </div>
                    <div class="card-body "> 
                        <span class="d-block ">
                            <?php
                                if($student['payment_type'] == 'full'){
                                    echo '
                                    <span class="d-block">
                                        <small class="text-dark fw-bold d-block">FULL PAYMENT</small>
                                        <small class="text-dark d-block">TOTAL: ₱21,884.7</small>
                                    </span>';
                                }elseif($student['payment_type'] == 'down'){
                                    echo '
                                    <span class="d-block">
                                        <small class="text-dark fw-bold d-block">INSTALLMENT</small>
                                        <small>MONTHS TO BE PAID</small>
                                        <small class="d-block ms-1  text-secondary mt-2">Checked checkboxes are paid months.</small>
                                        <span class="d-block mb-2 ms-1 ">
                                            <small class="fw-bold text-dark">EACH MONTH</small> 
                                            <small class="fw-bold text-primary ">₱1,131.3</small>
                                        </span>
                                        <small class="d-block ms-1  text-secondary mb-2">June is included on Down Payment.</small>
                                        <div class="ms-1">
                                            <input type="checkbox" id="june" checked disabled>
                                            <label for="june">June '.$currentYear.'</label>
                                        </div>

                                        <div class="ms-1">
                                            <input type="checkbox" id="july" disabled '. (!empty($paidMonths) && in_array($currentYear.'-7', array_column($paidMonths, 'date')) ? 'checked' : '').' >
                                            <label for="july">July '.$currentYear.'</label>
                                        </div>

                                        <div class="ms-1">
                                            <input type="checkbox" id="august" disabled '. (!empty($paidMonths) && in_array($currentYear.'-8', array_column($paidMonths, 'date')) ? 'checked' : '').' >
                                            <label for="august">August '.$currentYear.'</label>
                                        </div>
                                        
                                        <div class="ms-1">
                                            <input type="checkbox" id="september" disabled '. (!empty($paidMonths) && in_array($currentYear.'-9', array_column($paidMonths, 'date')) ? 'checked' : '').' >
                                            <label for="september">September '.$currentYear.'</label>
                                        </div>
                                        
                                        <div class="ms-1">
                                            <input type="checkbox" id="October" disabled '. (!empty($paidMonths) && in_array($currentYear.'-10', array_column($paidMonths, 'date')) ? 'checked' : '').' >
                                            <label for="October">October '.$currentYear.'</label>
                                        </div>

                                        <div class="ms-1">
                                            <input type="checkbox" id="November" disabled '. (!empty($paidMonths) && in_array($currentYear.'-11', array_column($paidMonths, 'date')) ? 'checked' : '').' >
                                            <label for="November">November '.$currentYear.'</label>
                                        </div>

                                        <div class="ms-1">
                                            <input type="checkbox" id="December" disabled '. (!empty($paidMonths) && in_array($currentYear.'-12', array_column($paidMonths, 'date')) ? 'checked' : '').' >
                                            <label for="December">December '.$currentYear.'</label>
                                        </div>

                                        <div class="ms-1">
                                            <input type="checkbox" id="January" disabled '. (!empty($paidMonths) && in_array(($currentYear+1).'-1', array_column($paidMonths, 'date')) ? 'checked' : '').' >
                                            <label for="January">January '.($currentYear+1).'</label>
                                        </div>

                                        <div class="ms-1">
                                            <input type="checkbox" id="February" disabled '. (!empty($paidMonths) && in_array(($currentYear+1).'-2', array_column($paidMonths, 'date')) ? 'checked' : '').' >
                                            <label for="February">February '.($currentYear+1).'</label>
                                        </div>

                                        <div class="ms-1">
                                            <input type="checkbox" id="March" disabled '. (!empty($paidMonths) && in_array(($currentYear+1).'-3', array_column($paidMonths, 'date')) ? 'checked' : '').' >
                                            <label for="March">March '.($currentYear+1).'</label>
                                        </div>

                                        <div class="ms-1 mt-3">
                                            <h5 class="d-block"><b>REMAINING BALANCE:</b> <h5 class="fw-bold text-primary" id="remainingBalance">₱ '.$balance.'</h5></h5>
                                            <small class="d-block fw-bold text-dark">'.((9 - $countMatches) > 0 ? 'Next Payment should be on 15th of the Month.' : '').'</small>
                                        </div>

                                    </span>';
                                }else{
                                    echo '
                                        <span class="d-block">
                                            <small class="text-dark fw-bold d-block">NO PAYMENT INDICATED YET.</small>
                                        </span>';
                                }
                            ?>
                        </span>
                    </div>
                </div>
            </div>
       </div>
     </div>
</body>

<?php
	require_once "../includes/includes_scripts.php";
?>
    <script> setActive('home_tab'); </script>