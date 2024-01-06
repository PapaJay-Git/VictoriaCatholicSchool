<?php
session_start();

function getSession($data) {
    if (isset($_SESSION[$data])) {
      $session_value = $_SESSION[$data];
      unset($_SESSION[$data]);
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

<div id="agreeDiv" <?php echo isset($_SESSION['agreed']) ? "style='display:none'" :  "style='display:block'" ?> >?>
    <div class="container pt-5 d-flex justify-content-center" >
        <div class="card w-75 " >
        <div class="card-body">
            <h5 class="card-title">Data Privary Policy</h5>
            <h6 class="card-subtitle mb-2 text-muted">Victoria Catholic School</h6>
            <p class="card-text">
                <p class="d-block">
                    We respect the fundamental rights of all individuals to the privacy of their personal data, and we commit to the responsible and lawful treatment of all personal data we handle. Moreover, we aim to comply with the requirements of all relevant personal data privacy and protection laws, particularly the Data Privacy Act of 2012 (DPA) and its implementing rules and regulations, while upholding our legitimate interests and effectively carrying out our responsibilities as an educational institution.</p>

                <p class="d-block mt-3">
                    This Data Privacy Policy is meant to help you understand what personal information we collect, why we collect it, and what we do with it. This policy applies to all STI ESG, Inc. offices, schools, websites, apps, and services.
                </p>
                <div class="mt-3 d-flex justify-content-end align-items-center">
                    <input type="checkbox" id="checkBox" class="me-2">
                    <label for="checkBox">I've read and agree on all terms</label>
                    
                    <button class="btn btn-primary btn-sm fw-bold ms-2" onclick="handleAgree()">Agree and Continue</button>
                </div>

            </p>
        </div>
        </div>
    </div>
</div>

<div id="enrollmentDiv" <?php echo isset($_SESSION['agreed']) ? "style='display:block'" :  "style='display:none'" ?> >
<form method="POST" id="signUpForm" action="../../../Backend-routes/login/student_registration.php" >
    <!-- start step indicators -->
    <!-- <div class="form-header d-flex mb-4">
        <span class="stepIndicator">Student Information</span>
        <span class="stepIndicator">Address Information</span>
        <span class="stepIndicator">Parent/Guardian Information</span>
        <span class="stepIndicator">Finish</span>
    </div> -->
    <!-- end step indicators -->
    
    <!-- step one -->
    <div >
        <p class="text-start  fs-4 fw-bold mb-4"><span style="border-bottom: 3px solid #ffd308; padding-bottom: 10px;">Student Information</span></p>
        <div class="row">
            <div class="col-lg-6 mb-3">
                <label>What type of student are you? <b class="text-danger">*</b></label>
                <select name="student_type" oninput="this.className = ''" id="student_type" onchange="checkStudentType()">
                    <option value="new"  <?php echo (getSession('student_type') == 'new' ? 'selected' : '') ?> id="typeNew">New Student</option>
                    <option value="transfer" <?php echo (getSession('student_type') == 'transfer'  ? 'selected' : '') ?> id="typeTransfer">Transferee</option>
                </select>
            </div>
            <div class="col-lg-6 mb-3">
                <label>Grade Level <b class="text-danger">*</b></label>
                <select name="grade" oninput="this.className = ''" id="grade" onchange="checkGradeLevel()">
                    <option <?php echo getSession('grade') == '7'  ? 'selected' : '' ?> value="7" id="level7">7</option>
                    <option <?php echo getSession('grade') == '8'  ? 'selected' : '' ?>  value="8"  id="level8">8</option>
                    <option <?php echo getSession('grade') == '9'  ? 'selected' : '' ?> value="9"  id="level9">9</option>
                    <option <?php echo getSession('grade') == '10'  ? 'selected' : '' ?> value="10"  id="level10">10</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 mb-3">
                <label>Last Name <b class="text-danger">*</b></label>
                <input type="text" placeholder="Last Name" oninput="this.className = ''" name="last_name"  <?php echo "value='".htmlspecialchars(getSession('last_name'))."'"  ?> >
            </div>
            <div class="col-lg-4 mb-3">
                <label>First Name <b class="text-danger">*</b></label>
                <input type="text" placeholder="First Name" oninput="this.className = ''" name="first_name" <?php echo "value='".htmlspecialchars(getSession('first_name'))."'"  ?> >
            </div>
            <div class="col-lg-4 mb-3">
                <label>Middlle Name </label>
                <input type="text" placeholder="Middle Name" oninput="this.className = ''" name="middle_name" <?php echo "value='".htmlspecialchars(getSession('middle_name'))."'"  ?> >
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mb-3">
                <label>Gender <b class="text-danger">*</b></label>
                <select name="gender" oninput="this.className = ''">
                    <option value="Male" <?php echo getSession('gender')== 'Male'  ? 'selected' : '' ?> >Male</option>
                    <option value="Female" <?php echo getSession('gender')== 'Female'  ? 'selected' : '' ?> >Female</option>
                </select>
            </div>
            <div class="col-lg-6 mb-3">
                <label>Date of Birth <b class="text-danger">*</b></label>
                <input type="date" oninput="this.className = ''" name="birthday" <?php echo "value='".htmlspecialchars(getSession('birthday'))."'"  ?> >
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 mb-3">
                <label>Phone Number <b class="text-danger">*</b></label>
                <input type="tel" oninput="this.className = ''" placeholder="Phone (0000-000-0000)" name="phone" <?php echo "value='".htmlspecialchars(getSession('phone'))."'"  ?> >
            </div>
            <div class="col-lg-8 mb-3">
                <label>Email <b class="text-danger">*</b></label>
                <input type="email" placeholder="Email" oninput="this.className = ''" name="email" <?php echo "value='".htmlspecialchars(getSession('email'))."'"  ?> >
            </div>
        </div>
        <div class="row">
            <h5 class="fw-bold mt-3">Current Address</h5>
            <div class="col-lg-2 mb-3">
                <label class="form-label">Street # / Unit # </label>
                <input type="text" class="form-control form-control-sm"name="street_no"
                <?php echo "value='".htmlspecialchars(getSession('street_no'))."'"  ?> placeholder="Street # / Unit # ">
            </div>
            <div class="col-lg-4 mb-3">
                <label class="form-label">Street </label>
                <input type="text" class="form-control form-control-sm"name="street"
                <?php echo "value='".htmlspecialchars(getSession('street'))."'"  ?> placeholder="Street">
            </div>
            <div class="col-lg-6 mb-3">
                <label class="form-label">Subdivision/Village/Bldg</label>
                <input type="text" class="form-control form-control-sm"name="village"
                <?php echo "value='".htmlspecialchars(getSession('village'))."'"  ?> placeholder="Subdivision/Village/Bldg">
            </div>
            <div class="col-lg-4 mb-3">
                <label class="form-label">Barangay <b class="text-danger">*</b></label>
                <input type="text" class="form-control form-control-sm"name="barangay"  required
                <?php echo "value='".htmlspecialchars(getSession('barangay'))."'"  ?> placeholder="Barangay">
            </div>
            <div class="col-lg-3 mb-3">
                <label class="form-label">City/Municipality <b class="text-danger">*</b></label>
                <input type="text" class="form-control form-control-sm"name="city_municipality" required
                <?php echo "value='".htmlspecialchars(getSession('city_municipality'))."'"  ?> placeholder="City/Municipality">
            </div>
            <div class="col-lg-3 mb-3">
                <label class="form-label">Province <b class="text-danger">*</b></label>
                <input type="text" class="form-control form-control-sm"name="province"  required
                <?php echo "value='".htmlspecialchars(getSession('province'))."'"  ?> placeholder="Province">
            </div>
            <div class="col-lg-2 mb-3">
                <label class="form-label">Zip Code <b class="text-danger">*</b></label>
                <input type="text" class="form-control form-control-sm"name="zip_code"  required
                <?php echo "value='".htmlspecialchars(getSession('zip_code'))."'"  ?> placeholder="Zip Code">
            </div>
        </div>


        <p class="text-start  fs-4 fw-bold mb-4 mt-5"><span style="border-bottom: 3px solid #ffd308; padding-bottom: 10px;">Parent/Guardian Information</span></p>
        <div class="row">
            <div class="col-lg-12 mb-3">
                <label>Which Parent/Guadian will have an account? <b class="text-danger">*</b></label>
                <small class="d-block fw-bold">Only the selected Parent/Guardian is Required</small>
                <select name="guardian_that_will_have_an_account" oninput="this.className = ''">
                    <option <?php echo getSession('guardian_that_will_have_an_account') == 'mother'  ? 'selected' : '' ?> value="mother"  >Mother</option>
                    <option <?php echo getSession('guardian_that_will_have_an_account') == 'father'  ? 'selected' : '' ?> value="father"  >Father</option>
                    <option <?php echo getSession('guardian_that_will_have_an_account') == 'guardian'  ? 'selected' : '' ?> value="guardian"  >Guardian</option>
                </select>
            </div>
        </div>
        <div class="row  mt-2">
            <div class="col-lg-12">
                <h5 class="fw-bold">Mother</h5>
            </div>
            <div class="col-lg-4 mb-3">
                <label>Last Name</label>
                <input type="text" placeholder="Last Name" oninput="this.className = ''" name="mother_last_name" <?php echo "value='".htmlspecialchars(getSession('mother_last_name'))."'"  ?> >
            </div>
            <div class="col-lg-4 mb-3">
                <label>First Name</label>
                <input type="text" placeholder="First Name" oninput="this.className = ''" name="mother_first_name" <?php echo "value='".htmlspecialchars(getSession('mother_first_name'))."'"  ?> >
            </div>
            <div class="col-lg-4 mb-3">
                <label>Middlle Name</label>
                <input type="text" placeholder="Middle Name" oninput="this.className = ''" name="mother_middle_name" <?php echo "value='".htmlspecialchars(getSession('mother_middle_name'))."'"  ?> >
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 mb-3">
                <label>Phone Number</label>
                <input type="tel" oninput="this.className = ''" placeholder="Phone (0000-000-0000)" name="mother_phone" <?php echo "value='".htmlspecialchars(getSession('mother_phone'))."'"  ?> >
            </div>
            <div class="col-lg-4 mb-3">
                <label>Email</label>
                <input type="email" placeholder="Email" oninput="this.className = ''" name="mother_email" name="mother_email" <?php echo "value='".htmlspecialchars(getSession('mother_email'))."'"  ?> >
            </div>
            <div class="col-lg-4 mb-3">
                <label>Occupation</label>
                <input type="text" placeholder="Occupation" oninput="this.className = ''" name="mother_occupation" <?php echo "value='".htmlspecialchars(getSession('mother_occupation'))."'"  ?>>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-12">
                <h5 class="fw-bold">Father</h5>
            </div>
            <div class="col-lg-4 mb-3">
                <label>Last Name</label>
                <input type="text" placeholder="Last Name" oninput="this.className = ''" name="father_last_name" <?php echo "value='".htmlspecialchars(getSession('father_last_name'))."'"  ?> >
            </div>
            <div class="col-lg-4 mb-3">
                <label>First Name</label>
                <input type="text" placeholder="First Name" oninput="this.className = ''" name="father_first_name" <?php echo "value='".htmlspecialchars(getSession('father_first_name'))."'"  ?> >
            </div>
            <div class="col-lg-4 mb-3">
                <label>Middlle Name</label>
                <input type="text" placeholder="Middle Name" oninput="this.className = ''" name="father_middle_name" <?php echo "value='".htmlspecialchars(getSession('father_middle_name'))."'"  ?> >
            </div>
            <div class="col-lg-4 mb-3">
                <label>Phone Number</label>
                <input type="tel" oninput="this.className = ''" placeholder="Phone (0000-000-0000)" name="father_phone" <?php echo "value='".htmlspecialchars(getSession('father_phone'))."'"  ?> >
            </div>
            <div class="col-lg-4 mb-3">
                <label>Email</label>
                <input type="email" placeholder="Email" oninput="this.className = ''" name="father_email" name="father_email" <?php echo "value='".htmlspecialchars(getSession('father_email'))."'"  ?> >
            </div>
            <div class="col-lg-4 mb-3">
                <label>Occupation</label>
                <input type="text" placeholder="Occupation" oninput="this.className = ''" name="father_occupation" <?php echo "value='".htmlspecialchars(getSession('father_occupation'))."'"  ?>>
            </div>
        </div>
            

        <div class="row  mt-3">
            <div class="col-lg-12">
                <h5 class="fw-bold">Guardian</h5>
            </div>
            <div class="col-lg-4 mb-3">
                <label>Last Name</label>
                <input type="text" placeholder="Last Name" oninput="this.className = ''" name="guardian_last_name" <?php echo "value='".htmlspecialchars(getSession('guardian_last_name'))."'"  ?> >
            </div>
            <div class="col-lg-4 mb-3">
                <label>First Name</label>
                <input type="text" placeholder="First Name" oninput="this.className = ''" name="guardian_first_name" <?php echo "value='".htmlspecialchars(getSession('guardian_first_name'))."'"  ?> >
            </div>
            <div class="col-lg-4 mb-3">
                <label>Middlle Name</label>
                <input type="text" placeholder="Middle Name" oninput="this.className = ''" name="guardian_middle_name" <?php echo "value='".htmlspecialchars(getSession('guardian_middle_name'))."'"  ?> >
            </div>
            <div class="col-lg-4 mb-3">
                <label>Phone Number</label>
                <input type="tel" oninput="this.className = ''" placeholder="Phone (0000-000-0000)" name="guardian_phone" <?php echo "value='".htmlspecialchars(getSession('guardian_phone'))."'"  ?> >
            </div>
            <div class="col-lg-4 mb-3">
                <label>Email</label>
                <input type="email" placeholder="Email" oninput="this.className = ''" name="guardian_email" name="guardian_email" <?php echo "value='".htmlspecialchars(getSession('guardian_email'))."'"  ?> >
            </div>
            <div class="col-lg-4 mb-3">
                <label>Occupation</label>
                <input type="text" placeholder="Occupation" oninput="this.className = ''" name="guardian_occupation" <?php echo "value='".htmlspecialchars(getSession('guardian_occupation'))."'"  ?>>
            </div>
        </div>
        <div class="row  mt-3">
            <div class="col-lg-12 mb-3">
                <label class="form-label fw-bold ">Default Password for Parent and Student</label>
                <small class="d-block"><strong>Student Last Name</strong> and <strong>Student Birth Year</strong> all lowercase</small>
                <small class="d-block">Example is delacruz_2003</small>
                <input type="text" class="form-control form-control-sm" name="password" disabled value="delacruz_2003"
                <?php echo "value='".htmlspecialchars(getSession('password'))."'"  ?> >
            </div>
        </div>
    </div>
    
  

    <!-- <div class="step">
        <h1 class="text-start fs-1 fw-bold text-center py-5">Thank You!</span></h1>
        
    </div> -->


    
    <!-- start previous / next buttons -->
    <div class="form-footer d-flex">
        <button type="submit" id="nextBtn">Submit</button>
    </div>
    <!-- end previous / next buttons -->
</form>
</div>

</body>

<?php
	require_once "../includes/includes_scripts.php";
?>

<!-- <script src="../../js/regis.js"></script> -->

<script>

    function checkStudentType(){
        var student_type = document.getElementById('student_type');

        var grade = document.getElementById('grade');

        if(student_type && grade){
            if(student_type.value == 'new'){
                grade.value = "7";
            }else{
                if(grade.value == "7"){
                    grade.value = "8";
                }
            }
        }
    }
    function checkGradeLevel(){
        var student_type = document.getElementById('student_type');

        var grade = document.getElementById('grade');

        if(student_type && grade){
            if(grade.value == '7'){
                student_type.value = "new";
            }else{
                if(student_type.value == 'new'){
                    grade.value = '7'
                }
            }
        }
    }

    $(function(){
        checkStudentType();
        checkGradeLevel();
    });


    function handleAgree() {
        var checkBox = document.getElementById("checkBox");
        
        if (checkBox.checked) {
         
            var agreeDiv = document.getElementById("agreeDiv");
            var enrollmentDiv = document.getElementById("enrollmentDiv");

            agreeDiv.style.display = "none";
            enrollmentDiv.style.display = "block";

            $.ajax({
            type: "POST",
            url: "update_session.php", // Adjust the URL to your server-side script
            data: { agreed: "true" },
            success: function(response) {
                // Handle the server response if needed
                    console.log(response);
                }
            });
           
        }
    }

</script>