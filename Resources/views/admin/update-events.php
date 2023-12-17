<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_event_route.php";

$title = "Admin - Update Event";

require_once "../includes/header_layout.php";

function getSession($data) {
  global $row;

  if (isset($_SESSION[$data])) {
    $session_value = $_SESSION[$data];
    unset($_SESSION[$data]);
    return $session_value;
  }

    return $row[$data];
}
?>
<body>
<?php 
    include "includes/navbar.php";
?>
<div class="container my-5">
    <div class="pb-2 px-2">
        <h5 class="mb-5 fw-bold">UPDATE EVENT</h5>
        <form method="POST" action="../../../Backend-routes/admin/update_event_route.php?" onsubmit="submitRequest('updateEvent', event)" id="updateEvent">
            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
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
            <div class="d-flex justify-content-end my-5">
                <button class="btn btn-sm fw-bold btn-primary me-1" type="submit">UPDATE</button>
                <a href="events.php" class="btn btn-danger btn-sm fw-bold">BACK</a>
            </div>

        </form>
    </div>
</div>
</body>
<?php
	require_once "../includes/includes_scripts.php";
?>
<script> setActive('events_tab'); </script>