<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfTeacher.php";

    // redirection file name
    $fileName = "Location: advisories.php";
    $accountID = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();

    isGETID();

    isSectionIDExists($accountID, $conn);

    $stmt = $conn->prepare("SELECT * FROM sections where id = ? and advisory_teacher_id = ?");
    $stmt->bind_param("ii", $accountID, $auth['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows <= 0){
        errorSender("Access on this section DENIED!", $fileName);
    }

    $sectionID = $accountID;
    $stmt = $conn->prepare("SELECT * FROM sections where id = ?");
    $stmt->bind_param("i", $sectionID);
    $stmt->execute();
    $results = $stmt->get_result();
    $row = $results->fetch_assoc();

    $stmt = $conn->prepare("SELECT * from subjects WHERE grade = ?");
    $stmt->bind_param("s", $row['grade']);
    $stmt->execute();

    $subjects = $stmt->get_result();

    $role = 'teacher';
    $stmt = $conn->prepare("SELECT first_name, last_name, id, school_number FROM users where role = ?");
    $stmt->bind_param("s", $role);
    $stmt->execute();

    $teachers = $stmt->get_result();

    $schedules = [
        '7:00 AM', '7:30 AM', '8:00 AM', '8:30 AM',
        '9:00 AM', '9:30 AM', '10:00 AM', '10:30 AM',
        '11:00 AM', '11:30 AM', '12:00 PM', '12:30 PM',
        '1:00 PM', '1:30 PM', '2:00 PM', '2:30 PM',
        '3:00 PM', '3:30 PM', '4:00 PM', '4:30 PM',
        '5:00 PM', '5:30 PM', '6:00 PM'
    ];


} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>