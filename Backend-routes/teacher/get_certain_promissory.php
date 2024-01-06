<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";

    // redirection file name
    $fileName = "Location: promissories.php";
    $accountID = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();

    isGETID();

    $stmt = $conn->prepare("
    select users.first_name, users.last_name, users.email,
    sections.name as section_name, sections.grade as section_grade, promissory.note, promissory.id as note_id,
    promissory.created_at, CONCAT(parents.guardian_type, ', ', parents.first_name, ' ', parents.last_name) as parent_info, promissory.id, promissory.is_approved
    FROM promissory 
    LEFT JOIN student_sections ON promissory.student_id = student_sections.student_id
    LEFT JOIN sections ON student_sections.section_id = sections.id
    LEFT JOIN users ON promissory.student_id = users.id
    LEFT JOIN guardians ON users.id = guardians.student_id
    LEFT JOIN users as parents ON guardians.guardian_id = parents.id
    WHERE promissory.id = ?
    ");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    
    $result = $stmt->get_result();

    if($result->num_rows <= 0){
        errorSender('Invalid promissory ID', $fileName);
    }

    $promissory = $result->fetch_assoc();

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>