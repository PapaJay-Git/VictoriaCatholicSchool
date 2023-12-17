<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

try {



    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/PHPMailer/src/Exception.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/PHPMailer/src/PHPMailer.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/PHPMailer/src/SMTP.php";

    // redirection file name
    $fileName = "Location: ../../Resources/views/login/regis.php";

    $error = false;
    $fieldName = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isPOST();

    // required array

    $required_fields = ['grade', 'first_name', 'middle_name', 'last_name', 'phone', 'email', 'gender', 'birthday', 'student_type', 'street_no', 'street', 'city_municipality', 'guardian_that_will_have_an_account'];

    // required checker
    foreach ($required_fields as $field) {
        $_SESSION[$field] = sanitize_input($_POST[$field]);
        if (empty($_POST[$field])) {
            $error = true;
            $fieldName = $field;
        }
    }
    
    if($error){
        errorSender("$fieldName is required", $fileName);
    }

    $street_no = sanitize_input($_POST['street_no']);
    $street = sanitize_input($_POST['street']);
    $village = isset($_POST['village']) ? sanitize_input($_POST['village']) : NULL;
    $barangay = isset($_POST['barangay']) ? sanitize_input($_POST['barangay']) : NULL;
    $city_municipality = sanitize_input($_POST['city_municipality']);
    $province = isset($_POST['province']) ? sanitize_input($_POST['province']) : NULL;
    $zip_code = isset($_POST['zip_code']) ? sanitize_input($_POST['zip_code']) : NULL;
    $guardian_account = $_POST['guardian_that_will_have_an_account'];

    $_SESSION['village'] = $village;
    $_SESSION['barangay'] = $barangay;
    $_SESSION['province'] = $province;
    $_SESSION['zip_code'] = $zip_code;

    $_SESSION['guardian_first_name'] = isset($_POST['guardian_first_name']) ? sanitize_input($_POST['guardian_first_name']) : NULL;
    $_SESSION['guardian_middle_name'] = isset($_POST['guardian_middle_name']) ? sanitize_input($_POST['guardian_middle_name']) : NULL;
    $_SESSION['guardian_last_name'] = isset($_POST['guardian_last_name']) ? sanitize_input($_POST['guardian_last_name']) : NULL;
    $_SESSION['guardian_phone'] = isset($_POST['guardian_phone']) ? sanitize_input($_POST['guardian_phone']) : NULL;
    $_SESSION['guardian_email'] = isset($_POST['guardian_email']) ? sanitize_input($_POST['guardian_email']) : NULL;
    $_SESSION['guardian_occupation'] = isset($_POST['guardian_occupation']) ? sanitize_input($_POST['guardian_occupation']) : NULL;

    $_SESSION['mother_first_name'] = isset($_POST['mother_first_name']) ? sanitize_input($_POST['mother_first_name']) : NULL;
    $_SESSION['mother_middle_name'] = isset($_POST['mother_middle_name']) ? sanitize_input($_POST['mother_middle_name']) : NULL;
    $_SESSION['mother_last_name'] = isset($_POST['mother_last_name']) ? sanitize_input($_POST['mother_last_name']) : NULL;
    $_SESSION['mother_phone'] = isset($_POST['mother_phone']) ? sanitize_input($_POST['mother_phone']) : NULL;
    $_SESSION['mother_email'] = isset($_POST['mother_email']) ? sanitize_input($_POST['mother_email']) : NULL;
    $_SESSION['mother_occupation'] = isset($_POST['mother_occupation']) ? sanitize_input($_POST['mother_occupation']) : NULL;

    $_SESSION['father_first_name'] = isset($_POST['father_first_name']) ? sanitize_input($_POST['father_first_name']) : NULL;
    $_SESSION['father_middle_name'] = isset($_POST['father_middle_name']) ? sanitize_input($_POST['father_middle_name']) : NULL;
    $_SESSION['father_last_name'] = isset($_POST['father_last_name']) ? sanitize_input($_POST['father_last_name']) : NULL;
    $_SESSION['father_phone'] = isset($_POST['father_phone']) ? sanitize_input($_POST['father_phone']) : NULL;
    $_SESSION['father_email'] = isset($_POST['father_email']) ? sanitize_input($_POST['father_email']) : NULL;
    $_SESSION['father_occupation'] = isset($_POST['father_occupation']) ? sanitize_input($_POST['father_occupation']) : NULL;
    

    checkIfGradeIsValid($_POST['grade']);

    if($guardian_account != 'mother' && $guardian_account != 'father' && $guardian_account != 'guardian'){
        errorSender('Parent/Guardian that will have an account should only be Father, Mother or Guardian!', $fileName);
    }

    // input data
    $student_type = validate_student_type($_POST['student_type']);
    $grade = $_POST['grade'];
    $last_name = validate_name(sanitize_input($_POST['last_name']));
    $first_name = validate_name(sanitize_input($_POST['first_name']));
    $middle_name = validate_name(sanitize_input($_POST['middle_name']));
    $gender = validate_gender($_POST['gender']);
    $phone_number = validate_phone_number(sanitize_input($_POST['phone']));
    $email_address = validate_email($_POST['email']);
    $date_of_birth = validateBirthday($_POST['birthday']);
    $role = 'student';

    $default_password = strtolower($last_name)."_".date("Y", strtotime($date_of_birth));
    $password = password_hash($default_password, PASSWORD_DEFAULT); 
    
    if($student_type == 'new' && $grade != '7'){

        errorSender('New student should always be grade 7!', $fileName);
    }

    if($student_type == 'transfer' && $grade == '7'){

        errorSender('Transfer student should either be grade 8, 9, and 10!', $fileName);
    }


    $required_fields2 = [$guardian_account.'_last_name', $guardian_account.'_first_name', $guardian_account.'_middle_name', $guardian_account.'_phone', $guardian_account.'_email', $guardian_account.'_occupation'];

    // required checker
    foreach ($required_fields2 as $field2) {
        $_SESSION[$field2] = sanitize_input($_POST[$field2]);
        if (empty($_POST[$field2])) {
            $error = true;
            $fieldName = $field2;
        }
    }

    if($error){
        errorSender("$fieldName is required since $guardian_account will have the account.", $fileName);
    }

    

    $is_guardian = false;
    if($guardian_account != 'guardian'){
        
        $guardian_first_name = isset($_POST['guardian_first_name']) && trim($_POST['guardian_first_name']) != ''  ? validate_name(sanitize_input($_POST['guardian_first_name'])) : NULL;
        $guardian_middle_name = isset($_POST['guardian_middle_name']) && trim($_POST['guardian_middle_name']) != '' ? validate_name(sanitize_input($_POST['guardian_middle_name'])) : NULL;
        $guardian_last_name = isset($_POST['guardian_last_name']) && trim($_POST['guardian_last_name']) != '' ? validate_name(sanitize_input($_POST['guardian_last_name'])) : NULL;
        $guardian_phone = isset($_POST['guardian_phone']) && trim($_POST['guardian_phone']) != '' ? validate_phone_number(sanitize_input($_POST['guardian_phone'])) : NULL;
        $guardian_email = isset($_POST['guardian_email']) && trim($_POST['guardian_email']) != '' ? validate_email(sanitize_input($_POST['guardian_email'])) : NULL;
        $guardian_occupation = isset($_POST['guardian_occupation']) && trim($_POST['guardian_occupation']) != '' ? sanitize_input($_POST['guardian_occupation']) : NULL;

        if($guardian_last_name != NULL || $guardian_middle_name != NULL || $guardian_first_name != NULL || $guardian_phone != NULL || $guardian_email != NULL || $guardian_occupation != NULL){

            $required_fields2 = ['guardian_last_name', 'guardian_first_name', 'guardian_middle_name', 'guardian_phone', 'guardian_email', 'guardian_occupation'];

            // required checker
            foreach ($required_fields2 as $field2) {
                $_SESSION[$field2] = sanitize_input($_POST[$field2]);
                if (empty($_POST[$field2])) {
                    $error = true;
                    $fieldName = $field2;
                }
            }
        
            if($error){
                errorSender("All guardian fields are required since one or more fields have value.", $fileName);
            }
            
            $is_guardian = true;
        }
    }

    $is_father = false;
    if($guardian_account != 'father'){
        $father_first_name = isset($_POST['father_first_name']) && trim($_POST['father_first_name']) != '' ? validate_name(sanitize_input($_POST['father_first_name'])) : NULL;
        $father_middle_name = isset($_POST['father_middle_name']) && trim($_POST['father_middle_name']) != '' ? validate_name(sanitize_input($_POST['father_middle_name'])) : NULL;
        $father_last_name = isset($_POST['father_last_name']) && trim($_POST['father_last_name']) != '' ? validate_name(sanitize_input($_POST['father_last_name'])) : NULL;
        $father_phone = isset($_POST['father_phone']) && trim($_POST['father_phone']) != '' ? validate_phone_number(sanitize_input($_POST['father_phone'])) : NULL;
        $father_email = isset($_POST['father_email']) && trim($_POST['father_email']) != '' ? validate_email(sanitize_input($_POST['father_email'])) : NULL;
        $father_occupation = isset($_POST['father_occupation']) && trim($_POST['father_occupation']) != '' ? sanitize_input($_POST['father_occupation']) : NULL;

        if($father_last_name != NULL || $father_middle_name != NULL || $father_first_name != NULL || $father_phone != NULL || $father_email != NULL || $father_occupation != NULL){

            $required_fields2 = ['father_last_name', 'father_first_name', 'father_middle_name', 'father_phone', 'father_email', 'father_occupation'];

            // required checker
            foreach ($required_fields2 as $field2) {
                $_SESSION[$field2] = sanitize_input($_POST[$field2]);
                if (empty($_POST[$field2])) {
                    $error = true;
                    $fieldName = $field2;
                }
            }
        
            if($error){
                errorSender("All father fields are required since one or more fields have value.", $fileName);
            }
            $is_father = true;
        }
    }
        


    $is_mother = false;
    if($guardian_account != 'mother'){
        $mother_first_name = isset($_POST['mother_first_name']) && trim($_POST['mother_first_name']) != '' ? validate_name(sanitize_input($_POST['mother_first_name'])) : NULL;
        $mother_middle_name = isset($_POST['mother_middle_name']) && trim($_POST['mother_middle_name']) != '' ? validate_name(sanitize_input($_POST['mother_middle_name'])) : NULL;
        $mother_last_name = isset($_POST['mother_last_name']) && trim($_POST['mother_last_name']) != '' ? validate_name(sanitize_input($_POST['mother_last_name'])) : NULL;
        $mother_phone = isset($_POST['mother_phone']) && trim($_POST['mother_phone']) != '' ? (sanitize_input($_POST['mother_phone'])) : NULL;
        $mother_email = isset($_POST['mother_email']) && trim($_POST['mother_email']) != '' ? validate_email(sanitize_input($_POST['mother_email'])) : NULL;
        $mother_occupation = isset($_POST['mother_occupation']) && trim($_POST['mother_occupation']) != '' ? sanitize_input($_POST['mother_occupation']) : NULL;

        if($mother_last_name != NULL || $mother_middle_name != NULL || $mother_first_name != NULL || $mother_phone != NULL || $mother_email != NULL || $mother_occupation != NULL){

            $required_fields2 = ['mother_last_name', 'mother_first_name', 'mother_middle_name', 'mother_phone', 'mother_email', 'mother_occupation'];

            // required checker
            foreach ($required_fields2 as $field2) {
                $_SESSION[$field2] = sanitize_input($_POST[$field2]);
                if (empty($_POST[$field2])) {
                    $error = true;
                    $fieldName = $field2;
                }
            }
        
            if($error){
                errorSender("All mother fields are required since one or more fields have value.", $fileName);
            }
            $is_mother = true;
        }
    }



    if($_POST[$guardian_account.'_email'] == $email_address){
        errorSender($guardian_account+' account email and student email can\'t be the same!', $fileName);
    }
    
    //student

    isPhoneNumberExists($phone_number, $conn);
    
    isEmailExists($email_address, $conn);

    //student

    //parent

    isPhoneNumberExists($_POST[$guardian_account.'_phone'], $conn);
    
    isEmailExists($_POST[$guardian_account.'_email'], $conn);
    //parent

    $stmt = $conn->prepare("INSERT INTO users (first_name, middle_name, last_name, password, phone, email, gender, birthday, role, street_no, street, village, barangay, city_municipality, province, zip_code) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssssssssssss", $first_name, $middle_name, $last_name, $password, $phone_number, $email_address, $gender, $date_of_birth, $role, $street_no, $street, $village, $barangay, $city_municipality, $province, $zip_code);
    $stmt->execute();
    $studentID = $conn->insert_id;

    $stmt = $conn->prepare("INSERT INTO unregistered_students (student_id, requested_grade, student_type)
    VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $studentID, $grade, $student_type);
    $stmt->execute();

    $guardian_role = 'guardian';
    $stmt = $conn->prepare("INSERT INTO users (first_name, middle_name, last_name, password, phone, email, occupation, role, guardian_type) VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssss", $_POST[$guardian_account.'_first_name'], $_POST[$guardian_account.'_middle_name'], $_POST[$guardian_account.'_last_name'], $password, $_POST[$guardian_account.'_phone'], $_POST[$guardian_account.'_email'], $_POST[$guardian_account.'_occupation'], $guardian_role, $guardian_account);
    $stmt->execute();
    $guardianID = $conn->insert_id;

    if($is_guardian){
        $guardian_type1 = 'guardian';
        $stmt = $conn->prepare("INSERT INTO non_account_guardian (student_id, first_name, middle_name, last_name, phone, email, occupation, type) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("isssssss", $studentID, $guardian_first_name, $guardian_middle_name, $guardian_last_name, $guardian_phone, $guardian_email, $guardian_occupation, $guardian_type1);
        $stmt->execute();
    }
    if($is_mother){
        $mother_type1 = 'mother';
        $stmt = $conn->prepare("INSERT INTO non_account_guardian (student_id, first_name, middle_name, last_name, phone, email, occupation, type) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("isssssss", $studentID, $mother_first_name, $mother_middle_name, $mother_last_name, $mother_phone, $mother_email, $mother_occupation, $mother_type1);
        $stmt->execute();
    }
    if($is_father){
        $father_type1 = 'father';
        $stmt = $conn->prepare("INSERT INTO non_account_guardian (student_id, first_name, middle_name, last_name, phone, email, occupation, type) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("isssssss", $studentID, $father_first_name, $father_middle_name, $father_last_name, $father_phone, $father_email, $father_occupation, $father_type1);
        $stmt->execute();
    }

    $stmt = $conn->prepare("INSERT INTO guardians (student_id, guardian_id) VALUES (?,?)");
    $stmt->bind_param("ii", $studentID, $guardianID);
    $stmt->execute();

    $admin = 'admin';
    $cashier = 'cashier';
    $stmt = $conn->prepare("SELECT id FROM users where role = ? OR role = ?");
    $stmt->bind_param("ss", $admin, $cashier);
    $stmt->execute();
    $users = $stmt->get_result();

    $data = 'Enrollee';

    foreach($users as $user){
        $stmt = $conn->prepare("DELETE FROM notifications where notifiable_id = ? AND data = ?");
        $stmt->bind_param("is", $user['id'], $data);
        $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO notifications (data, notifiable_id) VALUES (?, ?)");
        $stmt->bind_param("si", $data, $user['id']);
        $stmt->execute();
    }                      


    function emailBody($first_name, $last_name){
        return '
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            h2 {
                color: #3498db;
            }
            h3 {
                color: #2ecc71;
            }
            h4 {
                color: #333;
            }
            li {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <h2>Hi ' . $first_name . ' ' . $last_name . ',</h2>
        <p>Thank you for filling up our enrollment form at Victoria Catholic School of Tarlac.</p>
        
        <h3>Enrollment Requirements:</h3>
        <p>We are pleased to inform you about the requirements needed for enrollment:</p>
        
        <h4>New Students:</h4>
        <ul>
            <li>Original Form 138-A</li>
            <li>Certificate of Good Moral</li>
            <li>Photocopy of Baptismal and Birth Certificate (NSO Certificate)</li>
            <li>Honorary Dismissal</li>
            <li>Previous year Report Card</li>
        </ul>
        
        <h4>Transferees:</h4>
        <ul>
            <li>Original Form 138-A</li>
            <li>Certificate of Good Moral</li>
            <li>Photocopy of Baptismal and Birth Certificate (NSO Certificate)</li>
            <li>Honorary Dismissal</li>
            <li>Previous year Report Card</li>
        </ul>
        
        <h3>Mode of Payment:</h3>
        <p>Payment should be made through the cashier\'s office only.</p>
        <p><strong>Full Payment:</strong> P21,000-23,000 tuition range</p>
        <p><strong>Down Payment:</strong> Upon Enrollment - 10% of the school\'s tuition</p>
        <p><strong>Installment:</strong> P2,875 per month</p>
        
        <p>For any further inquiries, please feel free to contact us. We look forward to welcoming you to our school community!</p>
        
        <p>Best regards,</p>
        <p>The Victoria Catholic School of Tarlac Team</p>

        <h3>NOTE:</h3>
        <h4>Kindly print this message and present it to the admin office for verification. This will serve as your stab verification.</h4>
    </body>
    </html>';
    }

    $mail1 = new PHPMailer(true);
    $mail1->isSMTP();                                       
    $mail1->Host       = 'smtp.gmail.com';                     
    $mail1->SMTPAuth   = true;                                  
    $mail1->Username   = 'vcath0011@gmail.com';                   
    $mail1->Password   = 'oghwcivzviaybxty';                      
    $mail1->SMTPSecure = 'TLS';           
    $mail1->Port       = 587;   

    $mail1->setFrom('vcath0011@gmail.com', 'Victoria Catholic School');
    $mail1->addAddress($email_address, $first_name." ".$last_name);    
    $mail1->isHTML(true);                                  
    $mail1->Subject = 'Enrollment Requirements';
    $mail1->Body = emailBody($first_name, $last_name);
    $mail1->send();

    $mail2 = new PHPMailer(true);
    $mail2->isSMTP();                                       
    $mail2->Host       = 'smtp.gmail.com';                     
    $mail2->SMTPAuth   = true;                                  
    $mail2->Username   = 'vcath0011@gmail.com';                   
    $mail2->Password   = 'oghwcivzviaybxty';                      
    $mail2->SMTPSecure = 'TLS';           
    $mail2->Port       = 587;   

    $mail2->setFrom('vcath0011@gmail.com', 'Victoria Catholic School');
    $mail2->addAddress($_POST[$guardian_account.'_email'], $_POST[$guardian_account.'_first_name']." ".$_POST[$guardian_account.'_last_name']);    
    $mail2->isHTML(true);                                  
    $mail2->Subject = 'Enrollment Requirements';
    $mail2->Body = emailBody($_POST[$guardian_account.'_first_name'], $_POST[$guardian_account.'_last_name']);
    $mail2->send();

    $stmt->close();
    $conn->close();
    
    foreach ($required_fields as $field) {
        unset($_SESSION[$field]);
    }

    unset(
        $_SESSION['village'],
        $_SESSION['barangay'],
        $_SESSION['province'],
        $_SESSION['zip_code'],
        $_SESSION['guardian_first_name'],
        $_SESSION['guardian_middle_name'],
        $_SESSION['guardian_last_name'],
        $_SESSION['guardian_phone'],
        $_SESSION['guardian_email'],
        $_SESSION['guardian_occupation'],
        $_SESSION['mother_first_name'],
        $_SESSION['mother_middle_name'],
        $_SESSION['mother_last_name'],
        $_SESSION['mother_phone'],
        $_SESSION['mother_email'],
        $_SESSION['mother_occupation'],
        $_SESSION['father_first_name'],
        $_SESSION['father_middle_name'],
        $_SESSION['father_last_name'],
        $_SESSION['father_phone'],
        $_SESSION['father_email'],
        $_SESSION['father_occupation']
    );
    

    successSender("Enrollment Form Submitted Successfully", "Location: ../../Resources/views/login/index.php");

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>