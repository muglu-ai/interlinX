<?php

ini_set('display_errors', 0);
require_once 'db.php';

$link= $dbCon;
// Global error handler for fatal errors
set_exception_handler(function($e) {
    $logMsg = date('Y-m-d H:i:s') . " | Uncaught Exception: " . $e->getMessage() . "\n";
    file_put_contents('error_log.txt', $logMsg, FILE_APPEND);
    http_response_code(500);
    echo json_encode([
        'message' => 'Internal Server Error',
        'error' => $e->getMessage(),
        'status' => 'error',
        'status_code' => 500
    ]);
    exit;
});
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    $logMsg = date('Y-m-d H:i:s') . " | Error [$errno]: $errstr in $errfile on line $errline\n";
    file_put_contents('error_log.txt', $logMsg, FILE_APPEND);
    error_log("Error [$errno]: $errstr in $errfile on line $errline");
    http_response_code(500);
    echo json_encode([
        'message' => 'Internal Server Error',
        'error' => $errstr,
        'status' => 'error',
        'status_code' => 500
    ]);
    exit;
});

require_once 'db.php';
require_once 'jwt_utils.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access, Content-Type, Authorization, X-Requested-With, x-api-key");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'message' => 'Method Not Allowed',
        'status' => 'error',
        'status_code' => 405
    ]);
    exit;
}

try {
    $rawInput = file_get_contents("php://input");
    $data = json_decode($rawInput, true);
    file_put_contents('request.json', json_encode($data, JSON_PRETTY_PRINT));

    // Log request in API log
    $bid = md5(date('YmdHis') . rand());
    dbQuery("INSERT INTO it_2025_reg_api_log(booking_id, email, request, created_at) VALUES('{$bid}', '" . strtolower($data['email']) . "', '" . dbMysqli_real_escape_string(json_encode($data)) . "', '" . date('Y-m-d H:i:s') . "')");

    // Check for duplicate email
    $email1 = strtolower($data['email']);
    $qry_email_chk = dbQuery("SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE pri_email = '$email1'");
    if (dbNumRows($qry_email_chk) >= 1) {
        $res = json_encode([
            'message' => 'Entered email already registered with us.',
            'status' => 'success',
            'status_code' => 200
        ]);
        dbQuery("UPDATE it_2025_reg_api_log SET response='" . dbMysqli_real_escape_string($res) . "' WHERE booking_id = '$bid'");
        echo $res;
        exit;
    }

    // Generate unique tin_no
    $row = dbNumRows(dbQuery("SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL));
    $tin_no = $EVENT_DB_TIN_NO;
    $tin_no1 = '';
    $temp_srno_gt = $row + 1;
    do {
        $tin_no1 = $tin_no . $temp_srno_gt . mt_rand(1, 99999);
        $qry1 = dbQuery("SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE tin_no = '$tin_no1'");
    } while (dbNumRows($qry1) > 0);

    // Generate unique user_id
    $usr_no = $EVENT_TBL_PREFIX . '_' . $EVENT_YEAR . "_nrm_";
    do {
        $temp_no = rand(1, 9999999);
        $usr_no1 = $usr_no . str_pad($temp_no, 7, '0', STR_PAD_LEFT);
        $qry = dbQuery("SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE user_id = '$usr_no1'");
    } while (dbNumRows($qry) > 0);
    $user_id_md5 = md5($usr_no1);

    // Prepare user data
    $dele_title = $data['title'] ?? '';
    $dele_fname = $data['first_name'] ?? $data['fname'];
    $dele_lname = $data['last_name'] ?? $data['lname'];
    $dele_desig = $data['designation'] ?? '';
    $dele_email = $email1;
    $dele_cntry_code = $data['country_code'] ?? '';
    $dele_mob = $data['mobile'] ?? '';
    $org = $data['organisation'] ?? '';
    $add1 = $data['addr1'] ?? '';
    $add2 = $data['addr2'] ?? '';
    $city = $data['city'] ?? '';
    $state = $data['state'] ?? '';
    $country = $data['country'] ?? '';
    $pin = $data['pin'] ?? '';
    $pas1_inx = str_replace(' ', '_', $dele_fname) . "123";
    $pas2_inx = password_hash($pas1_inx, PASSWORD_BCRYPT);
    $reg_cata = $data['reg_cata'] ?? '';
    $inx_reg_date = date('Y-m-d');
    $inx_reg_time = date('H:i:s');
    // Escape all user-supplied values to avoid SQL syntax errors due to quotes/special chars
    $esc = function($v) use ($link) {
        return isset($v) ? mysqli_real_escape_string($link, (string)$v) : '';
    };

    $u_user_id = $esc($usr_no1);
    $u_dup_user_id = $esc($user_id_md5);
    $u_title = $esc($dele_title);
    $u_fname = $esc($dele_fname);
    $u_lname = $esc($dele_lname);
    $u_addr1 = $esc($add1);
    $u_addr2 = $esc($add2);
    $u_city = $esc($city);
    $u_state = $esc($state);
    $u_country = $esc($country);
    $u_pin = $esc($pin);
    $u_pri_email = $esc($dele_email);
    $u_org = $esc($org);
    $u_desig = $esc($dele_desig);
    $u_mob_code = $esc($dele_cntry_code);
    $u_mob = $esc($dele_mob);
    $u_reg_cata = $esc($reg_cata);
    $u_user_name = $esc($dele_email);
    $u_pass1 = $esc($pas1_inx);
    $u_pass2 = $esc($pas2_inx);
    $u_inx_reg_date = $esc($inx_reg_date);
    $u_inx_reg_time = $esc($inx_reg_time);
    $u_tin_no = $esc($tin_no1);

    $insert_sql = "INSERT INTO " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " (user_id,dup_user_id,title,fname,lname,birth_date,sex,addr1,addr2,city,state,country,pin,web_site,pri_email,sec_email,org_name,org_info,desig,mob_cntry_code,mob_number,hm_ph_cntry_code,hm_ph_area_code,hm_ph_number,fax_cntry_code,fax_area_code,fax_number,reg_cata,intr1,intr2,intr3,intr4,intr5,intr6,intr7,intr8,intr9,intr10,intr11,intr12,intr13,intr14,intr15,intr16,intr17,intr18,intr19,user_name,pass1,pass2,reg_id,vercode,photo,org_profile,inx_reg_date,inx_reg_time,tin_no) VALUES ('" . $u_user_id . "','" . $u_dup_user_id . "','" . $u_title . "','" . $u_fname . "','" . $u_lname . "','','','" . $u_addr1 . "','" . $u_addr2 . "','" . $u_city . "','" . $u_state . "','" . $u_country . "','" . $u_pin . "','','" . $u_pri_email . "','','" . $u_org . "','','" . $u_desig . "','" . $u_mob_code . "','" . $u_mob . "','','','','','','','','" . $u_reg_cata . "','','','','','','','','','','','','','','','','','','','" . $u_user_name . "','" . $u_pass1 . "','" . $u_pass2 . "','','','uploads/default_file.jpg','','" . $u_inx_reg_date . "','" . $u_inx_reg_time . "','" . $u_tin_no . "')";

    dbQuery($insert_sql);

    $year = $EVENT_YEAR;
		$month = '11';
		
		// Define schedule data structure
		$schedule_dates = [
			'18' => [
				['12:00:00 pm', '12:30:00 pm'],
				['12:30:00 pm', '13:00:00 pm'],
				['13:00:00 pm', '13:30:00 pm'],
				['13:30:00 pm', '14:00:00 pm'],
				['14:00:00 pm', '14:30:00 pm'],
				['14:30:00 pm', '15:00:00 pm'],
				['15:00:00 pm', '15:30:00 pm'],
				['15:30:00 pm', '16:00:00 pm'],
				['16:00:00 pm', '16:30:00 pm'],
				['16:30:00 pm', '17:00:00 pm'],
				['17:00:00 pm', '17:30:00 pm'],
				['17:30:00 pm', '18:00:00 pm']
			],
			'19' => [
				['10:00:00 am', '10:30:00 am'],
				['10:30:00 am', '11:00:00 am'],
				['11:00:00 am', '11:30:00 am'],
				['11:30:00 am', '12:00:00 pm'],
				['12:00:00 pm', '12:30:00 pm'],
				['12:30:00 pm', '13:00:00 pm'],
				['13:00:00 pm', '13:30:00 pm'],
				['13:30:00 pm', '14:00:00 pm'],
				['14:00:00 pm', '14:30:00 pm'],
				['14:30:00 pm', '15:00:00 pm'],
				['15:00:00 pm', '15:30:00 pm'],
				['15:30:00 pm', '16:00:00 pm'],
				['16:00:00 pm', '16:30:00 pm'],
				['16:30:00 pm', '17:00:00 pm'],
				['17:00:00 pm', '17:30:00 pm'],
				['17:30:00 pm', '18:00:00 pm']
			],
			'20' => [
				['10:00:00 am', '10:30:00 am'],
				['10:30:00 am', '11:00:00 am'],
				['11:00:00 am', '11:30:00 am'],
				['11:30:00 am', '12:00:00 pm'],
				['12:00:00 pm', '12:30:00 pm'],
				['12:30:00 pm', '13:00:00 pm'],
				['13:00:00 pm', '13:30:00 pm'],
				['13:30:00 pm', '14:00:00 pm'],
				['14:00:00 pm', '14:30:00 pm'],
				['14:30:00 pm', '15:00:00 pm'],
				['15:00:00 pm', '15:30:00 pm'],
				['15:30:00 pm', '16:00:00 pm']
			]
		];

        $temp_receiver_org = $org;
        $test_title = $dele_title;
        $test_fname = $dele_fname;
        $test_lname = $dele_lname;
        $test_email = $dele_email;
        
		
		// Prepare bulk insert for schedule
		$all_schedule_values = [];
		foreach ($schedule_dates as $date => $time_slots) {
			foreach ($time_slots as $slot) {
				$all_schedule_values[] = sprintf(
					"(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'%s','%s','%s','%s','%s',NULL,NULL,'%s',NULL,'%s-%s-%s','%s','%s',NULL,'',NULL,NULL)",
					mysqli_real_escape_string($link, $usr_no1),
					mysqli_real_escape_string($link, $test_title),
					mysqli_real_escape_string($link, $test_fname),
					mysqli_real_escape_string($link, $test_lname),
					mysqli_real_escape_string($link, $temp_receiver_org),
					mysqli_real_escape_string($link, $test_email),
					$year, $month, $date,
					$slot[0], $slot[1]
				);
			}
		}
		
		// Execute single batch insert
		if (!empty($all_schedule_values)) {
			$sql = "INSERT INTO `" . $EVENT_DB_FORM_ALL_USERS_SCHEDULE . "` 
				(`req_date`,`req_time`,`sender_id`,`sender_title`,`sender_fname`,`sender_lname`,`sender_org`,`sender_desig`,`sender_org_profile`,`sender_email`,`receiver_id`,`receiver_title`,`receiver_fname`,`receiver_lname`,`receiver_org`,`receiver_desig`,`receiver_org_profile`,`receiver_email`,`req_type`,`meeting_date`,`meeting_time_start`,`meeting_time_end`,`message`,`status`,`read_flag`,`table_no`) 
				VALUES " . implode(',', $all_schedule_values);
			
			if (!mysqli_query($link, $sql)) {
				die("Error inserting schedule data: " . mysqli_error($link));
			}
		}

    // Send confirmation email
    $qry_email_chk = dbQuery("SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE pri_email = '{$dele_email}'");
    if (dbNumRows($qry_email_chk)) {
        $qr_gt_user_inx_login_data_ans = dbFetchAssoc($qry_email_chk);
        include "reg_inx_emailer.php";
        $Subject = "Thank you for Registration for " . $EVENT_NAME . " " . $EVENT_YEAR . " B2B Partnering (InterlinX)";
        $mail_body = $mail_interlinx_str;
        $recipients = [$qr_gt_user_inx_login_data_ans['pri_email'], '', 'test.interlinks@gmail.com', ''];
        elastic_mail($Subject, $mail_body, $recipients);
        $res = json_encode([
            'message' => 'You have successfully registered.',
            'status' => 'success',
            'status_code' => 200
        ]);
        dbQuery("UPDATE it_2025_reg_api_log SET response='" . dbMysqli_real_escape_string($res) . "' WHERE booking_id = '$bid'");
        echo $res;
    } else {
        $res = json_encode([
            'message' => 'Something went wrong, please contact administrator',
            'status' => 'error',
            'status_code' => 500
        ]);
        dbQuery("UPDATE it_2025_reg_api_log SET response='" . dbMysqli_real_escape_string($res) . "' WHERE booking_id = '$bid'");
        echo $res;
    }
} catch (Exception $e) {
    error_log('Exception: ' . $e->getMessage());
    $logMsg = date('Y-m-d H:i:s') . " | Exception: " . $e->getMessage() . "\n";
    file_put_contents('error_log.txt', $logMsg, FILE_APPEND);
    http_response_code(500);
    echo json_encode([
        'message' => 'Internal Server Error',
        'error' => $e->getMessage(),
        'status' => 'error',
        'status_code' => 500
    ]);
}