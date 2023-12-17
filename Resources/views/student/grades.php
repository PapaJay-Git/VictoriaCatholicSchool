<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfStudent.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/student/includes_get_grades.php";
$title = "Student - Grades";

require_once "../includes/header_layout.php";

?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
       <div class="row">
            <div class="mt-3 col-12">
                <div class="card">
                    <div class="card-header fw-bold">
                        MY GRADES
                    </div>
                    <div class="card-body pb-5"> 
                        <?php
                            $count = 0;
                            foreach ($subjects as $subject) {
                                $count++;
                                $stmt = $conn->prepare("SELECT * FROM student_grades  WHERE subject_id = ? AND student_id = ?");
                                $stmt->bind_param("ii", $subject['id'], $auth['id']);
                                $stmt->execute();
                                $student_grades = $stmt->get_result();
                                if($student_grades->num_rows <= 0){
                                    echo "
                                    <div class='mt-4 d-block'>
                                        <span><small class='fw-bold'>$count. ".$subject['name'].": </small></span>
                                        <span class='d-block ps-3'>
                                            <small>First: 0</small>
                                        </span>
                                        <span class='d-block ps-3'>
                                            <small>Second: 0</small>
                                        </span>
                                        <span class='d-block ps-3'>
                                            <small>Third: 0</small>
                                        </span>
                                        <span class='d-block ps-3'>
                                            <small>Fourth: 0</small>
                                        </span>
                                        <span class='d-block ps-3'>
                                            <small><strong>Final:</strong> 0 / 100</small>
                                        </span>
                                    </div>"; 
                                }else{
                                    $student_grades_row = $student_grades->fetch_assoc();

                                    $final = ($student_grades_row['first_quarter']+$student_grades_row['second_quarter']+$student_grades_row['third_quarter']+$student_grades_row['fourth_quarter']) / 4;
                                    echo "
                                    <div class='mt-4 d-block'>
                                        <span><small class='fw-bold'>$count. ".$subject['name'].": </small></span>
                                        <span class='d-block ps-3'>
                                            <small>First: ".$student_grades_row['first_quarter']."</small>
                                        </span>
                                        <span class='d-block ps-3'>
                                            <small>Second: ".$student_grades_row['second_quarter']."</small>
                                        </span>
                                        <span class='d-block ps-3'>
                                            <small>Third: ".$student_grades_row['third_quarter']."</small>
                                        </span>
                                        <span class='d-block ps-3'>
                                            <small>Fourth: ".$student_grades_row['fourth_quarter']."</small>
                                        </span>
                                        <span class='d-block ps-3'>
                                            <small><strong>Final:</strong> $final / 100</small>
                                        </span>
                                    </div>"; 
                                }

                            }
                            
                        ?>
                    </div>
                </div>
            </div>
       </div>
     </div>
</body>

<?php
	require_once "../includes/includes_scripts.php";
?>
    <script> setActive('grades_tab'); </script>