<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

$title = "Admin - My Password";

require_once "../includes/header_layout.php";

?>
<body>
<?php 
    include "includes/navbar.php";
?>
<div class="container my-5">
    <div class="d-block mb-4">
        <h5 class="mb-2 fw-bold">CHANGE PASSWORD</h5>
        <small>(Atleast 8 characters, 1 number, 1 capital and lower case letter, and no spaces)</small>
    </div>
    <div class="pb-2 px-2"  id="password-tab">
        <form method="POST" action="../../../Backend-routes/admin/update_my_password_route.php" onsubmit="submitRequest('updateMyPasswod', event)" id="updateMyPasswod">
            <div class="mb-3 m-w-300px">
                <label class="form-label fw-bold text-uppercase d-block">Old Password</label>
                <div class="password-container">
                    <input type="password"  class="password-input form-control form-control-sm" id="password1"  name="old_password" required placeholder="Old Password" autocomplete="old_password">
                    <span class="toggle-password" onclick="togglePasswordVisibility('password1')">👁️‍🗨️</span>
                </div>
            </div>
            <div class="mb-3 m-w-300px">
                <label class="form-label fw-bold text-uppercase d-block">New Password</label>
                <div class="password-container">
                    <input type="password"  class="password-input form-control form-control-sm" id="password2"  name="new_password" required placeholder="New Password" autocomplete="new_password">
                    <span class="toggle-password" onclick="togglePasswordVisibility('password2')">👁️‍🗨️</span>
                </div>
            </div>
            <div class="mb-3 m-w-300px">
                <label class="form-label fw-bold text-uppercase d-block">Confirm New Password</label>
                <div class="password-container">
                    <input type="password"  class="password-input form-control form-control-sm" id="password3"  name="confirm_password" required placeholder="Confirm New Password" autocomplete="confirm_password">
                    <span class="toggle-password" onclick="togglePasswordVisibility('password3')">👁️‍🗨️</span>
                </div>
            </div>
            <div class="d-flex justify-content-end m-w-300px">
                <button class="btn btn-sm fw-bold btn-primary me-1" type="submit">CHANGE</button>
                <a href="profiles.php" class="btn btn-danger btn-sm fw-bold">BACK</a>
            </div>

        </form>
    </div>
</div>
</body>
<?php
	require_once "../includes/includes_scripts.php";
?>
<script> setActive('profiles_tab'); </script>