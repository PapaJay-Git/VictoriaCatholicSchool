<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    // redirection file name
    $fileName = "Location: ../../Resources/views/admin/events.php";
    $accountID = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();

    isGETID();

    $stmt = $conn->prepare("SELECT * FROM events where id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows <= 0){
        errorSender("Invalid Event ID", $fileName);
    }

    $stmt = $conn->prepare("DELETE FROM events where id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();

    successSender('Event Deleted Successfully!', $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>