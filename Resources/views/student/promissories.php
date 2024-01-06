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
                        <h5 >PROMISSORY NOTES FROM MY GUARDIAN</h5>
                    </div>
                    <?php 
                            $count = 1;
                            foreach($notes as $note){
                                $dateTime = new DateTime($note['created_at']);
                                $dateTime = $dateTime->format('F Y');
                                
                                echo "<label class='mt-3'>".$count++.".<b> Permission to take for Examination </b> ".($note['is_approved'] == 0 ? "<small class='fw-bold text-uppercase text-primary'>PENDING</small>" : "<small class='fw-bold text-uppercase text-success'>APPROVED</small>")."</label>
                                <div class='px-3 mt-3 mb-3'>
                                    <div class='row'>
                                        <div class='col-12'>
                                            <div class='card card-body'>
                                                <small data-bs-toggle='collapse' href='#collapseExample".$note['id']."' role='button' aria-expanded='false' aria-controls='collapseExample".$note['id']."'>
                                                    Dear Ma’am/Sir, <br><br>I am writing this letter to request your permission to grant my child ".($auth['first_name'].' '.$auth['last_name'])." to take the examination. Unfortunately, I am unable to pay within this month of $dateTime due to financial issues.<br><br>
                                                </small>

                                                <small class='collapse' id='collapseExample".$note['id']."'>
                                                    I am grateful for your time and consideration. I hope you will consider my permission request and let my child take the examination.<br><br>I shall be highly thankful for your kind support.<br><br>Sincerely,<br>".($note['first_name'].' '.$note['last_name'])."
                                                </small>
                                            </div>
                                        </div>
                                    </div>
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