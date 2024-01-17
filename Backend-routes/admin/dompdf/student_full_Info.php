<?php

require_once '../../../dompdf/autoload.inc.php';

use Dompdf\Dompdf;
    
try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfAdmin.php";

    $dompdf = new Dompdf();

    $currentYear = date('Y');

    $currentMonth = date('n');

    if ($currentMonth >= 5) {
        $currentYear += 1;
    }else{
        $currentYear -= 1;
    }

    // redirection file name
    $fileName = "Location: ../../../Resources/views/admin/enrolled_students.php";
    $role = 'student';
    $accountID = NULL;

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    isGET();

    isGETID();

    checkIfUserExists($accountID, $role, $conn);

   
    $stmt = $conn->prepare("
    SELECT users.*, student_sections.section_id , registered_students.student_type,
    checklists.form_138, checklists.good_moral, checklists.baptisaml_of_birth,
    checklists.nso_certificate, checklists.honorary_dismissal,
    guardian_user.first_name as guardian_first_name, guardian_user.middle_name as guardian_middle_name, guardian_user.last_name as guardian_last_name, guardian_user.email as guardian_email, guardian_user.phone as guardian_phone,guardian_user.occupation as guardian_occupation, guardian_user.guardian_type as guardian_guardian_type
    FROM users 
    LEFT JOIN student_sections
    ON users.id = student_sections.student_id
    LEFT JOIN registered_students ON users.id = registered_students.student_id
    LEFT JOIN checklists ON users.id = checklists.student_id
    LEFT JOIN guardians ON users.id = guardians.student_id
    LEFT JOIN users as guardian_user ON guardians.guardian_id = guardian_user.id
    WHERE users.id = ?");
    $stmt->bind_param("s", $accountID);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    $stmt = $conn->prepare("SELECT * FROM non_account_guardian WHERE student_id = ?");
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    $parents = $stmt->get_result();

    $accountGuardian = 1;
    $nonAccountGuardian = 1;

    if(($student['guardian_first_name'] == NULL && $student['guardian_last_name'] == NULL) || ($student['guardian_first_name'] == '' && $student['guardian_last_name'] == '')){
        $accountGuardian = 0;
    }

    if($parents->num_rows <= 0){
        $nonAccountGuardian = 0;
    }

$parentHTML = '';

if($accountGuardian == 0 && $nonAccountGuardian == 0){
    $parentHTML = '
    <tr>
        <th class="px-1 py-1 pt-5 font-bold text-lg text-start" colspan="12">Parent/Guardian Information</th>
    </tr>

    <tr>
        <th class="px-1 py-1 font-bold text-xs text-start" colspan="4">First Name</th>
        <th class="px-1 py-1 font-bold text-xs text-start" colspan="4">Middle Name</th>
        <th class="px-1 py-1 font-bold text-xs text-start" colspan="4">Last Name</th>
    </tr>
    <tr>
        <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="4"></th>
        <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="4"></th>
        <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="4"></th>
    </tr>


    <tr>
        <th class="px-1 py-1 font-bold text-xs text-start" colspan="4">Phone Number</th>
        <th class="px-1 py-1 font-bold text-xs text-start" colspan="4">Email Address</th>
        <th class="px-1 py-1 font-bold text-xs text-start" colspan="4">Occupation</th>
    </tr>
    <tr>
        <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="4"></th>
        <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="4"></th>
        <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="4"></th>
    </tr>
    ';
}else{
    if($accountGuardian == 1){
        $parentHTML .= '
        <tr>
            <th class="px-1 py-1 pt-5 font-bold text-lg text-start" colspan="12">'.(ucfirst($student['guardian_guardian_type'])).' Information</th>
        </tr>
    
        <tr>
            <th class="px-1 py-1 font-bold text-xs text-start" colspan="4">First Name</th>
            <th class="px-1 py-1 font-bold text-xs text-start" colspan="4">Middle Name</th>
            <th class="px-1 py-1 font-bold text-xs text-start" colspan="4">Last Name</th>
        </tr>
        <tr>
            <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="4">'.($student['guardian_first_name']).'</th>
            <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="4">'.($student['guardian_middle_name']).'</th>
            <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="4">'.($student['guardian_last_name']).'</th>
        </tr>
    
    
        <tr>
            <th class="px-1 py-1 font-bold text-xs text-start" colspan="4">Phone Number</th>
            <th class="px-1 py-1 font-bold text-xs text-start" colspan="4">Email Address</th>
            <th class="px-1 py-1 font-bold text-xs text-start" colspan="4">Occupation</th>
        </tr>
        <tr>
            <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="4">'.($student['guardian_phone']).'</th>
            <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="4">'.($student['guardian_email']).'</th>
            <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="4">'.($student['guardian_occupation']).'</th>
        </tr>
        ';
    }

    foreach($parents as $parent){
        $parentHTML .= '
            <tr>
                <th class="px-1 py-1 pt-5 font-bold text-lg text-start" colspan="12">'.(ucfirst($parent['type'])).' Information</th>
            </tr>
        
            <tr>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="4">First Name</th>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="4">Middle Name</th>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="4">Last Name</th>
            </tr>
            <tr>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="4">'.($parent['first_name']).'</th>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="4">'.($parent['middle_name']).'</th>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="4">'.($parent['last_name']).'</th>
            </tr>
        
        
            <tr>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="4">Phone Number</th>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="4">Email Address</th>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="4">Occupation</th>
            </tr>
            <tr>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="4">'.($parent['phone']).'</th>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="4">'.($parent['email']).'</th>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="4">'.($parent['occupation']).'</th>
            </tr>
            ';
    }
}
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STUDENT FULL INTO</title>
</head>
<style>
        .h-auto {
            height: auto;
        }

        table {
            width: 100%;
            max-width: 8.5in; 
            border-collapse: collapse;
        }
        .font-mono {
            font-family: monospace;
        }

        .whitespace-nowrap {
            white-space: nowrap;
        }
        .px-1 {
            padding-left: 0.25rem;
            padding-right: 0.25rem;
        }

        .py-1 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }

        .pt-1 {
            padding-top: 0.25rem;
        }
        .pt-2 {
            padding-top: 0.50rem;
        }

        .pb-1 {
            padding-bottom: 0.25rem;
        }
        .pb-3 {
            padding-bottom: 0.50rem;
        }
        .pt-5 {
            padding-top: 0.75rem;
        }

        .text-xs {
            font-size: 0.55rem;
        }

        .font-bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-start {
            text-align: left;
            left: 0;
        }

        .col-span-2 {
            column-span: 2;
        }

        .border-2 {
            border-width: 2px;
            border-style: solid;
        }
        .border-b-2 {
            border-bottom: 2px;
            border-style: solid;
        }

        .border-black {
            border-color: #000; 
        }

        .bg-gray-200 {
            background-color: #e2e8f0;
        }

        .border-b-2 {
            border-width: 0;
            border-bottom-width: 2px;
            border-style: solid;
        }

        .whitespace-nowrap {
            white-space: nowrap;
        }

        .text-2xl {
            font-size: 1.5rem;
        }
        .text-xl {
            font-size: 1.0rem;
        }
        .text-lg {
            font-size: 0.75rem;
        }

        @page {
            size: 8.5in 11in;
            margin-left: 30px;
            margin-right: 30px;
            margin-top: 30px;

        }

        body {
            margin: 0;
            padding: 0;
        }
    </style>

<body>
    <table class="min-w-full h-auto font-mono whitespace-nowrap">
        <thead>
            <tr>
                <th class="px-1 font-bold text-2xl text-center" colspan="12">Enrolled Student Information Sheet</th>
            </tr>
            <tr>
                <th class="px-1 pt-3 pb-3 font-bold text-xs text-center" colspan="12">School Year 2023-2024</th>
            </tr>
            <tr>
                <th class="px-1 py-1 pt-5 font-bold text-xs text-start" colspan="12">
                    For your child\'s Benefit, Please keep us informed of any changes
                </th>
            </tr>

            <tr>
                <th class="px-1 py-1 font-bold text-lg text-start" colspan="12">Student Information</th>
            </tr>

            <tr>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="3">First Name</th>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="3">Middle Name</th>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="3">Last Name</th>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="3">LRN</th>
            </tr>
            <tr>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="3">'.($student['first_name']).'</th>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="3">'.($student['middle_name']).'</th>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="3">'.($student['last_name']).'</th>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="3">'.($student['lrn']).'</th>
            </tr>


            <tr>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="3">Phone Number</th>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="3">Email Address</th>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="3">Gender</th>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="3">Date of Birth</th>
            </tr>
            <tr>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="3">'.($student['phone']).'</th>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="3">'.($student['email']).'</th>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="3">'.($student['gender']).'</th>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="3">'.($student['birthday']).'</th>
            </tr>


            <tr>
                <th class="px-1 py-1 font-bold text-lg text-start" colspan="12">Address</th>
            </tr>

            <tr>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="3">Street # / Unit #</th>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="3">Street</th>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="3">Subd/Village/Bldg</th>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="3">Barangay</th>
            </tr>
            <tr>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="3">'.($student['street_no']).'</th>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="3">'.($student['street']).'</th>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="3">'.($student['village']).'</th>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="3">'.($student['barangay']).'</th>
            </tr>

            <tr>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="3">City/Municipality </th>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="3">Province</th>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="3">Zip Code</th>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="3"></th>
            </tr>
            <tr>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="3">'.($student['city_municipality']).'</th>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="3">'.($student['province']).'</th>
                <th class="px-1 py-1 font-bold text-xs text-start border-2 border-black bg-gray-200" colspan="3">'.($student['zip_code']).'</th>
                <th class="px-1 py-1 font-bold text-xs text-start" colspan="3"></th>
            </tr>
            <tr>
                <th class="px-1 py-1 pt-5 border-b-2 border-black" colspan="12"></th>
            </tr>
            '.$parentHTML.'
        </thead>
    </table>
</body>
</html>
';



$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream('output.pdf', array('Attachment' => 0));

} catch (Exception $e) {

errorSender('error '.$e->getMessage(), $fileName);
}