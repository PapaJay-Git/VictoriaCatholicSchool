<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_registered_students_route.php";

$title = "Admin - Registered Students";

$count = 1;

require_once "../includes/header_layout.php";

function getSession($data) {
    if (isset($_SESSION[$data])) {
      $session_value = $_SESSION[$data];
      unset($_SESSION[$data]);
      return $session_value;
    }
  
    return null; 
}

?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold">REGISTERED STUDENTS</h2>
            <div class="btn-group">
                <a href="students-add.php" class="btn btn-sm fw-bold btn-dark" data-bs-toggle="modal" data-bs-target="#addModal">ADD STUDENT</a>
                <a href="students.php" class="btn btn-sm btn-danger fw-bold">BACK</a>
            </div>
        </div>

           <div class="table-responsive">
              <table id="sectionsTable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Student No</th>
                    <th scope="col">Section</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody id="tbody-sections">
                <?php
                  foreach($students as $student){
                    echo "
                      <tr>
                          <td>".$count++."</td>
                          <td>{$student['first_name']}</td>
                          <td>{$student['last_name']}</td>
                          <td>{$student['email']}</td>
                          <td>VCS00{$student['id']}</td>
                          <td>".($student['section_name'] == NULL ? 'None' : $student['section_name']." - ".$student['section_grade'])."</td>
                          <td>
                          <a class='btn btn-sm btn-primary fw-bold' href='update-student.php?id=".$student['id']."'>UPDATE</a>
                          <button class='btn btn-sm btn-danger fw-bold' onclick=".'"'."confirmDelete('../../../Backend-routes/admin/delete_student_route.php?id=".$student['id']."')".'"'.">DELETE</button>
                          </td>
                      </tr>
                  ";
                  }
                ?>
                </tbody>
              </table>
           </div>
     </div>

</body>
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <form method="POST" action="../../../Backend-routes/admin/add_new_student_route.php" onsubmit="submitRequest('addStudentForm', event)" id="addStudentForm">
            <div class="modal-header">
              <h5 class="modal-title fw-bold" id="exampleModalLabel">STUDENT INFORMATION </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                  <?php $student_type = getSession('student_type');?>
                  <label class="form-label fw-bold text-uppercase">STUDENT TYPE <b class="text-danger">*</b></label>
                  <select name='student_type' class='form-control form-control-sm my-2 me-3 border rounded p-1' required>
                    <option value='' disabled selected>Select an option</option>
                    <option value='new' <?php echo $student_type == 'new' ? 'selected' : '' ?> >NEW</option>
                    <option value='transfer' <?php echo $student_type == 'transfer' ? 'selected' : '' ?> >TRANSFEREE</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">SECTION <b class="text-danger">*</b></label>
                  <select name='section' class='form-control form-control-sm my-2 me-3 border rounded p-1' required>
                  <option value='' disabled selected>Select an option</option>
                    <?php
                        $sectionSessionID = getSession('section');
                        foreach ($sections as $section) {
                          $isSelected = ((string)$section['id'] == $sectionSessionID) ? 'selected' : '';
                          echo "<option value='{$section['id']}' $isSelected>{$section['name']} - {$section['grade']}</option>";
                      }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">First name <b class="text-danger">*</b></label>
                  <input type="text" class="form-control form-control-sm" name="first_name" required placeholder="First_name" 
                  <?php echo "value='".htmlspecialchars(getSession('first_name'))."'"  ?> >
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">Middle name <b class="text-danger">*</b></label>
                  <input type="text" class="form-control form-control-sm" name="middle_name" required placeholder="Middle name"
                  <?php echo "value='".htmlspecialchars(getSession('middle_name'))."'"  ?> >
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">Last name <b class="text-danger">*</b></label>
                  <input type="text" class="form-control form-control-sm"name="last_name" required placeholder="Last name"
                  <?php echo "value='".htmlspecialchars(getSession('last_name'))."'"  ?> >
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">Default Password</label>
                    <small class="d-block"><strong>Last Name</strong> and <strong>Birth Year</strong> all lowercase</small>
                    <small class="d-block">Example is delacruz_2003</small>
                    <input type="text" class="form-control form-control-sm" name="password" disabled value="delacruz_2003"
                    <?php echo "value='".htmlspecialchars(getSession('password'))."'"  ?> >
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">Student No <b class="text-danger">*</b></label>
                  <input type="text" class="form-control form-control-sm" name="school_number" required placeholder="Student No"
                  <?php echo "value='".htmlspecialchars(getSession('school_number'))."'"  ?> >
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">Phone Number <b class="text-danger">*</b></label>
                  <input type="text" class="form-control form-control-sm" name="phone" required placeholder="Phone Number"
                  <?php echo "value='".htmlspecialchars(getSession('phone'))."'"  ?> >
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">Email Address <b class="text-danger">*</b></label>
                  <input type="text" class="form-control form-control-sm" name="email" required placeholder="Email Adress"
                  <?php echo "value='".htmlspecialchars(getSession('email'))."'"  ?> >
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">Gender <b class="text-danger">*</b></label><br>
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
                  <label class="form-label fw-bold text-uppercase">Date of Birth <b class="text-danger">*</b></label>
                  <input type="date" class="form-control form-control-sm" name="birthday" required 
                  <?php echo "value='".htmlspecialchars(getSession('birthday'))."'"  ?> >
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
              </div>
              <div class="modal-footer">
                  <button class="btn btn-sm fw-bold btn-primary" type="submit">SUBMIT</button>
                  <button type="button" class="btn btn-sm fw-bold btn-danger" data-bs-dismiss="modal">CANCEL</button>
              </div>
            </form>
          </div>
        </div>
    </div>
<?php
	require_once "../includes/includes_scripts.php";
?>
<script src="../../js/admin/sections.js"></script>
<script> setActive('students_tab'); </script>