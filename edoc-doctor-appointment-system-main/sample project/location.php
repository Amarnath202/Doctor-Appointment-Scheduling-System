<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Listing by City</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: url(images/img7\(1\).jpg);
            padding: 20px;
        }

        .doctor-list {
            max-width: 600px;
            margin: auto;
            text-align: left;
        }

        .doctor-card {
            background: white;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .doctor-card h3 {
            margin: 0;
            color: #333;
        }

        .doctor-card p {
            margin: 5px 0;
            color: #666;
        }

        .specialization-container {
            margin: 20px 0;
        }

        select {
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <h2>Doctors Available in <span id="selectedCity">Your City</span></h2>

    <div class="specialization-container">
        <label for="specializationSelect">Select Specialization:</label>
        <select id="specializationSelect" onchange="showDoctors()">
            <option value="">-- All Specializations --</option>
        </select>
    </div>

    <div id="doctorList" class="doctor-list"></div>

    <script>
        function getCityFromURL() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get("location");
        }

        function loadSpecializations(doctors) {
            const specializationSelect = document.getElementById("specializationSelect");
            specializationSelect.innerHTML = `<option value="">-- All Specializations --</option>`;

            if (doctors.length > 0) {
                const specializations = [...new Set(doctors.map(doc => doc.specialization))];
                specializations.forEach(specialty => {
                    let option = document.createElement("option");
                    option.value = specialty;
                    option.textContent = specialty;
                    specializationSelect.appendChild(option);
                });
            }
        }

        function showDoctors() {
            const city = getCityFromURL();
            if (!city) {
                document.getElementById("doctorList").innerHTML = "<p>Please select a city.</p>";
                return;
            }

            fetch(`fetch_doctors.php?location=${encodeURIComponent(city)}`)
                .then(response => response.json())
                .then(doctors => {
                    loadSpecializations(doctors);
                    
                    const specialization = document.getElementById("specializationSelect").value;
                    const doctorListDiv = document.getElementById("doctorList");
                    doctorListDiv.innerHTML = "";

                    let filteredDoctors = doctors.filter(doctor => 
                        !specialization || doctor.specialization === specialization
                    );

                    if (filteredDoctors.length > 0) {
                        filteredDoctors.forEach(doctor => {
                            const doctorCard = `
                                <div class="doctor-card">
                                    <h3>${doctor.name}</h3>
                                    <p>${doctor.specialization}</p>
                                    <a href="?action=view&id='${doctor.id}'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">View</font></button></a>
                                </div>
                            `;
                            doctorListDiv.innerHTML += doctorCard;
                        });
                    } else {
                        doctorListDiv.innerHTML = "<p>No doctors available for this specialization.</p>";
                    }
                })
                .catch(error => {
                    console.error("Error fetching doctors:", error);
                    document.getElementById("doctorList").innerHTML = "<p>Error fetching doctor data.</p>";
                });
        }

        window.onload = showDoctors;
        document.getElementById("specializationSelect").addEventListener("change", showDoctors);
    </script>
<?php
if($action=='view'){
    $sqlmain = "SELECT * FROM doctor WHERE docid=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $name=$row["docname"];
    $email=$row["docemail"];
    $spe=$row["specialties"];
    
    $stmt = $database->prepare("select sname from specialties where id=?");
    $stmt->bind_param("s",$spe);
    $stmt->execute();
    $spcil_res = $stmt->get_result();
    $spcil_array= $spcil_res->fetch_assoc();
    $spcil_name=$spcil_array["sname"];
    $nic=$row['docnic'];
    $tele=$row['doctel'];
    echo '
    <div id="popup1" class="overlay">
            <div class="popup">
            <center>
                <h2></h2>
                <a class="close" href="doctors.php">&times;</a>
                <div class="content">
                    eDoc Web App<br>
                    
                </div>
                <div style="display: flex;justify-content: center;">
                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                
                    <tr>
                        <td>
                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                        </td>
                    </tr>
                    
                    <tr>
                        
                        <td class="label-td" colspan="2">
                            <label for="name" class="form-label">Name: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            '.$name.'<br><br>
                        </td>
                        
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="Email" class="form-label">Email: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                        '.$email.'<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="nic" class="form-label">NIC: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                        '.$nic.'<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="Tele" class="form-label">Telephone: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                        '.$tele.'<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="spec" class="form-label">Specialties: </label>
                            
                        </td>
                    </tr>
                    <tr>
                    <td class="label-td" colspan="2">
                    '.$spcil_name.'<br><br>
                    </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <a href="doctors.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                        
                            
                        </td>
        
                    </tr>
                   

                </table>
                </div>
            </center>
            <br><br>
    </div>
    </div>
    ';
}
?>
</body>
</html>
