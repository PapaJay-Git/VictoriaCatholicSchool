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
                <span>GUARDIAN PROMISSORY FOR STUDENT</span>
                <a href="promissories.php" class="btn btn-sm btn-danger fw-bold">BACK</a>
            </div>
            <div class="card-body">
                <h5 class="text-uppercase title-promissory"><?php echo $promissory['first_name']." ".$promissory['last_name']; ?></h5>
                <small class="d-block"><?php echo $promissory['section_name']."-".$promissory['section_grade'] ?></small>
                <textarea class="form-control form-control-sm mt-5" disabled rows="10"><?php echo $promissory['note'] ?></textarea>
            </div>
        </div>
     </div>
    	


</body>

<?php
	require_once "../includes/includes_scripts.php";
?>
<script src="../../js/admin/teachers.js"></script>
<script> setActive('promissories_tab'); </script>