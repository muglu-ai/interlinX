<?php

error_reporting(E_ALL);

// Same as error_reporting(E_ALL);
ini_set("error_reporting", E_ALL);
require_once 'db.php';
$response = callAPI(false);
//echo $response;
$bid = md5(date('YmdHis'). rand());
$sql = "INSERT INTO wcc_2023_reg_api_log(booking_id, email, request, created_at, ticket_type) VALUES('" . $bid . "', '" . strtolower($data['email']) . "', '" . dbMysqli_real_escape_string($response) . "', '" . date('Y-m-d H:i:s') . "', 'WCC User list API')";
dbQuery($sql);

$response = json_decode($response, true);
//print_r($response);exit;
if($response['status']) {
	foreach($response['content'] as $data) {
		//print_r($data);exit;
		$qry = dbQuery( "SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL);
		$row = dbNumRows($qry);
		
		$tin_no  = $EVENT_DB_TIN_NO;
		$tin_no1 = $res_no = "";
		
		$i = 0;
		$j = 0;
		
		$temp_srno_gt = $row+1;
		do {
			$i = $j = 0;
			
			$tin_no1 = $tin_no . $temp_srno_gt . mt_rand(1, 99999);
			
			$qry1    = dbQuery( "SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE tin_no = '$tin_no1'");
			$res_no1 = dbNumRows($qry1);
			
			if (($res_no == 0) || ($res_no1 == 0)) {
				$i++;
				$j++;
			} else {
				$i       = 0;
				$j       = 0;
				$tin_no1 = "";
			}
		} while (($i <= 0) || ($j <= 0));
		
		/*mysqli_query($link, "UPDATE " . $EVENT_DB_FORM_REG . " SET tin_no = '$tin_no1' WHERE reg_id = '$reg_id'") or die(mysql_error());*/
		
		$email1 = strtolower($data['email']);
		
		$qry_email_chk  = dbQuery("SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE pri_email = '$email1'");
		$qry_email_chk_num   = dbNumRows($qry_email_chk);
		
		if ($qry_email_chk_num >= 1) {
			   //$res = json_encode(array('message' => 'Entered email already registered with us.', 'status' => 'success', 'status_code'=>200));
			   //$sql = "update wcc_2023_reg_api_log set response='" . dbMysqli_real_escape_string($res) . "' where booking_id = '" . $bid . "'";
				//dbQuery($sql);
			   //echo $res;
			   //return;
		}else {
			//-------------------------------------------------- Generating User Id ------------------------------------------------
			$usr_no = $EVENT_TBL_PREFIX . '_' . $EVENT_YEAR . "_nrm_";
			$i_gim_inx_user_id_cnt = 0;
			do {
				$temp_no     = rand(1, 9999999);
				$temp_no_len = strlen($temp_no);
				
				if ($temp_no_len < 7) {
					$temp_no_len = 7 - $temp_no_len;
					while ($temp_no_len) {
						$temp_no = $temp_no . "0";
						$temp_no_len--;
					}
				}
				$usr_no1 = $usr_no . $temp_no;
				$qry     = dbQuery( "SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE user_id = '$usr_no1'");
				$res_no  = dbNumRows($qry);
				if ($res_no < 1) {
					$i_gim_inx_user_id_cnt++;
				} else {
					$usr_no1 = "";
				}
			} while (!($i_gim_inx_user_id_cnt == 1));
			//-------------------------------------------------End Generating User Id ------------------------------------------------
			$dele_title      = '';//$data['title'];
			$dele_fname      = dbMysqli_real_escape_string($data['name']);
			$dele_lname      = dbMysqli_real_escape_string($data['last_name']);
			$dele_desig      = dbMysqli_real_escape_string($data['designation']);
			$dele_email      = strtolower($data['email']);
			$dele_cntry_code = '';//$data['country_code'];
			$dele_mob		 = '';//$data['mobile'];
			$org 			 = dbMysqli_real_escape_string($data['organization']);
			$country 		 = '';//$data['country'];//explode(",", $org);
			/*$country = trim($contry[1]);
			 $org = trim($contry[0]);*/
			$state = $city = '';
			//$dele_cellno_arr = explode("-", $dele_cellno);
			
			$test_title = $dele_title;
			$test_fname = $dele_fname;
			$test_lname = $dele_lname;
			$test_email = $dele_email;
			
			$fname = explode(" ", $test_fname);
			$fname1 = $fname[0];
			$fone = $fax ='';
			
			$pas1_inx    = str_replace(' ', '_', $fname1) . "123";
			$pas2_inx    = md5($pas1_inx);
			$user_id_md5 = md5($usr_no1);

			$pas1_inx = '';//$data['pass1'];
			$pas2_inx = $data['pass2'];

			$temp_qr_gt_user_data_ans_row_fone_arr = explode("-", $fone);
			$temp_qr_gt_user_data_ans_row_fax_arr  = explode("-", $fax);
			$inx_reg_date = date('Y-m-d');
			$inx_reg_time = date('H:i:s');
			//------------------------------------------------- Inserting Values in interlinx registration table --------------------------------------
			dbQuery( "INSERT INTO " . $EVENT_DB_FORM_INTERLINX_REG_TBL . "
						(user_id,dup_user_id,title,fname,lname,birth_date,sex,addr1,addr2,city,state,country,pin,web_site,pri_email,sec_email,org_name,org_info,desig,mob_cntry_code,mob_number,hm_ph_cntry_code,hm_ph_area_code,hm_ph_number,fax_cntry_code,fax_area_code,fax_number,reg_cata,intr1,intr2,intr3,intr4,intr5,intr6,intr7,intr8,intr9,intr10,intr11,intr12,intr13,intr14,intr15,intr16,intr17,intr18,intr19,user_name,pass1,pass2,reg_id,vercode,photo,org_profile,inx_reg_date,inx_reg_time,tin_no) values
						('$usr_no1','$user_id_md5','$dele_title','$dele_fname','$dele_lname','','','','','$city','$state','$country','','','$dele_email','','$org','','$dele_desig','$dele_cntry_code','$dele_mob','$temp_qr_gt_user_data_ans_row_fone_arr[0]','$temp_qr_gt_user_data_ans_row_fone_arr[1]','$temp_qr_gt_user_data_ans_row_fone_arr[2]','$temp_qr_gt_user_data_ans_row_fax_arr[0]','$temp_qr_gt_user_data_ans_row_fax_arr[1]','$temp_qr_gt_user_data_ans_row_fax_arr[2]','','','','','','','','','','','','','','','','','','','','','$dele_email','$pas1_inx','$pas2_inx','','','uploads/default_file.jpg','','$inx_reg_date','$inx_reg_time','$tin_no1')") or die(mysql_error($link));
			$temp_receiver_org = '';
			$year = $EVENT_YEAR;
			$month = '09';
			$date = 26;
			dbQuery( "insert  into `" . $EVENT_DB_FORM_ALL_USERS_SCHEDULE . "` (`req_date`,`req_time`,`sender_id`,`sender_title`,`sender_fname`,`sender_lname`,`sender_org`,`sender_desig`,`sender_org_profile`,`sender_email`,`receiver_id`,`receiver_title`,`receiver_fname`,`receiver_lname`,`receiver_org`,`receiver_desig`,`receiver_org_profile`,`receiver_email`,`req_type`,`meeting_date`,`meeting_time_start`,`meeting_time_end`,`message`,`status`,`read_flag`,`table_no`) values
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
			
			$date = 27;
			dbQuery( "insert  into `" . $EVENT_DB_FORM_ALL_USERS_SCHEDULE . "` (`req_date`,`req_time`,`sender_id`,`sender_title`,`sender_fname`,`sender_lname`,`sender_org`,`sender_desig`,`sender_org_profile`,`sender_email`,`receiver_id`,`receiver_title`,`receiver_fname`,`receiver_lname`,`receiver_org`,`receiver_desig`,`receiver_org_profile`,`receiver_email`,`req_type`,`meeting_date`,`meeting_time_start`,`meeting_time_end`,`message`,`status`,`read_flag`,`table_no`) values
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


			$qry_email_chk  = dbQuery("SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE pri_email = '" . strtolower($data['email']) . "'");
			$qry_email_chk_num   = dbNumRows($qry_email_chk);
			if($qry_email_chk_num) {
				$qr_gt_user_inx_login_data_ans = dbFetchAssoc($qry_email_chk);
				include "reg_inx_emailer.php";
				$Subject     = "Thank you for Registration on " . $EVENT_NAME . "" . $EVENT_YEAR . " B2B Partnering (InterlinX)";
				echo $mail_body = $mail_interlinx_str;

				$recipients = array($qr_gt_user_inx_login_data_ans['pri_email'], '', 'test.interlinks@gmail.com', 'vivek.patil@mmactiv.com'); //, '', $EVENT_ENQUIRY_EMAIL, '', 'interlinx@outlook.com', '', '');
				//$recipients = array('vivek.patil@mmactiv.com', 'sagarpatil2112@gmail.com'); //, '', $EVENT_ENQUIRY_EMAIL, '', 'interlinx@outlook.com', '', '');
				//$recipients = array('sagarpatil2112@gmail.com');
				elastic_mail($Subject, $mail_body, $recipients);
			} 
		}
		//exit;
	}//exit;
} 



function callAPI($data, $url = '', $method = 'POST')
{
	$url = '';
	$curl = curl_init();

	switch ($method) {
		case "POST":
			curl_setopt($curl, CURLOPT_POST, 1);
			if ($data) {
				$fields_string = '';
				foreach ($data as $key => $value) {
					$fields_string .= $key . '=' . urlencode($value) . '&';
				}
				rtrim($fields_string, '&');
				curl_setopt($curl, CURLOPT_POST, count($data));
				curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
				//curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
			}
			break;
		case "PUT":
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
			if ($data)
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			break;
		default:
			if ($data)
				$url = sprintf("%s?%s", $url, http_build_query($data));
	}
	//print_r($data);
	// OPTIONS:
	curl_setopt($curl, CURLOPT_URL, $url);
	//curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

	// EXECUTE:
	$result = curl_exec($curl);

	if (!$result) {
		die("Connection Failure");
	}

	curl_close($curl);

	return $result;
}
//End of file