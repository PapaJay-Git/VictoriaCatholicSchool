<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfStudent.php";


    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();

    $stmt = $conn->prepare("SELECT sections.* FROM student_sections
    LEFT JOIN sections ON student_sections.section_id = sections.id
    WHERE student_sections.student_id = ?");
    $stmt->bind_param("i", $auth['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows <= 0){
        echo "You currrently have no section. You can go back here if admin updated your account section.";
        exit();
    }

    $section_data = $result->fetch_assoc();

    $stmt = $conn->prepare("SELECT * FROM subjects  WHERE grade = ?");
    $stmt->bind_param("s", $section_data['grade']);
    $stmt->execute();
    $subjects = $stmt->get_result();


} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>