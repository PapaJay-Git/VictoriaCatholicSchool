<?php

require_once '../../../Middleware/CheckIfLoggedIn_LoginPageOnly.php';

function getSession($data) {
    if (isset($_SESSION[$data])) {
      $session_value = $_SESSION[$data];
      return $session_value;
    }
  
    return null; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Login - Victoria Catholic School of Tarlac Inc</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">

  	<!-- FONT -->
	<link href="https://fonts.googleapis.com/css?family=Quicksand:400,600,700&display=swap" rel="stylesheet">
    
	<!-- Animate CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
		
	<!-- Style -->
	<link rel="stylesheet" href="../../css/style_login.css">
		
	<link rel="icon" href="../../images/victoria.ico">
	<link rel="stylesheet" href="../../css/assets/dataTables/jquery.dataTables.min.css">
	<link rel="stylesheet" href="../../css/assets/dataTables/buttons.dataTables.min.css">
	
</head>
<body class="body-login" style="background-image: url('../../images/cover-login.jpg'),linear-gradient(rgba(0,0,0,0.8),rgba(0,0,0,0.8));">
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <!-- Login -->
    <div class="row border rounded-5 p-3 border-0 box-area" style="background-image: url('../../images/hero_3.jpg');">
    <!--------------------------- Left Box ----------------------------->
    <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box">
    	<div class="featured-image mb-2">
			<a href="index.php"><img src="../../images/victoria.png" width="100px" height="100px" class="img-fluid"></a>
        </div>
        <p class="header-text-left text-white fw-bold fs-3">Victoria Catholic School</p>
    </div> 
    <!-------------------- ------ Right Box ---------------------------->
    <div class="col-md-6 right-box">
    	<div class="row align-items-center">
        	<div class="mb-3">
                <h2 class="header-text-right text-white fw-bold"><span style="border-bottom: 3px solid #ffd308; padding-bottom: 5px;">Hello, VCSian</span></h2>
            </div>
			
			<!-- Form -->
			<form class="login" method="post" action="../../../Backend-routes/login/login-router.php">
				<!-- email -->
				<div class="mb-2">
					<label class="form-label text-white fw-bold">Email</label>
					<input type="text" class="form-control form-control-lg bg-light fs-6" name="email" placeholder="Email" <?php echo "value='".htmlspecialchars(getSession('email'))."'"  ?>>
				</div>
				<!-- email -->
				
				<!-- Password -->
				<div class="mb-2">
					<label class="form-label text-white fw-bold">Password</label>
					<div class="password-container">
						<input type="password"  class="password-input form-control form-control-lg bg-light fs-6" id="password1"  name="password" required placeholder="Password" autocomplete="password">
						<span class="toggle-password" onclick="togglePasswordVisibility('password1')">👁️‍🗨️</span>
					</div>
				</div>
				<!-- Password -->

				<!-- Login Button -->
				<div class="mb-3">
					<button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Login</button>
				</div>
				<!-- Login Button -->

			</form>
			<!-- Form -->

			<!-- Footer -->
			<div class="row">
                <small class="text-white text-center">Copyright © 2023 - Victoria Catholic School of Tarlac Inc.<br>All Rights Reserved.</small>
            </div>
			<!-- Footer -->
        </div>
    </div> 
</div>
<!-- Login -->
</body>

<?php
	require_once "../includes/includes_scripts.php";
?>
