<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    // redirection file name
    $fileName = "Location: view_inactive_students.php";
    $role = 'student';
    $accountID = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();

    isGETID();

    checkIfUserExists($accountID, $role, $conn);

   
    $stmt = $conn->prepare("
    SELECT users.*, student_sections.section_id , registered_students.student_type
    FROM users 
    LEFT JOIN student_sections ON users.id = student_sections.student_id
    LEFT JOIN registered_students ON users.id = registered_students.student_id
    WHERE users.id = ?");
    $stmt->bind_param("s", $accountID);
    $stmt->execute();

    $result = $stmt->get_result();

    $row = $result->fetch_assoc();


    $stmt = $conn->prepare("SELECT * FROM sections");
    $stmt->execute();
    $sections = $stmt->get_result();
    

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>