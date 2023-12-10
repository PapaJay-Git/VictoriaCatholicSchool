<?php

try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    $gradeID = isset($_POST['grade']) ? $_POST['grade'] : NULL;
    $sectionID= isset($_POST['section']) ? $_POST['section'] : NULL;
    $error = false;
    $fieldName = NULL;

    // redirection file name
    $fileName = "Location: ../../Resources/views/admin/manage_section.php?id=$sectionID&grade=$gradeID";

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isPOST();

    checkIfGradeIsValid($gradeID);

    $required_fields = [
        'subject',
        'teacher',
        'is_monday',
        'monday_start_time',
        'monday_end_time',
        'is_tuesday',
        'tuesday_start_time',
        'tuesday_end_time',
        'is_wednesday',
        'wednesday_start_time',
        'wednesday_end_time',
        'is_thursday',
        'thursday_start_time',
        'thursday_end_time',
        'is_friday',
        'friday_start_time',
        'friday_end_time'
    ];
    
    $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];

    $schedules = [
        '7:00 AM', '7:30 AM', '8:00 AM', '8:30 AM',
        '9:00 AM', '9:30 AM', '10:00 AM', '10:30 AM',
        '11:00 AM', '11:30 AM', '12:00 PM', '12:30 PM',
        '1:00 PM', '1:30 PM', '2:00 PM', '2:30 PM',
        '3:00 PM', '3:30 PM', '4:00 PM', '4:30 PM',
        '5:00 PM', '5:30 PM', '6:00 PM'
    ];

    $fieldCounts = [];

    if(!isset($_POST['section']) || !isset($_POST['grade'])){
        errorSender("Both section and grade are required", $fileName);
    }

    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || !is_array($_POST[$field])) {
            $error = true;
            $fieldName = $field;
        }

        $fieldCounts[$field] = is_array($_POST[$field]) ? count($_POST[$field]) : 1;
    }
    
    if($error){
        errorSender("$fieldName is required", $fileName);
    }

    if (count(array_unique($fieldCounts)) != 1) {
        errorSender("Number of fields are imbalance!", $fileName);
    }

    
    foreach ($days as $day) {
        $isDayKey = 'is_' . $day;
        $startKey = $day . '_start_time';
        $endKey = $day . '_end_time';
    
        foreach ($_POST[$isDayKey] as $is_day) {
            if ($is_day != '0' && $is_day != '1') {
                errorSender("Days should only be true or false!", $fileName);
            }
        }

        // Check if each start time is in the schedules array
        foreach ($_POST[$startKey] as $startTime) {
            if (!in_array($startTime, $schedules)) {
                errorSender("Invalid start time for $day!", $fileName);
            }
        }

        // Check if each end time is in the schedules array
        foreach ($_POST[$endKey] as $endTime) {
            if (!in_array($endTime, $schedules)) {
                errorSender("Invalid end time for $day!", $fileName);
            }
        }
    }

    // check if is really a teacher
    foreach($_POST['teacher'] as $teacher){
        $role = "teacher";
        checkIfUserExists($teacher, $role, $conn);
    }
  
    //section check
    isSectionIDExists($_POST['section'], $conn);

    $grade = getGradeBySectionID($_POST['section'], $conn);

    foreach($_POST['subject'] as $subject){
        checkIfSubjectIsTheAsGrade($subject, $grade, $conn);
    }

    $stmt = $conn->prepare("DELETE FROM classes WHERE section_id = ?");
    $stmt->bind_param("i", $_POST['section']);
    $stmt->execute();

    foreach($_POST['subject'] as $index => $subject){
        $query = "INSERT INTO classes (subject_id, teacher_id, section_id, is_monday, monday_start_time, monday_end_time, 
        is_tuesday, tuesday_start_time, tuesday_end_time, is_wednesday, wednesday_start_time, 
        wednesday_end_time, is_thursday, thursday_start_time, thursday_end_time, is_friday, 
        friday_start_time, friday_end_time) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
        // Prepare the statement
        $stmt = mysqli_prepare($conn, $query);
    
        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'iiisssssssssssssss',
        $subject,
        $_POST['teacher'][$index],
        $_POST['section'],
        $_POST['is_monday'][$index],
        $_POST['monday_start_time'][$index],
        $_POST['monday_end_time'][$index],
        $_POST['is_tuesday'][$index],
        $_POST['tuesday_start_time'][$index],
        $_POST['tuesday_end_time'][$index],
        $_POST['is_wednesday'][$index],
        $_POST['wednesday_start_time'][$index],
        $_POST['wednesday_end_time'][$index],
        $_POST['is_thursday'][$index],
        $_POST['thursday_start_time'][$index],
        $_POST['thursday_end_time'][$index],
        $_POST['is_friday'][$index],
        $_POST['friday_start_time'][$index],
        $_POST['friday_end_time'][$index]
        );
    
        mysqli_stmt_execute($stmt);
    }
   

    foreach ($required_fields as $field) {
        unset($_SESSION[$field]);
    }
    successSender('Schedule and Subject Teacher Update Successfully', $fileName);

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>