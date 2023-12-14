<?php


try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    $role = 'student';
    $is_complete = 1;
    $inactive = 'INACTIVE';


    $stmt = $conn->prepare("
    SELECT users.*, sections.name as section_name, sections.grade as section_grade
    FROM users 
    LEFT JOIN student_sections ON users.id = student_sections.student_id
    LEFT JOIN sections ON student_sections.section_id = sections.id
    WHERE users.role = ?
    AND sections.name = ?
    ");
    $stmt->bind_param("ss", $role, $inactive);
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
