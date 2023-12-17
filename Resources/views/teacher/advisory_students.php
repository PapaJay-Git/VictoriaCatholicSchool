<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/teacher/includes_get_class_students_route.php";

$title = "Teacher - Students of ".$section['name']."-".$section['grade'];

$count = 1;

require_once "../includes/header_layout.php";

?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold">STUDENTS OF <?php echo $section['name']."-".$section['grade'] ?> </h2>
            </div>
            <div class="btn-group">
                <a href="advisories.php" class="btn btn-sm btn-danger fw-bold">BACK</a>
            </div>
        </div>

           <div class="table-responsive">
              <table id="sectionsTable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">School ID</th>
                  </tr>
                </thead>
                <tbody id="tbody-sections">
                <?php
                  foreach($students as $student){
                    echo "
                      <tr>
                          <td>".$count++."</td>
                          <td>{$student['first_name']}</td>
                          <td>{$student['last_name']}</td>
                          <td>{$student['email']}</td>
                          <td>{$student['school_number']}</td>
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
<script src="../../js/admin/sections.js"></script>
<script> setActive('advisories_tab'); </script>