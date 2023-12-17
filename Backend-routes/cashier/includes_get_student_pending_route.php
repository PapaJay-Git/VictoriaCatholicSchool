<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfCashier.php";

    // redirection file name
    $fileName = "Location: confirm_students.php";
    $role = 'student';
    $accountID = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();

    isGETID();

    checkIfUserExists($accountID, $role, $conn);

    $stmt = $conn->prepare("
    SELECT * FROM unregistered_students where student_id = ?");
    $stmt->bind_param("s", $accountID);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows <= 0){
        errorSender("Invalid pending student", $fileName);
    }

    $unregistered_info = $result->fetch_assoc();
   
    $stmt = $conn->prepare("
    SELECT users.*, student_sections.section_id, guardian_user.first_name as guardian_first_name, guardian_user.middle_name as guardian_middle_name, guardian_user.last_name as guardian_last_name, guardian_user.email as guardian_email, guardian_user.phone as guardian_phone, guardian_user.occupation as guardian_occupation, guardian_user.guardian_type as guardian_guardian_type
    FROM users 
    LEFT JOIN student_sections ON users.id = student_sections.student_id
    LEFT JOIN guardians ON users.id = guardians.student_id
    LEFT JOIN users as guardian_user ON guardians.guardian_id = guardian_user.id
    WHERE users.id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    $resultSet = $stmt->get_result();
    $row = $resultSet->fetch_assoc();

    $stmt = $conn->prepare("SELECT * FROM sections");
    $stmt->execute();
    $sections = $stmt->get_result();


    $stmt = $conn->prepare("
    SELECT * FROM guardians where student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    $result = $stmt->get_result();
    $guadians = $result->fetch_assoc();

    $stmt = $conn->prepare("SELECT * FROM non_account_guardian WHERE student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    $parents = $stmt->get_result();
    

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>