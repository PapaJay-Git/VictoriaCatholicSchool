<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_enrolled_student_route.php";

$title = "Admin - Update Student";

require_once "../includes/header_layout.php";

function getSession($data) {
  global $row;

  if (isset($_SESSION[$data])) {
    $session_value = $_SESSION[$data];
    unset($_SESSION[$data]);
    return $session_value;
  }

    return $row[$data];
}


function isTabSet($tab){


    if($tab == 'info' && (!isset($_GET['password']) && !isset($_GET['guardian']))){
        return "style='display:block'";
    }else if($tab == 'password' || $tab =='guardian'){
        return isset($_GET[$tab]) ? "style='display:block'" : "style='display:none'";
    }

    return "style='display:none'";
}

function isChecked($columnName){
    global $row;

    if($row[$columnName] == 1){
        return true;
    }

    return false;
}
?>
<body>
<?php 
    include "includes/navbar.php";
?>
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center">
        <div class="btn-group mb-5">
            <div class="btn btn-primary btn-sm fw-bold" onclick="hidePasswordTab2()">BASIC INFO</div>
            <div class="btn btn-primary btn-sm fw-bold" onclick="showGuadianTab2()">GUARDIAN</div>
            <div class="btn btn-secondary btn-sm fw-bold" onclick="showPasswordTab2()">PASSWORD</div>
        </div>

        
        <a href="enrolled_students.php" class="btn btn-sm btn-danger fw-bold">BACK</a>


    </div>

    <div class="pb-2 px-2"  id="password-tab" <?php echo isTabSet('password') ?>>
        <form method="POST" action="../../../Backend-routes/admin/update_complete_student_password_route.php" onsubmit="submitRequest('updateStudentFormPassword', event)" id="updateStudentFormPassword">
            <h5 class="mb-2 fw-bold">CHANGE PASSWORD</h5>
            <small>(Atleast 8 characters, 1 number, 1 capital and lower case letter, and no spaces)</small>
            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
            <div class="mb-3">
                <label class="form-label fw-bold text-uppercase">New Password</label>
                <input type="password"  class="form-control input-password form-control-sm" name="new_password" required placeholder="New Password"? >
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold text-uppercase">Confirm New Password</label>
                <input type="password"  class="form-control input-password form-control-sm" name="confirm_password" required placeholder="Confirm New Password" >
            </div>	<input id="checkBox" type="checkBox" onchange="showPassword()">
				<label for="checkBox" class="text-dark fw-bold">Show</label>
            <div class="d-flex justify-content-end my-5">
                <button class="btn btn-sm fw-bold btn-primary me-1" type="submit">CHANGE</button>
                <a href="enrolled_students.php" class="btn btn-danger btn-sm fw-bold">CANCEL</a>
            </div>

        </form>
    </div>

    <div class="pb-2 px-2"  id="guardian-tab" <?php echo isTabSet('guardian') ?>>
        <form method="POST" action="../../../Backend-routes/admin/update_student_complete_guardian_route.php" onsubmit="submitRequest('updateStudentFormGuardian', event)" id="updateStudentFormGuardian">
        <h5 class="mb-2 fw-bold text-uppercase" id="exampleModalLabel"><?php echo $row['guardian_guardian_type'] ?? 'PARENT/GUARDIAN' ?> INFORMATION - WITH ACCOUNT</h5>
        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
        <div class="mb-3 mt-5">
            <label class="form-label fw-bold text-uppercase" >Relationship</label>
            <select name="guardian_guardian_type" class="form-control form-control-sm">
                <option <?php echo getSession('guardian_guardian_type') == 'mother'  ? 'selected' : '' ?> value="mother"  >Mother</option>
                <option <?php echo getSession('guardian_guardian_type') == 'father'  ? 'selected' : '' ?> value="father"  >Father</option>
                <option <?php echo getSession('guardian_guardian_type') == 'guardian'  ? 'selected' : '' ?> value="guardian"  >Guardian</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-uppercase"> First name</label>
            <input type="text" class="form-control form-control-sm" name="guardian_first_name" required placeholder="First Name" <?php echo "value='".htmlspecialchars(getSession('guardian_first_name'))."'"  ?> >
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-uppercase"> Middle name</label>
            <input type="text" class="form-control form-control-sm" name="guardian_middle_name" required placeholder="Middle name" <?php echo "value='".htmlspecialchars(getSession('guardian_middle_name'))."'"  ?> >
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-uppercase"> Last name</label>
            <input type="text" class="form-control form-control-sm"name="guardian_last_name" required placeholder="Last name" <?php echo "value='".htmlspecialchars(getSession('guardian_last_name'))."'"  ?> >
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-uppercase"> Phone Number</label>
            <input type="text" class="form-control form-control-sm" name="guardian_phone" required placeholder="Phone Number" <?php echo "value='".htmlspecialchars(getSession('guardian_phone'))."'"  ?> >
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-uppercase"> Email Address</label>
            <input type="text" class="form-control form-control-sm" name="guardian_email" required placeholder="Email Adress" <?php echo "value='".htmlspecialchars(getSession('guardian_email'))."'"  ?> >
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-uppercase"> Occupation</label>
            <input type="text" class="form-control form-control-sm" name="guardian_occupation" required placeholder="Occupation" <?php echo "value='".htmlspecialchars(getSession('guardian_occupation'))."'"  ?> >
        </div>

        
        <?php
            foreach($parents as $parent){
                ?>
                <hr class="mt-5">
                    <h5 class="mb-2 fw-bold text-uppercase"><?php echo $parent['type'] ?> INFORMATION</h5>
                    <div class="mb-3 mt-5">
                        <label class="form-label fw-bold text-uppercase">First name</label>
                        <input type="text" class="form-control form-control-sm"  value="<?php echo $parent['first_name']?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-uppercase">Middle name</label>
                        <input type="text" class="form-control form-control-sm" value="<?php echo $parent['middle_name']?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-uppercase">Last name</label>
                        <input type="text" class="form-control form-control-sm" value="<?php echo $parent['last_name']?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-uppercase">Phone Number</label>
                        <input type="text" class="form-control form-control-sm" value="<?php echo $parent['phone']?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-uppercase">Email Address</label>
                        <input type="text" class="form-control form-control-sm" value="<?php echo $parent['email']?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-uppercase">Occupation</label>
                        <input type="text" class="form-control form-control-sm" value="<?php echo $parent['occupation']?>" disabled>
                    </div>
                <?php
            }
        ?>

        <div class="d-flex justify-content-end my-5">
            <button class="btn btn-sm fw-bold btn-primary me-1" type="submit">UPDATE</button>
            <a href="view_pending_students.php" class="btn btn-danger btn-sm fw-bold">CANCEL</a>
        </div>
                    
        </form>
    </div>

    <div class="pb-2 px-2" id="info-tab" <?php echo isTabSet('info') ?>>
                    
     <form method="POST" action="../../../Backend-routes/admin/update_complete_student_route.php" onsubmit="submitRequest('updateStudentForm', event)" id="updateStudentForm">
        <h5 class="mb-2 fw-bold" id="exampleModalLabel">STUDENT INFORMATION</h5>
        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
        <div class="mb-3 mt-5">
            <label class="form-label fw-bold text-uppercase d-block">STUDENT TYPE</label>
            <span class="fw-bold text-uppercase text-primary"><?php echo $row['student_type'] ?></span>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-uppercase">SECTION</label>
            <select name='section' class='form-control form-control-sm my-2 me-3 border rounded p-1' required>
                  <option value='' disabled selected>Select an option</option>
                    <?php
                        foreach ($sections as $section) {
                          $isSelected = $section['id'] == $row['section_id'] ? 'selected' : '';
                          echo "<option value='{$section['id']}' $isSelected>{$section['name']} - {$section['grade']}</option>";
                      }
                    ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-uppercase">First name</label>
            <input type="text" class="form-control form-control-sm" name="first_name" required placeholder="First_name" <?php echo "value='".htmlspecialchars(getSession('first_name'))."'"  ?> >
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-uppercase">Middle name</label>
            <input type="text" class="form-control form-control-sm" name="middle_name" placeholder="Middle name" <?php echo "value='".htmlspecialchars(getSession('middle_name'))."'"  ?> >
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-uppercase">Last name</label>
            <input type="text" class="form-control form-control-sm"name="last_name" required placeholder="Last name" <?php echo "value='".htmlspecialchars(getSession('last_name'))."'"  ?> >
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-uppercase">Student No</label>
            <input type="text" class="form-control form-control-sm"  <?php echo "value='VCS000".$row['id']."'"  ?> disabled>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-uppercase">Phone Number</label>
            <input type="text" class="form-control form-control-sm" name="phone" required placeholder="Phone Number" <?php echo "value='".htmlspecialchars(getSession('phone'))."'"  ?> >
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-uppercase">Email Address</label>
            <input type="text" class="form-control form-control-sm" name="email" required placeholder="Email Adress" <?php echo "value='".htmlspecialchars(getSession('email'))."'"  ?> >
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-uppercase">Gender</label><br>
            <?php
                if(getSession('gender') == 'Male'){
                ?>
                    <input type="radio" value="Male" checked name="gender"> Male 
                    <input type="radio" value="Female" name="gender"> Female
                <?php
                }else{
                ?>
                    <input type="radio" value="Male" name="gender"> Male 
                    <input type="radio" value="Female" checked name="gender"> Female
                <?php
                }
            ?>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-uppercase">Date of Birth</label>
            <input type="date" class="form-control form-control-sm" name="birthday" required    <?php echo "value='".htmlspecialchars(getSession('birthday'))."'"  ?> >
        </div>
        <div class="mb-3">
            <h5 class="form-label fw-bold text-uppercase">Address</h5>
            <div class="border border-dark p-2">
            <div class="p-2">
                <label class="form-label fw-bold text-uppercase">Street # / Unit # </label>
                <input type="text" class="form-control form-control-sm"name="street_no"
                <?php echo "value='".htmlspecialchars(getSession('street_no'))."'"  ?> >
            </div>
            <div class="p-2">
                <label class="form-label fw-bold text-uppercase">Street </label>
                <input type="text" class="form-control form-control-sm"name="street"
                <?php echo "value='".htmlspecialchars(getSession('street'))."'"  ?> >
            </div>
            <div class="p-2">
                <label class="form-label fw-bold text-uppercase">Subdivision/Village/Bldg</label>
                <input type="text" class="form-control form-control-sm"name="village"
                <?php echo "value='".htmlspecialchars(getSession('village'))."'"  ?> >
            </div>
            <div class="p-2">
                <label class="form-label fw-bold text-uppercase">Barangay <b class="text-danger">*</b></label>
                <input type="text" class="form-control form-control-sm"name="barangay" required
                <?php echo "value='".htmlspecialchars(getSession('barangay'))."'"  ?> >
            </div>
            <div class="p-2">
                <label class="form-label fw-bold text-uppercase">City/Municipality <b class="text-danger">*</b></label>
                <input type="text" class="form-control form-control-sm"name="city_municipality" required
                <?php echo "value='".htmlspecialchars(getSession('city_municipality'))."'"  ?> >
            </div>
            <div class="p-2">
                <label class="form-label fw-bold text-uppercase">Province <b class="text-danger">*</b></label>
                <input type="text" class="form-control form-control-sm"name="province" required
                <?php echo "value='".htmlspecialchars(getSession('province'))."'"  ?> >
            </div>
            <div class="p-2">
                <label class="form-label fw-bold text-uppercase">Zip Code <b class="text-danger">*</b></label>
                <input type="text" class="form-control form-control-sm"name="zip_code" required
                <?php echo "value='".htmlspecialchars(getSession('zip_code'))."'"  ?> >
            </div>
            </div>
        </div>
        <div class="d-flex justify-content-end my-5">
            <button class="btn btn-sm fw-bold btn-primary me-1" type="submit">UPDATE</button>
            <a href="enrolled_students.php" class="btn btn-danger btn-sm fw-bold">CANCEL</a>
        </div>
                    
        </form>
    </div>
</div>
</body>
<?php
	require_once "../includes/includes_scripts.php";
?>
<script> setActive('students_tab'); </script>