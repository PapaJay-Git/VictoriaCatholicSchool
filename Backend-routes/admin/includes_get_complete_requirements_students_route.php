<?php


try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    $role = 'student';
    $is_complete = 1;
    $stmt = $conn->prepare("
    SELECT users.*, sections.name as section_name, sections.grade as section_grade, payment_type
    FROM users 
    LEFT JOIN student_sections ON users.id = student_sections.student_id
    LEFT JOIN sections ON student_sections.section_id = sections.id
    LEFT JOIN student_payment ON users.id = student_payment.student_id
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
    ORDER BY users.updated_at DESC
    ");
    $stmt->bind_param("si", $role, $is_complete);
    $stmt->execute();
    $students = $stmt->get_result();

    $stmt = $conn->prepare("SELECT * FROM sections");
    $stmt->execute();
    $sections = $stmt->get_result();

} catch (Exception $e) {
    // Log the exception or handle it appropriately
    error_log("Error: " . $e->getMessage());

    // Return an error response
    echo json_encode(['error' => $e->getMessage()]);
}
?>
