<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    // redirection file name
    $fileName = "Location: enrolled_students.php";
    $role = 'student';
    $accountID = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();

    isGETID();

    checkIfUserExists($accountID, $role, $conn);

   
    $stmt = $conn->prepare("
    SELECT users.*, student_sections.section_id , registered_students.student_type,
    checklists.form_138, checklists.good_moral, checklists.baptisaml_of_birth,
    checklists.nso_certificate, checklists.honorary_dismissal
    FROM users 
    LEFT JOIN student_sections
    ON users.id = student_sections.student_id
    LEFT JOIN registered_students ON users.id = registered_students.student_id
    LEFT JOIN checklists ON users.id = checklists.student_id
    WHERE users.id = ?");
    $stmt->bind_param("s", $accountID);
    $stmt->execute();
    
    $resultSet = $stmt->get_result();

    $row = $resultSet->fetch_assoc();


    $stmt = $conn->prepare("SELECT * FROM sections");
    $stmt->execute();
    $sections = $stmt->get_result();
    

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>