<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_events.php";
$title = "Admin - Events";


require_once "../includes/header_layout.php";

$count = 1;

function limitString($inputString, $maxLength = 25) {
    if (strlen($inputString) > $maxLength) {
        $limitedString = substr($inputString, 0, $maxLength) . "...";
    } else {
        $limitedString = $inputString;
    }

    return $limitedString;
}

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
        <div class="card">
            <div class="card-header fw-bold d-flex justify-content-between">
                <span>EVENTS</span>
                <button class="btn btn-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addModal">ADD EVENT</button>
            </div>
            <div class="card-body text-center py-5"> 
                <div class="table-responsive">
                <table id="teachersTable">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Show Until</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody id="tbody-teachers">
                    <?php
                    foreach($events as $event){
                        ?>
                        <tr>
                            <td>
                                <small class="text-dark">
                                <?php echo $count++ ?>
                                </small>
                            <td>
                                <small class="text-dark"><?php echo limitString($event['title'], 15) ?></small>
                            </td>
                            <td>
                                <small class="text-dark"><?php echo limitString($event['description'], 25) ?></small>
                            </td>
                            <td>
                                <small class="text-dark"><?php echo $event['show_until'] ?></small>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-primary fw-bold" href="update-events.php?id=<?php echo $event['id'] ?>">UPDATE</a>
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
    	

     <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <form method="POST" action="../../../Backend-routes/admin/add_new_event_route.php" onsubmit="submitRequest('addEventForm', event)" id="addEventForm">
            <div class="modal-header">
              <h5 class="modal-title fw-bold" id="exampleModalLabel">TEACHER INFORMATION</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">TITLE</label>
                  <textarea name="title" class="form-control" id="title" cols="30" rows="2" minlength="1" maxlength="100" placeholder="Title..." required><?php echo htmlspecialchars(getSession('title'));  ?></textarea>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">DESCRIPTION</label>
                  <textarea name="description" class="form-control" id="description" cols="30" rows="4" minlength="1" maxlength="255" placeholder="Description..." required><?php echo htmlspecialchars(getSession('description'));  ?></textarea>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">SHOW UNTIL</label>
                  <input type="date" class="form-control form-control-sm" name="show_until" required 
                  <?php echo "value='".htmlspecialchars(getSession('show_until'))."'"  ?> >
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
<script> setActive('events_tab'); </script>