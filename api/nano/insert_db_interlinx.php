<?php

ini_set('display_errors', 0);

//max_execution_time = 600;

ini_set('max_execution_time', 300);

require 'db.php';


$EVENT_DB_FORM_INTERLINX_REG_TBL = 'it_2025_interlinx_reg_table';



$db_connection = $dbCon;





// Fetch data from it_2025_reg_tbl with paid or complimentary status

$sql = "SELECT * FROM it_2025_reg_tbl WHERE pay_status IN ('Paid', 'Complimentary', 'Free') LIMIT 250 OFFSET 350";

//$sql  = "select * from it_2025_reg_tbl where email1 = 'manishk_sharma@outlook.com'";

$stmt = mysqli_prepare($db_connection, $sql);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);



$total_delegates = 0;

date_default_timezone_set('Asia/Kolkata');



$sub_delegates_data = [];



while ($row = mysqli_fetch_assoc($result)) {

    $lmt = (int)$row['sub_delegates'];

    $tin_no1 = $row['tin_no'];

    $total_delegates += $lmt;



    for ($i = 1; $i <= $lmt; $i++) {

        $bid = md5(date('YmdHis') . rand());

        $usr_no1 = generateUserId($EVENT_TBL_PREFIX, $EVENT_YEAR);

        $email1 = strtolower($row['email' . $i]);



        // Check if email is already registered

        $qry_email_chk = "SELECT COUNT(*) FROM $EVENT_DB_FORM_INTERLINX_REG_TBL WHERE pri_email = ?";

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

            echo $res . "<br>" . "\n";

            continue; // Skip to the next delegate if the email already exists

        } else {



            $inx_reg_date = date('Y-m-d');

            $inx_reg_time = date('H:i:s');

            $dele_title = $row['title' . $i];

            $dele_fname = $row['fname' . $i];

            $dele_lname = $row['lname' . $i];

            $dele_desig = $row['job_title' . $i];

            $reg_cata = $row['cata' . $i];

            $full_number = $row['cellno' . $i];

            list($dele_cntry_code, $dele_mob) = explode('-', $full_number);

    

            $org = $row['org'];

            $add1 = $row['addr1'];

            $add2 = $row['addr2'];

            $city = $row['city'];

            $state = $row['state'];

            $country = $row['country'];

            $pin = $row['pin'];

    

            // Generate a password hash for the user

            $fname = explode(" ", $dele_fname);

            $fname1 = $fname[0];

            $pas1_inx = str_replace(' ', '_', $fname1) . "123";

            $pas2_inx = password_hash($pas1_inx, PASSWORD_BCRYPT);

            $user_id_md5 = md5($usr_no1);

            $dele_email = $row['email' . $i];

    

            // Insert user details into the registration table

            $query = "INSERT INTO " . $EVENT_DB_FORM_INTERLINX_REG_TBL . "

    	            		(user_id,dup_user_id,title,fname,lname,birth_date,sex,addr1,addr2,city,state,country,pin,web_site,pri_email,sec_email,

                            org_name,org_info,desig,mob_cntry_code,mob_number,hm_ph_cntry_code,hm_ph_area_code,hm_ph_number,fax_cntry_code,

                            fax_area_code,fax_number,reg_cata,intr1,intr2,intr3,intr4,intr5,intr6,intr7,intr8,intr9,intr10,intr11,intr12,

                            intr13,intr14,intr15,intr16,intr17,intr18,intr19,user_name,pass1,pass2,reg_id,vercode,photo,org_profile,inx_reg_date,

                            inx_reg_time,tin_no) values

    	            		('$usr_no1','$user_id_md5','$dele_title','$dele_fname','$dele_lname','','','$add1','$add2','$city','$state','$country',

                            '','','$dele_email','','$org','','$dele_desig','$dele_cntry_code','$dele_mob','$temp_qr_gt_user_data_ans_row_fone_arr[0]',

                            '$temp_qr_gt_user_data_ans_row_fone_arr[1]','$temp_qr_gt_user_data_ans_row_fone_arr[2]','$temp_qr_gt_user_data_ans_row_fax_arr[0]',

                            '$temp_qr_gt_user_data_ans_row_fax_arr[1]','$temp_qr_gt_user_data_ans_row_fax_arr[2]','$reg_cata','','','','','','','','','','','','','',

                            '','','','','','','$dele_email','$pas1_inx','$pas2_inx','','','uploads/default_file.jpg','','$inx_reg_date','$inx_reg_time','$tin_no1')";

                if (mysqli_query($db_connection, $query)) {



                    //send mail to user

                    $qry_email_chk = dbQuery("SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE pri_email = '" . strtolower($dele_email) . "'");

                $qry_email_chk_num = dbNumRows($qry_email_chk);

                if ($qry_email_chk_num) {

                    $qr_gt_user_inx_login_data_ans = dbFetchAssoc($qry_email_chk);

                    include "reg_inx_emailer.php";

                    $Subject = "Thank you for Registration for " . $EVENT_NAME . " " . $EVENT_YEAR . " B2B Partnering (InterlinX)";

                    $mail_body = $mail_interlinx_str;



                    $recipients = array($qr_gt_user_inx_login_data_ans['pri_email'], '', 'test.interlinks@gmail.com');

                    elastic_mail($Subject, $mail_body, $recipients);

                    echo $mail_body . "<br>" . "\n";

                    echo "Scheduled meeting successfully.\n";

                }

            // Insert user details into the Interlinx registration table

                echo "Inserting user details for $email1\n" . "<br>";







            //insert into 



            insertUserSchedule($db_connection, $usr_no1, $row['title' . $i], $row['fname' . $i], $row['lname' . $i], $email1, $EVENT_YEAR, $row['org'] );

            }

        }

    }

}

echo $total_delegates . " delegates processed successfully.\n";





function generateUserId($prefix, $year)

{

    global $db_connection;

    global $EVENT_DB_FORM_INTERLINX_REG_TBL;

    $usr_no = $prefix . '_' . $year . "_nrm_";

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

    GLOBAL $EVENT_DB_FORM_ALL_USERS_SCHEDULE;

    GLOBAL $EVENT_NAME;

    GLOBAL $EVENT_DB_FORM_INTERLINX_REG_TBL;



    $temp_receiver_org = '';



    // Define the dates and their respective time slots for the meetings

    $dates_and_time_slots = [

        '2025-11-18' => [

            '12:00:00 pm', '12:30:00 pm', '13:00:00 pm', '13:30:00 pm', '14:00:00 pm',

            '14:30:00 pm', '15:00:00 pm', '15:30:00 pm', '16:00:00 pm', '16:30:00 pm',

            '17:00:00 pm', '17:30:00 pm', '18:00:00 pm'

        ],

        '2025-11-19' => [

            '10:00:00 am', '10:30:00 am', '11:00:00 am', '11:30:00 am', '12:00:00 pm',

            '12:30:00 pm', '13:00:00 pm', '13:30:00 pm', '14:00:00 pm', '14:30:00 pm',

            '15:00:00 pm', '15:30:00 pm', '16:00:00 pm', '16:30:00 pm', '17:00:00 pm',

            '17:30:00 pm', '18:00:00 pm'

        ],

        '2025-11-20' => [

            '10:00:00 am', '10:30:00 am', '11:00:00 am', '11:30:00 am', '12:00:00 pm',

            '12:30:00 pm', '13:00:00 pm', '13:30:00 pm', '14:00:00 pm', '14:30:00 pm',

            '15:00:00 pm', '15:30:00 pm', '16:00:00 pm',

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

       

            if ($result ===true) {

               // echo "Inserted successfully for $meeting_date . $time_start . $time_end . $test_email \n"; ;

            } else {

                //echo "Error scheduling meeting on $meeting_date: " . mysqli_error($db_connection) . "\n";

                exit;

            }



             // Close the statement to free up resources

        }

    }

}



