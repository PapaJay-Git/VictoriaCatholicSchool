<?php
session_start();

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
	<title>Registration - Victoria Catholic School of Tarlac Inc</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">

  	<!-- FONT -->
	<link href="https://fonts.googleapis.com/css?family=Quicksand:400,600,700&display=swap" rel="stylesheet">
    
	<!-- Animate CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
		
	<!-- Style -->
	<link rel="stylesheet" href="../../css/style_registration.css">
		
	<link rel="icon" href="../../images/victoria.ico">
	<link rel="stylesheet" href="../../css/assets/dataTables/jquery.dataTables.min.css">
	<link rel="stylesheet" href="../../css/assets/dataTables/buttons.dataTables.min.css">
	
</head>
<body class="body">

<!-- HEADER -->
<header role="banner">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top border-bottom border-warning border-3 animate__animated animate__fadeIn">
    <div class="container">
      <a class="navbar-brand fs-6 text-uppercase" href="index.php"><img class ="logo" src="../../images/victoria.png" width="45px" height="45px"> Victoria Catholic School</a>
    </div>
  </nav>
</header>
<!-- END header -->

<div class="hero text-center bg-image"style="background-image: url('../../images/cover.jpg'),linear-gradient(rgba(0,0,0,0.8),rgba(0,0,0,0.8));">
    <div class="d-flex justify-content-center align-items-center h-100">
      <div class="container">
            <div class="text-center">
                <h2 class="text-white fs-1 fw-bold animate__animated animate__fadeInLeft">REGISTRATION</h2>
            </div>
        </div>
    </div>
</div>

<form method="POST" id="signUpForm" action="../../../Backend-routes/login/student_registration.php">
    <!-- start step indicators -->
    <div class="form-header d-flex mb-4">
        <span class="stepIndicator">Student Information</span>
        <span class="stepIndicator">Address Information</span>
        <span class="stepIndicator">Parent/Guardian Information</span>
        <span class="stepIndicator">Finish</span>
    </div>
    <!-- end step indicators -->
    
    <!-- step one -->
    <div class="step">
        <p class="text-start  fs-4 fw-bold mb-4"><span style="border-bottom: 3px solid #ffd308; padding-bottom: 10px;">Student Information</span></p>
        <div class="row">
            <div class="col-lg-6 mb-3">
                <label>What type of student are you? </label>
                <select name="student_type" oninput="this.className = ''">
                    <option value="new"  <?php echo (getSession('student_type') == 'new' ? 'selected' : '') ?> >New Student</option>
                    <option value="transfer" <?php echo (getSession('student_type') == 'transfer'  ? 'selected' : '') ?> >Transferee</option>
                </select>
            </div>
            <div class="col-lg-6 mb-3">
                <label>Grade Level</label>
                <select name="grade" oninput="this.className = ''">
                    <option <?php echo getSession('grade') == '7'  ? 'selected' : '' ?> value="7"  >7</option>
                    <option <?php echo getSession('grade') == '8'  ? 'selected' : '' ?>  value="8"  >8</option>
                    <option <?php echo getSession('grade') == '9'  ? 'selected' : '' ?> value="9"  >9</option>
                    <option <?php echo getSession('grade') == '10'  ? 'selected' : '' ?> value="10"  >10</option>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" placeholder="Last Name" oninput="this.className = ''" name="last_name"  <?php echo "value='".htmlspecialchars(getSession('last_name'))."'"  ?> >
        </div>
        <div class="mb-3">
            <label>First Name</label>
            <input type="text" placeholder="First Name" oninput="this.className = ''" name="first_name" <?php echo "value='".htmlspecialchars(getSession('first_name'))."'"  ?> >
        </div>
        <div class="mb-3">
            <label>Middlle Name</label>
            <input type="text" placeholder="Middle Name" oninput="this.className = ''" name="middle_name" <?php echo "value='".htmlspecialchars(getSession('middle_name'))."'"  ?> >
        </div>
        <div class="row">
            <div class="col-lg-6 mb-3">
                <label>Gender</label>
                <select name="gender" oninput="this.className = ''">
                    <option value="Male" <?php echo getSession('gender')== 'Male'  ? 'selected' : '' ?> >Male</option>
                    <option value="Female" <?php echo getSession('gender')== 'Female'  ? 'selected' : '' ?> >Female</option>
                </select>
            </div>
            <div class="col-lg-6 mb-3">
                <label>Birthday</label>
                <input type="date" oninput="this.className = ''" name="birthday" <?php echo "value='".htmlspecialchars(getSession('birthday'))."'"  ?> >
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 mb-3">
                <label>Phone Number</label>
                <input type="tel" oninput="this.className = ''" pattern="[0-9]{4}-[0-9]{3}-[0-9]{4}" placeholder="Phone (0000-000-0000)" name="phone" <?php echo "value='".htmlspecialchars(getSession('phone'))."'"  ?> >
            </div>
            <div class="col-lg-8 mb-3">
                <label>Email</label>
                <input type="email" placeholder="Email" oninput="this.className = ''" name="email" <?php echo "value='".htmlspecialchars(getSession('email'))."'"  ?> >
            </div>
        </div>

    </div>
    
    <!-- step two -->
    <div class="step">
        <p class="text-start  fs-4 fw-bold mb-4"><span style="border-bottom: 3px solid #ffd308; padding-bottom: 10px;">Address Information</span></p>
        <div class="row">
            <div class="col-lg-12 mb-3">
                <textarea name="address" class="form-control"  placeholder="Your address..." name="unit" cols="30" rows="10"><?php echo htmlspecialchars(getSession('address'))  ?></textarea>
            </div>
        </div>
    </div>
    
    <!-- step three -->
    <div class="step">
        <p class="text-start  fs-4 fw-bold mb-4"><span style="border-bottom: 3px solid #ffd308; padding-bottom: 10px;">Parent/Guardian Information</span></p>
        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" placeholder="Last Name" oninput="this.className = ''" name="guardian_last_name" <?php echo "value='".htmlspecialchars(getSession('guardian_last_name'))."'"  ?> >
        </div>
        <div class="mb-3">
            <label>First Name</label>
            <input type="text" placeholder="First Name" oninput="this.className = ''" name="guardian_first_name" <?php echo "value='".htmlspecialchars(getSession('guardian_first_name'))."'"  ?> >
        </div>
        <div class="mb-3">
            <label>Middlle Name</label>
            <input type="text" placeholder="Middle Name" oninput="this.className = ''" name="guardian_middle_name" <?php echo "value='".htmlspecialchars(getSession('guardian_middle_name'))."'"  ?> >
        </div>
        <div class="row">
            <div class="col-lg-4 mb-3">
                <label>Phone Number</label>
                <input type="tel" oninput="this.className = ''" pattern="[0-9]{4}-[0-9]{3}-[0-9]{4}" placeholder="Phone (0000-000-0000)" name="guardian_phone" <?php echo "value='".htmlspecialchars(getSession('guardian_phone'))."'"  ?> >
            </div>
            <div class="col-lg-8 mb-3">
                <label>Email</label>
                <input type="email" placeholder="Email" oninput="this.className = ''" name="guardian_email" name="guardian_email" <?php echo "value='".htmlspecialchars(getSession('guardian_email'))."'"  ?> >
            </div>
        </div>
        <div class="mb-3">
            <label>Occupation</label>
            <input type="text" placeholder="Occupation" oninput="this.className = ''" name="guardian_occupation" <?php echo "value='".htmlspecialchars(getSession('guardian_occupation'))."'"  ?>>
        </div>
    </div>

    <div class="step">
        <h1 class="text-start fs-1 fw-bold text-center py-5">Thank You!</span></h1>
        
    </div>
    
    <!-- start previous / next buttons -->
    <div class="form-footer d-flex">
        <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
        <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
    </div>
    <!-- end previous / next buttons -->
    </form>
</body>

<?php
	require_once "../includes/includes_scripts.php";
?>

<script src="../../js/regis.js"></script>
