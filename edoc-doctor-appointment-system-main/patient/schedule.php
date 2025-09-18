<?php
session_start();

// Check if the user is logged in and is a patient
if (!isset($_SESSION["user"]) || $_SESSION["user"] == "" || $_SESSION['usertype'] != 'p') {
    header("location: ../login.php");
    exit();
} 

$useremail = $_SESSION["user"];

// Import database connection
include("../connection.php");

// Fetch user details
$userrow = $database->query("SELECT * FROM patient WHERE pemail='$useremail'");
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["pid"];
$username = $userfetch["pname"];

// Get current date
date_default_timezone_set('Asia/Kolkata');
$today = date('Y-m-d');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
    <title>Sessions</title>
    <style>
    /* Container for Row Layout */
    .top-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #1a1aff;
        padding: 20px;
        color: white;
        flex-wrap: wrap;
    }

    /* Profile Section */
    .profile-header {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .profile-header img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: lightgray;
    }

    .profile-text {
        display: flex;
        flex-direction: column;
    }

    .profile-title {
        font-size: 18px;
        font-weight: bold;
        color: #edeff5;
    }

    .profile-subtitle {
        font-size: 14px;
        opacity: 0.8;
        color: #edeff5;
    }

    /* Navigation Menu */
    .navbar {
        display: flex;
        gap: 25px;
    }

    .navbar a {
        text-decoration: none;
        color: white;
        font-size: 16px;
        font-weight: bold;
        padding: 10px 15px;
        border-radius: 5px;
        transition: background 0.3s;
    }

    .navbar a:hover, .navbar .menu-active {
        background-color: red;
    }

    /* Logout Button */
    .logout-btn {
        background-color: red;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .logout-btn:hover {
        background-color: darkred;
    }
</style>
</head>
<body>

<?php

$sqlmain= "select schedule.*, doctor.docname, 
    (select count(*) from appointment where appointment.scheduleid = schedule.scheduleid) as appointment_count 
    from schedule 
    inner join doctor on schedule.docid=doctor.docid 
    where schedule.scheduledate>='$today' 
    having appointment_count < schedule.nop 
    order by schedule.scheduledate asc";
$sqlpt1="";
$insertkey="";
$searchtype="All";
        if($_POST){
        if(!empty($_POST["search"])){
            $keyword=$_POST["search"];
            $sqlmain= "select schedule.*, doctor.docname,
                (select count(*) from appointment where appointment.scheduleid = schedule.scheduleid) as appointment_count 
                from schedule 
                inner join doctor on schedule.docid=doctor.docid 
                where schedule.scheduledate>='$today' 
                and (doctor.docname='$keyword' or doctor.docname like '$keyword%' 
                or doctor.docname like '%$keyword' or doctor.docname like '%$keyword%' 
                or schedule.title='$keyword' or schedule.title like '$keyword%' 
                or schedule.title like '%$keyword' or schedule.title like '%$keyword%' 
                or schedule.scheduledate like '$keyword%' or schedule.scheduledate like '%$keyword' 
                or schedule.scheduledate like '%$keyword%' or schedule.scheduledate='$keyword')
                having appointment_count < schedule.nop  
                order by schedule.scheduledate asc";
            $insertkey=$keyword;
            $searchtype="Search Result : ";
        }
    }
    $result= $database->query($sqlmain) ?>
<div class="top-bar">
    <!-- Profile Section -->
    <div class="profile-header">
        <img src="../img/user.png" alt="">
        <div class="profile-text">
            <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
            <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="doctors.php" class="menu-active">All Doctors</a>
        <a href="schedule.php">Scheduled Sessions</a>
        <a href="appointment.php">My Bookings</a>
    </nav>

    <!-- Logout Button -->
    <a href="../logout.php">
        <button class="logout-btn">Log out</button>
    </a>
</div>
    <div class="dash-body">
        <table border="0" width="100%" style="border-spacing: 0; margin: 0; padding: 0; margin-top: 25px;">
            <tr>
                <td width="13%">
                    <a href="schedule.php">
                        <button class="login-btn btn-primary-soft btn btn-icon-back" style="padding: 10px; margin-left: 20px; width: 125px;">Back</button>
                    </a>
                </td>
                <td>
                    <form action="" method="post" class="header-search">
                        <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Doctor name, Email, or Date (YYYY-MM-DD)" list="doctors" value="<?php echo $insertkey; ?>">&nbsp;&nbsp;

                        <datalist id="doctors">
                            <?php
                            $list11 = $database->query("SELECT DISTINCT docname FROM doctor");
                            $list12 = $database->query("SELECT DISTINCT title FROM schedule");

                            while ($row = $list11->fetch_assoc()) {
                                echo "<option value='{$row["docname"]}'>";
                            }
                            while ($row = $list12->fetch_assoc()) {
                                echo "<option value='{$row["title"]}'>";
                            }
                            ?>
                        </datalist>

                        <input type="submit" value="Search" class="login-btn btn-primary btn" style="padding: 10px;">
                    </form>
                </td>
                <td width="15%">
                    <p style="font-size: 14px; color: rgb(119, 119, 119); text-align: right;">Date to refer</p>
                    <p class="heading-sub12"><?php echo $today; ?></p>
                </td>
            </tr>

            <tr>
                <td colspan="4" style="padding-top:10px;width: 100%;">
                    <p class="heading-main12" style="margin-left: 45px; font-size:18px;"><?php echo $searchtype . " Sessions (" . $result->num_rows . ")"; ?></p>
                </td>
            </tr>

            <tr>
                <td colspan="4">
                    <center>
                        <div class="abc scroll">
                            <table width="100%" class="sub-table scrolldown" border="0" style="padding: 50px;">
                                <tbody>
                                    <?php
                                    if ($result->num_rows == 0) {
                                        echo '<tr><td colspan="4" align="center"><img src="../img/notfound.svg" width="25%">
                                        <p class="heading-main12">We couldn’t find anything related to your keywords!</p>
                                        <a href="schedule.php"><button class="login-btn btn-primary-soft btn">Show all Sessions</button></a></td></tr>';
                                    } else {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td style='width: 25%;'>
                                                        <div class='dashboard-items search-items'>
                                                            <div>
                                                                <p class='h1-search'>{$row['title']}</p>
                                                                <p class='h3-search'>{$row['docname']}</p>
                                                                <p class='h4-search'>{$row['scheduledate']} - Starts @{$row['scheduletime']}</p>
                                                                <a href='booking.php?id={$row['scheduleid']}'><button class='login-btn btn-primary-soft btn'>Book Now</button></a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </center>
                </td>
            </tr>
        </table>
    </div>
</div>

</body>
</html>

