<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_class_students_route.php";

$title = "Admin - Students of ".$section['name']."-".$section['grade'];

$count = 1;

require_once "../includes/header_layout.php";

function convertTxt($string = null){

  return $string == null ? '' : ucwords(strtolower($string));
}

?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h5 >STUDENTS OF <?php echo $section['name']."-".$section['grade'] ?> </h5>
                <h5 class="text-uppercase">TEACHER ADVISOR: <?php echo $section['first_name']." ".$section['last_name']." - ".$section['email'] ?></h5>
            </div>
            <div class="btn-group">
                <a href="view_classes.php?id=<?php echo $gradeID ?>" class="btn btn-sm btn-danger fw-bold">BACK</a>
            </div>
        </div>

           <div class="table-responsive">
              <table id="sectionsTable">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">LRN</th>
                    <th scope="col">Student No</th>
                  </tr>
                </thead>
                <tbody id="tbody-sections">
                <?php
                  foreach($students as $student){
                    echo "
                      <tr>
                          <td>".convertTxt($student['last_name'].', '.$student['first_name'])." </td>
                          <td>{$student['email']}</td>
                          <td>{$student['lrn']}</td>
                          <td>VCS00{$student['id']}</td>
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
<script> setActive('classes_tab'); </script>