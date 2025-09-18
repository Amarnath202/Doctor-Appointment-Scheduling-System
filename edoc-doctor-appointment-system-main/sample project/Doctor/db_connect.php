<?php
$host = "localhost";
$user = "root"; // Change if using a different username
$password = ""; // Change if your database has a password
$database = "hospital_db";

$conn = new mysqli($host, $user, $password, $database);

// Check for errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
