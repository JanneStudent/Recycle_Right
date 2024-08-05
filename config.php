<?php
//config.php

$servername = "localhost";
$db_username = "example_user";
$db_password = "password";
$dbname = "recycle";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
