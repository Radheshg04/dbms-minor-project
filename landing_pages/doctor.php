<?php
    session_start();
    $userName = $_SESSION['Username'];
    $server = "localhost";
    $username = "root";
    $pass = "";
    $dbname = "hospital_management";
    
    $conn = new mysqli($server, $username, $pass, $dbname);
    
    if ($conn->connect_error) {
        die("Connection to database failed due to " . $conn->connect_error);
    }
    $sql = "SELECT * FROM users where email='$userName'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $name = $_SESSION['name'] = $row['name'];
    
    $sqlAppointment = "SELECT * FROM appointments where appointed_to='$userName'";
    $resultAppointment = $conn->query($sqlAppointment);
    
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Home</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="doctor.php">Manipal Hospitals</a> </p>
        </div>

        <div class="right-links">
            <a href="doctor_edit.php">Edit Profile</a>
            <a href="../php/logout.php"> <button class="btn">Log Out</button> </a>
        </div>
    </div>
    <main>
       <div class="main-box top">
          <div class="top">
            <div class="box">
                <p>Welcome <b><?php echo "Dr. $name"; ?></b></p>
            </div>
            <div class="box">
                <p>Logged in as <b><?php echo "$userName" ?></b>.</p>
            </div>
          </div>
          <div class="bottom">
            <div class="box">
                <p>You currently have <b><?php echo $resultAppointment->num_rows; ?></b> appointments scheduled.</p>
            </div>
            <br>
            <div class="box">
                <h3>Appointments:</h3>
                <ul style="list-style-type: none;">
                    <?php
                        while ($appointment = $resultAppointment->fetch_assoc()) {
                            echo "<li>Patient ID: " . $appointment['patient_id'] . " - Date: " . $appointment['appointed_date'] . " - Time: " . $appointment['appointed_time'] . "</li>";
                        }

                    ?>
                </ul>
            </div>
          </div>
       </div>
    </main>
</body>
</html>
