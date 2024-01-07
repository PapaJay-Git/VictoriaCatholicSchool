<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_all_cashiers_route.php";

$title = "Admin - Cashiers";

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
?>
<body>
    <?php 
        include "includes/navbar.php";
     ?>
     <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
          <h5 >CASHIERS</h5>
          <a href="#" class="btn btn-sm fw-bold btn-dark" data-bs-toggle="modal" data-bs-target="#addModal">Add New Cashier</a>
        </div>

           <div class="table-responsive">
              <table id="teachersTable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
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
                          <small class="text-dark"><?php echo $row['first_name'] ?></small>
                      </td>
                      <td>
                          <small class="text-dark"><?php echo $row['last_name'] ?></small>
                      </td>
                      <td>
                          <small class="text-dark"><?php echo $row['email'] ?></small>
                      </td>
                      <td>
                          <a class="btn btn-sm btn-primary fw-bold" href="update-cashier.php?id=<?php echo $row['id'] ?>">UPDATE</a>
                          <button class="btn btn-sm btn-danger fw-bold" onclick="confirmDelete('../../../Backend-routes/admin/delete_cashier_route.php?id=<?php echo $row['id'] ?>')">DELETE</button>

                          <form class="d-inline" method="GET" action="../../../Backend-routes/admin/lock_user.php" onsubmit="submitRequest('lockUser<?php echo $row['id'] ?>', event, '<?php echo $lockQuestion; ?>')" id="lockUser<?php echo $row['id'] ?>">

                          <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                          <input type="hidden" name="url" value="cashiers.php">
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


     <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <form method="POST" action="../../../Backend-routes/admin/add_new_cashier_route.php" onsubmit="submitRequest('addCashierForm', event)" id="addCashierForm">
            <div class="modal-header">
              <h5 class="modal-title fw-bold" id="exampleModalLabel">CASHIER INFORMATION</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">First name <b class="text-danger">*</b></label>
                  <input type="text" class="form-control form-control-sm" name="first_name" required placeholder="First_name" 
                  <?php echo "value='".htmlspecialchars(getSession('first_name'))."'"  ?> >
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">Middle name <b class="text-danger">*</b></label>
                  <input type="text" class="form-control form-control-sm" name="middle_name" placeholder="Middle name"
                  <?php echo "value='".htmlspecialchars(getSession('middle_name'))."'"  ?> >
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">Last name <b class="text-danger">*</b></label>
                  <input type="text" class="form-control form-control-sm"name="last_name" required placeholder="Last name"
                  <?php echo "value='".htmlspecialchars(getSession('last_name'))."'"  ?> >
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">Default Password</label>
                    <small class="d-block"><strong>Last Name</strong> and <strong>Birth Year</strong> all lowercase</small>
                    <small class="d-block">Example is delacruz_2003</small>
                    <input type="text" class="form-control form-control-sm" name="password" disabled value="delacruz_2003"
                    <?php echo "value='".htmlspecialchars(getSession('password'))."'"  ?> >
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">Phone Number <b class="text-danger">*</b></label>
                  <input type="text" class="form-control form-control-sm" name="phone" required placeholder="Phone Number"
                  <?php echo "value='".htmlspecialchars(getSession('phone'))."'"  ?> >
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">Email Address <b class="text-danger">*</b></label>
                  <input type="text" class="form-control form-control-sm" name="email" required placeholder="Email Adress"
                  <?php echo "value='".htmlspecialchars(getSession('email'))."'"  ?> >
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">Gender <b class="text-danger">*</b></label><br>
                  <?php
                      if(getSession('gender') == 'Male'){
                        ?>
                          <input type="radio" value="Male" checked name="gender"> Male 
                          <input type="radio" value="Female" name="gender"> Female
                        <?php
                      }else{
                        ?>
                          <input type="radio" value="Male" name="gender"> Male 
                          <input type="radio" value="Female" checked name="gender"> Female
                        <?php
                      }
                  ?>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">Date of Birth <b class="text-danger">*</b></label>
                  <input type="date" class="form-control form-control-sm" name="birthday" required 
                  <?php echo "value='".htmlspecialchars(getSession('birthday'))."'"  ?> >
                </div>
              </div>
              <div class="modal-footer">
                  <button class="btn btn-sm fw-bold btn-primary" type="submit">SUBMIT</button>
                  <button type="button" class="btn btn-sm fw-bold btn-danger" data-bs-dismiss="modal">CANCEL</button>
              </div>
            </form>
          </div>
        </div>
    </div>
</body>
<?php
	require_once "../includes/includes_scripts.php";
?>
<script src="../../js/admin/teachers.js"></script>
<script> setActive('cashiers_tab'); </script>