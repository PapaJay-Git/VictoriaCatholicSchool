<?php


try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfCashier.php";

    // redirection file name
    $accountID = isset($_POST['id']) ? $_POST['id'] : NULL;

    $fileName = "Location: ../../Resources/views/cashier/update-payment.php?id=$accountID";
    $role = 'student';
    $error = false;
    $fieldName = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isPOST();

    checkIfUserExists($accountID, $role, $conn);

    $required_fields = ['payment_type', 'value'];

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

    $value = $_POST['value'];
    $payment_type = validate_payment_type($_POST['payment_type']);


    if(!is_numeric($value)){
        errorSender("Invalid value", $fileName);
    }

    $stmt = $conn->prepare("DELETE FROM student_payment where student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO student_payment (student_id, value, payment_type) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $accountID, $value, $payment_type);
    $stmt->execute();

    $cashier = 'admin';
    $stmt = $conn->prepare("SELECT id FROM users where role = ?");
    $stmt->bind_param("s", $cashier);
    $stmt->execute();
    $users = $stmt->get_result();

    $data = 'Student_payment_added';

    foreach($users as $user){
        $stmt = $conn->prepare("DELETE FROM notifications where notifiable_id = ? AND data = ?");
        $stmt->bind_param("is", $user['id'], $data);
        $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO notifications (data, notifiable_id) VALUES (?, ?)");
        $stmt->bind_param("si", $data, $user['id']);
        $stmt->execute();
    }

    $stmt->close();
    $conn->close();

    foreach ($required_fields as $field) {
        unset($_SESSION[$field]);
    }
    successSender("Student Payment Updated Successfully", $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>