<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

  
    // redirection file name
    $fileName = "Location: ../../Resources/views/admin/view_advisory.php?";
    $error = false;
    $fieldName = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isPOST();

    $required_fields = ['section', 'teacher'];

    $fieldCounts = [];

    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || !is_array($_POST[$field])) {
            $error = true;
            $fieldName = $field;
        }

        $fieldCounts[$field] = is_array($_POST[$field]) ? count($_POST[$field]) : 1;
    }
    
    if($error){
        errorSender("$fieldName is required", $fileName);
    }

    if (count(array_unique($fieldCounts)) != 1) {
        errorSender("Number of fields are imbalance!", $fileName);
    }

    foreach($_POST['teacher'] as $teacher){
        $role = "teacher";
        checkIfUserExists($teacher, $role, $conn);
    }

    foreach($_POST['section'] as $section){
        isSectionIDExists($section, $conn);

        $stmt = $conn->prepare("SELECT name FROM sections where id = ?");
        $stmt->bind_param("i", $section);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if($row['name'] == 'INACTIVE'){
            errorSender("You cannot set the advisory of the INACTIVE section.", $fileName);
        }
    }

    foreach($_POST['teacher'] as $index => $teacher){
        $stmt = $conn->prepare("UPDATE sections set advisory_teacher_id = ? where id = ?");
        $stmt->bind_param("ii", $teacher, $_POST['section'][$index]);
        $stmt->execute();
    }

    foreach ($required_fields as $field) {
        unset($_SESSION[$field]);
    }
    successSender('Section updated successfully', $fileName);


} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>