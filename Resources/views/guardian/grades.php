<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfGuardian.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/guardian/includes_get_grades.php";

$finalAverage = 0;
$subjectThatHasGrade = 0;
foreach ($subjects as $subject) {
    $stmt = $conn->prepare("SELECT * FROM student_grades  WHERE subject_id = ? AND student_id = ?");
    $stmt->bind_param("ii", $subject['id'], $student['id']);
    $stmt->execute();
    $student_grades = $stmt->get_result();
    if($student_grades->num_rows > 0){
        $student_grades_row = $student_grades->fetch_assoc();

        $final = ($student_grades_row['first_quarter'] * 0.20 +
                $student_grades_row['second_quarter'] * 0.20 +
                $student_grades_row['third_quarter'] * 0.20 +
                $student_grades_row['fourth_quarter'] * 0.40);
        $finalAverage += $final;

        if($student_grades_row['first_quarter'] > 0 &&
           $student_grades_row['second_quarter'] > 0 &&
           $student_grades_row['third_quarter'] > 0 &&
           $student_grades_row['fourth_quarter'] > 0){
            $subjectThatHasGrade++;
        }
    }
} 

$finalAverageResult = ($subjects->num_rows == $subjectThatHasGrade) ? "Final Average: ".number_format($finalAverage/$subjects->num_rows, 2) : 'PENDING GRADES';
$title = $student['first_name']." ".$student['last_name']."     ".$finalAverageResult;

require_once "../includes/header_layout.php";

$count = 1;
?>
<body>
<?php 
    include "includes/navbar.php";
?>
<div class="container my-5">
    <div class="row pb-2 px-2">
        
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between  mb-5">
                        <span>
                            <h5 class="text-uppercase"><?php echo $student['first_name']." ".$student['last_name']." - Grades";?></h5>
                            <small class="d-block text-uppercase"><?php echo $section_data['name']." ".$section_data['grade'];?></small>
                        </span>
                        
                        <h5><?php echo $finalAverageResult ?></h5>
                    </div>
                    <div class="table-responsive ">
                            <table id="gradesTable">
                                <thead>
                                <tr>
                                    <th scope="col">Subject</th>
                                    <th scope="col">1st <small>(20%)</small></th>
                                    <th scope="col">2nd <small>(20%)</small></th>
                                    <th scope="col">3rd <small>(20%)</small></th>
                                    <th scope="col">4th <small>(40%)</small></th>
                                    <th scope="col">Final Rating</th>
                                </tr>
                                </thead>
                                <tbody id="tbody-grades">
                                    <?php
                                    foreach ($subjects as $subject) {
                                        $stmt = $conn->prepare("SELECT * FROM student_grades  WHERE subject_id = ? AND student_id = ?");
                                        $stmt->bind_param("ii", $subject['id'], $student['id']);
                                        $stmt->execute();
                                        $student_grades = $stmt->get_result();
                                        if($student_grades->num_rows <= 0){
                                            echo "
                                            <tr>
                                                <td>
                                                    <small class='fw-bold text-uppercase'>".$subject['name']."</small>
                                                </td>
                                                <td>
                                                    <small>0</small>
                                                </td>
                                                <td>
                                                    <small>0</small>
                                                </td>
                                                <td>
                                                    <small>0</small>
                                                </td>
                                                <td>
                                                    <small>0</small>
                                                </td>
                                                <td>
                                                    <small>0.00</small>
                                                </td>
                                            </tr>"; 
                                        }else{
                                            $student_grades_row = $student_grades->fetch_assoc();
    
                                            $final = ($student_grades_row['first_quarter'] == 0 ||
                                                        $student_grades_row['second_quarter'] == 0 ||
                                                        $student_grades_row['third_quarter'] == 0 ||
                                                        $student_grades_row['fourth_quarter'] == 0) ? 0 :
                                                        ($student_grades_row['first_quarter'] * 0.20 +
                                                        $student_grades_row['second_quarter'] * 0.20 +
                                                        $student_grades_row['third_quarter'] * 0.20 +
                                                        $student_grades_row['fourth_quarter'] * 0.40);
                                            
                                            echo "
                                            <tr>
                                                <td>
                                                    <small class='fw-bold text-uppercase'>".$subject['name']."</small>
                                                </td>
                                                <td>
                                                    <small>".$student_grades_row['first_quarter']."</small>
                                                </td>
                                                <td>
                                                    <small>".$student_grades_row['second_quarter']."</small>
                                                </td>
                                                <td>
                                                    <small>".$student_grades_row['third_quarter']."</small>
                                                </td>
                                                <td>
                                                    <small>".$student_grades_row['fourth_quarter']."</small>
                                                </td>
                                                <td>
                                                    <small>".number_format($final, 2)."</small>
                                                </td>
                                            </tr>"; 
                                        }
                                    } 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
    </div>
</div>
</body>

<?php
	require_once "../includes/includes_scripts.php";
	require_once "../includes/grade_calculation.php";
?>
<script src="../../js/admin/grades.js"></script>
<script> setActive('grades_tab'); </script>