<?php
// Function to send data via cURL
function sendData($data) {
    // Endpoint URL
    $url = 'https://bengalurutechsummit.com/web/bts-interlinx/api/nano/register.php';
    
    // Convert data array to JSON
    $json_data = json_encode($data);
    
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
        return 'Curl error: ' . curl_error($ch);

    } else {
        echo  'Response 1: ' . $response;
    }
    
    // Close cURL session
    curl_close($ch);
}

// Example data array

/*$data = array(
    array(
        "email" => "raghu@artaprk.in", "first_name" => "Raghu", "last_name" => "Dharmaraju", 
        "designation" => "CEO", "country_code" => "91", "mobile" => "9740594411", 
        "organisation" => "ARTPARK-IISc", "country" => "India", "state" => "", "city" => ""
    )
    /*array(
        "email" => "anurags@artpark.in", "first_name" => "Anurag", "last_name" => "Srivastava", 
        "designation" => "COO", "country_code" => "91", "mobile" => "9845205321", 
        "organisation" => "ARTPARK-IISc", "country" => "India", "state" => "", "city" => ""
    ),
    array(
        "email" => "amrutur@artpark.in", "first_name" => "Bharadwaj", "last_name" => "Amrutur", 
        "designation" => "Executive Director", "country_code" => "91", "mobile" => "9886054723", 
        "organisation" => "ARTPARK-IISc", "country" => "India", "state" => "", "city" => ""
    ),
    array(
        "email" => "akshata@artpark.in", "first_name" => "Akshata", "last_name" => "Badri", 
        "designation" => "Lead - Marketing & Communications", "country_code" => "91", "mobile" => "6366259798", 
        "organisation" => "ARTPARK-IISc", "country" => "India", "state" => "", "city" => ""
    ),
    array(
        "email" => "hemang@flomobility.com", "first_name" => "Hemang", "last_name" => "Purohit", 
        "designation" => "CTO", "country_code" => "91", "mobile" => "8595898520", 
        "organisation" => "Flo Mobility", "country" => "India", "state" => "", "city" => ""
    ),
    array(
        "email" => "abhay@vaydyn.com", "first_name" => "Abhay", "last_name" => "Aradhya", 
        "designation" => "CEO", "country_code" => "91", "mobile" => "9741009845", 
        "organisation" => "Vaydyn Technologies Pvt Ltd", "country" => "India", "state" => "", "city" => ""
    ),
    array(
        "email" => "abhishek.badri@artpark.in", "first_name" => "Abhishek", "last_name" => "B", 
        "designation" => "Marketing Executive", "country_code" => "91", "mobile" => "9972597364", 
        "organisation" => "COMRADO Aerospace", "country" => "India", "state" => "", "city" => ""
    ),
    array(
        "email" => "dhruv@sakarrobotics.com", "first_name" => "Dhruv", "last_name" => "Patil", 
        "designation" => "Co Founder", "country_code" => "91", "mobile" => "9975860009", 
        "organisation" => "Sakar Robotics", "country" => "India", "state" => "", "city" => ""
    ),
    array(
        "email" => "nikhil@nxtqube.com", "first_name" => "Nikhil", "last_name" => "Rajput", 
        "designation" => "CEO", "country_code" => "91", "mobile" => "9503067632", 
        "organisation" => "NxtQube", "country" => "India", "state" => "", "city" => ""
    ),
    array(
        "email" => "Nihar@artpark.in", "first_name" => "Nihar", "last_name" => "Desai", 
        "designation" => "Lead Program Manager", "country_code" => "91", "mobile" => "9924655322", 
        "organisation" => "Language data and AI", "country" => "India", "state" => "", "city" => ""
    ),
    array(
        "email" => "ansar@artpark.in", "first_name" => "Ansar", "last_name" => "Hussain", 
        "designation" => "CEO", "country_code" => "91", "mobile" => "9717730656", 
        "organisation" => "COMRADO Aerospace", "country" => "India", "state" => "", "city" => ""
    ),
    array(
        "email" => "mahadeb@artaprk.in", "first_name" => "Mahadeb", "last_name" => "Mandal", 
        "designation" => "Marketing Executive", "country_code" => "91", "mobile" => "9632727184", 
        "organisation" => "ARTAPRK-IISc", "country" => "India", "state" => "", "city" => ""
    ),
);
*/
$data = array(
    "email" => "mahadeb@artaprk.in", "first_name" => "Mahadeb", "last_name" => "Mandal", 
        "designation" => "Marketing Executive", "country_code" => "91", "mobile" => "9632727184", 
        "organisation" => "ARTAPRK-IISc", "country" => "India", "state" => "", "city" => ""
);

// Call the function and print the result
echo sendData($data);

//loop through the array and send data
// foreach($data as $key => $value){
//     print_r($value);
//     echo sendData($value);
// }

?>
