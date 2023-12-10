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
    $required_fields = [
        'student_type',
        'grade',
        'last_name',
        'first_name',
        'middle_name',
        'gender',
        'birthday',
        'phone',
        'email',
        'address',
        'guardian_last_name',
        'guardian_first_name',
        'guardian_middle_name',
        'guardian_phone',
        'guardian_email',
        'guardian_occupation',
        'username',
        'guardian_username'
    ];
    

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
    checkIfGradeIsValid($_POST['grade']);

    // input data
    $default_password = "P@ssword123";
    $student_type = validate_student_type($_POST['student_type']);
    $grade = $_POST['grade'];
    $last_name = validate_name(sanitize_input($_POST['last_name']));
    $first_name = validate_name(sanitize_input($_POST['first_name']));
    $middle_name = validate_name(sanitize_input($_POST['middle_name']));
    $gender = validate_gender($_POST['gender']);
    $username = validate_username(sanitize_input($_POST['username']));
    $password = password_hash($default_password, PASSWORD_DEFAULT); 
    $address = sanitize_input($_POST['address']);
    $phone_number = validate_phone_number(sanitize_input($_POST['phone']));
    $email_address = validate_email($_POST['email']);
    $date_of_birth = validateBirthday($_POST['birthday']);
    $role = 'student';
    
    $guardian_last_name = validate_name(sanitize_input($_POST['guardian_last_name']));
    $guardian_first_name = validate_name(sanitize_input($_POST['guardian_first_name']));
    $guardian_middle_name = validate_name(sanitize_input($_POST['guardian_middle_name']));
    $guardian_phone_number = validate_phone_number(sanitize_input($_POST['guardian_phone']));
    $guardian_email = validate_email($_POST['guardian_email']);
    $guardian_occupation = sanitize_input($_POST['guardian_occupation']);
    $guardian_username = validate_username(sanitize_input($_POST['guardian_username']));
    $guardian_role = 'guardian';
    
    //student
    isUsernameExists($username, $conn);

    isPhoneNumberExists($phone_number, $conn);
    
    isEmailExists($email_address, $conn);

    //student

    //parent
    isUsernameExists($username, $conn);

    isPhoneNumberExists($guardian_phone_number, $conn);
    
    isEmailExists($guardian_email, $conn);
    //parent

    $stmt = $conn->prepare("INSERT INTO users (first_name, middle_name, last_name, username, password, address, phone, email, gender, birthday, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $first_name, $middle_name, $last_name, $username, $password, $address, $phone_number, $email_address, $gender, $date_of_birth, $role);
    $stmt->execute();
    $studentID = $conn->insert_id;

    $stmt = $conn->prepare("INSERT INTO unregistered_students (student_id, requested_grade, student_type)
    VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $studentID, $grade, $student_type);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO users (first_name, middle_name, last_name, username, password, phone, email, occupation, role) VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssss", $guardian_first_name, $guardian_middle_name, $guardian_last_name, $guardian_username, $password, $guardian_phone_number, $guardian_email, $guardian_occupation, $guardian_role);
    $stmt->execute();
    $guardianID = $conn->insert_id;

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
    
    // $mail = new PHPMailer(true);
    // $mail->isSMTP();                                       
    // $mail->Host       = 'smtp.gmail.com';                     
    // $mail->SMTPAuth   = true;                                  
    // $mail->Username   = 'vcath0011@gmail.com';                   
    // $mail->Password   = 'oghwcivzviaybxty';                      
    // $mail->SMTPSecure = 'TLS';           
    // $mail->Port       = 587;                          

    // $mail->setFrom('vcath0011@gmail.com', 'Victoria Catholic School');
    // $mail->addAddress($email_address, $first_name." ".$last_name);    
    // $mail->isHTML(true);                                  
    // $mail->Subject = 'Enrollment Requirements';
    // $mail->Body = '
    // <html>
    // <head>
    //     <style>
    //         body {
    //             font-family: Arial, sans-serif;
    //         }
    //         h2 {
    //             color: #3498db;
    //         }
    //         h3 {
    //             color: #2ecc71;
    //         }
    //         h4 {
    //             color: #333;
    //         }
    //         li {
    //             margin-bottom: 10px;
    //         }
    //     </style>
    // </head>
    // <body>
    //     <h2>Hi ' . $first_name . ' ' . $last_name . ',</h2>
    //     <p>Thank you for filling up our enrollment form at Victoria Catholic School of Tarlac.</p>
        
    //     <h3>Enrollment Requirements:</h3>
    //     <p>We are pleased to inform you about the requirements needed for enrollment:</p>
        
    //     <h4>New Students:</h4>
    //     <ul>
    //         <li>Original Form 138-A</li>
    //         <li>Certificate of Good Moral</li>
    //         <li>Photocopy of Baptismal and Birth Certificate (NSO Certificate)</li>
    //         <li>Honorary Dismissal</li>
    //         <li>Previous year Report Card</li>
    //     </ul>
        
    //     <h4>Transferees:</h4>
    //     <ul>
    //         <li>Original Form 138-A</li>
    //         <li>Certificate of Good Moral</li>
    //         <li>Photocopy of Baptismal and Birth Certificate (NSO Certificate)</li>
    //         <li>Honorary Dismissal</li>
    //         <li>Previous year Report Card</li>
    //     </ul>
        
    //     <h3>Mode of Payment:</h3>
    //     <p>Payment should be made through the cashier\'s office only.</p>
    //     <p><strong>Full Payment:</strong> P21,000-23,000 tuition range</p>
    //     <p><strong>Down Payment:</strong> Upon Enrollment - 10% of the school\'s tuition</p>
    //     <p><strong>Installment:</strong> P2,875 per month</p>
        
    //     <p>For any further inquiries, please feel free to contact us. We look forward to welcoming you to our school community!</p>
        
    //     <p>Best regards,</p>
    //     <p>The Victoria Catholic School of Tarlac Team</p>

    //     <h3>NOTE:</h3>
    //     <h4>Kindly print this message and present it to the admin office for verification. This will serve as your stab verification.</h4>
    // </body>
    // </html>';


    // $mail->send();

    $stmt->close();
    $conn->close();
    
    successSender("Enrollment Form Submitted Successfully", "Location: ../../Resources/views/login/index.php");

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}

?>