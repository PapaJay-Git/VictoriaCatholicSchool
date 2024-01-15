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
    SELECT users.*
    FROM users 
    LEFT JOIN checklists ON users.id = checklists.student_id
    WHERE users.role = ? 
    AND NOT EXISTS (
        SELECT 1
        FROM unregistered_students
        WHERE unregistered_students.student_id = users.id
        )
    AND EXISTS (
        SELECT 1
        FROM registered_students
        WHERE registered_students.student_id = users.id
        )
    AND (
        NOT EXISTS (
            SELECT 1
            FROM student_payment
            WHERE student_payment.student_id = users.id
        )
        OR
        (checklists.is_complete IS NULL OR checklists.is_complete <> ?)
    )
    ");
    $stmt->bind_param("si", $role, $is_complete);
    $stmt->execute();
    $students = $stmt->get_result();
    $registered_count = $students->num_rows;


    
    $stmt = $conn->prepare("
    SELECT users.*
    FROM users 
    WHERE users.role = ? 
    AND EXISTS (
        SELECT 1
        FROM unregistered_students
        WHERE unregistered_students.student_id = users.id
        )
    AND NOT EXISTS (
        SELECT 1
        FROM registered_students
        WHERE registered_students.student_id = users.id
        )
    ");
    $stmt->bind_param("s", $role);
    $stmt->execute();
    $students = $stmt->get_result();
    $unregistered_count = $students->num_rows;


    $inactive = 'INACTIVE';
    $stmt = $conn->prepare("
    SELECT users.*
    FROM users 
    LEFT JOIN student_sections ON users.id = student_sections.student_id
    LEFT JOIN sections ON student_sections.section_id = sections.id
    WHERE users.role = ?
    AND sections.name = ?
    ");
    $stmt->bind_param("ss", $role, $inactive);
    $stmt->execute();
    $students = $stmt->get_result();
    $inactive_count = $students->num_rows;

} catch (Exception $e) {
    // Log the exception or handle it appropriately
    error_log("Error: " . $e->getMessage());

    // Return an error response
    echo json_encode(['error' => $e->getMessage()]);
}
?>
