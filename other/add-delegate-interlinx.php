<?php

	//require("includes/form_constants_both.php");
	require "dbcon_open.php";
	//require "class.phpmailer.php";

	exit;

	/*$title1 = 'Mr.';
	$fname1 = 'tester1';
	$lname1 = 'tester1';
	$email1 = 'tester1@gmail.com';
	$badge1 = $title1.' '.$fname1.' '.$lname1;
	$job_title1 = 'tester11';
	$cellno1 = '91-'.'12333546334';
	$org = '';
	$city = '';
	$state = '';
	$country = '';
	$org_reg_type = 'Premium Delegate'; // Standard/Premium Delegate
	$paymode = 'Complimentary';
	$pay_status = 'Complimentary';  //Paid/Complimentary
	$tin_no = '';
	$pin_no = '';
	$sector = 'Electronics';   //Information Technology/Electronics
	$cata1 = 'Premium Delegate';
	$cata = '';*/

// $EVENT_DB_FORM_INTERLINX_REG_TBL = "wcc_2023_interlinx_reg_table";
// $EVENT_DB_TIN_NO = 'TIN-WCC2023-';
// $EVENT_TBL_PREFIX = "wcc";
// $EVENT_YEAR = 2023;
// $EVENT_DB_FORM_ALL_USERS_SCHEDULE = 'wcc_2023_all_users_schedule';

$EVENT_DB_FORM_INTERLINX_REG_TBL = "ieia_2024_interlinx_reg_table";
$EVENT_DB_TIN_NO = 'TIN-IEIA2023-';
$EVENT_TBL_PREFIX = "ieia";
$EVENT_YEAR = 2024;
$EVENT_DB_FORM_ALL_USERS_SCHEDULE = 'ieia_2023_all_users_schedule';

//$delegate_list = array(array('P. Pratham','','tester','p.pratham@bcg.com','91','7795938800','Boston Consulting Group',''));
$delegate_list = array(
array('Vivek','Patil','Director','vivek.patil@mmactiv.com','91','1234567890','MMActiv',''),
array('Tejaswini','Patil','TL','tejaswini.patil@interlinks.in','91','1237852890','Interlinks',''));
	foreach ($delegate_list as $del) {
	
	/*mysqli_query($link, "insert  into " . $EVENT_DB_FORM_REG . "(title1,fname1,lname1,email1,badge1,job_title1,cellno1,org,city,state,country,org_reg_type,paymode,pay_status,sector,cata1,cata) VALUES('$title1','$fname1','$lname1','$email1','$badge1','$job_title1','$cellno1','$org','$city','$state','$country','$org_reg_type','$paymode','$pay_status','$sector','$cata1','$cata')");*/
	$qry = mysqli_query($link, "SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL);
	$row = mysqli_num_rows($qry);

	$tin_no  = $EVENT_DB_TIN_NO;
	$tin_no1 = $res_no = "";
	
	$i = 0;
	$j = 0;
	
	$temp_srno_gt = $row+1;
	do {
	    $i = $j = 0;
	    
	    $tin_no1 = $tin_no . $temp_srno_gt . mt_rand(1, 99999);
	    
	    $qry1    = mysqli_query($link, "SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE tin_no = '$tin_no1'");
	    $res_no1 = mysqli_num_rows($qry1);
	    
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

	$email1 = strtolower($del[3]);

	$qry_email_chk  = mysqli_query($link, "SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE pri_email = '$email1'");
	        $qry_email_chk_num   = mysqli_num_rows($qry_email_chk);
			
	        if ($qry_email_chk_num >= 1) {
	            
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
	                $qry     = mysqli_query($link, "SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE user_id = '$usr_no1'");
	                $res_no  = mysqli_num_rows($qry);
	                if ($res_no < 1) {
	                    $i_gim_inx_user_id_cnt++;
	                } else {
	                    $usr_no1 = "";
	                }
	            } while (!($i_gim_inx_user_id_cnt == 1));
	            //-------------------------------------------------End Generating User Id ------------------------------------------------
	            
	            $dele_title      = "Mr.";
	            $dele_fname      = $del[0];
	            $dele_lname      = $del[1];
	            $dele_desig      = $del[2];
	            $dele_email      = strtolower($del[3]);
	            $dele_cntry_code = $del[4];
	            $dele_mob		 = $del[5];
	            $org 			 = $del[6];
	            $country 		 = $del[7];//explode(",", $org);
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
	            
	            $temp_qr_gt_user_data_ans_row_fone_arr = explode("-", $fone);
	            $temp_qr_gt_user_data_ans_row_fax_arr  = explode("-", $fax);
	            $inx_reg_date = date('Y-m-d');
	            $inx_reg_time = date('H:i:s');
	            //------------------------------------------------- Inserting Values in interlinx registration table --------------------------------------
	            mysqli_query($link, "INSERT INTO " . $EVENT_DB_FORM_INTERLINX_REG_TBL . "
	            		(user_id,dup_user_id,title,fname,lname,birth_date,sex,addr1,addr2,city,state,country,pin,web_site,pri_email,sec_email,org_name,org_info,desig,mob_cntry_code,mob_number,hm_ph_cntry_code,hm_ph_area_code,hm_ph_number,fax_cntry_code,fax_area_code,fax_number,reg_cata,intr1,intr2,intr3,intr4,intr5,intr6,intr7,intr8,intr9,intr10,intr11,intr12,intr13,intr14,intr15,intr16,intr17,intr18,intr19,user_name,pass1,pass2,reg_id,vercode,photo,org_profile,inx_reg_date,inx_reg_time,tin_no) values 
	            		('$usr_no1','$user_id_md5','$dele_title','$dele_fname','$dele_lname','','','','','$city','$state','$country','','','$dele_email','','$org','','$dele_desig','$dele_cntry_code','$dele_mob','$temp_qr_gt_user_data_ans_row_fone_arr[0]','$temp_qr_gt_user_data_ans_row_fone_arr[1]','$temp_qr_gt_user_data_ans_row_fone_arr[2]','$temp_qr_gt_user_data_ans_row_fax_arr[0]','$temp_qr_gt_user_data_ans_row_fax_arr[1]','$temp_qr_gt_user_data_ans_row_fax_arr[2]','','','','','','','','','','','','','','','','','','','','','$dele_email','$pas1_inx','$pas2_inx','','','uploads/default_file.jpg','','$inx_reg_date','$inx_reg_time','$tin_no1')") or die(mysql_error($link));
	            
	            $year = $EVENT_YEAR;
	            $month = '09';
				$date = 26;
				mysqli_query($link, "insert  into `" . $EVENT_DB_FORM_ALL_USERS_SCHEDULE . "` (`req_date`,`req_time`,`sender_id`,`sender_title`,`sender_fname`,`sender_lname`,`sender_org`,`sender_desig`,`sender_org_profile`,`sender_email`,`receiver_id`,`receiver_title`,`receiver_fname`,`receiver_lname`,`receiver_org`,`receiver_desig`,`receiver_org_profile`,`receiver_email`,`req_type`,`meeting_date`,`meeting_time_start`,`meeting_time_end`,`message`,`status`,`read_flag`,`table_no`) values				
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
				mysqli_query($link, "insert  into `" . $EVENT_DB_FORM_ALL_USERS_SCHEDULE . "` (`req_date`,`req_time`,`sender_id`,`sender_title`,`sender_fname`,`sender_lname`,`sender_org`,`sender_desig`,`sender_org_profile`,`sender_email`,`receiver_id`,`receiver_title`,`receiver_fname`,`receiver_lname`,`receiver_org`,`receiver_desig`,`receiver_org_profile`,`receiver_email`,`req_type`,`meeting_date`,`meeting_time_start`,`meeting_time_end`,`message`,`status`,`read_flag`,`table_no`) values
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
				mysqli_query($link, "insert  into `" . $EVENT_DB_FORM_ALL_USERS_SCHEDULE . "` (`req_date`,`req_time`,`sender_id`,`sender_title`,`sender_fname`,`sender_lname`,`sender_org`,`sender_desig`,`sender_org_profile`,`sender_email`,`receiver_id`,`receiver_title`,`receiver_fname`,`receiver_lname`,`receiver_org`,`receiver_desig`,`receiver_org_profile`,`receiver_email`,`req_type`,`meeting_date`,`meeting_time_start`,`meeting_time_end`,`message`,`status`,`read_flag`,`table_no`) values
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
	//exit;



	/*$str_career_intx = "Thank you for Registration on " . $EVENT_NAME . " " . $EVENT_YEAR . " InterlinX";

	$mail = new PHPMailer();
	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing) // 1 = errors and messages // 2 = messages only
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
	$mail->Host       = "interlinksin.mailserverone.com";      // sets  as the SMTP server
	$mail->Port       = 587;                   // set the SMTP port for the server
	$mail->Username   = "noreply-interlinks";  // username
	$mail->Password   = "NrP#5@lt6ks";            // password	
	$mail->SetFrom("noreply@interlinks.in", $EVENT_NAME . ' ' . $EVENT_YEAR . ' InterlinX');
	$mail->Subject    = $str_career_intx ;		
	
	
	$test_delegate_email =  $del[2];
			
	//echo "SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE pri_email = '$test_delegate_email'";
	$qry_email_chk       = mysqli_query($link, "SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE pri_email = '$test_delegate_email'");
	$qr_gt_user_inx_login_data_ans = mysql_fetch_array($qry_email_chk);

	include "reg_inx_emailer.php";
	//echo '#'.$mail_interlinx_str;//exit;
	//include "emailer_bio_interlinx_use.php";
	//print_r($qr_gt_user_inx_login_data_ans);echo '<hr>';
			
	$str_career_intx = "Thank you for Registration on " . $EVENT_NAME . " " . $EVENT_YEAR . " InterlinX";
	$str_career_bdy_intx = $mail_interlinx_str;
	//$recipients = array('', $qr_gt_user_inx_login_data_ans['pri_email'],'', 'test.interlinks@gmail.com', '', 'interlinx@outlook.com');
	$recipients = array('test.interlinks@gmail.com');
			
	$mail->MsgHTML($str_career_bdy_intx);

		//$recipients = array($qr_gt_user_inx_login_data_ans['pri_email']);
	foreach($recipients as $emailid) {
		$mail->AddAddress($emailid);
		if(!$mail->Send()) {
			echo '<br /><br />#####' . $mail->ErrorInfo;
		} else {echo '<br /><br />' . $emailid;}
			$mail->clearAddresses();
		}*/
	
	}
?>