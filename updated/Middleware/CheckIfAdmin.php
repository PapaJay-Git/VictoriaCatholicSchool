<?php
require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";

$role = 'admin';
$stmt = $conn->prepare("SELECT * FROM users WHERE role = ? AND id = ?");
$stmt->bind_param("si", $role, $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows <= 0) {
    $stmt->close();

    echo json_encode(['error' => "Unauthorized - You are not authorized to access this resource."]);
    exit();
}

$auth = $result->fetch_assoc();

$is_read = 0;
$stmt = $conn->prepare("SELECT id FROM notifications WHERE notifiable_id = ? AND is_read = ?");
$stmt->bind_param("ii", $_SESSION['id'], $is_read);
$stmt->execute();
$result = $stmt->get_result();
$unread_count = $result->num_rows;