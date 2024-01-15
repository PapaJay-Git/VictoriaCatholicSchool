<?php


try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    // redirection file name
    $accountID = isset($_POST['id']) ? $_POST['id'] : NULL;

    $fileName = "Location: ../../Resources/views/admin/promisorry.php?id=$accountID";
    $error = false;
    $fieldName = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isPOST();

    isPOSTID();

    $is_approved = 0;
    $stmt = $conn->prepare("SELECT * FROM promissory WHERE id = ? AND is_approved = ?");
    $stmt->bind_param("ii", $accountID, $is_approved);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows <= 0){
        errorSender('Invalid Approval Process', $fileName);
    }

    $promissory = $result->fetch_assoc();
    $student_id = $promissory['student_id'];

    $is_approved = 1;
    $stmt = $conn->prepare("UPDATE promissory SET is_approved = ? WHERE id = ?");
    $stmt->bind_param("ii", $is_approved, $accountID);
    $stmt->execute();

    $stmt = $conn->prepare("SELECT * FROM student_sections where student_id = ? ");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $section = $result->fetch_assoc();

    // notification
    $data = 'Approved_promissory';

    $stmt = $conn->prepare("SELECT teacher_id FROM classes where section_id = ?");
    $stmt->bind_param("i", $section['section_id']);
    $stmt->execute();
    $subject_teachers = $stmt->get_result();

    $stmt = $conn->prepare("SELECT advisory_teacher_id FROM sections where id = ?");
    $stmt->bind_param("i", $section['section_id']);
    $stmt->execute();
    $avisors = $stmt->get_result();


    foreach($subject_teachers as $subject_teacher){
        $stmt = $conn->prepare("DELETE FROM notifications where notifiable_id = ? AND data = ?");
        $stmt->bind_param("is", $subject_teacher['teacher_id'], $data);
        $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO notifications (data, notifiable_id) VALUES (?, ?)");
        $stmt->bind_param("si", $data, $subject_teacher['teacher_id']);
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
    
    successSender("Promissory Approved Successfully", $fileName);


} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>