<?php


try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    // redirection file name
    $accountID = isset($_POST['id']) ? $_POST['id'] : NULL;

    $fileName = "Location: ../../Resources/views/admin/update-student.php?id=$accountID&checklist=true";
    $role = 'student';
    $error = false;
    $fieldName = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isPOST();

    isPOSTID();

    checkIfUserExists($accountID, $role, $conn);

    $form_138 = isset($_POST['form_138']) ? 1 : 0;
    $good_moral = isset($_POST['good_moral']) ? 1 : 0;
    $baptisaml_of_birth = isset($_POST['baptisaml_of_birth']) ? 1 : 0;
    $nso_certificate = isset($_POST['nso_certificate']) ? 1 : 0;
    $previous_year_report_card = isset($_POST['previous_year_report_card']) ? 1 : 0;
    $honorary_dismissal = isset($_POST['honorary_dismissal']) ? 1 : 0;

    $stmt = $conn->prepare("SELECT student_type FROM registered_students WHERE student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    
    $stmt = $conn->prepare("DELETE FROM checklists WHERE student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();


    $sendNotification = false;

    if($row['student_type'] == 'transfer' && $baptisaml_of_birth == 1 && $nso_certificate == 1 && $previous_year_report_card == 1 && $honorary_dismissal == 1 ){
       
        $sendNotification = true;
    }else if($row['student_type'] == 'new' && $baptisaml_of_birth == 1 && $nso_certificate == 1 && $previous_year_report_card == 1){
        $sendNotification = true;
    }

    if($sendNotification){
        $is_complete = 1;
        $stmt = $conn->prepare("INSERT INTO checklists(student_id, form_138, good_moral, baptisaml_of_birth, nso_certificate, previous_year_report_card, honorary_dismissal, is_complete) VALUES(?,?,?,?,?,?,?,?)");
        $stmt->bind_param("iiiiiiii", $accountID, $form_138, $good_moral, $baptisaml_of_birth, $nso_certificate, $previous_year_report_card, $honorary_dismissal, $is_complete);
        $stmt->execute();

        $cashier = 'cashier';
        $stmt = $conn->prepare("SELECT id FROM users where role = ?");
        $stmt->bind_param("s", $cashier);
        $stmt->execute();
        $users = $stmt->get_result();
    
        $data = 'Requirements_filled';
    
        foreach($users as $user){
            $stmt = $conn->prepare("DELETE FROM notifications where notifiable_id = ? AND data = ?");
            $stmt->bind_param("is", $user['id'], $data);
            $stmt->execute();
    
            $stmt = $conn->prepare("INSERT INTO notifications (data, notifiable_id) VALUES (?, ?)");
            $stmt->bind_param("si", $data, $user['id']);
            $stmt->execute();
        }
    }else{
    
        $stmt = $conn->prepare("INSERT INTO checklists(student_id, form_138, good_moral, baptisaml_of_birth, nso_certificate, previous_year_report_card, honorary_dismissal) VALUES(?,?,?,?,?,?,?)");
        $stmt->bind_param("iiiiiii", $accountID, $form_138, $good_moral, $baptisaml_of_birth, $nso_certificate, $previous_year_report_card, $honorary_dismissal);
        $stmt->execute();
    }

    $stmt->close();
    $conn->close();

    foreach ($required_fields as $field) {
        unset($_SESSION[$field]);
    }
    successSender("Student Requirememnts Updated Successfully", $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>