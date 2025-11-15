<?php
//Error reporting off
error_reporting(0);
// Endpoint URL
$url = 'https://interlinxpartnering.com/ieia-open-seminar-2024/api/register.php';


require_once 'db.php';

//query from ieia_2024_reg_api_log select request from ieia_2024_reg_api_log and break downdo the request and send to api
//$sql = "SELECT * FROM ieia_2024_reg_api_log";
$result = dbQuery($sql);

while ($row = dbFetchAssoc($result)) {
    $request = json_decode($row['request'], true);
    $json_data = json_encode($request);

//    $result['request'] = json_decode($row['request'], true);
//    $data = $row['request'];


// Data to send
    //$json_data = json_encode($data);


// Initialize cURL session
    $ch = curl_init($url);

// Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6IldrQ29DUGVydGc4NTIxQUdERyIsImV4cCI6MTY5MjcyNTE3OX0.vnHj8kkQCqlTRMeN4YsufEiLddKl11Q7j0qQcBCsASY',
        'x-api-key: AIzaSDyD51Q_7VGymsxVBgD3Py4_8ibV3SO0'
    ));

// Execute the request and get the response
    $response = curl_exec($ch);

// Check for errors
    if ($response === false) {
        echo 'Curl error: ' . curl_error($ch);
    } else {
        echo 'Response: ' . $response;
    }

// Close cURL session
    curl_close($ch);
}
?>
