<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/teacher/includes_get_student_grades.php";

$title = "Teacher - ".$section_data['grade']." ".$section_data['name']." Student Grades";

require_once "../includes/header_layout.php";

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
                        <h5 class="fw-bold"><?php echo $section_data['grade']." ".$section_data['name']." STUDENT GRADES" ?></h5>
                        <a href="advisories.php" class="btn btn-danger btn-sm fw-bold">BACK</a>
                    </div>
                    <form method="POST" action="../../../Backend-routes/teacher/update_student_grades.php" onsubmit="submitRequest('updateStudentGrade', event)" id="updateStudentGrade">
                        <input type="hidden" name="section_id" value="<?php echo $section_data['id'] ?>">
                        <?php 
                            $count = 1;
                            foreach($students as $student){ 
                                echo "<label class='mt-4 d-block text-uppercase'>".$count++.".<b> ".$student['first_name']." ".$student['last_name']."</b></label>
                                    <small class='d-block ps-3'>".$student['email']."</small>
                                    <small class='d-block ps-3'>".$student['school_number']."</small>";

                                foreach ($subjects as $subject) {
                                    $stmt = $conn->prepare("SELECT * FROM student_grades  WHERE subject_id = ? AND student_id = ?");
                                    $stmt->bind_param("ii", $subject['id'], $student['id']);
                                    $stmt->execute();
                                    $student_grades = $stmt->get_result();
                                    if($student_grades->num_rows <= 0){
                                        echo "<div class='mx-3 p-3 mt-2 d-block border-bottom-css'>
                                        <input type='hidden' name='student_id[]' value='".$student['id']."'>
                                        <input type='hidden' name='subject_id[]' value='".$subject['id']."'>
                                        <small class='fw-bold'>".$subject['name'].": </small>
                                        <small>First</small>
                                        <input type='number' class='grade-css' step='0.01' min='0.00' max='100.00' value='0' required name='first[]'>
                                        <small>Second</small>
                                        <input type='number' class='grade-css' step='0.01' min='0.00' max='100.00' value='0' required name='second[]'>
                                        <small>Third</small>
                                        <input type='number' class='grade-css' step='0.01' min='0.00' max='100.00' value='0' required name='third[]'>
                                        <small>Fourth</small>
                                        <input type='number' class='grade-css' step='0.01' min='0.00' max='100.00' value='0' required name='fourth[]'>
                                        <small class='ps-3 fw-bold'>Final</small>
                                        <small>0 / 100</small>
                                        </div>"; 
                                    }else{
                                        $student_grades_row = $student_grades->fetch_assoc();

                                        $final = ($student_grades_row['first_quarter']+$student_grades_row['second_quarter']+$student_grades_row['third_quarter']+$student_grades_row['fourth_quarter']) / 100;
                                        echo "<div class='mx-3 p-3 mt-2 d-block border-bottom-css'>
                                        <input type='hidden' name='student_id[]' value='".$student['id']."'>
                                        <input type='hidden' name='subject_id[]' value='".$subject['id']."'>
                                        <small class='fw-bold'>".$subject['name'].": </small>
                                        <small>First</small>
                                        <input type='number' class='grade-css' step='0.01' min='0.00' max='100.00' required name='first[]' value='".$student_grades_row['first_quarter']."'>
                                        <small>Second</small>
                                        <input type='number' class='grade-css' step='0.01' min='0.00' max='100.00' required name='second[]' value='".$student_grades_row['second_quarter']."'>
                                        <small>Third</small>
                                        <input type='number' class='grade-css' step='0.01' min='0.00' max='100.00' required name='third[]' value='".$student_grades_row['third_quarter']."'>
                                        <small>Fourth</small>
                                        <input type='number' class='grade-css' step='0.01' min='0.00' max='100.00' required name='fourth[]' value='".$student_grades_row['fourth_quarter']."'>
                                        <small class='ps-3 fw-bold'>Final</small>
                                        <small>$final / 100</small>
                                        </div>"; 
                                    }

                                }
                                
                            } 
                     

                            if($students->num_rows == 0){
                                echo "<div class='d-flex justify-content-center mt-5 fw-bold align-items-center'>NO STUDENTS TO BE GRADED</div>
                                ";
                            }else{
                                echo "
                                <div class='d-flex justify-content-end align-items-center mt-3'>
                                    <div class='btn-group '>
                                        <button type='submit' class='btn btn-primary btn-sm fw-bold'>UPDATE</button>
                                    <a href='advisories.php' class='btn btn-sm btn-danger fw-bold'>CANCEL</a></div>
                                </div>"; 
                            }
                        ?>
                        </form>
                    </div>
            </div>
    </div>
</div>
</body>

<?php
	require_once "../includes/includes_scripts.php";
?>
    <script> setActive('advisories_tab'); </script>