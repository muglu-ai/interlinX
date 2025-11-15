<?php
set_time_limit(0);
ini_set('max_execution_time', 0);
ini_set('display_errors', 1);

require 'db.php';



$db_connection = $dbCon;

// Fetch delegates with Paid / Complimentary / Free - we'll handle category exclusion in the loop
$sql = "SELECT * FROM it_2025_reg_tbl WHERE pay_status IN ('Paid','Complimentary','Free') AND delegate_flag = 'Yes' AND cata not like '%FMC%' order by srno desc";
// echo $sql;
$result = mysqli_query($db_connection, $sql) or die(mysqli_error($db_connection));

// print_r($result);

$total_delegates = 0;



//set default timezone as Asia/Kolkata

date_default_timezone_set('Asia/Kolkata');



// Create an array to hold the sub-delegate information

$sub_delegates_data = array();

//require 'send.php';

$sub_delegates = 0;

while ($row = mysqli_fetch_assoc($result)) {
    
    // Skip records with excluded FMC pass categories
    $excluded_categories = array('FMC Premium Delegate Pass', 'FMC GO Pass', 'FMC Delegate Pass');
    if (in_array($row['cata'], $excluded_categories)) {
        echo "Skipping record with category: " . $row['cata'] . "\n";
        continue; // Skip this iteration and move to the next record
    }

    $lmt = $row['sub_delegates']; // Assuming there are 4 sub-delegates

    // Loop through the sub-delegates (assuming there are 4)

    $tin_no1 = $row['tin_no'];

    //echo $tin_no1;



    $total_delegates += $sub_delegates;

   

    for ($i = 1; $i <= $lmt; $i++) {

        // Save loop counter before it gets modified
        $loop_index = $i;

        $bid = md5(date('YmdHis') . rand());

        $qry2 = dbQuery("SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL);

        

        $row2 = dbNumRows($qry2);



        $tin_no = $EVENT_DB_TIN_NO;

        $tin_no1 = "";

        $res_no = 0;



        $tin_check_i = 0;

        $tin_check_j = 0;



        $temp_srno_gt = $row2 + 1;

        do {

            $tin_check_i = $tin_check_j = 0;



            $tin_no1 = $tin_no . $temp_srno_gt . mt_rand(1, 99999);



            $qry1 = dbQuery("SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE tin_no = '$tin_no1'");

            $res_no1 = dbNumRows($qry1);



            if (($res_no == 0) || ($res_no1 == 0)) {

                $tin_check_i++;

                $tin_check_j++;

            } else {

                $tin_check_i = 0;

                $tin_check_j = 0;

                $tin_no1 = "";

            }

        } while (($tin_check_i <= 0) || ($tin_check_j <= 0));



        /*mysqli_query($link, "UPDATE " . $EVENT_DB_FORM_REG . " SET tin_no = '$tin_no1' WHERE reg_id = '$reg_id'") or die(mysql_error());*/



        $email1 = strtolower($row['email'. $loop_index]);



        $qry_email_chk = dbQuery("SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE pri_email = '$email1'");

        $qry_email_chk_num = dbNumRows($qry_email_chk);



        if ($qry_email_chk_num >= 1) {

            $res = json_encode(array('message' => 'Entered email already registered with us.', 'status' => 'success', 'status_code' => 200));

            $sql = "update it_2025_reg_api_log set response='" . dbMysqli_real_escape_string($res) . "' where booking_id = '" . $bid . "'";

            dbQuery($sql);

            echo $res;

            // exit;
            continue;

        } else {

            //-------------------------------------------------- Generating User Id ------------------------------------------------

            $usr_no = $EVENT_TBL_PREFIX . '_' . $EVENT_YEAR . "_nrm_";

            $i_gim_inx_user_id_cnt = 0;

            do {

                $temp_no = rand(1, 9999999);

                $temp_no_len = strlen($temp_no);



                if ($temp_no_len < 7) {

                    $temp_no_len = 7 - $temp_no_len;

                    while ($temp_no_len) {

                        $temp_no = $temp_no . "0";

                        $temp_no_len--;

                    }

                }

                $usr_no1 = $usr_no . $temp_no;

                $qry = dbQuery("SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE user_id = '$usr_no1'");

                $res_no = dbNumRows($qry);

                if ($res_no < 1) {

                    $i_gim_inx_user_id_cnt++;

                } else {

                    $usr_no1 = "";

                }

            } while (!($i_gim_inx_user_id_cnt == 1));

        }

            //-------------------------------------------------End Generating User Id ------------------------------------------------

             $dele_title = $row['title' . $loop_index];

            //$dele_title = "";

             $dele_fname = $row['fname'. $loop_index];

             $dele_lname = $row['lname'. $loop_index];

             $dele_desig = $row['job_title'. $loop_index];

             $dele_email = strtolower($row['email'. $loop_index]);

            $reg_cata = $row['cata'. $loop_index];

            $full_number = $row['cellno' . $loop_index];

            list($dele_cntry_code, $dele_mob) = explode('-', $full_number);

            // $dele_cntry_code;

            //echo "<br>" . $dele_mob;

             $org = $row['org'];

             $add1 = $row['addr1'];

             $add2 = $row['addr2'];

             $city = $row['city'];

             $state = $row['state'];

             $country = $row['country'];

             $pin = $row['pin'];





           









            /*$country = trim($contry[1]);

             $org = trim($contry[0]);*/

            //$state = $city = '';

            //$dele_cellno_arr = explode("-", $dele_cellno);



            $test_title = $dele_title;

            $test_fname = $dele_fname;

            $test_lname = $dele_lname;

            $test_email = $dele_email;



            $fname = explode(" ", $test_fname);

            $fname1 = $fname[0];

            $fone = $fax = '';

            $fname1 = $dele_fname;



            $pas1_inx = str_replace(' ', '_', $fname1) . "123";

            $pas2_inx = password_hash($pas1_inx, PASSWORD_BCRYPT);

            $user_id_md5 = md5($usr_no1);







            // $pas1_inx = $data['pass1'];

            //$pas2_inx = $data['pass2'];



            $temp_qr_gt_user_data_ans_row_fone_arr = explode("-", $fone);

            $temp_qr_gt_user_data_ans_row_fax_arr = explode("-", $fax);

            $inx_reg_date = date('Y-m-d');

            $inx_reg_time = date('H:i:s');

            //------------------------------------------------- Inserting Values in interlinx registration table --------------------------------------

            $insert_result = dbQuery("INSERT INTO " . $EVENT_DB_FORM_INTERLINX_REG_TBL . "

    	            		(user_id,dup_user_id,title,fname,lname,birth_date,sex,addr1,addr2,city,state,country,pin,web_site,pri_email,sec_email,org_name,org_info,desig,mob_cntry_code,mob_number,hm_ph_cntry_code,hm_ph_area_code,hm_ph_number,fax_cntry_code,fax_area_code,fax_number,reg_cata,intr1,intr2,intr3,intr4,intr5,intr6,intr7,intr8,intr9,intr10,intr11,intr12,intr13,intr14,intr15,intr16,intr17,intr18,intr19,user_name,pass1,pass2,reg_id,vercode,photo,org_profile,inx_reg_date,inx_reg_time,tin_no) values

    	            		('$usr_no1','$user_id_md5','$dele_title','$dele_fname','$dele_lname','','','$add1','$add2','$city','$state','$country','','','$dele_email','','$org','','$dele_desig','$dele_cntry_code','$dele_mob','$temp_qr_gt_user_data_ans_row_fone_arr[0]','$temp_qr_gt_user_data_ans_row_fone_arr[1]','$temp_qr_gt_user_data_ans_row_fone_arr[2]','$temp_qr_gt_user_data_ans_row_fax_arr[0]','$temp_qr_gt_user_data_ans_row_fax_arr[1]','$temp_qr_gt_user_data_ans_row_fax_arr[2]','$reg_cata','','','','','','','','','','','','','','','','','','','','$dele_email','$pas1_inx','$pas2_inx','','','uploads/default_file.jpg','','$inx_reg_date','$inx_reg_time','$tin_no1')");
            
            if (!$insert_result) {
                error_log("Database insert failed for user: $usr_no1. Error: " . (function_exists('mysqli_error') ? mysqli_error($db_connection) : 'Unknown error'));
                continue; // Skip to next iteration if insert fails
            }

            $temp_receiver_org = '';

            $year = $EVENT_YEAR;

            $month = '11';

            

        $date = "18";

        $schedule_result1 = dbQuery("insert  into `" . $EVENT_DB_FORM_ALL_USERS_SCHEDULE . "` (`req_date`,`req_time`,`sender_id`,`sender_title`,`sender_fname`,`sender_lname`,`sender_org`,`sender_desig`,`sender_org_profile`,`sender_email`,`receiver_id`,`receiver_title`,`receiver_fname`,`receiver_lname`,`receiver_org`,`receiver_desig`,`receiver_org_profile`,`receiver_email`,`req_type`,`meeting_date`,`meeting_time_start`,`meeting_time_end`,`message`,`status`,`read_flag`,`table_no`) values

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','12:00:00 pm','12:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','12:30:00 pm','13:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','13:00:00 pm','13:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','13:30:00 pm','14:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','14:00:00 pm','14:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','14:30:00 pm','15:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','15:00:00 pm','15:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','15:30:00 pm','16:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','16:00:00 pm','16:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','16:30:00 pm','17:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','17:00:00 pm','17:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','17:30:00 pm','18:00:00 pm',NULL,'',NULL,NULL)");
        
        if (!$schedule_result1) {
            error_log("Schedule insert failed for user: $usr_no1 on date $date");
        }

        $date = "19";

        $schedule_result2 = dbQuery("insert  into `" . $EVENT_DB_FORM_ALL_USERS_SCHEDULE . "` (`req_date`,`req_time`,`sender_id`,`sender_title`,`sender_fname`,`sender_lname`,`sender_org`,`sender_desig`,`sender_org_profile`,`sender_email`,`receiver_id`,`receiver_title`,`receiver_fname`,`receiver_lname`,`receiver_org`,`receiver_desig`,`receiver_org_profile`,`receiver_email`,`req_type`,`meeting_date`,`meeting_time_start`,`meeting_time_end`,`message`,`status`,`read_flag`,`table_no`) values

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','10:00:00 am','10:30:00 am',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','10:30:00 am','11:00:00 am',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','11:00:00 am','11:30:00 am',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','11:30:00 am','12:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','12:00:00 pm','12:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','12:30:00 pm','13:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','13:00:00 pm','13:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','13:30:00 pm','14:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','14:00:00 pm','14:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','14:30:00 pm','15:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','15:00:00 pm','15:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','15:30:00 pm','16:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','16:00:00 pm','16:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','16:30:00 pm','17:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','17:00:00 pm','17:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','17:30:00 pm','18:00:00 pm',NULL,'',NULL,NULL)");
        
        if (!$schedule_result2) {
            error_log("Schedule insert failed for user: $usr_no1 on date $date");
        }



            

            $date = "20";

        $schedule_result3 = dbQuery("insert  into `" . $EVENT_DB_FORM_ALL_USERS_SCHEDULE . "` (`req_date`,`req_time`,`sender_id`,`sender_title`,`sender_fname`,`sender_lname`,`sender_org`,`sender_desig`,`sender_org_profile`,`sender_email`,`receiver_id`,`receiver_title`,`receiver_fname`,`receiver_lname`,`receiver_org`,`receiver_desig`,`receiver_org_profile`,`receiver_email`,`req_type`,`meeting_date`,`meeting_time_start`,`meeting_time_end`,`message`,`status`,`read_flag`,`table_no`) values

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','10:00:00 am','10:30:00 am',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','10:30:00 am','11:00:00 am',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','11:00:00 am','11:30:00 am',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','11:30:00 am','12:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','12:00:00 pm','12:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','12:30:00 pm','13:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','13:00:00 pm','13:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','13:30:00 pm','14:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','14:00:00 pm','14:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','14:30:00 pm','15:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','15:00:00 pm','15:30:00 pm',NULL,'',NULL,NULL),

                    (NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','15:30:00 pm','16:00:00 pm',NULL,'',NULL,NULL)");
        
        if (!$schedule_result3) {
            error_log("Schedule insert failed for user: $usr_no1 on date $date");
        }



            



        //}

      

        $qry_email_chk = dbQuery("SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE pri_email = '" . strtolower($dele_email) . "'");

        $qry_email_chk_num = dbNumRows($qry_email_chk);

        if ($qry_email_chk_num) {

            $qr_gt_user_inx_login_data_ans = dbFetchAssoc($qry_email_chk);

            include "reg_inx_emailer.php";

            $Subject = "Thank you for Registration for " . $EVENT_NAME . " " . $EVENT_YEAR . " B2B Partnering (InterlinX)";

            $mail_body = $mail_interlinx_str;



            $recipients = array( $qr_gt_user_inx_login_data_ans['pri_email'], '', 'test.interlinks@gmail.com', ''); //, '', $EVENT_ENQUIRY_EMAIL, '', 'interlinx@outlook.com', '', '');

            $mail_result = elastic_mail($Subject, $mail_body, $recipients);
            
            if (!$mail_result) {
                error_log("Email sending failed for user: " . $qr_gt_user_inx_login_data_ans['pri_email']);
            }



            $res = json_encode(array('message' => 'You have successfully registered.', 'status' => 'success', 'status_code' => 200));

            $sql = "update it_2025_reg_api_log set response='" . dbMysqli_real_escape_string($res) . "' where booking_id = '" . $bid . "'";

            dbQuery($sql);

            echo $res;

        } else {

            $res = json_encode(array('message' => 'Something went wrong, please contact administrator', 'status' => 'error', 'status_code' => 200));

            $sql = "update it_2025_reg_api_log set response='" . dbMysqli_real_escape_string($res) . "' where booking_id = '" . $bid . "'";

            dbQuery($sql);

            echo $res;

        }







        

    }

}

echo $total_delegates;



// Convert the array to JSON and output it

//echo json_encode($sub_delegates_data);

//echo $total_delegates;

// Close the connection

mysqli_close($db_connection);



?>

