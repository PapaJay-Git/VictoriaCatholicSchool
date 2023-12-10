<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/teacher/includes_notifications_route.php";

$title = "Teacher - Notifications";

require_once "../includes/header_layout.php";

?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
        <div class="card">
            <div class="card-header fw-bold">
                NOTIFICATIONS
            </div>
            <div class="card-body my-3"> 
                <?php
                    foreach($notifications as $notification){
                        $dateTime = new DateTime($notification['created_at']);
                        
                        if ($notification['data'] == 'Promissory') {
                            echo '
                                <div>
                                    <a href="promissories.php" class="alert alert-primary w-100 d-flex justify-content-between text-decoration-none" role="alert">
                                        <span>New promissory note from one of your students\' guardian</span> <small>' . $dateTime->format('F j, Y, g:i a') . '</small>
                                    </a>
                                </div>';
                        }
                        
                    }
                ?>
            </div>
        </div>
     </div>
    	
</body>

<?php
	require_once "../includes/includes_scripts.php";
?>
    <script> setActive('notifications_tab'); </script>