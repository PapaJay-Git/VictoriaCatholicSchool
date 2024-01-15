<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    // redirection file name
    $fileName = "Location: ../../Resources/views/admin/view_registered_students.php";

    $error = false;
    $fieldName = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isPOST();

    // required array
    $required_fields = ['section','first_name', 'last_name', 'phone', 'email', 'birthday', 'gender', 'student_type', 'barangay', 'province', 'city_municipality', 'zip_code'];

    
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

    // OPTIONAL
    $street_no = isset($_POST['street_no'])  ? sanitize_input($_POST['street_no']) : NULL;
    $street = isset($_POST['street'])  ? sanitize_input($_POST['street']) : NULL;
    $village = isset($_POST['village']) ? sanitize_input($_POST['village']) : NULL;
    // REQUIRED
    $barangay = sanitize_input($_POST['barangay']);
    $city_municipality = sanitize_input($_POST['city_municipality']);
    $province = sanitize_input($_POST['province']);
    $zip_code = sanitize_input($_POST['zip_code']);
    $guardian_account = $_POST['guardian_that_will_have_an_account'];

    $_SESSION['street_no'] = $street_no;
    $_SESSION['street'] = $street;
    $_SESSION['village'] = $village;

    $_SESSION['city_municipality'] = $city_municipality;
    $_SESSION['barangay'] = $barangay;
    $_SESSION['province'] = $province;
    $_SESSION['zip_code'] = $zip_code;

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
    $role = 'student';
    $sectionID = $_POST['section'];
    $student_type = validate_student_type($_POST['student_type']);
    

    isPhoneNumberExists($phone_number, $conn);
    
    isEmailExists($email_address, $conn);

    isSectionIDExists($sectionID, $conn);

    $stmt = $conn->prepare("INSERT INTO users (first_name, middle_name, last_name, password,  phone, email, gender, birthday, role, street_no, street, village, barangay, city_municipality, province, zip_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssssss", $first_name, $middle_name, $last_name, $password, $phone_number, $email_address, $gender, $date_of_birth, $role, $street_no, $street, $village, $barangay, $city_municipality, $province, $zip_code);
    $stmt->execute();
    $insertedUserId = $conn->insert_id;

    $stmt = $conn->prepare("DELETE FROM student_sections where student_id = ?");
    $stmt->bind_param("i", $insertedUserId);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO student_sections (student_id, section_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $insertedUserId, $sectionID);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO registered_students (student_id, student_type) VALUES (?, ?)");
    $stmt->bind_param("is", $insertedUserId, $student_type);
    $stmt->execute();

    $stmt->close();
    $conn->close();


    foreach ($required_fields as $field) {
        unset($_SESSION[$field]);
    }

    unset(
        $_SESSION['street_no'],
        $_SESSION['street'],
        $_SESSION['village'],
    );
    
    successSender("Student Added Successfully", $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>