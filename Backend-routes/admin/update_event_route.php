<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    $eventID = isset($_POST['id']) ? $_POST['id'] : NULL;
    // redirection file name
    $fileName = "Location: ../../Resources/views/admin/update-events.php?id=$eventID";
    $accountID = NULL;
    $error = false;
    $fieldName = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isPOST();

    isPOSTID();

    $stmt = $conn->prepare("SELECT * FROM events where id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows <= 0){
        errorSender("Invalid Event ID", $fileName);
    }

    $required_fields = ['title', 'description', 'show_until'];

    // required checker
    foreach ($required_fields as $field) {
        $_SESSION[$field] = strtoupper(sanitize_input($_POST[$field]));
        if (empty($_POST[$field])) {
            $error = true;
            $fieldName = $field;
        }
    }

    if($error){
        errorSender("$fieldName is required", $fileName);
    }

    
    $title = sanitize_input($_POST['title']);
    $description = sanitize_input($_POST['description']);
    $show_until = validateDate($_POST['show_until']);

   if(strlen($title) > 150){
        errorSender("Title should only be below 150 characters!", $fileName);
   }

   if(strlen($title) > 500){
        errorSender("Description should only be below 255 characters", $fileName);
   }

    $stmt = $conn->prepare("UPDATE events set title = ?, description = ?, show_until = ? where id = ?");
    $stmt->bind_param("sssi", $title, $description, $show_until, $accountID);
    $stmt->execute();

    foreach ($required_fields as $field) {
        unset($_SESSION[$field]);
    }
    successSender('Event updated successfully', $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>