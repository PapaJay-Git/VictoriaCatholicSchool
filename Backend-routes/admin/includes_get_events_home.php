<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    // require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";

    $todayDate = date("Y-m-d"); // Get the current date in the format "YYYY-MM-DD"

    $stmt = $conn->prepare("SELECT * FROM events WHERE show_until >= ? ORDER BY updated_at DESC");
    $stmt->bind_param("s", $todayDate);
    $stmt->execute();
    $events = $stmt->get_result();

} catch (Exception $e) {
    // Log the exception or handle it appropriately
    error_log("Error: " . $e->getMessage());

    // Return an error response
    echo json_encode(['error' => $e->getMessage()]);
}
?>
