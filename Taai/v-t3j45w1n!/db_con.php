<?php



$dbConn = mysqli_connect('95.216.2.164', 'btsblnl265_asd1d_bengaluruite', 'Disl#vhfj#Af#DhW65', 'btsblnl265_asd1d_bengaluruite') or die('MySQL connect failed. ' . mysqli_connect_error());



function dbQuery($sql) {

    global $dbConn;

    $result = mysqli_query($dbConn, $sql) or die(mysqli_error($dbConn));

    return $result;

}







?>