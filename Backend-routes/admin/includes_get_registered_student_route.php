<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    // redirection file name
    $fileName = "Location: view_registered_students.php";
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
    checklists.nso_certificate, checklists.previous_year_report_card, checklists.honorary_dismissal,
    guardian_user.first_name as guardian_first_name, guardian_user.middle_name as guardian_middle_name, guardian_user.last_name as guardian_last_name, guardian_user.email as guardian_email, guardian_user.phone as guardian_phone,guardian_user.occupation as guardian_occupation, guardian_user.guardian_type as guardian_guardian_type
    FROM users 
    LEFT JOIN student_sections
    ON users.id = student_sections.student_id
    LEFT JOIN registered_students ON users.id = registered_students.student_id
    LEFT JOIN checklists ON users.id = checklists.student_id
    LEFT JOIN guardians ON users.id = guardians.student_id
    LEFT JOIN users as guardian_user ON guardians.guardian_id = guardian_user.id
    WHERE users.id = ? ");
    $stmt->bind_param("s", $accountID);
    $stmt->execute();

    $result = $stmt->get_result();

    $row = $result->fetch_assoc();


    $stmt = $conn->prepare("SELECT * FROM sections");
    $stmt->execute();
    $sections = $stmt->get_result();
    

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>