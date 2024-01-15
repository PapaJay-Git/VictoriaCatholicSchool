<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    $gradeID = isset($_POST['grade']) ? $_POST['grade'] : NULL;
    $idOnly = isset($_POST['id']) ? $_POST['id'] : NULL;
    // redirection file name
    $fileName = "Location: ../../Resources/views/admin/update_subject.php?id=$idOnly&grade=$gradeID";
    $accountID = NULL;
    $error = false;
    $fieldName = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isPOST();

    isPOSTID();

    checkIfGradeIsValid($gradeID);

    isSubjectIDExists($accountID, $conn);

    $required_fields = ['name'];

    // required checker
    foreach ($required_fields as $field) {
        $_SESSION[$field] = strtoupper(sanitize_input($_POST[$field]));
        if (empty($_POST[$field])) {
            $error = true;
            $fieldName = $field;
        }
    }

    if($error){
        errorSender("$fieldName is required", $fileName);
    }

    $name = strtoupper(validate_name(sanitize_input($_POST['name'])));

    isSubjectNameExistsOtherThanMe($name, $gradeID, $accountID, $conn);

    $stmt = $conn->prepare("UPDATE subjects set name = ? where id = ?");
    $stmt->bind_param("si", $name, $accountID);
    $stmt->execute();

    foreach ($required_fields as $field) {
        unset($_SESSION[$field]);
    }
    successSender('Subject updated successfully', $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>