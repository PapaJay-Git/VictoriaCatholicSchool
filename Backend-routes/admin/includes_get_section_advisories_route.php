<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

try {
    $inactive = 'INACTIVE';
    $stmt = $conn->prepare("SELECT id, grade, name, advisory_teacher_id FROM sections WHERE name != ? order by grade ");
    $stmt->bind_param('s', $inactive);
    $stmt->execute();
    $sections = $stmt->get_result();

    $role = 'teacher';
    $stmt = $conn->prepare("SELECT id, first_name, last_name, email FROM users WHERE role = ?");
    $stmt->bind_param('s', $role);
    $stmt->execute();
    $teachers = $stmt->get_result();

} catch (Exception $e) {
    // Log the exception or handle it appropriately
    error_log("Error: " . $e->getMessage());

    // Return an error response
    echo json_encode(['error' => $e->getMessage()]);
}
?>
