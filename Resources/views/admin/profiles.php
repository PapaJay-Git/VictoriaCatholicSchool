<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

$title = "Admin - Profile";

require_once "../includes/header_layout.php";

?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>

    <div class="container mt-5">
        <div class="row justify-content-center bg-white rounded shadow pb-5">


            <div class="col-12 d-flex justify-content-between align-items-center">
                <h3 class="bebas-font mt-3 border-bottom-navy">MY DETAILS</h3>
                <a href="update-my-password.php" class="btn btn-dark btn-sm fw-bold py-2 rounded">CHANGE PASSWORD</a>
            </div>



            <div class="col-lg-5 d-flex justify-content-center mt-4">
                <img src="../../images/profile.svg" class="shadow profile-design" >
            </div>


            <div class="col-lg-7 mt-4">
                <span class="bg-primary d-block d-lg-inline-block p-3 rounded">
                    <h1 class="bebas-font text-white text-uppercase"><?php echo $auth['first_name']." ".$auth['middle_name']." ".$auth['last_name'] ?> </h1>
                    <small class="text-white fw-bold"> ADMIN </small>
                </span>
                <span class="mt-1 p-2 d-block">
                    <span class="d-block">
                        <h4 class="bebas-font text-dark d-inline-block">Email:</h4>
                        <h5 class="bebas-font d-inline-block text-uppercase"><?php echo $auth['email'] ?></h5>
                    </span>
                    <span class="d-block">
                        <h4 class="bebas-font text-dark d-inline-block">Phone:</h4>
                        <h5 class="bebas-font d-inline-block"><?php echo $auth['phone'] ?></h5>
                    </span>
                </span>
            </div>
            <div class="col-md-12 mt-5 ">
                <span class="d-block px-2">
                    <h3 class="bebas-font text-dark border-bottom-navy">OTHER INFO</h3>
                    <span class="d-block pt-3">
                        <h4 class="bebas-font text-dark d-inline-block">Gender:</h4>
                        <h5 class="bebas-font d-inline-block text-uppercase"><?php echo $auth['gender']; ?></h5>
                    </span>
                    <span class="d-block">
                        <h4 class="bebas-font text-dark d-inline-block">Birthday:</h4>
                        <h5 class="bebas-font d-inline-block"><?php echo $auth['birthday']; ?></h5>
                    </span>
                </span>

            </div>


        </div>
    </div>
</body>

<?php
	require_once "../includes/includes_scripts.php";
?>
    <script> setActive('profiles_tab'); </script>