<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfStudent.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/student/includes_get_promissories.php";

$title = "Student - Promissories";

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
                        <h5 class="fw-bold">PROMISSORY NOTES FROM MY GUARDIAN</h5>
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
<?php
	require_once "../includes/includes_scripts.php";
?>
<script> setActive('promissories_tab'); </script>