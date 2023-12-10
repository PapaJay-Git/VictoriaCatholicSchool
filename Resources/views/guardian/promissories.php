<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfGuardian.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/guardian/includes_get_promissories.php";

$title = "Guardian - Promissories";

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
    <div class="container my-5">
        <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <h5 class="fw-bold">MY PROMISSORY NOTES</h5>
                        <a href="teacher-add.php" class="btn btn-sm fw-bold btn-dark" data-bs-toggle="modal" data-bs-target="#addModal">ADD PROMISSORY</a>
                    </div>
                        <?php 
                            $count = 1;
                            foreach($notes as $note){
                                $dateTime = new DateTime($note['created_at']);
                                
                                echo "<label class='mt-3 '>".$count++.".<b> ".$dateTime->format('F j, Y, g:i a')."</b></label>
                                <div class='px-3 mt-3 mb-3'>
                                    <small >".$note['note']."</small>
                                </div>";
                                
                            }
                            if($notes->num_rows <= 0){
                                echo "<div class='d-flex justify-content-center mt-5 fw-bold align-items-center'>EMPTY</div>";
                            }
                            
                        ?>
                    </div>
            </div>
    </div>
</body>

<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <form method="POST" action="../../../Backend-routes/guardian/add_new_promissory_route.php" onsubmit="submitRequest('addPromissoryForm', event)" id="addPromissoryForm">
            <div class="modal-header">
              <h5 class="modal-title fw-bold" id="exampleModalLabel">PROMISSORY NOTE</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                  <label class="form-label fw-bold text-uppercase">MY PROMISSORY</label>
                  <textarea name="promissory" class="form-control" cols="30" rows="3" placeholder="Promissory..."><?php echo htmlspecialchars(getSession('promissory'))?> </textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm fw-bold btn-primary" type="submit">SUBMIT</button>
                <button type="button" class="btn btn-sm fw-bold btn-secondary" data-bs-dismiss="modal">CLOSE</button>
            </div>
            </form>
          </div>
        </div>
    </div>
<?php
	require_once "../includes/includes_scripts.php";
?>
<script> setActive('promissories_tab'); </script>