<?php



// Database connection

require 'db.php';

$conn = $dbCon; // Use the connection from db.php

// ini_set("display_errors", 1);



// $host = 'localhost';        // Change to your database host (e.g., 127.0.0.1)

// $username = 'your_username'; // Replace with your database username

// $password = 'your_password'; // Replace with your database password

// $database = 'your_database'; // Replace with your database name



// // Create connection

// #$conn = mysqli_connect($host, $username, $password, $database);

// $conn = mysqli_connect('95.216.2.164', 'btsblnl265_asd1d_bengaluruite', 'Disl#vhfj#Af#DhW65', 'bbtsblnl265_asd1d_bengaluruite') or die('MySQL connect failed. ' . mysqli_connect_error());

// // Check connection

// if (!$conn) {

//     die("Connection failed: " . mysqli_connect_error());

// }



// Time slots array for 18-11-2025

$timeSlots_29 = [

    ['12:00:00 pm', '12:30:00 pm'],

    ['12:30:00 pm', '13:00:00 pm'],

    ['13:00:00 pm', '13:30:00 pm'],

    ['13:30:00 pm', '14:00:00 pm'],

    ['14:00:00 pm', '14:30:00 pm'],

    ['14:30:00 pm', '15:00:00 pm'],

    ['15:00:00 pm', '15:30:00 pm'],

    ['15:30:00 pm', '16:00:00 pm'],

    ['16:00:00 pm', '16:30:00 pm'],

    ['16:30:00 pm', '17:00:00 pm'],

    ['17:00:00 pm', '17:30:00 pm'],

    ['17:30:00 pm', '18:00:00 pm']

];



// Time slots array for 19-11-2025

$timeSlots_30 = [

    ['10:00:00 am', '10:30:00 am'],

    ['10:30:00 am', '11:00:00 am'], // Fixed incorrect 'pm'

    ['11:00:00 am', '11:30:00 am'],

    ['11:30:00 am', '12:00:00 pm'],

    ['12:00:00 pm', '12:30:00 pm'],

    ['12:30:00 pm', '13:00:00 pm'],

    ['13:00:00 pm', '13:30:00 pm'],

    ['13:30:00 pm', '14:00:00 pm'],

    ['14:00:00 pm', '14:30:00 pm'],

    ['14:30:00 pm', '15:00:00 pm'],

    ['15:00:00 pm', '15:30:00 pm'],

    ['15:30:00 pm', '16:00:00 pm'],

    ['16:00:00 pm', '16:30:00 pm'],

    ['16:30:00 pm', '17:00:00 pm'],

    ['17:00:00 pm', '17:30:00 pm'],

    ['17:30:00 pm', '18:00:00 pm']

];



// Time slots array for 20-11-2025

$timeSlots_31 = [

    ['10:00:00 am', '10:30:00 am'],

    ['10:30:00 am', '11:00:00 am'], // Fixed incorrect 'pm'

    ['11:00:00 am', '11:30:00 am'],

    ['11:30:00 am', '12:00:00 pm'],

    ['12:00:00 pm', '12:30:00 pm'],

    ['12:30:00 pm', '13:00:00 pm'],

    ['13:00:00 pm', '13:30:00 pm'],

    ['13:30:00 pm', '14:00:00 pm'],

    ['14:00:00 pm', '14:30:00 pm'],

    ['14:30:00 pm', '15:00:00 pm'],

    ['15:00:00 pm', '15:30:00 pm'],

    ['15:30:00 pm', '16:00:00 pm']


];



// Function to insert time slots

function insertTimeSlots($timeSlots, $meetingDate, $conn) {

    foreach ($timeSlots as $slot) {

        $meetingTimeStart = $slot[0];

        $meetingTimeEnd = $slot[1];



        for ($tableNo = 1; $tableNo <= 10; $tableNo++) {

            $tableNoValue = "table_$tableNo";



            // SQL query string

            $query = "

                INSERT INTO it_2025_table_all (

                    req_date, req_time, sender_id, sender_org, sender_title, sender_fname, 

                    sender_lname, sender_desig, sender_org_profile, sender_email, 

                    receiver_id, receiver_org, receiver_title, receiver_fname, 

                    receiver_lname, receiver_desig, receiver_org_profile, receiver_email, 

                    req_type, meeting_date, meeting_time_start, meeting_time_end, 

                    message, status, read_flag, table_no, messege_id

                ) VALUES (

                    NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 

                    NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 

                    '$meetingDate', '$meetingTimeStart', '$meetingTimeEnd', 

                    NULL, NULL, NULL, '$tableNoValue', NULL

                )";



            // Execute the query

            if (mysqli_query($conn, $query)) {

                echo "New record created successfully for $meetingDate slot $meetingTimeStart - $meetingTimeEnd at $tableNoValue<br>";

            } else {

                echo "Error: " . mysqli_error($conn) . "<br>";

            }

        }

    }

}



// Insert time slots for each day

insertTimeSlots($timeSlots_29, '2025-11-18', $conn);

insertTimeSlots($timeSlots_30, '2025-11-19', $conn);

insertTimeSlots($timeSlots_31, '2025-11-20', $conn);



?>

