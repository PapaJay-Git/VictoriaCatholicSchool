<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    $gradeID = isset($_GET['grade']) ? $_GET['grade'] : NULL;
    // redirection file name
    $fileName = "Location: view_sections.php?id=$gradeID";
    $accountID = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();

    isGETID();

    checkIfGradeIsValid($gradeID);

    isSectionIDExists($accountID, $conn);

    $stmt = $conn->prepare("SELECT name FROM sections where id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if($row['name'] == 'INACTIVE'){
        errorSender("You cannot update the INACTIVE section.", $fileName);
    }

    $stmt = $conn->prepare("SELECT * FROM sections WHERE id = ?");
    $stmt->bind_param("s", $accountID);
    $stmt->execute();

    $resultSet = $stmt->get_result();

    $row = $resultSet->fetch_assoc();

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>