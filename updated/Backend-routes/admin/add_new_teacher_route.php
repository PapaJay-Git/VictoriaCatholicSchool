<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    // redirection file name
    $fileName = "Location: ../../Resources/views/admin/teachers.php";

    $error = false;
    $fieldName = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isPOST();

    // required array
    $required_fields = ['first_name', 'last_name','phone', 'email', 'birthday', 'gender'];

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
    $middle_name = isset($_POST['middle_name']) ? sanitize_input($_POST['middle_name']) : NULL;
    $last_name = validate_name(sanitize_input($_POST['last_name']));
    $phone_number = validate_phone_number(sanitize_input($_POST['phone']));
    $email_address = validate_email($_POST['email']);
    $gender = validate_gender($_POST['gender']);
    $date_of_birth = validateBirthday($_POST['birthday']);

    $default_password = strtolower($last_name) . "_" . date("Y", strtotime($date_of_birth));

    // Remove spaces from the password
    $default_password = str_replace(' ', '', $default_password);

    $password = password_hash($default_password, PASSWORD_DEFAULT); 
    $role = 'teacher';
    

    isPhoneNumberExists($phone_number, $conn);
    
    isEmailExists($email_address, $conn);

    $stmt = $conn->prepare("INSERT INTO users (first_name, middle_name, last_name, password, phone, email, gender, birthday, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssssss", $first_name, $middle_name, $last_name, $password, $phone_number, $email_address, $gender, $date_of_birth, $role);

    $stmt->execute();
    $stmt->close();
    $conn->close();
    
    foreach ($required_fields as $field) {
        unset($_SESSION[$field]);
    }
    successSender("Teacher Added Successfully", $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>