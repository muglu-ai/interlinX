<?php

//error_reporting(E_ALL);

error_reporting(1);





// Same as error_reporting(E_ALL);

//ini_set("error_reporting", E_ALL);

require_once 'db.php';

require_once 'jwt_utils.php';



/* header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: POST"); */



header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Headers: access");

header("Access-Control-Allow-Methods: POST");

header("Content-Type: application/json; charset=UTF-8");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, x-api-key");



/* $headers = array('alg'=>'HS256','typ'=>'JWT');

$payload = array('username'=>'WkCoCPertg8521AGDG', 'exp'=>(time() + 120));



$jwt = generate_jwt($headers, $payload);



echo $jwt; */



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $bearer_token = get_bearer_token();

    if ($bearer_token == 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6IldrQ29DUGVydGc4NTIxQUdERyIsImV4cCI6MTY5MjcyNTE3OX0.vnHj8kkQCqlTRMeN4YsufEiLddKl11Q7j0qQcBCsASY' && get_xapikey() == 'AIzaSDyD51Q_7VGymsxVBgD3Py4_8ibV3SO0') {





        //echo $bearer_token;

        //$is_jwt_valid = is_jwt_valid($bearer_token);

        //echo $is_jwt_valid;

        //exit;

        // get posted data

        //print_r($_POST);





        // print_r($data);



        $data = json_decode(file_get_contents("php://input", true), true);



        $response = [

            "message" => "Received",

            "data" => $data,

            "status" => 200

        ];



        //store the response in json format



//        file_put_contents("test.json", $response);







        // echo file_get_contents("php://input");





        $bid = md5(date('YmdHis') . rand());

        //$sql = "INSERT INTO it_2025_reg_api_log(booking_id, email, request, created_at) VALUES('" . $bid . "', '" . strtolower($data['email']) . "', '" . dbMysqli_real_escape_string(json_encode($data)) . "', '" . date('Y-m-d H:i:s') . "')";

//        dbQuery($sql);

//        exit;



        //update $EVENT_DB_FORM_REG member reg_cate where email = email

        $email = strtolower($data['email']);

        $reg_cata = $data['delegate_type'];

        echo $email;

        echo "<br>";

        echo $reg_cata;



        $email = mysqli_escape_string($dbConn, $email);

        $reg_cata = mysqli_escape_string($dbConn, $reg_cata);



        $sql = "UPDATE it_2025_interlinx_reg_table SET reg_cata = '$reg_cata' WHERE pri_email = '$email'";

        echo $sql;

        $result = dbQuery($sql);



        if($result) {

            echo "Updated";

        }

        else{

            echo "Not Updated";

        }



        $sql_up = "SELECT * from it_2025_interlinx_reg_table where pri_email = '$email'";

        $result_up = dbQuery($sql_up);

        $row = dbFetchAssoc($result_up);

        echo "<pre>";

        print_r($row);

        echo "</pre>";















        //$sql = "INSERT INTO user(username, password) VALUES('" . mysqli_real_escape_string($dbConn, $data->username) . "', '" . mysqli_real_escape_string($dbConn, $data->password) . "')";



        //$delegate_list = array(array('P. Pratham','','tester','p.pratham@bcg.com','91','7795938800','Boston Consulting Group',''));

        /* $delegate_list = array(

            //array('Vivek','Patil','Director','vivek.patil1@mmactiv.com','91','1234567890','MMActiv','')

            array($data['title'],$data['fname'],$data['lname'],$data['designation'],$data['email'],$data['country_code'],$data['mobile'],$data['organisation'],$data['country'])



        ); */

        //foreach ($delegate_list as $del) {







        /*

        /*mysqli_query($link, "insert  into " . $EVENT_DB_FORM_REG . "(title1,fname1,lname1,email1,badge1,job_title1,cellno1,org,city,state,country,org_reg_type,paymode,pay_status,sector,cata1,cata) VALUES('$title1','$fname1','$lname1','$email1','$badge1','$job_title1','$cellno1','$org','$city','$state','$country','$org_reg_type','$paymode','$pay_status','$sector','$cata1','$cata')");*/

        /*$qry = dbQuery("SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL);

        $row = dbNumRows($qry);



        $tin_no = $EVENT_DB_TIN_NO;

        $tin_no1 = $res_no = "";



        $i = 0;

        $j = 0;



        $temp_srno_gt = $row + 1;

        do {

            $i = $j = 0;



            $tin_no1 = $tin_no . $temp_srno_gt . mt_rand(1, 99999);



            $qry1 = dbQuery("SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE tin_no = '$tin_no1'");

            $res_no1 = dbNumRows($qry1);



            if (($res_no == 0) || ($res_no1 == 0)) {

                $i++;

                $j++;

            } else {

                $i = 0;

                $j = 0;

                $tin_no1 = "";

            }

        } while (($i <= 0) || ($j <= 0));



        /*mysqli_query($link, "UPDATE " . $EVENT_DB_FORM_REG . " SET tin_no = '$tin_no1' WHERE reg_id = '$reg_id'") or die(mysql_error());*/

    /*

        $email1 = strtolower($data['email']);



        $qry_email_chk = dbQuery("SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE pri_email = '$email1'");

        $qry_email_chk_num = dbNumRows($qry_email_chk);



        if ($qry_email_chk_num >= 1) {

            $res = json_encode(array('message' => 'Entered email already registered with us.', 'status' => 'success', 'status_code' => 200));

            $sql = "update it_2025_reg_api_log set response='" . dbMysqli_real_escape_string($res) . "' where booking_id = '" . $bid . "'";

            dbQuery($sql);

            echo $res;

            return;

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

            //-------------------------------------------------End Generating User Id ------------------------------------------------

            //$dele_title = $data['title'];

            $dele_title = "";

            $dele_fname = $data['first_name'];

            $dele_lname = $data['last_name'];

            $dele_desig = $data['designation'];

            $dele_email = strtolower($data['email']);

            $dele_cntry_code = $data['country_code'];

            $dele_mob = $data['phone'];

            $org = $data['company'];

//            $country = $data['country'];//explode(",", $org);

            $country = "India";

            $reg_cata = $data['delegate_type'];



            /*$country = trim($contry[1]);

             $org = trim($contry[0]);*/

           /* $state = $city = '';

            //$dele_cellno_arr = explode("-", $dele_cellno);



            $test_title = $dele_title;

            $test_fname = $dele_fname;

            $test_lname = $dele_lname;

            $test_email = $dele_email;



            $fname = explode(" ", $test_fname);

            $fname1 = $fname[0];

            $fone = $fax = '';



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

            dbQuery("INSERT INTO " . $EVENT_DB_FORM_INTERLINX_REG_TBL . "

    	            		(user_id,dup_user_id,title,fname,lname,birth_date,sex,addr1,addr2,city,state,country,pin,web_site,pri_email,sec_email,org_name,org_info,desig,mob_cntry_code,mob_number,hm_ph_cntry_code,hm_ph_area_code,hm_ph_number,fax_cntry_code,fax_area_code,fax_number,reg_cata,intr1,intr2,intr3,intr4,intr5,intr6,intr7,intr8,intr9,intr10,intr11,intr12,intr13,intr14,intr15,intr16,intr17,intr18,intr19,user_name,pass1,pass2,reg_id,vercode,photo,org_profile,inx_reg_date,inx_reg_time,tin_no) values

    	            		('$usr_no1','$user_id_md5','$dele_title','$dele_fname','$dele_lname','','','','','$city','$state','$country','','','$dele_email','','$org','','$dele_desig','$dele_cntry_code','$dele_mob','$temp_qr_gt_user_data_ans_row_fone_arr[0]','$temp_qr_gt_user_data_ans_row_fone_arr[1]','$temp_qr_gt_user_data_ans_row_fone_arr[2]','$temp_qr_gt_user_data_ans_row_fax_arr[0]','$temp_qr_gt_user_data_ans_row_fax_arr[1]','$temp_qr_gt_user_data_ans_row_fax_arr[2]','$reg_cata','','','','','','','','','','','','','','','','','','','','$dele_email','$pas1_inx','$pas2_inx','','','uploads/default_file.jpg','','$inx_reg_date','$inx_reg_time','$tin_no1')") or die(mysqli_error($link));

            $temp_receiver_org = '';

            $year = $EVENT_YEAR;

            $month = '07';

            $date = 19;

            dbQuery("insert  into `" . $EVENT_DB_FORM_ALL_USERS_SCHEDULE . "` (`req_date`,`req_time`,`sender_id`,`sender_title`,`sender_fname`,`sender_lname`,`sender_org`,`sender_desig`,`sender_org_profile`,`sender_email`,`receiver_id`,`receiver_title`,`receiver_fname`,`receiver_lname`,`receiver_org`,`receiver_desig`,`receiver_org_profile`,`receiver_email`,`req_type`,`meeting_date`,`meeting_time_start`,`meeting_time_end`,`message`,`status`,`read_flag`,`table_no`) values

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','16:00:00 pm','16:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','16:30:00 pm','17:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','17:00:00 pm','17:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','19:30:00 pm','20:00:00 pm',NULL,'',NULL,NULL), 

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','20:00:00 pm','20:30:00 pm',NULL,'',NULL,NULL)") or die(mysqli_error($dbConn));



            $date = 20;

            dbQuery("insert  into `" . $EVENT_DB_FORM_ALL_USERS_SCHEDULE . "` (`req_date`,`req_time`,`sender_id`,`sender_title`,`sender_fname`,`sender_lname`,`sender_org`,`sender_desig`,`sender_org_profile`,`sender_email`,`receiver_id`,`receiver_title`,`receiver_fname`,`receiver_lname`,`receiver_org`,`receiver_desig`,`receiver_org_profile`,`receiver_email`,`req_type`,`meeting_date`,`meeting_time_start`,`meeting_time_end`,`message`,`status`,`read_flag`,`table_no`) values

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','10:00:00 am','10:30:00 am',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','10:30:00 am','11:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','11:00:00 am','11:30:00 am',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','12:00:00 pm','12:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','12:30:00 pm','13:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','13:00:00 pm','13:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','13:30:00 pm','14:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','14:00:00 pm','14:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','14:30:00 pm','15:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','15:00:00 pm','15:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','15:30:00 pm','16:00:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','16:00:00 pm','16:30:00 pm',NULL,'',NULL,NULL),

    				(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','16:30:00 pm','17:00:00 pm',NULL,'',NULL,NULL)") or die(mysqli_error($dbConn));



            /*

            $date = 28;

            dbQuery("insert  into `" . $EVENT_DB_FORM_ALL_USERS_SCHEDULE . "` (`req_date`,`req_time`,`sender_id`,`sender_title`,`sender_fname`,`sender_lname`,`sender_org`,`sender_desig`,`sender_org_profile`,`sender_email`,`receiver_id`,`receiver_title`,`receiver_fname`,`receiver_lname`,`receiver_org`,`receiver_desig`,`receiver_org_profile`,`receiver_email`,`req_type`,`meeting_date`,`meeting_time_start`,`meeting_time_end`,`message`,`status`,`read_flag`,`table_no`) values

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

                (NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','17:00:00 pm','17:30:00 pm',NULL,'',NULL,NULL)") or die(mysql_error($link));

            //------------------------------------------------- end Inserting Values in interlinx registration table --------------------------------------

            /*,

             (NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','17:30:00 pm','18:00:00 pm',NULL,'',NULL,NULL),

             (NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','18:00:00 pm','18:30:00 pm',NULL,'',NULL,NULL),

             (NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$usr_no1','$test_title','$test_fname','$test_lname','$temp_receiver_org',NULL,NULL,'$test_email',NULL,'$year-$month-$date','18:30:00 pm','19:00:00 pm',NULL,'',NULL,NULL)*/

        }



        //}

        //$result = dbQuery($sql);

      /*  $qry_email_chk = dbQuery("SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE pri_email = '" . strtolower($data['email']) . "'");

        $qry_email_chk_num = dbNumRows($qry_email_chk);

        if ($qry_email_chk_num) {

            $qr_gt_user_inx_login_data_ans = dbFetchAssoc($qry_email_chk);

            include "reg_inx_emailer.php";

            $Subject = "Thank you for Registration for " . $EVENT_NAME . " " . $EVENT_YEAR . " B2B Partnering (InterlinX)";

            $mail_body = $mail_interlinx_str;



            $recipients = array($qr_gt_user_inx_login_data_ans['pri_email'], '', 'test.interlinks@gmail.com', 'vivek.patil@mmactiv.com'); //, '', $EVENT_ENQUIRY_EMAIL, '', 'interlinx@outlook.com', '', '');

            //elastic_mail($Subject, $mail_body, $recipients);



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



    }*/ else {

        $res = json_encode(array('message' => 'Unauthorized', 'status' => 'error', 'status_code' => 401));

        echo $res;

    }

}

else{

    $res = json_encode(array('message' => 'Method Not Allowed', 'status' => 'error', 'status_code'=> 405 ));

}



//End of file