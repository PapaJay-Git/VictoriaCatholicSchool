<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_parent_route.php";

$title = "Admin - Update Parent/Guardian Account";

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

function isPasswordSet($tab){
    if($tab == 'password'){
        return isset($_GET['password']) ? "style='display:block'" : "style='display:none'";
    }

    if($tab == 'info'){
        return isset($_GET['password']) ? "style='display:none'" : "style='display:block'";
    }

    return NULL;
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
            <div class="btn btn-secondary btn-sm fw-bold" onclick="showPasswordTab()">PASSWORD</div>
        </div>
        
        <a href="parents.php" class="btn btn-sm btn-danger fw-bold">BACK</a>
    </div>
    <div class="pb-2 px-2"  id="password-tab" <?php echo isPasswordSet('password') ?>>
        <form method="POST" action="../../../Backend-routes/admin/update_parent_password_route.php" onsubmit="submitRequest('updateparentPasswordForm', event)" id="updateparentPasswordForm">
            <h5 class="mb-2 fw-bold">CHANGE PASSWORD</h5>
            <small>(Atleast 8 characters, 1 number, 1 capital and lower case letter, and no spaces)</small>
            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
            <div class="mb-3 m-w-300px">
                <label class="form-label">New Password</label>
                <div class="password-container">
                    <input type="password"  class="password-input form-control" id="password2"  name="new_password" required placeholder="New Password" autocomplete="new_password">
                    <span class="toggle-password" onclick="togglePasswordVisibility('password2')"><img src="../../images/see.svg" alt="" style="width: auto; height: 20px;"></span>
                </div>
            </div>
            <div class="mb-3 m-w-300px">
                <label class="form-label">Confirm New Password</label>
                <div class="password-container">
                    <input type="password"  class="password-input form-control" id="password3"  name="confirm_password" required placeholder="Confirm New Password" autocomplete="confirm_password">
                    <span class="toggle-password" onclick="togglePasswordVisibility('password3')"><img src="../../images/see.svg" alt="" style="width: auto; height: 20px;"></span>
                </div>
            </div>
            <div class="d-flex justify-content-end m-w-300px">
                <button class="btn btn-sm fw-bold btn-primary me-1" type="submit">CHANGE</button>
            </div>

        </form>
    </div>
    <div class="pb-2 px-2" id="info-tab" <?php echo isPasswordSet('info') ?>>
     <form method="POST" action="../../../Backend-routes/admin/update_parent_route.php" onsubmit="submitRequest('updateparentForm', event)" id="updateparentForm">
        <h5 class="mb-2 fw-bold text-uppercase" id="exampleModalLabel"><?php echo $row['guardian_type'] ?? 'PARENT/GUARDIAN' ?> INFORMATION</h5>
        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
        <div class="row">
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label" >Relationship</label>
                <select name="guardian_type" class="form-control">
                    <option <?php echo getSession('guardian_type') == 'mother'  ? 'selected' : '' ?> value="mother"  >Mother</option>
                    <option <?php echo getSession('guardian_type') == 'father'  ? 'selected' : '' ?> value="father"  >Father</option>
                    <option <?php echo getSession('guardian_type') == 'guardian'  ? 'selected' : '' ?> value="guardian"  >Guardian</option>
                </select>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label">First name</label>
                <input type="text" class="form-control" name="first_name" required placeholder="First_name" <?php echo "value='".htmlspecialchars(getSession('first_name'))."'"  ?> >
            </div>
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label">Middle name</label>
                <input type="text" class="form-control" name="middle_name" placeholder="Middle name" <?php echo "value='".htmlspecialchars(getSession('middle_name'))."'"  ?> >
            </div>
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label">Last name</label>
                <input type="text" class="form-control"name="last_name" required placeholder="Last name" <?php echo "value='".htmlspecialchars(getSession('last_name'))."'"  ?> >
            </div>
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="phone" required placeholder="Phone Number" <?php echo "value='".htmlspecialchars(getSession('phone'))."'"  ?> >
            </div>
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label">Email Address</label>
                <input type="text" class="form-control" name="email" required placeholder="Email Adress" <?php echo "value='".htmlspecialchars(getSession('email'))."'"  ?> >
            </div>
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label"> Occupation</label>
                <input type="text" class="form-control" name="occupation" required placeholder="Occupation" <?php echo "value='".htmlspecialchars(getSession('occupation'))."'"  ?> >
            </div>
        </div>
        <div class="d-flex justify-content-end my-5">
            <button class="btn btn-sm fw-bold btn-primary me-1" type="submit">UPDATE</button>
            <a href="parents.php" class="btn btn-danger btn-sm fw-bold">CANCEL</a>
        </div>
                    
        </form>
    </div>
</div>
</body>
<?php
	require_once "../includes/includes_scripts.php";
?>
<script> setActive('parents_tab'); </script>