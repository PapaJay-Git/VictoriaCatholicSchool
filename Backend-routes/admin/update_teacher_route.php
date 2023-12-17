<?php


try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    // redirection file name
    $accountID = isset($_POST['id']) ? $_POST['id'] : NULL;

    $fileName = "Location: ../../Resources/views/admin/update-teacher.php?id=$accountID";
    $role = 'teacher';
    $error = false;
    $fieldName = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isPOST();

    isPOSTID();

    checkIfUserExists($accountID, $role, $conn);

    $required_fields = ['first_name', 'middle_name', 'last_name', 'phone', 'email', 'gender', 'birthday'];

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

      // input data
    $first_name = validate_name(sanitize_input($_POST['first_name']));
    $middle_name = validate_name(sanitize_input($_POST['middle_name']));
    $last_name = validate_name(sanitize_input($_POST['last_name']));
    $phone = validate_phone_number(sanitize_input($_POST['phone']));
    $email_address = validate_email($_POST['email']);
    $gender = validate_gender($_POST['gender']);
    $date_of_birth = validateBirthday($_POST['birthday']);

    isPhoneNumberExistsOtherThanMe($phone, $conn, $accountID);
    
    isEmailExistsOtherThanMe($email_address, $conn, $accountID);
    
    $stmt = $conn->prepare("UPDATE users SET first_name = ?, middle_name = ?, last_name = ?, phone = ?, email = ?, gender = ?, birthday = ? WHERE id = ?");

    $stmt->bind_param("sssssssi", $first_name, $middle_name, $last_name, $phone, $email_address, $gender, $date_of_birth, $accountID);
    
    $stmt->execute();
    $stmt->close();
    $conn->close();

    foreach ($required_fields as $field) {
        unset($_SESSION[$field]);
    }
    successSender("Teacher Updated Successfully", $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>