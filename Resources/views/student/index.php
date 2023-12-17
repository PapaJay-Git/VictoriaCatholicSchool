<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfStudent.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_events_home.php";

$title = "Student - Home";

require_once "../includes/header_layout.php";

?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
       <div class="row">
            <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 mt-3">
                <div class="card">
                    <div class="card-header fw-bold">
                        EVENTS
                    </div>
                    <div class="card-body py-5"> 
                        <?php
                            $count = 0;
                            foreach($events as $event){
                                $count++;
                                echo "
                                <div class='mb-3'>
                                    <strong class='d-block'>{$count}. {$event['title']}</strong>
                                    <span class='d-block ms-3'>{$event['description']}</span>
                                </div>";
                            }

                            if($count == 0){
                                echo "<div class='text-center'>NO EVENTS</div>";
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mt-3">
                <div class="card">
                    <div class="card-header fw-bold">
                        BALANCE
                    </div>
                    <div class="card-body "> 
                        <span class="d-block ">
                            <span class="d-block">
                                <strong class="text-dark d-inline-block">Amount: </strong>
                                <span class="d-inline-block"><?php echo $auth['balance']; ?></span>
                            </span>
                            <span class="d-block">
                                <strong class="text-dark d-inline-block">Due Date: </strong>
                                <span class="d-inline-block"><?php echo $auth['date']; ?></span>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
       </div>
     </div>
</body>

<?php
	require_once "../includes/includes_scripts.php";
?>
    <script> setActive('home_tab'); </script>