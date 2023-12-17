<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_events_home.php";

$title = "Teacher - Home";

require_once "../includes/header_layout.php";

?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
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
</body>

<?php
	require_once "../includes/includes_scripts.php";
?>
    <script> setActive('home_tab'); </script>