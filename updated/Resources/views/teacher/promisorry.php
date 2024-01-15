<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/teacher/get_certain_promissory.php";
$title = "Teacher - Student Promissory";


require_once "../includes/header_layout.php";

$count = 1;

?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center fw-bold">
                <span class="text-uppercase">From <?php echo $promissory['parent_info']?></span>
                <a href="promissories.php" class="btn btn-sm btn-danger fw-bold">BACK</a>
            </div>
            <div class="card-body">
                <h5 class="text-uppercase title-promissory">STUDENT: <?php echo $promissory['first_name']." ".$promissory['last_name']; ?></h5>
                <small class="d-block"><?php echo $promissory['section_name']."-".$promissory['section_grade'] ?></small>
                <?php
                    $dateTime = new DateTime($promissory['created_at']);
                    $dateTime = $dateTime->format('F Y');

                    echo "<label class='mt-5'>1. <b> Permission to take for Examination </b></label>
                    <div class='px-3 mt-3 mb-3'>
                        <div class='row'>
                            <div class='col-12'>
                                <div class='card card-body'>
                                    <small >
                                        Dear Ma’am/Sir, <br><br>I am writing this letter to request your permission to grant my child ".($promissory['first_name'].' '.$promissory['last_name'])." to take the examination. Unfortunately, I am unable to pay within this month of $dateTime due to financial issues.<br><br>I am grateful for your time and consideration. I hope you will consider my permission request and let my child take the examination.<br><br>I shall be highly thankful for your kind support.<br><br>Sincerely,<br><br>".(ucwords($promissory['parent_info']))."
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>";

                    if($promissory['is_approved'] == 0){ ?>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-sm fw-bold btn-primary" disabled>PENDING</button> 
                        </div>
                    <?php }else{ ?>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-sm fw-bold btn-success" disabled>APPROVED</button> 
                        </div> 
                    <?php }

                ?>
                
            </div>
        </div>
     </div>
    	


</body>

<?php
	require_once "../includes/includes_scripts.php";
?>
<script src="../../js/admin/teachers.js"></script>
<script> setActive('promissories_tab'); </script>