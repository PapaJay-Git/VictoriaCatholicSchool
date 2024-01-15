<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfStudent.php";

    $accountID = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();

    $stmt = $conn->prepare("SELECT * FROM student_sections where student_id = ? ");
    $stmt->bind_param("i", $auth['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $section = $result->fetch_assoc();

    if($result->num_rows <= 0){
       echo "You currently have no section. You can view this once you have one.";
       exit();
    }

    $sectionID = $section['section_id'];
    $stmt = $conn->prepare("
    SELECT sections.*, users.first_name, users.last_name, users.email 
    FROM sections LEFT JOIN
    users ON sections.advisory_teacher_id = users.id
    WHERE sections.id = ?");
    $stmt->bind_param("i", $sectionID);
    $stmt->execute();
    $results = $stmt->get_result();
    $row = $results->fetch_assoc();

    $stmt = $conn->prepare("SELECT * from subjects WHERE grade = ?");
    $stmt->bind_param("s", $row['grade']);
    $stmt->execute();
    $subjects = $stmt->get_result();

    $role = 'teacher';
    $stmt = $conn->prepare("SELECT first_name, last_name, id, email FROM users where role = ?");
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