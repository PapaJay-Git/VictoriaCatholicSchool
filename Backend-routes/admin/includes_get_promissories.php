<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();
   
    $stmt = $conn->prepare("
    select users.id, users.first_name, users.last_name, users.email,
    sections.name as section_name, sections.grade as section_grade, promissory.note, promissory.id as note_id,
    promissory.created_at
    FROM promissory 
    LEFT JOIN student_sections ON promissory.student_id = student_sections.student_id
    LEFT JOIN sections ON student_sections.section_id = sections.id
    LEFT JOIN users ON promissory.student_id = users.id
    order by promissory.created_at desc
    ");
    $stmt->execute();
    
    $promissories = $stmt->get_result();

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>