<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_registered_student_route.php";

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

    if($tab == 'info' && (!isset($_GET['password']) && !isset($_GET['checklist']))){
        return "style='display:block'";
    }else if($tab == 'password' || $tab =='checklist'){
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
            <div class="btn btn-primary btn-sm fw-bold" onclick="hidePasswordTab()">BASIC INFO</div>
            <div class="btn btn-danger btn-sm fw-bold" onclick="showChecklist()">REQUIREMENTS</div>
            <div class="btn btn-secondary btn-sm fw-bold" onclick="showPasswordTab()">PASSWORD</div>
        </div>

        
        <a href="view_registered_students.php" class="btn btn-sm btn-danger fw-bold">BACK</a>


    </div>



    <div class="pb-2 px-2"  id="checklist-tab" <?php echo isTabSet('checklist') ?>>
        <form method="POST" action="../../../Backend-routes/admin/update_student_requirements_route.php" onsubmit="submitRequest('updateStudentChecklist', event)" id="updateStudentChecklist">
            <h5 class="mb-2 fw-bold mb-5 text-uppercase"><?php echo $row['student_type'] ?> STUDENT REQUIREMENTS</h5>
            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
            <div class="d-flex flex-column">
                <label class="fw-bold">
                    <input type="checkbox" name="form_138" value="yes" <?php echo isChecked('form_138') ? 'checked' : '' ?> > Form 138-A
                </label>
                <label class="fw-bold">
                    <input type="checkbox" name="good_moral" value="yes" <?php echo isChecked('good_moral') ? 'checked' : '' ?> > Certificate of Good Moral
                </label>
                <label class="fw-bold">
                    <input type="checkbox" name="baptisaml_of_birth" value="yes" <?php echo isChecked('baptisaml_of_birth') ? 'checked' : '' ?> > Photocopy of Baptismal and Birth
                </label>
                <label class="fw-bold">
                    <input type="checkbox" name="nso_certificate" value="yes" <?php echo isChecked('nso_certificate') ? 'checked' : '' ?> > Certificate (NSO Certificates)
                </label>
                <label class="fw-bold">
                    <input type="checkbox" name="previous_year_report_card" value="yes" <?php echo isChecked('previous_year_report_card') ? 'checked' : '' ?> > Previous Year Report Card
                </label>
                <?php
                if($row['student_type'] == 'transfer'){
                    echo "<label class='fw-bold'>
                        <input type='checkbox' name='honorary_dismissal' value='yes'".
                        (isChecked('honorary_dismissal') ? 'checked' : '')."> Honorary Dismissal
                    </label>";
                }
                ?>
            </div>
            <div class="d-flex justify-content-end my-5">
                <button class="btn btn-sm fw-bold btn-primary me-1" type="submit">CHANGE</button>
                <a href="view_registered_students.php" class="btn btn-danger btn-sm fw-bold">CANCEL</a>
            </div>

        </form>
    </div>

    <div class="pb-2 px-2"  id="password-tab" <?php echo isTabSet('password') ?>>
        <form method="POST" action="../../../Backend-routes/admin/update_student_password_route.php" onsubmit="submitRequest('updateStudentFormPassword', event)" id="updateStudentFormPassword">
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
                <a href="view_registered_students.php" class="btn btn-danger btn-sm fw-bold">CANCEL</a>
            </div>

        </form>
    </div>

    <div class="pb-2 px-2" id="info-tab" <?php echo isTabSet('info') ?>>
                    
     <form method="POST" action="../../../Backend-routes/admin/update_student_route.php" onsubmit="submitRequest('updateStudentForm', event)" id="updateStudentForm">
        <h5 class="mb-2 fw-bold" id="exampleModalLabel">STUDENT INFORMATION</h5>
        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
        <div class="mb-3">
            <?php $student_type = getSession('student_type');?>
            <label class="form-label fw-bold text-uppercase">STUDENT TYPE</label>
            <select name='student_type' class='form-control form-control-sm my-2 me-3 border rounded p-1' required>
            <option value='' disabled selected>Select an option</option>
            <option value='new' <?php echo $student_type == 'new' ? 'selected' : '' ?> >NEW</option>
            <option value='transfer' <?php echo $student_type == 'transfer' ? 'selected' : '' ?> >TRANSFEREE</option>
            </select>
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
            <input type="text" class="form-control form-control-sm" name="middle_name" required placeholder="Middle name" <?php echo "value='".htmlspecialchars(getSession('middle_name'))."'"  ?> >
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-uppercase">Last name</label>
            <input type="text" class="form-control form-control-sm"name="last_name" required placeholder="Last name" <?php echo "value='".htmlspecialchars(getSession('last_name'))."'"  ?> >
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-uppercase">School ID</label>
            <input type="text" class="form-control form-control-sm" name="school_number" required placeholder="School ID" <?php echo "value='".htmlspecialchars(getSession('school_number'))."'"  ?> >
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
                <label class="form-label fw-bold text-uppercase">Street # / Unit # <b class="text-danger">*</b></label>
                <input type="text" class="form-control form-control-sm"name="street_no" required
                <?php echo "value='".htmlspecialchars(getSession('street_no'))."'"  ?> >
            </div>
            <div class="p-2">
                <label class="form-label fw-bold text-uppercase">Street <b class="text-danger">*</b></label>
                <input type="text" class="form-control form-control-sm"name="street" required
                <?php echo "value='".htmlspecialchars(getSession('street'))."'"  ?> >
            </div>
            <div class="p-2">
                <label class="form-label fw-bold text-uppercase">Subdivision/Village/Bldg</label>
                <input type="text" class="form-control form-control-sm"name="village"
                <?php echo "value='".htmlspecialchars(getSession('village'))."'"  ?> >
            </div>
            <div class="p-2">
                <label class="form-label fw-bold text-uppercase">Barangay</label>
                <input type="text" class="form-control form-control-sm"name="barangay"
                <?php echo "value='".htmlspecialchars(getSession('barangay'))."'"  ?> >
            </div>
            <div class="p-2">
                <label class="form-label fw-bold text-uppercase">City/Municipality <b class="text-danger">*</b></label>
                <input type="text" class="form-control form-control-sm"name="city_municipality" required
                <?php echo "value='".htmlspecialchars(getSession('city_municipality'))."'"  ?> >
            </div>
            <div class="p-2">
                <label class="form-label fw-bold text-uppercase">Province</label>
                <input type="text" class="form-control form-control-sm"name="province"
                <?php echo "value='".htmlspecialchars(getSession('province'))."'"  ?> >
            </div>
            <div class="p-2">
                <label class="form-label fw-bold text-uppercase">Zip Code</label>
                <input type="text" class="form-control form-control-sm"name="zip_code"
                <?php echo "value='".htmlspecialchars(getSession('zip_code'))."'"  ?> >
            </div>
            </div>
        </div>

        <div class="d-flex justify-content-end my-5">
            <button class="btn btn-sm fw-bold btn-primary me-1" type="submit">UPDATE</button>
            <a href="view_registered_students.php" class="btn btn-danger btn-sm fw-bold">CANCEL</a>
        </div>
                    
        </form>
    </div>
</div>
</body>
<?php
	require_once "../includes/includes_scripts.php";
?>
<script> setActive('students_tab'); </script>