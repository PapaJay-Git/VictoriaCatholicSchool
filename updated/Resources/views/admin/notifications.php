<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_notifications_route.php";

$title = "Admin - Notifications";

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
                        if ($notification['data'] == 'Enrollee') {
                            echo '
                                <div>
                                    <a href="view_pending_students.php" class="alert alert-primary w-100 d-flex justify-content-between text-decoration-none" role="alert">
                                        <span>New online Enrollees</span> <small>' . $dateTime->format('F j, Y, g:i a') . '</small>
                                    </a>
                                </div>';
                        }
                        
                        if ($notification['data'] == 'Cashier_confirm_student') {
                            echo '
                                <div>
                                    <a href="view_registered_students.php" class="alert alert-primary w-100 d-flex justify-content-between text-decoration-none" role="alert">
                                        <span>A Cashier confirmed an online Enrollee</span> <small>' . $dateTime->format('F j, Y, g:i a') . '</small>
                                    </a>
                                </div>';
                        }
                        
                        if ($notification['data'] == 'Promissory') {
                            echo '
                                <div>
                                    <a href="promissories.php" class="alert alert-primary w-100 d-flex justify-content-between text-decoration-none" role="alert">
                                        <span>New promissory note from one of students\' guardian</span> <small>' . $dateTime->format('F j, Y, g:i a') . '</small>
                                    </a>
                                </div>';
                        }


                        if ($notification['data'] == 'Student_payment_added') {
                            echo '
                                <div>
                                    <a href="enrolled_students.php" class="alert alert-primary w-100 d-flex justify-content-between text-decoration-none" role="alert">
                                        <span>Cashier added the payment of one of the students</span> <small>' . $dateTime->format('F j, Y, g:i a') . '</small>
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