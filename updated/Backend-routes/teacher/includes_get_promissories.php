<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();
   
    $is_approved = 1;
    $stmt = $conn->prepare("
    select users.id, users.first_name, users.last_name, users.email,
    sections.name as section_name, sections.grade as section_grade, promissory.note, promissory.id as note_id,
    promissory.created_at, CONCAT(parents.guardian_type, ', ', parents.first_name, ' ', parents.last_name) as parent_info, promissory.is_approved
    FROM promissory 
    LEFT JOIN student_sections ON promissory.student_id = student_sections.student_id
    LEFT JOIN sections ON student_sections.section_id = sections.id
    LEFT JOIN users ON promissory.student_id = users.id
    LEFT JOIN guardians ON users.id = guardians.student_id
    LEFT JOIN users as parents ON guardians.guardian_id = parents.id
    WHERE (sections.id IN (select section_id from classes WHERE teacher_id = ? group by section_id)
    OR sections.id IN (select id from sections WHERE advisory_teacher_id = ?)) AND promissory.is_approved = ?
    order by promissory.updated_at desc
    ");
    $stmt->bind_param("iii", $auth['id'], $auth['id'], $is_approved);
    $stmt->execute();
    
    $promissories = $stmt->get_result();

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>