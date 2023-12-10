<?php


try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfCashier.php";

    // redirection file name
    $accountID = isset($_POST['id']) ? $_POST['id'] : NULL;

    $fileName = "Location: ../../Resources/views/cashier/update-balance.php?id=$accountID";
    $role = 'student';
    $error = false;
    $fieldName = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isPOST();

    checkIfUserExists($accountID, $role, $conn);

    $required_fields = ['balance', 'date', 'info'];

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

    $balance = $_POST['balance'];
    $date = $_POST['date'];
    $info = $_POST['info'];

    if(!is_numeric($balance)){
        errorSender("Invalid balance", $fileName);
    }

    if(strtotime($date) === false){
        errorSender("Invalid date", $fileName);
    }

    if(mb_strlen($info) > 255){
        errorSender("Info limit is only 255 characters", $fileName);
    }

    $stmt = $conn->prepare("DELETE FROM student_balance where student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO student_balance (student_id, date, descriptive_balance, info) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isds", $accountID, $date, $balance, $info);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    foreach ($required_fields as $field) {
        unset($_SESSION[$field]);
    }
    successSender("Student Balance Updated Successfully", $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>