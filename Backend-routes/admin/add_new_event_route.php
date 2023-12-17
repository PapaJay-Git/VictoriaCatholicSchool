<?php

try {
    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    // redirection file name
    $fileName = "Location: ../../Resources/views/admin/events.php?";

    $error = false;
    $fieldName = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isPOST();

    // required array
    $required_fields = ['title', 'description', 'show_until'];

    // required checker
    foreach ($required_fields as $field) {
        $_SESSION[$field] = sanitize_input($_POST[$field]);
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

    $stmt = $conn->prepare("INSERT INTO events (title, description, show_until) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $show_until);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    foreach ($required_fields as $field) {
        unset($_SESSION[$field]);
    }
    successSender("Event Added Successfully", $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>