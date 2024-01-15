<?php

try {
    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    $accountID = isset($_POST['id']) ? $_POST['id'] : NULL;

    // redirection file name
    $fileName = "Location: ../../Resources/views/admin/view_sections.php?id=$accountID";

    $role = NULL;
    $accountID = NULL;
    $error = false;
    $fieldName = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isPOST();

    isPOSTID();

    checkIfGradeIsValid($accountID);

    // required array
    $required_fields = ['section_name'];

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

    $name = strtoupper(validate_section_name(sanitize_input($_POST['section_name'])));

    isSectionNameExists($name, $conn);

   
    $stmt = $conn->prepare("INSERT INTO sections (name, grade) VALUES (?, ?)");

    $stmt->bind_param("ss", $name, $accountID);

    $stmt->execute();
    $stmt->close();
    $conn->close();

    foreach ($required_fields as $field) {
        unset($_SESSION[$field]);
    }
    successSender("Section Added Successfully", $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>