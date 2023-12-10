<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    $gradeID = isset($_GET['grade']) ? $_GET['grade'] : NULL;

    // redirection file name
    $fileName = "Location: ../../Resources/views/admin/view_subjects.php?id=$gradeID";
    $accountID = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();

    isGETID();

    checkIfGradeIsValid($gradeID);

    isSubjectIDExists($accountID, $conn);

    $stmt = $conn->prepare("
    SELECT 
        subjects.id
    FROM 
        subjects
    WHERE 
        subjects.id IN (SELECT subject_id FROM classes)
    AND 
        subjects.id = ?
    ");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        errorSender("You cannot delete a subject with an existing associated data.", $fileName);
    }


    // Prepare the DELETE statement
    $stmt = $conn->prepare("DELETE FROM subjects WHERE id = ?");
    $stmt->bind_param("i", $accountID);

    // Execute the statement
    if ($stmt->execute()) {
        successSender('Delete success!', $fileName);
    } else {
        errorSender('There is a problem deleting this subject.', $fileName);
    }


} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>