<?php

require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

try {
    $stmt = $conn->prepare("
    SELECT grades.grade, IFNULL(COUNT(sections.name), 0) AS section_count
    FROM (
        SELECT '7' AS grade
        UNION SELECT '8' AS grade
        UNION SELECT '9' AS grade
        UNION SELECT '10' AS grade
    ) AS grades
    LEFT JOIN sections ON grades.grade = sections.grade
    GROUP BY grades.grade ORDER BY sections.updated_at DESC
    ");
    $stmt->execute();
    $result = $stmt->get_result();

    $stmt = $conn->prepare("SELECT count(*) AS section_count FROM sections");
    $stmt->execute();
    $result2 = $stmt->get_result();
    $row2 = $result2->fetch_assoc();
    $sectionCount = $row2['section_count'];
    
   
    // // Fetch the result set as an associative array
    // $data = $result->fetch_all(MYSQLI_ASSOC);

    // // Convert the array to JSON
    // $jsonResult = json_encode($data);

    // // Return the JSON result
    // echo $jsonResult;

} catch (Exception $e) {
    // Log the exception or handle it appropriately
    error_log("Error: " . $e->getMessage());

    // Return an error response
    echo json_encode(['error' => $e->getMessage()]);
}
?>
