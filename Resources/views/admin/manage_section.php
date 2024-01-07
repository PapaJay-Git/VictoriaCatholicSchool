<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_manage_section_route.php";

$title = "Admin - Update Grade Schedules and Teachers";

require_once "../includes/header_layout.php";


$days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];

?>
<body>
<?php 
    include "includes/navbar.php";
?>
<div class="container my-5">
    <div class="row pb-2 px-2">
        <form method="POST" action="../../../Backend-routes/admin/update_class_route.php?" onsubmit="submitRequest('updateSectionName', event)" id="updateSectionName">
        
            <div class="card shadow">
                <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 fw-bold">SCHEDULES AND TEACHERS</h4>
                        <label><?php echo $row['name']."-".$row['grade'] ?></label>
                    </div>
                    <a href="view_sections.php?id=<?php echo $gradeID ?>" class="btn btn-danger btn-sm fw-bold">BACK</a>
                </div>
                    <input type="hidden" name='section' value='<?php echo $row['id'] ?>'>
                    <input type="hidden" name='grade' value='<?php echo $row['grade'] ?>'>

                    <div class="mt-5">
                        <label for="findSubject" class="fw-bold pe-2">FIND A SUBJECT</label>
                        <select name="findSubject" id="findSubject" class="my-2 me-3 px-5 select" onchange="findSubjectLocation()">
                            <option value="" disabled selected>FIND A SUBJECT</option>
                            <?php
                                foreach($subjects as $subject){
                                    echo "<option value='".$subject['name']."'>".$subject['name']."</option>";
                                }
                            ?>
                        </select>
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
                                    echo "<label class='mt-5' id='".$subject['name']."'>".$count++.".<b> ".$subject['name']."</b></label>
                                    <input type='hidden' name='subject[]' value='".$subject['id']."'>
                                    <div class='border-bottom px-2 mb-3 pb-2'>
                                        <small >Subject Teacher: </small>
                                        <select name='teacher[]' class='border rounded my-2 select' >
                                        <option value='' disabled selected>Select an option</option>";
                                        foreach($teachers as $teacher){
                                            if($data['teacher_id'] == $teacher['id']){
                                                echo "<option selected value='".$teacher['id']."'>".$teacher['first_name']." ".$teacher['last_name']." : ".$teacher['email']."</option>";
                                            }else{
                                                echo "<option value='".$teacher['id']."'>".$teacher['first_name']." ".$teacher['last_name']." : ".$teacher['email']."</option>";
                                            }
                                        }
                                        echo "</select>
                                    </div>";
        
                                    foreach ($days as $day) {
                                        echo "<div class='border-bottom px-2 mb-3 pb-2'>
                                            <small >In ".ucfirst($day).": </small>";
                                                      
                                        if ($data["is_$day"] == TRUE || $data["is_$day"] == 1) {
                                            echo "<select name='is_{$day}[]' class='my-2 me-3 px-3 border rounded selected select' required onchange='changeBorderColor(this)'>
                                            <option value='1' selected>TRUE</option>
                                                  <option value='0'>FALSE</option>";
                                        } else {
                                            echo "
                                            <select name='is_{$day}[]' class='my-2 me-3 px-3 border rounded select' required onchange='changeBorderColor(this)'>
                                            <option value='1'>TRUE</option>
                                                  <option value='0' selected>FALSE</option>";
                                        }
                                    
                                        echo "</select>
                                              <small > Start Time: </small>
                                              <select name='{$day}_start_time[]' class='my-2 me-3 px-3 border rounded select' required>";
                                    
                                        foreach ($schedules as $schedule) {
                                            if ($data["{$day}_start_time"] == $schedule) {
                                                echo "<option value='$schedule' selected>$schedule</option>";
                                            } else {
                                                echo "<option value='$schedule'>$schedule</option>";
                                            }
                                        }
                                    
                                        echo "</select>
                                              <small > End Time: </small>
                                              <select name='{$day}_end_time[]' class='my-2 me-3 px-3 border rounded select' >";
                                    
                                        foreach ($schedules as $schedule) {
                                            if ($data["{$day}_end_time"] == $schedule) {
                                                echo "<option value='$schedule' selected>$schedule</option>";
                                            } else {
                                                echo "<option value='$schedule'>$schedule</option>";
                                            }
                                        }
                                    
                                        echo "</select>
                                              </div>";
                                    }
                                    
                                } 
                            }else{
                                echo "<label class='mt-5' id='".$subject['name']."'>".$count++.".<b> ".$subject['name']."</b></label>
                                <input type='hidden' name='subject[]' value='".$subject['id']."'>
                                <div class='border-bottom px-2 mb-3 pb-2'>
                                    <small >Subject Teacher: </small>
                                    <select name='teacher[]' class='border rounded my-2 select' required>
                                    <option value='' disabled selected>Select an option</option>";
                                    foreach($teachers as $teacher){
                                        echo "<option value='".$teacher['id']."'>".$teacher['first_name']." ".$teacher['last_name']." : ".$teacher['email']."</option>";
                                    }
                                    echo "</select>
                                </div>";
    
                                foreach ($days as $day) {
                                    echo"<div class='border-bottom px-2 mb-3 pb-2'>";

                                    echo"<small >In ".ucfirst($day).": </small>
                                        <select name='is_{$day}[]' class='my-2 me-3 px-3 border rounded select' required onchange='changeBorderColor(this)'>
                                            <option value='1'>TRUE</option>
                                            <option value='0' selected>FALSE</option>
                                        </select>";

                                    echo"<small > Start Time: </small>
                                        <select name='{$day}_start_time[]' class='my-2 me-3 px-3 border rounded select' required>";
                                        foreach ($schedules as $schedule) {
                                            echo "<option value='$schedule'>$schedule</option>";
                                        }
                                    echo "</select>";


                                    echo"<small > End Time: </small>
                                        <select name='{$day}_end_time[]' class='my-2 me-3 px-3 border rounded select' required>";
                                        foreach ($schedules as $schedule) {
                                            echo "<option value='$schedule'>$schedule</option>";
                                        }
                                    echo "</select>
                                          </div>";
                                }
                            }
                        }
                        
                    ?>
                </div>
                
                <div class="d-flex justify-content-end my-5 me-3">
                    <button class="btn btn-sm fw-bold btn-primary me-1" type="submit">UPDATE</button>
                    <a href="view_sections.php?id=<?php echo $gradeID ?>" class="btn btn-danger btn-sm fw-bold">CANCEL</a>
                </div>
            </div>



        </form>
    </div>
</div>
</body>
<?php
	require_once "../includes/includes_scripts.php";
?>
<script>

    setActive('sections_tab'); 

    function findSubjectLocation(){
        var findSubject = document.getElementById('findSubject');
        var subject = document.getElementById(findSubject.value);
        
        if (subject) {
            var elementRect = subject.getBoundingClientRect();
            var absoluteElementTop = elementRect.top + window.pageYOffset;
            var middle = absoluteElementTop - (window.innerHeight / 5);

            window.scrollTo({
                top: middle,
                behavior: 'smooth'
            });
        }

    }
</script>