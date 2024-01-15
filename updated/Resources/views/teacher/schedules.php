<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/teacher/includes_get_assigned_subjects.php";

$title = "Teacher - Assigned Subjects";

require_once "../includes/header_layout.php";


$days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];

$monday = [];
$tuesday = [];
$wednesday = [];
$thursday = [];
$friday = [];

foreach($classes as $class){ 
    foreach ($days as $day) {
        if ($class["is_$day"] == TRUE || $class["is_$day"] == 1) {  
            $currentArray = [
                "start" => $class["{$day}_start_time"],
                "end" => $class["{$day}_end_time"]
            ];
            
            switch ($day) {
                case 'monday':
                    $monday[] = $currentArray;
                    break;
                case 'tuesday':
                    $tuesday[] = $currentArray;
                    break;
                case 'wednesday':
                    $wednesday[] = $currentArray;
                    break;
                case 'thursday':
                    $thursday[] = $currentArray;
                    break;
                case 'friday':
                    $friday[] = $currentArray;
                    break;
                default:
                    // Handle unexpected day value
                    break;
            }
        } 
    }
} 

function hasDuplicateTimeRanges($schedulesArray) {
    global $errorDays;
    $startSet = [];
    $endSet = [];

    foreach ($schedulesArray as $scheduleData) {
        $startTime = date('H:i:s', strtotime($scheduleData['start']));
        $endTime = date('H:i:s', strtotime($scheduleData['end']));

        if (in_array($startTime, $startSet) || in_array($endTime, $endSet)) {
            return true; 
        }

        $startSet[] = $startTime;
        $endSet[] = $endTime;
    }

    foreach ($schedulesArray as $index1 => $scheduleData1) {
        $start1 = date('H:i:s', strtotime($scheduleData1['start']));
        $end1 = date('H:i:s', strtotime($scheduleData1['end']));

        foreach($schedulesArray as $index2 => $scheduleData2){
            $start2 = date('H:i:s', strtotime($scheduleData2['start']));
            $end2 = date('H:i:s', strtotime($scheduleData2['end']));

            if($index1 !== $index2){
                if($start1 >= $start2 && $end1 <= $end2 ||
                   $start1 < $start2 && $end1 > $end2 ||
                   $start1 < $end2 && $end1 >= $end2 ){
                    return true;
                }
            }
        }
    }

    return false; // No duplicates       
}
function isConflictDays($days) {
    $errorDays = [];

    foreach ($days as $day => $timeRanges) {
        if (hasDuplicateTimeRanges($timeRanges)) {
            $errorDays[] = $day;
        }
    }

    if (!empty($errorDays)) {
        $errorList = implode(', ', $errorDays);
        return "There's a conflict on your schedule ($errorList). Please contact your admin.";
    }

    return '';
}

$daysIndexed = [
    'Monday' => $monday,
    'Tuesday' => $tuesday,
    'Wednesday' => $wednesday,
    'Thursday' => $thursday,
    'Friday' => $friday,
];

$result = isConflictDays($daysIndexed);
// print_r($monday);


// exit();
?>
<body>
<?php 
    include "includes/navbar.php";
?>
<div class="container my-5">
    <div class="row pb-2 px-2">
        
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <h5 >ASSIGNED SUBJECT SCHEDULES</h5>
                    </div>
                    <label class="text-danger"><?php echo $result ?></label>
                        <?php 
                            $count = 1;
                            if($classes->num_rows > 0){
                                foreach($classes as $class){ 
                                    echo "<label class='mt-3 d-block'>".$count++.".<b> ".$class['subject_name']."</b></label>
                                        <small class='d-block ps-3 pb-4'>".$class['section_name']."-".$class['section_grade']."</small>
                                        
                                        
                                        <div class='table-responsive ps-2'>
                                        <table class='table table-bordered '>
                                            <thead>
                                                <tr>
                                                <th scope='col'>Day</th>
                                                <th scope='col'>Start Time</th>
                                                <th scope='col'>End Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>";
        
                                    foreach ($days as $day) {
                                        if ($class["is_$day"] == TRUE || $class["is_$day"] == 1) {
                                            echo "
                                            <tr>
                                                <td><small >".ucfirst($day)."  </small></td>
                                                <td><small >".$class["{$day}_start_time"]."</small></td>
                                                <td><small>".$class["{$day}_end_time"]."</small></td>
                                            </tr>";   
                                        } 
                                    
                                    }
                                    echo "</tbody>
                                    </table>
                                </div>";
                                    
                                } 
                            }else{
                                echo "<div class='d-flex justify-content-center mt-5 fw-bold align-items-center'>EMPTY</div>";
                            }
                        ?>
                    </div>
            </div>
    </div>
</div>

</body>

<?php
	require_once "../includes/includes_scripts.php";
?>
    <script> setActive('schedules_tab'); </script>