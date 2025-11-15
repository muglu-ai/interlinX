<?php
		error_reporting(E_ALL);
	ini_set("error_reporting", E_ALL);

	/*$servername='66.199.251.67';     // Your MySql Server Name or IP address here
	$dbusername='bangalorenano';          // Login user id here
	$dbpassword='BanG9537';              // Login password here
	$dbname='bangalorenano';     		 // Your database name here
*/
	$servername='localhost'; // Your MySql Server Name or IP address here
	$dbusername='u623622947_wcc';          // Login user id here
	$dbpassword='{Z8!v@b5&$LqAI^+dP)M*V';              // Login password here
	$dbname='u623622947_wcc';     		 // Your database name here
	
	$link = mysqli_connect($servername, $dbusername, $dbpassword);
	mysqli_select_db($link,$dbname);

	/*//connecttodb($servername,$dbname,$dbusername,$dbpassword);
	function connecttodb($servername,$dbname,$dbuser,$dbpassword)
	{
		global $link;
		$link=mysql_connect("$servername","$dbuser","$dbpassword");
		if(!$link){die("Could not connect to MySQL");}
		mysql_select_db("$dbname",$link) or die ("could not open db - ".mysql_error());
	}*/
?>