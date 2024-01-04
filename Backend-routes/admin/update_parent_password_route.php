<?php


try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    // redirection file name
    $accountID = isset($_POST['id']) ? $_POST['id'] : NULL;

    $fileName = "Location: ../../Resources/views/admin/update-parent.php?id=$accountID&password=true";
    $role = 'guardian';
    $error = false;
    $fieldName = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isPOST();

    isPOSTID();

    checkIfUserExists($accountID, $role, $conn);

    $required_fields = ['new_password', 'confirm_password'];

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

    $password = validatePassword($_POST['new_password'], $_POST['confirm_password']);
    
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");

    $stmt->bind_param("si", $password, $accountID);
    
    $stmt->execute();
    $stmt->close();
    $conn->close();

    foreach ($required_fields as $field) {
        unset($_SESSION[$field]);
    }
    successSender("Parent Password Updated Successfully", $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>