<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";

session_unset();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredEmail = trim($_POST['email']);
    $enteredPassword = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT role, id, password, is_locked, login_attempts FROM users WHERE email = ?");
    $stmt->bind_param("s", $enteredEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    
    $_SESSION['email'] = $_POST['email'];

    if ($result->num_rows <= 0) {
        $_SESSION['error'] = "Invalid email or password";
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

if($row['role'] != 'admin'){

    //check if account is locked
    if($row['is_locked'] == 1){
        $_SESSION['error'] = "It looks like your account has been locked. Please contact your admin.";
        header('Location: ../../Resources/views/login/login.php?error=1');
        exit();
    }
    //check if account is locked

    
    //check login attempts
    $login_attempts = $row['login_attempts'];
    $updated_login_attempts = $login_attempts+1;
    $stmt = $conn->prepare("UPDATE users SET login_attempts = ? WHERE id = ?");
    $stmt->bind_param("ii", $updated_login_attempts, $row['id']);
    $stmt->execute();
    //check login attempts
}

    $dbPasswordHash = $row['password'];
    $dbID = $row['id'];
    $role = $row['role'];

    if (password_verify($enteredPassword, $dbPasswordHash)) {
        $_SESSION['id'] = $dbID;
        $_SESSION['role'] = $role;

        unset($_SESSION['email']);

        $updated_login_attempts = 0;
        $is_unlocked = 0;
        $stmt = $conn->prepare("UPDATE users SET login_attempts = ?, is_locked = ? WHERE id = ?");
        $stmt->bind_param("iii", $updated_login_attempts, $is_unlocked, $row['id']);
        $stmt->execute();

        header("Location: ../../Resources/views/$role");
        exit();
    } else {
        if($updated_login_attempts >= 3){
            $is_locked = 1;
            $updated_login_attempts = 0;
            $stmt = $conn->prepare("UPDATE users SET login_attempts = ?, is_locked = ? WHERE id = ?");
            $stmt->bind_param("iii", $updated_login_attempts, $is_locked, $row['id']);
            $stmt->execute();
        } 
        $_SESSION['error'] = "Invalid email or password";
        header('Location: ../../Resources/views/login/login.php?error=1');
        exit();
    }
}else{
    $_SESSION['error'] = "Invalid method Request!";
    header('Location: ../../Resources/views/login/login.php?error=1');
    exit();
}
