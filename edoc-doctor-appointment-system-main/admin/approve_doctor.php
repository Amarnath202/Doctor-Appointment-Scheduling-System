<?php
session_start();

if(isset($_SESSION["user"]) && $_SESSION['usertype'] == 'a') {
    include("../connection.php");

    if (isset($_POST['approve'])) {
        $doctor_id = $_POST['doctor_id'];

        // Update the doctor's status to 'approved' in the database
        $update_query = "UPDATE doctor SET status = 'approved' WHERE docid = ?";
        $stmt = $database->prepare($update_query);
        $stmt->bind_param("i", $doctor_id);

        if ($stmt->execute()) {
            echo "<script>alert('Doctor Approved Successfully!'); window.location.href='doctors.php';</script>";
        } else {
            echo "<script>alert('Failed to approve doctor. Please try again.'); window.location.href='doctors.php';</script>";
        }

        $stmt->close();
    }
} else {
    header("location: ../login.php");
}
?>