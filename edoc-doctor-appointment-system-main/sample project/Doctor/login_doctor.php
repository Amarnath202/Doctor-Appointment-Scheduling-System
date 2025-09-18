<?php
session_start();
include 'db_connect.php';

// Check if the doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    header("Location: ../login.php"); // Redirect if not logged in
    exit();
}

// Fetch doctor's details from the database
$doctor_id = $_SESSION['doctor_id'];
$query = "SELECT * FROM doctors WHERE doctor_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function showSection(sectionId) {
            document.querySelectorAll('.content-section').forEach(section => {
                section.style.display = 'none';
            });
            document.getElementById(sectionId).style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="sidebar">
        <h2>Welcome, Dr. <?php echo htmlspecialchars($doctor['name']); ?></h2>
        <ul>
            <li><a href="#" onclick="showSection('dashboard')">Dashboard</a></li>
            <li><a href="#" onclick="showSection('appointments')">My Appointments</a></li>
            <li><a href="#" onclick="showSection('patients')">Patients List</a></li>
            <li><a href="#" onclick="showSection('profile')">Edit Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <!-- Dashboard Section -->
        <div id="dashboard" class="content-section">
            <h1>Dashboard</h1>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($doctor['name']); ?></p>
            <p><strong>Specialization:</strong> <?php echo htmlspecialchars($doctor['specialization']); ?></p>
            <p><strong>Experience:</strong> <?php echo htmlspecialchars($doctor['work_experience']); ?> years</p>
            <p><strong>Contact:</strong> <?php echo htmlspecialchars($doctor['contact']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($doctor['email']); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($doctor['location']); ?></p>
            <iframe src="https://calendar.google.com/calendar/embed?src=your_calendar_id" 
                style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
        </div>

        <!-- Appointments Section -->
        <div id="appointments" class="content-section" style="display: none;">
            <h1>My Appointments</h1>
            <table border="1" cellpadding="10">
                <tr>
                    <th>Patient Name</th>
                    <th>Appointment Date</th>
                    <th>Status</th>
                </tr>
                <?php
                $query = "SELECT patients.name AS patient_name, appointments.appointment_date, appointments.status 
                          FROM appointments 
                          JOIN patients ON appointments.patient_id = patients.patient_id 
                          WHERE appointments.doctor_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $doctor_id);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['patient_name']}</td>
                            <td>{$row['appointment_date']}</td>
                            <td>{$row['status']}</td>
                          </tr>";
                }
                $stmt->close();
                ?>
            </table>
        </div>

        <!-- Patients Section -->
        <div id="patients" class="content-section" style="display: none;">
            <h1>Patients List</h1>
            <table border="1" cellpadding="10">
                <tr>
                    <th>Patient Name</th>
                    <th>Contact</th>
                    <th>Gender</th>
                </tr>
                <?php
                $query = "SELECT name, contact, gender FROM patients";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['name']}</td>
                            <td>{$row['contact']}</td>
                            <td>{$row['gender']}</td>
                          </tr>";
                }
                ?>
            </table>
        </div>

        <!-- Profile Section -->
        <div id="profile" class="content-section" style="display: none;">
            <h1>Edit Profile</h1>
            <form action="update_profile.php" method="POST">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($doctor['name']); ?>" required>
                <label>Contact:</label>
                <input type="text" name="contact" value="<?php echo htmlspecialchars($doctor['contact']); ?>" required>
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($doctor['email']); ?>" required>
                <label>Location:</label>
                <input type="text" name="location" value="<?php echo htmlspecialchars($doctor['location']); ?>" required>
                <input type="submit" value="Update Profile">
            </form>
        </div>
    </div>
</body>
</html>
