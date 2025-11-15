<?php

require 'db.php';



$conn = $dbCon;



// Check connection

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}



$communities = [

    "BlockChain",

    "AI",

    "ML & Robotics",

    "Intelligent Apps and Analytics",

    "Immersive Experience (AR/VR)",

    "IOT",

    "Electronics AND Telecom",

    "Cyber SECURITY",

    "BioPharma",

    "AgriTechnology",

    "BioEnergy & BioFuels",

    "BioServices",

    "BioInformatics",

    "BioIndustrial",

    "Investment & Finance",

    "Information Technology",

    "Venture Capital",

    "Biotechnology",

    "Startup",

    "Academia AND University",

    "Others"

];





$date = date("Y-m-d");



foreach ($communities as $index => $comm_name) {

    $comm_id = 'comm-' . ($index + 1);

    $comm_short_form = strtoupper(str_replace(' ', '_', substr($comm_name, 0, 3))); // Example short form generation

    $sql = "INSERT INTO it_2025_master_community_tbl (comm_id, comm_name, comm_short_form, date) 

            VALUES ('$comm_id', '$comm_name', '$comm_short_form', '$date')";



    if ($conn->query($sql) === TRUE) {

        echo "New record created successfully for $comm_name\n";

    } else {

        echo "Error: " . $sql . "<br>" . $conn->error . "\n";

    }

}



$conn->close();

?>

