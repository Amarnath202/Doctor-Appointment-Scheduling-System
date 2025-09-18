<?php
// Include database configuration file
include('../db_connect.php'); // Make sure to replace this with the actual path to your DB config file
session_start();
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the email and password from the form
    $pemail = $_POST['pemail'];
    $ppassword = $_POST['ppassword'];

    // Validate the input fields (Optional)
    if (empty($pemail) || empty($ppassword)) {
        echo "Both email and password are required!";
        exit;
    }

    // Sanitize input values to prevent SQL injection
    $pemail = mysqli_real_escape_string($conn, $pemail);
    $ppassword = mysqli_real_escape_string($conn, $ppassword);

    // Hash the password (for security)
    $ppassword_hash = $ppassword; // You can replace this with more secure hashing like bcrypt if needed
echo $ppassword_hash;
    // Query to check if the email and password match
    $sql = "SELECT * FROM patient WHERE pemail = '$pemail' AND ppassword = '$ppassword_hash'";
    $result = mysqli_query($conn, $sql);

    // Check if a matching patient is found
    if (mysqli_num_rows($result) > 0) {
        // Login successful, you can start a session and redirect the user
        
        $_SESSION['user']=$pemail;
        $_SESSION['usertype']='p';
        // Redirect to a protected page (e.g., patient dashboard)
        header("Location: ../../patient/index.php"); // Replace with your desired page
        exit();
    } else {
        // Login failed
        echo "<script>alert('Invalid email or password');</script>";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
