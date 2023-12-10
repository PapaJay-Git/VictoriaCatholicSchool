<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/teacher/includes_get_promissories.php";
$title = "Teacher - Promissories";


require_once "../includes/header_layout.php";

$count = 1;

function limitString($inputString, $maxLength = 15) {
    if (strlen($inputString) > $maxLength) {
        $limitedString = substr($inputString, 0, $maxLength) . "...";
    } else {
        $limitedString = $inputString;
    }

    return $limitedString;
}

?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
        <div class="card">
            <div class="card-header fw-bold">
                STUDENT GUARDIAN PROMISSORIES
            </div>
            <div class="card-body text-center py-5"> 
                <div class="table-responsive">
                <table id="teachersTable">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">School Number</th>
                        <th scope="col">Section</th>
                        <th scope="col">Promissory</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody id="tbody-teachers">
                    <?php
                    foreach($promissories as $promissory){
                        ?>
                        <tr>
                        <td>
                            <small class="text-dark">
                            <?php echo $count++ ?>
                            </small></td>
                        <td>
                            <small class="text-dark"><?php echo $promissory['first_name']." ".$promissory['last_name'] ?></small>
                        </td>
                        <td>
                            <small class="text-dark"><?php echo $promissory['username'] ?></small>
                        </td>
                        <td>
                            <small class="text-dark"><?php echo $promissory['email'] ?></small>
                        </td>
                        <td>
                            <small class="text-dark"><?php echo $promissory['school_number'] ?></small>
                        </td>
                        <td>
                            <small class="text-dark"><?php echo $promissory['section_name']."-".$promissory['section_grade'] ?></small>
                        </td>
                        <td>
                            <small class="text-dark"><?php echo limitString($promissory['note']) ?></small>
                        </td>
                        <td>
                            <small class="text-dark"><?php echo $promissory['created_at'] ?></small>
                        </td>
                        <td>
                            <a class="btn btn-sm btn-primary fw-bold" href="promisorry.php?id=<?php echo $promissory['note_id'] ?>">FULL INFO</a>
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
    	


</body>

<?php
	require_once "../includes/includes_scripts.php";
?>
<script src="../../js/admin/teachers.js"></script>
<script> setActive('promissories_tab'); </script>