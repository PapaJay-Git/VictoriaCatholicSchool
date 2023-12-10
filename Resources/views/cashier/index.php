<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfCashier.php";

$title = "Cashier - Home";

require_once "../includes/header_layout.php";

?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
        <div class="card">
            <div class="card-header fw-bold">
                CASHIER DASHBOARD
            </div>
            <div class="card-body text-center py-5"> 
                <h3 class="card-title text-uppercase bebas-font d-block">WELCOME <?php echo $auth['first_name']." ".$auth['last_name'] ?></h3>
                <h1 class="card-text bebas-font d-block mt-5">DO SOMETHING AMAZING TODAY</h1>
            </div>
        </div>
     </div>
    	
</body>

<?php
	require_once "../includes/includes_scripts.php";
?>
    <script> setActive('home_tab'); </script>