<?php


try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    // redirection file name
    $accountID = isset($_POST['id']) ? $_POST['id'] : NULL;

    $fileName = "Location: ../../Resources/views/admin/update-pending-student.php?id=$accountID";
    $role = 'student';
    $error = false;
    $fieldName = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isPOST();

    isPOSTID();

    checkIfUserExists($accountID, $role, $conn);

    $required_fields = ['section', 'first_name', 'middle_name', 'last_name', 'username', 'address', 'school_number', 'phone', 'email', 'gender', 'birthday', 'student_type'];

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
    $username = validate_username(sanitize_input($_POST['username']));
    $address = sanitize_input($_POST['address']);
    $school_number = sanitize_input($_POST['school_number']);
    $phone = validate_phone_number(sanitize_input($_POST['phone']));
    $email_address = validate_email($_POST['email']);
    $gender = validate_gender($_POST['gender']);
    $date_of_birth = validateBirthday($_POST['birthday']);
    $sectionID = $_POST['section'];
    $student_type = validate_student_type($_POST['student_type']);

    isUsernameExistsOtherThanMe($username, $conn, $accountID);

    isSchoolNumberExistsOtherThanMe($school_number, $conn, $accountID);

    isPhoneNumberExistsOtherThanMe($phone, $conn, $accountID);
    
    isEmailExistsOtherThanMe($email_address, $conn, $accountID);

    isSectionIDExists($sectionID, $conn);
    
    $stmt = $conn->prepare("UPDATE users SET first_name = ?, middle_name = ?, last_name = ?, username = ?, address = ?, school_number = ?, phone = ?, email = ?, gender = ?, birthday = ? WHERE id = ?");
    $stmt->bind_param("ssssssssssi", $first_name, $middle_name, $last_name, $username, $address, $school_number, $phone, $email_address, $gender, $date_of_birth, $accountID);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM student_sections where student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO student_sections (student_id, section_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $accountID, $sectionID);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM registered_students where student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO registered_students (student_id, student_type) VALUES (?, ?)");
    $stmt->bind_param("is", $accountID, $student_type);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM unregistered_students where student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    $fileName = "Location: ../../Resources/views/admin/view_pending_students.php";

    foreach ($required_fields as $field) {
        unset($_SESSION[$field]);
    }
    successSender("Student Confirmed Successfully", $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>