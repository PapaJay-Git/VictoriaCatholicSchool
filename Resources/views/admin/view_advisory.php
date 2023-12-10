<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_section_advisories_route.php";

$title = "Admin - Section Advisories";

$count = 1;
require_once "../includes/header_layout.php";

?>
<body>
<?php 
    include "includes/navbar.php";
?>
<div class="container my-5">
    <div class="row pb-2 px-2">
        <form method="POST" action="../../../Backend-routes/admin/update_advisory_route.php?" onsubmit="submitRequest('updateAdvisory', event)" id="updateAdvisory">
        
            <div class="card shadow">
                <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold text-uppercase">Section Advisories</h4>
                    <a href="sections.php?" class="btn btn-danger btn-sm fw-bold">BACK</a>
                </div>
                    <?php
                        foreach($sections as $section){
                           echo "
                           <div class='py-3'>
                           <input type='hidden' name='section[]' value='".$section['id']."'>
                           ".$count++.". ".$section['name']."-".$section['grade']."
                           <select name='teacher[]' class='form-control form-control-sm my-2 me-3 border rounded p-1' required>
                            <option value='' disabled selected>Select an option</option>";
                                    foreach ($teachers as $teacher) {
                                    $isSelected = ((string)$teacher['id'] == $section['advisory_teacher_id']) ? 'selected' : '';
                                    echo "<option value='{$teacher['id']}' $isSelected>{$teacher['first_name']} {$teacher['last_name']} - {$teacher['school_number']}</option>";
                                    }
                            echo "
                            </select>
                           </div>";

                        }

                    ?>
                </div>
                
                <div class="d-flex justify-content-end my-5 me-3">
                    <button class="btn btn-sm fw-bold btn-primary me-1" type="submit">UPDATE</button>
                    <a href="sections.php?" class="btn btn-danger btn-sm fw-bold">CANCEL</a>
                </div>
            </div>



        </form>
    </div>
</div>
</body>
<?php
	require_once "../includes/includes_scripts.php";
?>
<script> setActive('sections_tab'); </script>