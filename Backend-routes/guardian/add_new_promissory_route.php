<?php

try {
    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfGuardian.php";

    // redirection file name
    $fileName = "Location: ../../Resources/views/guardian/promissories.php?";

    $error = false;
    $fieldName = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isPOST();

    $stmt = $conn->prepare("SELECT * FROM student_sections where student_id = ? ");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $section = $result->fetch_assoc();

    if($result->num_rows <= 0){
       echo "You currently have no section. You can view this once you have one.";
       exit();
    }

    // required array
    $required_fields = ['promissory'];

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

    $promissory = $_POST['promissory'];

    if ($promissory !== 'payment') {
        errorSender("Invalid selected promissory.", $fileName);
    }
    
   
    $stmt = $conn->prepare("INSERT INTO promissory (note, student_id) VALUES (?, ?)");
    $stmt->bind_param("si", $promissory, $student_id);
    $stmt->execute();

    // notification
    $data = 'Promissory';


    $stmt = $conn->prepare("SELECT teacher_id FROM classes where section_id = ?");
    $stmt->bind_param("i", $section['section_id']);
    $stmt->execute();
    $subject_teachers = $stmt->get_result();

    $stmt = $conn->prepare("SELECT advisory_teacher_id FROM sections where id = ?");
    $stmt->bind_param("i", $section['section_id']);
    $stmt->execute();
    $avisors = $stmt->get_result();

    $adminTxt = 'admin';
    $stmt = $conn->prepare("SELECT id FROM users WHERE role = ?");
    $stmt->bind_param("s", $adminTxt);
    $stmt->execute();
    $admins = $stmt->get_result();


    foreach($subject_teachers as $subject_teacher){
        $stmt = $conn->prepare("DELETE FROM notifications where notifiable_id = ? AND data = ?");
        $stmt->bind_param("is", $subject_teacher['teacher_id'], $data);
        $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO notifications (data, notifiable_id) VALUES (?, ?)");
        $stmt->bind_param("si", $data, $subject_teacher['teacher_id']);
        $stmt->execute();
    }
    foreach($admins as $admin){
        $stmt = $conn->prepare("DELETE FROM notifications where notifiable_id = ? AND data = ?");
        $stmt->bind_param("is", $admin['id'], $data);
        $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO notifications (data, notifiable_id) VALUES (?, ?)");
        $stmt->bind_param("si", $data, $admin['id']);
        $stmt->execute();
    }
    foreach($avisors as $avisor){
        $stmt = $conn->prepare("DELETE FROM notifications where notifiable_id = ? AND data = ?");
        $stmt->bind_param("is", $avisor['advisory_teacher_id'], $data);
        $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO notifications (data, notifiable_id) VALUES (?, ?)");
        $stmt->bind_param("si", $data, $avisor['advisory_teacher_id']);
        $stmt->execute();
    }

    $stmt->close();
    $conn->close();

    foreach ($required_fields as $field) {
        unset($_SESSION[$field]);
    }
    successSender("Promissory Added Successfully", $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>