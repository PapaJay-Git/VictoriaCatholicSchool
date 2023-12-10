<?php


try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfCashier.php";

    // redirection file name
    $accountID = isset($_POST['id']) ? $_POST['id'] : NULL;

    $fileName = "Location: ../../Resources/views/cashier/update-pending-student.php?id=$accountID&guardian=true";
    $role = 'student';
    $error = false;
    $fieldName = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isPOST();

    isPOSTID();

    checkIfUserExists($accountID, $role, $conn);

    $required_fields = ['guardian_first_name', 'guardian_middle_name', 'guardian_last_name', 'guardian_username', 'guardian_phone', 'guardian_email', 'guardian_occupation'];

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
    $first_name = validate_name(sanitize_input($_POST['guardian_first_name']));
    $middle_name = validate_name(sanitize_input($_POST['guardian_middle_name']));
    $last_name = validate_name(sanitize_input($_POST['guardian_last_name']));
    $username = validate_username(sanitize_input($_POST['guardian_username']));
    $phone = validate_phone_number(sanitize_input($_POST['guardian_phone']));
    $guardian_occupation = sanitize_input($_POST['guardian_occupation']);
    $email_address = validate_email($_POST['guardian_email']);

    $stmt = $conn->prepare("SELECT guardian_id FROM guardians WHERE student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){

        $guardian = $result->fetch_assoc();
        $guardian_id = $guardian['guardian_id'];

        isUsernameExistsOtherThanMe($username, $conn, $guardian_id);
        isPhoneNumberExistsOtherThanMe($phone, $conn, $guardian_id);
        isEmailExistsOtherThanMe($email_address, $conn, $guardian_id);

        $stmt = $conn->prepare("UPDATE users SET first_name = ?, middle_name = ?, last_name = ?, username = ?, phone = ?, email = ?, occupation = ? WHERE id = ?");
        $stmt->bind_param("sssssssi", $first_name, $middle_name, $last_name, $username, $phone, $email_address, $guardian_occupation, $guardian_id);
        $stmt->execute();

    }else{
        $guardian_role = 'guardian';
        $default_password = "P@ssword123";
        $password = password_hash($default_password, PASSWORD_DEFAULT); 

        isUsernameExists($username, $conn);
        isPhoneNumberExists($phone_number, $conn);
        isEmailExists($email_address, $conn);

        $stmt = $conn->prepare("INSERT INTO users (first_name, middle_name, last_name, username, password, phone, email, occupation, role) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssssss", $first_name, $middle_name, $last_name, $username, $password, $phone, $email_address, $guardian_occupation, $guardian_role);
        $stmt->execute();
        $guardianID = $conn->insert_id;
    
        $stmt = $conn->prepare("DELETE FROM guardians WHERE student_id = ?");
        $stmt->bind_param("i", $accountID);
        $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO guardians (student_id, guardian_id) VALUES (?,?)");
        $stmt->bind_param("ii", $accountID, $guardianID);
        $stmt->execute();
    }

    $stmt->close();
    $conn->close();

    foreach ($required_fields as $field) {
        unset($_SESSION[$field]);
    }
    successSender("Guardian Updated Successfully", $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>