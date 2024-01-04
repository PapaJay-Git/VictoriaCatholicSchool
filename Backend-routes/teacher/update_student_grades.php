<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";

    $section_id = isset($_POST['section_id']) ? $_POST['section_id'] : NULL;
    $subject_id = isset($_POST['subject_id']) ? $_POST['subject_id'] : NULL;
    // redirection file name
    $fileName = "Location: ../../Resources/views/teacher/students.php?section_id=$section_id&subject_id=$subject_id";
    $error = false;
    $fieldName = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isPOST();

    $required_fields = ['section_id', 'subject_id'];

    // required checker
    foreach ($required_fields as $field) {
        $_SESSION[$field] = sanitize_input($_POST[$field]);
        if (empty($_POST[$field])) {
            $error = true;
            $fieldName = $field;
        }
    }
    
    if($error){
        errorSender("$fieldName is required", $fileName);
    }

    $section_id = $_POST['section_id'];
    $subject_id = $_POST['subject_id'];

    isSectionIDExists($section_id, $conn);

    isSubjectIDExists($subject_id, $conn);

    $stmt = $conn->prepare("SELECT * FROM classes where section_id = ? and subject_id = ? and teacher_id = ?");
    $stmt->bind_param("iii", $section_id, $subject_id, $auth['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows <= 0){
        errorSender("Access on this class is DENIED!", $fileName);
    }

    $required_fields = ['student_id', 'first', 'second', 'third', 'fourth'];

    foreach ($required_fields as $field) {
        if (isset($_POST[$field]) && is_array($_POST[$field])) {
            foreach ($_POST[$field] as $field_row) {
                if (!isset($field_row) || $field_row === '') {
                    $error = true;
                    $fieldName = $field;
                }
            }
        } else {
            $error = true;
            $fieldName = $field;
        }
    }

    if($error){
        errorSender("All of the $fieldName are required", $fileName);
    }

    $student_ids = $_POST['student_id'];
    $firsts = $_POST['first'];
    $seconds = $_POST['second'];
    $thirds = $_POST['third'];
    $fourths = $_POST['fourth'];

    if (
        count($student_ids) !== count($firsts) ||
        count($firsts) !== count($seconds) ||
        count($seconds) !== count($thirds) ||
        count($thirds) !== count($fourths)
    ) {
        errorSender("Uneven Count of inputs", $fileName);
    }

    foreach($student_ids as $student_id){
        $stmt = $conn->prepare("SELECT * FROM student_sections WHERE student_id = ? AND section_id = ?");
        $stmt->bind_param("ii", $student_id, $section_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 0){
            errorSender("Invalid student ID", $fileName);
        }
    }

    for ($count = 0; $count < count($fourths); $count++) {

        if($fourths[$count] < 0 || $fourths[$count] > 100){
            errorSender("Grades should only be between 0 to 100", $fileName);
        }
        if($thirds[$count] < 0 || $thirds[$count] > 100){
            errorSender("Grades should only be between 0 to 100", $fileName);
        }
        if($seconds[$count] < 0 || $seconds[$count] > 100){
            errorSender("Grades should only be between 0 to 100", $fileName);
        }
        if($firsts[$count] < 0 || $firsts[$count] > 100){
            errorSender("Grades should only be between 0 to 100", $fileName);
        }

    }

    for ($count = 0; $count < count($student_ids); $count++) {
        $student_id = $_POST['student_id'][$count];
        $first = $_POST['first'][$count];
        $second = $_POST['second'][$count];
        $third = $_POST['third'][$count];
        $fourth = $_POST['fourth'][$count];

        $stmt = $conn->prepare("DELETE FROM student_grades WHERE student_id = ? AND subject_id = ?");
        $stmt->bind_param("ii", $student_id, $subject_id);
        $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO student_grades (student_id, subject_id, first_quarter, second_quarter, third_quarter, fourth_quarter) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iidddd", $student_id, $subject_id, $first, $second, $third, $fourth);
        $stmt->execute();
    }

    successSender('Grades updated successfully', $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>