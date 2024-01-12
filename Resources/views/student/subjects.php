<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfStudent.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/student/includes_get_subjects.php";

$title = "Student - Subjects";

require_once "../includes/header_layout.php";


$days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];

$subjectIds = [];

while ($row2 = $subjects->fetch_assoc()) {
    $subjectIds[] = $row2['id'];
}

$subjectIdsImploded = implode(',', $subjectIds);

$stmt = $conn->prepare("SELECT * FROM classes WHERE section_id = ? AND subject_id IN ($subjectIdsImploded)");
$stmt->bind_param("i", $sectionID);
$stmt->execute();
$classes2 = $stmt->get_result();

$monday = [];
$tuesday = [];
$wednesday = [];
$thursday = [];
$friday = [];

foreach($classes2 as $class){ 
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
?>
<body>
<?php 
    include "includes/navbar.php";
?>
<div class="container my-5">
    <div class="row pb-2 px-2">
        
            <div class="card shadow">
                <div class="card-body">
                    <div>
                        <h5>SECTION <?php echo $row['name']."-".$row['grade'] ?></h5>
                        <small>Adviser: <?php echo $row['first_name']." ".$row['last_name'].", ".$row['email'] ?></small>
                    </div>
                    <label class="text-danger d-block mt-5 "><?php echo $result ?></label>
                        <?php 
                            $count = 1;
                            foreach($subjects as $subject){
                                $stmt = $conn->prepare("SELECT * FROM classes where section_id = ? AND subject_id = ? LIMIT 1");
                                $stmt->bind_param("ii", $sectionID, $subject['id']);
                                $stmt->execute();
                                $classes = $stmt->get_result();

                                echo "<label class=''>".$count++.".<b> ".$subject['name']."</b></label>";

                                if($classes->num_rows > 0){
                                    foreach($classes as $data){ 
                                        echo "
                                        <div class='px-3 mt-3 mb-3'>
                                            <small >Teacher: ";
                                            foreach($teachers as $teacher){
                                                if($data['teacher_id'] == $teacher['id']){
                                                    echo $teacher['first_name']." ".$teacher['last_name'].", ".$teacher['email'];
                                                }
                                            }
                                            echo "</small>
                                        </div>
                                        
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
                                            if ($data["is_$day"] == TRUE || $data["is_$day"] == 1) {
                                                echo "
                                                    <tr>
                                                        <td>
                                                            <small >".ucfirst($day)."</small>
                                                        </td>
                                                        <td>
                                                            <small >".$data["{$day}_start_time"]."</small>
                                                        </td>
                                                        <td>
                                                            <small>".$data["{$day}_end_time"]."</small>
                                                        </td>
                                                    </tr>";
                                                 
                                            } 
                                        
                                        }
                                        echo "</tbody>
                                        </table>
                                    </div>";  
                                        
                                        
                                    } 
                                }
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
<script> setActive('subjects_tab'); </script>