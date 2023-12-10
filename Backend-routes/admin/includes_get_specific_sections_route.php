<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    // redirection file name
    $fileName = "Location: sections.php";
    $role = NULL;
    $accountID = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();

    isGETID();

    checkIfGradeIsValid($accountID);

    $stmt = $conn->prepare("SELECT * FROM sections WHERE grade = ?");
    $stmt->bind_param("s", $accountID);
    $stmt->execute();
    $result = $stmt->get_result();

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>