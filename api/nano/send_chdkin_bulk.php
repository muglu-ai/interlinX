<?php

ini_set('display_errors', 1);

//max_execution_time = 600;
it_2025_
ini_set('max_execution_tiit_2025_);

require 'db.php';

$EVENT_DB_FORM_INTERLINX_REG_TBL = 'it_2025_interlinx_reg_table';
it_2025_
$EVENT_BADGE_DATA_TBL = 'it_2025_badge_data';
it_2025_


$db_connection = $dbCon;





// Fetch data from it_2025_reg_tbl with paid or complimentary status

// $sql = "SELECT * FROM it_2025_reg_tbl WHERE pay_status IN ('Paid', 'Complimentary', 'Free') AND srno >=600";

$sql = "SELECT * FROM it_2025_reg_tbl WHERE tin_no = 'TIN-BTS2024-109079898'";

$stmt = mysqli_prepare($db_connection, $sql);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);







$total_delegates = 0;

date_default_timezone_set('Asia/Kolkata');



$sub_delegates_data = [];

//print_r($result);



//Fatal error: Uncaught TypeError: mysqli_fetch_assoc(): Argument #1 ($result) must be of type mysqli_result, bool given 

if ($result === false) {

    die('Error executing query: ' . htmlspecialchars(mysqli_error($db_connection)));

}



while ($row = mysqli_fetch_assoc($result)) {

    $lmt = (int) $row['sub_delegates'];

    $tin_no1 = $row['tin_no'];

    $total_delegates += $lmt;







    for ($i = 1; $i <= $lmt; $i++) {

        $bid = md5(date('YmdHis') . rand());

        $usr_no1 = generateUserId($EVENT_TBL_PREFIX, $EVENT_YEAR);

        $email1 = strtolower($row['email' . $i]);



        // Check if email is already registered

        $qry_email_chk = "SELECT COUNT(*) FROM $EVENT_BADGE_DATA_TBL WHERE email = ?";

        $email_stmt = mysqli_prepare($db_connection, $qry_email_chk);

        mysqli_stmt_bind_param($email_stmt, 's', $email1);

        mysqli_stmt_execute($email_stmt);

        mysqli_stmt_bind_result($email_stmt, $qry_email_chk_num);

        mysqli_stmt_fetch($email_stmt);

        mysqli_stmt_close($email_stmt); // Close the statement to free up resources



        if ($qry_email_chk_num > 0) {

            // Log the event that the email already exists but don't exit the loop

            $res = json_encode([

                'message' => "Email $email1 already registered. Skipping to next delegate.",

                'status' => 'skipped',

                'status_code' => 200

            ]);

            //updateApiLog($db_connection, $res, $bid);

            // echo $res . "<br>" . "\n";

            continue; // Skip to the next delegate if the email already exists

        } else {



            $dele_desig = mysqli_escape_string($db_connection, $row['job_title' . $i]);

            $reg_cata = mysqli_escape_string($db_connection, $row['cata' . $i]);



            $full_number = mysqli_escape_string($db_connection, $row['cellno' . $i]);
it_2025_
            list($dele_cntry_code, $dele_mob) = explode('-', $full_number);

            $org = mysqli_escape_string($db_connection, $row['org']);

            $add1 = mysqli_escape_string($db_connection, $row['addr1']);

            $add2 = mysqli_escape_string($db_connection, $row['addr2']);

            $state = mysqli_escape_string($db_connection, $row['state']);

            $country = mysqli_escape_string($db_connection, $row['country']);

            $pin = mysqli_escape_string($db_connection, $row['pin_no']);

            $tin_no1 = mysqli_escape_string($db_connection, $row['tin_no']);

            $city = mysqli_escape_string($db_connection, $row['city']);

            $name = mysqli_escape_string($db_connection, $row['fname' . $i]) . " " . mysqli_escape_string($db_connection, $row['lname' . $i]);



            $dele_email = mysqli_escape_string($db_connection, $row['email' . $i]);

            $pay_status = mysqli_escape_string($db_connection, $row['pay_status']);



            //if reg_cata is Complimentary Delegate then set the category_id to 1881

            // Complimentary Exhibitors Delegate 1885

            //Delegate 1886

            //Full Delegate 1886

            //GIA Pit_2025_877

            //Media Delegate 1887 

            // Speaker 1869



            if ($reg_cata == 'Complimentary Delegate') {

                $cata_code = 1886;

                $print = "Delegate";

            } elseif ($reg_cata == 'Complimentary Exhibitors Delegate') {

                $cata_code = 1885;

                $print = "Delegate";

            } elseif ($reg_cata == 'Delegate') {

                $cata_code = 1886;

                $print = "Delegate";

            } elseif ($reg_cata == 'Full Delegate') {

                $cata_code = 1886;

                $print = "Delegate";

            } elseif ($reg_cata == 'GIA Partner') {

                $cata_code = 1877;

                $print = "GIA Partner";

            } elseif ($reg_cata == 'Media Delegate') {

                $cata_code = 1887;

                $print = "Media";

            } elseif ($reg_cata == 'Speaker') {

                $cata_code = 1869;

                $print = "Speaker";

            } else {

                $cata_code = 1886;

                $print = "Delegate";

            }



            $sql = "INSERT INTO $EVENT_BADGE_DATA_TBL  (name, email, cata, category_id, country_code, mobile, company, designation,qsn_366,  country, tin_no, city, pay_status) 

        VALUES ('$name', '$dele_email', '$reg_cata', '$cata_code', '$dele_cntry_code', '$dele_mob', '$org', '$dele_desig','$print', '$country', '$tin_no1', '$city', '$pay_status')";

            //echo $sql;



            $result = mysqli_query($db_connection, $sql);

            if ($result === true) {

                echo "Inserted successfully for $dele_email \n";

            } else {

                echo "Error inserting data for $dele_email: " . mysqli_error($db_connection) . "\n";

                exit;

            }

















            // Insert user details into the it_2025_badge_data table













        }

    }

}



echo $total_delegates . " delegates processed successfully.\n";





function generateUserId($prefix, $year)

{

    global $db_connection;

    global $EVENT_DB_FORM_INTERLINX_REG_TBL;

    $usr_no = $prefix . '_' . $year . "_chk_";

    do {

        $temp_no = str_pad(rand(1, 9999999), 7, '0', STR_PAD_LEFT);

        $usr_no1 = $usr_no . $temp_no;



        // Check if the user_id already exists

        $qry = "SELECT COUNT(*) FROM $EVENT_DB_FORM_INTERLINX_REG_TBL WHERE user_id = ?";

        $stmt = mysqli_prepare($db_connection, $qry);

        mysqli_stmt_bind_param($stmt, 's', $usr_no1);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $res_no);

        mysqli_stmt_fetch($stmt);

    } while ($res_no > 0);



    return $usr_no1;

}



function updateApiLog($db_connection, $res, $bid)

{

    $sql = "UPDATE it_2025_reg_api_log SET response = ? WHERE booking_id = ?";

    $stmt = mysqli_prepare($db_connection, $sql);

    mysqli_stmt_bind_param($stmt, 'ss', $res, $bid);

    mysqli_stmt_execute($stmt);

}



// Function to insert user's meeting schedule with multiple dates and time slotsfunction 

function insertUserSchedule($db_connection, $usr_no1, $test_title, $test_fname, $test_lname, $test_email, $EVENT_YEAR, $org)

{

    global $EVENT_DB_FORM_ALL_USERS_SCHEDULE;

    global $EVENT_NAME;

    global $EVENT_DB_FORM_INTERLINX_REG_TBL;



    $temp_receiver_org = '';



    // Define the dates and their respective time slots for the meetings

    $dates_and_time_slots = [

        '2024-11-19' => [

            '12:00:00 pm',

            '12:30:00 pm',

            '13:00:00 pm',

            '13:30:00 pm',

            '14:00:00 pm',

            '14:30:00 pm',

            '15:00:00 pm',

            '15:30:00 pm',

            '16:00:00 pm',

            '16:30:00 pm',

            '17:00:00 pm',

            '17:30:00 pm',

            '18:00:00 pm'

        ],

        '2024-11-20' => [

            '10:00:00 am',

            '10:30:00 am',

            '11:00:00 am',

            '11:30:00 am',

            '12:00:00 pm',

            '12:30:00 pm',

            '13:00:00 pm',

            '13:30:00 pm',

            '14:00:00 pm',

            '14:30:00 pm',

            '15:00:00 pm',

            '15:30:00 pm',

            '16:00:00 pm',

            '16:30:00 pm',

            '17:00:00 pm',

            '17:30:00 pm',

            '18:00:00 pm'

        ],

        '2024-11-21' => [

            '10:00:00 am',

            '10:30:00 am',

            '11:00:00 am',

            '11:30:00 am',

            '12:00:00 pm',

            '12:30:00 pm',

            '13:00:00 pm',

            '13:30:00 pm',

            '14:00:00 pm',

            '14:30:00 pm',

            '15:00:00 pm',

            '15:30:00 pm'

        ]

    ];



    // Loop through each date and its corresponding time slots

    foreach ($dates_and_time_slots as $meeting_date => $time_slots) {

        for ($index = 0; $index < count($time_slots) - 1; $index++) {

            $time_start = $time_slots[$index];

            $time_end = $time_slots[$index + 1];



            // Insert the schedule data for each time slot using a prepared statement

            $query = "INSERT INTO `" . $EVENT_DB_FORM_ALL_USERS_SCHEDULE . "` 

                                                (`req_date`, `req_time`, `sender_id`, `sender_title`, `sender_fname`, `sender_lname`, 

                                                `sender_org`, `sender_desig`, `sender_org_profile`, `sender_email`, 

                                                `receiver_id`, `receiver_title`, `receiver_fname`, `receiver_lname`, 

                                                `receiver_org`, `receiver_desig`, `receiver_org_profile`, `receiver_email`, 

                                                `req_type`, `meeting_date`, `meeting_time_start`, `meeting_time_end`, 

                                                `message`, `status`, `read_flag`, `table_no`) 

                                                VALUES 

                                                (NULL, NULL, NULL, 

                                                '" . mysqli_real_escape_string($db_connection, "") . "', 

                                                '" . mysqli_real_escape_string($db_connection, "") . "', 

                                                '" . mysqli_real_escape_string($db_connection, "") . "', 

                                                '" . mysqli_real_escape_string($db_connection, "") . "', 

                                                '" . mysqli_real_escape_string($db_connection, "") . "', 

                                                '" . mysqli_real_escape_string($db_connection, "") . "', 

                                                '" . mysqli_real_escape_string($db_connection, "") . "', 

                                                '" . mysqli_real_escape_string($db_connection, $usr_no1) . "', 

                                                '" . mysqli_real_escape_string($db_connection, $test_title) . "', 

                                                '" . mysqli_real_escape_string($db_connection, $test_fname) . "', 

                                                '" . mysqli_real_escape_string($db_connection, $test_lname) . "', 

                                                '" . mysqli_real_escape_string($db_connection, $org) . "', 

                                                '" . mysqli_real_escape_string($db_connection, "") . "', 

                                                '" . mysqli_real_escape_string($db_connection, "") . "', 

                                                '" . mysqli_real_escape_string($db_connection, $test_email) . "', 

                                                '" . mysqli_real_escape_string($db_connection, "") . "', 

                                                '" . mysqli_real_escape_string($db_connection, $meeting_date) . "', 

                                                '" . mysqli_real_escape_string($db_connection, $time_start) . "', 

                                                '" . mysqli_real_escape_string($db_connection, $time_end) . "', 

                                                '" . mysqli_real_escape_string($db_connection, "") . "', 

                                                '', NULL, NULL)";



            $result = mysqli_query($db_connection, $query);

            // if() echo "Inserted successfully\n";



            //exit;

            if ($result === false) {

                die('mysqli_query() failed: ' . htmlspecialchars(mysqli_error($db_connection)));

            }







            // Execute the prepared statement



            if ($result === true) {

                // echo "Inserted successfully for $meeting_date . $time_start . $time_end . $test_email \n"; ;

            } else {

                //echo "Error scheduling meeting on $meeting_date: " . mysqli_error($db_connection) . "\n";

                exit;

            }



            // Close the statement to free up resources

        }

    }

}



