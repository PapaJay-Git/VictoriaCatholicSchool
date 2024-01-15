<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";

    // redirection file name
    $fileName = "Location: advisories.php";
    $accountID = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();

    isGETID();

    isSectionIDExists($accountID, $conn);

    $stmt = $conn->prepare("SELECT * FROM sections where id = ? and advisory_teacher_id = ?");
    $stmt->bind_param("ii", $accountID, $auth['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows <= 0){
        errorSender("Access on this section DENIED!", $fileName);
    }

    $stmt = $conn->prepare("
    SELECT sections.*, users.first_name, users.last_name
    FROM sections LEFT JOIN users ON sections.advisory_teacher_id = users.id
    WHERE sections.id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    $result = $stmt->get_result();
    $section = $result->fetch_assoc();

    $role = 'student';
    $stmt = $conn->prepare("
    SELECT users.* FROM users 
    LEFT JOIN student_sections ON users.id = student_sections.student_id
    WHERE users.role = ? AND student_sections.section_id = ?");
    $stmt->bind_param("si", $role, $accountID);
    $stmt->execute();
    $students = $stmt->get_result();



} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>