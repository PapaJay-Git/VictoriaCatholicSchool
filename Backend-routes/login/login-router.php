<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";


session_unset();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredUsername = $_POST['username'];
    $enteredPassword = $_POST['password'];

    $stmt = $conn->prepare("SELECT role, id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $enteredUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    
    $_SESSION['username'] = $_POST['username'];

    if ($result->num_rows <= 0) {
        $_SESSION['error'] = "Invalid username or password";
        header('Location: ../../Resources/views/login/login.php?error=1');
        exit();
    } 
    $row = $result->fetch_assoc();

// check if student  is in unregistered table
    $stmt = $conn->prepare("SELECT * from unregistered_students WHERE student_id = ?");
    $stmt->bind_param("i", $row['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Your account is still waiting for approval.";
        header('Location: ../../Resources/views/login/login.php?error=1');
        exit();
    } 
// check if student  is in unregistered table



// check if student is in inactive section
    $stmt = $conn->prepare("SELECT sections.name FROM sections 
    LEFT JOIN student_sections ON student_sections.section_id = sections.id 
    WHERE student_sections.student_id = ?");
    $stmt->bind_param("i", $row['id']);
    $stmt->execute();
    $result2 = $stmt->get_result();
    
    if($result2->num_rows > 0){
        $row2 = $result2->fetch_assoc();

        if($row2['name'] == 'INACTIVE'){
            $_SESSION['error'] = "Admin set your account as INACTIVE account";
            header('Location: ../../Resources/views/login/login.php?error=1');
            exit();
        }
    }
// check if student is in inactive section


    $dbPasswordHash = $row['password'];
    $dbID = $row['id'];
    $role = $row['role'];

    if (password_verify($enteredPassword, $dbPasswordHash)) {
        $_SESSION['id'] = $dbID;
        $_SESSION['role'] = $role;

        unset($_SESSION['username']);

        header("Location: ../../Resources/views/$role");
        exit();
    } else {
        $_SESSION['error'] = "Invalid username or password";
        header('Location: ../../Resources/views/login/login.php?error=1');
        exit();
    }
}else{
    $_SESSION['error'] = "Invalid method Request!";
    header('Location: ../../Resources/views/login/login.php?error=1');
    exit();
}
