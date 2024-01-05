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

    $required_fields = ['payment_type'];

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

    $payment_type = validate_payment_type($_POST['payment_type']);

    $currentYear = date('Y');

    $currentMonth = date('n');

    if ($currentMonth >= 5) {
        $currentYear += 1;
    }else{
        $currentYear -= 1;
    }

    $acceptableMonths = [
        $currentYear."-7",
        $currentYear."-8",
        $currentYear."-9",
        $currentYear."-10",
        $currentYear."-11",
        $currentYear."-12",
        ($currentYear+1)."-1",
        ($currentYear+1)."-2",
        ($currentYear+1)."-3"
    ];

    if($payment_type == 'down'){
        if(isset($_POST['month']) && !is_array($_POST['month'])){
            errorSender('Month is not in array format', $fileName);
        }

        $stmt = $conn->prepare("DELETE FROM paidMonths where student_id = ? and date = ?");
        foreach($acceptableMonths as $acceptableMonth){
            $stmt->bind_param("is", $accountID, $acceptableMonth);
            $stmt->execute();
        }

        if(isset($_POST['month']) && is_array($_POST['month'])){
            $months = $_POST['month'];
            foreach($months as $month){
                if(!in_array($month, $acceptableMonths)){
                    errorSender('One or more date is invalid', $fileName);
                }
            }
            $stmt = $conn->prepare("INSERT INTO paidMonths(student_id, date) values(?,?) ");
            foreach($months as $month){
                $stmt->bind_param("is", $accountID, $month);
                $stmt->execute();
            }

        }
    }else{

        $stmt = $conn->prepare("DELETE FROM paidMonths where student_id = ? and date = ?");
        foreach($acceptableMonths as $acceptableMonth){
            $stmt->bind_param("is", $accountID, $acceptableMonth);
            $stmt->execute();
        }
    
        $stmt = $conn->prepare("INSERT INTO paidMonths(student_id, date) values(?,?) ");
        foreach($acceptableMonths as $acceptableMonth){
            $stmt->bind_param("is", $accountID, $acceptableMonth);
            $stmt->execute();
        }
    }

    $stmt = $conn->prepare("DELETE FROM student_payment where student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO student_payment (student_id, payment_type) VALUES (?, ?)");
    $stmt->bind_param("is", $accountID, $payment_type);
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

    $fileName = "Location: ../../Resources/views/cashier/registered_students.php";
    successSender("Student Payment Updated Successfully", $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>