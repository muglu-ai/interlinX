<?php 

require_once 'db.php';
require_once 'jwt_utils.php';
$data['email'] = 'ataul.islam@silicoscientia.com';





$qry_email_chk = dbQuery("SELECT * FROM " . $EVENT_DB_FORM_INTERLINX_REG_TBL . " WHERE pri_email = '" . strtolower($data['email']) . "'");
        $qry_email_chk_num = dbNumRows($qry_email_chk);
        if ($qry_email_chk_num) {
            $qr_gt_user_inx_login_data_ans = dbFetchAssoc($qry_email_chk);
            include "reg_inx_emailer.php";
            $Subject = "Thank you for Registration for " . $EVENT_NAME . " " . $EVENT_YEAR . " B2B Partnering (InterlinX)";
            $mail_body = $mail_interlinx_str;

            echo $mail_body;

            $recipients = array( $qr_gt_user_inx_login_data_ans['pri_email'], '', 'test.interlinks@gmail.com', ''); //, '', $EVENT_ENQUIRY_EMAIL, '', 'interlinx@outlook.com', '', '');
           print_r($recipients);
            elastic_mail($Subject, $mail_body, $recipients);


}