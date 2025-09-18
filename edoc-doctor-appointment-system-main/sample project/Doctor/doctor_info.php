<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change if different
$password = "";     // Change if different
$dbname = "hospital_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the doctor ID from URL parameters
$doctor_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($doctor_id === 0) {
    echo "<p>Invalid doctor ID.</p>";
    exit;
}

// Fetch doctor details based on ID
$sql = "SELECT * FROM doctor WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $doctor = $result->fetch_assoc();
} else {
    echo "<p>Doctor not found.</p>";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url("../images/img15.jpg") no-repeat center center fixed;
            background-size: cover;
            padding: 50px 20px;
            margin: 0;
            color: #333;
            transition: background-color 0.3s ease;
        }

        .doctor-details {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            margin: auto;
            width: 380px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: left; /* Aligning text left */
            font-size: 16px;
            display: grid;
            gap: 20px; /* Adds spacing between each row */
            transition: transform 0.3s ease-in-out;
        }

        .doctor-details:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }

        .doctor-details h2 {
            color: #1A73E8;
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
            transition: color 0.3s ease;
        }

        .doctor-details img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 20px;
            object-fit: cover;
            border: 3px solid #1A73E8;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .doctor-details .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
        }

        .doctor-details .info-row strong {
            color: #333;
            width: 40%; /* Ensures labels are aligned consistently */
        }

        .doctor-details .info-row span {
            color: #555;
            width: 55%; /* Ensures the values are aligned properly */
            word-wrap: break-word;
        }

        .doctor-details .highlight {
            color: #1A73E8;
        }

        .doctor-details .button {
            display: inline-block;
            background-color: #1A73E8;
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            transition: background-color 0.3s ease, transform 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }

        .doctor-details .button:hover {
            background-color: #0C5BB5;
            transform: translateY(-5px);
        }

        .doctor-details .button:active {
            background-color: #0a477f;
            transform: translateY(1px);
        }

        .doctor-details h2:hover {
            color: #0C5BB5;
        }

        /* Adding a pulse animation for the button */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        .doctor-details .button {
            animation: pulse 2s infinite;
        }

    </style>
</head>
<body>
    <div class="doctor-details">
        <!-- Profile Picture -->
        <img src="../images/doc-mm.jpg" alt="Doctor Profile Photo">
        
        <h2>Doctor Details</h2>
        
        <div class="info-row">
            <strong>Name:</strong> <span class="highlight"><?php echo htmlspecialchars($doctor['name']); ?></span>
        </div>
        <div class="info-row">
            <strong>Doctor ID:</strong> <span><?php echo htmlspecialchars($doctor['doctor_id']); ?></span>
        </div>
        <div class="info-row">
            <strong>Hospital:</strong> <span><?php echo htmlspecialchars($doctor['Hospital']); ?></span>
        </div>
        <div class="info-row">
            <strong>Specialization:</strong> <span><?php echo htmlspecialchars($doctor['specialization']); ?></span>
        </div>
        <div class="info-row">
            <strong>Work Experience:</strong> <span><?php echo htmlspecialchars($doctor['work_experience']); ?></span>
        </div>
        <div class="info-row">
            <strong>Email:</strong> <span><?php echo htmlspecialchars($doctor['email']); ?></span>
        </div>
        <div class="info-row">
            <strong>Location:</strong> <span><?php echo htmlspecialchars($doctor['location']); ?></span>
        </div>

        <button href="#" class="button">Schedule an Appointment</button>
    </div>
</body>
</html>

