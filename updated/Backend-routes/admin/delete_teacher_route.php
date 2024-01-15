<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    // redirection file name
    $fileName = "Location: ../../Resources/views/admin/teachers.php";
    $role = 'teacher';
    $accountID = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();

    isGETID();

    checkIfUserExists($accountID, $role, $conn);

    $stmt = $conn->prepare("
    SELECT 
        users.id
    FROM 
        users
    WHERE 
        (users.id IN (SELECT teacher_id FROM classes)
    OR 
        users.id IN (SELECT advisory_teacher_id FROM sections))
    AND 
        users.id = ?
    ");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        errorSender("You cannot delete a teacher with an existing associated data.", $fileName);
    }

    deleteUser($accountID, $role, $conn);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>