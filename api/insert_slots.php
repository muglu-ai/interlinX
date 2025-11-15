<?php
$servername = "62.72.14.157";
$username = "u623622947_wcc";
$password = '{Z8!v@b5&$LqAI^+dP)M*V';
$dbname = "u623622947_wcc";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

require 'db.php';
$conn = $dbConn;

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$timeSlots_20 = [
    ['10:00:00 am', '10:30:00 am'],
    ['10:30:00 am', '11:00:00 pm'],
    ['11:00:00 am', '11:30:00 am'],
    ['12:00:00 pm', '12:30:00 pm'],
    ['12:30:00 pm', '13:00:00 pm'],
    ['13:00:00 pm', '13:30:00 pm'],
    ['13:30:00 pm', '14:00:00 pm'],
    ['14:00:00 pm', '14:30:00 pm'],
    ['14:30:00 pm', '15:00:00 pm'],
    ['15:00:00 pm', '15:30:00 pm'],
    ['15:30:00 pm', '16:00:00 pm'],
    ['16:00:00 pm', '16:30:00 pm'],
    ['16:30:00 pm', '17:00:00 pm']
];

// Time slots array for 19-07-2024
$timeSlots_19 = [
    ['16:00:00 pm', '16:30:00 pm'],
    ['16:30:00 pm', '17:00:00 pm'],
    ['17:00:00 pm', '17:30:00 pm'],
    ['19:30:00 pm', '20:00:00 pm'],
    ['20:00:00 pm', '20:30:00 pm']
];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO ieia_2024_table_all 
                        (req_date, req_time, sender_id, sender_org, sender_title, sender_fname, sender_lname, sender_desig, sender_org_profile, sender_email, receiver_id, receiver_org, receiver_title, receiver_fname, receiver_lname, receiver_desig, receiver_org_profile, receiver_email, req_type, meeting_date, meeting_time_start, meeting_time_end, message, status, read_flag, table_no, messege_id) 
                        VALUES (null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, ?, ?, ?, null, null, null, ?, null)");

// Loop through the time slots and execute the prepared statement for each table
function insertTimeSlots($timeSlots, $meetingDate, $stmt) {
    foreach ($timeSlots as $slot) {
        $meetingTimeStart = $slot[0];
        $meetingTimeEnd = $slot[1];

        for ($tableNo = 11; $tableNo <= 20; $tableNo++) {
            $tableNoValue = "table_$tableNo";

            // Bind the parameters
            $stmt->bind_param("ssss", $meetingDate, $meetingTimeStart, $meetingTimeEnd, $tableNoValue);

            // Execute the statement
            if ($stmt->execute()) {
                echo "New record created successfully for $meetingDate slot $meetingTimeStart - $meetingTimeEnd at $tableNoValue\n";
            } else {
                echo "Error: " . $stmt->error . "\n";
            }
        }
    }
}

// Insert time slots for 20-07-2024
insertTimeSlots($timeSlots_20, '2024-07-20', $stmt);

// Insert time slots for 19-07-2024
insertTimeSlots($timeSlots_19, '2024-07-19', $stmt);

// Close the statement and connection
$stmt->close();
$conn->close();
?>