<?php
$servername = "iqc353.encs.concordia.ca"; // Your database server
$username = "iqc353_4"; // Your MySQL username
$password = "P@55M0RD"; // Your MySQL password
$database = "iqc353_4"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
