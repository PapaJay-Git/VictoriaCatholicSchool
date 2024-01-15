<?php


try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfGuardian.php";

    $fileName = "Location: ../../Resources/views/guardian/update-my-password.php";
    $error = false;
    $fieldName = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isPOST();

    $required_fields = ['old_password', 'new_password', 'confirm_password'];

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

    $old_password = $_POST['old_password'];

    $passwordFromDB = $auth['password'];

    if (password_verify($passwordFromDB, $old_password)) {
        errorSender("Wrong old password.", $fileName);
    }
  
    $password = validatePassword($_POST['new_password'], $_POST['confirm_password']);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $password, $auth['id']);
    $stmt->execute();


    $stmt->close();
    $conn->close();

    foreach ($required_fields as $field) {
        unset($_SESSION[$field]);
    }
    successSender("Password Updated Successfully", $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>