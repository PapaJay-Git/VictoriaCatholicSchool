<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    // redirection file name
    $fileName = "Location: ../../Resources/views/admin/view_registered_students.php";
    $role = 'student';
    $accountID = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();

    isGETID();

    checkIfUserExists($accountID, $role, $conn);

    // checker
    $is_complete = 1;
    $stmt = $conn->prepare("SELECT * FROM checklists WHERE student_id = ? AND is_complete = ?");
    $stmt->bind_param("ii", $accountID, $is_complete);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        errorSender('Cannot delete a student who completed his requirements', $fileName);
    }

    $stmt = $conn->prepare("SELECT * FROM student_payment WHERE student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        errorSender('Cannot delete a student who already has a payment.', $fileName);
    }
    // checker

    $stmt = $conn->prepare("SELECT guardian_id FROM guardians WHERE student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $guardian = $result->fetch_assoc();
        $guardian_id = $guardian['guardian_id'];

        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $guardian_id);
        $stmt->execute();
    }

    $stmt = $conn->prepare("DELETE FROM guardians WHERE student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM unregistered_students WHERE student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM checklists WHERE student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM registered_students WHERE student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM student_sections WHERE student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM notifications WHERE notifiable_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM student_balance WHERE student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM promissory WHERE student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    
    deleteUser($accountID, $role, $conn);



} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>