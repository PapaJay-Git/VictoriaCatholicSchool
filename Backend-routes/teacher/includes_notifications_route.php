<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();
   
    $is_read = 1;
    $stmt = $conn->prepare("UPDATE notifications SET is_read = ? WHERE notifiable_id = ?");
    $stmt->bind_param("ii", $is_read, $auth['id']);
    $stmt->execute(); 

    $stmt = $conn->prepare("SELECT * FROM notifications where notifiable_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $auth['id']);
    $stmt->execute(); 
    $notifications = $stmt->get_result();
    

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>