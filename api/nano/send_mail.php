<?php



require_once 'db.php';



//select all users from the table it_2025_interlinx_reg_table

$sql = "SELECT * FROM it_2025_interlinx_reg_table";

$result = dbQuery($sql);



//fetch the result

while ($qr_gt_user_inx_login_data_ans = dbFetchAssoc($result)) {

//    $qr_gt_user_inx_login_data_ans[] = $row;

    include "reg_inx_emailer.php";







    $Subject     = "Thank you for Registration for " . $EVENT_NAME . " " . $EVENT_YEAR . " B2B Partnering (InterlinX)";

    $mail_body = $mail_interlinx_str;

    $recipients = array($qr_gt_user_inx_login_data_ans['pri_email'], '', 'test.interlinks@gmail.com',); //, '', $EVENT_ENQUIRY_EMAIL, '', 'interlinx@outlook.com', '', '');

   // $recipients = array('manish.interlink@gmail.com','vivek.patil@mmactiv.com' );

    elastic_mail($Subject, $mail_body, $recipients);

     //echo $mail_body;









}



