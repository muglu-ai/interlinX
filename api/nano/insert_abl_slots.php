<?php

require 'db.php';

$conn = $dbCon;



// Check connection

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}

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

    ['10:30:00 am', '11:00:00 pm'],

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

    ['10:30:00 am', '11:00:00 pm'],

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

  


];





// Prepare and bind

$stmt = $conn->prepare("INSERT INTO it_2025_avb_time_table_slots 

                        (meeting_date, meeting_time_start, meeting_time_end, total_table, allocated_table, rem_table, status, read_flag, table_no) 

                        VALUES (?, ?, ?, '10', '0', '10', 'Available', null, null)");



// Function to insert time slots into the table

function insertTimeSlots($timeSlots, $meetingDate, $stmt) {

    foreach ($timeSlots as $slot) {

        $meetingTimeStart = $slot[0];

        $meetingTimeEnd = $slot[1];



        // Bind the parameters

        $stmt->bind_param("sss", $meetingDate, $meetingTimeStart, $meetingTimeEnd);



        // Execute the statement

        if ($stmt->execute()) {

            echo "New record created successfully for $meetingDate slot $meetingTimeStart - $meetingTimeEnd\n";

            echo "<br>";

        } else {

            echo "Error: " . $stmt->error . "\n";

        }

    }

}



// Insert time slots for 18-11-2025

insertTimeSlots($timeSlots_29, '2025-11-18', $stmt);



// Insert time slots for 19-11-2025

insertTimeSlots($timeSlots_30, '2025-11-19', $stmt);

// Insert time slots for 20-11-2025

insertTimeSlots($timeSlots_31, '2025-11-20', $stmt);





// Close the statement and connection

$stmt->close();

$conn->close();

?>