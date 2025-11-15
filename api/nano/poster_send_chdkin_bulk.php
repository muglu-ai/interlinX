<?php 



ini_set('display_errors', 1);

ini_set('max_execution_time', 300);it_2025_
it_2025_
require 'db.php';



$EVENT_DB_FORM_INTERLIit_2025_BL = 'it_2025_interlinx_reg_table';

$EVENT_BADGE_DATA_TBL = 'it_2025_badge_data';



$db_connection = $dbCon;



// Fetch only specific fields: lead_name, lead_email, lead_mob, lead_org from the table

$sql = "SELECT * FROM it_2025_poster_submission_tbl WHERE pay_status IN ('Paid', 'Complimentary', 'Free')";

$stmt = mysqli_prepare($db_connection, $sql);



if ($stmt === false) {

    die('Error preparing query: ' . htmlspecialchars(mysqli_error($db_connection)));

}



mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);



// Check for query execution errors

if ($result === false) {

    die('Error executing query: ' . htmlspecialchars(mysqli_error($db_connection)));

}



// Initialize variables

$total_delegates = 0;

date_default_timezone_set('Asia/Kolkata');



$sub_delegates_data = [];



// Loop through the result and process each row

while ($row = mysqli_fetch_assoc($result)) {

   

    // Fetch only required columns

    $lead_name = htmlspecialchars(mysqli_escape_string($db_connection, $row['lead_name']));

    $lead_email = htmlspecialchars(mysqli_escape_string($db_connection, $row['lead_email']));

    $lead_mob =htmlspecialchars( mysqli_escape_string($db_connection, $row['lead_mob']));

    $lead_mob_country = 91;

	$lead_mob = str_replace('91-', '', $row['lead_mob']);

    $lead_org = htmlspecialchars(mysqli_escape_string($db_connection, $row['lead_org']));

    $tin_no = htmlspecialchars(mysqli_escape_string($db_connection, $row['tin_no']));

    $lead_city =htmlspecialchars( mysqli_escape_string($db_connection, $row['lead_city']));

    $country = htmlspecialchars(mysqli_escape_string($db_connection, $row['lead_country']));

    $reg_cata = "Poster Delegate";

    $cata_code = 1880;

    $dele_desig = "NA";

    $print = $reg_cata;

    $pay_status = htmlspecialchars(mysqli_escape_string($db_connection, $row['pay_status']));



    echo "Processing $lead_email...<br>";





    // Store or process the data as needed

    

    $qry_email_chk = "SELECT COUNT(*) FROM $EVENT_BADGE_DATA_TBL WHERE email = ? AND category_id = ?";  

    $email_stmt = mysqli_prepare($db_connection, $qry_email_chk);

    

    if ($email_stmt === false) {

        die('MySQL prepare statement error: ' . mysqli_error($db_connection));

    }

    

    mysqli_stmt_bind_param($email_stmt, 'si', $lead_email, $cata_code);

    

    if (!mysqli_stmt_execute($email_stmt)) {

        die('MySQL execute statement error: ' . mysqli_stmt_error($email_stmt));

    }

    

    mysqli_stmt_bind_result($email_stmt, $qry_email_chk_num);

    

    if (!mysqli_stmt_fetch($email_stmt)) {

        die('MySQL fetch statement error: ' . mysqli_stmt_error($email_stmt));

    }

    

    mysqli_stmt_close($email_stmt); // Close the statement to free up resources

    



    if ($qry_email_chk_num > 0) {

        // Log the event that the email already exists but don't exit the loop

        $res = json_encode([

            'message' => "Email $lead_email already registered. Skipping to next delegate.",

            'status' => 'skipped',

            'status_code' => 200

        ]);

        //updateApiLog($db_connection, $res, $bid);

        echo $res . "<br>" . "\n";

        continue; // Skip to the next delegate if the email already exists

    } else {

        $sql = "INSERT INTO $EVENT_BADGE_DATA_TBL  (name, email, cata, category_id, country_code, mobile, company, designation,qsn_366,  country, tin_no, city, pay_status) 

        VALUES ('$lead_name', '$lead_email', '$reg_cata', '$cata_code', '$lead_mob_country', '$lead_mob', '$lead_org', '$dele_desig','$print', '$country', '$tin_no', '$lead_city', '$pay_status')";



        $result = mysqli_query($db_connection, $sql);

        if ($result === true) {

            echo "Inserted successfully for $lead_email \n";

        } else {

            echo "Error inserting data for $lead_email: " . mysqli_error($db_connection) . "\n";

            exit;

        }

    }



}



// Free the result set

mysqli_free_result($result);



// Close the statement

mysqli_stmt_close($stmt);



// Optional: Print the total number of delegates

$total_delegates = count($sub_delegates_data);

echo "Total Delegates: $total_delegates<br>";



// Close the database connection

mysqli_close($db_connection);

