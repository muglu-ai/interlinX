<?php

ini_set('display_errors', 0);

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
    $dele_fname = $data['first_name'] ?? '';
    $dele_lname = $data['last_name'] ?? '';
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

    // Insert user registration
    dbQuery("INSERT INTO " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " (user_id,dup_user_id,title,fname,lname,birth_date,sex,addr1,addr2,city,state,country,pin,web_site,pri_email,sec_email,org_name,org_info,desig,mob_cntry_code,mob_number,hm_ph_cntry_code,hm_ph_area_code,hm_ph_number,fax_cntry_code,fax_area_code,fax_number,reg_cata,intr1,intr2,intr3,intr4,intr5,intr6,intr7,intr8,intr9,intr10,intr11,intr12,intr13,intr14,intr15,intr16,intr17,intr18,intr19,user_name,pass1,pass2,reg_id,vercode,photo,org_profile,inx_reg_date,inx_reg_time,tin_no) VALUES ('{$usr_no1}','{$user_id_md5}','{$dele_title}','{$dele_fname}','{$dele_lname}','','','{$add1}','{$add2}','{$city}','{$state}','{$country}','{$pin}','','{$dele_email}','','{$org}','','{$dele_desig}','{$dele_cntry_code}','{$dele_mob}','','','','','','','','{$reg_cata}','','','','','','','','','','','','','','','','','','','{$dele_email}','{$pas1_inx}','{$pas2_inx}','','','uploads/default_file.jpg','','{$inx_reg_date}','{$inx_reg_time}','{$tin_no1}')");

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