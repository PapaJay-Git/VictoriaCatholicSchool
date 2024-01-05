<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfCashier.php";

    // redirection file name
    $fileName = "Location: registered_students.php";
    $role = 'student';
    $accountID = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();

    isGETID();

    checkIfUserExists($accountID, $role, $conn);

    $is_complete = 1;
    $stmt = $conn->prepare("
    SELECT users.*, sections.name as section_name, sections.grade as section_grade, student_payment.value, student_payment.payment_type
    FROM users 
    LEFT JOIN student_sections ON users.id = student_sections.student_id
    LEFT JOIN sections ON student_sections.section_id = sections.id
    LEFT JOIN student_payment ON users.id = student_payment.student_id
    LEFT JOIN checklists ON users.id = checklists.student_id
    WHERE users.id = ? AND
    NOT EXISTS (
        SELECT 1
        FROM unregistered_students
        WHERE unregistered_students.student_id = users.id
        )
    AND checklists.is_complete = ?
    ");
    $stmt->bind_param("ii", $accountID, $is_complete);
    $stmt->execute(); 
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    

    if($result->num_rows == 0){
        errorSender('Invalid ID', $fileName);
    }

    $stmt = $conn->prepare("SELECT date FROM paidMonths WHERE student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute(); 
    $paidMonthsResult = $stmt->get_result();
    $paidMonths = $paidMonthsResult->fetch_all(MYSQLI_ASSOC);
    
} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>