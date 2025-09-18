<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the doctor_id and password from POST
    $doctor_id = $_POST['doctor_id'];
    $password = $_POST['password']; // Plain text input

    // Query to check if the doctor ID exists
    $sql = "SELECT * FROM doctor WHERE doctor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a record was found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password (Ensure passwords are hashed in the database)
        if ($password== $row['password']){
            // Store session data
            $_SESSION['doctor_id'] = $row['doctor_id'];
            $_SESSION['doctor_name'] = $row['name']; // Fetch the doctor's name

            // Redirect to the dashboard
            header("Location: login_doctor.php");
            exit();
        } else {
            echo "<script>alert('Invalid password. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Doctor ID not found. Please try again.');</script>";
    }

    $stmt->close();
}
?>


