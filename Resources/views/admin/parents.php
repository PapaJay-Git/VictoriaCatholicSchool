<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_all_parents_route.php";

$title = "Admin - Parents/Guardian Accounts";

$count = 1;

require_once "../includes/header_layout.php";

function getSession($data) {
  if (isset($_SESSION[$data])) {
    $session_value = $_SESSION[$data];
    unset($_SESSION[$data]);
    return $session_value;
  }

  return null; 
}

function convertTxt($string = null){

  return $string == null ? 'None' : ucwords(strtolower($string));
}
?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
          <h5 >PARENT/GUARDIAN ACCOUNTS</h5>
        </div>

           <div class="table-responsive">
              <table id="teachersTable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Parent/Guardian Info</th>
                    <th scope="col">Student Info</th>
                    <th scope="col">Student Section</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody id="tbody-teachers">
                  <?php
                  foreach($result as $row){
                    $lockQuestion = $row['is_locked'] == 1 ? 'Are you sure you want to unlock this account?' : 'Are you sure you want to lock this account?';
                    ?>
                    <tr>
                      <td>
                        <small class="text-dark">
                          <?php echo $count++ ?>
                        </small></td>
                      <td>
                          <small class="text-dark"><?php echo convertTxt($row['guardian_type']).', '.convertTxt($row['last_name']).' '.convertTxt($row['first_name']).', '.ucfirst($row['email']) ?></small>
                      </td>
                      <td>
                        <small class="text-dark"><?php echo convertTxt($row['student_full_name']).", ".convertTxt($row['student_email']); ?></small>
                      </td>
                      <td>
                        <small class="text-dark"><?php echo $row['section_name'] == NULL ? 'None' : $row['section_name']." - ".$row['grade'];  ?></small>
                      </td>
                      <td>
                          <a class="btn btn-sm btn-primary fw-bold" href="update-parent.php?id=<?php echo $row['id'] ?>">UPDATE</a>

                          <form class="d-inline" method="GET" action="../../../Backend-routes/admin/lock_user.php" onsubmit="submitRequest('lockUser<?php echo $row['id'] ?>', event, '<?php echo $lockQuestion; ?>')" id="lockUser<?php echo $row['id'] ?>">

                            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                            <input type="hidden" name="url" value="parents.php">
                            <?php
                              if($row['is_locked'] == 1){
                                echo '<button class="btn btn-sm fw-bold btn-dark" type="submit">LOCKED</button>';
                              }else{
                                echo '<button class="btn btn-sm fw-bold btn-success" type="submit">LOCK</button>';
                              }

                            ?>  
                          </form>
                      </td>
                    </tr>
                  <?php 
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
<script src="../../js/admin/teachers.js"></script>
<script> setActive('parents_tab'); </script>