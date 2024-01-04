<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";

    // redirection file name
    $fileName = "Location: assigned_subjects.php";
    $error = false;
    $fieldName = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();

    $required_fields = ['section_id', 'subject_id'];

    // required checker
    foreach ($required_fields as $field) {
        $_SESSION[$field] = sanitize_input($_GET[$field]);
        if (empty($_GET[$field])) {
            $error = true;
            $fieldName = $field;
        }
    }
    
    if($error){
        errorSender("$fieldName is required", $fileName);
    }

    $section_id = $_GET['section_id'];
    $subject_id = $_GET['subject_id'];

    isSectionIDExists($section_id, $conn);

    isSubjectIDExists($subject_id, $conn);

    $stmt = $conn->prepare("SELECT * FROM classes where section_id = ? and subject_id = ? and teacher_id = ?");
    $stmt->bind_param("iii", $section_id, $subject_id, $auth['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows <= 0){
        errorSender("Access on this class is DENIED!", $fileName);
    }

    $stmt = $conn->prepare("SELECT * FROM subjects  WHERE id = ?");
    $stmt->bind_param("i", $subject_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $subject = $result->fetch_assoc();

    $stmt = $conn->prepare("SELECT * FROM sections  WHERE id = ?");
    $stmt->bind_param("i", $section_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $section = $result->fetch_assoc();

    $role = 'student';
    $stmt = $conn->prepare("
    SELECT users.* FROM users 
    LEFT JOIN student_sections ON users.id = student_sections.student_id
    WHERE users.role = ? AND student_sections.section_id = ?");
    $stmt->bind_param("si", $role, $section_id);
    $stmt->execute();
    $students = $stmt->get_result();


} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>