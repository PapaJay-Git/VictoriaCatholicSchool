<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfStudent.php";

    $accountID = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();

    $stmt = $conn->prepare("SELECT * FROM student_sections where student_id = ? ");
    $stmt->bind_param("i", $auth['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $section = $result->fetch_assoc();

    if($result->num_rows <= 0){
       echo "You currently have no section. You can view this once you have one.";
       exit();
    }

    $stmt = $conn->prepare("SELECT promissory.*, users.first_name, users.last_name, users.guardian_type 
    FROM promissory
    LEFT JOIN guardians ON promissory.student_id = guardians.student_id
    LEFT JOIN users ON guardians.guardian_id = users.id
    where promissory.student_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $auth['id']);
    $stmt->execute();
    $notes = $stmt->get_result();


} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>