<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/teacher/includes_get_assigned_student_grades.php";

$title = $subject['name']." ".$section['grade']." ".$section['name'];

require_once "../includes/header_layout.php";

$count = 1;

function convertTxt($string = null){

    return $string == null ? '' : ucwords(strtolower($string));
  }


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
                        <div>
                            <h5 ><?php echo $section['grade']." ".$section['name'] ?></h5>
                            <h5 ><?php echo $subject['name']?></h5>
                        </div>
                    </div>
                    <form method="POST" action="../../../Backend-routes/teacher/update_student_grades.php" onsubmit="submitRequest('updateStudentGrade', event)" id="updateStudentGrade">
                        <input type="hidden" name="section_id" value="<?php echo $section['id'] ?>">
                        <input type="hidden" name="subject_id" value="<?php echo $subject['id'] ?>">
                      
                        <div class="d-flex justify-content-end mb-3">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-sm btn-primary fw-bold">UPDATE</button>
                                <a href="assigned_subjects.php" class="btn btn-danger btn-sm fw-bold">BACK</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="gradesTable">
                                <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">1st <small>(20%)</small></th>
                                    <th scope="col">2nd <small>(20%)</small></th>
                                    <th scope="col">3rd <small>(20%)</small></th>
                                    <th scope="col">4th <small>(40%)</small></th>
                                    <th scope="col">Final Rating</th>
                                </tr>
                                </thead>
                                <tbody id="tbody-grades">
                                    <?php
                                        foreach($students as $student){ 
                                            $stmt = $conn->prepare("SELECT * FROM student_grades  WHERE subject_id = ? AND student_id = ?");
                                            $stmt->bind_param("ii", $subject['id'], $student['id']);
                                            $stmt->execute();
                                            $student_grades = $stmt->get_result();
                                                if($student_grades->num_rows <= 0){
                                                    echo "
                                                    <tr>
                                                        <td>
                                                            <input type='hidden' name='student_id[]' value='".$student['id']."'>
                                                            <small>".convertTxt($student['last_name'].', '.$student['first_name'])."</small>
                                                        </td>
                                                        <td>
                                                            <small>".$student['email']."</small>
                                                        </td>
                                                        <td>
                                                            <small class='d-none'>0</small>
                                                            <input type='number' class='grade-css' step='0.01' min='0.00' max='100.00' value='0' required name='first[]'>
                                                        </td>
                                                        <td>
                                                            <small class='d-none'>0</small>
                                                            <input type='number' class='grade-css' step='0.01' min='0.00' max='100.00' value='0' required name='second[]'>
                                                        </td>
                                                        <td>
                                                            <small class='d-none'>0</small>
                                                            <input type='number' class='grade-css' step='0.01' min='0.00' max='100.00' value='0' required name='third[]'>
                                                        </td>
                                                        <td>
                                                            <small class='d-none'>0</small>
                                                            <input type='number' class='grade-css' step='0.01' min='0.00' max='100.00' value='0' required name='fourth[]'>
                                                        </td>
                                                        <td>
                                                            <small>0</small>
                                                        </td>
                                                    </tr>"; 
                                                }else{
                                                    $student_grades_row = $student_grades->fetch_assoc();
            
                                                    $final = ($student_grades_row['first_quarter'] * 0.20 +
                                                            $student_grades_row['second_quarter'] * 0.20 +
                                                            $student_grades_row['third_quarter'] * 0.20 +
                                                            $student_grades_row['fourth_quarter'] * 0.40);

                                                    
                                                    echo "
                                                    <tr>
                                                        <td>
                                                            <input type='hidden' name='student_id[]' value='".$student['id']."'>
                                                            <small>".convertTxt($student['last_name'].', '.$student['first_name'])."</small>
                                                        </td>
                                                        <td>
                                                            <small>".$student['email']."</small>
                                                        </td>
                                                        <td>
                                                            <small class='d-none'>".$student_grades_row['first_quarter']."</small>
                                                            <input type='number' class='grade-css' step='0.01' min='0.00' max='100.00' required name='first[]' value='".$student_grades_row['first_quarter']."'>
                                                        </td>
                                                        <td>
                                                            <small class='d-none'>".$student_grades_row['second_quarter']."</small>
                                                            <input type='number' class='grade-css' step='0.01' min='0.00' max='100.00' required name='second[]' value='".$student_grades_row['second_quarter']."'>
                                                        </td>
                                                        <td>
                                                            <small class='d-none'>".$student_grades_row['third_quarter']."</small>
                                                            <input type='number' class='grade-css' step='0.01' min='0.00' max='100.00' required name='third[]' value='".$student_grades_row['third_quarter']."'>
                                                        </td>
                                                        <td>
                                                            <small class='d-none'>".$student_grades_row['fourth_quarter']."</small>
                                                            <input type='number' class='grade-css' step='0.01' min='0.00' max='100.00' required name='fourth[]' value='".$student_grades_row['fourth_quarter']."'>
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
                        
                        </form>
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
<script> setActive('assigned_subjects_tab'); </script>