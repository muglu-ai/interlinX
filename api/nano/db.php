<?php

$INTERLINX_LOGO_LINK = "https://www.prawaas.com/interlinx-2024/assets/img/interlinx-logo.png";

$EVENT_LOGO_LINK = "https://bengalurutechsummit.com/web/bts-interlinx/assets/img/logo.png";

$EVENT_WEBSITE_LINK = "https://bengalurutechsummit.com/";

$EVENT_NAME = "Bengaluru Tech Summit";

$EVENT_YEAR = "2025";

$interlink = "https://bengalurutechsummit.com/web/bts-interlinx/";

$EVENT_DB_FORM_INTERLINX_REG_TBL = "it_2025_interlinx_reg_table";

$EVENT_DB_TIN_NO = 'TIN-BTS2025-';

$EVENT_TBL_PREFIX = "it";

$EVENT_YEAR = 2025;

$EVENT_DB_FORM_ALL_USERS_SCHEDULE = 'it_2025_all_users_schedule';



$dbCon = mysqli_connect('localhost', 'btsblnl265_asd1d_bengaluruite', 'Disl#vhfj#Af#DhW65', 'btsblnl265_asd1d_bengaluruite') or die('MySQL connect failed. ' . mysqli_connect_error());
$dbCon2 = mysqli_connect('localhost', 'btsblnl265_asd1d_bengaluruite', 'Disl#vhfj#Af#DhW65', 'btsblnl265_asd1d_portal') or die('MySQL connect failed. ' . mysqli_connect_error());


function dbQuery($sql) {

	global $dbCon;

	

	$result = mysqli_query($dbCon, $sql) or die(mysqli_error($dbCon));

	return $result;

}



function dbFetchAssoc($result) {

	return mysqli_fetch_assoc($result);

}



function dbNumRows($result) {

    return mysqli_num_rows($result);

}



function closeConn() {

	global $dbCon;

	mysqli_close($dbCon);

}

	



function dbMysqli_real_escape_string($result) {

	global $dbCon;

    return mysqli_real_escape_string($dbCon, $result);

}



function elastic_mail($subject, $message, $to) {

	$url = 'https://api.elasticemail.com/v2/email/send';



	try {

		$to = implode(";", $to);

		$post = array('from' => 'enquiry@interlinx.in',

		'fromName' => "Bengaluru Tech Summit 2025",

		'apikey' => 'B28BC46A67EAFBAF60DDFE3257D34E756B550950312375B641A3C111D1811928822355B83637DA21623EBE9535648F65',

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