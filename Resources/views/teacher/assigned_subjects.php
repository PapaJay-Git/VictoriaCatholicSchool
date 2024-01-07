<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/teacher/includes_get_assigned_subjects.php";

$title = "Teacher - Assigned Subjects";

require_once "../includes/header_layout.php";

$count = 1;

$days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];

$schedules = [
    '7:00 AM', '7:30 AM', '8:00 AM', '8:30 AM',
    '9:00 AM', '9:30 AM', '10:00 AM', '10:30 AM',
    '11:00 AM', '11:30 AM', '12:00 PM', '12:30 PM',
    '1:00 PM', '1:30 PM', '2:00 PM', '2:30 PM',
    '3:00 PM', '3:30 PM', '4:00 PM', '4:30 PM',
    '5:00 PM', '5:30 PM', '6:00 PM'
];

?>
<body>
<?php 
    include "includes/navbar.php";
?>
<div class="container my-5">
    <div class="row pb-2 px-2">
        
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <h5 >ASSIGNED SUBJECTS</h5>
                        <a href="advisories.php" class="btn btn-danger btn-sm fw-bold">BACK</a>
                    </div>
                    <div class="table-responsive">
                        <table id="teachersTable">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">SUBJECT NAME</th>
                                <th scope="col">SECTION</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody id="tbody-teachers">
                            <?php
                            foreach($classes as $class){
                                ?>
                                <tr>
                                <td>
                                    <small class="text-dark">
                                    <?php echo $count++ ?>
                                    </small></td>
                                <td>
                                    <small class="text-dark"><?php echo $class['subject_name'] ?></small>
                                </td>
                                <td>
                                    <small class="text-dark"><?php echo $class['section_name']."-".$class['section_grade'] ?></small>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-primary fw-bold" href="students.php?<?php echo "subject_id=".$class['subject_id']."&section_id=".$class['section_id'] ?>">STUDENTS</a>

                                  
                                </td>
                                </tr>
                            <?php 
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
        
                </div>
            </div>
    </div>
</div>

</body>

<?php
	require_once "../includes/includes_scripts.php";
?>

<script src="../../js/admin/teachers.js"></script>
<script> setActive('assigned_subjects_tab'); </script>