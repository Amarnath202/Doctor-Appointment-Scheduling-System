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

// Get the city from URL parameters
$city = isset($_GET['location']) ? $_GET['location'] : '';

if (!$city) {
    echo "<p>Please select a city.</p>";
    exit;
}

// Fetch doctors based on the city
$sql = "SELECT * FROM doctor WHERE location = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $city);
$stmt->execute();
$result = $stmt->get_result();

$doctors = [];
while ($row = $result->fetch_assoc()) {
    $doctors[] = $row;
}

// Get unique specializations
$specializations = array_unique(array_column($doctors, 'specialization'));

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors in <?php echo htmlspecialchars($city); ?></title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            text-align: center;
            background: url("../images/img14.jpg");
            background-size: cover;
            padding: 20px;
        }

        h2 {
            position: center ;
            display: inline-block;
            padding: 10px 20px;
            border-radius: 10px;
            width:auto;
        }

        .specialization-container {
            padding: 10px 20px;
            border-radius: 10px;
            width: 300px;
            margin: auto;
        }

        select {
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
            background: #fff;
            color: #333;
            border: none;
            cursor: pointer;
        }

        .doctor-list {
            max-width: 700px;
            margin: 20px auto;
            text-align: left;
        }

        .doctor-card {
            background: rgba(233, 236, 237, 0.9);
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            transition: transform 0.3s;
        }

        .doctor-card:hover {
            transform: translateY(-5px);
        }

        .doctor-card h3 {
            margin: 0;
            color: #2c3e50;
        }

        .doctor-card p {
            margin: 8px 0;
            color: #555;
        }

        button {
            padding: 10px 15px;
            background: #007BFF;
            color: #fff;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <h2>Doctors Available in <?php echo htmlspecialchars($city); ?></h2>

    <!-- Specialization Dropdown -->
    <div class="specialization-container">
        <label for="specializationSelect">Select Specialization:</label>
        <select id="specializationSelect" onchange="filterDoctors()">
            <option value="">-- All Specializations --</option>
            <?php foreach ($specializations as $specialization): ?>
                <option value="<?php echo htmlspecialchars($specialization); ?>"><?php echo htmlspecialchars($specialization); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Doctor List -->
    <div id="doctorList" class="doctor-list">
        <?php if (count($doctors) > 0): ?>
            <?php foreach ($doctors as $doctor): ?>
                <div class="doctor-card" data-specialization="<?php echo htmlspecialchars($doctor['specialization']); ?>">
                    <h3><?php echo htmlspecialchars($doctor['name']); ?></h3>
                    <p><strong>Specialization:</strong> <?php echo htmlspecialchars($doctor['specialization']); ?></p>
                    <p><strong>Hospital:</strong> <?php echo htmlspecialchars($doctor['Hospital']); ?></p>
                    <button onclick="location.href='doctor_info.php?id=<?php echo $doctor['id']; ?>'">More</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No doctors available in this city.</p>
        <?php endif; ?>
    </div>

    <script>
        function filterDoctors() {
            const specialization = document.getElementById("specializationSelect").value;
            const doctorCards = document.querySelectorAll(".doctor-card");

            doctorCards.forEach(card => {
                if (specialization === "" || card.getAttribute("data-specialization") === specialization) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        }
    </script>

</body>
</html>
