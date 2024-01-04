<?php


try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    $role = 'guardian';
    $stmt = $conn->prepare("SELECT parents.*, CONCAT(student.first_name, ' ',student.middle_name, ' ', student.last_name) as student_full_name, student.email as student_email 
    FROM users as parents 
    LEFT JOIN guardians ON parents.id = guardians.guardian_id 
    LEFT JOIN users as student ON guardians.student_id = student.id
    WHERE parents.role = ? ORDER BY parents.updated_at DESC");
    $stmt->bind_param("s", $role);
    $stmt->execute();
    $result = $stmt->get_result();

} catch (Exception $e) {
    // Log the exception or handle it appropriately
    error_log("Error: " . $e->getMessage());

    // Return an error response
    echo json_encode(['error' => $e->getMessage()]);
}
?>
