<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/teacher/includes_get_manage_section_route.php";

$title = "Teacher - Class Schedules";

require_once "../includes/header_layout.php";


$days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];

?>
<body>
<?php 
    include "includes/navbar.php";
?>
<div class="container my-5">
    <div class="row pb-2 px-2">
        
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold">SECTION <?php echo $row['name']."-".$row['grade'] ?></h5>
                        <a href="advisories.php" class="btn btn-danger btn-sm fw-bold">BACK</a>
                    </div>
                        <?php 
                            $count = 1;
                            foreach($subjects as $subject){
                                $stmt = $conn->prepare("SELECT * FROM classes where section_id = ? AND subject_id = ? LIMIT 1");
                                $stmt->bind_param("ii", $sectionID, $subject['id']);
                                $stmt->execute();
                                $classes = $stmt->get_result();
                                if($classes->num_rows > 0){
                                    foreach($classes as $data){ 
                                        echo "<label class='mt-5 '>".$count++.".<b> ".$subject['name']."</b></label>
                                        <div class='px-3 mt-3 mb-3'>
                                            <small >Teacher: </small> <small>";
                                            foreach($teachers as $teacher){
                                                if($data['teacher_id'] == $teacher['id']){
                                                    echo $teacher['first_name']." ".$teacher['last_name'].", ".$teacher['school_number'];
                                                }
                                            }
                                            echo "</small>
                                        </div>";
            
                                        foreach ($days as $day) {
                                            if ($data["is_$day"] == TRUE || $data["is_$day"] == 1) {
                                                echo "<div class='px-3 mb-3'>
                                                <small >".ucfirst($day)."  </small>";
                                            
                                                foreach ($schedules as $schedule) {
                                                    if ($data["{$day}_start_time"] == $schedule) {
                                                        echo "<small >$schedule</small>";
                                                    }
                                                }
                                            
                                                foreach ($schedules as $schedule) {
                                                    if ($data["{$day}_end_time"] == $schedule) {
                                                        echo "<small> - $schedule</small>";
                                                    } 
                                                }  
                                                echo "</div>";   
                                            } 
                                        
                                        }
                                        
                                    } 
                                }else{
                                    echo "<label class='mt-5 d-block'>".$count++.".<b> ".$subject['name']."</b></label>";
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
<script> setActive('advisories_tab'); </script>