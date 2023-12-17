<?php
require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";

$role = 'student';
$stmt = $conn->prepare("SELECT users.*, COALESCE(balance, 'NONE')  as balance, 
COALESCE(date, 'NONE') as date
FROM users 
LEFT JOIN student_balance ON users.id = student_balance.student_id
WHERE role = ? AND users.id = ?");
$stmt->bind_param("si", $role, $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows <= 0) {
    $stmt->close();

    echo json_encode(['error' => "Unauthorized - You are not authorized to access this resource."]);
    exit();
}

$auth = $result->fetch_assoc();