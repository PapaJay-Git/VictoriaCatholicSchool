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
                        <h5>MY PROMISSORY NOTES</h5>
                        <a href="teacher-add.php" class="btn btn-sm fw-bold btn-dark" data-bs-toggle="modal" data-bs-target="#addModal">ADD PROMISSORY</a>
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
                                                    Dear Ma’am/Sir, <br><br>I am writing this letter to request your permission to grant my child ".($student['first_name'].' '.$student['last_name'])." to take the examination. Unfortunately, I am unable to pay within this month of $dateTime due to financial issues.<br><br>
                                                </small>

                                                <small class='collapse' id='collapseExample".$note['id']."'>
                                                    I am grateful for your time and consideration. I hope you will consider my permission request and let my child take the examination.<br><br>I shall be highly thankful for your kind support.<br><br>Sincerely,<br>".($auth['first_name'].' '.$auth['last_name'])."
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
                  <label class="form-label text-uppercase" for="promissory">MY PROMISSORY</label>
                  <select name="promissory" id="promissory" class="form-control mt-2" required onchange="checkpromissory()">
                    <option value="payment">Permission to take for Examination.</option>
                  </select>

                  <textarea class="form-control mt-3" disabled cols="30" rows="15" id="textArea"></textarea>
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

<script>

    function checkpromissory(){
        var promissory = document.getElementById('promissory');
        var selectedPromissory = promissory.value;
        var textArea = document.getElementById('textArea');

        if(selectedPromissory && textArea)
        {
            var studentName = <?php echo "'".$student['first_name']." ".$student['last_name']."'" ?>;
            var parentName = <?php echo "'".$auth['first_name']." ".$auth['last_name']."'" ?>;

            let currentDate = new Date();
            let currentMonth = new Date(currentDate.getYear(), currentDate.getMonth(), 1).toLocaleString('en-US', { month: 'long'});

            if(selectedPromissory == 'sick')
            {

            }else if(selectedPromissory == 'payment')
            {

                textArea.innerHTML = `Dear Ma’am/Sir, \n\nI am writing this letter to request your permission to grant my child `+studentName+` to take the examination. Unfortunately, I am unable to pay within this month of `+currentMonth+` due to financial issues.\n\nI am grateful for your time and consideration. I hope you will consider my permission request and let my child take the examination.\n\nI shall be highly thankful for your kind support.\n\nSincerely,\n`+parentName;

            }
        }
    }

    $(function(){
        checkpromissory();
    });
</script>