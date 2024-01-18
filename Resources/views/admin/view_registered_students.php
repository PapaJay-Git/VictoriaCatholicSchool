<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_registered_students_route.php";

$title = "Registered Students List";

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

function convertTxt($string = null){

  return $string == null ? '' : ucwords(strtolower($string));
}

?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h5 >REGISTERED STUDENTS</h5>
            <div class="btn-group">
                <a href="students-add.php" class="btn btn-sm fw-bold btn-dark" data-bs-toggle="modal" data-bs-target="#addModal">ADD STUDENT</a>
                <a href="students.php" class="btn btn-sm btn-danger fw-bold">BACK</a>
            </div>
        </div>

           <div class="table-responsive">
              <table class="table table-bordered table-striped"  id="sectionsTable">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">LRN</th>
                    <th scope="col">Student No</th>
                    <th scope="col">Section</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody id="tbody-sections">
                <?php
                  foreach($students as $student){
                    $lockQuestion = $student['is_locked'] == 1 ? 'Are you sure you want to unlock this account?' : 'Are you sure you want to lock this account?';
                    echo "
                      <tr>
                          <td>".convertTxt($student['last_name'].', '.$student['first_name'])." </td>
                          <td>{$student['email']}</td>
                          <td>{$student['lrn']}</td>
                          <td>VCS00{$student['id']}</td>
                          <td>".($student['section_name'] == NULL ? 'None' : $student['section_name']." - ".$student['section_grade'])."</td>
                          <td>
                          <a class='btn btn-sm btn-primary fw-bold' href='update-student.php?id=".$student['id']."'>UPDATE</a>
                          <button class='btn btn-sm btn-danger fw-bold' onclick=".'"'."confirmDelete('../../../Backend-routes/admin/delete_student_route.php?id=".$student['id']."')".'"'.">DELETE</button>
                          ";
                          ?>
                          <form class="d-inline" method="GET" action="../../../Backend-routes/admin/lock_user.php" onsubmit="submitRequest('lockUser<?php echo $student['id'] ?>', event, '<?php echo $lockQuestion; ?>')" id="lockUser<?php echo $student['id'] ?>">

                          <input type="hidden" name="id" value="<?php echo $student['id'] ?>">
                          <input type="hidden" name="url" value="view_registered_students.php">
                          <?php
                            if($student['is_locked'] == 1){
                              echo '<button class="btn btn-sm fw-bold btn-dark" type="submit">LOCKED</button>';
                            }else{
                              echo '<button class="btn btn-sm fw-bold btn-success" type="submit">LOCK</button>';
                            }

                          ?>  
                          </form>
                          <?php
                      echo "
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
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <form method="POST" action="../../../Backend-routes/admin/add_new_student_route.php" onsubmit="submitRequest('addStudentForm', event)" id="addStudentForm">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <h5 class="form-label mb-3">Student Information</h5>
              <div class="row">
                  <div class="col-12 col-md-4 mb-3">
                    <?php $student_type = getSession('student_type');?>
                    <label class="form-label">STUDENT TYPE <b class="text-danger">*</b></label>
                    <select name='student_type' class='form-control my-2 me-3 border rounded p-1' required>
                      <option value='' disabled selected>Select an option</option>
                      <option value='new' <?php echo $student_type == 'new' ? 'selected' : '' ?> >NEW</option>
                      <option value='transfer' <?php echo $student_type == 'transfer' ? 'selected' : '' ?> >TRANSFEREE</option>
                    </select>
                  </div>
                  <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">SECTION <b class="text-danger">*</b></label>
                    <select name='section' class='form-control my-2 me-3 border rounded p-1' required>
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
                  <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">LRN <b class="text-danger">*</b></label>
                    <input type="text" minlength="12" maxlength="12"  class="form-control" name="lrn" required placeholder="LRN"
                    <?php echo "value='".htmlspecialchars(getSession('lrn'))."'"  ?> >
                  </div>
                  <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">First name <b class="text-danger">*</b></label>
                    <input type="text" class="form-control" name="first_name" required placeholder="First_name" 
                    <?php echo "value='".htmlspecialchars(getSession('first_name'))."'"  ?> >
                  </div>
                  <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">Middle name <b class="text-danger">*</b></label>
                    <input type="text" class="form-control" name="middle_name" placeholder="Middle name"
                    <?php echo "value='".htmlspecialchars(getSession('middle_name'))."'"  ?> >
                  </div>
                  <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">Last name <b class="text-danger">*</b></label>
                    <input type="text" class="form-control"name="last_name" required placeholder="Last name"
                    <?php echo "value='".htmlspecialchars(getSession('last_name'))."'"  ?> >
                  </div>
                  <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">Phone Number <b class="text-danger">*</b></label>
                    <input type="text" class="form-control" name="phone" required placeholder="Phone Number"
                    <?php echo "value='".htmlspecialchars(getSession('phone'))."'"  ?> >
                  </div>
                  <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">Email Address <b class="text-danger">*</b></label>
                    <input type="text" class="form-control" name="email" required placeholder="Email Adress"
                    <?php echo "value='".htmlspecialchars(getSession('email'))."'"  ?> >
                  </div>
                  <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">Date of Birth <b class="text-danger">*</b></label>
                    <input type="date" class="form-control" name="birthday" required 
                    <?php echo "value='".htmlspecialchars(getSession('birthday'))."'"  ?> >
                  </div>
                  <div class="col-12 col-md-8 col-lg-4 mb-3">
                    <label class="form-label">Default Password</label>
                    <small class="d-block"><strong>Last Name</strong> and <strong>Birth Year</strong> all lowercase</small>
                    <small class="d-block">Example is delacruz_2003</small>
                    <input type="text" class="form-control" name="password" disabled value="delacruz_2003"
                    <?php echo "value='".htmlspecialchars(getSession('password'))."'"  ?> >
                  </div>
                  <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">Gender <b class="text-danger">*</b></label><br>
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
              </div>
              <h5 class="form-label mt-3 mb-3">Address</h5>
              <div class="row">
                  <div class="col-12 col-md-4 col-lg-2 mb-3">
                      <label class="form-label">Street # / Unit # </label>
                      <input type="text" class="form-control"name="street_no"
                      <?php echo "value='".htmlspecialchars(getSession('street_no'))."'"  ?> placeholder="Street # / Unit #">
                  </div>
                  <div class="col-12 col-md-4 col-lg-3 mb-3">
                      <label class="form-label">Street</label>
                      <input type="text" class="form-control"name="street"
                      <?php echo "value='".htmlspecialchars(getSession('street'))."'"  ?> placeholder="Street">
                  </div>
                  <div class="col-12 col-md-4 col-lg-4 mb-3">
                      <label class="form-label">Subdivision/Village/Bldg</label>
                      <input type="text" class="form-control"name="village"
                      <?php echo "value='".htmlspecialchars(getSession('village'))."'"  ?> placeholder="Subdivision/Village/Bldg">
                  </div>
                  <div class="col-12 col-md-4 col-lg-3 mb-3">
                      <label class="form-label">Barangay <b class="text-danger">*</b></label>
                      <input type="text" class="form-control"name="barangay" required
                      <?php echo "value='".htmlspecialchars(getSession('barangay'))."'"  ?> placeholder="Barangay">
                  </div>
                  <div class="col-12 col-md-4 col-lg-3 mb-3">
                      <label class="form-label">City/Municipality <b class="text-danger">*</b></label>
                      <input type="text" class="form-control"name="city_municipality" required
                      <?php echo "value='".htmlspecialchars(getSession('city_municipality'))."'"  ?> placeholder="City/Municipality">
                  </div>
                  <div class="col-12 col-md-4 col-lg-3 mb-3">
                      <label class="form-label">Province <b class="text-danger">*</b></label>
                      <input type="text" class="form-control"name="province" required
                      <?php echo "value='".htmlspecialchars(getSession('province'))."'"  ?> placeholder="Province">
                  </div>
                  <div class="col-12 col-md-4 col-lg-2 mb-3">
                      <label class="form-label">Zip Code <b class="text-danger">*</b></label>
                      <input type="text" class="form-control"name="zip_code" required
                      <?php echo "value='".htmlspecialchars(getSession('zip_code'))."'"  ?> placeholder="Zip Code">
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