<?php

function errorSender($sessionError, $errorLocation)
{
    // Set the error in the session
    $_SESSION['error'] = $sessionError;
    
    header($errorLocation);
    exit(1);
}
function successSender($sessionSuccess, $successLocation)
{
    // Set the error in the session
    $_SESSION['success'] = $sessionSuccess;
    
    header($successLocation);
    exit(1);
}

function isPOST() {
    global $fileName;

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        errorSender('Invalid Method Type', $fileName);
    }
}
function isGET() {
    global $fileName;

    if($_SERVER["REQUEST_METHOD"] != "GET"){
        errorSender('Invalid Method Type', $fileName);
    }
}

function isGETID() {
    global $fileName;
    global $accountID;

    if(!isset($_GET['id']) || empty($_GET['id']) ){
        errorSender('ID is required', $fileName);
    }

    $accountID = $_GET['id'];
}

function isPOSTID() {
    global $fileName;
    global $accountID;

    if(!isset($_POST['id']) || empty($_POST['id']) ){
        errorSender('ID is required', $fileName);
    }

    $accountID = $_POST['id'];
}


function checkIfUserExists($accountID, $role, $conn){
    global $fileName;

    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE id = ? AND role = ?");
    $stmt->bind_param("is", $accountID, $role);
    $stmt->execute();

    $result = $stmt->get_result();
    $rowCount = $result->fetch_assoc()['COUNT(*)']; // Retrieve the count from the result set

    if ($rowCount <= 0) {
        // No user found
        errorSender('INVALID USER ID!', $fileName);
    }

}

function checkIfGradeIsValid($accountID) {
    global $fileName;

    $validGrades = [7, 8, 9, 10];

    if (!in_array($accountID, $validGrades)) {
        // No user found
        errorSender('INVALID GRADE!', $fileName);
    }
}



function deleteUser($accountID, $role, $conn) {
    global $fileName;

    // Prepare the DELETE statement
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role = ?");
    $stmt->bind_param("is", $accountID, $role);

    // Execute the statement
    if ($stmt->execute()) {
        successSender('Delete success!', $fileName);
    } else {
        errorSender('There is a problem deleting this user.', $fileName);
    }
}





function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


function validate_email($email) {
    global $fileName;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        errorSender('Invalid Email', $fileName);
    }

    return $email;
}

function validate_name($name) {
    global $fileName;
    $name = trim($name);
    if (empty($name)) {
        errorSender('Name is required', $fileName);
    }

    if (!preg_match('/^[\p{L}\s\'\-]+$/u', $name)) {
        errorSender("Name can only contain letters, spaces, hyphens, and apostrophes.", $fileName);
    }

    return $name;
}

function validate_username($username) {
    $min_length = 3;
    $max_length = 20;
    global $fileName;
        
    $username_length = strlen($username);
    if ($username_length < $min_length || $username_length > $max_length) {
        errorSender("Username must be between $min_length and $max_length characters.", $fileName);
    }

    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        errorSender("Username can only contain letters, numbers, and underscores.", $fileName);
    }

    return $username;
}

function validate_phone_number($phone_number) {
    $phone_number = preg_replace('/[^0-9]/', '', $phone_number);

    global $fileName;
        
    $required_length = 11;
    if (strlen($phone_number) !== $required_length) {
        errorSender("Invalid  phone number format.", $fileName);
    }
    if (substr($phone_number, 0, 2) !== '09') {
        errorSender("phone number must start with 09.", $fileName);
    }
    return $phone_number;
}

function validate_gender($gender){
    global $fileName;

    if($gender != "Male" && $gender != "Female"){
        errorSender("Invalid Gender.", $fileName);
    }

    return $gender;
}

function validateBirthday($birthday) {
    $dateArray = explode('-', $birthday);
    global $fileName;

    if (count($dateArray) != 3 || !checkdate($dateArray[1], $dateArray[2], $dateArray[0])) {
        errorSender("Invalid birthday.", $fileName);
    }

    $currentDate = new DateTime();
    $providedDate = new DateTime($birthday);

    if ($providedDate > $currentDate) {
        errorSender("Invalid birthday.", $fileName);
    }

    return $birthday;
}

// Function to check if an email already exists
function isEmailExists($email, $conn) {
    global $fileName;
    
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if(mysqli_stmt_num_rows($stmt) > 0){
        errorSender('Email already exist!', $fileName);
    }
    
}


// Function to check if a username already exists
function isUsernameExists($username, $conn) {
    global $fileName;

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if(mysqli_stmt_num_rows($stmt) > 0){
        errorSender('Username already exist!', $fileName);
    }
}

function isSectionNameExists($name, $conn) {
    global $fileName;

    $query = "SELECT * FROM sections WHERE name = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if(mysqli_stmt_num_rows($stmt) > 0){
        errorSender('Section Name already exist!', $fileName);
    }
}

function isSectionNameExistsOtherThanMe($name, $conn, $id) {
    global $fileName;

    $query = "SELECT * FROM sections WHERE name = ? AND id != ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $name, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if(mysqli_stmt_num_rows($stmt) > 0){
        errorSender('Section Name already exist!', $fileName);
    }
}

function isSubjectNameExistsOtherThanMe($name, $grade, $accountID, $conn){
    global $fileName;

    $query = "SELECT * FROM subjects WHERE name = ? AND grade = ? AND id != ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssi', $name, $grade, $accountID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if(mysqli_stmt_num_rows($stmt) > 0){
        errorSender('Subject Name already exist!', $fileName);
    }
}

function isSubjectNameExists($name, $conn, $grade){
    global $fileName;

    $query = "SELECT * FROM subjects WHERE name = ? AND grade = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $name, $grade);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if(mysqli_stmt_num_rows($stmt) > 0){
        errorSender('Subject Name already exist!', $fileName);
    }
}

function isSectionIDExists($id, $conn) {
    global $fileName;

    $query = "SELECT * FROM sections WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if(mysqli_stmt_num_rows($stmt) <= 0){
        errorSender('Cannot make a process out of an Invalid Section!', $fileName);
    }
}

function checkIfSubjectIsTheAsGrade($subjectID, $grade, $conn){
    global $fileName;

    $query = "SELECT * FROM subjects WHERE id = ? AND grade = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'is', $subjectID, $grade);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if(mysqli_stmt_num_rows($stmt) <= 0){
        errorSender('Cannot make a process out of an unmatched section and grade!', $fileName);
    }
}



function getGradeBySectionID($id, $conn) {
    global $fileName;

    $query = "SELECT grade FROM sections WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        errorSender('Error preparing statement: ' . mysqli_error($conn), $fileName);
    }

    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $grade);

    if (mysqli_stmt_fetch($stmt)) {
        mysqli_stmt_close($stmt);
        return $grade;
    } else {
        errorSender('Cannot make a process out of an Invalid Section!', $fileName);
    }
}

function isSubjectIDExists($id, $conn) {
    global $fileName;

    $query = "SELECT * FROM subjects WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if(mysqli_stmt_num_rows($stmt) <= 0){
        errorSender('Cannot make a process out of an Invalid Subject!', $fileName);
    }
}

// Function to check if a school number already exists
function isSchoolNumberExists($schoolNumber, $conn) {
    global $fileName;

    $query = "SELECT * FROM users WHERE school_number = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $schoolNumber);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if(mysqli_stmt_num_rows($stmt) > 0){
        errorSender('School number already exist!', $fileName);
    }
}

// Function to check if a phone number already exists
function isPhoneNumberExists($phoneNumber, $conn) {
    global $fileName;

    $query = "SELECT * FROM users WHERE phone = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $phoneNumber);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if(mysqli_stmt_num_rows($stmt) > 0){
        errorSender('Phone number already exist!', $fileName);
    }
}

// exist other than me

// Function to check if an email already exists
function isEmailExistsOtherThanMe($email, $conn, $accountID) {
    global $fileName;
    
    $query = "SELECT * FROM users WHERE email = ? AND id != ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $email, $accountID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if(mysqli_stmt_num_rows($stmt) > 0){
        errorSender('Email already exist!', $fileName);
    }
    
}

function validatePassword($password, $confirmPassword) {
    global $fileName;

    if($password != $confirmPassword){
        errorSender('Confirm password do not match!', $fileName);
    }
    
    if (strlen($password) < 8) {
        errorSender('Password must be at least 8 characters long!', $fileName);
    }

    if (!preg_match("/[A-Z]/", $password)) {
        errorSender('Password must contain at least one uppercase letter!', $fileName);
    }

    if (!preg_match("/[a-z]/", $password)) {
        errorSender('Password must contain at least one lowercase letter!', $fileName);
    }

    if (!preg_match("/[0-9]/", $password)) {
        errorSender('Password must contain at least one number!', $fileName);
    }

    if (strpos($password, ' ') !== false) {
        errorSender('Password must not contain spaces!', $fileName);
    }
    
    $password = password_hash(trim($password), PASSWORD_DEFAULT); 
    return $password;
}

// Function to check if a username already exists
function isUsernameExistsOtherThanMe($username, $conn, $accountID) {
    global $fileName;

    $query = "SELECT * FROM users WHERE username = ? AND id != ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $username, $accountID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if(mysqli_stmt_num_rows($stmt) > 0){
        errorSender('Username already exist!', $fileName);
    }
}

// Function to check if a school number already exists
function isSchoolNumberExistsOtherThanMe($schoolNumber, $conn, $accountID) {
    global $fileName;

    $query = "SELECT * FROM users WHERE school_number = ? AND id != ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $schoolNumber, $accountID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if(mysqli_stmt_num_rows($stmt) > 0){
        errorSender('School number already exist!', $fileName);
    }
}

// Function to check if a phone number already exists
function isPhoneNumberExistsOtherThanMe($phoneNumber, $conn, $accountID) {
    global $fileName;

    $query = "SELECT * FROM users WHERE phone = ? AND id != ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $phoneNumber, $accountID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if(mysqli_stmt_num_rows($stmt) > 0){
        errorSender('Phone number already exist!', $fileName);
    }
}
// exist other than me

