<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    // redirection file name
    $fileName = "Location: ../../Resources/views/admin/index.php";
    $accountID = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();

    isGETID();

    $required_fields = ['url'];

    // required checker
    foreach ($required_fields as $field) {
        $_SESSION[$field] = sanitize_input($_GET[$field]);
        if (empty($_GET[$field])) {
            $error = true;
            $fieldName = $field;
        }
    }

    if($error){
        echo "Back URL is missing";
        exit();
    }

    $url  = $_GET['url'];

    $fileName = "Location: ../../Resources/views/admin/$url";

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if($result->num_rows == 0 || $user['role'] == 'admin'){
        errorSender("Invalid User ID", $fileName);
    }

    $lockStatusResult = $user['is_locked'] == 1 ? 'unlocked' : 'locked';
    
    $is_locked = $user['is_locked'] == 1 ? 0 : 1;
    $login_attempts = 0;
    $stmt = $conn->prepare("UPDATE users SET is_locked = ?, login_attempts = ? WHERE id = ?");
    $stmt->bind_param("iii", $is_locked, $login_attempts, $accountID);
    $stmt->execute();

    successSender("User $lockStatusResult successfully", $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>