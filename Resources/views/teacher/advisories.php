<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/teacher/includes_get_advisories.php";

$title = "Teacher - Advisories";

require_once "../includes/header_layout.php";

?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold">SECTION ADVISORIES</h2>
        </div>
        <div class="table-responsive">
            <table id="tablesID">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">SECTION NAME</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody id="tbody-student">
                    <?php
                        foreach($advisories as $index => $advisory){
                            echo "
                            <tr>
                                <td><small class='text-dark'>".($index+1)."</small></td>
                                <td><small class='text-dark'>".$advisory['name']."</small></td>
                                <td>
                                    <a href='advisory_students.php?id=".$advisory['id']."' class='btn btn-primary btn-sm fw-bold'>STUDENTS</a>
                                    <a href='advisory_schedules.php?id=".$advisory['id']."' class='btn btn-primary btn-sm fw-bold'>SCHEDULES</a>
                                    <a href='section_grades.php?id=".$advisory['id']."' class='btn btn-primary btn-sm fw-bold'>GRADES</a>
                                </td>
                            </tr>
                            
                            ";
                        }
                    ?>
                </tbody>
            </table>
        </div>
     </div>


</body>

<?php
	require_once "../includes/includes_scripts.php";
?>
<script src="../../js/teacher/tables.js"></script>
<script> setActive('advisories_tab'); </script>