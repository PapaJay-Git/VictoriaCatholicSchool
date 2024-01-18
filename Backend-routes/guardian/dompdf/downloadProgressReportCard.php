<?php

require_once '../../../dompdf/autoload.inc.php';

use Dompdf\Dompdf;
    
try {

    require_once $_SERVER['DOCUMENT_ROOT']."/Connections/DB_connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfLoggedIn.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/Middleware/CheckIfGuardian.php";

    // validations functions
    require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_user_checker_router.php";

    $path = '../../../Resources/images/victoria.png';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $currentYear = date('Y');

    $currentMonth = date('n');

    if ($currentMonth >= 5) {
        $currentYear += 1;
    }else{
        $currentYear -= 1;
    }

    function calculateLetterGrade($percentage) {
        if ($percentage >= 90) {
            return 'A';
        } elseif ($percentage >= 85 && $percentage <= 89) {
            return 'P';
        } elseif ($percentage >= 80 && $percentage <= 84) {
            return 'AP';
        } elseif ($percentage >= 75 && $percentage <= 79) {
            return 'D';
        } elseif ($percentage > 0 && $percentage < 75) {
            return 'B';
        } else {
            return '';
        }
    }

    isGET();

    $stmt = $conn->prepare("SELECT sections.* FROM student_sections
    LEFT JOIN sections ON student_sections.section_id = sections.id
    WHERE student_sections.student_id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows <= 0){
        echo "You currrently have no section. You can go back here if admin updated your account section.";
        exit();
    }

    $section_data = $result->fetch_assoc();

    // get adviser
    $sectionID = $section_data['id'];
    $stmt = $conn->prepare("
    SELECT sections.*, users.first_name, users.middle_name, users.last_name, users.email 
    FROM sections LEFT JOIN
    users ON sections.advisory_teacher_id = users.id
    WHERE sections.id = ?");
    $stmt->bind_param("i", $sectionID);
    $stmt->execute();
    $results = $stmt->get_result();
    $adviser = $results->fetch_assoc();
    // get adviser

    $stmt = $conn->prepare("SELECT * FROM subjects  WHERE grade = ?");
    $stmt->bind_param("s", $section_data['grade']);
    $stmt->execute();
    $subjects = $stmt->get_result();

    $finalAverage = 0;
    $subjectThatHasGrade = 0;

    $subjectGrades = '';

    foreach ($subjects as $subject) {
        $stmt = $conn->prepare("SELECT * FROM student_grades  WHERE subject_id = ? AND student_id = ?");
        $stmt->bind_param("ii", $subject['id'], $student_id);
        $stmt->execute();
        $student_grades = $stmt->get_result();
        if($student_grades->num_rows <= 0){
            $subjectGrades .= '                
            <tr>
                <th class="py-2 text-xs text-center border-2 border-black" colspan="2">'.($subject['name']).'</th>
                <th class="py-2 text-xs text-center border-2 border-black" colspan="1"> </th>
                <th class="py-2 text-xs text-center border-2 border-black" colspan="1"> </th>
                <th class="py-2 text-xs text-center border-2 border-black" colspan="1"> </th>
                <th class="py-2 text-xs text-center border-2 border-black" colspan="1"> </th>
                <th class="py-2 text-xs text-center border-2 border-black" colspan="1"> </th>
                <th class="py-2 text-xs text-center border-2 border-black" colspan="1" > </th>
                <th class="py-2 text-xs text-center border-2 border-black" colspan="1">PENDING</th>
            </tr>';
        }else{
            $student_grades_row = $student_grades->fetch_assoc();

            $final = ($student_grades_row['first_quarter'] * 0.20 +
            $student_grades_row['second_quarter'] * 0.20 +
            $student_grades_row['third_quarter'] * 0.20 +
            $student_grades_row['fourth_quarter'] * 0.40);
            $finalAverage += $final;

            if($student_grades_row['first_quarter'] > 0 &&
                $student_grades_row['second_quarter'] > 0 &&
                $student_grades_row['third_quarter'] > 0 &&
                $student_grades_row['fourth_quarter'] > 0){
                    $subjectThatHasGrade++;
            }

            $final = ($student_grades_row['first_quarter'] == 0 ||
                    $student_grades_row['second_quarter'] == 0 ||
                    $student_grades_row['third_quarter'] == 0 ||
                    $student_grades_row['fourth_quarter'] == 0) ? 0 :
                    ($student_grades_row['first_quarter'] * 0.20 +
                    $student_grades_row['second_quarter'] * 0.20 +
                    $student_grades_row['third_quarter'] * 0.20 +
                    $student_grades_row['fourth_quarter'] * 0.40);

            // $first_quarter = calculateLetterGrade($student_grades_row['first_quarter']);
            // $second_quarter = calculateLetterGrade($student_grades_row['second_quarter']);
            // $third_quarter = calculateLetterGrade($student_grades_row['third_quarter']);
            // $fourth_quarter = calculateLetterGrade($student_grades_row['fourth_quarter']);
            $first_quarter = $student_grades_row['first_quarter'] == 0 ? '' : $student_grades_row['first_quarter'] ;
            $second_quarter = $student_grades_row['second_quarter'] == 0 ? '' : $student_grades_row['second_quarter'] ;
            $third_quarter = $student_grades_row['third_quarter'] == 0 ? '' : $student_grades_row['third_quarter'] ;
            $fourth_quarter = $student_grades_row['fourth_quarter'] == 0 ? '' : $student_grades_row['fourth_quarter'] ;
            
            $subjectGrades .= '                
            <tr>
                <th class="py-2 text-xs text-center border-2 border-black" colspan="2">'.($subject['name']).'</th>
                <th class="py-2 text-xs text-center border-2 border-black" colspan="1">'.$first_quarter.'</th>
                <th class="py-2 text-xs text-center border-2 border-black" colspan="1">'.$second_quarter.'</th>
                <th class="py-2 text-xs text-center border-2 border-black" colspan="1">'.$third_quarter.'</th>
                <th class="py-2 text-xs text-center border-2 border-black" colspan="1">'.$fourth_quarter.'</th>
                <th class="py-2 text-xs text-center border-2 border-black" colspan="1">'.calculateLetterGrade(number_format($final, 2)).'</th>
                <th class="py-2 text-xs text-center border-2 border-black" colspan="1" >'.number_format($final, 2).'</th>
                <th class="py-2 text-xs text-center border-2 border-black" colspan="1">'.(number_format($final, 2) > 75 ? 'PASSED' : (number_format($final, 2) == 0 ? 'PENDING' : 'FAILED')).'</th>
            </tr>';
            
        }
    } 

    
    $finalAverageResult = ($subjects->num_rows == $subjectThatHasGrade) ? number_format($finalAverage/$subjects->num_rows, 2) : 0.00 ;

    $dompdf = new Dompdf();

    $html = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PROGRESS REPORT CARD</title>
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
            .py-2 {
                padding-top: 0.50rem;
                padding-bottom: 0.50rem;
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
                padding-top: 1.5rem;
            }
            .pt-10 {
                padding-top: 2.5rem;
            }
            .pb-5 {
                padding-bottom: 0.75rem;
            }

            .text-xs {
                font-size: 0.65rem;
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
                font-size: 0.80rem;
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
                    <th class="text-center" colspan="4">
                        <img src="'.$base64.'" width="100" height="100"/>
                    </th>
                    <th class="font-bold text-start" colspan="8">
                        <div>
                            <span class="text-2xl text-center">Victoria Catholic School of Tarlac Inc.</span>
                            <br>
                            <span class="text-xs text-center">Progress Report Card</span>
                        </div>
                    </th>
                </tr>

                <tr>
                    <th class="px-1 py-2 pt-10 font-bold text-xs text-start border-b-2" colspan="2">'.($student['first_name']).'</th>
                    <th class="px-1 py-2 pt-10 font-bold text-xs text-start" colspan="1"></th>
                    <th class="px-1 py-2 pt-10 font-bold text-xs text-start border-b-2" colspan="2">'.($student['middle_name']).'</th>
                    <th class="px-1 py-2 pt-10 font-bold text-xs text-start" colspan="1"></th>
                    <th class="px-1 py-2 pt-10 font-bold text-xs text-start border-b-2" colspan="2">'.($student['last_name']).'</th>
                    <th class="px-1 py-2 pt-10 font-bold text-xs text-start" colspan="1"></th>
                    <th class="px-1 py-2 pt-10 font-bold text-xs text-start border-b-2" colspan="2">'.($student['lrn']).'</th>
                </tr>                
                <tr>
                    <th class=" py-2 font-bold text-xs text-start" colspan="2">First Name</th>
                    <th class=" py-2 font-bold text-xs text-start" colspan="1"></th>
                    <th class=" py-2 font-bold text-xs text-start" colspan="2">Middle Name</th>
                    <th class=" py-2 font-bold text-xs text-start" colspan="1"></th>
                    <th class=" py-2 font-bold text-xs text-start" colspan="2">Last Name</th>
                    <th class=" py-2 font-bold text-xs text-start" colspan="1"></th>
                    <th class=" py-2 font-bold text-xs text-start" colspan="2">LRN</th>
                </tr>


                <tr>
                    <th class="px-1 py-2 font-bold text-xs text-start border-b-2" colspan="2">'.($section_data['grade']).' '.($section_data['name']).'</th>
                    <th class="px-1 py-2 font-bold text-xs text-start" colspan="1"></th>
                    <th class="px-1 py-2 font-bold text-xs text-start border-b-2" colspan="2">'.($currentYear.'-'.$currentYear+1).'</th>
                    <th class="px-1 py-2 font-bold text-xs text-start" colspan="1"></th>
                    <th class="px-1 py-2 font-bold text-xs text-start border-b-2" colspan="2">'.($student['gender']).'</th>
                    <th class="px-1 py-2 font-bold text-xs text-start" colspan="1"></th>
                    <th class="px-1 py-2 font-bold text-xs text-start border-b-2" colspan="2">'.($student['birthday']).'</th>
                </tr>                
                <tr>
                    <th class="py-2 font-bold text-xs text-start" colspan="2">Grade/Section</th>
                    <th class="py-2 font-bold text-xs text-start" colspan="1"></th>
                    <th class="py-2 font-bold text-xs text-start" colspan="2">School Year</th>
                    <th class="py-2 font-bold text-xs text-start" colspan="1"></th>
                    <th class="py-2 font-bold text-xs text-start" colspan="2">Gender</th>
                    <th class="py-2 font-bold text-xs text-start" colspan="1"></th>
                    <th class="py-2 font-bold text-xs text-start" colspan="2">Birthday</th>
                </tr>


                <tr>
                    <th class="px-1 py-2 font-bold text-xs text-start border-b-2" colspan="11">
                    '.($student['street_no'].' '.$student['street'].' '.$student['village'].' '.$student['barangay'].', '.$student['city_municipality'].', '.$student['province'].', '.$student['zip_code']).'
                    </th>
                </tr>
                <tr>
                    <th class="py-2 font-bold text-xs text-start" colspan="11">Address</th>
                </tr>


                <tr>
                    <th class="px-1 py-2 font-bold text-xs text-start border-b-2" colspan="2">
                    '.($adviser['first_name'].' '.$adviser['middle_name'].' '.$adviser['last_name']).'
                    </th>
                </tr>
                <tr>
                    <th class="py-2 font-bold text-xs text-start" colspan="2">Adviser</th>
                </tr> 
            </thead>
        </table>
            
        <table class="min-w-full h-auto font-mono whitespace-nowrap">
            <thead>
                <tr>
                    <th class="px-1 pt-5 font-bold text-xl" colspan="11"></th>
                </tr>
            </thead>
        </table>

        <table class="min-w-full h-auto font-mono whitespace-nowrap" >
            <thead>
                <tr>
                    <th class="py-2 font-bold text-xl text-center border-2 border-black bg-gray-200" colspan="2" rowspan="2">SUBJECTS</th>
                    <th class="py-2 font-bold text-xl text-center border-2 border-black bg-gray-200" colspan="4">Quarter</th>
                    <th class="py-2 font-bold text-xs text-center border-2 border-black bg-gray-200" colspan="1" rowspan="2">Final <br>Rating</th>
                    <th class="py-2 font-bold text-xs text-center border-2 border-black bg-gray-200" colspan="1" rowspan="2">Average</th>
                    <th class="py-2 font-bold text-xs text-center border-2 border-black bg-gray-200" colspan="1" rowspan="2">Evaluation</th>
                </tr>
                <tr>
                    <th class="py-2 font-bold text-xs text-center border-2 border-black bg-gray-200" colspan="1">1</th>
                    <th class="py-2 font-bold text-xs text-center border-2 border-black bg-gray-200" colspan="1">2</th>
                    <th class="py-2 font-bold text-xs text-center border-2 border-black bg-gray-200" colspan="1">3</th>
                    <th class="py-2 font-bold text-xs text-center border-2 border-black bg-gray-200" colspan="1">4</th>
                </tr>
                '.$subjectGrades.'
                <tr>
                    <th class="py-2 text-xs font-bold text-center border-2 border-black" colspan="2">AVERAGE</th>
                    <th class="py-2 text-xs text-center border-2 border-black" colspan="1"></th>
                    <th class="py-2 text-xs text-center border-2 border-black" colspan="1"></th>
                    <th class="py-2 text-xs text-center border-2 border-black" colspan="1"></th>
                    <th class="py-2 text-xs text-center border-2 border-black" colspan="1"></th>
                    <th class="py-2 text-xs text-center border-2 border-black" colspan="1">'.calculateLetterGrade($finalAverageResult).'</th>
                    <th class="py-2 text-xs text-center border-2 border-black" colspan="1" >'.( $finalAverageResult == 0 ? 'N/A' : $finalAverageResult).'</th>
                    <th class="py-2 text-xs text-center border-2 border-black" colspan="1"></th>
                </tr>

            </thead>
        </table>



        <table class="min-w-full h-auto font-mono whitespace-nowrap">
            <thead>
                <tr>
                    <th class="px-1 py-2 pt-5 font-bold text-xl" colspan="11">AVERAGING</th>
                </tr>
            </thead>
        </table>


        <table class="min-w-full h-auto font-mono whitespace-nowrap">
            <thead>
                <tr>
                    <th class="px-1 py-2 text-xs text-start border-2 border-black" style="width: 50%;"><b>A</b> (Advanced)</th>
                    <th class="px-1 py-2 text-xs text-start border-2 border-black" style="width: 50%;">90% and above</th>
                </tr>
                <tr>
                    <th class="px-1 py-2 text-xs text-start border-2 border-black"><b>P</b> (Proficient)</th>
                    <th class="px-1 py-2 text-xs text-start border-2 border-black">85% - 89%</th>
                </tr>
                <tr>
                    <th class="px-1 py-2 text-xs text-start border-2 border-black"><b>AP</b> (Approching Proficiency)</th>
                    <th class="px-1 py-2 text-xs text-start border-2 border-black">80% - 84%</th>
                </tr>
                <tr>
                    <th class="px-1 py-2 text-xs text-start border-2 border-black"><b>D</b> (Developing)</th>
                    <th class="px-1 py-2 text-xs text-start border-2 border-black">75% - 79%</th>
                </tr>
                <tr>
                    <th class="px-1 py-2 text-xs text-start border-2 border-black"><b>B</b> (Beginning)</th>
                    <th class="px-1 py-2 text-xs text-start border-2 border-black">74% and below</th>
                </tr>
            </thead>
        </table>
    </body>
    </html>
    ';

    // echo $html;
    $dompdf->loadHtml($html);
    $dompdf->render();
    $dompdf->stream('output.pdf', array('Attachment' => 0));

} catch (Exception $e) {

    errorSender('error '.$e->getMessage(), $fileName);
}
?>

