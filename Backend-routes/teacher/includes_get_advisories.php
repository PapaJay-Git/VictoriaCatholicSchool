<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();
   
    $stmt = $conn->prepare("
    SELECT sections.*
    FROM users 
    LEFT JOIN sections 
    ON users.id = sections.advisory_teacher_id 
    WHERE sections.advisory_teacher_id = ?
    ");
    $stmt->bind_param("s", $auth['id']);
    $stmt->execute();
    
    $advisories = $stmt->get_result();

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>