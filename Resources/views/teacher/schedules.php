<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/teacher/includes_get_assigned_subjects.php";

$title = "Teacher - Assigned Subjects";

require_once "../includes/header_layout.php";


$days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];

$schedules = [
    '7:00 AM', '7:30 AM', '8:00 AM', '8:30 AM',
    '9:00 AM', '9:30 AM', '10:00 AM', '10:30 AM',
    '11:00 AM', '11:30 AM', '12:00 PM', '12:30 PM',
    '1:00 PM', '1:30 PM', '2:00 PM', '2:30 PM',
    '3:00 PM', '3:30 PM', '4:00 PM', '4:30 PM',
    '5:00 PM', '5:30 PM', '6:00 PM'
];

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
                        <?php 
                            $count = 1;
                            if($classes->num_rows > 0){
                                foreach($classes as $class){ 
                                    echo "<label class='mt-4 d-block'>".$count++.".<b> ".$class['subject_name']."</b></label>
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
                                            echo "<tr>
                                                    <td><small >".ucfirst($day)."  </small></td>";
                                                
                                                    foreach ($schedules as $schedule) {
                                                        if ($class["{$day}_start_time"] == $schedule) {
                                                            echo "<td><small >$schedule</small></td>";
                                                        }
                                                    }
                                                
                                                    foreach ($schedules as $schedule) {
                                                        if ($class["{$day}_end_time"] == $schedule) {
                                                            echo "<td><small> - $schedule</small></td>";
                                                        } 
                                                    }  
                                            echo "</tr>";   
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