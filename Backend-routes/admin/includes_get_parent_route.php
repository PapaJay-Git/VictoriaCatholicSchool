<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    // redirection file name
    $fileName = "Location: parents.php";
    $role = 'guardian';
    $accountID = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();

    isGETID();

    checkIfUserExists($accountID, $role, $conn);

   
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("s", $accountID);
    $stmt->execute();
    
    $resultSet = $stmt->get_result();

    $row = $resultSet->fetch_assoc();
    

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>