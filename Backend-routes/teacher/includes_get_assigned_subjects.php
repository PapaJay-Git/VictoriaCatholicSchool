<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();
   
    $stmt = $conn->prepare("SELECT classes.*, sections.name as section_name, sections.grade as section_grade, subjects.name as subject_name
    FROM classes 
    LEFT JOIN sections ON classes.section_id = sections.id
    LEFT JOIN subjects ON classes.subject_id = subjects.id
    WHERE teacher_id = ? 
    ORDER BY section_grade ASC
    ");
    $stmt->bind_param("s", $auth['id']);
    $stmt->execute();
    
    $classes = $stmt->get_result();

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>