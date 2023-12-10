<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

try {
    $role = 'student';


    $is_complete = 1;
    $stmt = $conn->prepare("
    SELECT users.*
    FROM users 
    LEFT JOIN checklists ON users.id = checklists.student_id
    WHERE users.role = ? AND 
    NOT EXISTS (
        SELECT 1
        FROM unregistered_students
        WHERE unregistered_students.student_id = users.id
        )
    AND EXISTS (
        SELECT 1
        FROM student_payment
        WHERE student_payment.student_id = users.id
        )
    AND checklists.is_complete = ?
    ORDER BY checklists.updated_at DESC
    ");
    $stmt->bind_param("si", $role, $is_complete);
    $stmt->execute();
    $students = $stmt->get_result();

    $enrolled_count = $students->num_rows;


    $stmt = $conn->prepare("
    SELECT
        COUNT(users.id) AS all_count,
        COUNT(unregistered_students.student_id) AS unregistered_count
    FROM users
    LEFT JOIN unregistered_students ON users.id = unregistered_students.student_id
    WHERE users.role = ? ");
    $stmt->bind_param("s", $role);
    $stmt->execute();
    $stmt->bind_result($all_count, $unregistered_count);
    $stmt->fetch();

} catch (Exception $e) {
    // Log the exception or handle it appropriately
    error_log("Error: " . $e->getMessage());

    // Return an error response
    echo json_encode(['error' => $e->getMessage()]);
}
?>
