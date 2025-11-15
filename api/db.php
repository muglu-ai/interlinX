<?php

$INTERLINX_LOGO_LINK = "https://interlinxpartnering.com/ieia-open-seminar-2024/assets/img/interlinx-logo.png";

$EVENT_LOGO_LINK = "https://www.interlinxpartnering.com/ieia-open-seminar-2024/assets/img/ieia_logo.png";

$EVENT_WEBSITE_LINK = "https://ieia.in/";

$EVENT_NAME = "IEIA Open Seminar";

$EVENT_YEAR = "2024";

$interlink = "https://interlinxpartnering.com/ieia-open-seminar-2024/";

$EVENT_DB_FORM_INTERLINX_REG_TBL = "ieia_2024_interlinx_reg_table";

$EVENT_DB_TIN_NO = 'TIN-IEIA2024-';

$EVENT_TBL_PREFIX = "ieia";

$EVENT_YEAR = 2024;

$EVENT_DB_FORM_ALL_USERS_SCHEDULE = 'ieia_2024_all_users_schedule';



$dbConn = mysqli_connect('localhost', 'u623622947_wcc', '{Z8!v@b5&$LqAI^+dP)M*V', 'u623622947_wcc') or die('MySQL connect failed. ' . mysqli_connect_error());



function dbQuery($sql) {

	global $dbConn;

	$result = mysqli_query($dbConn, $sql) or die(mysqli_error($dbConn));

	return $result;

}



function dbFetchAssoc($result) {

	return mysqli_fetch_assoc($result);

}



function dbNumRows($result) {

    return mysqli_num_rows($result);

}



function closeConn() {

	global $dbConn;

	mysqli_close($dbConn);

}

	



function dbMysqli_real_escape_string($result) {

	global $dbConn;

    return mysqli_real_escape_string($dbConn, $result);

}



function elastic_mail($subject, $message, $to) {

	$url = 'https://api.elasticemail.com/v2/email/send';



	try {

		$to = implode(";", $to);

		$post = array('from' => 'enquiry@interlinx.in',

		'fromName' => "IEIA Open Seminar 2024 B2B Partnering (InterlinX)",

		'apikey' => 'E3789A39124B6397F3C4290637E5D57F269ACABD51053D992C4B9A44CB0BA59555EA032B359CC27ACFDC566E585FE74D',

		'subject' => $subject, //"Thank you for Registration on " . $EVENT_NAME . " " . $EVENT_YEAR . " InterlinX",

		'to' => $to, // 'sagarpatil2112@gmail.com;liomayer04@gmail.com;vivek.patil@mmactiv.com;vivek@interlinks.in;test.interlinks@gmail.com',

		//'to' => 'sagarpatil2112@gmail.com',

		'bodyHtml' => $message);//,//'<h1>Html Body</h1>',

		//'bodyText' => 'Text Body');

		

		$ch = curl_init();

		curl_setopt_array($ch, array(

			CURLOPT_URL => $url,

			CURLOPT_POST => true,

			CURLOPT_POSTFIELDS => $post,

			CURLOPT_RETURNTRANSFER => true,

			CURLOPT_HEADER => false,

			CURLOPT_SSL_VERIFYPEER => false

		));

		

		$result=curl_exec ($ch);

		curl_close ($ch);

		

		return true;



		/*$data = json_decode($result, true);

		if(isset($data['success']) && $data['success']) {

			//print_r($data);

			return true;

		}

		//echo $result;

		return false;*/

	} catch(Exception $ex){

		echo $ex->getMessage();

	}

}

//End of file