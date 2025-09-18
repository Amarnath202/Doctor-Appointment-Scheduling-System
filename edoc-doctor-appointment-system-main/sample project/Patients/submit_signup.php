<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Update if necessary
$password = "";    // Add your DB password if set
$dbname = "edoc";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $pid = $conn->real_escape_string($_POST['pid']);
    $pemail = $conn->real_escape_string($_POST['pemail']);
    $pname = $conn->real_escape_string($_POST['pname']);
    $ppassword = password_hash($_POST['ppassword'], PASSWORD_BCRYPT); // Password hashing
    $paddress = $conn->real_escape_string($_POST['paddress']);
    $pdob = $conn->real_escape_string($_POST['pdob']);
    $ptel = $conn->real_escape_string($_POST['ptel']);

    // Insert data into database
    $sql = "INSERT INTO patient (pid, pemail, pname, ppassword, paddress, pdob, ptel) 
            VALUES ('$pid', '$pemail', '$pname', '$ppassword', '$paddress', '$pdob', '$ptel')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration successful!'); window.location.href='login_doctor.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
