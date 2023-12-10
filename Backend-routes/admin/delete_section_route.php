<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    $gradeID = isset($_GET['grade']) ? $_GET['grade'] : NULL;

    // redirection file name
    $fileName = "Location: ../../Resources/views/admin/view_sections.php?id=$gradeID";
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
        errorSender("You cannot delete the INACTIVE section.", $fileName);
    }

    $stmt = $conn->prepare("
    SELECT 
        sections.id, advisory_teacher_id
    FROM 
        sections
    WHERE 
        (sections.id IN (SELECT section_id FROM classes)
    OR 
        sections.id IN (SELECT section_id FROM student_sections))
    AND 
        sections.id = ?
    ");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    if($result->num_rows > 0 || $row['advisory_teacher_id'] != 0){
        errorSender("You cannot delete a section with an existing associated data.", $fileName);
    }

    // Prepare the DELETE statement
    $stmt = $conn->prepare("DELETE FROM sections WHERE id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    successSender('Delete success!', $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>